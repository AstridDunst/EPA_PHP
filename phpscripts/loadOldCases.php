<?php
/**
 * Created by PhpStorm.
 * User: Astrid D
 * Date: 20.01.2017
 * Time: 15:13
 */
class OverviewOldCase
{
    public $id;
    public $vorgeschehen;
    public $beginnzeit;
    public $verdachtsdiagnose;
    public $rtw;
    public $rtwNr;
    public $doctor;
    public $timeEnd;
}
try {
    $faelle = array();
    $db = new mysqli('epa.htl5.org', 'epa', 'epateam', 'dunst_epa');
    $sql = "SELECT f_id, f_vorgeschehen, f_beginnzeit, f_endzeit,f_verdachtsdiagnose, f_standort, f_stnummer, f_arzt FROM f_fall WHERE f_isActive = 0 ";


    if (!$result = $db->query($sql)) {
        insertLogFile($db->error);
        die('There was an error running the query [' . $db->error . ']');

    }
    $werteabfrage = $db->query($sql);
    if ($werteabfrage) {
        while ($row = $werteabfrage->fetch_assoc()) {

            //$_SESSION['b_id'] = $row['b_id'];
            $b = new OverviewOldCase();
            $b->id = $row['f_id'];
            $b->vorgeschehen = $row['f_vorgeschehen'];
            $b->beginnzeit = $row['f_beginnzeit'];
            $b->verdachtsdiagnose = $row['f_verdachtsdiagnose'];
            $b->rtw = $row['f_standort'];
            $b->rtwNr = $row['f_stnummer'];
            $b->doctor = htmlentities($row['f_arzt']);
            $b->timeEnd = $row['f_endzeit'];
            $faelle[] = $b;

            //$_SESSION['istArzt'] = $row['U_IstArzt'];
        }
    }
    //var_dump($faelle);
    $result->close();
    $db->close();
    $ausgabe = json_encode($faelle);
    insertLogFile("Übersicht alte Fälle: ".$ausgabe);
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
//}

//}
