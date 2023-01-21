<?php namespace BackEnd\Changelog\Models;

class Changelog extends \App\Core\BaseModel
{
    protected $table         = 'changelogs';
    protected $primaryKey    = 'changelog_id';
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'changelog_id',
        'changelog_code',
        'changelog_title',
        'changelog_description',
        'changelog_created_at',
        'changelog_updated_at',
        'changelog_created_by',
        'changelog_active'
    ];

    protected $view     = [
        'v_changelogs' => []
    ];
}