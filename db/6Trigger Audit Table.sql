# Trigger - Audit Table
# create a audit table to store the review has been deleted
DROP TABLE IF EXISTS Review_Audit;
CREATE TABLE Review_Audit (
  Audit_ID                                     INT UNSIGNED AUTO_INCREMENT NOT NULL,
  Hotel_ID		                               INT UNSIGNED DEFAULT NULL,
  Review_ID                                    INT UNSIGNED NOT NULL,
  Negative_Review                              VARCHAR(2000) DEFAULT NULL,
  Positive_Review                              VARCHAR(2000) DEFAULT NULL,
  Reviewer_Score                               INT DEFAULT NULL,
  Review_Date                                  DATE DEFAULT NULL,
  Date_Deleted                                 DATE DEFAULT NULL,
  PRIMARY KEY (Audit_ID)
);

DROP TRIGGER IF EXISTS review_after_delete;
DELIMITER //
CREATE TRIGGER review_after_delete
AFTER DELETE
ON reviews
FOR EACH ROW
BEGIN
  INSERT INTO Review_Audit(Audit_ID, Hotel_ID, Review_ID, Negative_Review, 
						   Positive_Review, Reviewer_Score, Review_Date, Date_Deleted)
  VALUES (DEFAULT, OLD.Hotel_ID, OLD.Review_ID, OLD.Negative_Review, 
		  OLD.Positive_Review, OLD.Reviewer_Score, OLD.Review_Date, CURRENT_DATE());
END //
#SELECT * FROM Review_Audit;