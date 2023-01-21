<?php

namespace BackEnd\BidangProgram\Models;

class BidangKegiatanSub extends \App\Core\BaseModel
{
    protected $table        = 'position_kegiatan_subs';
    protected $primaryKey   = 'position_kegiatan_sub_id';

    protected $allowedFields = [
        'position_kegiatan_sub_id',
        'position_kegiatan_sub_kegiatan_sub_id',
        'position_kegiatan_sub_bidang_id',
    ];

    protected $view = [
        'v_position_kegiatan_sub' => '*'
    ];
}
