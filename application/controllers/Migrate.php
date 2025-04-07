<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function index() {
        $this->load->library('migration');
        
        $this->load->database();
        $query = $this->db->get('migrations');
        $latest_version = $query->num_rows() > 0 ? max(array_column($query->result_array(), 'version')) : 0;
        
        $this->config->set_item('migration_version', $latest_version);

        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migration executed successfully';
        }
    }
}
?>
