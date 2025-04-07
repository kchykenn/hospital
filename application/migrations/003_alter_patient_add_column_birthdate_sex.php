<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_patient_add_column_birthdate_sex extends CI_Migration {

    public function up() {
        
        $fields = [
            'birthdate' => [
                'type' => 'DATE',
                'null' => TRUE,
                'array' => TRUE,  
            ],
            'sex' => [
                'type' => 'CHAR',
                'constraint' => 1,
                'null' => TRUE,
                'array' => TRUE,  
            ],
        ];

        $this->dbforge->add_column('patients', $fields);
    }

    public function down() {
        $this->dbforge->drop_column('patients', 'birthdate');
        $this->dbforge->drop_column('patients', 'sex');
    }
}
?>
