<?php
/**
 * Class ApiClientAbstract
 *
 * @filesource   ApiClientAbstract.php
 * @created      09.04.2018
 * @package      chillerlan\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\MagicAPI;

use chillerlan\HTTP\HTTPClientAbstract;

abstract class ApiClientAbstract extends HTTPClientAbstract implements ApiClientInterface{
	use ApiClientTrait;
}
