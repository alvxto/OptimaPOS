<?php

namespace BackEnd\Position\Models;

class Position extends \App\Core\BaseModel
{
    protected $table        = 'positions';
    protected $primaryKey   = 'position_id';

    protected $allowedFields = [
        'position_id',
        'position_code',
        'position_name',
        'position_descriptions',
        'position_active',
    ];

    protected $view = [
        'positions' => [
            'datatable' => [
                'position_id',
                'position_code',
                'position_name',
                'position_active',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'position_active',
    ];
}
