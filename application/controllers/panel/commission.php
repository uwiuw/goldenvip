<?php
class Commission extends CI_Controller
{
	public function index()
	{
            is_admin();
		$this->comision_payment();
	}
	
	function comision_payed()
	{
            is_admin();
		if($this->input->post('bonus'))
		{
			if($this->input->post('bonus')=='fast')
			{
				$this->fast_bonus_payed();
			}
			elseif($this->input->post('bonus')=='cycle')
			{
				$this->cycle_bonus_payed();
			}
			elseif($this->input->post('bonus')=='all')
			{
				$this->all_bonus_payed();
			}
			elseif($this->input->post('bonus')=='matching')
			{
				$this->matching_bonus_payed();
			}
			elseif($this->input->post('bonus')=='mentor')
			{
				$this->mentor_bonus_payed();
			}
		}
	}
	
	function comision_payment()
	{
            is_admin();
		echo "
		<script type=\"text/javascript\">
		jQuery(function(){
			jQuery(\"#myTable\").tablesorter();
			jQuery('#myTable tbody tr:odd').addClass('odd');
			jQuery('#process').click(function(){
					payed();
				}
			);
		});
		</script>";
		if($this->input->post('pilihan'))
		{
			echo "
			<table id='myTable' class='wp-list-table widefat fixed pages tablesorter' cellspacing='0'>
			<thead>
			<tr>
				<th width='9' class='header'>No</th>
				<th width='118' class='header'>Member</th> 
				<th width='20' class='header'>Bonus ($)</th>
				<th width='103' class='header'>Bank Info</th>
				<th width='20' class='header'>Payment</th>   
			</tr>
			</thead>
			<tbody>
			";
			if($this->input->post('pilihan')=='fast')
			{
				$this->fast_bonus();
				echo "<input type='hidden' name='bonus' value='fast'>";
			}
			elseif($this->input->post('pilihan')=='cycle')
			{
				$this->cycle_bonus();
				echo "<input type='hidden' name='bonus' value='cycle'>";
			}
			elseif($this->input->post('pilihan')=='matching')
			{
				$this->matching_bonus();
				echo "<input type='hidden' name='bonus' value='matching'>";
			}
			elseif($this->input->post('pilihan')=='mentor')
			{
				$this->mentor_bonus();
				echo "<input type='hidden' name='bonus' value='mentor'>";
			}
			elseif($this->input->post('pilihan')=='null')
			{
				echo "	<script type=\"text/javascript\">
							jQuery(function(){
								jQuery('#myTable').css('display','none');
								jQuery('#processbtn').css('display','none');
							});
						</script>";
				echo "<p class=\"error\">Please Select Commission Type</p>";
			}
			else
			{
				$this->all_bonus();
				echo "<input type='hidden' name='bonus' value='all'>";
			}
			echo"
				</tbody>
				</table>
				<table width='100%' id='processbtn'>
				 <tr align='right'><td><input type='button' value='Process' id='process' class='button'></td></tr>
				</table>
				";
		}
		else
		{
			$this->load->view('panel/page/mlm/comision_payment'); 
		}
	}
	
	function all_bonus()
	{
            is_admin();
		$sql = "select commission as bonus, uid,firstname, username, bank_name, bank_account_number  
				from `tx_rwmembermlm_member` 
				WHERE deleted = 0 and hidden = 0 and pid='67' and commission > 0             
				ORDER BY firstname";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		if(empty($data))
		{
			echo "<tr align='center'><td colspan='5'> Data Not Found</td></tr>";
		}
		else
		{
			$i = 1;
			foreach($data as $row)
			{
				echo "
				<tr>
					<td>$i</td>
					<td>".$row['firstname']." ".$row['lastname']." "."(".$row['username'].")</td>
					<td>".$row['bonus']."</td>
					<td>".$row['bank_name']." , ".$row['bank_account_number']."</td>
					
					<td align='center'><input type='checkbox' name='".$row['uid']."'></td>
				</tr>";
				$i++;
			}
		}
	}
	
	function all_bonus_payed()
	{
            is_admin();
		$sql = "select commission as bonus, uid,firstname, username, bank_name, bank_account_number  
				from `tx_rwmembermlm_member` 
				WHERE deleted = 0 and hidden = 0 and pid='67' and commission > 0             
				ORDER BY firstname"; // ambil uid dll dari tabel yang memiliki commision > 0
		$data = $this->Mix->read_more_rows_by_sql($sql);
		
		$boolean = FALSE;
		echo "<ol>";
		foreach($data as $row)
		{
			if($this->input->post($row['uid']))
			{
				echo  "<li><strong>".$row['username']."</strong> (".$row['firstname']." ".$row['lastname'].") has been payed.</li>";
				
				$sql = "UPDATE  tx_rwmembermlm_member SET  commission = 0
						WHERE  uid ='".$row['uid']."' ";
				$this->db->query($sql); // al bonus reset to 0
				
				$sql = "UPDATE  tx_rwmembermlm_historyfastbonus SET  paid = 1
						WHERE  uid_member ='".$row['uid']."' ";
				$this->db->query($sql); // fast bonus reset unpaid to paid
				
				$sql = "UPDATE  tx_rwmembermlm_historycycle SET  paid = 1
						WHERE  uid_member ='".$row['uid']."' ";
				$this->db->query($sql); // cycle bonus reset from unpaid to paid
				
				/* matching dan mentor menyusul */
				$sql = "UPDATE  tx_rwmembermlm_historymatchingbonus SET  paid = 1
						WHERE  uid_member ='".$row['uid']."' ";
				$this->db->query($sql); // cycle bonus reset from unpaid to paid
				
				$sql = "UPDATE  tx_rwmembermlm_historymentorbonus SET  paid = 1
						WHERE  uid_member ='".$row['uid']."' ";
				$this->db->query($sql); // cycle bonus reset from unpaid to paid
				
				$boolean = TRUE;
			}
		}
		echo "</ol>";
		if($boolean)
		{
			echo "<p class=\"error\">transaction has been success.</p>";
		}
		else
		{
			echo "<p class=\"error\">Nothing to do.</p>";
		}
	}
	
	function fast_bonus()
	{
            is_admin();
		$sql = "select a.uid_member, sum(a.bonus) as bonus, a.paid, b.username, b.firstname, b.lastname, 
				b.bank_name, b.bank_account_number
				from tx_rwmembermlm_historyfastbonus a, tx_rwmembermlm_member b 
				where a.bonus > 0 and a.paid = 0
				and a.uid_member = b.uid
				group by a.uid_member
				order by b.firstname";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		if(empty($data))
		{
			echo "<tr align='center'><td colspan='5'> Data Not Found</td></tr>";
		}
		else
		{
			$i = 1;
			foreach($data as $row)
			{
				echo "
				<tr>
					<td>$i</td>
					<td>".$row['firstname']." ".$row['lastname']." "."(".$row['username'].")</td>
					<td>".$row['bonus']."</td>
					<td>".$row['bank_name']." , ".$row['bank_account_number']."</td>
					
					<td align='center'><input type='checkbox' name='".$row['uid_member']."'></td>
				</tr>";
				$i++;
			}
		}
	}
	
	function fast_bonus_payed()
	{
            is_admin();
		$sql = "select a.uid_member, sum(a.bonus) as bonus, a.paid, b.username, b.firstname, b.lastname, 
				b.bank_name, b.bank_account_number
				from tx_rwmembermlm_historyfastbonus a, tx_rwmembermlm_member b 
				where a.bonus > 0 and a.paid = 0
				and a.uid_member = b.uid
				group by a.uid_member
				order by b.firstname";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		$boolean = FALSE;
		echo "<ol>";
		foreach($data as $row)
		{
			if($this->input->post($row['uid_member']))
			{
				echo  "<li><strong>".$row['username']."</strong> (".$row['firstname']." ".$row['lastname'].") has been payed.</li>";
				
				$c = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$row['uid_member'],'uid');// get commission from tabel member
				$sql = "select   sum(bonus) as bonus  
						from tx_rwmembermlm_historyfastbonus 
						where  bonus > 0 and  paid = 0
						and  uid_member = '".$row['uid_member']."'
						group by  uid_member";
				$f = $this->Mix->read_rows_by_sql($sql);
				 
				$t = $c['commission']-$f['bonus'];
				
				$mc['commission'] = $t;
				$this->Mix->update_record('uid',$row['uid_member'],$mc,'tx_rwmembermlm_member');
				
				$fb['paid'] = 1;
				$this->Mix->update_record('uid_member',$row['uid_member'],$fb,'tx_rwmembermlm_historyfastbonus');
				
				$boolean = TRUE;
			}
		}
		echo "</ol>";
		if($boolean)
		{
			echo "<p class=\"error\">transaction has been success.</p>";
		}
		else
		{
			echo "<p class=\"error\">Nothing to do.</p>";
		}
	}
	
	function cycle_bonus()
	{
            is_admin();
		$sql = "SELECT a.uid_member, b.*, sum(a.bonus) as bonus   
				FROM tx_rwmembermlm_historycycle a,tx_rwmembermlm_member b
				WHERE 
					  a.deleted = 0 and a.hidden = 0 and 
				a.pid='67'
					  and a.paid = '0' 
					  and a.uid_member = b.uid
					  GROUP By a.uid_member
				ORDER BY b.firstname ASC";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		if(empty($data))
		{
			echo "<tr align='center'><td colspan='5'> Data Not Found</td></tr>";
		}
		else
		{
			$i = 1;
			foreach($data as $row)
			{
				echo "
				<tr>
					<td>$i</td>
					<td>".$row['firstname']." ".$row['lastname']." "."(".$row['username'].")</td>
					<td>".$row['bonus']."</td>
					<td>".$row['bank_name']." , ".$row['bank_account_number']."</td>
					<td align='center'><input type='checkbox' name='".$row['uid_member']."'></td>
				</tr>";
				$i++;
			}
		}
	}
	function cycle_bonus_payed()
	{
            is_admin();
		$sql = "SELECT a.uid_member, b.*, sum(a.bonus) as bonus   
				FROM tx_rwmembermlm_historycycle a,tx_rwmembermlm_member b
				WHERE 
					  a.deleted = 0 and a.hidden = 0 and 
				a.pid='67'
					  and a.paid = '0' 
					  and a.uid_member = b.uid
					  GROUP By a.uid_member
				ORDER BY b.firstname ASC";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		$boolean = FALSE;
		echo "<ol>";
		foreach($data as $row)
		{
			if($this->input->post($row['uid_member']))
			{
				echo  "<li><strong>".$row['username']."</strong> (".$row['firstname']." ".$row['lastname'].") has been payed.</li>";
				
				$c = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$row['uid_member'],'uid');// get commission from tabel member
				$sql = "select   sum(bonus) as bonus  
						from tx_rwmembermlm_historycycle 
						where  bonus > 0 and  paid = 0
						and  uid_member = '".$row['uid_member']."'
						group by  uid_member";
				$f = $this->Mix->read_rows_by_sql($sql);
				 
				$t = $c['commission']-$f['bonus'];
				
				$mc['commission'] = $t;
				$this->Mix->update_record('uid',$row['uid_member'],$mc,'tx_rwmembermlm_member');
				
				$fc['paid'] = 1;
				$this->Mix->update_record('uid_member',$row['uid_member'],$fc,'tx_rwmembermlm_historycycle');
				#debug_data($f);
				$boolean = TRUE;
			}
		}
		echo "</ol>";
		if($boolean)
		{
			echo "<p class=\"error\">transaction has been success.</p>";
		}
		else
		{
			echo "<p class=\"error\">Nothing to do.</p>";
		}
	}
	
	function matching_bonus()
	{
            is_admin();
		$sql = "SELECT a.uid_member, b.*, sum(a.bonus) as bonus   
				FROM tx_rwmembermlm_historymatchingbonus a,tx_rwmembermlm_member b
				WHERE 
					  a.deleted = 0 and a.hidden = 0 and 
				a.pid='67'
					  and a.paid = '0' 
					  and a.uid_member = b.uid
					  GROUP By a.uid_member
				ORDER BY b.firstname ASC";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		if(empty($data))
		{
			echo "<tr align='center'><td colspan='5'> Data Not Found</td></tr>";
		}
		else
		{
			$i = 1;
			foreach($data as $row)
			{
				echo "
				<tr>
					<td>$i</td>
					<td>".$row['firstname']." ".$row['lastname']." "."(".$row['username'].")</td>
					<td>".$row['bonus']."</td>
					<td>".$row['bank_name']." , ".$row['bank_account_number']."</td>
					<td align='center'><input type='checkbox' name='".$row['uid_member']."'></td>
				</tr>";
				$i++;
			}
		}
	}
	
	function matching_bonus_payed()
	{
            is_admin();
		$sql = "SELECT a.uid_member, b.*, sum(a.bonus) as bonus   
				FROM tx_rwmembermlm_historymatchingbonus a,tx_rwmembermlm_member b
				WHERE 
					  a.deleted = 0 and a.hidden = 0 and 
				a.pid='67'
					  and a.paid = '0' 
					  and a.uid_member = b.uid
					  GROUP By a.uid_member
				ORDER BY b.firstname ASC";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		$boolean = FALSE;
		echo "<ol>";
		foreach($data as $row)
		{
			if($this->input->post($row['uid_member']))
			{
				echo  "<li><strong>".$row['username']."</strong> (".$row['firstname']." ".$row['lastname'].") has been payed.</li>";
				
				$c = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$row['uid_member'],'uid');// get commission from tabel member
				$sql = "select   sum(bonus) as bonus  
						from tx_rwmembermlm_historymatchingbonus 
						where  bonus > 0 and  paid = 0
						and  uid_member = '".$row['uid_member']."'
						group by  uid_member";
				$f = $this->Mix->read_rows_by_sql($sql);
				 
				$t = $c['commission']-$f['bonus'];
				
				$mc['commission'] = $t;
				$this->Mix->update_record('uid',$row['uid_member'],$mc,'tx_rwmembermlm_member');
				
				$fc['paid'] = 1;
				$this->Mix->update_record('uid_member',$row['uid_member'],$fc,'tx_rwmembermlm_historymatchingbonus');
				#debug_data($f);
				$boolean = TRUE;
			}
		}
		echo "</ol>";
		if($boolean)
		{
			echo "<p class=\"error\">transaction has been success.</p>";
		}
		else
		{
			echo "<p class=\"error\">Nothing to do.</p>";
		}
	}
	//matching_bonus_payed
	
	function mentor_bonus()
	{
            is_admin();
		$sql = "SELECT a.uid_member, b.*, sum(a.bonus) as bonus   
				FROM tx_rwmembermlm_historymentorbonus a,tx_rwmembermlm_member b
				WHERE 
					  a.deleted = 0 and a.hidden = 0 and 
				a.pid='67'
					  and a.paid = '0' 
					  and a.uid_member = b.uid
					  GROUP By a.uid_member
				ORDER BY b.firstname ASC";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		if(empty($data))
		{
			echo "<tr align='center'><td colspan='5'> Data Not Found</td></tr>";
		}
		else
		{
			$i = 1;
			foreach($data as $row)
			{
				echo "
				<tr>
					<td>$i</td>
					<td>".$row['firstname']." ".$row['lastname']." "."(".$row['username'].")</td>
					<td>".$row['bonus']."</td>
					<td>".$row['bank_name']." , ".$row['bank_account_number']."</td>
					<td align='center'><input type='checkbox' name='".$row['uid_member']."'></td>
				</tr>";
				$i++;
			}
		}
	}
	function mentor_bonus_payed()
	{
            is_admin();
		$sql = "SELECT a.uid_member, b.*, sum(a.bonus) as bonus   
				FROM tx_rwmembermlm_historymentorbonus a,tx_rwmembermlm_member b
				WHERE 
					  a.deleted = 0 and a.hidden = 0 and 
				a.pid='67'
					  and a.paid = '0' 
					  and a.uid_member = b.uid
					  GROUP By a.uid_member
				ORDER BY b.firstname ASC";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		$boolean = FALSE;
		echo "<ol>";
		foreach($data as $row)
		{
			if($this->input->post($row['uid_member']))
			{
				echo  "<li><strong>".$row['username']."</strong> (".$row['firstname']." ".$row['lastname'].") has been payed.</li>";
				
				$c = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$row['uid_member'],'uid');// get commission from tabel member
				$sql = "select   sum(bonus) as bonus  
						from tx_rwmembermlm_historymentorbonus 
						where  bonus > 0 and  paid = 0
						and  uid_member = '".$row['uid_member']."'
						group by  uid_member";
				$f = $this->Mix->read_rows_by_sql($sql);
				 
				$t = $c['commission']-$f['bonus'];
				
				$mc['commission'] = $t;
				$this->Mix->update_record('uid',$row['uid_member'],$mc,'tx_rwmembermlm_member');
				
				$fc['paid'] = 1;
				$this->Mix->update_record('uid_member',$row['uid_member'],$fc,'tx_rwmembermlm_historymentorbonus');
				#debug_data($f);
				$boolean = TRUE;
			}
		}
		echo "</ol>";
		if($boolean)
		{
			echo "<p class=\"error\">transaction has been success.</p>";
		}
		else
		{
			echo "<p class=\"error\">Nothing to do.</p>";
		}
	}
}