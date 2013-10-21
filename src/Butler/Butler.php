<?php namespace Butler;

class Butler
{
	public function parse(array $parameters)
	{
		global $argv;
		$result = [];
		foreach($parameters as $key => $parameter)
		{
			$result[$key] = $parameter->check($argv);
		}
		return $result;
	}
	
	public function perform($name, callable $function, $debug = false)
	{
		$action = new Action($name, $function, $debug);
		return $action->run();
	}
};

?>