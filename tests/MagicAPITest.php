<?php
/**
 * Class MagicAPITest
 *
 * @filesource   MagicAPITest.php
 * @created      01.09.2018
 * @package      chillerlan\HTTPTest\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\HTTPTest\MagicAPI;

use chillerlan\HTTP\HTTPOptions;
use chillerlan\HTTP\Psr7;
use PHPUnit\Framework\TestCase;

class MagicAPITest extends TestCase{

	/**
	 * @var \chillerlan\HTTP\HTTPClientInterface
	 */
	protected $http;

	protected function setUp(){
		$options = new HTTPOptions(['ca_info' => __DIR__.'/cacert.pem']);

		$this->http = new MagicAPI($options);
	}

	public function requestDataProvider():array {
		return [
			'get'    => ['get',    []],
			'post'   => ['post',   []],
			'put'    => ['put',    ['Content-type' => 'application/json']],
			'patch'  => ['patch',  ['Content-type' => 'application/json']],
			'delete' => ['delete', []],
		];
	}

	/**
	 * @dataProvider requestDataProvider
	 *
	 * @param $method
	 * @param $extra_headers
	 */
	public function testRequest(string $method, array $extra_headers){
		$r = $this->http->{$method}();

		try{
			$response = $this->http->{$method}(['foo' => 'bar'], ['huh' => 'wtf']);
		}
		catch(\Exception $e){
			$this->markTestSkipped('httpbin.org error: '.$e->getMessage());
			return;
		}

		$json = Psr7\get_json($response);

		if(!$json){
			$this->markTestSkipped('empty response');
		}
		else{
			$this->assertSame('https://httpbin.org/'.$method.'?foo=bar', $json->url);
			$this->assertSame('bar', $json->args->foo);
			$this->assertSame('nope', $json->headers->What);

			if(in_array($method, ['patch', 'post', 'put'])){

				if(isset($extra_headers['content-type']) && $extra_headers['content-type'] === 'application/json'){
					$this->assertSame('wtf', $json->json->huh);
				}
				else{
					$this->assertSame('wtf', $json->form->huh);
				}

			}
		}
	}
}
