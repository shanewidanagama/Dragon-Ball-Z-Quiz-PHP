<!--
Page name: Question 2 - Dragon Ball Z Quiz Login
Description: Asks user to enter a username, and declares session variables for
the question number, current score, user's answers, and feedback.
-->

<?php
require './includes/library.php'; //defines connectDB functions
session_start(); //create session
$pdo = connectDB(); //connect to database

$_SESSION['qnum'] = 1;  //tracks question number
$_SESSION['currscore'] = 0; //current user score

$feedbackArray = array();
/* array storing whether user entered correct answer. if not, it stores the actual
correct answer */
$_SESSION['feedback'] = $feedbackArray;

$answersArray = array();
$_SESSION['userchoices'] = $answersArray; //array storing user's answers

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="./css/styles.css">
  <title>Login</title>
</head>
<body>
<main>
  <h1>Dragon Ball Z Quiz</h1> <!-- Header -->


  <!-- textbox for user to enter username-->
  <form id="main-form" action="enterusername.php" method="post">
    <div>
      <label for="username">USERNAME:</label>
      <input required  id = "username" name="username" type="text">
    </div>
    <button class = 'button' name="submit">Submit</button>
  </form>

  <?php
  /*stores username, and redirects to quiz after submit is clicked, and terminates
  this script*/
  if(isset($_POST['submit']))
  {
    $_SESSION["usrname"] = $_POST['username'];
    header("Location: quiz.php ");
    exit();
  }
  ?>

</main>
</body>
</html>
