<?php

namespace App\Libraries;

use Laminas\Filter\Word\CamelCaseToUnderscore;
use Laminas\Filter\Word\UnderscoreToCamelCase;

/**
 * 
 * 
 */

class Utils
{
    /**
     * This filter modifies a given string such that CamelCaseWords are converted to Camel_Case_Words.
     * */
    public static function camelToSnake($data, $prefix = '')
    {
        $data = json_decode(json_encode($data), TRUE);
        if (is_array($data)) {
            $results = [];
            foreach ($data as $key => $value) {
                $camelCaseToSeparatorFilter = new CamelCaseToUnderscore();
                $result = $camelCaseToSeparatorFilter->filter($key);
                $result = strtolower($result);
                if ($prefix != '') {
                    $result = $prefix . '_' . $result;
                }
                $results[$result] = $value;
            }
            return $results;
        } else {
            $camelCaseToSeparatorFilter = new CamelCaseToUnderscore();
            $result = $camelCaseToSeparatorFilter->filter($data);
            $result = strtolower($result);
            if ($prefix != '') {
                $result = $prefix . '_' . $result;
            }
            return $result;
        }
    }

    /**
     * This filter modifies a given string such that words_with_underscores are converted to WordsWithUnderscores.
     * */
    public static function snakeToCamel($data, $removePrefix = '', $lcfirst = true)
    {
        $data = json_decode(json_encode($data), TRUE);
        if (is_array($data)) {
            if (self::isArrayMulti($data)) {
                $returnData = [];
                foreach ($data as $keyData => $valueData) {
                    $results = [];
                    foreach ($valueData as $key => $value) {

                        if ($removePrefix != '') {
                            $countLength = strlen($removePrefix);
                            $filter = strtolower(substr($key, 0, $countLength));
                            if (strtolower($removePrefix) == $filter) {
                                $newKey = substr($key, $countLength);
                            } else {
                                $newKey = $key;
                            }
                        } else {
                            $newKey = $key;
                        }

                        $underscoreToCamelCaseFilter = new UnderscoreToCamelCase();
                        $result = $underscoreToCamelCaseFilter->filter($newKey);
                        if ($lcfirst) {
                            $results[lcfirst($result)] = $value;
                        } else {
                            $results[ucwords($result)] = $value;
                        }
                    }
                    array_push($returnData, $results);
                }
                return $returnData;
            } else {
                $results = [];
                foreach ($data as $key => $value) {

                    if ($removePrefix != '') {
                        $countLength = strlen($removePrefix);
                        $filter = strtolower(substr($key, 0, $countLength));
                        if (strtolower($removePrefix) == $filter) {
                            $newKey = substr($key, $countLength);
                        } else {
                            $newKey = $key;
                        }
                    } else {
                        $newKey = $key;
                    }

                    $underscoreToCamelCaseFilter = new UnderscoreToCamelCase();
                    $result = $underscoreToCamelCaseFilter->filter($newKey);

                    if ($lcfirst) {
                        $results[lcfirst($result)] = $value;
                    } else {
                        $results[ucwords($result)] = $value;
                    }
                }
                return $results;
            }
        } else {

            if ($removePrefix != '') {
                $countLength = strlen($removePrefix);
                $filter = strtolower(substr($data, 0, $countLength));
                if (strtolower($removePrefix) == $filter) {
                    $newKey = substr($data, $countLength);
                }
            } else {
                $newKey = $data;
            }

            $underscoreToCamelCaseFilter = new UnderscoreToCamelCase();
            $result = $underscoreToCamelCaseFilter->filter($data);

            if ($lcfirst) {
                return lcfirst($result);
            } else {
                return ucwords($result);
            }
        }
    }

    /**
     * 
     * remove characters other than letters and numbers and sign (-)
     * */
    public static function hject($text = '')
    {
        return preg_replace("/\-[^a-zA-Z0-9]+/", "", $text);
    }

    static function isArrayMulti($arr)
    {
        $multi = false;
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
