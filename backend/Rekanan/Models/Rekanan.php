<?php

namespace BackEnd\Rekanan\Models;

class Rekanan extends \App\Core\BaseModel
{
    protected $table        = 'rekanan';
    protected $primaryKey   = 'rekanan_id';
    protected $fieldPrefix  = 'rekanan';

    protected $allowedFields = [
        'rekanan_id',
        'rekanan_kode',
        'rekanan_nama',
        'rekanan_nama_perusahaan',
        'rekanan_alamat',
        'rekanan_kota',
        'rekanan_jabatan',
        'rekanan_npwp',
        'rekanan_akte',
        'rekanan_tgl_akte',
        'rekanan_pembuat_akte',
        'rekanan_kop_surat',
        'rekanan_telepon',
        'rekanan_email',
        'rekanan_rekening',
        'rekanan_bank',
        'rekanan_create_at',
        'rekanan_update_at',
        'rekanan_deleted_at',
    ];

    protected $view = [
        'v_rekanan' => [
            'datatable' => [
                'rekanan_id',
                'rekanan_nama_perusahaan',
                'rekanan_nama',
                'rekanan_jabatan',
            ]
        ],
        'v_role_menus' => [
            'roles' => ['menu_id', 'menu_code', 'menu_level']
        ]
    ];
}
