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

    /**
     * Nesta versão trata votos de BU com apenas 1 qrcode
     */
    public function qrcode()
    {
        //qrcode de exemplo
        $qrcode = "QRBU:1:4 VRQR:1.5 VRCH:20240507 ORIG:VOTA ORLC:LEG PROC:
        1000 DTPL:20241006 PLEI:1100 TURN:1 FASE:S UNFE:ACMUNI:1392 
        ZONA:9 SECA:22 IDUE:2033200 IDCA:216820571350570928893711 
        HIQT:1
        HICA:1:216820571350570928893711 VERS:9.21.0.0 LOCA:4 APTO:559 
        APTS:559 APTT:0 COMP:504 FALT:55 DTAB:20241006 HRAB:091502 
        DTFC:20241006 HRFC:170042 IDEL:1101 CARG:13 TIPO:1 VERC:202
        406131529 PART:91 91001:1 91002:1 91003:4 91004:1 91005:3 91006:3 
        91007:1 91009:1 91010:1 91011:1 91012:3 91013:1 91014:2 91015:2 91987:58 
        91018:1 91020:3 91022:5 91024:2 91025:2 91026:3 91027:3 91028:2 
        91029:1 91030:2 91031:1 91032:1 91033:2 91034:1 91035:1 91036:1 
        91037:2 91038:2 91039:5 91040:3 91043:1 91044:4 91045:1 91046:3 
        91047:2 91048:1 91049:2 91050:1 91051:3 91052:2 91054:2 91055:2 
        91056:3 91057:1 91059:3 LEGP:0 TOTP:99 PART:92 92001:2 92002:3 
        92003:2 92004:3 92005:2 92006:2 92007:1 HASH:C84EAF7AEC9D9
        5CD157B5F00206C708B0E6BB67226098903B0050F12D3BEFF
        79B7EF6025FBA22 54E388E264511816BC270EB8701FC9455170F
        D905BFC6E19628";

        //remove espaços duplos
        $qrcode = str_replace("  "," ", $qrcode);

        // montar um array com todos os dados do qrcode
         $explode = explode(" ", $qrcode);

        $i = 0;
        $isvotos = false;
        $partido = '';
        for($i ; $i < count($explode); $i++){
            //busca separador ':' para separar chave e valor da propriedade
            $position_separator = stripos($explode[$i],":");
            // separar nome do campo
            $campo = trim(substr($explode[$i], 0, $position_separator));
            // pula mais uma posição para depois do ':'
            $position_separator ++;
            // captura valor do campo
            $valor = substr($explode[$i], $position_separator);
            
            if($isvotos === true){
                if($campo == "APTA" || $campo == "LEGP" || $campo == "TOTP"){
                    $isvotos = false;
                }else{
                    echo sprintf("Partido: %s -> Candidato: %s -> votos: %s\n",$partido,$campo,$valor);
                    $data [] = [
                        'partido' => $partido,
                        'num_candidato' => $campo,
                        'qtd_votos' => $valor
                    ];
                }
                
            }
            
            //busca variavel de cargo
            if($campo === 'CARG'){
                // próxima cahve é tipo de cargo
                //TIPO:n Tipo: 0 – Majoritário; 1 – Proporcional; 2 – Consulta.
                $i ++;
                $tipo_cargo = $explode[$i];
                //próxima cahve é VERC - Versão do pacote de dados de candidatos/consulta
                $i++;
                
                // próxima chave é a do partido
                $i ++;
                $partido = $explode[$i];
                
                $isvotos = true;
                continue;
                    
                //se cargo for proporcional mostra PART, LEGP e TOTP
                if($tipo_cargo === 1){
                    
                }
                
                
                
            }
            
        //	echo sprintf("%s -> %s\n", $campo, $valor);
            
            // print_r($explode[$i]);
        }
        

    }
}
