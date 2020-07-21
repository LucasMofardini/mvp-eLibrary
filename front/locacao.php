<?php
    require_once '../back/classes/Locacao.php';
?>
<!DOCTYPE html>
<html lang="pt/br" dir="ltr">

<head>
    <link rel="icon" href="https://image.flaticon.com/icons/png/512/73/73705.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style/estilo.css">
    <script src="../back/teste.js"></script>
    <meta charset="utf-8">
    <title>Pesquisa livro</title>
</head>

<body>
    <section>
        <a href="validara.php"><i class="material-icons">arrow_back</i></a>
        Locacoes efetuadas: <?php echo $_GET['locacoes'] ?>
        <form method="post">
            <h2>Pesquisa de Livro</h2>
            <input type="radio" name="tipo" value="livro" checked>Livro
            <input type="radio" name="tipo" value="autor">Autor
            <br>
            <input type="text" name="pesquisa"> <br>
            <button class="btn_padrao">Pesquisar</button>
            
        </form>
        <form>
                <?php
                    if ($_GET['locacoes'] >= 3) {
                        echo "<p class='msgErro'>Aluno já possui 3 livros alugados</p>";
                    } else {
                        if (isset($_POST['tipo']) && isset($_POST['pesquisa'])){
                            $tipo = $_POST['tipo'];
                            $pesquisa = $_POST['pesquisa'];
                            $locacao = new Locacao;
                            if ($tipo == "livro"){
                                $livros = $locacao->buscarNomeLivro($pesquisa);
                            } else if($tipo == "autor"){
                                $livros = $locacao->buscarNomeAutor($pesquisa);
                            }
                            
                            if (count($livros) > 0) {
                                echo '<h2>Resultados da pesquisa</h2>
                                <table style="width: 100%;" id="table_resultados_pesquisa"> <br>
                                    <tr>
                                        <th>Livro</th>
                                        <th>Autor</th>
                                        <th>Editora</th>
                                        <th>Exemplares </th>
                                        <th>Alugar</th>
                                    </tr>';
    
                                for ($i = 0; $i < count($livros); $i++) {
                                    echo "<tr>";
                                    foreach ($livros[$i] as $key => $value) {
                                        if ($key != "id_livro") {
                                            echo "<td>$value</td>";
                                        }
                                    }
                                    ?>
                                    <td>
                                    <button><a href="../back/insereLocacao.php?<?php 
                                                                $exemplar = $locacao->pesquisaExemplarDisponivel($livros[$i]['id_livro']);
                                                                echo "exemplar=".$exemplar.
                                                                    "&idAluno=".$_GET['idAluno'].
                                                                    "&ra=".$_GET['ra'].
                                                                    "&locacoes=".$_GET['locacoes'];
                                                            ?>">
                                           Alugar
                                        </a>
                                        
                                       </button> 
                                    </td>
                                    <?php
                                    echo "</tr>";
                                }
                            } else {
                                echo "<p class='msgErro'>Nenhum livro encontrado</p>";
                            }
                        }
                    }
                ?>
            </table>
            <br>
        </form>
    </section>
</body>

</html>