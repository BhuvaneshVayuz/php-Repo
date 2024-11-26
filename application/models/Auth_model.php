<?php
class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Check if email already exists
    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('auth');
        return $query->num_rows() > 0;
    }

    // Register a new user
    public function register_user($email, $password) {
        $data = array(
            'email' => $email,
            'password' => $password,
        );
        return $this->db->insert('auth', $data);
    }

    // Check user credentials for login
    public function login_user($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('auth');
        if ($query->num_rows() == 1) {
            $user = $query->row();
            if($password == $user->password){
               return $user;
           }
        }
        return null;
    }
}

?>
