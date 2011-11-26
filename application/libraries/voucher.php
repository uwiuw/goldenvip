<?php
    class Voucher{        
        private function generateVoucherCode(){
            $len = 18;
            $base='ABCDEFGHJKLMNPQRSTWXYZ2345789';
            $max=strlen($base)-1;
            $activatecode='';
            mt_srand((double)microtime()*1000000);
            while (strlen($activatecode)<$len)
              $activatecode .= $base{mt_rand(0,$max)};
                    
            return $activatecode;
        }
        function getVoucherCode($count){
            $voucher = array();
            for($i=0;$i<$count;$i++){
                $v = $this->generateVoucherCode();
                if($this->checkValidVoucher($v))
                    $voucher[$i] = $v;
                else
                    $i--;
                    
            }
            return $voucher;
        }        
        function checkValidVoucher($voucher, $status="", $distributor=""){
            $w = "";
            if($status ==0 or $status==1){ //$status != "" 
                $w .= " and status=$status";
            }
            if($distributor != ""){
                $w .= " and distributor=$distributor";
            }
            
            $sql = "SELECT count(uid) as c_uid 
                    FROM tx_rwmembermlm_vouchercode
                    WHERE deleted = 0 and hidden = 0 AND voucher_code = '$voucher'
                    $w
                    ";
            //echo $sql;
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);  
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);
            if($result["c_uid"] > 0)
                return false;//belum terpakai / ada
            else
                return true;//sudah terpakai /  tidak ada
        }
        function getAllVoucherDB(){
            $sql = "SELECT a.*, b.firstname, b.lastname, b.username
                    FROM tx_rwmembermlm_vouchercode a, tx_rwmembermlm_member b
                    WHERE b.deleted=0 and b.hidden=0 and a.distributor=b.uid $w
                    ORDER BY uid DESC
                    ";                      
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql);
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_vouchercode");
            $field["firstname"]["Field"] = "firstname";
            $field["lastname"]["Field"] = "lastname";
            $field["username"]["Field"] = "username";
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="status"){
                       if($result[$d["Field"]]==0){
                          $result[$d["Field"]] = "hasn't been used";    
                       }else{
                          $result[$d["Field"]] = "has been used";    
                       }     
                    }
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }  
            return $_data;   
        }
        function getVoucherbyCode($voucher){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_vouchercode
                    WHERE deleted = 0 and hidden = 0 and voucher_code='$voucher'                   
                    ";                    
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);              
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);
            return $result;
        }
        function getCountStatusVoucher($w=""){
            $sql = "SELECT count(status) as c_status 
                    FROM tx_rwmembermlm_vouchercode
                    WHERE deleted = 0 and hidden = 0 $w                    
                    ";            
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);              
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);
            return $result["c_status"];
        }
        function getVoucherDBPaginate($urlVar,$limit,&$SmartyPaginate,$id, $w="", $pid=0){
            $SmartyPaginate->connect($id);
			$SmartyPaginate->setLimit($limit,$id);
			$count = $SmartyPaginate->getCurrentIndex($id);			
			$offset = $SmartyPaginate->getLimit($id);
            
            ($w ? $w="and $w" : $w="");
            
            $sql = "SELECT a.*, b.firstname, b.lastname, b.username
                    FROM tx_rwmembermlm_vouchercode a, tx_rwmembermlm_member b
                    WHERE a.pid=$pid and b.deleted=0 and b.hidden=0 and a.distributor=b.uid $w
                    ORDER BY uid DESC
                    ";                      
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql . " limit $count, $offset");
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_vouchercode");
            $field["firstname"]["Field"] = "firstname";
            $field["lastname"]["Field"] = "lastname";
            $field["username"]["Field"] = "username";
            
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="status"){                        
                       if($result[$d["Field"]]==0){
                          $result[$d["Field"]] = "Available";
                          $c_voucher["status"][0]++;    
                       }else{
                          $result[$d["Field"]] = "Used";
                          $c_voucher["status"][1]++;    
                       }     
                    }
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }      
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql);
            $totalrow = $GLOBALS['TYPO3_DB']->sql_num_rows($q);						
			$SmartyPaginate->setTotal($totalrow,$id);
			$SmartyPaginate->setUrl($urlVar,$id);
			$SmartyPaginate->setPrevText('&lt; Previous',$id);
			$SmartyPaginate->setNextText('Next &gt;',$id);
			$SmartyPaginate->setLastText('Last &gt;&gt;',$id);
			$SmartyPaginate->setFirstText('&lt;&lt; First',$id);                  
            return $_data;
        }
        function insertVoucher($data){
            $result = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_rwmembermlm_vouchercode', $data);
            return $result;            
        }
        function insertDistributeVoucher($data){
            $result = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_rwmembermlm_distributevoucher', $data);
            return $result;            
        }
        function updateVoucher($data,$uid){
             $result = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_rwmembermlm_vouchercode','uid='.$uid,$data);
             return $result;
        }                
        function deleteVoucher($uid){             
             $result = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_rwmembermlm_vouchercode','uid='.$uid);
             return $result;
        }
    }
?>