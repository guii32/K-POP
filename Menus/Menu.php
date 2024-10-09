<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <style>
        ul {
            list-style-type: none;
        }
        li {
            margin: 5px 0;
        }
        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>


<body>
    <ul>
        <li><strong>Menu Principal</strong></li>
        <li>Cadastro
            <ul>
                <li><a href="Cadastro_artistas.php" target="_blank">Artistas</a></li>
                <li><a href="Cadastro_Bandas.php" target="_blank">Bandas</a></li>
                <li><a href="Cadastro_Musicas.php" target="_blank">Músicas</a></li>
            </ul>
        </li>
        <li>Pesquisar Geral
            <ul>
                <li><a href="pesquisa_geral_Artistas.php" target="_blank">Artistas - Lista Geral</a></li>
                <li><a href="pesquisa_geral_Bandas.php" target="_blank">Bandas - Lista Geral</a></li>
                <li><a href="pesquisa_geral_Musicas.php" target="_blank">Músicas - Lista Geral</a></li>
            </ul>
        </li>
        <li>Pesquisar por Nome
            <ul>
                <li><a href="pesquisa_nome_artista.php" target="_blank">Artistas - Pesquisa por Nome</a></li>
                <li><a href="pesquisa_nome_banda.php" target="_blank">Bandas - Pesquisa por Nome</a></li>
                <li><a href="pesquisa_nome_musica.php" target="_blank">Músicas - Pesquisa por Nome</a></li>
            </ul>
        </li>
        <li>Exclusão
            <ul>
                <li><a href="excluir_artistas.php" target="_blank">Artistas</a></li>
                <li><a href="excluir_Bandas.php" target="_blank">Bandas</a></li>
                <li><a href="excluir_musicas.php" target="_blank">Músicas</a></li>
            </ul>
        </li>

<!-- Se necessita do arquivo de Alteração, no caso o mesmo ainda não foi entregue!-->
    
        <li>Alteração
            <ul>
                <li><a href="#">Artistas</a></li>
                <li><a href="#">Bandas</a></li>
                <li><a href="#">Músicas</a></li>
            </ul>
        </li>
    </ul>
</body>
</html>
