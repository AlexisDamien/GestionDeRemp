<?php
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }
    $page = $_POST['page'];
    if ($page == "Gestionnaire"){
        try {
            $req = $pdo->prepare("UPDATE Gestionnaire set genom=?, prenom=?, pole=?, arrive=? WHERE gestionid=?");
            $req->execute(array($_POST['genom'], $_POST['prenom'], $_POST['pole'], $_POST['arrive'], $_POST['gestionid']));
            $req->closeCursor();
        }  catch (PDOException $e) {
            die("Erreur" .$e);
    }
    }



?>