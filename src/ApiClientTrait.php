<?php
/**
 * Trait ApiClientTrait
 *
 * @filesource   ApiClientTrait.php
 * @created      07.04.2018
 * @package      chillerlan\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\MagicAPI;

use chillerlan\HTTP\HTTPResponseInterface;
use chillerlan\Traits\ClassLoader;
use Psr\Log\LoggerAwareTrait;
use ReflectionClass;

/**
 * @link http://php.net/manual/language.oop5.magic.php#118617
 *
 * @implements chillerlan\MagicAPI\ApiClientInterface
 *
 * @property string $endpointMap FQCN
 *
 * from \chillerlan\HTTP\HTTPClientInterface:
 * @method request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface
 * @method checkQueryParams(array $params, bool $booleans_as_string = null):array;
 */
trait ApiClientTrait{
	use ClassLoader, LoggerAwareTrait;
	/**
	 * @var \chillerlan\MagicAPI\EndpointMapInterface
	 *
	 * method => [url, method, mandatory_params, params_in_url, ...]
	 */
	protected $endpoints;

	/**
	 * @return \chillerlan\MagicAPI\ApiClientInterface
	 */
	public function loadEndpoints():ApiClientInterface {

		if(class_exists($this->endpointMap)){
			$this->endpoints = $this->loadClass($this->endpointMap, EndpointMapInterface::class);
		}

		/** @noinspection PhpIncompatibleReturnTypeInspection */
		return $this;
	}

	/**
	 * ugly, isn't it?
	 * @todo WIP
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return \chillerlan\HTTP\HTTPResponseInterface|null
	 * @throws \chillerlan\MagicAPI\APIClientException
	 */
	public function __call(string $name, array $arguments):?HTTPResponseInterface{

		if($this->endpoints instanceof EndpointMapInterface && $this->endpoints->__isset($name)){
			$m = $this->endpoints->{$name};

			$endpoint      = $m['path'];
			$method        = $m['method'] ?? 'GET';
			$body          = null;
			$headers       = isset($m['headers']) && is_array($m['headers']) ? $m['headers'] : [];
			$path_elements = $m['path_elements'] ?? [];
			$params_in_url = count($path_elements);
			$params        = $arguments[$params_in_url] ?? null;
			$urlparams     = array_slice($arguments,0 , $params_in_url);

			if($params_in_url > 0){

				if(count($urlparams) < $params_in_url){
					throw new APIClientException('too few URL params, required: '.implode(', ', $path_elements));
				}

				$endpoint = sprintf($endpoint, ...$urlparams);
			}

			if(in_array($method, ['POST', 'PATCH', 'PUT', 'DELETE'])){
				$body = $arguments[$params_in_url + 1] ?? $params;

				if($params === $body){
					$params = null;
				}

				if(is_array($body) && isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'json') !== false){
					$body = json_encode($body);
				}

			}

			$params = $this->checkQueryParams($params);
			$body   = $this->checkQueryParams($body);

			$this->logger->debug('OAuthProvider::__call() -> '.(new ReflectionClass($this))->getShortName().'::'.$name.'()', [
				'$endpoint' => $endpoint, '$params' => $params, '$method' => $method, '$body' => $body, '$headers' => $headers,
			]);

			return $this->request($endpoint, $params, $method, $body, $headers);
		}

		return null;
	}

}
