<?php namespace BackEnd\Role\Models;

class Role extends \App\Core\BaseModel
{
    protected $table        = 'roles';
    protected $primaryKey   = 'role_id';
    
    protected $allowedFields= [
        'role_id','role_code','role_name'
    ];

}