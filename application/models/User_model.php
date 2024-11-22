<?php
class User_model extends CI_model{

	function create($formArray)
	{
		$this->db->insert("users",$formArray); // INSERT INTO users (name,email,created) values (?, ?, ?);
	}

	function all() {
		return $users = $this->db->get('users')->result_array(); // SELECT * from users
	}

	function getUser($userId) {
		$this->db->where('user_id',$userId);
		return $user = $this->db->get('users')->row_array(); // Select * from users where user_id = ?
	}

	function updateUser($userId,$formArray) {
		$this->db->where('user_id',$userId);
		$this->db->update('users',$formArray); // Update users SET name = ? , email = ? where user_id = ?

        
		$this->db->where('user_id', $userId);
        $query = $this->db->get('users');

		if ($query->num_rows() == 0) {
			return false;  // User not found
		}
		if($this->db->affected_rows()==0){
			return false;
		}
			return true;

	}

	function deleteUser($userId) {
		$this->db->where('user_id',$userId);
		$this->db->delete('users'); // DELETE FROM users Where user_id = ?
	}
}
?>