# Procedure
#create a procedure to update the info of businesses aroud the hotel
DROP PROCEDURE IF EXISTS update_hotel_info;
DELIMITER //
CREATE PROCEDURE update_hotel_info(IN input_hotel_address VARCHAR(255), 
								   IN new_businesses_100m INT,
								   IN new_businesses_1km INT, 
								   IN new_businesses_5km INT)
BEGIN
	#check whether the input new_businesses is less than 0
	IF new_businesses_100m < 0 OR new_businesses_1km < 0 OR new_businesses_5km < 0 
    THEN
		SIGNAL SQLSTATE '22003'
		SET MESSAGE_TEXT = 'Invalid input number. Please input positive number.', 
		MYSQL_ERRNO = 1264;
	END IF;
	#check whether the input_hotel_address is in the database
	IF input_hotel_address NOT IN (SELECT DISTINCT Hotel_Address
					FROM hotel_info) 
	THEN
		SIGNAL SQLSTATE '22003'
		SET MESSAGE_TEXT = 'Invalid hotel address.',
		MYSQL_ERRNO = 1264;
	END IF;
    
	UPDATE hotel_info
	SET businesses_100m = new_businesses_100m,
        businesses_1km = new_businesses_1km,
        businesses_5km = new_businesses_5km
	WHERE hotel_address = input_hotel_address;

END //
DELIMITER ;


#Trigger -- Validation
#create a trigger to check ensure businesses_100m <= businesses_1km <= businesses_5km
DROP TRIGGER IF EXISTS update_hotel_info;
DELIMITER //
CREATE TRIGGER update_hotel_info
BEFORE UPDATE 
ON hotel_info
FOR EACH ROW 
BEGIN
	IF NEW.businesses_1km > NEW.businesses_5km THEN
		SET NEW.businesses_1km = NEW.businesses_5km;
	END IF;
    
	IF NEW.businesses_100m > NEW.businesses_1km THEN
		SET NEW.businesses_100m = NEW.businesses_1km;
	END IF;
END  //
DELIMITER ;


#CALL update_hotel_info('s Gravesandestraat 55 Oost 1092 AA Amsterdam Netherlands',
#						6, 429, 8600);
#SELECT * FROM hotel_info LIMIT 1;