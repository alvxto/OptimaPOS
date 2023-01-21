<?php

namespace BackEnd\Pekerjaan\Models;

class PekerjaanJenisDokumen extends \App\Core\BaseModel
{
    protected $table        = 'pekerjaan_jenis_dokumen';
    protected $primaryKey   = 'pekerjaan_jenis_dokumen_id';
    // protected $fieldPrefix  = 'pekerjaan_jenis_dokumen';

    protected $allowedFields = [
        'pekerjaan_jenis_dokumen_id',
        'pekerjaan_jenis_dokumen_pekerjaan_id',
        'pekerjaan_jenis_dokumen_jenis_dokumen_id',
        'pekerjaan_jenis_dokumen_pembayaran',
        'pekerjaan_jenis_dokumen_created_at',
    ];

    protected $view = [
        'v_pekerjaan_jenis_dokumen_all' => '*'
    ];
}
