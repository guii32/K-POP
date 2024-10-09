<?php
$erro = null;
$valido = false;

if (isset($_REQUEST["validar"]) && $_REQUEST["validar"] == true) {

    if (empty($_POST["nome"]) || mb_strlen($_POST["nome"], 'UTF-8') > 30) {
        $erro = "Preencha o campo nome do artista corretamente (até 30 caracteres).";
    }
    elseif (!is_numeric($_POST["idade"]) || $_POST["idade"] <= 0) {
        $erro = "Preencha o campo idade corretamente.";
    }
    elseif (empty($_POST["nacionalidade"]) || mb_strlen($_POST["nacionalidade"], 'UTF-8') > 50) {
        $erro = "Preencha o campo nacionalidade corretamente (até 50 caracteres).";
    }
    elseif (!isset($_POST["genero"]) || !in_array($_POST["genero"], ['F', 'M'])) {
        $erro = "Selecione o gênero do artista.";
    }
    elseif (empty($_POST["id_banda"])) {
        $erro = "Selecione uma banda para o artista.";
    }
    else {
        $valido = true;

        try {
            $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
            $connection->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Falha: " . $e->getMessage();
            exit();
        }

        
        $sql_banda = "SELECT * FROM Bandas WHERE id_banda = ?";
        $stmt_banda = $connection->prepare($sql_banda);
        $stmt_banda->bindParam(1, $_POST["id_banda"]);
        $stmt_banda->execute();

        if ($stmt_banda->rowCount() == 0) {
            $valido = false;
            $erro = "Banda não encontrada.";
        }

        if ($valido) {
            
            $sql = "INSERT INTO Artistas (nome, idade, nacionalidade, genero, id_banda) VALUES (?, ?, ?, ?, ?)";

            $stmt = $connection->prepare($sql);
            $stmt->bindParam(1, $_POST["nome"]);
            $stmt->bindParam(2, $_POST["idade"]);
            $stmt->bindParam(3, $_POST["nacionalidade"]);
            $stmt->bindParam(4, $_POST["genero"]);
            $stmt->bindParam(5, $_POST["id_banda"]);

            $stmt->execute();

            
            if ($stmt->errorCode() != "00000") {
                $valido = false;
                $erro = "Erro código " . $stmt->errorCode() . ": ";
                $erro .= implode(", ", $stmt->errorInfo());
            }
        }
    }
}
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <TITLE>Cadastro de Artistas</TITLE>
</HEAD>
<BODY>
<?php
    if ($valido == true) {
        echo "Artista cadastrado com sucesso!<br><br>";
        echo "<a href='pesquisa_geral_Artistas.php'><input type='button' value='Visualizar registros'></a><br /><br />";
        echo "<a href='Menu.php'><input type='button' value='Voltar para o Menu'></a>";
    } else {
        if (isset($erro)) {
            echo "<b style='color:red;'>$erro</b><br><br>";
        }

        try {
            $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
            $connection->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Falha: " . $e->getMessage();
            exit();
        }

        
        $sql_bandas = "SELECT id_banda, nome_banda FROM Bandas";
        $stmt_bandas = $connection->query($sql_bandas);
        $bandas = $stmt_bandas->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <FORM method="POST" action="?validar=true">
            Nome do Artista:
            <INPUT type="text" name="nome"
            <?php if (isset($_POST["nome"])) { echo "value='" . $_POST["nome"] . "'"; } ?>
            ><BR><BR>

            Idade:
            <INPUT type="text" name="idade"
            <?php if (isset($_POST["idade"])) { echo "value='" . $_POST["idade"] . "'"; } ?>
            ><BR><BR>

            Nacionalidade:
            <INPUT type="text" name="nacionalidade"
            <?php if (isset($_POST["nacionalidade"])) { echo "value='" . $_POST["nacionalidade"] . "'"; } ?>
            ><BR><BR>

            Gênero:
            <INPUT type="radio" name="genero" value="M" <?php if (isset($_POST["genero"]) && $_POST["genero"] == 'M') { echo "checked"; } ?>> Masculino
            <INPUT type="radio" name="genero" value="F" <?php if (isset($_POST["genero"]) && $_POST["genero"] == 'F') { echo "checked"; } ?>> Feminino
            <BR><BR>

            Banda:
            <SELECT name="id_banda" required>
                <OPTION value="">Selecione uma banda</OPTION>
                <?php
                foreach ($bandas as $banda) {
                    echo "<OPTION value='" . $banda['id_banda'] . "'";
                    if (isset($_POST["id_banda"]) && $_POST["id_banda"] == $banda['id_banda']) {
                        echo " selected";
                    }
                    echo ">" . $banda['nome_banda'] . "</OPTION>";
                }
                ?>
            </SELECT>
            <BR><BR>

            <INPUT type="submit" value="Cadastrar Artista">
            <br>
            <br>
            <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
        </FORM>
        <?php
    }
    ?>
</BODY>
</HTML>
