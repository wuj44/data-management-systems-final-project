# Procedure
# create a procedure to delete an existing review
           
DROP PROCEDURE IF EXISTS delete_review;
DELIMITER //
CREATE PROCEDURE delete_review(IN input_Review_ID INT UNSIGNED)
BEGIN
    
	IF input_Review_ID NOT IN (SELECT Review_ID FROM reviews) THEN
		SIGNAL SQLSTATE '22003'
		SET MESSAGE_TEXT = 'Invalid Review ID. Please check.', 
		MYSQL_ERRNO = 1264;
	END IF;
    
    DELETE FROM reviews
    WHERE Review_ID = input_Review_ID;
    
END //
DELIMITER ;      

# test case
#CALL delete_review(15);
#CALL delete_review(515786);