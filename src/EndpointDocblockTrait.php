<?php
/**
 * Trait EndpointDocblockTrait
 *
 * @filesource   EndpointDocblockTrait.php
 * @created      09.04.2018
 * @package      chillerlan\MagicAPI
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\MagicAPI;

trait EndpointDocblockTrait{

	/**
	 * @param string $returntype
	 *
	 * @return string
	 * @throws \chillerlan\MagicAPI\ApiClientException
	 */
	public function createDocblock(string $returntype):string{

		if(!$this instanceof EndpointMap){
			throw new ApiClientException('invalid endpoint map');
		}

		$str = '/**'.PHP_EOL;

		foreach($this as $methodName => $params){

			$args = [];

			if(count($params['path_elements']) > 0){

				foreach($params['path_elements'] as $i){
					$args[] = 'string $'.$i;
				}

			}

			if(!empty($params['query'])){
				$args[] = 'array $params = [\''.implode('\', \'', $params['query']).'\']';
			}

			if(in_array($params['method'], ['PATCH', 'POST', 'PUT', 'DELETE'])){

				if($params['body'] !== null){
					$args[] = is_array($params['body']) ? 'array $body = [\''.implode('\', \'', $params['body']).'\']' : 'array $body = []';
				}

			}

			$str.= ' * @method \\'.$returntype.' '.$methodName.'('.implode(', ', $args).')'.PHP_EOL;
		}

		$str .= ' *'.'/'.PHP_EOL;

		return $str;
	}

}
