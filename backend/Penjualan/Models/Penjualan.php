<?php

namespace BackEnd\Penjualan\Models;

class Penjualan extends \App\Core\BaseModel
{
    protected $table        = 'penjualan';
    protected $primaryKey   = 'penjualan_id';
    // protected $fieldPrefix  = 'penjualan'; 

    protected $allowedFields = [
        'penjualan_id',
    ];
    protected $view = [
        'penjualan' => [
            'datatable' => [
                'penjualan_id',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'penjualan_aktif',
    ];
}
