<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel'); 
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->database();  
    }

    public function register()
    {
        $this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');

//add session before redirect
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('user/register');
        } else {

            $user_data = [
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT), 
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->UserModel->insert_user($user_data)) {
                $this->session->set_flashdata('success', 'Registration successful! Please log in.');
                redirect('user/login'); 
            } else {
                $this->session->set_flashdata('error', 'Registration failed, please try again.');
                $this->load->view('user/register');
            }
        }
    }

   public function login()
   {
       if ($this->input->post()) {
           $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
           $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

           if ($this->form_validation->run() == FALSE) {
               $this->load->view('user/login');
           } else {
               $email = $this->input->post('email');
               $password = $this->input->post('password');

               $user = $this->UserModel->get_user_by_email($email);

               if ($user && password_verify($password, $user['password'])) {
                   $this->session->set_userdata('user_id', $user['id']); 
                   $this->session->set_flashdata('success', 'Login successful!');
                   redirect('patient/table'); 
               } else {
                   $this->session->set_flashdata('error', 'Invalid credentials, please try again.');
                   $this->load->view('user/login');
               }
           }
       } else {
           $this->load->view('user/login');
       }
   }
}
