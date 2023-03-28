<?php
    if (isset($_POST['search'])){
        try{
            $pdo = new PDO('sqlite:..\Adecco.db');
        } catch (PDOException $e) {
            die("Erreur" .$e);
        }
        $nom = ucfirst($_POST['search']);
        try {
            $req = $pdo->prepare("SELECT * FROM Gestionnaire WHERE prenom LIKE '?%' or genom LIKE '?%'");
            $req->execute(array($nom));
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
        }
    }
    else{
        try{
            $pdo = new PDO('sqlite:..\Adecco.db');
            $req = $pdo->query("SELECT prenom, genom FROM Gestionnaire");
            $pdo = null;
        } catch (PDOException $e) {
            die("Erreur" .$e);
        }
        $noFirst = true;

        foreach ($req as $reqs){
            if (!$noFirst){
                echo ";";
            }               
            $noFirst = false;
            echo $reqs['prenom']." ".$reqs['genom'];
        }

    }   
?>