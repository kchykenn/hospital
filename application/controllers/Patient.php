<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('PatientModel');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('upload');
    }

    public function index() {
        // Fetch only active patients (where `deleted_at` is NULL)
        $data['patients'] = $this->PatientModel->get_active_patients();
        $this->load->view('user/login', $data);
    }


    public function table() {
       
        $data['patients'] = $this->PatientModel->get_active_patients();
        $this->load->view('patient/table', $data);
    }



    public function get_patient_by($id) {
        $data = $this->PatientModel->get_patient_by_id($id);
        if ($data) {
            $response = [
                'id' => $data['id'],
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'sex' => $data['sex'],
                'birthdate' => date('F d, Y', strtotime($data['birthdate'])),
                'profile_image' => $data['profile_image'] // Ensure this field is returned
            ];
            echo json_encode($response);
        } else {
            echo json_encode([]);
        }
    }
    
    
    


    public function add() {
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middle Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[patients.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');  
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[male,female,other]'); 
        
        if ($this->form_validation->run() == FALSE) {
     
            echo '<script>console.log("Form validation failed.");</script>';
            $this->load->view('patient/add');
        } else {
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . "_" . $_FILES['profile_image']['name'];
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('profile_image')) {
                $upload_data = $this->upload->data();
                $image = $upload_data['file_name']; 
            } else {
                $image = '';
            }
    

            echo '<script>console.log("Uploaded image: " + "' . $image . '");</script>';
    

            $patient_data = [
                'firstname' => $this->input->post('firstname'),
                'middlename' => $this->input->post('middlename'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email'),
                'profile_image' => $image, 
                'phone' => $this->input->post('phone'),
                'birthdate' => $this->input->post('birthdate'),
                'sex' => $this->input->post('sex'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
    
 
            if ($this->PatientModel->insert_patient($patient_data)) {
                $this->session->set_flashdata('success', 'Patient added successfully');
                redirect('patient/table');
            } else {
                $this->session->set_flashdata('error', 'Failed to add patient');
                echo '<script>console.log("Error: Failed to add patient.");</script>';
                $this->load->view('patient/add');
            }
        }
    }
    

    public function edit($id) {
        // Load the PatientModel
        $this->load->model('PatientModel');
    
        // Fetch patient data by ID
        $data['patient'] = $this->PatientModel->get_patient_by_id($id);
    
        // If the patient doesn't exist, show a 404 error
        if (!$data['patient']) {
            show_404();
        }
    
        // Set form validation rules for the fields
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middle Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[patients.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[male,female,other]');
        
        // If validation fails, reload the edit form with existing data
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('patient/edit', $data);
        } else {
            // File upload logic for editing patient profile image
            if ($_FILES['profile_image']['name']) {
                $config['upload_path'] = './upload/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 2048;
                $config['file_name'] = time() . "_" . $_FILES['profile_image']['name'];
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_image')) {
                    $upload_data = $this->upload->data();
                    $image = $upload_data['file_name']; // Get the uploaded image filename
                } else {
                    $image = $data['patient']['profile_image']; // Use existing image if upload fails
                }
            } else {
                $image = $data['patient']['profile_image']; // Keep existing image if no new image is uploaded
            }

            // Prepare the update data
            $update_data = [
                'firstname' => $this->input->post('firstname'),
                'middlename' => $this->input->post('middlename'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email'),
                'profile_image' => $image, // Use the uploaded image or existing image
                'phone' => $this->input->post('phone'),
                'birthdate' => $this->input->post('birthdate'),
                'sex' => $this->input->post('sex'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            // Update patient data in the database
            if ($this->PatientModel->update_patient($id, $update_data)) {
                $this->session->set_flashdata('success', 'Patient updated successfully');
                redirect('patient/table');
            } else {
                $this->session->set_flashdata('error', 'Failed to update patient');
                $this->load->view('patient/edit', $data);
            }
        }
    }
    
    

    public function update() {
        $id = $this->input->post('id');
    
        // Form validation
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middle Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[patients.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[male,female,other]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            // Get the current image from the hidden field
            $image = $this->input->post('current_profile_image');
    
            if ($_FILES['profile_image']['name']) {
                $config['upload_path'] = './upload/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 2048;
                $config['file_name'] = time() . "_" . $_FILES['profile_image']['name'];
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
    
                if ($this->upload->do_upload('profile_image')) {
                    // Delete the old image if a new one is uploaded
                    if (!empty($image)) {
                        unlink('./upload/' . $image);
                    }
    
                    $upload_data = $this->upload->data();
                    $image = $upload_data['file_name']; // New image name
                } else {
                    $this->session->set_flashdata('error', 'Failed to upload profile image');
                    redirect('patient/edit/' . $id);
                    return;
                }
            }
    
            // Prepare update data
            $update_data = [
                'firstname' => $this->input->post('firstname'),
                'middlename' => $this->input->post('middlename'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email'),
                'profile_image' => $image,  // Save the image filename
                'phone' => $this->input->post('phone'),
                'birthdate' => $this->input->post('birthdate'),
                'sex' => $this->input->post('sex'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            // Update patient data
            if ($this->PatientModel->update_patient($id, $update_data)) {
                $this->session->set_flashdata('success', 'Patient updated successfully');
                redirect('patient/table');
            } else {
                $this->session->set_flashdata('error', 'Failed to update patient');
                redirect('patient/edit/' . $id);
            }
        }
    }
    

    
    

    // Soft delete patient (called from the delete link)
    public function delete($id) {
        if ($this->PatientModel->delete_patient($id)) {
            $this->session->set_flashdata('success', 'Patient deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete patient');
        }
        redirect('patient/table');
    }

    public function show_deleted_pat() {
        // Fetch deleted patients (where `deleted_at` is NOT NULL)
        $data['patients'] = $this->PatientModel->get_deleted_patients();
        $this->load->view('patient/deleted', $data);
    }

    // Restore soft-deleted patient
    public function restore($id) {
        // Restore patient by setting `deleted_at` to NULL
        $this->load->model('PatientModel');
        if ($this->PatientModel->restore_patient($id)) {
            $this->session->set_flashdata('success', 'Patient restored successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to restore patient');
        }
        redirect('patient/show_deleted_pat');
    }

    
}

?>