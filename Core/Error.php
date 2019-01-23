<?php
namespace Core;

use App\Config;

/**
* Error and exception handler
*
* PHP 7.2
*/
class Error
{
	/**
	* Convert all errors to exceptions by throwing an Error exception
	* 
	* @param int $level Error level
	* @param string $message Error message
	* @param string $file Filename the error was raised in
	* @param int $line Line number in the file
	*
	* @return void
	*/
	public static function errorHandler($level, $message, $file, $line)
	{
		if (error_reporting() != 0) {
			throw new \ErrorException($message, 0, $level, $file, $line);
		}
	}

	/**
	* Exception handler
	*
	* @param exception $exception Get exception
	*
	* @return void
	*/
	public static function exceptionHandler($exception)
	{
		$code = $exception->getCode();

		if ($code != 404) {
			$code = 500;
		}

		http_response_code($code);

		if (Config::SHOW_ERRORS) {
			echo "<h1>Fatal Error</h1>";
			echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
			echo "<p>Message: '" . $exception->getMessage() . "'</p>";
			echo "<p>Stack Trace: <pre>'" . $exception->getTraceAsString() . "'</pre></p>";
			echo "<p>Thrown in: '" . $exception->getFile() . "', on line'" . $exception->getLine() . "'</p>";			
		} else {
			$log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
			ini_set('error_log', $log);

			$message = "<h1>Fatal Error</h1>";
			$message .= "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
			$message .= "<p>Message: '" . $exception->getMessage() . "'</p>";
			$message .= "<p>Stack Trace: <pre>'" . $exception->getTraceAsString() . "'</pre></p>";
			$message .= "<p>Thrown in: '" . $exception->getFile() . "', on line'" . $exception->getLine() . "'</p>";

			error_log($message);

			if ($code == 404) {
				View::renderTemplate('Errors/404.html');
			} else {
				View::renderTemplate('Errors/500.html');
			}
		}
	}
}