<?php
class Users
{
    public $id;
    public $zuname;
    public $vorname;
    public $username;
    public $admin;
    public $blocked;
}
try {
    $faelle = array();
    $db = new mysqli('epa.htl5.org', 'epa', 'epateam', 'dunst_epa');
    $sql = "SELECT b_id, b_zuname,b_vorname,b_username,b_blocked, b_admin FROM b_benutzer ";


    if (!$result = $db->query($sql)) {
        insertLogFile($db->error);
        die('There was an error running the query [' . $db->error . ']');

    }
    $werteabfrage = $db->query($sql);
    if ($werteabfrage) {
        while ($row = $werteabfrage->fetch_assoc()) {

            //$_SESSION['b_id'] = $row['b_id'];
            $b = new Users();
            $b->id = $row['b_id'];
            $b->zuname = $row['b_zuname'];
            $b->vorname = $row['b_vorname'];
            $b->username = $row['b_username'];
            $b->blocked = $row['b_blocked'];
            $b->admin = $row['b_admin'];
            $faelle[] = $b;

            //$_SESSION['istArzt'] = $row['U_IstArzt'];
        }
    }
    //var_dump($faelle);
    $result->close();
    $db->close();
    $ausgabe = json_encode($faelle);
    //insertLogFile("Übersicht der Benutzer: ".$ausgabe);
    echo $ausgabe;

} catch(Exception $e) {
    insertLogFile($e->getMessage());
}
function insertLogFile($text){
    $logfile =fopen("logfile.txt","a");
    $date = date("d.m.Y H:i:s");
    fwrite($logfile,$date."     ".$text."\n");
    fclose($logfile);
}