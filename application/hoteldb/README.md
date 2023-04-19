# Hotel Review

## Description

In this demo, you can find the information about hotel reviews for nearly 1,500 hotels across 6 countries in Europe, including location, nearby businesses, room types, reviews, etc. Following is the guidance of how to set up the environment on your laptop to run this demo locally.

## Getting Started

### Dependencies

* MySQL - 5.7.34
* PHP - 7.4.21

### Installing

* For Windows users
* MySQL Workbench - 8.0.27 (https://dev.mysql.com/downloads/workbench/)
* WampServer - 3.2.6 (https://www.wampserver.com/en/#download-wrapper)

* For Mac users
* MySQL Workbench - 8.0.28 (https://dev.mysql.com/downloads/workbench/)
* MAMP - 6.6(M1)/6.6(Intel)(https://www.mamp.info/en/downloads/)

#### MySQL Workbench Connection

* For Windows users
```
Connection Method = Standard (TCP/IP)
Hostname = 127.0.0.1
Port = 3306
Username = root
```

* For Mac users
```
Connection Method = Standard (TCP/IP)
Hostname = 127.0.0.1
Port = 8889
Username = root
```

#### PHP Connection

* For Windows users
* Go to C:/wamp64/www/hoteldb/conn.php, and set the connection as following
```
$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = '';
$dbname = 'hoteldb'; //Database name
$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
```

* For Mac users
* Go to /Applications/MAMP/htdocs/hoteldb/conn.php, and set the connection as following
```
$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = 'root';
$dbname = 'hoteldb'; //Database name
$dbo = new PDO('mysql:host=' . $dbhost . ';port=8889;dbname=' . $dbname, $dbuname, $dbpass);
```

### Executing program
* For Windows users
* Put the csv file in C:/wamp64/tmp
* Put the wu-xu-Project/application/hoteldb folder in C:/wamp64/www
* Set up new connection in MySQL Workbench
* Run .sql files in order in wu-xu-Project/db folder with MySQL Workbench
* Click (http://localhost/hoteldb/index.html) to get to the home page

* For Mac users
* Put the csv file wherever you want, copy and paste the path in 1Database Creation.sql load data part
* Put the wu-xu-Project/application/hoteldb folder in /Applications/MAMP/htdocs
* Set up new connection in MySQL Workbench
* Run .sql files in order in wu-xu-Project/db folder with MySQL Workbench
* Click (http://localhost:8888/hoteldb/index.html) to get to the home page

## Authors and Contact Info

* Jingyuan Wu jingyuan.wu@vanderbilt.edu
* Jingting Xu jingting.xu@vanderbilt.edu

## Version History

* 0.1
    * Initial Release

## License

This project is licensed under the MIT License
