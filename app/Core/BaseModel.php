<?php

namespace App\Core;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
use App\Libraries\Gen;
use App\Libraries\Utils;

class BaseModel extends Model
{

    protected $db;
    protected $dt;
    protected $request;
    protected $mode = '';

    protected $allowCallbacks = true;
    protected $beforeInsert = ["callBeforeInsert"];
    protected $afterInsert = ["callAfterInsert"];
    protected $beforeUpdate = ["callBeforeUpdate"];
    protected $afterUpdate = ["callAfterUpdate"];
    protected $beforeFind = ["callBeforeFind"];
    protected $afterFind = ["callAfterFind"];
    protected $beforeDelete = ["callBeforeDelete"];
    protected $afterDelete = ["callAfterDelete"];

    protected $beforeInsertData = [];
    protected $afterInsertData = [];
    protected $beforeUpdateData = [];
    protected $afterUpdateData = [];
    protected $beforeFindData = [];
    protected $afterFindData = [];
    protected $beforeDeleteData = [];
    protected $afterDeleteData = [];

    protected $whereRaw = [];

    protected $makeView = false;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }

    public function __set($key, $value = '')
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }

    /**
     * @param string
     * */
    public function setView($view = '')
    {
        $this->makeView = true;
        $this->__set('table', $view);
        return $this;
    }

    /**
     * @param string
     * */
    public function setMode($mode = '')
    {
        if (isset($this->view[$this->__get('table')][$mode])) {
            $this->mode = $mode;
            return $this->select($this->view[$this->__get('table')][$mode]);
        }
        return $this;
    }

    /**
     * Inserts data into the database. If an object is provided,
     * it will attempt to convert it to an array.
     *
     * @param array|object|null $data
     * @param bool|callback     $returnID Whether insert ID should be returned or not. 
     *                          $returnID can be filled function
     * @throws ReflectionException
     *
     */
    public function insert($data = null, $returnID = false, $callback = '')
    {

        $data = (is_object($data)) ? (array) $data : $data;

        if (!isset($data[$this->primaryKey]) || $data[$this->primaryKey] == '') {
            $data[$this->primaryKey] = Gen::key();
        }

        $operation = parent::insert($data, ((is_callable($returnID)) ? false : $returnID));

        $isCallable = false;
        if (is_callable($returnID)) {
            $isCallable = true;
            $call = $returnID;
        }
        if (is_callable($callback)) {
            $isCallable = true;
            $call = $callback;
        }

        if ($isCallable) {
            $return = [
                'success' => $operation,
                'id' => $data[$this->primaryKey],
                'data' => $this->getResultAfterInsert()['data'],
            ];
            call_user_func($call, ($this->returnType == 'object') ? json_decode(json_encode($return)) : $return);
        }

        return $operation;
    }

    /**
     * Updates a single record in the database. If an object is provided,
     * it will attempt to convert it into an array.
     *
     * @param array|int|string|null $id
     * @param array|object|null     $data
     *
     * @throws ReflectionException
     */
    public function update($id = null, $data = null, $callback = ''): bool
    {
        if (is_null($data)) {
            $data = (is_object($id)) ? (array) $id : $id;
            $id = $data[$this->primaryKey];
        } else {
            $data = (is_object($data)) ? (array) $data : $data;
        }

        $operation = parent::update($id, $data);

        if (is_callable($callback)) {
            $return = [
                'success' => $operation,
                'id' => $id,
                'data' => $this->afterUpdateData['data'],
            ];
            call_user_func($callback, ($this->returnType == 'object') ? json_decode(json_encode($return)) : $return);
        }

        return $operation;
    }

    /**
     * Deletes a single record from the database where $id matches
     *
     * @param array|int|string|null $id    The rows primary key(s)
     * @param $purge can be filled function
     */
    public function destroy($id = '', $purge = '')
    {
        try {

            $dataResult = (is_callable($purge)) ? $this->find($id) : $this->beforeDeleteData;
            if (parent::delete($id)) {
                if (is_callable($purge)) {
                    $return = [
                        'success' => true,
                        'id' => $id,
                        'data' => $dataResult,
                    ];
                    call_user_func($purge, ($this->returnType == 'object') ? json_decode(json_encode($return)) : $return);
                }
                return [
                    'success' => true,
                    'code' => 200,
                    'status' => 'Deleted',
                    'errors' => null
                ];
            } else {
                return  [
                    'success' => false,
                    'code' => 404,
                    'status' => 'Resource Not Found',
                    'errors' => $this->errors(),
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => $e->getCode(),
                'status' => $e->getCode(),
                'errors' => (($e->getCode() == 1451) ? explode('(', $e->getMessage())[0] : $e->getMessage())
            ];
        }
    }

    /**
     * Deletes a single record from the database where $id matches
     *
     * @param array|int|string|null $id    The rows primary key(s)
     * @param $purge can be filled function
     */
    public function delete($id = null, $purge = false)
    {
        return $this->destroy($id, $purge);
    }

    // DATA TABLE

    private function getColumn()
    {
        if ($this->mode != '') {
            return $this->view[$this->table][$this->mode];
        } else {
            if (isset($this->view[$this->table]['datatable'])) {
                return $this->view[$this->table]['datatable'];
            } else {
                return $this->db->getFieldNames($this->table);
            }
        }
    }

    private function getDatatablesQuery()
    {
        $i = 0;
        $this->dt->select(implode(",", $this->getColumn()));
        $column = $this->getColumn();
        unset($column[0]);

        $searchColumn = $column;
        if (isset($this->excludeSearchFields) && $this->excludeSearchFields != []) {
            foreach ($searchColumn as $ksc => $vsc) {
                foreach ($this->excludeSearchFields as $kesf => $vesf) {
                    if ($vsc == $vesf) unset($searchColumn[$ksc]);
                }
            }
        }

        foreach ($searchColumn as $item) {
            if ((isset($this->request->getPost('search')['value']))) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    // $this->dt->getFieldNames
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                    // for postgress
                    // $this->dt->like('CAST(' . $item . ' AS text)', $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                    // for postgress
                    // $this->dt->orLike('CAST(' . $item . ' AS text)', $this->request->getPost('search')['value']);
                }

                if (count($searchColumn) - 1 == $i) {
                    $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if (!empty($this->whereRaw)) {
            $this->dt->where($this->whereRaw);
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    function whereRaw($field1 = '', $field2 = '', $field3 = '')
    {
        if ($field1) {
            if (is_array($field1)) {
                $this->whereRaw = $field1;
            } else {
                if ($field1 != '' && $field2 != '' && $field3 != '') {
                    $this->whereRaw = [$field1 . ' ' . $field2 . ' ' . $field3 => null];
                } else {
                    if ($field1 != '' && $field2 != '') {
                        $this->whereRaw = [$field1 => $field2];
                    } else {
                        $this->whereRaw = [$field1 => null];
                    }
                }
            }
        }
        return $this;
    }

    /**
     * @param array|boolean
     * @param bool
     * @param bool
     * */
    public function draw($where = null, $keyAssoc = false, $setAutoNumber = true)
    {
        if (is_array($where)) {
            $this->whereRaw = $where;
        } else {
            if (is_bool($where)) {
                $keyAssoc = $where;
                $setAutoNumber = $keyAssoc;
            }
        }

        $this->dt = $this->db->table($this->table);
        if ($this->request->getMethod(true) === 'POST') {

            $recordsTotal = $this->countAll();
            $recordsFiltered = $this->countFiltered();
            $lists = $this->getDatatables();

            $data  = [];
            $no    = $this->request->getPost('start');

            if ($keyAssoc) {
                foreach ($lists as $list) {
                    $list->rowData = [
                        'id' => (isset($list->{$this->primaryKey})) ? $list->{$this->primaryKey} : null
                    ];
                    $list->no = ($no + 1);
                    $no++;
                }
                $data = $lists;
            } else {
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $i = 0;
                    $ID = (isset($list->{$this->primaryKey})) ? $list->{$this->primaryKey} : null;
                    foreach ($list as $key => $value) {
                        if ($setAutoNumber) {
                            if ($i == 0) {
                                $row[$i] = $no;
                            } else {
                                $row[$i] = $list->{$key};
                            }
                        } else {
                            $row[$i] = $list->{$key};
                        }
                        $i++;
                    }
                    $row['rowData'] = ['id' => $ID];
                    $data[] = (object) $row;
                }
            }

            return [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ];
        } else {
            die('methods must post');
        }
    }

    // END DATA TABLES

    protected function callBeforeInsert(array $data)
    {
        $this->beforeInsertData = $data;
        //log_message("info", "Running method before insert");
        return $data;
    }

    public function getResultBeforeInsert()
    {
        return $this->beforeInsertData;
    }

    protected function callAfterInsert(array $data)
    {
        $this->afterInsertData = $data;
        //log_message("info", "Running method after insert");
        return $data;
    }

    public function getResultAfterInsert()
    {
        return $this->afterInsertData;
    }

    protected function callBeforeUpdate(array $data)
    {
        $this->beforeUpdateData = $data;
        //log_message("info", "Running method before update");
        return $data;
    }

    public function getResultBeforeUpdate()
    {
        return $this->beforeUpdateData;
    }

    protected function callAfterUpdate(array $data)
    {
        $this->afterUpdateData = $data;
        //log_message("info", "Running method after update");
        return $data;
    }

    public function getResultAfterUpdate()
    {
        return $this->afterUpdateData;
    }

    protected function callBeforeFind(array $data)
    {
        $this->beforeFindData = $data;
        //log_message("info", "Running method before find");
        return $data;
    }

    public function getResultBeforeFind()
    {
        return $this->beforeFindData;
    }

    protected function callAfterFind(array $data)
    {
        $this->afterFindData = $data;
        //log_message("info", "Running method after find");
        return $data;
    }

    public function getResultAfterFind()
    {
        return $this->afterFindData;
    }

    protected function callBeforeDelete(array $data)
    {
        $this->beforeDeleteData = $data;
        //log_message("info", "Running method before delete");
        return $data;
    }

    public function getResultBeforeDelete()
    {
        return $this->beforeDeleteData;
    }

    protected function callAfterDelete(array $data)
    {
        $this->afterDeleteData = $data;
        //log_message("info", "Running method after delete");
        return $data;
    }

    public function getResultAfterDelete()
    {
        return $this->afterDeleteData;
    }
}
