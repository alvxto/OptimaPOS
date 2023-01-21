<?php namespace BackEnd\Test\Controllers;

use BackEnd\Test\Models\Test;
use \App\Libraries\DB;

class TestController extends \App\Core\BaseController
{

	/**
	 * create datatable serverside with query manual
	 * */
	public function table()
	{
		$operation = (new DB(request()))->rawQuery("SELECT * FROM tests")->draw(false);
		return $this->respond($operation);
	}

	/**
	 * generate id
	 * */
	public function nanoid()
	{
		for ($i=0; $i < 10; $i++) { 
			echo self::key().'<br />';
		}
	}

	/**
	 * draw table
	 * @return array
	 * */
	public function index()
	{
		$operation = (new Test(request()))->draw(false);
		return $this->respond($operation);
	}

	/**
	 * @return array
	 * */
	public function find()
	{
		$operation = (new Test())->find();
		dd($operation);
	}

	/**
	 * @return array
	 * */
	public function findAll()
	{
		$operation = (new Test())->where('id','IeJfAABtqZJQUJzx')->findAll();
		dd($operation);
	}

	/**
	 * insert data
	 * @return array
	 * */
	public function store()
	{
		$data = [];
		$operation = (new Test())->insert([
			'id' => self::key(),
			'code' => self::key(),
			'name' => self::key(). 'Name',
			'active' => 1
		], function($response) use($data) {
			echo "<pre>";
			print_r($response);
		});
		dd($operation);
	}

	/**
	 * update data
	 * @return array
	 * */
	public function update()
	{
		$data = [];
		$operation = (new Test())->update('Il6eXRKTlAJCqDDy', ['name' => self::key(). 'Name'], function($response) use($data) {
			echo "<pre>";
			print_r($response);
		});
		dd($operation);
	}

	/**
	 * deleted data
	 * @return array
	 * */
	public function destroy()
	{
		$data = [];
		$operation = (new Test())->destroy('PUmEEKTasrEysaak', function($response) use($data){
			echo "<pre>";
			print_r($response);
		});
		dd($operation);
	}

	public function trans()
	{
		$data = [];
		$operation = self::transaction(function() use($data) {
			$get = (new Test())->findAll();
			echo "<pre>";
			print_r($get);
		});
		dd($operation);
	}
}