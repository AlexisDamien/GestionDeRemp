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
                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
            }
        header("location:./BddA.php");
    }
        elseif (isset($_GET["idgestion"])){
            try {
                $req = $pdo->prepare("DELETE FROM Gestionnaire WHERE gestionid=?");
                $req->execute(array($_GET["idgestion"]));
            } 
                catch (PDOException $e) {
                    die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                }
            header("location:./BddG.php");
        }
        elseif (isset($_GET["idporte"])){
            try {
                $req = $pdo->prepare("DELETE FROM Portefeuille WHERE porteid=?");
                $req->execute(array($_GET["idporte"]));
            }
                catch (PDOException $e) {
                    die("Erreur" .$e);
                }
            header("location:./BddP.php");
        }
        elseif (isset($_GET['idconge'])){
            try {
                $req = $pdo->prepare("DELETE FROM Conge WHERE congeid=?");
                $req->execute(array($_GET['idconge']));
            }
                catch (PDOException $e){
                    die("Erreur" .$e);
                }
            header("location:./Conge.php");
        }
?>