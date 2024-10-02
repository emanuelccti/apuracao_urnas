<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCandidatos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_candidato' => [
                'type' => 'INT',
                'contraint' => 11,
                'auto_increment' => true
            ],
            'nome_urna' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'num_candidato' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'coligacao' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'cod_cargo' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ]);
        $this->forge->addKey('id_candidato', true);
        $this->forge->createTable('candidatos');
    }

    public function down()
    {
        $this->forge->dropTable('candidatos');
    }
}
