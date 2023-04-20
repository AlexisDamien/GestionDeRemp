<?php
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }

    if (isset($_GET["idagence"])){
        try {
            $req = $pdo->prepare("DELETE FROM Agence WHERE agenceid=?");
            $req->execute(array($_GET["idagence"]));
        } 
            catch (PDOException $e) {
                die("Erreur" .$e);
            }
        header("location:./BddA.php");
    }
        elseif (isset($_GET["idgestion"])){
            try {
                $req = $pdo->prepare("DELETE FROM Gestionnaire WHERE gestionid=?");
                $req->execute(array($_GET["idgestion"]));
            } 
                catch (PDOException $e) {
                    die("Erreur" .$e);
                }
            header("location:./BddG.php");
        }
        elseif (isset($_GET["idporte"])){
            try {
                $req = $pdo->prepare("SELECT gestionid FROM Gestionnaire G INNER JOIN Portefeuille P ON G.gestionid=P.gestionnaireporte WHERE porteid=?");
                $req->execute(array($_GET['idporte']));
                foreach ($req as $reqlist) {
                    $idporte = $reqlist['gestionid'];
                    echo $id;
                }
                $req = $pdo->prepare("DELETE FROM Portefeuille WHERE porteid=?");
                $req->execute(array($_GET["idporte"]));
            }
                catch (PDOException $e) {
                    die("Erreur" .$e);
                }
            header("location:./BddP.php?gestionid={$idporte}");
        }
        elseif (isset($_GET['idconge'])){
            try {
                $req = $pdo->prepare("SELECT gestionConge FROM Conge WHERE congeid=?");
                $req->execute(array($_GET['idconge']));
                foreach ($req as $reqlist){
                    $id = $reqlist['gestionConge'];
                }
                $req = $pdo->prepare("DELETE FROM Conge WHERE congeid=?");
                $req->execute(array($_GET['idconge']));
            }
                catch (PDOException $e){
                    die("Erreur" .$e);
                }
            header("location:./Conge.php?gestionid={$id}");
        }
        elseif (isset($_GET['idRemp'])){
            try {
                $req = $pdo->prepare("DELETE FROM Remplacement WHERE idRemp=?");
                $req->execute(array($_GET['idRemp']));
            }
                catch (PDOException $e){
                    die("Erreur" .$e);
                }
            header("location:./SR.php");
        }

?>