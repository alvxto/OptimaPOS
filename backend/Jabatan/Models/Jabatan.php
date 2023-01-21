<?php

namespace BackEnd\Jabatan\Models;

class Jabatan extends \App\Core\BaseModel
{
    protected $table        = 'jabatan';
    protected $primaryKey   = 'jabatan_id';

    protected $allowedFields = [
        'jabatan_id',
        'jabatan_code',
        'jabatan_name',
        'jabatan_descriptions',
        'jabatan_active',
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'jabatan_active',
    ];
}
