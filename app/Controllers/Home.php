<?php

namespace App\Controllers;

use App\Models\BuModel;
use App\Models\CandidatoModel;
use App\Models\QrCodeModel;

class Home extends BaseController
{
    public function index(): string
    {
        $candidatoModel = new CandidatoModel();
        $data['prefeitos'] = $candidatoModel->where('cod_cargo', CandidatoModel::CARGO_PREFEITO)->findAll();
        $data['vereadores'] = $candidatoModel->where('cod_cargo', CandidatoModel::CARGO_VEREADOR)->findAll();
        return view('home', $data);
    }

    public function req_ajax_datatable_vereadores()
    {
        $candidatoModel = new CandidatoModel();
        $candidatos = $candidatoModel->where('cod_cargo', CandidatoModel::CARGO_VEREADOR)->get()->getResult();

        $array_v = [];

        foreach ($candidatos as $cand) {
            $percentual = "XXXX";
            $array_v[] = [
                'partido' => $cand->coligacao,
                'num_cand' => $cand->num_candidato,
                'nome' => $cand->nome_urna,
                'qtd_votos' => $candidatoModel->getQtdvotos($cand),
                'percentual' => $percentual,
            ];
        }

        $response = [
            'vereadores' => $array_v
        ];

        array_multisort(array_column($array_v, 'qtd_votos'), $array_v, SORT_ASC);

        return json_encode($array_v);
    }

    /**
     * Nesta versão trata votos de BU com apenas 1 qrcode
     */
    public function qrcode()
    {
        //qrcode de exemplo
        $bus = (new BuModel())->findAll();

        foreach ($bus as $bu) {
            $qrcodes = (new QrCodeModel())->where('id_bu', $bu['id_bu'])->findAll();

            foreach($qrcodes as $i => $qr){
                $qr['num_secao'] = $bu['num_secao'];

                if($i > 0){
                    $this->readQrCode($qr, true);    
                }
                $this->readQrCode($qr);
            }
        }
    }


    public function readQrCode($qrcode, $next = false)
    {
        //remove espaços duplos
        $qrcode = preg_replace('/\s+/', ' ', $qrcode);

        // montar um array com todos os dados do qrcode
        $explode = explode(" ", $qrcode['content_qr']);

        $i = 0;
        $campos = function () use ($i, $explode) {
            //busca separador ':' para separar chave e valor da propriedade
            $position_separator = stripos($explode[$i], ":");
            // separar nome do campo
            $campo = trim(substr($explode[$i], 0, $position_separator));
            // pula mais uma posição para depois do ':'
            $position_separator++;
            // captura valor do campo
            $valor = substr($explode[$i], $position_separator);

            $result = [
                'campo' => $campo,
                'valor' => $valor
            ];

            return $result;
        };

        for ($i; $i < count($explode); $i++) {

            //busca variavel de cargo
            if ($campos['campo'] === 'CARG' || $next == true) {
                if ($campos['campo'] === 'CARG') {
                    // próxima cahve é tipo de cargo
                    //TIPO:n Tipo: 0 – Majoritário; 1 – Proporcional; 2 – Consulta.
                    $i++;
                    $tipo_cargo = $explode[$i];
                    //próxima cahve é VERC - Versão do pacote de dados de candidatos/consulta
                    $i++;
                    $verc = $explode[$i];

                    $i++;
                }

                if ($next == true) {
                    //pula dados de qr QRBU, VRQR e VRCH
                    $i += 3;
                }

                if ($campos['part'] === 'PART') {
                    // número do partido
                    $num_partido = $campos['valor'];
                    $i++;
                }

                while (!in_array($campos['campo'], ["APTA", "LEGP", "TOTP"])) {
                    echo sprintf("Partido: %s -> Candidato: %s -> votos: %s<br>\n", $campos['campo'], $campos['valor']);
                    $candidato = (new CandidatoModel())->where('num_candidato', $campos['valor']);
                    $data[] = [

                        'id_qr_code' => $qrcode['id_qr_code'],
                        'num_candidato' => $campos['campo'],
                        'qtd_votos' => $campos['valor'],
                        'coligacao' => $candidato['coligacao'],
                        'num_secao' => $qrcode['num_secao'],
                        'cod_cargo' => $candidato['cod_cargo'],
                    ];
                    $i++;
                }
            }
        }
    }
}
