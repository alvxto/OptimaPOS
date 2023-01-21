<?php

namespace BackEnd\SumberDana\Models;

class SumberDana extends \App\Core\BaseModel
{
    protected $table        = 'sumber_dana';
    protected $primaryKey   = 'sumber_dana_id';
    // protected $fieldPrefix  = 'sumber_dana'; 

    protected $allowedFields = [
        'sumber_dana_id',
        'sumber_dana_kode',
        'sumber_dana_nama',
        'sumber_dana_keterangan',
        'sumber_dana_aktif',
        'sumber_dana_created_at',
        'sumber_dana_updated_at'
    ];

    protected $view = [
        'sumber_dana' => [
            'datatable' => [
                'sumber_dana_id',
                'sumber_dana_kode',
                'sumber_dana_nama',
                'sumber_dana_aktif',
            ]
        ]
    ];
    //     'v_role_menus' => [
    //         'roles' => ['menu_id', 'menu_code', 'menu_level']
    //     ]
    // ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'sumber_dana_aktif',
    ];
}
