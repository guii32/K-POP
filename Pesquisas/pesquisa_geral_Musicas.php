<?php
$connection = null;

try {
    
    $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo "Falha: " . $e->getMessage();
    exit();
}


$sql = "SELECT * FROM Musicas ORDER BY nome_musica ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$musicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <TITLE>Lista Geral de Músicas</TITLE>
</HEAD>
<BODY>
    <h2>Lista de Músicas</h2>
    
    <?php
    if (!empty($musicas)) {
        echo "<ul>";
        foreach ($musicas as $musica) {
            echo "<li>Música: " . $musica['nome_musica'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhuma música cadastrada.</p>";
    }
    ?>
    <br>
    <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
</BODY>
</HTML>
