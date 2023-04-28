<?php require('LoadP.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\gen.css">
    <script src="../js/popup.js"></script>
    <title>Accueil</title>
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
            <form class='dropList' action="Conge.php" method="post">
                <select name="gestionid" id="gestionid">
                    <option value="">-- Gestionnaire --</option>
                    <?php //Liste déroulante contenant les noms des gestionnaires    
                        try {
                            $pdo = new PDO('sqlite:..\Adecco.db');
                        }   
                        catch (PDOException $e) {
                            die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                        }
                        $ListeS = $pdo->query("SELECT gestionid, genom, prenom FROM Gestionnaire");
                        
                        foreach ($ListeS as $liste){
                            $ligne = '<option';
                            if(isset($_POST['gestionid']) && $_POST['gestionid'] <> "" && $_POST['gestionid'] == $liste['gestionid']) {
                                $ligne .= ' selected';
                            }
                            $ligne .= ' value='.$liste['gestionid'].'>'.$liste['genom']." ".$liste['prenom'].'</option>';
                            echo $ligne;
                        }
                    ?>
                </select>
                <input type="submit" value="Rechercher" name="submit">
                <input type="hidden" value="Conge" name="page">
            </form>
        </div>
        <div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <td>Date de début</td>
                        <td>Date de fin</td>
                        <td>Type</td>
                        <td>Statut</td>
                        <td>Edit.</td>
                        <td>Suppr.</td>
                    </tr>
                </thead>
                <tbody>
                    <?php //echo le tableau des Congés pour le gestionnaire choisis              
                        $req = "SELECT congeid, gestionid, genom, prenom, datedebut, typeconge, datefin, statut_conge FROM gestionnaire G INNER JOIN Conge C ON G.gestionid = C.gestionConge";
                        if(isset($_GET['gestionid'])){
                            $_POST['gestionid'] = $_GET['gestionid'];
                        }          
                        if (isset($_POST['gestionid']) && $_POST['gestionid'] <> ""){
                            $req .= " WHERE G.gestionid={$_POST['gestionid']}";
                            try {
                                $pdo = new PDO('sqlite:..\Adecco.db');
                            }  catch (PDOException $e) {
                                    die("Erreur" .$e);
                            }
                            $cpt = 0;
                            $ListeS = $pdo->query($req);
                            foreach ($ListeS as $liste){
                                if ($cpt == 0){
                                    echo "<h1 class='title'>".$liste['prenom']." ".$liste['genom']."</h1>";
                                    echo '<div>';
                                    echo "<button class='new-btn' id='show-add' onclick="."popup_show('popup1')".">Nouvelle absence</button>";
                                    echo '</div>';                                
                                    $cpt++;
                                }
                                echo"<tr rowid='{$liste['congeid']}'>";
                                echo"<td class='edit'>".$liste['datedebut']."</td>";
                                echo"<td class='edit'>".$liste['datefin']."</td>";
                                echo"<td class='edit'>".$liste['typeconge']."</td>";
                                echo"<td>".$liste['statut_conge']."</td>";                            
                                echo"<td><button class='edit-btn' id='show-add' onclick='popup_show(\"popup2\", {$liste['congeid']})'><img src=../img/editing.png witdh=15 height=15></button></td>";
                                echo"<td><a href='Delete.php?idconge=$liste[congeid]'><img src=../img/delete.png witdh=15 height=15></a></td>";
                                echo"</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php //Formulaire pour ajouter des données dans la table Conge
            try {
                $pdo = new PDO('sqlite:..\Adecco.db');
            }  catch (PDOException $e) {
            die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
            }
            if(isset($_POST['gestionid']) && $_POST['gestionid'] <> ""){
                    //Popup d'ajout de Congé
                    echo '<div id="popup1" class="popup">';
                        echo "<form action='Insert.php' method='POST'>";
                            echo "<div class='close-btn' onclick="."popup_hide('popup1')".">&times;</div>";
                            echo "Date début : <input type='date' name='dateDebut' id='dateDebut'></input>";
                            echo "Date fin : <input type='date' name='dateFin' id='dateFin'></input>";
                            echo "<select name='type' id='type'>";
                                echo "<option value='CP'>CP</option>";
                                echo "<option value='Maladie'>Maladie</option>";
                            echo "</select>";
                            echo '<input type="submit" value="Ajouter" name="submit">';
                            echo '<input type="hidden" value="conge" name="page">';
                        echo "</form>";
                    echo '</div>';
                    //Popup d'edition de Congé
                    echo '<div id="popup2" class="popup">';
                        echo "<form action='update.php' method='POST'>";
                            echo "<div class='close-btn' onclick="."popup_hide('popup2')".">&times;</div>";
                            echo "Date début : <input type='date' name='dateDebut' id='dateDebut' class='input-edit'></input>";
                            echo "Date fin : <input type='date' name='dateFin' id='dateFin' class='input-edit'></input>";
                            echo "<select name='type' id='typeUpt' class='input-edit'>";
                                echo "<option value='CP'>CP</option>";
                                echo "<option value='Maladie'>Maladie</option>";
                            echo "</select>";
                            echo '<input type="hidden" value="conge" name="page">';
                            echo '<input id="rowId" type="hidden" value="" name="rowid">';
                            echo "<input type='hidden' value='{$_POST['gestionid']}' name='gestionid'>";
                            echo '<input type="submit" value="Modifier" name="submit">';
                        echo "</form>";
                    echo '</div>';
                }
        ?>
</body>
</html>
