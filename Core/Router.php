<?php
namespace Core;

/**
* Router Class - for routes management
*/
class Router
{
	/**
	* Routes table
	*
	* @var array
	*/
	private $routes_table = [];

	/**
	* Routes table
	*
	* @var array
	*/
	private $parameters = [];
	
	/**
	* Add routes to routing table
	*
	* @param $url string
	* @param $params array
	*
	* @return void
	*/
	public function add_route($url, $params = [])
	{
		$route = preg_replace('/\//', '\\/', $url); //Pronađi znak / (potrebno ga je escape sa \/), kad je pronađen stavi u url taj znak
		$route = preg_replace('/\{([a-z-]+)\}/', '(?P<\1>[a-z-]+)', $route);
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
		$route = '/^' . $route . '$/i';
		
		$this->routes_table[$route] = $params;
	}

	/**
	* Show registered routes in routing table
	*
	* @return array
	*/
	public function show_routes()
	{
		echo $this->routes_table;
	}

	/**
	* Match registered route in routing table
	*
	* @param $url string
	*
	* @return boolean true if route exist, false if route not found
	*/
	public function match_route($url)
	{
		foreach ($this->routes_table as $route => $parameters) {
			if (preg_match($route, $url, $matches)) {
				foreach ($matches as $key => $match) {
					if(is_string($key)) {
						$parameters[$key] = $match;
					}
				}

				$this->parameters = $parameters;

				return true;
			}
		}

		return false;
	}

	/**
	* Get parameters for matched route
	*
	* @return array
	*/
	/*public function get_parameters()
	{
		return $this->parameters;
	}
	*/
	
	/**
	* Change url to studlyCaps
	*
	* @param $url string
	*
	* @return string
	*/
	private function getStudlyCaps($url)
	{
		$url = strtolower($url);

		if (strpos($url, '-')) {
			$url = str_replace('-', ' ', $url);
		}

		$url = ucwords($url);
		$url = str_replace(' ', '', $url);

		return $url;
	}

	/**
	* Change url to camelCase
	*
	* @param $url string
	*
	* @return string
	*/
	private function getCamelCase($url)
	{
		$url = strtolower($url);	
		$url = $this->getStudlyCaps($url);
		$url = lcfirst($url);

		return $url;
	}

	/**
	* Function to dispatch route to corresponding controller and route
	*
	* @param $url string
	*
	* @return void
	*/
	public function dispatch($url)
	{
		$url = $this->removeQueryStringVariables($url);

		if ($this->match_route($url)) {
			$controller = 'App\\Controllers\\' . $this->getStudlyCaps($this->parameters['controller']);

			if (class_exists($controller)) {
				$controller_object = new $controller($this->parameters);
				$method = $this->getCamelCase($this->parameters['action']);
				
				if (preg_match('/action$/i', $method) == 0) {
					$controller_object->$method();
				} else {
					throw new \Exception("Method '$method' in $controller can't be called directly, remove the action suffix");
				}
			} else {
				throw new \Exception("Class '$controller' does not exist.");
			}
		} else {
			throw new \Exception("The selected route does not exist.", 404);
		}
	}

	/**
	* Remove query string variables from route
	*
	* @param $url string
	*
	* @return string
	*/
	private function removeQueryStringVariables($url)
	{
		if ($url != '') {
			$parts = explode('&', $url, 2);

			if (strpos($parts[0], '=') === false) {
				$ur = $parts[0];
			} else {
				$url = '';
			}
		}

		return $url;
	}
}