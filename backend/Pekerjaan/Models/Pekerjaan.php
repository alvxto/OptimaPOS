<?php

namespace BackEnd\Pekerjaan\Models;

class Pekerjaan extends \App\Core\BaseModel
{
    protected $table        = 'pekerjaan';
    protected $primaryKey   = 'pekerjaan_id';
    protected $fieldPrefix  = 'pekerjaan';

    protected $allowedFields = [
        'pekerjaan_id',
        'pekerjaan_kode',
        'pekerjaan_name',
        'pekerjaan_program_id',
        'pekerjaan_kegiatan_id',
        'pekerjaan_kegiatan_sub_id',
        'pekerjaan_rekanan_id',
        'pekerjaan_rekanan_detail',
        'pekerjaan_penata_usaha_keuangan_id',
        'pekerjaan_penata_usaha_keuangan_detail',
        'pekerjaan_pembuat_komitmen_id',
        'pekerjaan_pembuat_komitmen_detail',
        'pekerjaan_pelaksana_teknis_id',
        'pekerjaan_pelaksana_teknis_detail',
        'pekerjaan_bendahara_pengeluaran_id',
        'pekerjaan_bendahara_pengeluaran_detail',
        'pekerjaan_pengguna_anggaran_id',
        'pekerjaan_pengguna_anggaran_detail',
        'pekerjaan_ppn',
        'pekerjaan_jenis_pph_id',
        'pekerjaan_created_at',
        'pekerjaan_updated_at',
        'pekerjaan_created_by',
        'pekerjaan_sumber_dana_id',
        'pekerjaan_is_include_ppn',
        'pekerjaan_jenis_kontrak',
        'pekerjaan_tahun_anggaran',
        'pekerjaan_lokasi',
        'pekerjaan_surat_undangan_no',
        'pekerjaan_surat_undangan_tgl',
        'pekerjaan_surat_penunjukan_no',
        'pekerjaan_surat_penunjukan_tgl',
        'pekerjaan_ssk',
        'pekerjaan_ssuk',
    ];

    protected $view = [
        'v_pekerjaan' => [
            'datatable' => [
                'pekerjaan_id',
                'pekerjaan_name',
                'status',
                'pekerjaan_created_at',
            ]
        ],
        'v_role_menus' => [
            'roles' => ['menu_id', 'menu_code', 'menu_level']
        ],
        'v_pekerjaan_all' => '*'
    ];
}
