<?php

namespace BackEnd\BidangProgram\Models;

class BidangKegiatan extends \App\Core\BaseModel
{
    protected $table        = 'position_kegiatans';
    protected $primaryKey   = 'position_kegiatan_id';

    protected $allowedFields = [
        'position_kegiatan_id',
        'position_kegiatan_kegiatan_id',
        'position_kegiatan_bidang_id',
    ];

    protected $view = [
        'v_position_kegiatan' => '*'
    ];
}
