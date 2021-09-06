<!--
Page name: Dragon Ball Z Feedback Page
Description: Lists user's score, gives a custom message based on it, and whether
their answers were correct. If incorrect, it lists the correct answer. Also provides
links to highscore board, and response breakdown page.
-->

<?php
require './includes/library.php'; //defines connectDB functions
session_start();  //create session
$pdo = connectDB(); //connect to database

/*writes user's score to database*/
$scorequery = "INSERT INTO `a2_scores` (username, score) VALUES (?, ?)";
$usrscore = $pdo->prepare($scorequery);
$usrscore->execute([$_SESSION["usrname"], $_SESSION['currscore']]);

/*gets quiz questions*/
$questionquery = "SELECT * FROM a2_quest";
$questions = $pdo->prepare($questionquery);
$questions->execute();
$qresults = $questions->fetchAll();

$i = 0;   //counter variable for array's containing feedback and user's answers

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="./css/styles.css">
  <title>Quiz Complete</title>
</head>
<body>
<main>
  <h1>You have completed the quiz!</h1>

  <ul>
  <?php foreach ($qresults as $row): ?>

    <!-- output each question -->
    <li class = 'question'><?= $row['question'] ?></li>

    <?php
    /* get respective answer */
    $ansquery = "SELECT * FROM a2_ans WHERE fk_questid = ?";
    $ans = $pdo->prepare($ansquery);
    $ans->execute([$_SESSION['qnum']]);

    $_SESSION['qnum']++;  //increment question number

    /* echo user's answer. If incorrect display correct answer, othewise confirm
    that it is correct */
    echo "<li>YOUR ANSWER: ".$_SESSION['userchoices'][$i]."</li>";
    echo "<li class = 'feedback'>ANSWER:  ".$_SESSION['feedback'][$i]."</li>";

    $i++; //increment counter for arrays containing feedback and user choices
    ?>


  <?php endforeach; ?>

    </ul>

<!-- display total score -->
<?php echo "<p id='score'> YOUR SCORE: ".$_SESSION['currscore']."</p>";

/* display custom message based on score*/
switch($_SESSION['currscore']) {
  case 0:
    echo "<p class='endmessage' >THAT'S TOO BAD!</p>";
    break;
  case 100:
    echo "<p class='endmessage' >BETTER LUCK NEXT TIME! </p>";
    break;
  case 200:
    echo "<p class='endmessage'>Meh. </p>";
    break;
  case 300:
    echo "<p class='endmessage'>NOT TOO SHABBY! </p>";
    break;
  case 400:
    echo "<p class='endmessage'>NICE! </p>";
    break;
  case 500:
    echo "<p class='endmessage'>CONGRATULATIONS!!! </p>";
    break;
}
?>

<!-- links to highscores and response breakdown pages-->
<ul>
  <li><a href="https://loki.trentu.ca/~shanewidanagama/3420/assignments/assn2/assn2Q2/highscores.php">HIGHSCORES</a></li>
  <li><a href="https://loki.trentu.ca/~shanewidanagama/3420/assignments/assn2/assn2Q2/responsebreakdown.php">RESPONSE BREAKDOWN</a></li>
</ul>
</main>
</body>
</html>
