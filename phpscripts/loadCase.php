<?php
/**
 * Created by PhpStorm.
 * User: Astrid D
 * Date: 19.01.2017
 * Time: 13:13
 */
session_start();
class fullCase {
    // von f_fall
    public $zuname;
    public $nachname;
    public $titel;
    public $strasse;
    public $ort;
    public $plz;
    public $gebDat;
    public $messungaf2;
    public $messungaf1;
    public $messungspo1;
    public $messungspo2;
    public $messungHF1;
    public $messungHF2;
    public $messungRR1;
    public $messungRR2;
    public $messungBZ1;
    public $messungBZ2;
    public $messungC1;
    public $messungC2;
    public $beginnzeit;
    public $endzeit;
    public $vorgeschehen;
    public $patGeschichte;
    public $verdachtsdiagnose;
    public $risikofaktoren;
    public $RTWstandort;
    public $RTWNR;
    public $notarzt;

    //von Atmung
    public $unauffaelig;
    public $atembeschwerden;
    public $atemwegsverlegung;
    public $abnormeAtemger;
    public $asymbkbeweg;
    public $keineNormAtm;
    public $hypervent;

    //von Kreislauf
    public $starkeBlutung;
    public $arrythmie;
    public $schockzustand;
    public $atemkreislaufstillst;
    public $verbrennung;
    public $veraetzung;

    // von massnahmen
    public $helmabnahme;
    public $absaugung;
    public $esmarchhandgriff;
    public $guedeltubus;
    public $larynxtubus;
    public $beatmung;
    public $rueckatmung;
    public $sauerstoffgabe;
    public $heimlichmanoever;
    public $ekg;
    public $infusion;
    public $herzdruckmassage;
    public $defi;
    public $defianzahl;
    public $blutstillung;
    public $ksSonstige;
    public $rautegriff;
    public $rettungstuch;
    public $schaufeltrage;
    public $spineboad;
    public $hwsschinung;
    public $extSchinung;
    public $vakuummatraze;
    public $rettungskorsett;
    public $arztanwesend;
    public $amputation;
    public $amputationext;
    public $augenspuelung;
    public $entbindung;
    public $ewmasnhamensonsginge;
    public $arztname;
    public $perVenenzugang;
    public $medikamentenapplication;

    //von Neuro
    public $krampfgeschehn;
    public $spracstoerung;
    public $pupillelinks;
    public $pupillerechts;
    public $schmerzbeurteilung;

    //von lagebeurteilung
    public $orientiert;
    public $desorientiert;
    public $erregungszustand;
    public $OhneBewusstsein;
    public $sichereTodeszeichen;
    public $gehend;
    public $sitzend;
    public $liegend;
    public $vorgefundenSonstiges;
    public $gefahrenzone;


}
try{
    if(isset($_SESSION['selectid'])) {
        $caseID = $_SESSION['selectid'];
        $cases = Array();

        $db = new mysqli('epa.htl5.org', 'epa', 'epateam', 'dunst_epa');
        $sql = "SELECT * FROM f_fall WHERE f_id = '$caseID' ;";
        $logfile = fopen("logfile.txt", "a");
        $date = date("d.m.Y H:i:s");
        fwrite($logfile, $date . "     SQL: " ." SELECT * WHERE f_id = '$caseID' ;". "\n");
        fclose($logfile);


        if (!$result = $db->query($sql)) {
            die('There was an error running the query [' . $db->error . ']');
            $logfile = fopen("logfile.txt", "a");
            $date = date("d.m.Y H:i:s");
            fwrite($logfile, $date . "     Failed DB: " . $db->error . "\n");
            fclose($logfile);

        }

        $werteabfrage = $db->query($sql);
        if ($werteabfrage) {
            while ($row = $werteabfrage->fetch_assoc()) {
                //$_SESSION['b_id'] = $row['b_id'];
                $b = new fullCase();
                $b->zuname = $row['f_zuname'];
                $b->nachname = $row['f_vorname'];
                $b->titel = $row['f_titel'];
                $b->messungaf1 = $row['f_messungAF1'];
                $b->strasse = $row['f_strasse'];
                $faelle[] = $b;
            }
        }
        $result->close();
        $db->close();
        $ausgabe = json_encode($faelle);
        echo $ausgabe;
    } else {
        $logfile =fopen("logfile.txt","a");
        $date = date("d.m.Y H:i:s");
        fwrite($logfile,$date."     Session not set"."\n");
        fclose($logfile);
    }
} catch (Exception $e){
    insertLogFile($e->getMessage());
}
function insertLogFile($text){
    $logfile =fopen("logfile.txt","a");
    $date = date("d.m.Y H:i:s");
    fwrite($logfile,$date."     ".$text."\n");
    fclose($logfile);
}
