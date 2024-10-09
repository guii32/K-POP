<?php
$connection = null;

try {
    
    $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo "Falha: " . $e->getMessage();
    exit();
}


$sql = "SELECT * FROM Bandas ORDER BY nome_banda ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$bandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <TITLE>Lista Geral de Bandas</TITLE>
</HEAD>
<BODY>
    <h2>Lista de Bandas</h2>
    
    <?php
    if (!empty($bandas)) {
        echo "<ul>";
        foreach ($bandas as $banda) {
            echo "<li>Nome da Banda: " . $banda['nome_banda'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhuma banda cadastrada.</p>";
    }
    ?>
    <br>
    <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
</BODY>
</HTML>
