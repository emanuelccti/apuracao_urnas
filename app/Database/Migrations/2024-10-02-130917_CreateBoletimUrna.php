<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBoletimUrna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_boletim_urna' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11
            ],
            'qr_code' => [
                'type' => 'TEXT'
            ],
            'indice_qrcode' => [
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
            $this->forge->addKey('id_boletim_urna', true);
            $this->forge->createTable('boletim_urna');
    }

    public function down()
    {
        $this->forge->dropTable('boletim_urna');
    }
}
