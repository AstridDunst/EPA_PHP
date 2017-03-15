<?php
/**
 * Created by PhpStorm.
 * User: Astrid D
 * Date: 27.01.2017
 * Time: 13:47
 */
try {
session_start();

$prename = $_POST['prename'];
$lastname = $_POST['lastname'];
$userName = $_POST['userName'];
$password = $_POST['password'];
$adminKZ = $_POST['adminKZ'];

$db =  $db = new mysqli('epa.htl5.org', 'epa', 'epateam', 'dunst_epa');
$sql = "INSERT INTO b_benutzer (b_zuname, b_vorname, b_username, b_password, b_admin, b_blocked)
                VALUES ('$prename', '$lastname', '$userName', '$password', '$adminKZ',0);";

if (!$result = $db->query($sql)) {
    die('There was an error running the query [' . $db->error . ']');
    insertLogFile('There was an error running the query [' . $db->error . ']');
    echo "n";
}
$result = mysql_query($sql, $db);
//$result->close();
$db->close();
insertLogFile("New User ".$userName." added.");
echo "y";
} catch(Exception $e) {
    insertLogFile($e->getMessage());
}

function insertLogFile($text){
    $logfile =fopen("logfile.txt","a");
    $date = date("d.m.Y H:i:s");
    fwrite($logfile,$date."     ".$text."\n");
    fclose($logfile);
}
