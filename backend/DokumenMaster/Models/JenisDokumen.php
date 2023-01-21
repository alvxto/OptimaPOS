<?php

namespace BackEnd\DokumenMaster\Models;

class JenisDokumen extends \App\Core\BaseModel
{
    protected $table        = 'jenis_dokumen';
    protected $primaryKey   = 'jenis_dokumen_id';

    protected $allowedFields = [
        'jenis_dokumen_id',
        'jenis_dokumen_kode',
        'jenis_dokumen_nama',
        'jenis_dokumen_keterangan',
        'jenis_dokumen_aktif',
    ];
}
