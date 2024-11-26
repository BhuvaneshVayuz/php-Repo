<?php
class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    // Show the sign-up form
    public function sign_up() {
        $this->load->view('signup');
    }

    // Handle the sign-up submission
    public function sign_up_submit() {
        // Set form validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            // Validation failed, re-render sign-up form with errors
            $this->load->view('auth/sign_up');
        } else {
            // Validation passed, handle registration
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Check if email already exists
            if ($this->Auth_model->check_email_exists($email)) {
                $this->session->set_flashdata('error', 'Email already exists!');
                redirect('auth/sign_up');
            }

            // Register the user
            if ($this->Auth_model->register_user($email, $password)) {
                $this->session->set_flashdata('success', 'User registered successfully!');
                redirect('auth/sign_in');
            } else {
                $this->session->set_flashdata('error', 'Registration failed!');
                redirect('auth/sign_up');
            }
        }
    }

    // Show the sign-in form
    public function sign_in() {
        $this->load->view('signin');
    }

    // Handle the sign-in submission
    public function sign_in_submit() {
        // Set form validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == false) {
            // Validation failed, re-render sign-in form with errors
            $this->load->view('auth/sign_in');
        } else {
            // Validation passed, handle login
            $email = $this->input->post('email');
            $password = $this->input->post('password');


            $user = $this->Auth_model->login_user($email, $password);

            if ($user) {
                // Store user data in session
                $this->session->set_userdata('user', $user);
                redirect('user/index');
            } else {
                $this->session->set_flashdata('error', 'Invalid credentials!');
                redirect('auth/sign_in');
            }
        }
    }

    // Logout the user
    public function logout() {
        $this->session->unset_userdata('user');
        redirect('auth/sign_in');
    }
}
?>
