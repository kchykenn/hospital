<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class PatientApi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PatientModel');
        $this->load->library('form_validation');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/patients",
     *     summary="Get all active patients",
     *     description="Returns a list of active patients.",
     *     operationId="getAllPatients",
     *     tags={"patients"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of active patients",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="firstname", type="string", example="John"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="phone", type="string", example="123-456-7890"),
     *                 @OA\Property(property="birthdate", type="string", format="date", example="1985-08-15")
     *             )
     *         )
     *     )
     * )
     */
    public function getAll() {
        $data = $this->PatientModel->get_active_patients();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/patients/add",
     *     summary="Add a new patient",
     *     description="Adds a new patient to the system with an optional profile image.",
     *     operationId="addPatient",
     *     tags={"patients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"firstname", "lastname", "email", "phone", "birthdate", "sex"},
     *                 @OA\Property(property="firstname", type="string", example="John"),
     *                 @OA\Property(property="middlename", type="string", example="Doe"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                 @OA\Property(property="phone", type="string", example="123-456-7890"),
     *                 @OA\Property(property="birthdate", type="string", format="date", example="1985-08-15"),
     *                 @OA\Property(property="sex", type="string", example="male"),
     *                 @OA\Property(property="profile_image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient successfully added",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function add() {
        // Form validation for fields
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middle Name', 'min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[patients.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[male,female,other]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors(); // Get detailed error messages
            log_message('error', 'Form Validation Failed: ' . $errors); // Log errors for debugging
            $this->output->set_content_type('application/json')->set_output(json_encode(["error" => $errors]));
            return;
        }

        // Handling file upload
        $profile_image = '';
        if (!empty($_FILES['profile_image']['name'])) {
            // Specify the file upload configuration
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2 MB max file size
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profile_image')) {
                $this->output->set_content_type('application/json')->set_output(json_encode(["error" => $this->upload->display_errors()])); 
                return;
            } else {
                $upload_data = $this->upload->data();
                $profile_image = $upload_data['file_name']; // Store the image filename
            }
        }

        $patient_data = [
            'firstname' => $this->input->post('firstname'),
            'middlename' => $this->input->post('middlename'),
            'lastname' => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'birthdate' => $this->input->post('birthdate'),
            'sex' => $this->input->post('sex'),
            'profile_image' => $profile_image, // Save the image filename
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->PatientModel->insert_patient($patient_data)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false]));
        }
    }


    /**
     * @OA\Get(
     *     path="/api/v1/patients/{id}",
     *     summary="Get a patient by ID",
     *     description="Fetches a patient's details based on the provided ID.",
     *     operationId="getPatientById",
     *     tags={"patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient to fetch",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient data successfully retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="firstname", type="string", example="John"),
     *             @OA\Property(property="lastname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="phone", type="string", example="123-456-7890"),
     *             @OA\Property(property="birthdate", type="string", format="date", example="1985-08-15")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function getPatientById($id) {
        // Fetch the patient data from the model using the provided ID
        $data = $this->PatientModel->get_patient_by_id($id);

        if ($data) {
            // If patient data found, return it as JSON
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            // If no data is found, return a 404 error response
            $this->output->set_content_type('application/json')->set_output(json_encode(["error" => "Patient not found"]));
        }
    }


    /**
     * @OA\Put(
     *     path="/api/v1/patients/update/{id}",
     *     summary="Update an existing patient",
     *     description="Updates an existing patient's details, including profile image if provided.",
     *     operationId="updatePatient",
     *     tags={"patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"firstname", "lastname", "email", "phone", "birthdate", "sex"},
     *                 @OA\Property(property="firstname", type="string", example="John"),
     *                 @OA\Property(property="middlename", type="string", example="Doe"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                 @OA\Property(property="phone", type="string", example="123-456-7890"),
     *                 @OA\Property(property="birthdate", type="string", format="date", example="1985-08-15"),
     *                 @OA\Property(property="sex", type="string", example="male"),
     *                 @OA\Property(property="profile_image", type="string", format="binary"),
     *                 @OA\Property(property="existing_profile_image", type="string", example="image.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient successfully updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */


    public function update($id) {
        // Form validation for fields
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middle Name', 'min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[male,female,other]');
    
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors(); // Get detailed error messages
            log_message('error', 'Form Validation Failed: ' . $errors); // Log errors for debugging
            $this->output->set_content_type('application/json')->set_output(json_encode(["error" => $errors]));
            return;
        }
    
        // Fetch the current patient info (to carry over the existing profile image if not uploaded)
        $current_patient = $this->PatientModel->get_patient($id);
        if (!$current_patient) {
            $this->output->set_content_type('application/json')->set_output(json_encode(["error" => "Patient not found"]));
            return;
        }
    
        // Default the profile image to the existing one
        $profile_image = $current_patient->profile_image;  // Carry over the current image if no new image is uploaded
        
        // Check if a new profile image is uploaded
        if (!empty($_FILES['profile_image']['name'])) {
            // Handle the file upload
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2 MB max file size
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('profile_image')) {
                // If upload fails, return error
                log_message('error', 'Upload Error: ' . $this->upload->display_errors());
                $this->output->set_content_type('application/json')->set_output(json_encode(["error" => $this->upload->display_errors()]));
                return;
            } else {
                // If upload succeeds, delete the old image and store the new one
                if ($profile_image && file_exists('./upload/' . $profile_image)) {
                    unlink('./upload/' . $profile_image); // Delete the old image
                }
    
                // Store the new image filename
                $upload_data = $this->upload->data();
                $profile_image = $upload_data['file_name']; // Update with new image
            }
        }
    
        // Prepare data for update
        $patient_data = [
            'firstname' => $this->input->post('firstname'),
            'middlename' => $this->input->post('middlename'),
            'lastname' => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'birthdate' => $this->input->post('birthdate'),
            'sex' => $this->input->post('sex'),
            'profile_image' => $profile_image, // Either existing or newly uploaded image
        ];
    
        // Update the patient
        if ($this->PatientModel->update_patient($id, $patient_data)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
        } else {
            log_message('error', 'Failed to update patient with ID: ' . $id);
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false]));
        }
    }
    
   

/**
 * @OA\Delete(
 *     path="/api/v1/patients/delete/{id}",
 *     summary="Soft delete a patient",
 *     description="Soft deletes a patient by marking their record as deleted (sets `deleted_at`).",
 *     operationId="deletePatient",
 *     tags={"patients"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the patient to delete",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Patient successfully deleted",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Patient not found"
 *     )
 * )
 */
public function delete($id) {
    $result = $this->PatientModel->delete_patient($id);
    
    if ($result) {
        $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
    } else {
        $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'error' => 'Patient not found']));
    }
}


    /**
     * @OA\Post(
     *     path="/api/v1/patients/restore/{id}",
     *     summary="Restore a soft-deleted patient",
     *     description="Restores a soft-deleted patient by setting `deleted_at` to NULL.",
     *     operationId="restorePatient",
     *     tags={"patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient to restore",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient successfully restored",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Patient not found"
     *     )
     * )
     */
    public function restore($id) {
        $result = $this->PatientModel->restore_patient($id);
        if ($result) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'error' => 'Patient not found']));
        }
    }
}
