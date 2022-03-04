<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of dbConn
 *
 * @author Legnus
 */

$sName="localhost";
$uName="root";
$pass="";
$db_name="todo_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    echo "Conecção falhou : ". $e->getMessage();

}
