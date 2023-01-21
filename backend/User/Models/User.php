<?php

namespace BackEnd\User\Models;

class User extends \App\Core\BaseModel
{
    protected $table        = 'users';
    protected $primaryKey   = 'user_id';
    protected $fieldPrefix  = 'user';

    protected $allowedFields = [
        'user_id',
        'user_name',
        'user_email',
        'user_username',
        'user_password',
        'user_gender',
        'user_telp',
        'user_active',
        'user_role_id',
        'user_photo',
        'user_address',
        'user_lastlogin',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
        'user_position_id',
        'user_code',
        'user_no_dpp',
        'user_tgl_dpp',
        'user_no_dppa',
        'user_tgl_dppa',
        'user_no_skpa',
        'user_no_skppkom_pptk_ppk',
        'user_bidang_id',
        'user_is_pejabat',
    ];

    protected $view = [
        'v_user_roles' => [
            'datatable' => [
                'user_id',
                'user_name',
                'position_name',
                'role_name',
                'user_active',
                'user_email',
            ]
        ],
        'v_role_menus' => [
            'roles' => ['menu_id', 'menu_code', 'menu_level']
        ],
        'v_user_all' => [
            'snapshoot' => [
                'user_id',
                'user_code',
                'user_name',
                'jabatan_name',
                'user_email',
                'user_username',
                'user_gender',
                'user_telp',
                'user_photo',
                'user_address',
                'user_code',
                'user_pangkat',
                'user_position_id',
                'user_no_dpp',
                'user_tgl_dpp',
                'user_no_dppa',
                'user_tgl_dppa',
                'user_no_skpa',
                'user_no_skppkom_pptk_ppk',
                'user_bidang_id',
                'user_active',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'user_password',
        'user_active',
        'user_role_id',
        'user_photo',
        'user_lastlogin',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
        'user_position_id',
        'user_bidang_id',
        'user_is_pejabat',
    ];

    public function getPenggunaAnggaran()
    {
        return $this->db->query("SELECT position_name, position_code, user_id, user_name, user_email, user_username, user_gender, user_telp, user_photo, user_address, user_code, user_pangkat FROM v_user_all WHERE user_code = (SELECT config_value FROM configurations WHERE config_code = 'general.pltCode')")->getResultArray()[0];
    }
}
