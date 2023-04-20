<?php
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }  
    $page = $_POST['page'];
    if ($page == "Agence"){ //Ajout d'une agence dans la table Agence
        try {
            $req = $pdo->prepare("INSERT INTO Agence (code,agnom, complexite) VALUES (?,?,?)");
            $req->execute(array($_POST['code'], $_POST['agnom'], $_POST['complexite']));
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur" .$e);
        }
    header("location:./BddA.php");
    }
    elseif ($page == "Gestionnaire"){ //Ajout d'un gestionnaire dans la table Gestionnaire
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
    elseif ($page == "portefeuille"){ //Ajout d'une agence lié à un gestionnaire dans la table Portefeuille
        try{
            $req = $pdo->prepare("INSERT INTO Portefeuille (gestionnaireporte, agenceporte) VALUES (?,?)");
            $req->execute(array($_POST['idGestion'], $_POST['agenceid']));
            $req->closeCursor();
        }   catch (PDOException $e) {
            die("Erreur" .$e);
        }
        header("location:./BddP.php?gestionid={$_POST['idGestion']}");
    }
    elseif ($page == "conge"){//Création d'une période d'absence dans la table Conge pour un gestionnaire
        try{
            $req = $pdo->prepare("INSERT INTO Conge (gestionConge, datedebut, datefin, typeconge) VALUES (?,?,?,?)");
            $req->execute(array($_POST['idGestion'],$_POST['dateDebut'],$_POST['dateFin'],$_POST['type']));
            $req->closeCursor();
        }   catch (PDOException $e){
            die("Erreur" .$e);
        }
        header("location:./Conge.php?gestionid={$_POST['idGestion']}"); 
    }
    elseif ($page == "SR"){//Ajout d'un gestionnaire Présent récupérant la charge de travail d'un gestionnaire Absent dans la table Remplacement
        try{
            $req = $pdo->prepare("INSERT INTO Remplacement (idGestionAbs, idGestionRemp) VALUES (?,?)");
            $req->execute(array($_POST['idGestionAbs'],$_POST['idGestionRemp']));
            $req->closeCursor();
        }   catch (PDOException $e){
            die("Erreur" .$e);
        }
        header("location:./SR.php");
    }
?>