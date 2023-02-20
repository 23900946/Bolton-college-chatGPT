<?php

/**
 * Get the PSR4 autoloader and load all the classes required.
 */
spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name . '.php';
});

// Turn cache off
ini_set('opcache.enable','0');

/**
 * The parent class of the project. All other classes will be extended classes of Main.
 * This class can be used for the helper functions to be shared amongst all classes.
 **/
class Main
{
	public $conn;
	public $stuID;

	public function __construct()
	{
		// Connection to the database and use try/catch to catch any issues.
		try
		{
			// Get the database connection.
			$this->conn = new SQL();
  		// Email headers for all emails sent in the classes unless they're overwritten in the classes.
			$this->headers =
			'From: mailer@boltoncc.ac.uk' . "\r\n" .
		    'Reply-To: noreply@boltoncc.ac.uk' . "\r\n" .
		    'Cc: mike.thornley@boltoncc.ac.uk' . "\r\n".
		    'MIME-Version: 1.0' . "\r\n".
		    'Content-type: text/html; charset=iso-8859-1' . "\r\n".
		    'X-Mailer: PHP/' . phpversion();

		}

		// Catch some PDO errors.
		catch (PDOException $e)
		{
			throw new Exception('PDO Database connection instantiation failed in line: ' . __LINE__ . ' of the file: '. __FILE__ .' with the message: '. $e->getMessage());
		}
	}


	/**
	 * Close the connection to PDO.
	 */
	public function __destruct()
	{
		$this->conn = NULL;
	}
}
