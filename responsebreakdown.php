<!--
Page name: Dragon Ball Z Response Breakdown Page
Description: Displays how often each answer has been selected.
-->

<?php
require './includes/library.php'; //defines connectDB functions
$pdo = connectDB(); //connect to database
$_SESSION['qnum'] = 1;  //resets question number tracker


/* get all questions */
$questionquery = "SELECT * FROM a2_quest";
$questions = $pdo->prepare($questionquery);
$questions->execute();
$qresults = $questions->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="./css/styles.css">
  <title>Choice Counts</title>
</head>
<body>
<main>
  <h1>Choice Counts</h1>  <!-- page header -->

<ul>
  <?php foreach ($qresults as $row): ?> <!-- for each question ... -->
    <li class = 'question'><?= $row['question'] ?></li> <!--display the question -->

    <?php
    /*get answers*/
    $ansquery = "SELECT * FROM a2_ans WHERE fk_questid = ?";
    $ans = $pdo->prepare($ansquery);
    $ans->execute([$_SESSION['qnum']]);

    $_SESSION['qnum']++;  //increase question counter

    /* print answers for each question. prints correct answers in green */
    while(($row = $ans->fetch())):
      if($row['correct']==1) {
        echo "<li class='correct'>".$row['answer']." ".$row['choicecount']."</li>";
      }
      else
        echo "<li>".$row['answer']." ".$row['choicecount']."</li>";
      endwhile;
    ?>
  <?php endforeach; ?>
</ul>

<!-- links to highscores and response feedback pages -->
  <ul>
    <li><a href="https://loki.trentu.ca/~shanewidanagama/3420/assignments/assn2/assn2Q2/highscores.php">HIGHSCORES</a></li>
    <li><a href="https://loki.trentu.ca/~shanewidanagama/3420/assignments/assn2/assn2Q2/feedback.php">FEEDBACK</a></li>
  </ul>


</main>



</body>
</html>
