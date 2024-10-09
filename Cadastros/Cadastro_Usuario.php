<?php
$connection = null;
$erro = null;
$sucesso = null;

try {
    // Conexão com o banco de dados
    $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo "Falha: " . $e->getMessage();
    exit();
}

if (isset($_POST['cadastrar'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Verifica se os campos estão preenchidos
    if (empty($login) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {
        // Verifica se o login já existe
        $sql = "SELECT * FROM Usuarios WHERE login = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$login]);
        
        if ($stmt->rowCount() > 0) {
            $erro = "Login já cadastrado!";
        } else {
            // Criptografando a senha
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

            // Inserindo no banco
            $sql = "INSERT INTO Usuarios (login, senha) VALUES (?, ?)";
            $stmt = $connection->prepare($sql);
            if ($stmt->execute([$login, $senhaHash])) {
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar o usuário.";
            }
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    
    <?php if ($sucesso) { echo "<b style='color:green;'>$sucesso</b><br>"; } ?>
    <?php if ($erro) { echo "<b style='color:red;'>$erro</b><br>"; } ?>
    
    <form method="POST">
        Login: <input type="text" name="login"><br><br>
        Senha: <input type="password" name="senha"><br><br>
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>

    <br><a href='Menu_Login.php'><input type="button" value="Voltar para o Menu"></a>
</body>
</html>
