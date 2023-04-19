<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // It will refer to conn.php file and will open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_Review_ID= $_POST['field_Review_ID'];
    // Save the query into variable called $query. NOte that :title is a place holder
    $query = "CALL delete_review(:Review_ID)";
    
    try
    {
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_title to the place holder :title after //verifying (using PDO::PARAM_STR) that the user has typed a valid string.
      $prepared_stmt->bindValue(':Review_ID', $var_Review_ID, PDO::PARAM_INT);
      //Execute the query and save the result in variable named $result
      $result = $prepared_stmt->execute();

    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}

?>

<html>
  <!-- Any thing inside the HEAD tags are not visible on page.-->
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
  </head> 

  <!-- Everything inside the BODY tags are visible on page.-->
  <body>
     <!-- See the project.css file to see how is navbar stylized.-->
    <div id="navbar">
      <!-- See the project.css file to note how ul (unordered list) is stylized.-->
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
    <!-- See the project.css file to note h1 (Heading 1) is stylized.-->
    <h1> Delete Review </h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">

      <label for="id_Review_ID">Review ID</label>
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_title = $_POST['field_title']; -->
      <input type="text" name="field_Review_ID" id="id_Review_ID">
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Delete Movie.
      The name attribute is referred above on line 3 and line 63. -->
      <input type="submit" name="field_submit" value="Delete">
    </form>

    <?php
      if (isset($_POST['field_submit'])) {
        if ($result) { 
    ?>
          Review was deleted successfully.
    <?php 
        } else { 
    ?>
          <h3> Sorry, there was an error. Invalid Review ID. </h3>
    <?php 
        }
      } 
    ?>

    
  </body>
</html>


