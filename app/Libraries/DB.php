<?php

namespace App\Libraries;

use CodeIgniter\HTTP\RequestInterface;

class DB
{

    protected $syntaxQuery = '';

    function __construct(RequestInterface $request = null)
    {
        $this->db = db_connect();
        $this->request = $request;
    }

    /**
     * 
     * DB Transaction
     * Create datatable with query manual 
     * */
    static function transaction($callback = '')
    {
        $db = \Config\Database::connect();
        $db->transStart();

        if (is_callable($callback)) {
            call_user_func($callback, $callback);
        }

        $db->transComplete();

        return [
            'success' => $db->transStatus(),
            'message' => ($db->transStatus() === false) ? 'transaction error' : 'transaction success',
        ];
    }

    /**
     * 
     * @param syntax query
     * 
     * */
    public function rawQuery($query = '')
    {
        $this->syntaxQuery = $query;
        return $this;
    }

    /**
     * 
     * 
     * 
     * */
    public function draw($isObject = false, $setAutoNumber = true)
    {
        $request = $this->request->getPost();

        if ($this->request->getMethod(true) === 'POST') {
            $bindings = array();
            $table         = self::fieldName($this->syntaxQuery);
            $limit         = self::limit($request, $this->getColumn($table));
            $order         = self::order($request, $this->getColumn($table));
            $where      = self::filter($request, $this->getColumn($table), $bindings);

            $fromWhere          = self::strAfter($this->syntaxQuery, 'FROM');
            $recordsTotal      =  $this->db->query("SELECT COUNT(*) AS total FROM {$table}")->getResultArray()[0]['total'];
            $recordsFiltered =  $this->db->query("SELECT COUNT(*) AS total FROM {$fromWhere}")->getResultArray()[0]['total'];

            // get primary key
            $primaryKey = $this->getPrimaryKey($table);
            $query = "
                    {$this->syntaxQuery}
                    {$order}
                    {$limit}
                ";

            $lists = $this->db->query($query)->getResult();

            $data  = [];
            $no    = $this->request->getPost('start');

            if ($isObject) {
                $data = $lists;
            } else {
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $i = 0;
                    $ID = (isset($list->{$primaryKey})) ? $list->{$primaryKey} : null;
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

    static function strAfter($subject, $search)
    {
        if ($search == '') {
            return $subject;
        }
        $pos = strpos($subject, $search);
        if ($pos === false) {
            return $subject;
        }
        return substr($subject, $pos + strlen($search));
    }

    static function fieldName($query = '')
    {
        $string = substr($query, strpos($query, "FROM") + 4);
        return array_values(array_filter(explode(' ', $string)))[0];
    }

    static function limit($request, $columns)
    {
        $limit = '';
        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }
        // with postgress
        /*if (isset($request['start']) && $request['length'] != -1) {
            $limit = "OFFSET " . intval($request['start']) . " LIMIT " . intval($request['length']);
        }*/

        return $limit;
    }

    static function order($request, $columns)
    {
        $order = '';

        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';
                    $orderBy[] = $column . ' ' . $dir;
                }
            }

            if (count($orderBy)) {
                $order = 'ORDER BY ' . implode(', ', $orderBy);
            }
        }

        return $order;
    }

    static function filter($request, $columns, &$bindings)
    {
        $globalSearch = array();
        $columnSearch = array(); //all columns, both db and dt keys
        $dtColumns = self::pluck($columns, 'dt');     // get all dt keys  

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];
            for ($i = 0, $ien = count($dtColumns); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$i];

                if ($requestColumn['searchable'] == 'true') {
                    $binding = self::bind($bindings, '%' . $str . '%', '');
                    $globalSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
                }
            }
        }

        for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$i];
            $str = $requestColumn['search']['value'];
            if ($requestColumn['searchable'] == 'true' && $str != '') {
                $binding = self::bind($bindings, '%' . $str . '%', '');
                $columnSearch[] = "" . $column . " LIKE " . $binding;
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }
        return $where;
    }

    static function pluck($a, $prop)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            if (empty($a[$i][$prop])) {
                continue;
            }
            //removing the $out array index confuses the filter method in doing proper binding,
            //adding it ensures that the array data are mapped correctly
            $out[$i] = $a[$i][$prop];
        }

        return $out;
    }

    static function bind(&$a, $val, $type = '')
    {
        $key = ':binding_' . count($a);

        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );

        return $key;
    }

    function getPrimaryKey($tableName)
    {
        $fields = (array) $this->db->getFieldData($tableName);
        foreach ($fields as $key => $value) {
            if ($value->primary_key) {
                return $value->name;
                exit;
            }
        }
    }

    function getColumn($tableName)
    {
        return $this->db->getFieldNames($tableName);
    }
}
