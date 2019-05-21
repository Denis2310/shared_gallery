<?php
namespace Core;

class Session
{
    private $signed_in = false;
    private $user_id;
    public $username;
    public $message = '';

    public function __construct()
    {
        session_start();
        $this->check_login();
        $this->check_message();
    }

    public function is_signed_in()
    {
        return $this->signed_in;
    }

    public function user_id()
    {
        return $this->user_id;
    }

    private function check_login()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->username = $_SESSION['username'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            unset($this->username);
            $this->signed_in = false;
        }
    }

    private function check_message()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = '';
        }
    }

    public function message($message = '')
    {
        if ($message) {
            $_SESSION['message'] = $message; //razmotriti
        } else {
            return $this->message;
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        unset($_SESSION['username']);
        unset($this->username);
        $this->signed_in = false;
    }

    public function login($id, $username)
    {
        $this->user_id = $_SESSION['user_id'] = $id;
        $this->username = $_SESSION['username'] = $username;
        $this->signed_in = true;
    }

}
