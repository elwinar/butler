<?php namespace Butler;

class Parameter
{
	private $short;
	private $long;
	private $flags;
	private $default;
	
	const COMMUTATOR = 1;
	const MULTIPLE = 2;
	
	public function __construct($short, $long, $flags = null, $default = null)
	{
		$this->short = $short;
		$this->long = $long;
		$this->flags = $flags;
		$this->default = $default;
	}
	
	public function check($arguments)
	{
		if($this->flags & self::COMMUTATOR) // If the parameter is a commutator
		{
			$result = false; // Defaults to false
			for($i = 0; $i < count($arguments); $i++) // For each argument
			{
				if(strpos($arguments[$i], '--') === 0) // If this is a long parameter
				{
					if($arguments[$i] == '--'.$this->long) // And it's this parameter
					{
						$result = true; // Result is true
					}
				}
				else if(strpos($arguments[$i], '-') === 0) // If it's a short parameter
				{
					if(strpos($arguments[$i], $this->short) !== false) // And it contains this parameter
					{
						$result = true;
					}
				}
			}
			return $result;
		}
		else // If the parameter is a value parameter
		{
			if($this->flags & self::MULTIPLE) // If it is a multiple value paramete
			{
				$result = []; // Default to an empty array
				for($i = 0; $i < count($arguments); $i++) // For each argument
				{
					if($arguments[$i] == '--'.$this->long || $arguments[$i] == '-'.$this->short) // If this is this parameter in short or long version
					{
						while(isset($arguments[$i+1]) && strpos($arguments[$i+1], '-') !== 0)
						{
							$result[] = $arguments[$i+1];
							$i++;
						}
					}
				}
				if(empty($result) && $this->default != null)
				{
					$result[] = $this->default;
				}
				return $result;
			}
			else // If it is a single value parameter
			{
				$result = $this->default; // Defaults to specified value (or null by default)
				for($i = 0; $i < count($arguments); $i++) // For each argument
				{
					if($arguments[$i] == '--'.$this->long || $arguments[$i] == '-'.$this->short) // If this is this parameter in short or long version
					{
						if(isset($arguments[$i+1]) && strpos($arguments[$i+1], '-') !== 0)
						{
							$result = $arguments[$i+1];
							$i++;
						}
					}
				}
				return $result;
			}
		}
	}
};

?>