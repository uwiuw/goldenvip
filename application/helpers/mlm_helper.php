<?php

if(!function_exists('setGradeMember'))
{
	function setGradeMember($uid, $pid)
	{
		$CI =& get_instance();
		/*
		0. PREMIUM
			syarat : 	a. sudah terdaftar sebagai member mygoldenvip.com
		
		1. BRONZE
			syarat :    a. sudah mempunyai direct sponsor 1 kiri & 1 kanan
						b. sudah pernah sekali cycle bonus                 
		
		2. SILVER
			syarat :    a. sudah mempunyai direct sponsor 2-6, 4-4, 6-2l
						b. silver permanent                 
		
		3. GOLD
			syarat :    a. sudah mempunyai direct sponsor 6-10, 8-8, 10-6
						b. gold permanent                 
		
		4. PLATINUM
			syarat :    a. sudah mempunyai direct sponsor 6-10, 8-8, 10-6
						b. dan ke-16 anak tersebut sudah lengkap memiliki anak kiri 1 dan kanan 1                 
		*/
			  
		$m = getMemberByUid($uid, $pid); # ok sukses   
		/***
		hasildebug
		*/
		       
				
		$direct = countDirectSponsored($m["uid"], $pid);
		if($m["grade"]==1)
		{                
			if($direct["left"] > 0 && $direct["right"] > 0)
			{                    
				$sql = "SELECT count(uid) as c_history  
						FROM tx_rwmembermlm_historycycle
						WHERE deleted = 0 and hidden = 0 and uid_member=$uid and pid=$pid                  
						";                    
				#$q=$GLOBALS['TYPO3_DB']->sql_query($sql);
				#$result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q);
				$result = $CI->Mix->read_rows_by_sql($sql);
				
				if($result["c_history"] > 0)
				{
					$update = array("grade"=>2, "tstamp"=>time());
					updateMember($update, $m["uid"]);
				}   
			}
		}
		elseif($m["grade"]==2)
		{
			if(($direct["left"] >= 2 && $direct["right"] >= 6) || ($direct["left"] >= 4 && $direct["right"] >= 4) || ($direct["left"] >= 6 && $direct["right"] >= 2))
			{
				$update = array("grade"=>3, "permanent_grade"=>2, "tstamp"=>time());
				updateMember($update, $m["uid"]);                                                               
			}
		}
		elseif($m["grade"]==3 && $m["permanent_grade"]==2)
		{
			if(($direct["left"] >= 6 && $direct["right"] >= 10) || ($direct["left"] >= 8 && $direct["right"] >= 8) || ($direct["left"] >= 10 && $direct["right"] >= 6))
			{
				$update = array("grade"=>4, "permanent_grade"=>2, "tstamp"=>time());
				updateMember($update, $m["uid"]);                                                               
			}
		}
		elseif($m["grade"]==4 && $m["permanent_grade"]==2)
		{
			if(($direct["left"] >= 6 && $direct["right"] >= 10) 
				|| ($direct["left"] >= 8 && $direct["right"] >= 8) 
				|| ($direct["left"] >= 10 && $direct["right"] >= 6))
			{
				$rec = getDirectSponsored($m["uid"], $pid);
				$a = true;
				foreach($b as $rec)
				{
					$c = countDirectSponsored($d["uid"], $pid);
					print_r($c);
					if($c["left"] <= 0 && $c["right"] <= 0)
					{
						$a=false;
						break;
					}
				}
				if($a)
				{
					$update = array("grade"=>5,"permanent_grade"=>2, "tstamp"=>time());
					updateMember($update, $m["uid"]); 
				}
			}
		}
		/*
		TEMPORARY GRADE MEMBER             
		*/
		/*
		1. SILVER
			syarat :    a. didapat dengan membeli paket travel
						b. jika dalam satu bulan(30 hari) tidak mencapai downline (2-6, 4,4, 6-2) -> harus turun grade                            
		*/
		/*
		2. GOLD
			syarat :    a. didapat dengan membeli paket VIP
						b. jika dalam satu bulan(60 hari) tidak mencapai downline (2-6, 4,4, 6-2) -> harus turun grade                            
		*/
		if($m["grade"]==3 && $m["permanent_grade"]==1)
		{                
			$date1 = date("d-m-Y",$m["crdate"]);
			$date2 = date("d-m-Y",time());
			$numdays = diffDay($date1, $date2);
			if($numdays > 30)
			{
				if($direct["left"] < 2 && $direct["right"] < 6 || $direct["left"] < 4 && $direct["right"] < 4 || $direct["left"] < 6 && $direct["right"] < 2)
				{
					if($direct["a"] > 0 && $direct["b"] > 0)
					{
						$update = array("grade"=>2);                            
					}
					else
					{
						$update = array("grade"=>1);                        
					}
					updateMember($update, $m["uid"]);                                                               
				}
			}
			if($numdays <= 30)
			{
				if($direct["left"] >= 2 && $direct["right"] >= 6 || $direct["left"] >= 4 && $direct["right"] >= 4 || $direct["left"] >= 6 && $direct["right"] >= 2)
				{
					$update = array("grade"=>3, "permanent_grade"=>2, "tstamp"=>time());
					updateMember($update, $m["uid"]);                                                               
				}    
			}
		}
		elseif($m["grade"]==4 && $m["permanent_grade"]==1)
		{                
			$date1 = date("d-m-Y",$m["crdate"]);
			$date2 = date("d-m-Y",time());
			$numdays = diffDay($date1, $date2);
			if($numdays > 60)
			{
				if($direct["left"] < 6 && $direct["right"] < 10 || $direct["left"] < 8 && $direct["right"] < 8 || $direct["left"] < 10 && $direct["right"] < 6)
				{
					if($direct["a"] > 0 && $direct["b"] > 0)
					{
						$update = array("grade"=>2);                            
					}
					else
					{
						$update = array("grade"=>1);                        
					}
					updateMember($update, $m["uid"]);                                                       
				}
			}
			if($numdays <= 60)
			{
				if($direct["left"] >= 6 && $direct["right"] >= 10 || $direct["left"] >= 8 && $direct["right"] >= 8 || $direct["left"] >= 10 && $direct["right"] >= 6)
				{
					$update = array("grade"=>4, "permanent_grade"=>2, "tstamp"=>time());
					updateMember($update, $m["uid"]);                                                               
				}
			}
		}
		 
	}
}


if(!function_exists('getMemberByUid'))
{
	function getMemberByUid($uid='0', $pid='67'){
		$CI =& get_instance();
		$sql = "select * from tx_rwmembermlm_member where valid = 1 and deleted = 0 and hidden = 0 and uid=$uid and pid=$pid ";
		$data = $CI->Mix->read_rows_by_sql($sql);
		return $data;
	}
}

if(!function_exists('countDirectSponsored'))
{
	function countDirectSponsored($sponsor='0', $pid='0'){
		$CI =& get_instance();
		$sql1 = "SELECT count(uid) as a  
				FROM tx_rwmembermlm_member
				WHERE valid = 1 and deleted = 0 and hidden = 0 and 
				sponsor=$sponsor and pid=$pid and placement = 1                  
				"; 
					
		$result1 = $CI->Mix->read_rows_by_sql($sql1);
		//	$q1=$GLOBALS['TYPO3_DB']->sql_query($sql1);
		//	$result1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q1);
		
		$sql2 = "SELECT count(uid) as b  
				FROM tx_rwmembermlm_member
				WHERE valid = 1 and deleted = 0 and hidden = 0 and 
				sponsor=$sponsor and pid=$pid and placement = 2                  
				";
		
		$result2 = $CI->Mix->read_rows_by_sql($sql2);
		                          
		#$q2=$GLOBALS['TYPO3_DB']->sql_query($sql2);
		#$result2 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($q2);
		
		$result = array("left"=> $result1["a"], "right"=>$result2["b"]);                 
		return $result;
	} 
}

if(!function_exists('updateMember'))
{
	function updateMember($data,$uid='0'){
		 $CI =& get_instance();
		 $CI->Mix->update_record('uid',$uid,$data,'tx_rwmembermlm_member');
	}   
}

if(!function_exists('getDirectSponsored'))
{
	 function getDirectSponsored($sponsor='0', $pid='0', $limit=0){
		 	$CI =& get_instance();
            $w="";
            if($limit)
                $w = "limit 0,$limit";
                
            $sql = "SELECT *  
                    FROM tx_rwmembermlm_member
                    WHERE valid = 1 and deleted = 0 and hidden = 0 and 
                          sponsor=$sponsor and pid=$pid
                    ORDER BY uid ASC $w
                                     
                    ";                         
            $result=$CI->Mix->read_more_rows_by_sql($sql);
			
            $field = admin_get_fields("tx_rwmembermlm_member");
			/*
            $i=0;
			$end_while = count($result);
            while($i < $end_while){
                foreach($field as $d){
                    $_data[$i][$d["Field"]] = $result[$d["Field"]];
                    if($d["Field"]=="uid"){
                        $x = $this->countDirectSponsored($_data[$i]["uid"], $pid);                        
                        $y = $x["left"] + $x["right"];
                        $_data[$i]["sponsors"] = $y;    
                    }
                }
                $i++;
            }    
			*/        
			$i = 0;
			$final = array();
			foreach($result as $row)
			{
					if($row['placement']=='1')
					{ 
						$final['kiri'][$i]['uid'] = $row['uid'];
					}
					if($row['placement']=='2')
					{
						$final['kanan'][$i]['uid'] = $row['uid']; 
					}
				$i++;
			}
            return $final;
        }
}

if(!function_exists('admin_get_fields'))
{
	function admin_get_fields($tb='tx_rwmembermlm_member')
	{
		$CI =& get_instance();
		$result = $CI->Mix->read_rows($tb);
		return $result;
	}
}

if(!function_exists('diffDay'))
{
	function diffDay ($date1, $date2){
		//$date1 & $date2 format YYYY-MM-DD
		return $date_diff = abs(strtotime($date1)-strtotime($date2)) / 86400;  
	}
}

if(!function_exists('getMinCV'))
{
	# check user minimal grade (derajat)
	function getMinCV($uidgrade='0'){
		$CI =& get_instance();
		$sql = "SELECT *  
				FROM tx_rwmembermlm_grade
				WHERE deleted = 0 and hidden = 0 and uid=$uidgrade                  
				";
		$result = $CI->Mix->read_rows_by_sql($sql);
		return $result;
	}
}


if(!function_exists('getCountRequest'))
{
	function getCountRequest($categori, $pid=0, $uid, $regional=0){
			$CI =& get_instance();
            $w = "";
            if($categori==3){//DISTRIBUTOR
                $w = "and (sponsor='' and regional=$regional or sponsor=$uid and regional=$regional) and uid <> $uid";
            }elseif($categori==4){//MEMBER
                $w = "and sponsor=$uid";
            }
            
            $sql = "SELECT count(uid) as a  
                    FROM tx_rwmembermlm_member
                    WHERE valid = 0 and deleted = 0 and hidden = 0 and pid=$pid $w                
                    ";                               
           $result = $CI->Mix->read_rows_by_sql($sql);
           return $result;            
        }
}

if(!function_exists('get_downline'))
{
	function get_downline($uid,$placement,$pid='67')
	{
		$sql="select uid from tx_rwmembermlm_member where upline='".$uid."' and placement='".$placement."' and pid='".$pid."'";
		$CI =& get_instance();
		$result = $CI->Mix->read_rows_by_sql($sql);
		$idownline = "";
		if(!empty($result))
		{
			$idownline = $result['uid'];
		}
		return $idownline;
	}
}

if(!function_exists('get_tips_info'))
{
	function get_tips_info($uid,$pid='67')
	{
		$result = array();
		$CI =& get_instance();
		if($uid != "")
		{
			$sql = "select username, point_left, point_right, sponsor from tx_rwmembermlm_member where uid = '".$uid."'";
			$result  = $CI->Mix->read_rows_by_sql($sql); 
		} 
		if(!empty($result))
		{ 
			if($result['sponsor']!='0')
			{
				$sql = "select username from tx_rwmembermlm_member where uid = '".$result['sponsor']."'";
				$data = $CI->Mix->read_rows_by_sql($sql);
				$result['sponsor'] = $data['username'];
			}
			else
			{
				$result['sponsor'] = "GoldenVIP";
			}
			echo "
			<script type='text/javascript'>
				jQuery(document).ready(function(){jQuery('#tipsy-".$uid."').tipsy();});
			</script>
			<p>
				<a id='tipsy-".$uid."' href='".site_url("member/post_data/get_genealogy/$uid")."' title='
					<table>
						<tr>
							<td>Username</td>
							<td>".$result['username']."</td>
						</tr>
						<tr>
							<td>Sponsor By</td>
							<td>".$result['sponsor']."</td>
						</tr>
						<tr>
							<td>Left Point : ".$result['point_left'].",</td>
							<td>Right Point : ".$result['point_right'].",</td>
						</tr>
					</table>
				' class='gen-btn'>".$result['username']."</a>
			</p>
			<div class='clear-line'></div>
			";
		}
	}
}

if(!function_exists('get_leaf_left'))
{
	function get_leaf_left($uid, $pid='67')
	{
		$sql="select uid from tx_rwmembermlm_member where upline='".$uid."' and placement='1' and pid='".$pid."'";
		$CI =& get_instance();
		$result = $CI->Mix->read_rows_by_sql($sql);
		
		while(!empty($result))
		{
			$uid = $result['uid'];
			$sql="select uid from tx_rwmembermlm_member where upline='".$uid."' and placement='1' and pid='".$pid."'";
			$result = $CI->Mix->read_rows_by_sql($sql);
			
		}
		return $uid;
	}
}

if(!function_exists('get_leaf_right'))
{
	function get_leaf_right($uid, $pid='67')
	{
		$sql="select uid from tx_rwmembermlm_member where upline='".$uid."' and placement='2' and pid='".$pid."'";
		$CI =& get_instance();
		$result = $CI->Mix->read_rows_by_sql($sql);
		
		while(!empty($result))
		{
			$uid = $result['uid'];
			$sql="select uid from tx_rwmembermlm_member where upline='".$uid."' and placement='2' and pid='".$pid."'";
			$result = $CI->Mix->read_rows_by_sql($sql);
			
		}
		return $uid;
	}
}

if(!function_exists('getAccountMLM'))
{
	function getAccountMLM($cat = '3')
	{
		$sql="select m.uid, m.pid, m.firstname, m.lastname, m.email, m.username, m.mobilephone, c.city from tx_rwmembermlm_member m, tx_rwmembermlm_city c where c.uid = m.regional and m.usercategory='".$cat."' and m.pid = '67' limit 0,50";
		$CI =& get_instance();
		$result = $CI->Mix->read_more_rows_by_sql($sql);
		return $result;
	}
}

if(!function_exists('getUsernameMLM'))
{
	function getUsernameMLM($username = '')
	{
		$sql="select username from tx_rwmembermlm_member where username = '".$username."' ";
		$CI =& get_instance();
		$result = $CI->Mix->read_more_rows_by_sql($sql); 
		return $result;
	}
}

if(!function_exists('update_point'))
{
	function update_point($uid_down,$pack)
	{
		$CI =& get_instance();
		#$pack = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','package',$uid_down,'uid');
		do
		{
			$uid = get_upline($uid_down,$pack);
			$b = get_point($uid['upline'],$uid['placement']);
			#$pack = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','package',$uid[],'uid');
			$ins_point = $b+$uid['point'];
			set_point($uid['upline'],$ins_point,$uid['placement']);
			update_cyclebonus($uid['upline']);
			setGradeMember($uid['upline'],'67');
			$uid_down = $uid['upline'];
			$check = get_upline($uid_down,$pack);
		}while($check['upline'] > 0);
	}
}

if(!function_exists('get_upline'))
{
	function get_upline($uid,$pack)
	{
		$CI =& get_instance();
		$up = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','upline',$uid,'uid');
		$place = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','placement',$uid,'uid');
		#$pack = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','package',$uid,'uid');
		$point = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','point',$pack,'uid');
		if(empty($point))
		{
			$point['point']='0';
		}
		$result = array('upline'=>$up['upline'],'placement'=>$place['placement'],'point'=>$point['point']);
		return $result;
	}
}
if(!function_exists('get_point'))
{
	function get_point($uid,$p)
	{
		$CI =& get_instance();
		$w = 'point_right';
		if($p=='1')
		{
			$w = 'point_left';
		}
		$b = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member',$w,$uid,'uid');
		
		return $b[$w];
	}
}
if(!function_exists('set_point'))
{
	function set_point($uid,$point,$p)
	{
		$CI =& get_instance();
		$w = 'point_right';
		if($p=='1')
		{
			$w = 'point_left';
		}
		$data[$w]= $point;
		$b = $CI->Mix->update_record('uid',$uid,$data,'tx_rwmembermlm_member');
	}
}

if(!function_exists('update_cyclebonus'))
{
	function update_cyclebonus($uid)
	{
		$CI =& get_instance();
		$left = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','point_left',$uid,'uid');
		$right = $CI->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','point_right',$uid,'uid');
		$data['pid'] = '67';
		$data['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));
		$data['uid_member'] = $uid;
		$data['paid'] = '0';
		
		if($left['point_left'] >= 400)
		{
			if($right['point_right'] >=200)
			{
				$l = $left['point_left']-400;
				$r = $right['point_right']-200;
				set_point($uid,$l,'1');
				set_point($uid,$r,'2');
				$data['bonus'] = '25';
				$CI->Mix->add_with_array($data,'tx_rwmembermlm_historycycle');
			}
		}
		else
		{
			if($left['point_left'] >= 200)
			{
				if($right['point_right'] >=400)
				{
					#echo $right['point_right'];
					$l = $left['point_left']-200;
					$r = $right['point_right']-400;
					set_point($uid,$l,'1');
					set_point($uid,$r,'2');
					$data['bonus'] = '25';
					$CI->Mix->add_with_array($data,'tx_rwmembermlm_historycycle');
				}
			}
		}
		
		/*
		if(($left['point_left'] >= 200) && ($right['point_right'] >=400))
		{
			$l = $left['point_left']-200;
			$r = $right['point_right']-400;
			set_point($uid,$l,'1');
			set_point($uid,$r,'2');
			$data['bonus'] = '25';
			$CI->Mix->add_with_array($data,'tx_rwmembermlm_historycycle');
		}
		elseif(($left['point_left'] >= 400) && ($right['point_right'] >=200))
		{
			$l = $left['point_left']-400;
			$r = $right['point_right']-200;
			set_point($uid,$l,'1');
			set_point($uid,$r,'2');
			$data['bonus'] = '25';
			$CI->Mix->add_with_array($data,'tx_rwmembermlm_historycycle');
		}
		else
		{
			echo '123234';
			# nothing
		}
		*/
		
	}
}
?>