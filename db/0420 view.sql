-- View

-- create a view to show hotel overview searched by city sort by average score
CREATE OR REPLACE VIEW hotel_score AS
SELECT Hotel_Name, 
       Hotel_City, 
       MAX(Hotel_Address) AS Hotel_Address, 
       ROUND(AVG(Reviewer_Score), 0) AS Average_Score, 
	   COUNT(*) AS Total_Number_of_Reviews, 
       MAX(Businesses_1km) AS Businesses_1km
FROM reviews
  JOIN hotel_overview USING (Hotel_ID)
  JOIN hotel_info USING (Hotel_Address)
GROUP BY Hotel_Name, Hotel_City
ORDER BY ROUND(AVG(Reviewer_Score), 0) DESC;

-- create a view to show hotel overview searched by city sort by number of reviews
CREATE OR REPLACE VIEW hotel_review AS
SELECT Hotel_Name, 
       Hotel_City, 
       MAX(Hotel_Address) AS Hotel_Address, 
       ROUND(AVG(Reviewer_Score), 0) AS Average_Score, 
	   COUNT(*) AS Total_Number_of_Reviews, 
       MAX(Businesses_1km) AS Businesses_1km
FROM reviews
  JOIN hotel_overview USING (Hotel_ID)
  JOIN hotel_info USING (Hotel_Address)
GROUP BY Hotel_Name, Hotel_City
ORDER BY COUNT(*) DESC;

-- create a view to show hotel overview searched by city sort by number of nearby businesses
CREATE OR REPLACE VIEW hotel_business AS
SELECT Hotel_Name, 
       Hotel_City, 
       MAX(Hotel_Address) AS Hotel_Address, 
       ROUND(AVG(Reviewer_Score), 0) AS Average_Score, 
	   COUNT(*) AS Total_Number_of_Reviews,
       MAX(Businesses_1km) AS Businesses_1km
FROM reviews
  JOIN hotel_overview USING (Hotel_ID)
  JOIN hotel_info USING (Hotel_Address)
GROUP BY Hotel_Name, Hotel_City
ORDER BY Businesses_1km DESC;


-- create a view to show reviews searched by hotel name sort by review date
CREATE OR REPLACE VIEW review_date AS
SELECT Hotel_Name, Hotel_City, Review_ID, Negative_Review, Positive_Review, Reviewer_Score, Review_Date
FROM reviews
  JOIN hotel_overview USING (Hotel_ID)
  JOIN hotel_info USING (Hotel_Address)
ORDER BY Review_Date DESC, Review_ID DESC;

-- create a view to show reviews searched by hotel name sort by reviewer score desc
CREATE OR REPLACE VIEW review_score AS
SELECT Hotel_Name, Hotel_City, Review_ID, Negative_Review, Positive_Review, Reviewer_Score, Review_Date
FROM reviews
  JOIN hotel_overview USING (Hotel_ID)
  JOIN hotel_info USING (Hotel_Address)
ORDER BY Reviewer_Score DESC, Review_ID DESC;

-- create a view to show reviews searched by hotel name sort by reviewer score asc
CREATE OR REPLACE VIEW review_score AS
SELECT Hotel_Name, Hotel_City, Review_ID, Negative_Review, Positive_Review, Reviewer_Score, Review_Date
FROM reviews
  JOIN hotel_overview USING (Hotel_ID)
  JOIN hotel_info USING (Hotel_Address)
ORDER BY Reviewer_Score, Review_ID DESC;