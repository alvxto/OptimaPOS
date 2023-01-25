<?php

namespace BackEnd\Satuan\Models;

class Satuan extends \App\Core\BaseModel
{
    protected $table        = 'satuan';
    protected $primaryKey   = 'satuan_id';
    // protected $fieldPrefix  = 'satuan'; 

    protected $allowedFields = [
        'satuan_id',
        'satuan_nama',
        'satuan_keterangan',
        'satuan_perusahaan_id',
        'satuan_user_id',
    ];
    protected $view = [
        'satuan' => [
            'datatable' => [
                'satuan_id',
                'satuan_nama',
                'satuan_keterangan',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'satuan_aktif',
    ];
}
