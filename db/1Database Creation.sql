-- Create database
DROP DATABASE IF EXISTS hoteldb;
CREATE DATABASE hoteldb;
USE hoteldb;

-- Create megatable
DROP TABLE IF EXISTS hotel;
CREATE TABLE hotel (
  id                                           INT,
  Hotel_Name                                   VARCHAR(70),
  Hotel_Address                                VARCHAR(255),
  Hotel_Country                                VARCHAR(70),
  Hotel_State                                  VARCHAR(70),
  Hotel_City                                   VARCHAR(70),
  Hotel_lat                                    VARCHAR(70),
  Hotel_lng                                    VARCHAR(70),
  Businesses_100m                              INT,
  Businesses_1km                               INT,
  Businesses_5km                               INT,
  Room_Type                                    VARCHAR(70),
  Room_Type_Level                              VARCHAR(70),
  Bed_Type                                     VARCHAR(70),
  Tags                                         TEXT,
  Guest_Type                                   VARCHAR(70),
  Trip_Type                                    VARCHAR(70),
  Stay_Duration                                INT,
  Review_Date                                  DATE,
  Day_of_Week                                  INT,
  Day_of_Year                                  INT,
  Days_Since_Review                            VARCHAR(70),
  Week_of_Month                                INT,
  Week_of_Year                                 INT,
  Is_Hotel_Holiday                             INT,
  Is_Reviewer_Holiday                          INT,
  Quarter_of_Year                              INT,
  Total_Number_of_Reviews                      INT,
  Review_Is_Positive                           INT,
  Review_Positivity_Rate                       DOUBLE,
  Reviewer_Nationality                         VARCHAR(70),
  Reviewer_Country                             VARCHAR(70),
  Negative_Review                              VARCHAR(2000),
  Review_Total_Negative_Word_Counts            INT,
  Positive_Review                              VARCHAR(2000),
  Review_Total_Positive_Word_Counts            INT,
  Average_Score                                INT,
  Reviewer_Score                               INT,
  Total_Number_of_Reviews_Reviewer_Has_Given   INT,
  Additional_Number_of_Scoring                 INT,
  Submitted_from_Mobile                        INT
);

-- Load data
LOAD DATA INFILE 'c:/wamp64/tmp/hotel_reviews_enriched.csv'
INTO TABLE hotel
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

-- Check the first 100 rows of megatable after loading data
SELECT * FROM hotel LIMIT 100;
