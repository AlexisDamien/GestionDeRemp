<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\gen.css">
    <script src="../js/popup.js"></script>
    <title>Gestion Agence</title>
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
            <button class="new-btn" id="show-add" onclick='popup_show("popup1")'>Nouvelle Agence</button>
        </div>
        <div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <td>Code Agence</td>
                        <td>Nom site</td>
                        <td>Complexité</td>
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
                        }
                        $ListeS = $pdo->query("SELECT agenceid, code, agnom, complexite FROM Agence");
                        foreach ($ListeS as $liste){
                                echo"<tr>";
                                echo"<td>".$liste['code']."</td>";
                                echo"<td>".$liste['agnom']."</td>";
                                echo"<td>".$liste['complexite']."</td>";
                                echo"<td><button class='edit-btn' id='show-add' onclick='popup_show(\"popup2\")'><img src=../img/editing.png witdh=15 height=15></button></td>";
                                echo"<td><a href='Delete.php?idagence=$liste[agenceid]'><img src=../img/delete.png witdh=15 height=15></a></td>";
                                echo"</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <div id="popup1" class="popup">
        <form action="Insert.php" method="post">
            <div class="close-btn" onclick='popup_hide("popup1")'>&times;</div>
            <h3>Nouvelle Agence</h3>
            <input type="text" placeholder="Code Agence" name="code" id="code">
            <input type="text" placeholder="Nom site" name="agnom" id="agnom">
                <select name="complexite" id="complexite">
                    <option value="">--Complexité--</option>
                    <option value="Très simple">Très simple</option>
                    <option value="Simple">Simple</option>
                    <option value="Normale">Normale</option>
                    <option value="Complexe">Complexe</option>
                    <option value="Très complexe">Très complexe</option>
                </select>
            <input type="submit" value="Ajouter" name="submit">
            <input type="hidden" value="Agence" name="page"> 
        </form>
    </div>
    <div id="popup2" class="popup">
        <form action="update.php" method="post">
            <div class="close-btn" onclick='popup_hide("popup2")'>&times;</div>
            <h3>Editer Agence</h3>
            <input type="text" placeholder="Code Agence" name="code" id="code">
            <input type="text" placeholder="Nom site" name="agnom" id="agnom">
                <select name="complexite" id="complexite">
                    <option value="">--Complexité--</option>
                    <option value="Très simple">Très simple</option>
                    <option value="Simple">Simple</option>
                    <option value="Normale">Normale</option>
                    <option value="Complexe">Complexe</option>
                    <option value="Très complexe">Très complexe</option>
                </select>
            <input type="submit" value="Modifier" name="submit">
            <input type="hidden" value="Agence" name="page"> 
        </form>
    </div>
</body>
</html>