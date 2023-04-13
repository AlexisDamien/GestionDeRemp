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
                die("Erreur" .$e);
        }
    header("location:./BddA.php");
    }
    elseif ($page == "Gestionnaire"){
        $dispo = 'Présent';
        try {
            $req = $pdo->prepare("INSERT INTO Gestionnaire (genom, prenom, pole, arrive, dispo, anciennete) VALUES (?,?,?,?,?,?)");
            $req->execute(array(ucfirst($_POST['genom']), ucfirst($_POST['prenom']), $_POST['pole'], $_POST['arrive'], $dispo, 'Inférieur à 6 mois'));
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur" .$e);
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
            $req = $pdo->prepare("INSERT INTO Conge (gestionConge, datedebut, datefin, typeconge) VALUES (?,?,?,?)");
            $req->execute(array($_POST['idGestion'],$_POST['dateDebut'],$_POST['dateFin'],$_POST['type']));
            $req->closeCursor();
        }   catch (PDOException $e){
            die("Erreur" .$e);
        }
        header("location:./Conge.php");
    }
?>