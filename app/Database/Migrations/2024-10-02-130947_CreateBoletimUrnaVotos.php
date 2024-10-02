<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBoletimUrnaVotos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_boletim_urna_voto' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11
            ],
            'id_boletim_urna' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'num_candidato' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'qtd_votos' => [
                'type' => 'BIGINT'
            ],
            'coligacao' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'num_secao' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'cod_cargo' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ]);
        $this->forge->addKey('id_boletim_urna_voto', true);
        $this->forge->addForeignKey('id_boletim_urna', 'boletim_urna', 'id_boletim_urna');
        $this->forge->createTable('boletim_urna_votos');
    }

    public function down()
    {
        $this->forge->dropTable('boletim_urna_votos');
    }
}
