<?php
namespace Core;

/**
* Base Controller
*
* PHP version 7.2
*/
abstract class Controller
{
	/**
	* Parameters from the matched route
	*
	* @var array
	*/
	protected $route_parameters = [];

	/**
	* Class constructor
	*
	* @param array $route_params Parameters from the route
	*
	* @return void
	*/
	public function __construct($route_parameters)
	{
		$this->route_parameters = $route_parameters;
	}

 	/**
 	* Call magic method for inaccessible class methods
 	*/
	public function __call($name, $args)
	{
		$method = $name . 'Action';
		
		if(method_exists($this, $method)) {
			call_user_func_array([$this, $method], $args);
		} else {
			throw new \Exception("Method '$method' not found in controller" . get_class($this));
		}
	}

	/**
	* Before filter - called before an Action method
	*
	* @return void
	*/
	protected function before()
	{

	}

	/**
	* After filter - called after an Action method
	*
	* @return void
	*/
	protected function after()
	{

	}
}