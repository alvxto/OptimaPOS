<?php

namespace BackEnd\Pekerjaan\Models;

class Pekerjaan extends \App\Core\BaseModel
{
    protected $table        = '';
    protected $primaryKey   = '';
    protected $fieldPrefix  = '';

    protected $allowedFields = [
        ''
    ];

    protected $view = [
        'v_pekerjaan' => [
            'datatable' => [
                ''
            ]
        ],
        'v_role_menus' => [
            'roles' => ['menu_id', 'menu_code', 'menu_level']
        ],
        'v_pekerjaan_all' => '*'
    ];
}
