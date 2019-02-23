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

use chillerlan\HTTP\Psr18\CurlClient;
use chillerlan\HTTP\MagicAPI\{ApiClientInterface, ApiClientTrait};
use chillerlan\Settings\SettingsContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\{LoggerAwareTrait, LoggerInterface};

class MagicAPI extends CurlClient implements ApiClientInterface{
	use ApiClientTrait, LoggerAwareTrait;

	public function __construct(
		SettingsContainerInterface $options = null,
		ResponseFactoryInterface $responseFactory = null,
		LoggerInterface $logger = null
	){
		parent::__construct($options, $responseFactory, $logger);

		$this->loadEndpoints(MagicAPIEndpoints::class);
	}

}
