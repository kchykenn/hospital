<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    private $table = 'users';
    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_user($data)
    {
        // Insert user data into the users table
        $this->db->insert('users', $data);
        return $this->db->insert_id(); // Returns the inserted user's ID
    }

    // Get all users
    public function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result_array(); 
    }

    // Get user by email
    public function get_user_by_email($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->row_array(); 
    }

    // Get user by ID
    public function get_user_by_id($user_id)
    {
        $query = $this->db->get_where('users', array('id' => $user_id));
        return $query->row_array(); // Return user as an associative array
    }

    // Update user data
    public function update_user($user_id, $data)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data); 
    }

    // Delete user by marking them as deleted (soft delete)
    public function delete_user($user_id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s') // Set current date-time for deleted_at
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data); // Soft delete the user by updating the deleted_at field
    }

    // Permanently delete a user
    public function permanently_delete_user($user_id)
    {
        $this->db->where('id', $user_id);
        return $this->db->delete('users'); // Permanently delete user from the database
    }

    // Check if email already exists
    public function check_email_exists($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->num_rows() > 0; // Return true if email exists, false otherwise
    }

        // Restore a soft-deleted Users
    public function restore_user($user_id) {
        // Check if patient exists before restoring
        if (!$this->get_user_by_id($user_id)) {
            return ['error' => 'User not found'];
        }

        $this->db->where('id', $user_id);
        return $this->db->update($this->table, ['deleted_at' => NULL]);
    }
}
