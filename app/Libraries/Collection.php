<?php

namespace App\Libraries;

/**
 * Class manipulation data array
 * This Function Under Development
 * 
 * EXAMPLE
 * 
 * ->where('type','data')
 * ->orderBy('name','ASC')
 * ->unset(['name','kode'])
 * 
 */

class Collection
{
    protected $dataArray = [];
    protected $where = [];

    function __construct($data = '')
    {
        $this->dataArray = $data;
    }

    public function setData($data = '')
    {
        $this->dataArray = $data;
        return $this;
    }

    public function orderby($ke, $value = null)
    {
    }

    public function where($key = '', $value = null)
    {
        if (!is_null($value)) {
            $key = [$key => $value];
        }
        $this->where = $key;
        return $this;
    }

    public function whereNotIn($key)
    {

        return $this;
    }

    public function unset()
    {

        return $this;
    }

    public function first()
    {
        $data = $this->dataArray;

        if (!empty($this->where)) {
            foreach ($data as $item) {
                $isMatch = true;
                foreach ($this->where as $key => $value) {
                    if (is_object($item)) {
                        if (!isset($item->$key)) {
                            $isMatch = false;
                            break;
                        }
                    } else {
                        if (!isset($item[$key])) {
                            $isMatch = false;
                            break;
                        }
                    }

                    if (is_object($item)) {
                        if ($item->$key != $value) {
                            $isMatch = false;
                            break;
                        }
                    } else {
                        if ($item[$key] != $value) {
                            $isMatch = false;
                            break;
                        }
                    }
                }

                if ($isMatch) {
                    return $item;
                }
            }
        } else {
            return $data[0];
        }

        return false;
    }

    public function find($match = '')
    {
        $data = $this->dataArray;
        $matching = ($match != '') ? $match : $this->where;
        foreach ($data as $item) {
            $isMatch = true;
            foreach ($matching as $key => $value) {
                if (is_object($item)) {
                    if (!isset($item->$key)) {
                        $isMatch = false;
                        break;
                    }
                } else {
                    if (!isset($item[$key])) {
                        $isMatch = false;
                        break;
                    }
                }

                if (is_object($item)) {
                    if ($item->$key != $value) {
                        $isMatch = false;
                        break;
                    }
                } else {
                    if ($item[$key] != $value) {
                        $isMatch = false;
                        break;
                    }
                }
            }

            if ($isMatch) {
                return $item;
            }
        }
        return false;
    }


    public function findAll(int $limit = 0, int $offset = 0)
    {
        $return = array();
        foreach ($this->dataArray as $item) {
            $isMatch = true;
            foreach ($this->where as $key => $value) {

                if (is_object($item)) {
                    if (!isset($item->$key)) {
                        $isMatch = false;
                        break;
                    }
                } else {
                    if (!isset($item[$key])) {
                        $isMatch = false;
                        break;
                    }
                }

                if (is_object($item)) {
                    if ($item->$key != $value) {
                        $isMatch = false;
                        break;
                    }
                } else {
                    if ($item[$key] != $value) {
                        $isMatch = false;
                        break;
                    }
                }
            }

            if ($isMatch) {
                array_push($return, $item);
            }
        }
        return $return;
    }
}
