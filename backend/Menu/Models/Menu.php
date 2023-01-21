<?php namespace BackEnd\Menu\Models;

class Menu extends \App\Core\BaseModel
{
    protected $table        = 'menus';
    protected $primaryKey   = 'menu_id';
    protected $useAutoIncrement = false;

    protected $allowedFields= [
        'menu_id',
        'menu_code',
        'menu_title',
        'menu_parent',
        'menu_level',
        'menu_active',
        'menu_order',
        'menu_description',
        'menu_link',
        'menu_created_at',
        'menu_updated_at',
        'menu_module',
        'menu_icon',
        'menu_navbar'
    ];

    private $view = [
        'v_user_menus' => [],
    ];

}