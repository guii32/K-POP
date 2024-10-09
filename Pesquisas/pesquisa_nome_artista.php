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
        $sql = "SELECT * FROM Artistas WHERE nome LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, "%$nome%");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultados)) {
            $erro = "Nenhum artista encontrado com o nome '$nome'.";
        }
    } else {
        $erro = "Preencha o campo de pesquisa.";
    }
}
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <TITLE>Pesquisa de Artistas por Nome</TITLE>
</HEAD>
<BODY>
    <h2>Pesquisar Artistas</h2>
    <form method="GET" action="">
        Nome do Artista:
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
        foreach ($resultados as $artista) {
            echo "<li>Nome: " . $artista['nome'] . " | Idade: " . $artista['idade'] . " | Nacionalidade: " . $artista['nacionalidade'] . "</li>";
        }
        echo "</ul>";
    }
    ?>
</BODY>
</HTML>