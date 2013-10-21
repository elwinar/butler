<?php namespace Butler;

class Action
{
	private $name;
	private $function;
	private $debug;
	
	public function __construct($name, $function, $debug = false)
	{
		$this->name = $name;
		$this->function = $function;
		$this->debug = $debug;
	}
	
	public function run()
	{
		echo $this->name.'... ';
		try
		{
			$result = $this->function();
		}
		catch(\Exception $e)
		{
			echo 'NOK - '.$e->getMessage().PHP_EOL;
			if($this->debug)
			{
				echo $e->getTraceAsString().PHP_EOL;
			}
			return false;
		}
		echo 'OK'.PHP_EOL;
		return $result;
	}
};

?>