<?php

namespace BackEnd\Kategori\Models;

class Kategori extends \App\Core\BaseModel
{
    protected $table        = 'kategori';
    protected $primaryKey   = 'kategori_id';
    // protected $fieldPrefix  = 'kategori'; 

    protected $allowedFields = [
        'kategori_id',
        'kategori_nama',
        'kategori_perusahaan_id',
        'kategori_user_id',
    ];
    protected $view = [
        'kategori' => [
            'datatable' => [
                'kategori_id',
                'kategori_nama',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'kategori_aktif',
    ];
}
