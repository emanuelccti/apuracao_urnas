<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBoletimUrna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_qr_code' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11
            ],
            'id_bu' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'content_qr' => [
                'type' => 'TEXT'
            ],
            'indice_qrcode' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_qr_code', true);
        $this->forge->addForeignKey('id_bu', 'bu', 'id_bu');
        $this->forge->createTable('qr_codes');
    }

    public function down()
    {
        $this->forge->dropTable('qr_codes');
    }
}
