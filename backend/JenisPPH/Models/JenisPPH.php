<?php

namespace BackEnd\JenisPPH\Models;

class JenisPPH extends \App\Core\BaseModel
{
    protected $table        = 'jenis_pph';
    protected $primaryKey   = 'jenis_pph_id';
    // protected $fieldPrefix  = 'jenis_pph';

    protected $allowedFields = [
        'jenis_pph_id',
        'jenis_pph_kode',
        'jenis_pph_nama',
        'jenis_pph_keterangan',
        'jenis_pph_aktif',
        'jenis_pph_presentase',
        'jenis_pph_created_at',
        'jenis_pph_updated_at'
    ];

    protected $view = [
        'jenis_pph' => [
            'datatable' => [
                'jenis_pph_id',
                'jenis_pph_kode',
                'jenis_pph_nama',
                'jenis_pph_presentase',
                'jenis_pph_keterangan',
                'jenis_pph_aktif',
            ]
        ]
    ];
    //     'v_role_menus' => [
    //         'roles' => ['menu_id', 'menu_code', 'menu_level']
    //     ]
    // ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'jenis_pph_aktif',
    ];
}
