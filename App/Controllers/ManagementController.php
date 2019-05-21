<?php
namespace App\Controllers;

use \App\Models\Image;
use \App\Models\User;
use \Core\Controller;
use \Core\Validator;
use \Core\View;

/**
 * Management Controller
 */
class ManagementController extends Controller
{
    /**
     * Function that could be executed before any other method in Home Controller
     */
    protected function before()
    {
        global $session;

        return $session->is_signed_in() ? true : redirect('/shared_gallery/public');
    }

    /**
     * Function that could be executed after any other method in Home Controller
     */
    protected function after()
    {

    }

    /**
     * Management View, Image upload if form was submitted
     *
     * @return View management.php
     */
    public function indexAction()
    {
        global $session;

        if (isset($_POST['upload-image']) && !empty($_FILES['file']['name'])) {
            $file = $_FILES['file'];
            $validated = Validator::validateFile($file);

            if ($validated === true) {
                //Validacija je uspjena odradi dio ispod
                $upload_directory = 'images/' . $session->user_id() . '/';

                if (!file_exists($upload_directory)) {
                    mkdir($upload_directory, 0777, true);
                }
                $file_name = time() . $file['name'];
                $path = $upload_directory . $file_name;

                if (move_uploaded_file($file['tmp_name'], $path)) {
                    $image = new Image();
                    $image->user_id = $session->user_id();
                    $image->path = $file_name;

                    if ($image->save()) {
                        $session->message('Image uploaded');
                    } else {
                        $session->message('Image not uploaded');
                    }
                }
            } else {
                $session->message($validated); //ne radi treba provjeriti
            }

            return redirect('management');
        }

        $images = Image::sql("SELECT images.id, images.user_id, users.username, users.email, images.path FROM images INNER JOIN users ON images.user_id = users.id ORDER BY FIELD(username, '$session->username') DESC");

        return View::renderTemplate('User/management.php', ['images' => $images]);
    }

    /**
     * Removes user data from session global variable and logout user from application
     *
     * @return redirect method that redirects user to home view
     */
    public function logoutAction()
    {
        global $session;

        $session->logout();
        return redirect('/shared_gallery/public');
    }

    public function deleteAction($image_id)
    {
        global $session;

        $image = Image::findById($image_id);
        if (empty($image) || $image->user_id != $session->user_id()) {
            $session->message('Something went wrong!');

            return redirect('/shared_gallery/public/management');
        }

        $filename = $image->path;
        $directory = $_SERVER['DOCUMENT_ROOT'] . '/shared_gallery/public/images/' . $session->user_id;
        $path = $directory . '/' . $filename;

        if (unlink($path)) {
            Image::delete($image_id);
            $session->message('Image deleted.');
        } else {
            $session->message('Image not found on path.');
        }

        return redirect('/shared_gallery/public/management');
    }
}
