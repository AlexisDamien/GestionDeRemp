
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\gen.css">
    <title>Remplacements</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class=""><a href="..\html\Index.html">Accueil</a></li>
                <li class="deroulant"><a href="#">Manager</a>
                    <ul class="sous">
                        <ul class="sous">
                            <li><a href="..\php\BddA.php">Agence</a></li>
                            <li><a href="..\php\BddG.php">Gestionnaire</a></li>
                            <li><a href="..\php\BddP.php">Portefeuille</a></li>
                            <li><a href="..\php\SR.php">Remplacements</a></li>
                        </ul>
                    </ul>
                </li>
                <li class=""><a href="..\php\Conge.php">Gestionnaire</a></li>
            </ul>
        </nav>
</header>
    <h2 class="title">Gestionnaire à remplacer</h2>
    <div>
        <table class="styled-table">
            <thead>
                <tr>
                    <td>Nom - Prénom</td>
                    <td>Equipe</td>
                    <td>Portefeuille</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $pdo = new PDO('sqlite:..\Adecco.db');
                    }  catch (PDOException $e) {
                            die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                    } 
                    //Récupération des portefeuilles de chaque Gestionnaires
                    $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo, code FROM Gestionnaire G left JOIN portefeuille P ON G.gestionid = P.gestionnaireporte left JOIN agence A ON A.agenceid = P.agenceporte WHERE dispo='Absent'");
                    foreach ($ListeS as $porte){
                        if (isset(${'portefeuille'.$porte['gestionid']})){
                            ${'portefeuille'.$porte['gestionid']} .= $porte['code'].", ";
                        }
                        elseif ($porte['code'] == ""){
                            ${'portefeuille'.$porte['gestionid']} = "";
                        }
                        else {
                            ${'portefeuille'.$porte['gestionid']} = "";
                            ${'portefeuille'.$porte['gestionid']} .= $porte['code'].", ";
                        }
                    }
                    //Tableau des "Personnes à remplacer"
                    $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo FROM Gestionnaire G left JOIN Remplacement R ON G.gestionid=R.idGestionAbs WHERE dispo='Absent' AND R.idGestionAbs IS NULL"); 
                    foreach ($ListeS as $liste){
                        echo("<tr>");
                        echo("<td>".$liste['genom']." ".$liste['prenom']."</td>");
                        echo("<td>".$liste['pole']."</td>");
                        if (isset(${'portefeuille'.$liste['gestionid']})){
                            echo("<td>".${'portefeuille'.$liste['gestionid']}."</td>");
                        }
                        else{
                            echo("<td>"."</td>");
                        }
                        echo("</tr>");
                    }
                ?>
            </tbody>
        </table>
    </div>
    <h2 class="title" >Gestionnaire En Remplacements</h2>
        <form action="Insert.php" method="post">
            <?php //Ajout d'un remplaçant pour un Gestionnaire absent
                try {
                    $pdo = new PDO('sqlite:..\Adecco.db');
                }  catch (PDOException $e) {
                        die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                }//Liste des personnes absentes
                $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo FROM Gestionnaire WHERE dispo='Absent'");
                echo "<select class='dropList' name='idGestionAbs'>";
                foreach ($ListeS as $remp){
                    echo "<option value='{$remp['gestionid']}'>{$remp['genom']}"." "."{$remp['prenom']}</option>";
                }
                echo "</select>";
                //Liste des remplaçants potentiels
                $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo FROM Gestionnaire WHERE dispo='Présent' AND anciennete='Supérieur à 6 mois'");
                echo "<select class='dropList' name='idGestionRemp'>";
                foreach ($ListeS as $remp){
                    echo "<option value='{$remp['gestionid']}'>{$remp['genom']}"." "."{$remp['prenom']}</option>";
                }
                echo "</select>";
            ?>
        <input type="submit" value='Ajouter' name="submit">
        <input type="hidden" value='SR' name="page">
    </form>
    <div>
        <table class="styled-table" >
            <thead>
                <tr>
                    <td>Remplaçant</td>
                    <td>Gestionnaire absent</td>
                    <td>Portefeuille</td>
                    <td>Dates</td>
                    <td>Edit.</td>
                    <td>Suppr.</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $pdo = new PDO('sqlite:..\Adecco.db');
                    }  catch (PDOException $e) {
                            die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                    }//Tableau des "Personnes en remplacements"
                    $ListeS = $pdo->query("SELECT R.idRemp, G.gestionid, G.genom as 'gestNomAbs', G.prenom as 'gestPrenomAbs', G2.genom, G2.prenom, C.datedebut, C.datefin FROM Gestionnaire G JOIN Remplacement R on R.idGestionAbs = G.gestionid JOIN Gestionnaire G2 on G2.gestionid = R.idGestionRemp INNER JOIN Conge C ON G.gestionid=C.gestionConge WHERE statut_conge ='En cours'")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($ListeS as $liste){
                        echo"<tr>";
                        echo"<td>{$liste['genom']}"." "."{$liste['prenom']}</td>";    
                        echo"<td>".$liste['gestNomAbs']." ".$liste['gestPrenomAbs']."</td>";
                        if (isset(${'portefeuille'.$liste['gestionid']})){
                            echo"<td>".${'portefeuille'.$liste['gestionid']}."</td>";
                        }
                        else{
                            echo"<td>"."</td>";
                        }
                        echo"<td>{$liste['datedebut']}"." - "."{$liste['datefin']}</td>";
                        echo "<td><button class='edit-btn' id='show-add' onclick='popup_show(\"popup2\",{$liste['gestionid']})'><img src=../img/editing.png witdh=15 height=15></button></td>";
                        echo "<td><a href='Delete.php?idRemp=$liste[idRemp]'><img src=../img/delete.png witdh=15 height=15></a></td>";
                        echo"</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>