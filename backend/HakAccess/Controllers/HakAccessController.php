<?php

namespace BackEnd\HakAccess\Controllers;

use BackEnd\Role\Models\Role;
use BackEnd\Role\Models\RoleMenu;
use BackEnd\HakAccess\Models\HakAccess;

use App\Libraries\Gen;
use App\Libraries\DB;

class HakAccessController extends \App\Core\BaseController
{
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getMenuList($init = 'tidak')
    {
        $roleId = getPost('roleId');
        $operation = (new HakAccess())->getMenuList($init, $roleId);
        return $this->respond($operation);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getRoleList()
    {
        $roles = (new Role())->orderBy('role_name', 'ASC')->findAll();
        return $this->respondFindAll($roles);
    }

    /**
     * Create or update a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function save()
    {
        $data = getPost();
        $roles = $data['roles'];
        $roleId = $data['role_id'];
        $roleMenu = new RoleMenu();

        $operation = $roleMenu->where('role_menu_role_id', $roleId)->delete();
        if ($operation) {
            foreach ($roles as $key => $value) {
                $roleMenu->insert([
                    'role_menu_id' => Gen::key(),
                    'role_menu_role_id' => $roleId,
                    'role_menu_menu_id' => $value
                ]);
            }
        }

        return $this->respond([
            'success' => $operation,
            'reload' => ($roleId == session()->RoleId) ? true : false,
            'roles' => count($roles)
        ]);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function saveRole($value = '')
    {
        $role = getPost('role_name');
        $operation = (new Role())->insert([
            'role_id' => Gen::key(),
            'role_code' => preg_replace('/\s+/', '_', $role),
            'role_name' => $role,
        ]);
        return $this->respondCreated($operation);
    }

    /**
     * Delete a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function destroyRole()
    {
        $role = getPost('role_id');
        $operation = DB::transaction(function () use ($role) {
            (new RoleMenu())->where('role_menu_role_id', $role)->delete();
            $operation =  (new Role())->delete($role);
        });

        return $this->respondDeleted($operation);
    }

    /**
     * Update a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function editRole($value = '')
    {
        $data = getPost();
        $operation = (new Role())->update($data['role_id'], ['role_name' => $data['role_name']]);
        return $this->respondUpdated($operation);
    }
}
