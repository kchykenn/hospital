<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_patients_profile_image extends CI_Migration {

    public function up() {
        
        $fields = [
            'profile_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'array' => TRUE,  
            ],
        ];

        $this->dbforge->add_column('patients', $fields);
    }

    public function down() {
        $this->dbforge->drop_column('patients', 'profile_image');
    }
}
?>
