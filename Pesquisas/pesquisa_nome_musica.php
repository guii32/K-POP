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

$resultados = [];

if (isset($_GET['pesquisar'])) {
    $nome = $_GET['nome'];

    if (!empty($nome)) {
        $sql = "SELECT * FROM Musicas WHERE nome_musica LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, "%$nome%");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultados)) {
            $erro = "Nenhuma música encontrada com o nome '$nome'.";
        }
    } else {
        $erro = "Preencha o campo de pesquisa.";
    }
}
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <TITLE>Pesquisa de Músicas por Nome</TITLE>
</HEAD>
<BODY>
    <h2>Pesquisar Músicas</h2>
    <form method="GET" action="">
        Nome da Música:
        <input type="text" name="nome">
        <input type="submit" name="pesquisar" value="Pesquisar">
        <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
    </form>

    <?php
    if ($erro) {
        echo "<p style='color:red;'>$erro</p>";
    }

    if (!empty($resultados)) {
        echo "<h3>Resultados da Pesquisa:</h3>";
        echo "<ul>";
        foreach ($resultados as $musica) {
            echo "<li>Música: " . $musica['nome_musica'] . "</li>";
        }
        echo "</ul>";
    }
    ?>
</BODY>
</HTML>
