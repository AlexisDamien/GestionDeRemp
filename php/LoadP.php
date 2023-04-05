<?php
    $date = date('Y-m-d');
    $notHere = "Absent";
    $here = "Présent";
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }  
        try {
            $req = $pdo->query("SELECT prenom, gestionid, datedebut, datefin, gestionConge FROM gestionnaire G left outer join conge C ON G.gestionid=C.gestionConge");
            foreach ($req as $request){
                if ($date >= $request['datedebut'] && $date <= $request['datefin']){
                    $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid={$request['gestionid']}");
                    $update->execute(array($notHere));
                }
                else{
                    $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid={$request['gestionid']}");
                    $update->execute(array($here));
                }
            }
            $req->closeCursor();
        }  catch (PDOException $e) {
                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
        }
?>