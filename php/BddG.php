<?php require('LoadP.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\gen.css">
    <script src="../js/popup.js"></script>
    <title>Gestion Gestionnaire</title>
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
    <main>
        <div>
            <button class="new-btn" id="show-add" onclick='popup_show("popup1")'>Nouveau gestionnaire</button>
        </div>
        <div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Prénom</td>
                        <td>Equipe</td>
                        <td>Ancienneté</td>
                        <td>Portefeuille</td>
                        <td>Disponibilité</td>
                        <td>Edit.</td>
                        <td>Suppr.</td>
                        <td style="display:none;" ></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $portefeuille = "";
                        try {
                            $pdo = new PDO('sqlite:..\Adecco.db');
                        }  catch (PDOException $e) {
                                die("Erreur" .$e);
                        }
                        $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo, code FROM Gestionnaire G INNER JOIN portefeuille P ON G.gestionid = P.gestionnaireporte INNER JOIN agence A ON A.agenceid = P.agenceporte");
                        foreach ($ListeS as $porte){
                            if (isset(${'portefeuille'.$porte['gestionid']})){
                                ${'portefeuille'.$porte['gestionid']} .= $porte['code'].", ";
                            }
                            else {
                                ${'portefeuille'.$porte['gestionid']} = "";
                                ${'portefeuille'.$porte['gestionid']} .= $porte['code'].", ";
                            }
                        }
                        $ListeS = $pdo->query("SELECT gestionid, genom, prenom, pole, anciennete, dispo, arrive FROM Gestionnaire");
                        foreach ($ListeS as $liste){
                            echo"<tr rowId='{$liste['gestionid']}'>";
                            echo"<td class='edit'>".$liste['genom']."</td>";
                            echo"<td class='edit'>".$liste['prenom']."</td>";
                            echo"<td class='edit'>".$liste['pole']."</td>";
                            echo"<td>".$liste['anciennete']."</td>";
                            if (isset(${'portefeuille'.$liste['gestionid']})){
                                echo"<td>".${'portefeuille'.$liste['gestionid']}."</td>";
                            }
                            else{
                                echo"<td></td>";
                            }
                            if ($liste['dispo'] == "Présent"){
                                echo"<td class='here'>".$liste['dispo']."</td>";
                            }
                            else{
                                echo"<td class='nothere'>".$liste['dispo']."</td>";
                            }
                            echo "<td><button class='edit-btn' id='show-add' onclick='popup_show(\"popup2\",{$liste['gestionid']})'><img src=../img/editing.png witdh=15 height=15></button></td>";
                            echo "<td><a href='Delete.php?idgestion=$liste[gestionid]'><img src=../img/delete.png witdh=15 height=15></a></td>";
                            echo "<td style='display:none;' class='edit'>".$liste['arrive']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <div id="popup1" class="popup">
        <form action="Insert.php" method="post">
            <div class="close-btn" onclick='popup_hide("popup1")'>&times;</div>
            <h3>Nouveau gestionnaire</h3>
            <input type="text" placeholder="Nom Gestionnaire" name="genom" id="genom">
            <input type="text" placeholder="Prénom Gestionnaire" name="prenom" id="prenom">
            <select name="pole" id="pole">
                <option value="">--Pôle--</option>
                <option value="Pôle A">Pôle A</option>
                <option value="Pôle B">Pôle B</option>
                <option value="Carré VIP">Carré VIP</option>
                <option value="Gestionnaire dématéralisation">Gestionnaire dématéralisation</option>
            </select>
            <label for="arrive"> Date d'arrivée : </label>
            <input type="date" name="arrive" id="arrive">
            <input type="submit" value="Ajouter" name="submit">
            <input type="hidden" value="Gestionnaire" name="page"> 
        </form>
    </div>
    <div id="popup2" class="popup">
        <form action="update.php" method="post">
            <div class="close-btn" onclick='popup_hide("popup2")'>&times;</div>
            <h3>Editer Gestionnaire</h3>
            <input type="text" placeholder="Nom Gestionnaire" name="genom" class="input-edit">
            <input type="text" placeholder="Prénom Gestionnaire" name="prenom" class="input-edit">
            <select name="pole" class="input-edit">
                <option value="">--Pôle--</option>
                <option value="Pôle A">Pôle A</option>
                <option value="Pôle B">Pôle B</option>
                <option value="Carré VIP">Carré VIP</option>
                <option value="Gestionnaire dématéralisation">Gestionnaire dématéralisation</option>
            </select>
            <label for="arrive"> Date d'arrivée : </label>
            <input type="date" name="arrive" class="input-edit">
            <input type="submit" value="Modifier" name="submit">
            <input type="hidden" value="Gestionnaire" name="page">
            <input id='rowId' type="hidden" value="" name="gestionid">
        </form>
    </div>
</body>
</html>