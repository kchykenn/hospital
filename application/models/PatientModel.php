<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PatientModel extends CI_Model {

    private $table = 'patients';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Insert a new patient
    public function insert_patient($data) {
        // Ensure created_at timestamp is set
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        // Validate required fields
        if (empty($data['firstname']) || empty($data['lastname']) || empty($data['birthdate'])) {
            return ['error' => 'Required fields missing: firstname, lastname, birthdate'];
        }

        return $this->db->insert($this->table, $data);
    }

    // Get all active patients
    public function get_active_patients() {
        $query = $this->db->select('id, firstname, middlename, lastname, birthdate, sex, profile_image, phone, email, created_at, updated_at, deleted_at')
                          ->from($this->table)
                          ->where('deleted_at', NULL)
                          ->get();
        return $query->result_array();
    }

    // Get a specific patient by ID
    public function get_patient_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    // Update an existing patient
    public function update_patient($id, $data) {
        // Ensure updated_at timestamp is set
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Soft delete a patient
    public function delete_patient($id) {
        // Check if patient exists before deleting
        if (!$this->get_patient_by_id($id)) {
            return ['error' => 'Patient not found'];
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    // Get all deleted (soft-deleted) patients
    public function get_deleted_patients() {
        $query = $this->db->select('id, firstname, middlename, lastname, birthdate, sex, profile_image, phone, email, created_at, updated_at, deleted_at')
                          ->from($this->table)
                          ->where('deleted_at !=', NULL)
                          ->get();
        return $query->result_array();
    }

    // Restore a soft-deleted patient
    public function restore_patient($id) {
        // Check if patient exists before restoring
        if (!$this->get_patient_by_id($id)) {
            return ['error' => 'Patient not found'];
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, ['deleted_at' => NULL]);
    }
}
?>
