<?php
$erro = null;
$valido = false;

if(isset($_REQUEST["validar"]) && $_REQUEST["validar"] == true)
{
    
    if (mb_strlen($_POST["nome_banda"], 'UTF-8') > 100) 
    {
        $erro = "Preencha o campo nome da banda corretamente (até 100 caracteres).";
    }
    elseif(empty($_POST["data_fundacao"]))
    {
        $erro = "Preencha o campo data de fundação.";
    }
    else
    {
        $valido = true;

        
        try
        {
            $connection = new PDO("mysql:host=localhost;dbname=bancoPHP", "root", "");
            $connection->exec("set names utf8");
        }
        catch(PDOException $e)
        {
            echo "Falha: " . $e->getMessage();
            exit();
        }

        
        $sql = "INSERT INTO Bandas (nome_banda, data_fundacao) VALUES (?, ?)";

        $stmt = $connection->prepare($sql);

       
        $stmt->bindParam(1, $_POST["nome_banda"]);
        $stmt->bindParam(2, $_POST["data_fundacao"]);

        
        $stmt->execute();

        
        if($stmt->errorCode() != "00000")
        {
            $valido = false;
            $erro = "Erro código " . $stmt->errorCode() . ": ";
            $erro .= implode(", ", $stmt->errorInfo());
        }
    }
}
?>

<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <TITLE>Cadastro de Bandas</TITLE>
    </HEAD>
    <BODY>
        <?php
            
            if($valido == true)
            {
                echo "Banda cadastrada com sucesso!<br><br>";
                echo "<a href='pesquisa_geral_Bandas.php'><input type='button' value='Visualizar registros'></a><br /><br />";
                echo "<a href='Menu.php'><input type='button' value='Voltar para o Menu'></a>";
            }
            else
            {
                if(isset($erro))
                {
                    echo "<b style='color:red;'>$erro</b><br><br>";
                }
        ?>
        <FORM method="POST" action="?validar=true">
            Nome da Banda:
            <INPUT type="text" name="nome_banda" 
            <?php if(isset($_POST["nome_banda"])) { echo "value='" . $_POST["nome_banda"] . "'"; } ?>
            ><BR><BR>

            Data de Fundação:
            <INPUT type="date" name="data_fundacao"
            <?php if(isset($_POST["data_fundacao"])) { echo "value='" . $_POST["data_fundacao"] . "'"; } ?>
            ><BR><BR>
            
            <INPUT type="submit" value="Cadastrar Banda">
            <br>
            <br>
            <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
        </FORM>
        <?php
            }
        ?>
    </BODY>
</HTML>