# Procedure
# create a procedure to insert a review

DROP PROCEDURE IF EXISTS insert_review;
DELIMITER //
CREATE PROCEDURE insert_review(IN input_Hotel_Name VARCHAR(70),
							   IN input_Hotel_City VARCHAR(70),
							   IN input_Negative_Review VARCHAR(2000), 
							   IN input_Positive_Review VARCHAR(2000), 
							   IN input_Reviewer_Score INT,
                               OUT output_Review_ID INT)
BEGIN
    
	#check whether the input_Reviewer_Score is between 0 and 10 (both are inclusive)
	IF input_Reviewer_Score < 0 OR input_Reviewer_Score > 10 THEN
		SIGNAL SQLSTATE '22003'
		SET MESSAGE_TEXT = 'Invalid score. Please input integer between 0 to 10.', 
		MYSQL_ERRNO = 1264;
	END IF;
    
	#check whether input_Hotel_City and input_Hotel_Name is in the database
	IF (SELECT Hotel_ID
			FROM (SELECT * 
				  FROM hotel_overview
					JOIN hotel_info USING (Hotel_Address)
					JOIN hotel_reg USING (Hotel_City)) temp
				  WHERE Hotel_Name = input_Hotel_Name AND Hotel_City = input_Hotel_City) IS NULL
	THEN
		SIGNAL SQLSTATE '22003'
		SET MESSAGE_TEXT = 'Invalid hotel name or hotel city. Please check.',
		MYSQL_ERRNO = 1264;
	END IF;
    
    INSERT reviews (Hotel_ID, Negative_Review, Positive_Review, Reviewer_Score, Review_Date)
    VALUES((SELECT Hotel_ID
			FROM (SELECT * 
				  FROM hotel_overview
					JOIN hotel_info USING (Hotel_Address)
					JOIN hotel_reg USING (Hotel_City)) temp
				  WHERE Hotel_Name = input_Hotel_Name AND Hotel_City = input_Hotel_City), 
            input_Negative_Review, input_Positive_Review, ROUND(input_Reviewer_Score, 0), CURRENT_DATE());
	SET output_Review_ID = (SELECT Review_ID FROM reviews ORDER BY Review_ID DESC LIMIT 1);
END //
DELIMITER ;      

#CALL insert_review('Hotel Whistler', 'Paris', 'www', 'aaa', 5, @output_Review_ID);
#SELECT @output_Review_ID;
#DELETE FROM reviews where Review_ID >= 515751;