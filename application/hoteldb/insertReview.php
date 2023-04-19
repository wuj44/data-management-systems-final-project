<?php

if (isset($_POST['f_submit'])) {

    require_once("conn.php");

    $var_Hotel_Name = $_POST['f_Hotel_Name'];
    $var_Hotel_City = $_POST['f_Hotel_City'];
    $var_Negative_Review = $_POST['f_Negative_Review'];
    $var_Positive_Review = $_POST['f_Positive_Review'];
    $var_Reviewer_Score = $_POST['f_Reviewer_Score'];

    $query = "CALL insert_review(:Hotel_Name, :Hotel_City, :Negative_Review, :Positive_Review, :Reviewer_Score, @output_Review_ID)";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':Hotel_Name', $var_Hotel_Name, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':Hotel_City', $var_Hotel_City, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':Negative_Review', $var_Negative_Review, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':Positive_Review', $var_Positive_Review, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':Reviewer_Score', $var_Reviewer_Score, PDO::PARAM_INT);
      $result = $prepared_stmt->execute();

    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}

?>

<html>
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
  </head> 

  <body>
    <div id="navbar">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="getHotel.php">Search Hotel by City</a></li>
        <li><a href="searchName.php">Search Hotel by Hotel Name</a></li>
        <li><a href="getReview.php">Search Review by Hotel Name</a></li>
        <li><a href="insertReview.php">Insert Review</a></li>
        <li><a href="deleteReview.php">Delete Review</a></li>
        <li><a href="updateBusiness.php">Update Business</a></li>
        <li><a href="auditReview.php">Audit Review</a></li>
      </ul>
    </div>

<h1> Insert Review </h1>

    <form method="post">
    	<label for="id_Hotel_Name">Hotel Name</label>
    	<input type="text" name="f_Hotel_Name" id="id_Hotel_Name"> 

    	<label for="id_Hotel_City">Hotel City</label>
    	<input type="text" name="f_Hotel_City" id="id_Hotel_City">

      <label for="id_Negative_Review">Negative Review</label>
    	<input type="text" name="f_Negative_Review" id="id_Negative_Review">

      <label for="id_Positive_Review">Positive Review</label>
    	<input type="text" name="f_Positive_Review" id="id_Positive_Review">

      <label for="id_Reviewer_Score">Reviewer Score (Please input integer between 0 and 10, both are inclusive.)</label>
    	<input type="text" name="f_Reviewer_Score" id="id_Reviewer_Score">
    	
    	<input type="submit" name="f_submit" value="Submit">
    </form>
    <?php
      if (isset($_POST['f_submit'])) {
        if ($result) { 
    ?>
          Review was inserted successfully.
    <?php 
        } else { 
    ?>
          <h3> Sorry, there was an error. Review was not inserted. </h3>
    <?php 
        }
      } 
    ?>


    
  </body>
</html>