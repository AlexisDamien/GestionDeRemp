<?php
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }
    $page = $_POST['page'];
    if ($page == "Gestionnaire"){
        try {
            $req = $pdo->prepare("UPDATE Gestionnaire SET genom=?, prenom=?, pole=?, arrive=? WHERE gestionid=?");
            $req->execute(array($_POST['genom'], $_POST['prenom'], $_POST['pole'], $_POST['arrive'], $_POST['gestionid']));
            $req->closeCursor();
        }  catch (PDOException $e) {
            die("Erreur" .$e);
        }
        header("location:./BddG.php");
    }
    elseif ($page == "Agence"){
        try {
            $req = $pdo->prepare("UPDATE Agence SET agnom=?, code=?, complexite=? WHERE agenceid=?");
            $req->execute(array($_POST['agnom'], $_POST['code'], $_POST['complexite'], $_POST['agenceid']));
            $req->closeCursor();
        }  catch (PDOException $e) {
            die("Erreur" .$e);
        }
        header("location:./BddA.php");
    }
    elseif ($page == "conge"){
        try {
            $req = $pdo->prepare("UPDATE Conge SET datedebut=?, datefin=?, typeconge=? WHERE congeid=?");
            $req->execute(array($_POST['dateDebut'], $_POST['dateFin'], $_POST['type'], $_POST['rowid']));
            $req->closeCursor();
        } catch (PDOException $e) {
            die ("Erreur .$e");
        }
        header("location:./Conge.php?gestionid={$_POST['gestionid']}");
    }




?>