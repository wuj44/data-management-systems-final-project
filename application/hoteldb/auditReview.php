<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Save the query into variable called $query. Note that :ph_game_year is a place holder
    $query = "SELECT * FROM Review_Audit";

try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_director to the place holder :ph_director  
      // Use PDO::PARAM_STR to sanitize user string.
      $prepared_stmt->execute();
      // Fetch all the values based on query and save that to variable $result
      $result = $prepared_stmt->fetchAll();

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
    
    <h1> Click the button below to see audit review table</h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Submit.
      The name attribute is referred  on line 3 and line 61. -->
      <input type="submit" name="field_submit" value="Audit">
    </form>
    
    <?php
      if (isset($_POST['field_submit'])) {
        // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <!-- first show the header RESULT -->
              <h2>Results</h2>
              <!-- THen create a table like structure. See the project.css how table is stylized. -->
              <table>
                <!-- Create the first row of table as table head (thead). -->
                <thead>
                   <!-- The top row is table head with columns named -- ID... -->
                  <tr>
                    <th>Audit ID </th>
                    <th>Hotel ID</th>
                    <th>Review ID</th>
                    <th>Negative Review</th>
                    <th>Positive Review</th>
                    <th>Reviewer Score</th>
                    <th>Review Date</th>
                    <th>Date Deleted</th>

                  </tr>
                </thead>
                 <!-- Create rest of the the body of the table -->
                <tbody>
                   <!-- For each row saved in the $result variable ... -->
                  <?php foreach ($result as $row) { ?>
                
                    <tr>
                       <!-- Print (echo) the value of Audit_ID in first column of table -->
                      <td><?php echo $row["Audit_ID"]; ?></td>
                      <!-- Print (echo) the value of Hotel_ID in second column of table -->
                      <td><?php echo $row["Hotel_ID"]; ?></td>
                      <!-- Print (echo) the value of Review_ID in third column of table and so on... -->
                      <td><?php echo $row["Review_ID"]; ?></td>
                      <td><?php echo $row["Negative_Review"]; ?></td>
                      <td><?php echo $row["Positive_Review"]; ?></td>
                      <td><?php echo $row["Reviewer_Score"]; ?></td>
                      <td><?php echo $row["Review_Date"]; ?></td>
                      <td><?php echo $row["Date_Deleted"]; ?></td>
                      
                    <!-- End first row. Note this will repeat for each row in the $result variable-->
                    </tr>
                  <?php } ?>
                  <!-- End table body -->
                </tbody>
                <!-- End table -->
            </table>
  
        <?php } else { ?>
          <!-- IF query execution resulted in error display the following message-->
          <h3>No review has been deleted yet. </h3>
        <?php }
    } ?>


    
  </body>
</html>
