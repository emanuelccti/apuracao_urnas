<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBoletimUrnaVotos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_qr_codes_voto' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11
            ],
            'id_qr_code' => [
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
        $this->forge->addKey('id_qr_codes_voto', true);
        $this->forge->addForeignKey('id_qr_code', 'qr_codes', 'id_qr_code');
        $this->forge->createTable('qr_codes_votos');
    }

    public function down()
    {
        $this->forge->dropTable('qr_codes_votos');
    }
}
