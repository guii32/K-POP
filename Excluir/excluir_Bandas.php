<?php
$connection = null;
$erro = null;

try {
    $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo "Falha: " . $e->getMessage();
    exit();
}


if (isset($_GET['id'])) {
    $id_banda = $_GET['id'];

    
    $sql = "DELETE FROM Musicas WHERE id_banda = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id_banda]);

    $sql = "DELETE FROM Artistas WHERE id_banda = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id_banda]);

    $sql = "DELETE FROM Bandas WHERE id_banda = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id_banda]);

    if ($stmt->rowCount() > 0) {
        echo "Banda excluída com sucesso, incluindo artistas e músicas relacionadas!";
    } else {
        $erro = "Erro ao excluir banda ou banda não encontrada.";
    }
}


$sql = "SELECT * FROM Bandas ORDER BY nome_banda ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$bandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Excluir Bandas</title>
</head>
<body>
    <h2>Excluir Bandas</h2>
    
    <?php if ($erro) { echo "<b style='color:red;'>$erro</b><br>"; } ?>

    <ul>
        <?php foreach ($bandas as $banda): ?>
            <li>
                <?php echo $banda['nome_banda']; ?>
                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $banda['id_banda']; ?>)">Excluir</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        function confirmDelete(id) {
            if (confirm("Tem certeza que deseja excluir esta banda? Isso também excluirá todos os artistas e músicas relacionados.")) {
                window.location.href = "?id=" + id;
            }
        }
    </script>
    <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
</body>
</html>
