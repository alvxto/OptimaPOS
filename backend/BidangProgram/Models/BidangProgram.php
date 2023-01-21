<?php

namespace BackEnd\BidangProgram\Models;

class BidangProgram extends \App\Core\BaseModel
{
    protected $table        = 'position_programs';
    protected $primaryKey   = 'position_program_id';

    protected $allowedFields = [
        'position_program_id',
        'position_program_program_id',
        'position_program_bidang_id',
    ];

    protected $view = [
        'v_position_program' => '*'
    ];
}
