<?php namespace BackEnd\KegiatanSub\Models;

class KegiatanSub extends \App\Core\BaseModel
{
    protected $table        = 'kegiatan_sub';
    protected $primaryKey   = 'kegiatan_sub_id';
    // protected $fieldPrefix  = 'kegiatan_sub'; 
     
    protected $allowedFields = [
            'kegiatan_sub_id',
            'kegiatan_sub_kode',
            'kegiatan_sub_nama',
            'kegiatan_sub_keterangan',
            'kegiatan_sub_kegiatan_id',
            'kegiatan_sub_aktif',
            'kegiatan_sub_created_at',
            'kegiatan_sub_updated_at'
    ];

    protected $view = [
        'v_kegiatan_sub' => [
            'datatable' => [
                'kegiatan_sub_id',
                'kegiatan_sub_kode',
                'kegiatan_sub_nama',
                'kegiatan_nama',
                'kegiatan_sub_aktif',
            ]
        ],
        // 'v_role_menus' => [
        //     'roles' => ['menu_id', 'menu_code', 'menu_level']
        // ]
    ];

    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'kegiatan_sub_aktif',
    ];
}