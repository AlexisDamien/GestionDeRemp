<?php
    $date = date('Y-m-d');
    $sixMonthDate = mktime(0, 0, 0, date("m")-6, date("d"),   date("Y"));
    $sixMonthDate = date('Y-m-d', $sixMonthDate);
    $notHere = "Absent";
    $here = "Présent";
    try{
        $pdo = new PDO('sqlite:..\Adecco.db');
    } catch (PDOException $e) {
        die("Erreur" .$e);
    }  
            $req = $pdo->query("SELECT prenom, gestionid, datedebut, datefin, gestionConge, anciennete, arrive FROM gestionnaire G left outer join conge C ON G.gestionid=C.gestionConge");
            foreach ($req as $request){
                if ($date >= $request['datedebut'] && $date <= $request['datefin']){
                    $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid={$request['gestionid']}");
                    $update->execute(array($notHere));
                }
                else{
                    $update = $pdo->prepare("UPDATE Gestionnaire SET dispo=? WHERE gestionid={$request['gestionid']}");
                    $update->execute(array($here));
                }
                if ($sixMonthDate >= $request['arrive']){
                    $update = $pdo->prepare("UPDATE Gestionnaire SET anciennete='Supérieur à 6 mois' WHERE gestionid={$request['gestionid']}");
                    $update->execute(array());
                }
            }
            $req->closeCursor();
?>