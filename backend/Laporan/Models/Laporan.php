<?php

namespace BackEnd\Laporan\Models;

class Laporan extends \App\Core\BaseModel
{
    protected $table        = '';
    protected $primaryKey   = 'pekerjaan_id';
    protected $fieldPrefix  = '';

    protected $allowedFields = [];

    protected $view = [
        'v_laporan' => [
            'datatable' => [
                'pekerjaan_id',
                'program_nama',
                'kegiatan_nama',
                'kegiatan_sub_nama',
                'pekerjaan_name',
                'pekerjaan_program_id',
                'pekerjaan_kegiatan_id',
                'pekerjaan_kegiatan_sub_id',
                'pekerjaan_dokumen_type',
            ]
        ],
        'v_role_menus' => [
            'roles' => ['menu_id', 'menu_code', 'menu_level']
        ]
    ];

    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'pekerjaan_program_id',
        'pekerjaan_kegiatan_id',
        'pekerjaan_kegiatan_sub_id',
    ];
}
