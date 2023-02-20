<?php

/**
 * Get the PSR4 autoloader and load all the classes required.
 */
spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name . '.php';
});

// Error reporting.
//error_reporting(-1);

// Turn cache off
ini_set('opcache.enable','0');

class Comms Extends Main {

  public function __construct()  {

    // Call the parent first and instantiate the database SQL class instance.
    parent::__construct();

  }

  public function testDatabase() {

    $query = $this->conn->select('SELECT * from Data');

    return $query;

  }

  public function feedback($feedback, $SMART) {

    $query = $this->conn->update('UPDATE SMART_Targets SET `GPT Feedback` = ? WHERE `SMART Target` = ?', [$feedback, $SMART]);

    return $query;

  }

  public function getData() {

    $query = $this->conn->select('SELECT DISTINCT `Student Number`, `First Name`, `Last Name`, `SMART Target`, `GPT Feedback` from data.SMART_Targets');

    return $query;

  }

  public function delete($sNumber, $fName, $lName, $sTarget, $gptFeedback) {

    $query = $this->conn->delete('DELETE FROM SMART_Targets WHERE `Student Number` = ? and `First Name` = ? and `Last Name` = ?  and `SMART Target` = ? and `GPT Feedback` = ?', [$sNumber, $fName, $lName, $sTarget, $gptFeedback]);

    return $query;

  }
  }

?>
