#Decomposition
#create hotel_reg table and insert values
DROP TABLE IF EXISTS hotel_reg;
CREATE TABLE hotel_reg (
  Hotel_City                                   VARCHAR(70),
  Hotel_State                                  VARCHAR(70) DEFAULT NULL,
  Hotel_Country                                VARCHAR(70) DEFAULT NULL,
  PRIMARY KEY (Hotel_City),
  INDEX (Hotel_City)
  )ENGINE=InnoDB;


INSERT INTO hotel_reg
SELECT  DISTINCT Hotel_City, Hotel_State, Hotel_Country
FROM hotel
WHERE Hotel_State IS NOT NULL;


#create hotel_info table and insert values
DROP TABLE IF EXISTS hotel_info;
CREATE TABLE hotel_info (
  Hotel_Address                                VARCHAR(255),
  Hotel_City                                   VARCHAR(70) DEFAULT NULL,
  Businesses_100m                              INT DEFAULT NULL,
  Businesses_1km                               INT DEFAULT NULL,
  Businesses_5km                               INT DEFAULT NULL,
  PRIMARY KEY (Hotel_Address),
  INDEX (Hotel_City),
  INDEX (Hotel_Address)
)ENGINE=InnoDB;

INSERT INTO hotel_info
SELECT  DISTINCT Hotel_Address, Hotel_City, Businesses_100m, Businesses_1km, 
				 Businesses_5km
FROM hotel;


#create hotel_overview table and insert values
#hotel_id should be unsigned auto_increment integer
DROP TABLE IF EXISTS hotel_overview;
CREATE TABLE hotel_overview (
  Hotel_ID									   INT UNSIGNED AUTO_INCREMENT,
  Hotel_Name                                   VARCHAR(70) DEFAULT NULL,
  Hotel_Address                                VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY(Hotel_ID),
  INDEX (Hotel_Address),
  INDEX (Hotel_ID)
)ENGINE=InnoDB;

INSERT INTO hotel_overview(Hotel_Name, Hotel_Address)
SELECT  DISTINCT Hotel_Name, Hotel_Address
FROM hotel;


 #create hotel_loc table and insert values
DROP TABLE IF EXISTS hotel_loc;
CREATE TABLE hotel_loc (
  Hotel_lat                                    VARCHAR(70),
  Hotel_lng                                    VARCHAR(70),
  PRIMARY KEY(Hotel_lat)
)
ENGINE=InnoDB;

INSERT INTO hotel_loc
SELECT  DISTINCT Hotel_lat, Hotel_lng
FROM hotel;


#create reviewers table and insert values
DROP TABLE IF EXISTS reviewers;
CREATE TABLE reviewers (
  Reviewer_Nationality                         VARCHAR(70),
  Reviewer_Country                             VARCHAR(70),
  PRIMARY KEY(Reviewer_Nationality)
)
ENGINE=InnoDB;

INSERT INTO reviewers
SELECT  DISTINCT Reviewer_Nationality, Reviewer_Country
FROM hotel;


#create review_days table and insert values
#review_date is in the data dimension based on the original data
DROP TABLE IF EXISTS review_days;
CREATE TABLE review_days (
  Review_Date                                  DATE,
  Day_of_Week                                  INT,
  Day_of_Year                                  INT,
  Week_of_Month                                INT,
  Week_of_Year                                 INT,
  Quarter_of_Year                              INT,
  PRIMARY KEY (Review_Date)
)
ENGINE=InnoDB;

INSERT INTO review_days
SELECT  DISTINCT Review_Date, Day_of_Week, Day_of_Year, Week_of_Month, 
				 Week_of_Year, Quarter_of_Year
FROM hotel;


#create reviews table and insert values
#review score should be integers between 0 to 10 (both inclusive)
DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
  Review_ID                                    INT UNSIGNED AUTO_INCREMENT NOT NULL,
  Hotel_ID		                               INT UNSIGNED DEFAULT NULL,
  Hotel_lat                                    VARCHAR(70) DEFAULT NULL,
  Guest_Type                                   VARCHAR(70) DEFAULT NULL,
  Trip_Type                                    VARCHAR(70) DEFAULT NULL,
  Stay_Duration                                INT DEFAULT NULL,
  Review_Is_Positive                           INT DEFAULT NULL,
  Negative_Review                              VARCHAR(2000) DEFAULT NULL,
  Review_Total_Negative_Word_Counts            INT DEFAULT NULL,
  Positive_Review                              VARCHAR(2000) DEFAULT NULL,
  Review_Total_Positive_Word_Counts            INT DEFAULT NULL,
  Submitted_from_Mobile                        INT DEFAULT NULL,
  Room_Type                                    VARCHAR(70) DEFAULT NULL,
  Room_Type_Level                              VARCHAR(70) DEFAULT NULL,
  Bed_Type                                     VARCHAR(70) DEFAULT NULL,
  Reviewer_Nationality                         VARCHAR(70) DEFAULT NULL,
  Reviewer_Score                               INT DEFAULT NULL CHECK(Reviewer_Score IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
  Review_Date                                  DATE DEFAULT NULL,
  PRIMARY KEY (Review_ID),
  INDEX (Review_ID),
  INDEX (Hotel_ID),
  CONSTRAINT fk_reviews_overview
  FOREIGN KEY (Hotel_ID)
	REFERENCES hotel_overview(Hotel_ID)
	ON DELETE CASCADE
	ON UPDATE CASCADE
)
ENGINE=InnoDB;

INSERT INTO reviews(Review_ID, Hotel_ID, Hotel_lat, Guest_Type, Trip_Type, Stay_Duration, Review_Is_Positive, 
				 Negative_Review, Review_Total_Negative_Word_Counts, Positive_Review, 
                 Review_Total_Positive_Word_Counts, Submitted_from_Mobile, Room_Type, 
                 Room_Type_Level, Bed_Type, Reviewer_Nationality, Reviewer_Score, Review_Date)
SELECT id, Hotel_ID, Hotel_lat, Guest_Type, Trip_Type, Stay_Duration, Review_Is_Positive, 
				 Negative_Review, Review_Total_Negative_Word_Counts, Positive_Review, 
                 Review_Total_Positive_Word_Counts, Submitted_from_Mobile, Room_Type, 
                 Room_Type_Level, Bed_Type, Reviewer_Nationality, Reviewer_Score, Review_Date
FROM hotel
	LEFT JOIN hotel_overview USING (Hotel_Name, Hotel_Address);


#create remaining table and insert values
#tags are long text, so we use text type here
DROP TABLE IF EXISTS remaining;
CREATE TABLE remaining (
  Review_ID                                    INT,
  Tags                                  	   TEXT,
  Review_Positivity_Rate                       DOUBLE,
  Total_Number_of_Reviews_Reviewer_Has_Given   INT,
  Days_Since_Review                            VARCHAR(70),
  Is_Hotel_Holiday                             INT,
  Is_Reviewer_Holiday                          INT,
  PRIMARY KEY (Review_ID)
)
ENGINE = InnoDB;

INSERT INTO remaining
SELECT DISTINCT ID, Tags, Review_Positivity_Rate, Total_Number_of_Reviews_Reviewer_Has_Given, 
				 Days_Since_Review, Is_Hotel_Holiday, Is_Reviewer_Holiday
FROM hotel;


#join all decomposed tables
SELECT COUNT(*)
FROM reviews
	JOIN hotel_overview USING(Hotel_ID)
    JOIN hotel_info USING (Hotel_Address)
    JOIN hotel_reg USING(Hotel_City)
    JOIN hotel_loc USING (Hotel_lat)
    JOIN review_days USING (Review_Date)
    JOIN reviewers USING (Reviewer_Nationality);   


#check all decomposed tables
SELECT * FROM reviews;
SELECT * FROM hotel_overview;
SELECT * FROM hotel_info;
SELECT * FROM hotel_reg;
SELECT * FROM hotel_loc;
SELECT * FROM review_days;
SELECT * FROM reviewers;
