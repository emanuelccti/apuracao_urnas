<?php

namespace App\Controllers;

use App\Models\CandidatoModel;

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

        return json_encode($array_v);
    }

    public function qrcode()
    {
        $qrcode = "QRBU:4:4 VRQR:1.5 VRCH:20240507 95058:1 95059:2 LEGP:3 TOTP:99 APTA:559 APTS:559 APTT:0 NOMI:499 LEGC:5 BRAN:0 NULO:0 TOTC:504 CARG:11 TIPO:0 VERC:202406 131529 91:102 92:105 93:111 94:95 95:91 APTA:559 APTS:559 APTT:0 NOMI:504 BRAN:0 NULO:0 TOTC:504HASH:27 FF0E01FB973621CAD76FF624B71A396AA858E57 24179A0DA3CC160811F5BF550D85024C75CA54686 901FBC12695D21C2EBDA46EA7D1B2593B4459EAF0BDEF6 ASSI:154D5E3ABD3567C353D144A324BE4D2EFBDB7166 85F3155AB07C2105B3774FCE3262FDCE5 0CE5FBE9582 8EC19141991C04FAA0A91A2C54CDC33E6D0716F1190E";

        $explodeAll = explode(' ', $qrcode);

        dd($explodeAll);

    }
}
