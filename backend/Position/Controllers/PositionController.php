<?php

namespace BackEnd\Position\Controllers;

use BackEnd\Position\Models\Position;
use Exception;

class PositionController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Position(request()))->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Position())->find($data['id']);
		return $this->respondToCamel($operation, 'position');
	}

	public function store()
	{
		$data = getVar(null, 'position');
		$data['position_active'] = ((isset($data['position_active']) && $data['position_active'] == 1) ? 1 : 0);
		$data['position_created_at'] = date('Y-m-d H:i:s');
		$data['position_created_by'] = session()->UserId;
		$operation = (new Position())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'position');
		$data['position_active'] = ((isset($data['position_active']) && $data['position_active'] == 1) ? 1 : 0);
		$data['position_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Position())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Position())->delete($data['id']);
			if ($operation['success'] == false) throw new Exception($operation['errors'], $operation['code']);
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
}
