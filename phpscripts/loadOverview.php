<?php
/**
 * Created by PhpStorm.
 * User: Astrid D
 * Date: 28.03.2016
 * Time: 12:53
 */
class Overview
{
    public $id;
    public $vorgeschehen;
    public $beginnzeit;
    public $verdachtsdiagnose;
    public $rtw;
    public $rtwNr;
}
try {
    $faelle = array();
    //$userid = $_SESSION['b_id'];
//Datenbankzugriff
//$db = new MySQLi('localhost','root','','nomaez');
    $db = new mysqli('epa.htl5.org', 'epa', 'epateam', 'dunst_epa');
    $sql = "SELECT f_id, f_vorgeschehen, f_beginnzeit, f_verdachtsdiagnose, f_standort, f_stnummer	 FROM f_fall WHERE f_isActive = 1 ;";


    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    }
    $werteabfrage = $db->query($sql);
    if ($werteabfrage) {
        while ($row = $werteabfrage->fetch_assoc()) {
            //$_SESSION['b_id'] = $row['b_id'];
            $b = new Overview();
            $b->id = $row['f_id'];
            $b->vorgeschehen = $row['f_vorgeschehen'];
            $b->beginnzeit = $row['f_beginnzeit'];
            $b->verdachtsdiagnose = $row['f_verdachtsdiagnose'];
            $b->rtw = $row['f_standort'];
            $b->rtwNr = $row['f_stnummer'];
            $faelle[] = $b;

            //$_SESSION['istArzt'] = $row['U_IstArzt'];
        }
    }
    $result->close();
    $db->close();
    $ausgabe = json_encode($faelle);
    insertLogFile("Aktuell: ".$ausgabe);
    echo $ausgabe;

} catch(Exception $e) {
    insertLogFile($e->getMessage());
}
//}
function insertLogFile($text){
    $logfile =fopen("logfile.txt","a");
    $date = date("d.m.Y H:i:s");
    fwrite($logfile,$date."     ".$text."\n");
    fclose($logfile);
}
//}
?>