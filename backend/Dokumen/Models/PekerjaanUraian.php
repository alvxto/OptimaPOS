<?php

namespace BackEnd\Pekerjaan\Models;

class PekerjaanUraian extends \App\Core\BaseModel
{
    protected $table        = 'pekerjaan_uraian';
    protected $primaryKey   = 'pekerjaan_uraian_id';
    protected $fieldPrefix  = 'pekerjaan_uraian';

    protected $allowedFields = [
        'pekerjaan_uraian_id',
        'pekerjaan_uraian_pekerjaan_id',
        'pekerjaan_uraian_nama',
        'pekerjaan_uraian_qty',
        'pekerjaan_uraian_satuan_id',
        'pekerjaan_uraian_harga',
    ];
}
