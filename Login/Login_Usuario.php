<?php
session_start();
$connection = null;
$erro = null;

try {
    // Conexão com o banco de dados
    $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo "Falha: " . $e->getMessage();
    exit();
}

if (isset($_POST['entrar'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Verifica se os campos estão preenchidos
    if (empty($login) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {
        // Busca o usuário no banco de dados
        $sql = "SELECT * FROM Usuarios WHERE login = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o login existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Usuário autenticado com sucesso
            $_SESSION['usuario'] = $usuario['login'];
            header('Location: Menu.php');
            exit();
        } else {
            $erro = "Login ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Login de Usuário</title>
</head>
<body>
    <h2>Login</h2>

    <?php if ($erro) { echo "<b style='color:red;'>$erro</b><br>"; } ?>
    
    <form method="POST">
        Login: <input type="text" name="login"><br><br>
        Senha: <input type="password" name="senha"><br><br>
        <input type="submit" name="entrar" value="Entrar">
    </form>

    <br><a href='Cadastro.php'><input type="button" value="Cadastrar Usuário"></a>
</body>
</html>
