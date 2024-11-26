<?php
class User extends CI_controller{

	public function index() {
		$this->load->model('User_model');
		$this->load->model('UserProfile_model');  // Load the profile model
	
		$user = $this->session->userdata('user');
	
		if ($user) {
			$authId = $user->auth_id;
			$users = $this->User_model->all($authId);
	
			// Check if each user has a profile and add the information to the array
			foreach ($users as &$userData) {
				$profile = $this->UserProfile_model->getProfile($userData['user_id'], $authId);
				$userData['profile_exists'] = !empty($profile);
			}
	
			$data['users'] = $users;
			$this->load->view('list', $data);
		} else {
			redirect('auth/sign_in');
		}
	}
	

	function create() {
		$this->load->model('User_model');

		$user = $this->session->userdata('user');
  
		if (!$user) {
			// If no user is logged in, redirect to the login page
			redirect('auth/sign_in');
		}


		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');


		if ($this->form_validation->run() == false) {
			$this->load->view('create');
		} else {
			// Save record to database
			$formArray = array();
			$formArray['name'] = $this->input->post('name');
			$formArray['email'] = $this->input->post('email');
			$formArray['created_at'] = date('Y-m-d');
			$this->User_model->create($formArray ,$user->auth_id  );
			$this->session->set_flashdata('success','Record added successfully!');
			redirect(base_url().'index.php/user/index');
					}
		
	}

	// function create() {
	// 	$this->load->model('User_model');
    //     $input = json_decode(file_get_contents('php://input'), true);

    //     $this->load->library('form_validation');

    //     $this->form_validation->set_data($input); // Set data for validation rules


	// 	$this->form_validation->set_rules('name','Name','required');
	// 	$this->form_validation->set_rules('email','Email','required|valid_email');





	// 	if ($this->form_validation->run() == false) {
	// 		// $this->load->view('create');
	// 		$response = [
    //             'status' => 'error',
    //             'message' => 'Validation errors',
    //             'errors' => $this->form_validation->error_array(),
    //         ];
    //         $this->output
    //             ->set_status_header(400)
    //             ->set_content_type('application/json')
    //             ->set_output(json_encode($response));

	// 	} else {
	// 		// Save record to database
	// 		// $formArray = array();
	// 		// $formArray['name'] = $this->input->post('name');
	// 		// $formArray['email'] = $this->input->post('email');
	// 		// $formArray['created_at'] = date('Y-m-d');

	// 		$formArray = [
    //             'name' => $input['name'],
    //             'email' => $input['email'],
    //             'created_at' => date('Y-m-d'),
    //         ];

	// 		$this->User_model->create($formArray);
	// 		// $this->session->set_flashdata('success','Record added successfully!');
	// 		// redirect(base_url().'index.php/user/index');
	// 		$response = [
    //             'status' => 'success',
    //             'message' => 'Record added successfully',
    //             'data' => $formArray,
    //         ];
    //         $this->output
    //             ->set_content_type('application/json')
    //             ->set_output(json_encode($response));
	// 	}
		
	// }

	function edit($userId) {
		$this->load->model('User_model');
	
		// Retrieve the logged-in user's auth_id from the session
		$user = $this->session->userdata('user');
	
		if (!$user) {
			// If no user is logged in, redirect to the login page
			redirect('auth/sign_in');
		}
	
		// Get the logged-in user's auth_id
		$authId = $user->auth_id;
	
		// Get the user data for the specified userId, but ensure it belongs to the logged-in user's auth_id
		$existingUser = $this->User_model->getUser($userId, $authId);
	
		if (!$existingUser) {
			// Return error if the user doesn't exist or if the auth_id doesn't match
			$this->session->set_flashdata('error', 'User not found or you do not have permission to edit this user.');
			redirect('user/index');
		}
	
		// Prepare data for the view
		$data = array();
		$data['user'] = $existingUser;
	
		// Set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	
		if ($this->form_validation->run() == false) {
			// If validation fails, load the edit view with errors
			$this->load->view('edit', $data);
		} else {
			// Validation passed, update the user record
			$formArray = array();
			$formArray['name'] = $this->input->post('name');
			$formArray['email'] = $this->input->post('email');
	
			// Pass the auth_id when calling updateUser to ensure the user belongs to the logged-in user's auth_id
			$this->User_model->updateUser($userId, $formArray, $authId);
	
			// Set success message and redirect to the index page
			$this->session->set_flashdata('success', 'Record updated successfully!');
			redirect(base_url() . 'index.php/user/index');
		}
	}
	
	// function edit($userId)
	// {
	// 	$this->load->model('User_model');

	// 	$input = json_decode(file_get_contents('php://input'), true);



	// 	$user = $this->User_model->getUser($userId);



    //     if (!$user) {
    //         // Return error if user doesn't exist
    //         echo json_encode(['status' => 'error', 'message' => 'User not found']);
    //         return;
    //     }



    //     $this->form_validation->set_data($input); // Set input data for validation


	// 	$this->form_validation->set_rules('name','Name','required');
	// 	$this->form_validation->set_rules('email','Email','required|valid_email');

	// 	if ($this->form_validation->run() == false)  {
	// 		// $this->load->view('edit',$data);
	// 		echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Validation failed',
    //             'errors' => $this->form_validation->error_array()
    //         ]);
    //         return;
	// 	}
		
	// 	// else {
	// 		// update user record
	// 		// $formArray = array();
	// 		// $formArray['name'] = $this->input->post('name');
	// 		// $formArray['email'] = $this->input->post('email');
			
			
	// 		$formArray = [
    //             'name' => $input['name'],
    //             'email' => $input['email'],
    //         ];
			
	// 		$this->User_model->updateUser($userId,$formArray);
	// 		// $this->session->set_flashdata('success','Record updated successfully');
	// 		// redirect(base_url().'index.php/user/index');
	// 		// $response = [
    //         //     'status' => 'success',
    //         //     'message' => 'Record added successfully',
    //         //     'data' => $formArray,
    //         // ];
    //         // $this->output
    //         //     ->set_content_type('application/json')
    //         //     ->set_output(json_encode($response));

    //         //print_r($this->User_model->updateUser($userId, $formArray));die();
	// 		if ($this->User_model->updateUser($userId, $formArray)) {
	// 			// Return success response
	// 			echo json_encode([
	// 				'status' => 'success',
	// 				'message' => 'User record updated successfully'
	// 			]);
	// 		} else {
	// 			// Handle error if update fails
	// 			echo json_encode([
	// 				'status' => 'error',
	// 				'message' => 'Error updating user record'
	// 			]);
	// 		}
	// 	// }
	// }

	function delete($userId) {
		$this->load->model('User_model');
	
		// Retrieve the logged-in user's auth_id from the session
		$user = $this->session->userdata('user');
		
		if (!$user) {
			// If no user is logged in, redirect to the login page
			redirect('auth/sign_in');
		}
	
		// Get the logged-in user's auth_id
		$authId = $user->auth_id;
	
		// Get the user data for the specified userId, but ensure it belongs to the logged-in user's auth_id
		$userToDelete = $this->User_model->getUser($userId, $authId);
	
		if (empty($userToDelete)) {
			// Return error if the user doesn't exist or if the auth_id doesn't match
			$this->session->set_flashdata('failure', 'Record not found or you do not have permission to delete this user.');
			redirect(base_url() . 'index.php/user/index');
		}
	
		// Call the deleteUser method to delete the user
		$this->User_model->deleteUser($userId, $authId);
	
		// Set success message and redirect to the user index page
		$this->session->set_flashdata('success', 'Record deleted successfully!');
		redirect(base_url() . 'index.php/user/index');
	}
	
	// function delete($userId)
	// {
	// 	$this->load->model('User_model');
	// 	$user = $this->User_model->getUser($userId);
	// 	if (empty($user)) {
	// 		// $this->session->set_flashdata('failure','Record not found in database');
	// 		// redirect(base_url().'index.php/user/index');
	// 		$response = [
    //             'status' => 'error',
    //             'message' => 'Record Not found in DB'
    //         ];
    //         $this->output
    //             ->set_content_type('application/json')
    //             ->set_output(json_encode($response));
	// 	}

	// 	$this->User_model->deleteUser($userId);
	// 	// $this->session->set_flashdata('success','Record deleted successfully');
	// 	// redirect(base_url().'index.php/user/index');
	// 	$response = [
	// 		'status' => 'Success',
	// 		'message' => 'Record Deleted'
	// 	];
	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($response));
	
	// }
}
?>