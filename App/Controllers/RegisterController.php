<?php
namespace App\Controllers;

use \App\Models\User;
use \Core\Controller;
use \Core\Validator;
use \Core\View;

/**
 * Registration Controller
 */
class RegisterController extends Controller
{
    /**
     * Function that could be executed before any other method in Register Controller
     */
    protected function before()
    {
        global $session;

        return !$session->is_signed_in() ? true : redirect('/shared_gallery/public');
    }

    /**
     * Function that could be executed after any other method in Register Controller
     */
    protected function after()
    {

    }

    /**
     * Registration form view
     *
     * @return View register.php or redirects to management.php if registered
     */
    public function indexAction()
    {
        global $session;

        //Check if register form is submitted
        if (isset($_POST['submit'])) {
            $validated = Validator::validateRegistration($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password-confirm']);
            //Pozvati validator klasu i odraditi validaciju
            if ($validated === true) {
                $user = new User();

                $user->username = $_POST['username'];
                $user->email = $_POST['email'];

                $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
                $user->password = $password;

                if ($user->save() == true) {
                    $session->login($user->id, $user->username);
                    $session->message('Welcome to Shared Gallery!');

                    return redirect('management');
                }

                $session->message('Username and/or email already exist!');
                return redirect('register');

            } else {

                $session->message($validated);
                return redirect('register');
            }

        } else {
            return View::renderTemplate('Auth/register.php');
        }
    }

}
