 <?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

  //Display errors on screen - for use for development only

  //Import comms class and methods
  include('classes/Comms.php');
  $comms = new Comms();








  // $user = strtolower($_SERVER['sAMAccountName']);
  // $userEmail = $_SERVER['mail'];

  //Site URL without parameters
  $homeURL = strtok($_SERVER["REQUEST_URI"],'?');

  //If page is set as a URL parameter store it as a variable
  if (isset($_GET['page'])) {
   $currentPage = $_GET['page'];
  } else {
   $currentPage = '';
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/core.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
  </script>
  </head>
  <body>

    <div class="main-container">

      <div class="main">


        <div class="column">

            <?php
            //If $currentPage is not empty, include the view with matching name, else include default.php
            if ($currentPage) {?>

              <?php include('views/'.$currentPage.'.php'); ?>

            <?php } else { ?>

              <?php include('views/default.php'); ?>

            <?php } ?>


          </div>

      </div>
    </div>
  </body>
</html>
