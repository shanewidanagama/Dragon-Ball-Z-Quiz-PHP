<!--
Page name: Question 2 - Dragon Ball Z Quiz
Description: Conducts DBZ themed quiz. It also records whether the user
entered the correct answer, as well as the actual answer if not.
-->

<?php
require './includes/library.php'; //defines connectDB functions
session_start();  //create session
$pdo = connectDB(); //connect to database

/*get current question*/
$questionquery = "SELECT * FROM a2_quest WHERE id = ?";
$questions = $pdo->prepare($questionquery);
$questions->execute([$_SESSION['qnum']]);
$qresults = $questions->fetch();

/*get answer table*/
$ansquery = "SELECT * FROM a2_ans WHERE fk_questid = ?";
$ans = $pdo->prepare($ansquery);
$ans->execute([$_SESSION['qnum']]);

/*get answer key*/
$keyquery = "SELECT answer FROM a2_ans WHERE correct = 1 AND fk_questid = ?";
$anskey = $pdo->prepare($keyquery);
$anskey->execute([$_SESSION['qnum']]);
$keyresults = $anskey->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="./css/styles.css">
  <title>DBZ Quiz</title>
</head>
<body>
<main>
  <h1>Dragon Ball Z Quiz</h1>

  <form id="main-form" action="quiz.php" method="post">

    <!-- display current question -->
    <p class = 'question'><?php echo $qresults['question']; ?></p>

    <!-- display choices to each question-->
    <ul>
    <?php while(($row = $ans->fetch())): ?>
      <li><input required name="choice" type="radio"  value="<?php echo $row['answer']; ?>" /> <?php echo $row['answer'] ?></li>
      <?php endwhile; ?>
    </ul>

    <!-- submit button -->
    <input type="submit" name="submit" class="button" value="Submit" />

  </form>

  <?php
  if(isset($_POST['submit'])) { //if submit is clicked

    $_SESSION['qnum']++;  //increase question counter

      /*if answer is correct, add to score, as well as store answer and feedback
      to in session variables */
      if($_POST['choice']==$keyresults['answer']){
        $_SESSION['currscore'] = $_SESSION['currscore'] + 100;
        array_push($_SESSION['userchoices'], $_POST['choice']);
        array_push($_SESSION['feedback'], "Correct!");
      }
      else {
        /*if answer is incorrect, store answer and the correct
        in session variables */
        array_push($_SESSION['userchoices'], $_POST['choice']);
        array_push($_SESSION['feedback'], $keyresults['answer']);

      }

      /*increment number of times an answer was chosen*/
    $ccquery = "UPDATE a2_ans set choicecount=choicecount+1 where answer= ?";
    $choicecount = $pdo->prepare($ccquery);
    $choicecount->execute([$_POST['choice']]);

    header("Refresh:0");  //refresh page

    //redirect to feedback page when quiz is complete, and terminate current php script
    if($_SESSION['qnum']==6)
    {
      header("Location: feedback.php ");
      exit();
    }
  } ?>
</main>
</body>
</html>
