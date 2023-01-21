<?php

namespace BackEnd\Satuan\Models;

class Satuan extends \App\Core\BaseModel
{
    protected $table        = 'satuan';
    protected $primaryKey   = 'satuan_id';

    protected $allowedFields = [
        'satuan_id',
        'satuan_kode',
        'satuan_nama',
        'satuan_aktif',
        'satuan_created_at',
        'satuan_updated_at',
        'satuan_created_by'
    ];

    protected $view = [
        'satuan' => [
            'datatable' => [
                'satuan_id',
                'satuan_kode',
                'satuan_nama',
                'satuan_aktif',
            ]
        ]
    ];

    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'satuan_aktif',
    ];
}
