<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\gen.css">
    <script src="../js/updateJson.js"></script>
    <title>Accueil</title>
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
    <div>
        <form class="button" action="Conge.php" method="post">
            <input type="text" placeholder="Rechercher" name="SEARCH" id="search">
            <select name="gestionid" id="gestionid">
                <option value="">-- Choisis ta voie --</option>
                <?php/*
                    try {
                        $pdo = new PDO('sqlite:..\Adecco.db');
                    }  catch (PDOException $e) {
                            die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                    }
                    $ListeS = $pdo->query("SELECT gestionid, genom, prenom FROM Gestionnaire");
                        foreach ($ListeS as $liste){
                            echo '<option value='.$liste['gestionid'].'>'.$liste['genom']." ".$liste['prenom'].'</option>';
                        }
                */?>
                <?php
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
        <?php
            $reqname = "SELECT genom, prenom FROM Gestionnaire";
            if(isset($_POST['gestionid']) && $_POST['gestionid'] <> ""){
                $reqname .= " WHERE gestionid={$_POST['gestionid']}";
                try {
                    $pdo = new PDO('sqlite:..\Adecco.db');
                    $name = $pdo->query($reqname);
                }  catch (PDOException $e) {
                        die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                }
                foreach ($name as $na){
                    echo "<h1>".$na['genom']." ".$na['prenom']."</h1>";
                    echo "<form class='button' action='Insert.php' method='POST'>";
                    echo "Date début : <input type='date' name='dateDebut' id='dateDebut'></input>";
                    echo "Date fin : <input type='date' name='dateFin' id='dateFin'></input>";
                    echo "<select name='type' id='type'>";
                    echo "<option value='CP'>CP</option>";
                    echo "<option value='Maladie'>Maladie</option>";
                    echo "</select>";
                    echo '<input type="submit" value="Ajouter Conge" name="submit">';
                    echo '<input type="hidden" value="conge" name="page">';
                    echo '<input type="hidden" value='.$_POST['gestionid'].' name="idGestion">';
                echo "</form>";
                    }
                }
        ?>
    </div>
    <div>
        <table class="styled-table">
            <thead>
                <tr>
                    <td>Congé</td>
                    <td>Type</td>
                    <td>Suppr.</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $req = "SELECT congeid, gestionid, genom, prenom, datedebut, typeconge, datefin FROM gestionnaire G INNER JOIN Conge C ON G.gestionid = C.gestionConge";
                    if (isset($_POST['gestionid']) && $_POST['gestionid'] <> ""){
                        $req .= " WHERE G.gestionid={$_POST['gestionid']}";
                        try {
                            $pdo = new PDO('sqlite:..\Adecco.db');
                        }  catch (PDOException $e) {
                                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                        }
                        $ListeS = $pdo->query($req);
                        foreach ($ListeS as $liste){
                            $cpt = 0;
                            if($cpt%2 == 0){
                                echo("<tr>");
                                echo("<td>".$liste['datedebut']." - ".$liste['datefin']."</td>");
                                echo("<td>".$liste['typeconge']."</td>");
                                echo("<td><a href='Delete.php?idconge=$liste[congeid]'><img src=../img/delete.png witdh=15 height=15></a></td>");
                                echo("</tr>");
                                $cpt++;
                            }
                            elseif ($cpt%2 <> 0){
                                echo("<tr>");
                                echo("<td>".$liste['datedebut']." - ".$liste['datefin']."</td>");
                                echo("<td>".$liste['type']."</td>");
                                echo("<td><a href='Delete.php?idconge=$liste[congeid]'><img src=../img/delete.png witdh=15 height=15></a></td>");
                                echo("</tr>");
                                $cpt++;
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="foot"></div>
</body>
<script src="..\js\dropdown.js"></script>
</html>
