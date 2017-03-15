<?php
/**
 * Created by PhpStorm.
 * User: Astrid D
 * Date: 09.01.2017
 * Time: 16:30
 */
session_start();
$logfile =fopen("logfile.txt","a");
$date = date("d.m.Y H:i:s");
fwrite($logfile,"\n".$date."     Opened Login "."\n");
fclose($logfile);
try {
unset($_SESSION['b_id']);
if (isset($_POST['username'])) {
    //TODO: schauen ob Benutzer vorhanden wenn ja anmelden
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new mysqli('epa.htl5.org', 'epa', 'epateam', 'dunst_epa');
    $sql = "SELECT b_id, b_username, b_password FROM b_benutzer WHERE b_username = '$username' AND  b_password = '$password';";
    if(!$result = $db->query($sql)){
        $logfile =fopen("logfile.txt","a");
        $date = date("d.m.Y H:i:s");
        fwrite($logfile,$date."     Error in db Query ".$db->error."\n");
        fclose($logfile);
        die('There was an error running the query [' . $db->error . ']');

    }
    while($row = $result->fetch_assoc())
    {
        $_SESSION['b_id'] = $row['b_id'];
        $_SESSION['b_benutzer'] = $row['b_username'];

        //$_SESSION['istArzt'] = $row['U_IstArzt'];
    }
    $result->close();
    $db->close();

    if(isset($_SESSION['b_id'])) {
        echo "RollA.html";
    }
    else {
        //header('Location: authenticationFailed.html');
        //echo "<p>Einloggen fehlgeschlagen</p>";
        //echo "<a href='index.html'>Zur vorherigen Seite</a>";
        echo "hat nicht funktioniert";
    }
} else {
    echo "Ups es gab Probleme";
}
}catch (Exception $e) {
    insertLogFile($e->getMessage());
}

function insertLogFile($text){
    $logfile =fopen("logfile.txt","a");
    $date = date("d.m.Y H:i:s");
    fwrite($logfile,$date."     ".$text."\n");
    fclose($logfile);
}