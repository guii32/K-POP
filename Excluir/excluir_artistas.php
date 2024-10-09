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
    $id_artista = $_GET['id'];

    
    $sql = "DELETE FROM Artistas WHERE id_artista = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id_artista]);

    if ($stmt->rowCount() > 0) {
        echo "Artista excluído com sucesso!";
    } else {
        $erro = "Erro ao excluir artista ou artista não encontrado.";
    }
}


$sql = "SELECT * FROM Artistas ORDER BY nome ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$artistas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Excluir Artistas</title>
</head>
<body>
    <h2>Excluir Artistas</h2>
    
    <?php if ($erro) { echo "<b style='color:red;'>$erro</b><br>"; } ?>

    <ul>
        <?php foreach ($artistas as $artista): ?>
            <li>
                <?php echo $artista['nome']; ?>
                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $artista['id_artista']; ?>)">Excluir</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        function confirmDelete(id) {
            if (confirm("Tem certeza que deseja excluir este artista?")) {
                window.location.href = "?id=" + id;
            }
        }
    </script>
    <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
</body>
</html>
