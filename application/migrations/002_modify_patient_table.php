<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_patient_table extends CI_Migration {

    public function up() {
        $this->dbforge->modify_column('patients', [
            'name' => [
                'name' => 'firstname',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
        ]);

        $fields = [
            'middlename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'array' => TRUE,  
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'array' => TRUE, 
            ],
        ];

        $this->dbforge->add_column('patients', $fields);
    }

    public function down() {
        $this->dbforge->modify_column('patients', [
            'firstname' => [
                'name' => 'name',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
        ]);

        // Remove 'middlename' and 'lastname' columns
        $this->dbforge->drop_column('patients', 'middlename');
        $this->dbforge->drop_column('patients', 'lastname');
    }
}
?>
