<?php

namespace App\Libraries;

use Hidehalo\Nanoid\Client;

class Gen
{

	function __construct($argument = '')
	{
	}

	public static function key($length = '', $alphabet = '', $toLower = true)
	{
		$client 	= new Client();
		$length 	= ($length != '') ? $length : 16;
		$alphabet 	= ($alphabet != '') ? $alphabet : '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$keyGen     = $client->formattedId($alphabet, (int) $length);
		return ($toLower) ? strtolower($keyGen) : $keyGen;
	}
}
