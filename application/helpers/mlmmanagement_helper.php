<?php

     
        
        
        
		
        //CHECK CV PENDING DOLO
        function checkCV($uid, $pid){
            $core = new Core;
            $m = $this->getMemberByUid($uid, $pid);
            $mincv = $this->getMinCV($m["grade"]);                        
            /*
            2. PREMIUM / BRONZE
                - tidak mempunyai kewajiban untuk memenuhi point cv                
            */
            if($m["grade"]==1 || $m["grade"]==2){
                $result = 0;//tidak mempunyai kewajiban untuk memenuhi cv point
            }
            /*
            3. SILVER
                - harus menjadi point dengan belanja untuk mendapatkan matching bonus
                - minimal 50 point
            */
            /*
            4. GOLD                
                - minimal 100 point
            */
            /*
            4. PLATINUM                
                - minimal 200 point
            */
            //jika tanggal sekarang = tanggal dia jadi member
            //reset CV point
            $date = date("d",$m["crdate"]);
            $now = date("d",time());
            
            if($date==31)
                $date--;
            if($now==31)
                $now--;
            
            if($date==$now){
                $update =  array("cv"=>0);
                $this->updateMember($update, $m["uid"]);
            }       
            //if(($m["grade"]==3 || $m["grade"]==4 || $m["grade"]==5) && $m["permanent_grade"]==2){
            if(($m["grade"]==3 || $m["grade"]==4 || $m["grade"]==5)){
                if($m["cv"] >= $mincv["min_cv"]){
                    $result = 1;//memenuhi cv point
                }else{
                    $result = 0;
                }
            }
            return $result;
        }     
		   
        
        function genelogy($uid = 1, $pid, $float = "left", $level =1, $cepat=0, $page=""){
            $this->html = "";
            $this->binarytree($uid, $pid, $float, $level,false,$cepat, $page);
            return $this->html;
        }
              
       
        
        function getDirectSponsoredPaginate($urlVar,$limit,&$SmartyPaginate,$id, $pid=0, $uid){
            $SmartyPaginate->connect($id);
			$SmartyPaginate->setLimit($limit,$id);
			$count = $SmartyPaginate->getCurrentIndex($id);			
			$offset = $SmartyPaginate->getLimit($id);                                    
                                    
            $w = "and a.sponsor=$uid";            
            
            $sql = "SELECT a.*, b.country as country_name, c.province as province_name, d.city as city_name, 
                           e.category, e.code, f.city as regional_name  
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_phonecountrycode b, tx_rwmembermlm_province c,
                         tx_rwmembermlm_city d, tx_rwmembermlm_usercategory e, tx_rwmembermlm_city f
                    WHERE a.valid=1 and a.deleted = 0 and a.hidden = 0 and a.pid=$pid and 
                          a.country = b.uid and a.province = c.uid and a.city = d.uid and a.regional=f.uid and
                          a.usercategory = e.uid $w                
                    ";                               
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql . " limit $count, $offset");
                        
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");
            $field["country_name"]["Field"] = "country_name";
            $field["province_name"]["Field"] = "province_name";
            $field["city_name"]["Field"] = "city_name";
            $field["regional_name"]["Field"] = "regional_name";            
            $field["category"]["Field"] = "category";
            $field["code"]["Field"] = "code";
            
            $i=0;            
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="city_name"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="dob"){                        
                        list($y, $m, $d) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["y"] = $y;
                        $_data[$i]["m"] = $m;
                        $_data[$i]["d"] = $d;
                    }
                    if($d["Field"]=="homephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode1"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    if($d["Field"]=="mobilephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode2"] = $a;
                        $result[$d["Field"]] = $b;
                    }                    
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];
                    
                    if($d["Field"]=="uid"){
                        $x = $this->countDirectSponsored($_data[$i]["uid"], $pid);                        
                        $y = $x["left"] + $x["right"];
                        $_data[$i]["sponsors"] = $y;    
                    }
                                        
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
        function getRequestMember($categori, $urlVar,$limit,&$SmartyPaginate,$id, $pid=0, $uid, $regional=0){
            $SmartyPaginate->connect($id);
			$SmartyPaginate->setLimit($limit,$id);
			$count = $SmartyPaginate->getCurrentIndex($id);			
			$offset = $SmartyPaginate->getLimit($id);                                    
            
            $w = "";
            if($categori==3){//DISTRIBUTOR
                $w = "and (a.sponsor='' and a.regional=$regional or a.sponsor=$uid and a.regional=$regional) and a.uid <> $uid";
            }elseif($categori==4){//MEMBER
                $w = "and a.sponsor=$uid";
            }
            
            $sql = "SELECT a.*, b.country as country_name, c.province as province_name, d.city as city_name, 
                           e.category, e.code, f.city as regional_name  
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_phonecountrycode b, tx_rwmembermlm_province c,
                         tx_rwmembermlm_city d, tx_rwmembermlm_usercategory e, tx_rwmembermlm_city f
                    WHERE a.valid=0 and a.deleted = 0 and a.hidden = 0 and a.pid=$pid and 
                          a.country = b.uid and a.province = c.uid and a.city = d.uid and a.regional=f.uid and
                          a.usercategory = e.uid $w                
                    ";                               
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql . " limit $count, $offset");
                        
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");
            $field["country_name"]["Field"] = "country_name";
            $field["province_name"]["Field"] = "province_name";
            $field["city_name"]["Field"] = "city_name";
            $field["regional_name"]["Field"] = "regional_name";            
            $field["category"]["Field"] = "category";
            $field["code"]["Field"] = "code";
            
            $i=0;            
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="city_name"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="dob"){                        
                        list($y, $m, $d) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["y"] = $y;
                        $_data[$i]["m"] = $m;
                        $_data[$i]["d"] = $d;
                    }
                    if($d["Field"]=="homephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode1"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    if($d["Field"]=="mobilephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode2"] = $a;
                        $result[$d["Field"]] = $b;
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
        function getDetailMemberByUserName($username, $pid=0){
            $sql = "SELECT a.*, b.country as country_name, c.province as province_name, d.city as city_name, 
                          e.category, e.code, f.city as regional_name, g.grade grade_name, g.simbol grade_simbol 
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_phonecountrycode b, tx_rwmembermlm_province c,
                         tx_rwmembermlm_city d, tx_rwmembermlm_usercategory e, tx_rwmembermlm_city f, tx_rwmembermlm_grade g
                    WHERE a.deleted = 0 and a.hidden = 0 and a.username='$username' and a.pid=$pid and 
                          a.country = b.uid and a.province = c.uid and a.city = d.uid and a.regional=f.uid and
                          a.grade = g.uid and a.usercategory = e.uid and a.valid=1 
                    LIMIT 1
                    ";            
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);  
                       
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");
            $field["country_name"]["Field"] = "country_name";
            $field["province_name"]["Field"] = "province_name";
            $field["city_name"]["Field"] = "city_name";
            $field["regional_name"]["Field"] = "regional_name";             
            $field["category"]["Field"] = "category";
            $field["code"]["Field"] = "code";
            $field["grade_name"]["Field"] = "grade_name";
            $field["grade_simbol"]["Field"] = "grade_simbol";
                        
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    /*
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    */
                    if($d["Field"]=="city_name"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="regional_name"){                        
                        $result[$d["Field"]] = str_replace("Kota Administrasi","",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="dob"){                        
                        list($y, $m, $d) = explode("-",$result[$d["Field"]]);
                        $_data["y"] = $y;
                        $_data["m"] = $m;
                        $_data["d"] = $d;
                    }
                    if($d["Field"]=="homephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data["countrycode1"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    if($d["Field"]=="mobilephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data["countrycode2"] = $a;
                        $result[$d["Field"]] = $b;
                    }                    
                    $_data[$d["Field"]] = $result[$d["Field"]];                    
                }            
            }                         
            return $_data;
        }
        function getDetailMember($uid, $pid=0){
           $sql = "SELECT a.*, b.country as country_name, c.province as province_name, d.city as city_name, 
                          e.category, e.code, f.city as regional_name  
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_phonecountrycode b, tx_rwmembermlm_province c,
                         tx_rwmembermlm_city d, tx_rwmembermlm_usercategory e, tx_rwmembermlm_city f
                    WHERE a.deleted = 0 and a.hidden = 0 and a.uid=$uid and a.pid=$pid and 
                          a.country = b.uid and a.province = c.uid and a.city = d.uid and a.regional=f.uid and
                          a.usercategory = e.uid
                    LIMIT 1
                    ";           
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);  
                       
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");
            $field["country_name"]["Field"] = "country_name";
            $field["province_name"]["Field"] = "province_name";
            $field["city_name"]["Field"] = "city_name";
            $field["regional_name"]["Field"] = "regional_name";            
            $field["category"]["Field"] = "category";
            $field["code"]["Field"] = "code";
                        
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="city_name"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="dob"){                        
                        list($y, $m, $d) = explode("-",$result[$d["Field"]]);
                        $_data["y"] = $y;
                        $_data["m"] = $m;
                        $_data["d"] = $d;
                    }
                    if($d["Field"]=="homephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data["countrycode1"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    if($d["Field"]=="mobilephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data["countrycode2"] = $a;
                        $result[$d["Field"]] = $b;
                    }                    
                    $_data[$d["Field"]] = $result[$d["Field"]];                    
                }            
            }                         
            return $_data;
        }
        function getMember($category=0, $pid=0){
            ($category ? $where="usercategory=$category and" : $where="");            
            $sql = "SELECT a.*, b.country as country_name, c.province as province_name, d.city as city_name, 
                          e.category, e.code, f.city as regional_name
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_phonecountrycode b, tx_rwmembermlm_province c,
                         tx_rwmembermlm_city d, tx_rwmembermlm_usercategory e, tx_rwmembermlm_city f
                    WHERE $where a.deleted = 0 and a.hidden = 0 and a.pid=$pid and 
                          a.country = b.uid and a.province = c.uid and a.city = d.uid and a.regional=f.uid and
                          a.usercategory = e.uid                   
                    ";                                 
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql);
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");
            $field["country_name"]["Field"] = "country_name";
            $field["province_name"]["Field"] = "province_name";
            $field["city_name"]["Field"] = "city_name";
            $field["regional_name"]["Field"] = "regional_name";            
            $field["category"]["Field"] = "category";
            $field["code"]["Field"] = "code";
            
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){                    
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="city_name" || $d["Field"]=="regional_name"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    /*
                    if($d["Field"]=="dob"){                        
                        list($y, $m, $d) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["y"] = $y;
                        $_data[$i]["m"] = $m;
                        $_data[$i]["d"] = $d;
                    }
                    if($d["Field"]=="homephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode1"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    if($d["Field"]=="mobilephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode2"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    */                   
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                   
                }
                $i++;
            }  
            return $_data;   
        }
        function getMemberPaginate($category=0,$urlVar,$limit,&$SmartyPaginate,$id, $pid=0){
            $SmartyPaginate->connect($id);
			$SmartyPaginate->setLimit($limit,$id);
			$count = $SmartyPaginate->getCurrentIndex($id);			
			$offset = $SmartyPaginate->getLimit($id);
                        
            ($category ? $where="a.usercategory=$category and" : $where="");
            
            $sql = "SELECT a.*, b.country as country_name, c.province as province_name, d.city as city_name, 
                          e.category, e.code, f.city as regional_name
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_phonecountrycode b, tx_rwmembermlm_province c,
                         tx_rwmembermlm_city d, tx_rwmembermlm_usercategory e, tx_rwmembermlm_city f
                    WHERE $where a.deleted = 0 and a.hidden = 0 and a.pid=$pid and 
                          a.country = b.uid and a.province = c.uid and a.city = d.uid and a.regional=f.uid and
                          a.usercategory = e.uid                   
                    ";                                                                   
            $q=$GLOBALS['TYPO3_DB']->sql_query($sql . " limit $count, $offset");
                        
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");
            $field["country_name"]["Field"] = "country_name";
            $field["province_name"]["Field"] = "province_name";
            $field["city_name"]["Field"] = "city_name";
            $field["regional_name"]["Field"] = "regional_name";            
            $field["category"]["Field"] = "category";
            $field["code"]["Field"] = "code";
            
            $i=0;            
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="crdate"){
                        $result[$d["Field"]] = date("Y-m-d H:i:s",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="city_name" || $d["Field"]=="regional_name"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    if($d["Field"]=="dob"){                        
                        list($y, $m, $d) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["y"] = $y;
                        $_data[$i]["m"] = $m;
                        $_data[$i]["d"] = $d;
                    }
                    if($d["Field"]=="homephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode1"] = $a;
                        $result[$d["Field"]] = $b;
                    }
                    if($d["Field"]=="mobilephone"){                        
                        list($a, $b) = explode("-",$result[$d["Field"]]);
                        $_data[$i]["countrycode2"] = $a;
                        $result[$d["Field"]] = $b;
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
        function checkValidUsername($username, $pid=0){
            $sql = "SELECT count(uid) as c_uid 
                    FROM tx_rwmembermlm_member
                    WHERE deleted = 0 and hidden = 0 AND username = '$username' and pid=$pid
                    ";            
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);  
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);            
            if($result["c_uid"] > 0)
                return false;
            else
                return true;
        }
        function checkValidEmail($email, $pid=0){
            $sql = "SELECT count(uid) as c_uid 
                    FROM tx_rwmembermlm_member
                    WHERE deleted = 0 and hidden = 0 AND email = '$email' and pid=$pid
                    ";            
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);  
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);            
            if($result["c_uid"] > 0)
                return false;
            else
                return true;
        }
        function getCountryPhoneCode(){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_phonecountrycode
                    WHERE deleted = 0 and hidden = 0                    
                    ORDER BY country                                        
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);             
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_phonecountrycode");
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            } 
            return $_data;
        }
        function getProvinceByCountry($uid_country){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_province
                    WHERE uid_country = $uid_country and deleted = 0 and hidden = 0                    
                    ORDER BY province                    
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);             
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_province");
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }            
            return $_data;
        }
        function getCityByProvince($uid_city){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_city
                    WHERE uid_province = $uid_city and deleted = 0 and hidden = 0                   
                    ORDER BY city                    
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);             
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_city");
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="city"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }            
            return $_data;
        }
        function getCity(){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_city
                    WHERE deleted = 0 and hidden = 0                                       
                    ORDER BY city                    
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);             
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_city");
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="city"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }            
            return $_data;
        }
        function getRegional($pid){
            $sql = "SELECT distinct(b.uid), b.city                            
                    FROM tx_rwmembermlm_member a, tx_rwmembermlm_city b
                    WHERE a.pid=$pid and a.deleted = 0 and a.hidden = 0 and a.valid=1 and a.usercategory=3 and a.regional=b.uid                          
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_city");             
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="city"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }  
            return $_data;             
        }
        function getMemberByRegional($uidReg, $pid){
            $sql = "SELECT *
                    FROM tx_rwmembermlm_member
                    WHERE pid=$pid and deleted = 0 and hidden = 0 and valid=1 and regional = $uidReg and usercategory = 3
                    ORDER BY firstname
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_member");                        
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    if($d["Field"]=="city"){                        
                        $result[$d["Field"]] = str_replace("Administrasi","",$result[$d["Field"]]);
                    }
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }  
            return $_data;  
        }
        function getPackage(){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_package
                    WHERE deleted = 0 and hidden = 0                                       
                    ORDER BY uid                    
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);             
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_package");
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }            
            return $_data;
        }
        function getBank(){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_bank
                    WHERE deleted = 0 and hidden = 0                                       
                    ORDER BY bank                    
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);             
            $field = $GLOBALS['TYPO3_DB']->admin_get_fields("tx_rwmembermlm_bank");
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                foreach($field as $d){
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];                    
                }
                $i++;
            }            
            return $_data;
        }
        function getPackageByUid($uid){
            $sql = "SELECT * 
                    FROM tx_rwmembermlm_package
                    WHERE deleted = 0 and hidden = 0 and uid=$uid
                    ";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);            
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);
            return $result;
        }
        function getUplineByUid($uid, $pid=0){
            $_data = $this->getDetailMember($uid, $pid);
            return $_data;    
        }
        function insertMember($data){
            $result = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_rwmembermlm_member', $data);
            return $result;            
        }                       
        function updateMember($data,$uid){
             $result = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_rwmembermlm_member','uid='.$uid,$data);
             return $result;
        }                
        function deleteMember($uid){
             $result = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_rwmembermlm_member','uid='.$uid);
             return $result;
        }
        function insertTakeTour($data){
            $result = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_rwmembermlm_taketour', $data);
            return $result;            
        }
        function getProfileMember($username){
            $sql = "SELECT a.*, b.code, c.uid as uid_citynya, c.city as citynya, d.province as provincenya, e.country as negara, f.uid as uidnyaya, f.city as tempat, g.package
                    FROM tx_rwmembermlm_member as a INNER JOIN tx_rwmembermlm_usercategory as b ON a.usercategory = b.uid 
                    INNER JOIN tx_rwmembermlm_city as c ON a.regional = c.uid
                    INNER JOIN tx_rwmembermlm_province as d ON a.province = d.uid
                    INNER JOIN tx_rwmembermlm_phonecountrycode as e ON a.country = e.uid
                    INNER JOIN tx_rwmembermlm_city as f ON a.city = f.uid
                    INNER JOIN tx_rwmembermlm_package as g ON a.package=g.uid
                    WHERE a.username = '".$username."'";
            $q = $GLOBALS['TYPO3_DB']->sql_query($sql);         
            $i=0;
            while($result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q)){
                $hasil[] = $result;
                $hasil[$i]['day'] .= substr($result['dob'], 8); 
                $hasil[$i]['month'] .= substr($result['dob'], 5, -3); 
                $hasil[$i]['year'] .= substr($result['dob'], 0, -6);  // returns "abcde"
                $hasil[$i]['homephonenya'] .= str_replace("+62-","",$result['homephone']); 
                $hasil[$i]['celullar'] .= str_replace("+62-","",$result['mobilephone']); 
                $hasil[$i]['crdatenya'] .= date("Y-m-d h:i:s",$result['crdate']);
                $hasil[$i]['kotanya'] .= str_replace("Administrasi","",$result['tempat']); 
                
                $i++;
            }       
            //foreach($hasil as $d){
            //    $_data = $d['code'];
            //}     
            return $hasil;
            
        }
		
		
?>