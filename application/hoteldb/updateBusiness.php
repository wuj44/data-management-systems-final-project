<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_hotel_address = $_POST['field_hotel_address'];
    $var_new_businesses_100m = $_POST['field_new_businesses_100m'];
    $var_new_businesses_1km = $_POST['field_new_businesses_1km'];
    $var_new_businesses_5km = $_POST['field_new_businesses_5km'];
    // Save the query into variable called $query. Note that :ph_hotel is a place holder
    $query = "CALL update_hotel_info(:ph_hotel_address, :ph_new_businesses_100m, :ph_new_businesses_1km, :ph_new_businesses_5km)";
try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_hotel to the place holder :ph_hotel  
      // Use PDO::PARAM_STR to sanitize user string.
      $prepared_stmt->bindValue(':ph_hotel_address', $var_hotel_address, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_new_businesses_100m', $var_new_businesses_100m, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':ph_new_businesses_1km', $var_new_businesses_1km, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':ph_new_businesses_5km', $var_new_businesses_5km, PDO::PARAM_INT);
      #$prepared_stmt->execute();
      // Fetch all the values based on query and save that to variable $result
      $result = $prepared_stmt->execute();
      #$result = $prepared_stmt->fetchAll();

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
    
    <h1>Update Business</h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">

      <label for="id_hotel_address">Hotel Address</label>
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_hotel = $_POST['field_hotel']; id attribute is referred in label tag above on line 52-->
      <input type="text" name="field_hotel_address" id = "id_hotel_address">
      <label for="id_hotel_address">New Businesses within 100m</label>
      <input type="text" name="field_new_businesses_100m" id = "id_new_businesses_100m">
      <label for="id_hotel_address">New Businesses within 1km</label>
      <input type="text" name="field_new_businesses_1km" id = "id_new_businesses_1km">
      <label for="id_hotel_address">New Businesses within 5km</label>
      <input type="text" name="field_new_businesses_5km" id = "id_new_businesses_5km">
      <!-- label for="id_hotel_city">Hotel City</label -->
      <!--<input type="text" name="field_hotel_city" id = "id_hotel_city" -->
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Submit.
      The name attribute is referred  on line 3 and line 61. -->
      <input type="submit" name="field_submit" value="Submit">
    </form>
    
    <?php
      if (isset($_POST['field_submit'])) {
        if ($result) { 
    ?>
          Updated successfully.
    <?php 
        } else { 
    ?>
          <h3> Invalid input. </h3>
    <?php 
        }
      } 
    ?>


    
  </body>
</html>