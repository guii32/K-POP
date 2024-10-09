<?php
$connection = null;

try {
   
    $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo "Falha: " . $e->getMessage();
    exit();
}


$sql = "SELECT * FROM Artistas ORDER BY nome ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$artistas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <TITLE>Lista Geral de Artistas</TITLE>
</HEAD>
<BODY>
    <h2>Lista de Artistas</h2>
    
    <?php
    if (!empty($artistas)) {
        echo "<ul>";
        foreach ($artistas as $artista) {
            echo "<li>Nome: " . $artista['nome'] . " | Idade: " . $artista['idade'] . " | Nacionalidade: " . $artista['nacionalidade'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum artista cadastrado.</p>";
    }
    ?>
    <br>
    <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
</BODY>
</HTML>
