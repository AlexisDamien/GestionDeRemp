<?php
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }  
     $page = $_POST['page'];
    if ($page == "Agence"){
        try {
            $req = $pdo->prepare("INSERT INTO Agence (code,agnom, complexite) VALUES (?,?,?)");
            $req->execute(array($_POST['code'], $_POST['agnom'], $_POST['complexite']));
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
        }
    header("location:./BddA.php");
    }
    elseif ($page == "Gestionnaire"){
        $dispo = 'Présent';
        try {
            $req = $pdo->prepare("INSERT INTO Gestionnaire (genom, prenom, pole, anciennete, dispo) VALUES (?,?,?,?,?)");
            $req->execute(array(ucfirst($_POST['genom']), ucfirst($_POST['prenom']), $_POST['pole'], $_POST['anciennete'], $dispo));
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
        }
    header("location:./BddG.php");
    }
    elseif ($page == "portefeuille"){
        try{
            $req = $pdo->prepare("INSERT INTO Portefeuille (gestionnaire, agence) VALUES (?,?)");
            $req->execute(array($_POST['idGestion'], $_POST['agenceid']));
            $req->closeCursor();
        }   catch (PDOException $e) {
            die("Erreur" .$e);
        }
        header("location:./BddP.php");
    }
    elseif ($page == "conge"){
        try{
            $req = $pdo->prepare("INSERT INTO Conge (gestionnaire, datedebut, datefin, typeconge) VALUES (?,?,?,?)");
            $req->execute(array($_POST['idGestion'],$_POST['dateDebut'],$_POST['dateFin'],$_POST['type']));
            $req->closeCursor();
        }   catch (PDOException $e){
            die("Erreur" .$e);
        }
        header("location:./Conge.php");
    }
?>