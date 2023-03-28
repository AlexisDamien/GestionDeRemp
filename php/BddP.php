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
        <form class="button" action="BddP.php" method="POST">
            <select name="gestionid" id="gestionid">
                <option value="">-- Choisis ton chemin --</option>
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
            <input type="submit" value="Ajouter" name="submit">
            <input type="hidden" value="portefeuille" name="page"> 
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
                    $code = $pdo->query("SELECT agenceid, code FROM Agence");
                }  catch (PDOException $e) {
                        die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                }
                foreach ($name as $na){
                    echo "<h1>".$na['genom']." ".$na['prenom']."</h1>";
                    }
                echo "<form action='Insert.php' method='POST'>";
                    echo '<select name="agenceid" id="agenceid">';
                        foreach ($code as $codelist){
                            echo '<option value='.$codelist['agenceid'].'>'.$codelist['code'].'</option>';
                        }
                    echo '</select>';
                    echo '<input type="submit" value="Ajouter agence" name="submit">';
                    echo '<input type="hidden" value="portefeuille" name="page">';
                    echo '<input type="hidden" value='.$_POST['gestionid'].' name="idGestion">';
                echo "</form>";
            }

        ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <td>Agences</td>
                    <td>Suppr.</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $req = "SELECT G.genom, G.prenom, code, porteid FROM gestionnaire G INNER JOIN portefeuille P ON gestionnaire=gestionid INNER JOIN Agence A ON agence=agenceid";
                    if(isset($_POST['gestionid']) && $_POST['gestionid'] <> ""){
                        $req .= " WHERE G.gestionid={$_POST['gestionid']}";
                        try {
                            $pdo = new PDO('sqlite:..\Adecco.db');
                            $ListeS = $pdo->query($req);
                        }  catch (PDOException $e) {
                                die("Erreur de connexion dans le fichier {$e->getFile()} à la ligne {$e->getLine()} : {$e->getCode()} - {$e->getMessage()}");
                        }
                        foreach ($ListeS as $liste){
                            $cpt = 0;
                            if($cpt%2 == 0){
                                echo("<tr>");
                                echo("<td>".$liste['code']."</td>");
                                echo("<td><a href='Delete.php?idporte=$liste[porteid]'><img src=../img/delete.png witdh=15 height=15></a></td>");
                                echo("</tr>");
                                $cpt++;
                            }
                            elseif ($cpt%2 <> 0){
                                echo("<tr class='active-row'>");
                                echo("<td>"."</td>");
                                echo("<td><a href='Delete.php?idporte=$liste[porteid]'><img src=../img/delete.png witdh=15 height=15></a></td>");
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
</html>