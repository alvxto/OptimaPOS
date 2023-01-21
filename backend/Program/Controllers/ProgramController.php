<?php

namespace BackEnd\Program\Controllers;

use BackEnd\Program\Models\Program;
use Exception;

class ProgramController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Program(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Program())->find($data['id']);
		return $this->respondToCamel($operation, 'program');
	}

	public function store()
	{
		$data = getVar(null, 'program');
		$data['program_aktif'] = ((isset($data['program_aktif']) && $data['program_aktif'] == 1) ? 1 : 0);
		$data['program_created_at'] = date('Y-m-d H:i:s');
		$data['program_created_by'] = session()->UserId;
		$operation = (new Program())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'program');
		$data['program_aktif'] = ((isset($data['program_aktif']) && $data['program_aktif'] == 1) ? 1 : 0);
		$data['program_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Program())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Program())->delete($data['id']);
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
