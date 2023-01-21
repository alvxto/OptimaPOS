<?php

namespace App\Core;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use CodeIgniter\API\ResponseTrait;

use \App\Libraries\Gen;
use \App\Libraries\DB;
use \App\Libraries\Utils;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{

	use ResponseTrait;

	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	protected $db;
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->db = db_connect();

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();

		helper([
			'System_helper'
		]);

	}

	static function key($length = '', $alphabet = '')
	{
		return Gen::key($length = '', $alphabet = '');
	}

	static function transaction($callback = '')
	{
		return DB::transaction($callback);
	}

	protected function respondToCamel($data, $prefix = '')
	{
		return $this->respond(Utils::snakeToCamel($data, $prefix));
	}

	protected function respondCreated($id = '')
	{
		if (is_array($id)) {
			return $this->respond([
				'success' => $id['success'],
				'message' => ($id['success']) ? 'Successfully saved data.' : $id['message']
			]);
		}else{
			return $this->respond([
				'success' => ($id) ? true : false,
				'message' => ($id) ? 'Successfully saved data.' : 'Failed to save data.'
			]);
		}		
	}

	protected function respondUpdated($id = '')
	{
		if (is_array($id)) {
			return $this->respond([
				'success' => $id['success'],
				'message' => ($id['success']) ? 'Successfully changed data.' : $id['message']
			]);
		}else{
			return $this->respond([
				'success' => ($id) ? true : false,
				'message' => ($id) ? 'Successfully changed data.' : 'Failed to update data.'
			]);
		}
	}

	protected function respondDeleted($id = '')
	{
		if (is_array($id)) {
			return $this->respond([
				'success' => $id['success'],
				'message' => ($id['success']) ? 'Successfully deleted data.' : $id['message']
			]);
		}else{
			return $this->respond([
				'success' => ($id) ? true : false,
				'message' => ($id) ? 'Successfully deleted data.' : 'Failed to delete data, There was an error on the server.'
			]);
		}
	}

	protected function respondFindAll($data = [])
	{
		return $this->respond([
			'success' => true,
			'total' => count($data),
			'data' => $data
		]);
	}

	protected function respondFind($data = [])
	{
		return $this->respond($data);
	}

	protected function respondFirst($data = [])
	{
		return $this->respond($data);
	}

	/*public function uploadFile($path = '', $validationRule = '')
    {
        if ($_FILES['file']['name'] != '') {
            if (! $this->validate($validationRule)) {
                $operation = [
                    'success' => false,
                    'title' => 'Failed',
                    'message' => $this->validator->getErrors()['file']
                ];
            }

            $file = $this->request->getFile('file');
            $randomFileName = $file->getRandomName();

            $uploadSuccess = false;
            if (! $file->hasMoved()) {
                $file->move($path, $randomFileName);
                $uploadSuccess = true;
            } 
            return [
                'success' => $uploadSuccess,
                'id'    => $randomFileName,
                'origin_name' => $file->getClientName(),
            ];
        }else{
            return [
                'success' => false,
                'id'    => ''
            ];
        }
    }*/
}
