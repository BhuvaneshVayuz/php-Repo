<?php
class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserProfile_model');
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // Display a user's profile
    public function view($userId) {
        $user = $this->session->userdata('user');

        if (!$user) {
            redirect('auth/sign_in');
        }

        $authId = $user->auth_id;

        // Ensure the user belongs to the logged-in user's account
        $userData = $this->User_model->getUser($userId, $authId);
        if (!$userData) {
            $this->session->set_flashdata('error', 'Unauthorized access.');
            redirect('user/index');
        }

        // Fetch profile data
        $profile = $this->UserProfile_model->getProfile($userId, $authId);
        if (!$profile) {
            redirect('profile/create/' . $userId); // Redirect to create if profile doesn't exist
        }

        $data['profile'] = $profile;
        $data['user'] = $userData;

        $this->load->view('profileView', $data);
    }

    // Show the profile creation form
    public function create($userId) {
        
        $user = $this->session->userdata('user');
        
        if (!$user) {
            redirect('auth/sign_in');
        }

        $authId = $user->auth_id;

        // Ensure the user belongs to the logged-in user's account
        $userData = $this->User_model->getUser($userId, $authId);
        if (!$userData) {
            $this->session->set_flashdata('error', 'Unauthorized access.');
            redirect('user/index');
        }

        $data['user'] = $userData;

        // Set validation rules
        // print_r("fgh",$this->input->post('education'));die();
        $this->form_validation->set_rules('education', 'Education', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'required');

        if ($this->form_validation->run() == false) {
            // Load the create view
            $this->load->view('profileCreate', $data);
        } else {
            // print_r('validation passed');die();
            // Form validation passed, create profile
            $profileData = array(
                'user_id' => $userId,
                'education' => $this->input->post('education'),
                'phone_number' => $this->input->post('phone_number'),
                'address' => $this->input->post('address'),
                'birth_date' => $this->input->post('birth_date'),
            );

            $this->UserProfile_model->createProfile($profileData);
            $this->session->set_flashdata('success', 'Profile created successfully!');
            redirect('profile/view/' . $userId);
        }
    }

    // Show the profile edit form
    public function edit($userId) {
        $user = $this->session->userdata('user');

        if (!$user) {
            redirect('auth/sign_in');
        }

        $authId = $user->auth_id;

        // Ensure the user belongs to the logged-in user's account
        $userData = $this->User_model->getUser($userId, $authId);
        if (!$userData) {
            $this->session->set_flashdata('error', 'Unauthorized access.');
            redirect('user/index');
        }

        // Fetch existing profile data
        $profile = $this->UserProfile_model->getProfile($userId, $authId);
        if (!$profile) {
            redirect('profile/create/' . $userId); // Redirect to create if profile doesn't exist
        }

        $data['profile'] = $profile;
        $data['user'] = $userData;

        // Set validation rules
        $this->form_validation->set_rules('education', 'Education', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'required');

        if ($this->form_validation->run() == false) {
            // Load the edit view
            $this->load->view('profileEdit', $data);
        } else {
            // Form validation passed, update profile data
            $profileData = array(
                'education' => $this->input->post('education'),
                'phone_number' => $this->input->post('phone_number'),
                'address' => $this->input->post('address'),
                'birth_date' => $this->input->post('birth_date'),
            );

            $this->UserProfile_model->updateProfile($userId, $authId, $profileData);
            $this->session->set_flashdata('success', 'Profile updated successfully!');
            redirect('profile/view/' . $userId);
        }
    }

    // Delete a user's profile
    public function delete($userId) {
        $user = $this->session->userdata('user');

        if (!$user) {
            redirect('auth/sign_in');
        }

        $authId = $user->auth_id;

        // Ensure the user belongs to the logged-in user's account
        $userData = $this->User_model->getUser($userId, $authId);
        if (!$userData) {
            $this->session->set_flashdata('error', 'Unauthorized access.');
            redirect('user/index');
        }

        // Delete the profile
        $this->UserProfile_model->deleteProfile($userId, $authId);
        $this->session->set_flashdata('success', 'Profile deleted successfully!');
        redirect('user/index');
    }
}
?>
