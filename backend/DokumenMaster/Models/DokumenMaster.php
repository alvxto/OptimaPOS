<?php

namespace BackEnd\DokumenMaster\Models;

class DokumenMaster extends \App\Core\BaseModel
{
    protected $table        = 'dokumen';
    protected $primaryKey   = 'dokumen_id';

    protected $allowedFields = [
        'dokumen_id',
        'dokumen_kode',
        'dokumen_nama',
        'dokumen_tipe',
        'dokumen_keterangan',
        'dokumen_aktif',
        'dokumen_template',
    ];

    protected $view = [
        'v_dokumen_master' => [
            'datatable' => [
                'dokumen_id',
                'dokumen_kode',
                'dokumen_nama',
                'dokumen_tipe',
                'dokumen_aktif',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'dokumen_aktif',
    ];
}
