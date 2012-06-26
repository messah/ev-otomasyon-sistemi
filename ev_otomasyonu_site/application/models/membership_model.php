<?php
class Membership_model extends CI_Model{

	function validate()
	{
		$this->db->where('username',$this->input->post('username'));
		$this->db->where('password',md5($this->input->post('password')));
		$query = $this->db->get('membership');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}
	function create_member()
	{
		$new_member_insert_data = array(
			'firstname' => $this->input->post('first_name'),
			'lastname' => $this->input->post('last_name'),
			'email' => $this->input->post('email_address'),
			'username' => $this->input->post('user_name'),
			'password' => md5($this->input->post('password'))
			
		);
		$insert = $this->db->insert('membership',$new_member_insert_data);
		return $insert;
	}
}

?>
