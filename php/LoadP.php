<?php
    $date = date('d/m/Y');
    $notHere = "Absent";
    $here = "Présent";
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }  
        try {
            $req = $pdo->query("SELECT datedebut, datefin, gestionnaire");
            foreach ($req as $request){
                if ($date >= $request['datedebut'] && $date <= $request['datefin'] ){
                    $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid=?");
                    $update->execute(array($notHere,$_POST['idGestion']));
                }
            }
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
        }
    header("location:./BddA.php");
?>