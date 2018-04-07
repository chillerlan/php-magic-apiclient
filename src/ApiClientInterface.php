<?php
/**
 * Interface ApiClientInterface
 *
 * @filesource   ApiClientInterface.php
 * @created      07.04.2018
 * @package      chillerlan\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\MagicAPI;

interface ApiClientInterface{

	/**
	 * @return \chillerlan\MagicAPI\ApiClientInterface
	 */
	public function loadEndpoints():ApiClientInterface;

	/**
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return \chillerlan\HTTP\HTTPResponseInterface|null
	 * @throws \chillerlan\MagicAPI\APIClientException
	 */
	public function __call(string $name, array $arguments);

}
