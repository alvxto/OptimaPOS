<?php namespace BackEnd\Role\Models;

class RoleMenu extends \App\Core\BaseModel
{
    protected $table        = 'role_menus';
    protected $primaryKey   = 'role_menu_id';
    
    protected $allowedFields= [
        'role_menu_id',
        'role_menu_menu_id',
        'role_menu_role_id'
    ];

}