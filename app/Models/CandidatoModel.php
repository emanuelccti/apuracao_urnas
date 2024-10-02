<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidatoModel extends Model
{
    protected $table            = 'candidatos';
    protected $primaryKey       = 'id_candidato';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome_urna',
        'num_candidato',
        'coligacao',
        'cod_cargo',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    //De acordo com manual do tse
    const CARGO_PREFEITO = 11;
    const CARGO_VEREADOR = 13;
    const CARGOS = [
        self::CARGO_PREFEITO => 'Prefeito',
        self::CARGO_VEREADOR => 'Vereador'
    ];

    public function getQtdvotos($candidato)
    {
        $votos = (new BoletimUrnaVotoModel())->where('num_candidato', $candidato->num_candidato)
            ->selectSum('qtd_votos')
            ->get()
            ->getResult();

        return $votos[0]->qtd_votos;
    }
}
