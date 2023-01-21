<?php

namespace BackEnd\User\Controllers;

use BackEnd\User\Models\User;
use BackEnd\Role\Models\Role;
use BackEnd\Position\Models\Position;

use App\Libraries\Utils;
use App\Libraries\DB;
use App\Libraries\Gen;
use CodeIgniter\Files\File;
use Exception;

class UserController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new User(request()))->setView('v_user_roles')->setMode('datatable')->draw(['user_is_pejabat = 0 OR user_is_pejabat IS NULL' => null], true);
		foreach ($operation['data'] as $key => $value) {
			$operation['data'][$key]->no = ($key + 1);
			$operation['data'][$key]->profile = base_url() . '/manages/file/uploads-users-thumbs-' . $operation['data'][$key]->user_id . '.jpg?' . date('YmdHis');
		}
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new User())->find($data['id']);
		$operation['profile'] = base_url() . '/manages/file/uploads-users-' . $data['id'] . '.jpg?' . date('YmdHis');
		return $this->respondToCamel($operation, 'user');
	}

	public function store()
	{
		$data = getVar(null, 'user');
		$data['user_id'] = Gen::key();

		try {
			if ($data['user_isremoved'] != 1 && $_FILES['photo']['name'] != null) {

				$validationRule = [
					'photo' => [
						'label' => 'Image File',
						'rules' => 'uploaded[photo]'
							. '|is_image[photo]'
							. '|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
							. '|max_size[photo,1000]'
							. '|max_dims[photo,1024,768]',
					],
				];
				if (!$this->validate($validationRule)) {
					new Exception($this->validator->getErrors()['photo']);
				}

				$img = $this->request->getFile('photo');
				if (!$img->hasMoved()) {
					if (file_exists(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg')) {
						unlink(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg');
						unlink(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');
					}

					$operation = \Config\Services::image()
						->withFile($img)
						->resize(100, 100, true, 'height')
						->save(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');

					$operation = $img->move(WRITEPATH . 'uploads/users/', $data['user_id'] . '.jpg');

					$data['user_photo'] = $img->getClientName();
				} else {
					new Exception("Failed to save Photo Profile");
				}
			}
			unset($data['user_isremoved']);
			if ($data['user_password'] != '') {
				$data['user_password'] = generatePassword($data['user_password']);
			} else {
				$data['user_password'] = generatePassword($data['user_username']);
			}
			$data['user_created_at'] = date('Y-m-d H:i:s');
			$data['user_active'] = ((isset($data['user_active']) && $data['user_active'] == 1) ? 1 : 0);
			$data['user_is_pejabat'] = '0';
			$operation = (new User())->insert($data);
		} catch (\Throwable $th) {
			$operation = [
				'success' => false,
				'message' => $th->getMessage(),
				'title' => 'Error'
			];
		}

		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'user');
		try {
			if ($_FILES['photo']['name'] != null && $data['user_isremoved'] != 1) {
				$validationRule = [
					'photo' => [
						'label' => 'Image File',
						'rules' => 'uploaded[photo]'
							. '|is_image[photo]'
							. '|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
							. '|max_size[photo,1000]'
							. '|max_dims[photo,1024,768]',
					],
				];
				if (!$this->validate($validationRule)) {
					new Exception($this->validator->getErrors()['photo']);
				}

				$img = $this->request->getFile('photo');
				if (!$img->hasMoved()) {
					if (file_exists(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg')) {
						unlink(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg');
						unlink(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');
					}

					$operation = \Config\Services::image()
						->withFile($img)
						->resize(100, 100, true, 'height')
						->save(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');

					$operation = $img->move(WRITEPATH . 'uploads/users/', $data['user_id'] . '.jpg');

					$data['user_photo'] = $img->getClientName();
				} else {
					new Exception("Failed to save Photo Profile");
				}
			} else {
				if ($data['user_isremoved'] == 1) {
					if (file_exists(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg')) {
						unlink(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg');
						unlink(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');
						$data['user_photo'] = NULL;
					}
					unset($data['user_isremoved']);
				}
			}
			$dataU = [
				'user_id' => $data['user_id'],
				'user_name' => $data['user_name'],
				'user_email' => $data['user_email'],
				'user_username' => $data['user_username'],
				'user_telp' => $data['user_telp'],
				'user_role_id' => $data['user_role_id'],
				'user_updated_at' => date('Y-m-d H:i:s'),
				'user_code' => $data['user_code'],
				'user_bidang_id' => $data['user_bidang_id'],
			];

			if (isset($data['user_gender'])) {
				$dataU['user_gender'] = $data['user_gender'];
			}

			if (isset($data['user_active']) && $data['user_active'] == 1) {
				$dataU['user_active'] = 1;
			} else {
				$dataU['user_active'] = null;
			}

			if ($data['user_password'] || $data['user_password'] != '') {
				$dataU['user_password'] = generatePassword($data['user_password']);
			}
			// $data['user_password'] = generatePassword($data['user_password']);
			// $data['user_updated_at'] = date('Y-m-d H:i:s');
			// $data['user_active'] = ((isset($data['user_active']) && $data['user_active'] == 1) ? 1 : 0);
			$operation = (new User())->update($dataU);
		} catch (\Throwable $th) {
			$operation = [
				'success' => false,
				'message' => $th->getMessage(),
				'title' => 'Error'
			];
		}
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = DB::transaction(function () use ($data) {
				$operation = (new User())->delete($data['id']);
				if ($operation['success'] == false) throw new Exception($operation['errors'], $operation['code']);
				if (file_exists(WRITEPATH . 'uploads/users/thumbs/' . $data['id'] . '.jpg')) {
					unlink(WRITEPATH . 'uploads/users/' . $data['id'] . '.jpg');
					unlink(WRITEPATH . 'uploads/users/thumbs/' . $data['id'] . '.jpg');
					$data['user_photo'] = NULL;
				}
			});
			return $this->respondDeleted($operation);
		} catch (\Throwable $th) {
			if ($th->getCode() == '1451') {
				return $this->respondDeleted([
					'success' => false,
					'message' => "Gagal menghapus Data, Data sudah digunakan",
				]);
			} else {
				return $this->respondDeleted([
					'success' => false,
					'message' => "Gagal menghapus Data",
				]);
			}
		}
	}

	public function getData()
	{
		$role = (new Role())->orderBy('role_code', 'ASC')->findAll();
		$position = (new Position())->where('position_active', 1)->orderBy('position_code', 'ASC')->findAll();
		return $this->respond([
			'role' => $role,
			'position' => $position
		]);
	}
}
