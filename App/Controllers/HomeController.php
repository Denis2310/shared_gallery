<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\Model;
use \Core\View;

/**
 * Home Controller
 */
class HomeController extends Controller
{
    /**
     * Function that could be executed before any other method in Home Controller
     */
    protected function before()
    {
        global $session;

        return !$session->is_signed_in() ? true : redirect('management');
    }

    /**
     * Function that could be executed after any other method in Home Controller
     */
    protected function after()
    {

    }

    public function indexAction()
    {
        return View::renderTemplate('home.php');
    }

    public function imagesCountAction()
    {
        $db = Model::getDB();

        $stmt = $db->query('SELECT count(*) FROM images');
        $response = $stmt->fetchColumn();

        echo $response;
    }
}
