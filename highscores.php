<!--
Page name: Question 2 - Dragon Ball Z Response Highscores Page
Description: Displays top 10 scores of users, and their usernames.
-->
<?php
require './includes/library.php'; //defines connectDB functions
$pdo = connectDB(); //connect to database

/* get top ten scores in descending order */
$scorequery = "SELECT * FROM a2_scores ORDER BY score DESC LIMIT 10";
$scores = $pdo->prepare($scorequery);
$scores->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="./css/styles.css">
  <title>Highscores</title>
</head>
<body>
<main>
  <h1 class='highscoretitle'>HIGHSCORES</h1> <!-- page header-->

<!-- prints out top ten highscores-->
<ul>
  <?php while(($row = $scores->fetch())):
    echo "<li class='highscores'>".$row['username']." ".$row['score']."</li>";
  endwhile;
    ?>
</ul>


    <!-- stores username, and redirects to quiz after submit is clicked, and terminates
    this script -->
    <ul>
      <li><a href="https://loki.trentu.ca/~shanewidanagama/3420/assignments/assn2/assn2Q2/feedback.php">FEEDBACK</a></li>
      <li><a href="https://loki.trentu.ca/~shanewidanagama/3420/assignments/assn2/assn2Q2/responsebreakdown.php">RESPONSE BREAKDOWN</a></li>
    </ul>

</main>
</body>
</html>
