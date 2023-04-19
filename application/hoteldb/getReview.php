<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_hotel_name = $_POST['field_hotel_name'];
    #$var_hotel_city = $_POST['field_hotel_city'];
    // Save the query into variable called $query. Note that :ph_hotel is a place holder
    if (isset($_POST['RadioGroup1'])){
        if($_POST['RadioGroup1']==1){
            $query = "SELECT * 
                      FROM review_date 
                      WHERE hotel_name = '$var_hotel_name'
                      ORDER BY Review_Date DESC";
        }
        else if($_POST['RadioGroup1']==2){
            $query = "SELECT * 
                      FROM review_score 
                      WHERE hotel_name = '$var_hotel_name'
                      ORDER BY Reviewer_Score DESC";
        }
        else if($_POST['RadioGroup1']==3){
          $query = "SELECT * 
                    FROM review_score 
                    WHERE hotel_name = '$var_hotel_name'
                    ORDER BY Reviewer_Score";
      }}
    if (empty($_POST['RadioGroup1'])){
        echo "<script>alert('Sorry, please choose one.')</script>";
    }
if (isset($_POST['RadioGroup1'])){
    try
        {
          // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
          $prepared_stmt = $dbo->prepare($query);
          //bind the value saved in the variable $var_hotel to the place holder :ph_hotel  
          // Use PDO::PARAM_STR to sanitize user string.
          $prepared_stmt->bindValue(':ph_hotel_name', $var_hotel_name, PDO::PARAM_STR);
          #$prepared_stmt->bindValue(':ph_hotel_city', $var_hotel_city, PDO::PARAM_STR);
          $prepared_stmt->execute();
          // Fetch all the values based on query and save that to variable $result
          $result = $prepared_stmt->fetchAll();

        }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}}
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
    
    <h1> Search Review by Hotel Name</h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">

      <label for="id_hotel_name">Hotel Name</label>
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_hotel = $_POST['field_hotel']; id attribute is referred in label tag above on line 52-->
      <input type="text" name="field_hotel_name" id = "id_hotel_name">
      <!-- label for="id_hotel_city">Hotel City</label -->
      <!--<input type="text" name="field_hotel_city" id = "id_hotel_city" -->
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Submit.
      The name attribute is referred  on line 3 and line 61. -->
        <p>
            <label>
                <input type="radio" name="RadioGroup1" value="1" />
                Sort by review date</label>
            <label>
                <input type="radio" name="RadioGroup1" value="2" />
                Sort by reviewer score desc</label>
            <label>
                <input type="radio" name="RadioGroup1" value="3" />
                Sort by reviewer score asc</label>
        </p>
      <input type="submit" name="field_submit" value="Submit">
    </form>
    
    <?php
      if (isset($_POST['field_submit']) & isset($_POST['RadioGroup1'])) {
        // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <!-- first show the header RESULT -->
              <h2>Results</h2>
              <!-- THen create a table like structure. See the project.css how table is stylized. -->
              <table>
                <!-- Create the first row of table as table head (thead). -->
                <thead>
                   <!-- The top row is table head with four columns named -- ID, Title ... -->
                  <tr>
                    <th>Hotel Name</th>
                    <th>Hotel City</th>
                    <th>Review ID</th>
                    <th>Negative Review</th>
                    <th>Positive Review</th>
                    <th>Reviewer Score</th>
                    <th>Review Date</th>
                  </tr>
                </thead>
                 <!-- Create rest of the the body of the table -->
                <tbody>
                   <!-- For each row saved in the $result variable ... -->
                  <?php foreach ($result as $row) { ?>
                
                    <tr>
                       <!-- Print (echo) the value of mID in first column of table -->
                      <td><?php echo $row["Hotel_Name"]; ?></td>
                      <!-- Print (echo) the value of title in second column of table -->
                      <td><?php echo $row["Hotel_City"]; ?></td>
                      <!-- Print (echo) the value of movieYear in third column of table and so on... -->
                      <td><?php echo $row["Review_ID"]; ?></td>
                      <td><?php echo $row["Negative_Review"]; ?></td>
                      <td><?php echo $row["Positive_Review"]; ?></td>
                      <td><?php echo $row["Reviewer_Score"]; ?></td>
                      <td><?php echo $row["Review_Date"]; ?></td>
                                          
                    <!-- End first row. Note this will repeat for each row in the $result variable-->
                    </tr>
                  <?php } ?>
                  <!-- End table body -->
                </tbody>
                <!-- End table -->
            </table>
  
        <?php } else { ?>
          <!-- IF query execution resulted in error display the following message-->
          <h3>Sorry, no results found for <?php echo $_POST['field_hotel_name']; ?>. </h3>
        <?php }
    } ?>


    
  </body>
</html>