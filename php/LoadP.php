<?php
    $date = date('Y-m-d');
    $sixMonthDate = mktime(0, 0, 0, date("m")-6, date("d"),   date("Y"));
    $sixMonthDate = date('Y-m-d', $sixMonthDate);
    $notHere = "Absent";
    $here = "Présent";
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
    }  //Gestion de l'indicateur de disonibilité de la table Gestionnaire
    
    $req = $pdo->query("SELECT congeid, prenom, gestionid, datedebut, datefin, gestionConge, anciennete, arrive FROM gestionnaire G left outer join conge C ON G.gestionid=C.gestionConge");
    foreach ($req as $request){
        if ($date >= $request['datedebut'] && $date <= $request['datefin']){
            $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid={$request['gestionid']} AND dispo != 'En Remplacement'");
            $update->execute(array($notHere));
            $update = $pdo->prepare("UPDATE Conge SET statut_conge=? WHERE congeid={$request['congeid']}");
            $update->execute(array('En cours'));
        }
        else{
            $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid={$request['gestionid']}");
            $update->execute(array($here));
            if ($date > $request['datefin']){
                //$update = $pdo->prepare("UPDATE Conge SET statut_conge=? WHERE congeid={$request['congeid']}");
                //$update->execute(array('Terminé'));    
            }
            if ($date < $request['datedebut']){
                $update = $pdo->prepare("UPDATE Conge SET statut_conge=? WHERE congeid={$request['congeid']}");
                $update->execute(array('A venir'));    
            }
        }
        if ($sixMonthDate >= $request['arrive']){ //Gestion de l'indicateur d'anciennete de la table Gestionnaire
            $update = $pdo->prepare("UPDATE Gestionnaire SET anciennete='Supérieur à 6 mois' WHERE gestionid={$request['gestionid']}");
            $update->execute(array());
        }
    }
$req->closeCursor();
?>