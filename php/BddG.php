<?php require('LoadP.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\gen.css">
    <title>Gestion Gestionnaire</title>
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
    <div class="button">
        <form action="Insert.php" method="post">
            <input type="text" placeholder="Nom Gestionnaire" name="genom" id="genom">
            <input type="text" placeholder="Prénom Gestionnaire" name="prenom" id="prenom">
            <select name="pole" id="pole">
                <option value="">--Pôle--</option>
                <option value="Pôle A">1. Pôle A</option>
                <option value="Pôle B">2. Pôle B</option>
                <option value="Carré VIP">3. Carré VIP</option>
                <option value="Gestionnaire dématéralisation">4. Gestionnaire dématéralisation</option>
            </select>
            Date d'arrivée : <input type="date" name="arrive" id="arrive">
            <input type="submit" value="Ajouter" name="submit">
            <input type="hidden" value="Gestionnaire" name="page"> 
        </form>
    </div>
    <div>
    <div>
        <table class="styled-table">
            <thead>
                <tr>
                    <td>Nom - Prénom</td>
                    <td>Equipe</td>
                    <td>Ancienneté</td>
                    <td>Portefeuille</td>
                    <td>Disponibilité</td>
                    <td>Edit.</td>
                    <td>Suppr.</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $portefeuille = "";
                    try {
                        $pdo = new PDO('sqlite:..\Adecco.db');
                    }  catch (PDOException $e) {
                            die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                    }
                        $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo, code FROM Gestionnaire G INNER JOIN portefeuille P ON G.gestionid = P.gestionnaire INNER JOIN agence A ON A.agenceid = P.agence");
                        foreach ($ListeS as $porte){
                            if (isset(${'portefeuille'.$porte['gestionid']})){
                                ${'portefeuille'.$porte['gestionid']} .= $porte['code'].", ";
                            }
                            else {
                                ${'portefeuille'.$porte['gestionid']} = "";
                                ${'portefeuille'.$porte['gestionid']} .= $porte['code'].", ";
                            }
                        }
                        $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo FROM Gestionnaire");
                        foreach ($ListeS as $liste){
                            $cpt = 0;
                            if($cpt%2 == 0){
                                echo("<tr>");
                                echo("<td>".$liste['genom']." ".$liste['prenom']."</td>");
                                echo("<td>".$liste['pole']."</td>");
                                echo("<td>".$liste['anciennete']."</td>");
                                if (isset(${'portefeuille'.$liste['gestionid']})){
                                    echo("<td>".${'portefeuille'.$liste['gestionid']}."</td>");
                                }
                                else{
                                    echo("<td>"."</td>");
                                }
                                if ($liste['dispo'] == "Présent"){
                                    echo("<td class='here'>".$liste['dispo']."</td>");
                                }
                                else{
                                    echo("<td class='nothere'>".$liste['dispo']."</td>");
                                }
                                echo("<td><img src=../img/editing.png witdh=15 height=15></td>");
                                echo("<td><a href='Delete.php?idgestion=$liste[gestionid]'><img src=../img/delete.png witdh=15 height=15></a></td>");
                                echo("</tr>");
                                $cpt++;
                            }
                            elseif ($cpt%2 <> 0){
                                echo("<tr class='active-row'>");
                                echo("<td>".$liste['genom']." ".$liste['prenom']."</td>");
                                echo("<td>".$liste['pole']."</td>");
                                echo("<td>".$liste['anciennete']."</td>");
                                if (isset(${'portefeuille'.$liste['gestionid']})){
                                    echo("<td>".${'portefeuille'.$liste['gestionid']}."</td>");
                                }
                                else{
                                    echo("<td>"."</td>");
                                }
                                if ($liste['dispo'] == "Présent"){
                                    echo("<td class='here'>".$liste['dispo']."</td>");
                                }
                                else{
                                    echo("<td class='nothere'>".$liste['dispo']."</td>");
                                }
                                echo("<td>"."</td>");
                                echo("<td><a href='Delete.php?idgestion=$liste[gestionid]'><img src=../img/delete.png witdh=15 height=15></a></td>");
                                echo("</tr>");
                                $cpt++;
                            }
                        }
                ?>
            </tbody>
        </table>
    </div>
    </div>
    <div class="foot"></div>
</body>
</html>