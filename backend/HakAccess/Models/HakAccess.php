<?php

namespace BackEnd\HakAccess\Models;

class HakAccess extends \App\Core\BaseModel
{
    public function getMenuList($init, $roleId)
    {
        $query = "SELECT *,
                (
                    SELECT DISTINCT v_role_menus.role_menu_id FROM v_role_menus 
                    WHERE 
                        v_role_menus.menu_id = menus.menu_id AND v_role_menus.role_id = '{$roleId}' 
                        AND v_role_menus.menu_level = 3
                ) AS menu_selected,
                (
                    SELECT DISTINCT v_role_menus.role_menu_id FROM v_role_menus 
                    WHERE 
                        v_role_menus.menu_id = menus.menu_id AND v_role_menus.role_id = '{$roleId}' 
                        AND v_role_menus.menu_level = 2
                ) AS selected,
                (
                    SELECT DISTINCT COUNT(m.menu_id) FROM menus AS m WHERE 
                        m.menu_parent = menus.menu_id
                ) AS child
            FROM menus
            WHERE menus.menu_active = 1

            AND (SELECT
            CASE 
                WHEN ms.menu_active = 1  THEN 'Active'
                ELSE 'Non Active'
            END
            FROM menus AS ms WHERE 
                ms.menu_id=menus.menu_parent
            ) = 'Active'
            
            OR
            
            (SELECT
                CASE 
                    WHEN ms.menu_active = 1  THEN 'Active'
                    ELSE 'Non Active'
                END
            FROM menus AS ms WHERE 
                ms.menu_id=menus.menu_parent
            ) IS NULL

            ORDER BY menus.menu_order ASC
        ";

        $menu['data'] = $this->db->query($query)->getResultArray();
        $menu_list = array();
        $setted['data'] = [];

        foreach ($menu['data'] as $key => $value) {
            $parent = ($value['menu_parent'] == null) ? '#' : $value['menu_parent'];
            $state = false;

            if ($init == 'tidak') {
                //  ====================
                if ($value['menu_level'] == 2) {
                    $value['menu_selected'] = ($value['child'] == 0) ? $value['selected'] : null;
                }
                //  ====================
                $state = (is_null($value['menu_selected']) ? false : true);
            }

            array_push($menu_list, array(
                'id' => $value['menu_id'],
                'parent' => $parent,
                'text' => $value['menu_title'],
                'icon' => $value['menu_icon'],
                'state' => array(
                    "selected" => $state,
                    "opened" => false
                )
            ));
        }

        return [
            'menu' => $menu_list,
            'setted' => $setted['data']
        ];
    }
}
