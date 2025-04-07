<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class UserApi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Get all users",
     *     description="Returns a list of all users.",
     *     operationId="getAllUsers",
     *     tags={"users"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="firstname", type="string", example="John"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-04-03T12:30:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function getAll() {
        $users = $this->UserModel->get_all_users();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($users));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Create a new user",
     *     description="Creates a new user and returns the user ID.",
     *     operationId="createUser",
     *     tags={"users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"firstname", "lastname", "email", "password"},
     *                 @OA\Property(property="firstname", type="string", example="John"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="password", type="string", example="password123")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function create() {
        $data = json_decode($this->input->raw_input_stream, true);
        
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');

        if ($this->form_validation->run() === FALSE) {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['error' => validation_errors()]));
        } else {
            $user_data = [
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $user_id = $this->UserModel->insert_user($user_data);
            $this->output
                ->set_status_header(201)
                ->set_output(json_encode(['id' => $user_id]));
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Get a user by ID",
     *     description="Returns a user by their ID.",
     *     operationId="getUserById",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="firstname", type="string", example="John"),
     *             @OA\Property(property="lastname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    // Get user by ID
    public function get($id) {
        $user = $this->UserModel->get_user_by_id($id);
        if ($user) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($user));
        } else {
            $this->output
                ->set_status_header(404)
                ->set_output(json_encode(['error' => 'User not found']));
        }
    }


    /**
     * @OA\Put(
     *     path="/api/v1/users/update/{id}",
     *     summary="Update user by ID",
     *     description="Updates a user's information by ID.",
     *     operationId="updateUser",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="firstname", type="string", example="John"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update($id) {
        $data = json_decode($this->input->raw_input_stream, true);
        
        if ($this->UserModel->update_user($id, $data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => 'User updated successfully']));
        } else {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['error' => 'Failed to update user']));
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/delete/{id}",
     *     summary="Delete user by ID",
     *     description="Deletes a user by their ID.",
     *     operationId="deleteUser",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function delete($id) {
        if ($this->UserModel->delete_user($id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => 'User deleted successfully']));
        } else {
            $this->output
                ->set_status_header(404)
                ->set_output(json_encode(['error' => 'User not found']));
        }
    }


        /**
     * @OA\Post(
     *     path="/api/v1/users/restore/{id}",
     *     summary="Restore a soft-deleted users",
     *     description="Restores a soft-deleted users by setting `deleted_at` to NULL.",
     *     operationId="restoreUser",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to restore",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully restored",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="User not found"
     *     )
     * )
     */
    public function restore($id) {
        $result = $this->UserModel->restore_user($id);
        if ($result) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'error' => 'Patient not found']));
        }
    }
}
