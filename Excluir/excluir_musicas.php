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
    $id_musica = $_GET['id'];

    
    $sql = "DELETE FROM Musicas WHERE id_musica = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id_musica]);

    if ($stmt->rowCount() > 0) {
        echo "Música excluída com sucesso!";
    } else {
        $erro = "Erro ao excluir música ou música não encontrada.";
    }
}


$sql = "SELECT * FROM Musicas ORDER BY nome_musica ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$musicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Excluir Músicas</title>
</head>
<body>
    <h2>Excluir Músicas</h2>
    
    <?php if ($erro) { echo "<b style='color:red;'>$erro</b><br>"; } ?>

    <ul>
        <?php foreach ($musicas as $musica): ?>
            <li>
                <?php echo $musica['nome_musica']; ?>
                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $musica['id_musica']; ?>)">Excluir</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        function confirmDelete(id) {
            if (confirm("Tem certeza que deseja excluir esta música?")) {
                window.location.href = "?id=" + id;
            }
        }
    </script>
    <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
</body>
</html>
