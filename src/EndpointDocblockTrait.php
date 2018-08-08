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

			if(isset($params['path_elements']) && count($params['path_elements']) > 0){

				foreach($params['path_elements'] as $i){
					$args[] = 'string $'.$i;
				}

			}

			if(isset($params['query']) && !empty($params['query'])){
				$args[] = 'array $params = [\''.implode('\', \'', $params['query']).'\']';
			}

			if(isset($params['method']) && in_array($params['method'], ['PATCH', 'POST', 'PUT', 'DELETE'], true)){

				if($params['body'] !== null){
					$args[] = is_array($params['body']) ? 'array $body = [\''.implode('\', \'', $params['body']).'\']' : 'array $body = []';
				}

			}

			$str.= ' * @method \\'.$returntype.' '.$methodName.'('.implode(', ', $args).')'.PHP_EOL;
		}

		$str .= ' *'.'/'.PHP_EOL;

		return $str;
	}

	/**
	 * @param string $interfaceName
	 * @param string $returntype
	 *
	 * @return bool
	 */
	public function createInterface(string $interfaceName, string $returntype):bool{

		$str = '<?php'.PHP_EOL.PHP_EOL
		       .'namespace '.__NAMESPACE__.';'.PHP_EOL.PHP_EOL
		       .'use \\'.$returntype.';'.PHP_EOL.PHP_EOL
		       .'interface '.$interfaceName.'{'.PHP_EOL.PHP_EOL;

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

			if(in_array($params['method'], ['POST', 'PUT', 'DELETE'])){

				if($params['body'] !== null){
					$args[] = is_array($params['body']) ? 'array $body = [\''.implode('\', \'', $params['body']).'\']' : 'array $body = []';
				}

			}
			$str.= "\t".'/**'.PHP_EOL;


			$str.= "\t".' */'.PHP_EOL."\t".'public function '.$methodName.'('.implode(', ', $args).'):'.((new ReflectionClass($returntype))->getShortName()).';'.PHP_EOL.PHP_EOL;
		}

		$str .= PHP_EOL.'}'.PHP_EOL;

		return (bool)file_put_contents(__DIR__.'/'.$interfaceName.'.php', $str);
	}

}
