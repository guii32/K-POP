<?php
$erro = null;
$valido = false;

if(isset($_REQUEST["validar"]) && $_REQUEST["validar"] == true)
{
    
    if (mb_strlen($_POST["nome_musica"], 'UTF-8') > 100) 
    {
        $erro = "Preencha o campo nome da música corretamente (até 100 caracteres).";
    }
    elseif(empty($_POST["id_banda"]))
    {
        $erro = "Selecione uma banda existente.";
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

        
        $sql_banda = "SELECT * FROM Bandas WHERE id_banda = ?";
        $stmt_banda = $connection->prepare($sql_banda);
        $stmt_banda->bindParam(1, $_POST["id_banda"]);
        $stmt_banda->execute();

        if($stmt_banda->rowCount() == 0)
        {
            $valido = false;
            $erro = "Banda não encontrada.";
        }
        else
        {
            
            $sql = "INSERT INTO Musicas (nome_musica, id_banda) VALUES (?, ?)";

            $stmt = $connection->prepare($sql);

            
            $stmt->bindParam(1, $_POST["nome_musica"]);
            $stmt->bindParam(2, $_POST["id_banda"]);

            
            $stmt->execute();

            
            if($stmt->errorCode() != "00000")
            {
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
        <TITLE>Cadastro de Músicas</TITLE>
    </HEAD>
    <BODY>
        <?php
            
            if($valido == true)
            {
                echo "Música cadastrada com sucesso!<br><br>";
                echo "<a href='pesquisa_geral_Musicas.php'><input type='button' value='Visualizar registros'></a><br /><br />";
                echo "<a href='Menu.php'><input type='button' value='Voltar para o Menu'></a>";
            }
            else
            {
                if(isset($erro))
                {
                    echo "<b style='color:red;'>$erro</b><br><br>";
                }

                
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

                
                $sql_bandas = "SELECT id_banda, nome_banda FROM Bandas";
                $stmt_bandas = $connection->query($sql_bandas);
                $bandas = $stmt_bandas->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <FORM method="POST" action="?validar=true">
            Nome da Música:
            <INPUT type="text" name="nome_musica"
            <?php if(isset($_POST["nome_musica"])) { echo "value='" . $_POST["nome_musica"] . "'"; } ?>
            ><BR><BR>

            Banda:
            <SELECT name="id_banda">
                <OPTION value="">Selecione uma banda</OPTION>
                <?php
                    
                    foreach($bandas as $banda)
                    {
                        echo "<OPTION value='" . $banda['id_banda'] . "'";
                        if(isset($_POST["id_banda"]) && $_POST["id_banda"] == $banda['id_banda'])
                        {
                            echo " selected";
                        }
                        echo ">" . $banda['nome_banda'] . "</OPTION>";
                    }
                ?>
            </SELECT>
            <BR><BR>
            
            <INPUT type="submit" value="Cadastrar Música">
            <br>
            <br>
            <a href='Menu.php'><input type="button" value="Voltar para o Menu"></a>
        </FORM>
        <?php
            }
        ?>
    </BODY>
</HTML>
