<?php
/**
 * Class MagicAPI
 *
 * @filesource   MagicAPI.php
 * @created      01.09.2018
 * @package      chillerlan\HTTPTest\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\HTTPTest\MagicAPI;

use chillerlan\HTTP\CurlClient;
use chillerlan\HTTP\MagicAPI\{ApiClientInterface, ApiClientTrait};
use chillerlan\Settings\SettingsContainerInterface;
use Psr\Http\Message\{RequestFactoryInterface, ResponseFactoryInterface, StreamFactoryInterface};
use Psr\Log\LoggerAwareTrait;

class MagicAPI extends CurlClient implements ApiClientInterface{
	use ApiClientTrait, LoggerAwareTrait;

	public function __construct(
		SettingsContainerInterface $options = null,
		RequestFactoryInterface $requestFactory = null,
		ResponseFactoryInterface $responseFactory = null,
		StreamFactoryInterface $streamFactory = null
	){
		parent::__construct($options, $requestFactory, $responseFactory, $streamFactory);

		$this->loadEndpoints(MagicAPIEndpoints::class);
	}

}
