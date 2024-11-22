<?php
class User extends CI_controller{

	function index() {
		$this->load->model('User_model');
		$users = $this->User_model->all();
		$data = array();
		$data['users'] = $users;
		// $this->load->view('list',$data);
		$response = [
			'status'=> 'success',
			'data'=> $users
		];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

	}

	function create() {
		$this->load->model('User_model');
        $input = json_decode(file_get_contents('php://input'), true);

        $this->load->library('form_validation');

        $this->form_validation->set_data($input); // Set data for validation rules


		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');





		if ($this->form_validation->run() == false) {
			// $this->load->view('create');
			$response = [
                'status' => 'error',
                'message' => 'Validation errors',
                'errors' => $this->form_validation->error_array(),
            ];
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));

		} else {
			// Save record to database
			// $formArray = array();
			// $formArray['name'] = $this->input->post('name');
			// $formArray['email'] = $this->input->post('email');
			// $formArray['created_at'] = date('Y-m-d');

			$formArray = [
                'name' => $input['name'],
                'email' => $input['email'],
                'created_at' => date('Y-m-d'),
            ];

			$this->User_model->create($formArray);
			// $this->session->set_flashdata('success','Record added successfully!');
			// redirect(base_url().'index.php/user/index');
			$response = [
                'status' => 'success',
                'message' => 'Record added successfully',
                'data' => $formArray,
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
		}
		
	}

	function edit($userId)
	{
		$this->load->model('User_model');

		$input = json_decode(file_get_contents('php://input'), true);



		$user = $this->User_model->getUser($userId);



        if (!$user) {
            // Return error if user doesn't exist
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }



        $this->form_validation->set_data($input); // Set input data for validation


		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');

		if ($this->form_validation->run() == false)  {
			// $this->load->view('edit',$data);
			echo json_encode([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->form_validation->error_array()
            ]);
            return;
		}
		
		// else {
			// update user record
			// $formArray = array();
			// $formArray['name'] = $this->input->post('name');
			// $formArray['email'] = $this->input->post('email');
			
			
			$formArray = [
                'name' => $input['name'],
                'email' => $input['email'],
            ];
			
			$this->User_model->updateUser($userId,$formArray);
			// $this->session->set_flashdata('success','Record updated successfully');
			// redirect(base_url().'index.php/user/index');
			// $response = [
            //     'status' => 'success',
            //     'message' => 'Record added successfully',
            //     'data' => $formArray,
            // ];
            // $this->output
            //     ->set_content_type('application/json')
            //     ->set_output(json_encode($response));

            //print_r($this->User_model->updateUser($userId, $formArray));die();
			if ($this->User_model->updateUser($userId, $formArray)) {
				// Return success response
				echo json_encode([
					'status' => 'success',
					'message' => 'User record updated successfully'
				]);
			} else {
				// Handle error if update fails
				echo json_encode([
					'status' => 'error',
					'message' => 'Error updating user record'
				]);
			}
		// }
	}

	function delete($userId)
	{
		$this->load->model('User_model');
		$user = $this->User_model->getUser($userId);
		if (empty($user)) {
			// $this->session->set_flashdata('failure','Record not found in database');
			// redirect(base_url().'index.php/user/index');
			$response = [
                'status' => 'error',
                'message' => 'Record Not found in DB'
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
		}

		$this->User_model->deleteUser($userId);
		// $this->session->set_flashdata('success','Record deleted successfully');
		// redirect(base_url().'index.php/user/index');
		$response = [
			'status' => 'Success',
			'message' => 'Record Deleted'
		];
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	
	}
}
?>