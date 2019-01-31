<?php
/**
 * Class MagicAPIEndpoints
 *
 * @filesource   MagicAPIEndpoints.php
 * @created      01.09.2018
 * @package      chillerlan\HTTPTest\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\HTTPTest\MagicAPI;

use chillerlan\HTTP\MagicAPI\EndpointMap;

class MagicAPIEndpoints extends EndpointMap{

	protected $API_BASE = 'https://httpbin.org';

	protected $get = [
		'path'          => '/get',
		'method'        => 'GET',
		'query'         => [],
		'path_elements' => [],
		'body'          => null,
		'headers'       => [['what' => 'nope']],
	];

	protected $post = [
		'path'          => '/post',
		'method'        => 'POST',
		'query'         => [],
		'path_elements' => [],
		'body'          => [],
		'headers'       => [['what' => 'nope'], ['Content-type' => 'application/x-www-form-urlencoded']],
	];

	protected $put = [
		'path'          => '/put',
		'method'        => 'PUT',
		'query'         => [],
		'path_elements' => [],
		'body'          => [],
		'headers'       => [['what' => 'nope'], ['Content-type' => 'application/json']],
	];

	protected $patch = [
		'path'          => '/patch',
		'method'        => 'PATCH',
		'query'         => [],
		'path_elements' => [],
		'body'          => [],
		'headers'       => [['what' => 'nope'], ['Content-type' => 'application/json']],
	];

	protected $delete = [
		'path'          => '/delete',
		'method'        => 'DELETE',
		'query'         => [],
		'path_elements' => [],
		'body'          => [],
		'headers'       => [['what' => 'nope'], ['Content-type' => 'application/json']],
	];

}
