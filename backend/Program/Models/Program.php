<?php

namespace BackEnd\Program\Models;

class Program extends \App\Core\BaseModel
{
    protected $table        = 'program';
    protected $primaryKey   = 'program_id';
    // protected $fieldPrefix  = 'program'; 

    protected $allowedFields = [
        'program_id',
        'program_kode',
        'program_nama',
        'program_keterangan',
        'program_aktif',
        'program_created_at',
        'program_updated_at',
        'program_created_by'
    ];
    protected $view = [
        'program' => [
            'datatable' => [
                'program_id',
                'program_kode',
                'program_nama',
                'program_keterangan',
                'program_aktif',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'program_aktif',
    ];
}
