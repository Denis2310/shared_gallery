<?php
namespace App\Controllers;

use \Core\Controller;
use App\Models\Post;
use \Core\View;

/**
* Posts Controller
*/
class Posts extends Controller
{
	/**
	* Function that could be executed before any other method in Posts Controller
	*/
	protected function before()
	{

	}

	/**
	* Function that could be executed after any other method in Posts Controller
	*/
	protected function after()
	{

	}

	/**
	* Method for Posts/index.php view
	*/	
	public function indexAction()
	{
		$posts = Post::all();
		return View::renderTemplate('Posts/index.php', ['posts' => $posts]);
	}

	/**
	* Method that for Posts/add-new.php view
	*/	
	public function addNewAction()
	{
		 return View::renderTemplate('Posts/add-new.php');
	}

	/**
	* Method for Posts/edit.php view
	*/	
	public function editAction()
	{
		//echo "<p>Route parameters <pre>" . htmlspecialchars(print_r($this->route_parameters, true)) . '</pre></p>';
		return View::renderTemplate('Posts/edit.php');
	}

}