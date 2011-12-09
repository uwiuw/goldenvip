<?php 
// mix model idea for x web
class Mix extends CI_Model
{
	//	add record into table
	function add_with_array($data,$tb)
	{
		$this->db->insert($tb,$data);
	}
	//	update record table
	function update_record($field,$val,$data,$tb)
	{
		$this->db->where($field,$val);
		$this->db->update($tb,$data);
	}
	//	update record table by two value
	function update_record_by_two($field,$val,$field1,$val1,$data,$tb)
	{
		$this->db->where($field,$val);
		$this->db->where($field1,$val1);
		$this->db->update($tb,$data);
	}
	function update_record_by_three($field,$val,$field2,$val2,$field3,$val3,$data,$tb)
	{
		$this->db->where($field,$val);
		$this->db->where($field2,$val2);
		$this->db->where($field3,$val3);
		$this->db->update($tb,$data);
	}
	//	delete record by one id
	function dell_one_by_one($field,$val,$tb)
	{
		$this->db->where($field,$val);
		$this->db->delete($tb);
	}
	//	delete record by two id
	function dell_one_by_two($field,$val,$field1,$val1,$tb)
	{
		$this->db->where($field,$val);
		$this->db->where($field1,$val1);
		$this->db->delete($tb);
	}
	//	read one record row
	function read_row_by_one($field,$val,$tb)
	{
		$data = array();
		$this->db->where($field,$val);
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	// read rows record
	function read_rows($tb)
	{
		$data = array();
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	function read_rows_desc($field,$tb)
	{
		$data = array();
		$this->db->order_by($field,'desc');
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	//	read rows record
	function read_rows_by_one($field,$val,$tb)
	{
		$data = array();
		$this->db->where($field,$val);
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	//	read one record row by two field
	function read_row_by_two($field1,$val1,$field2,$val2,$tb)
	{
		$data = array();
		$this->db->where($field1,$val1);
		$this->db->where($field2,$val2);
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	// 	read one rows record and return field
	function read_row_ret_field($tb,$field)
	{
		$data = array();
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[$field] = $row[$field];
			}
		}
		$q->free_result();
		return $data;
	}
	
	// 	read one rows record and return field by value
	function read_row_ret_field_by_value($tb,$field,$val,$field2)
	{
		$data = array();
		$this->db->where($field2,$val);
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[$field] = $row[$field];
			}
		}
		$q->free_result();
		return $data;
	}
	
	//	read rows record by two field
	function read_rows_by_two($field1,$val1,$field2,$val2,$tb)
	{
		$data = array();
		$this->db->where($field1,$val1);
		$this->db->where($field2,$val2);
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	//	read rows record by sql
	function read_rows_by_sql($sql)
	{
		$data = array(); 
		$q = $this->db->query($sql);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	// read rows for dropdown menu
	function dropdown_menu($field,$field2,$tb,$hidden='0',$pid='0')
	{
		$data = array(); 
		$this->db->where('pid',$pid);
		$this->db->where('hidden',$hidden);
		$q = $this->db->get($tb);
		$data['']= '-- select --';
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[$row[$field]] = $row[$field2];
			}
		}
		$q->free_result();
		return $data;
	}
	
	// custom
	
	
	function read_province($uid,$hidden='0')
	{
		$data = array(); 
		$this->db->where('hidden',$hidden);
		$this->db->where('uid_country',$uid);
		$q = $this->db->get('tx_rwmembermlm_province');
		$data['']= '-- select --';
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[$row['uid']] = $row['province'];
			}
		}
		$q->free_result();
		return $data;
	}
	
	function read_city($uid,$hidden='0')
	{
		$data = array(); 
		$this->db->where('hidden',$hidden);
		$this->db->where('uid_province',$uid);
		$q = $this->db->get('tx_rwmembermlm_city');
		$data['']= '-- select --';
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[$row['uid']] = $row['city'];
			}
		}
		$q->free_result();
		return $data;
	}
	
	function read_disrtibutor($regional,$pid='67',$cat='3')
	{
		$data = array(); 
		$this->db->where('regional',$regional);
		$this->db->where('pid',$pid);
		$this->db->where('usercategory',$cat);
		$q = $this->db->get('tx_rwmembermlm_member');
		$data['']= '-- select --';
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[$row['uid']] = $row['firstname']." ".$row['lastname'];
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get_destination_detail($val='0')
	{
		$data = array();
		$this->db->where('hidden','0');
		$this->db->where('uid_destination',$val);
		$q = $this->db->get('tx_rwmembermlm_destination_detail');
		if($q->num_rows()>0)
		{
			$data['0']= '-- select --';
			foreach($q->result_array() as $row)
			{
				$data[$row['uid']] = $row['destination_detail'];
			}
		}
		$q->free_result();
		return $data;
	}
	
	function read_more_rows_by_sql($sql)
	{
		$data = array(); 
		$q = $this->db->query($sql);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	function read_rows_data_by_sql($sql)
	{
		$data = array(); 
		$q = $this->db->query($sql);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	function read_row_by_three($field,$val,$field2,$val2,$field3,$val3,$tb)
	{
		$data = array();
		$this->db->where($field,$val);
		$this->db->where($field2,$val2);
		$this->db->where($field3,$val3);
		$q = $this->db->get($tb);
		if($q->num_rows()>0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function rekap_data()
        {
            $data = $this->db->select('*');
            $data = $this->db->order_by('id','desc');
            $data = $this->db->get('rekap');
            return $data;
        }
}
