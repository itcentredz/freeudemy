<?php 

/*
    Outil développé par ITCentre Informatique
    Email:  itcentredz@gmail.com
    Tel:    (+213) 796069321 
*/

$dbhost = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'freeudemy';

$db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
$db->query("CREATE TABLE IF NOT EXISTS courses (id int(5) AUTO_INCREMENT PRIMARY KEY, title varchar(100) UNIQUE NOT NULL, urlindirect varchar(100) NOT NULL, date varchar(20), urldirect varchar(100), categorie varchar(10), description text, old_price varchar(10), new_price varchar(10));");
