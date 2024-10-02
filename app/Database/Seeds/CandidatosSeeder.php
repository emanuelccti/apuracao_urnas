<?php

namespace App\Database\Seeds;

use App\Models\CandidatoModel;
use CodeIgniter\Database\Seeder;

class CandidatosSeeder extends Seeder
{
    public function run()
    {
        $url_file_prefeito = WRITEPATH . 'uploads/tse/CANDIDATOS-CE-2024-prefeitos.csv';
        $handle_prefeitos = fopen($url_file_prefeito, "r");

        $url_file_vereador = WRITEPATH . 'uploads/tse/CANDIDATOS-CE-2024-vereadores.csv';
        $handle_vereador = fopen($url_file_vereador, "r");

        $cabecalho_prefeito = fgetcsv($handle_prefeitos, 1000, ";");
        $cabecalho_vereador = fgetcsv($handle_vereador, 1000, ";");
        try {
            $this->db->transBegin();

            while (($next = fgetcsv($handle_prefeitos, 1000, ";")) !== false) {
                $nome_candidato = mb_convert_encoding($next[0], 'UTF-8', 'Windows-1252');
                $coligacao = mb_convert_encoding($next[1], 'UTF-8', 'Windows-1252');
                $data = [
                    'nome_urna' => $nome_candidato,
                    'num_candidato' => $next[3],
                    'coligacao' => $coligacao,
                    'cod_cargo' => CandidatoModel::CARGO_PREFEITO,
                ];
                $this->db->table('candidatos')->insert($data);
            }

            while (($next = fgetcsv($handle_vereador, 1000, ";")) !== false) {
                $nome_candidato = mb_convert_encoding($next[0], 'UTF-8', 'Windows-1252');
                $coligacao = mb_convert_encoding($next[1], 'UTF-8', 'Windows-1252');
                $data = [
                    'nome_urna' => $nome_candidato,
                    'num_candidato' => $next[3],
                    'coligacao' => $coligacao,
                    'cod_cargo' => CandidatoModel::CARGO_VEREADOR,
                ];
                $this->db->table('candidatos')->insert($data);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();
            print("Falha ao migrar candidatos." . $e->getMessage());
        }
    }
}
