<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bu' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11
            ],
            'idue' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'num_secao' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'qtd_total_qrcode' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_bu', true);
        $this->forge->createTable('bu');
    }

    public function down()
    {
        $this->forge->dropTable('bu');
    }
}
