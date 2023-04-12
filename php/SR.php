
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
                <li>                
                </li>
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
    <h1>Personnes à remplacer</h1>
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
                    $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo, code FROM Gestionnaire G left JOIN portefeuille P ON G.gestionid = P.gestionnaire left JOIN agence A ON A.agenceid = P.agence WHERE dispo='Absent'");
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
                    $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo FROM Gestionnaire WHERE dispo='Absent'");
                    foreach ($ListeS as $liste){
                        $cpt = 0;
                        if($cpt%2 == 0){
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
                            $cpt++;
                        }
                        elseif ($cpt%2 <> 0){
                            echo("<tr class='active-row'>");
                            echo("<td>".$liste['genom']." ".$liste['prenom']."</td>");
                            echo("<td>".$liste['pole']."</td>");
                            if (isset(${'portefeuille'.$liste['gestionid']})){
                                echo("<td>".${'portefeuille'.$liste['gestionid']}."</td>");
                            }
                            else{
                                echo("<td>"."</td>");
                            }
                            echo("</tr>");
                            $cpt++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
                    
    <div class="foot"></div>
</body>
</html>