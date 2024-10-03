<?php

namespace App\Database\Seeds;

use App\Models\CandidatoModel;
use CodeIgniter\Database\Seeder;

class SecoesSeeder extends Seeder
{
    public function run()
    {
        $url_file = WRITEPATH . 'uploads/tse/SECOES.csv';
        $handle = fopen($url_file, "r");

        $cabecalho_prefeito = fgetcsv($handle, 1000, ";");

        try {
            $this->db->transBegin();

            while (($next = fgetcsv($handle, 1000, ";")) !== false) {
                $local = mb_convert_encoding($next[2], 'UTF-8', 'Windows-1252');
                $data = [
                    'num_secao' => $next[0],
                    'cod_local' => $next[1],
                    'local' => $local,
                    'aptos' => $next[3],
                ];
                $this->db->table('secoes')->insert($data);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();
            print("Falha ao migrar secoes." . $e->getMessage());
        }
    }
}
