<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSecoes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_secao' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'num_secao' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'cod_local' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'local' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'aptos' => [
                'type' => 'INT',
                'constraint' => 11
            ]
            ]);
            $this->forge->addKey('id_secao', true);
            $this->forge->createTable('secoes');
    }

    public function down()
    {
        $this->forge->dropTable('secoes');

    }
}
