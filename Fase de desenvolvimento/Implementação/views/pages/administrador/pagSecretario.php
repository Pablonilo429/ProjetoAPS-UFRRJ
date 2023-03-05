<?php

require_once("controller/controllerSecretario/ListarSecretarioController.php");

session_start();

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != "1") {
    header("Location: /");
    exit();
}

?><!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="views/css/style.css">
        <link rel="stylesheet" href="views/css/stylecrud.css">
        <link rel="stylesheet" href="views/css/stlylemodal.css">

        <title>Biblioteca Científica Digital</title>
    </head>

    <body>
        <header>
            <div class="container">
                <div class="logo"><a href="/"><img src="views/img/logo.png" style="width: 200px; height: 120px;"></a></div>
                <div class="menu">
                    <nav>
                        <a href="IndexSecretário.html#Sobre">Sobre</a>
                        <a href="IndexSecretário.html#Colaborador">Quero ser colaborador</a>
                        <a href="IndexSecretário.html#Artigo">Submeta seu artigo</a>
                        <a href="eventos.html">Eventos</a>
                        <a href="/homeAdm">Menu</a>
                    </nav>
                </div>

                <div class="login">
                    <?php echo '<p>Bem-vindo, ' . $_SESSION['nome_usuario'] . '!</p>'; ?>
                    </br>
                    <button id="btn1">Sair</button>
                </div>

                <div>
        </header>

        <section>
            <!-- Modal de Logout -->
            <div id="modal1" style="display: none;">
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <div class="fora-form">
                            <form method="post" action="/logout">
                                <div class="dentro-form">
                                    <h2>Deseja Sair do Sitema?</h2></br>
                                    <div style="text-align:center; margin-left: auto; margin-right: auto;">
                                        <button type="submit">Confirmar</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" id="cancel-button1">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Adicionar Secretarios -->
            <div id="modal2" name="modal2" style="display: none; ">
                <div id="modal" name="modal" class="modal">
                    <div class="modal-content">
                        <div class="fora-form">
                            <form method="post" action="/secretario/form/save">
                                <div class=" dentro-form">
                                    <h1>Adicionar novo secretário</h1></br>
                                    <div class="form-dados">
                                        <label for="nome">Nome do Secretário:</label></br>
                                        <input type="nome" id="nome" name="nome" placeholder="" required></br>

                                        <label for="cpf">CPF:</label>
                                        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" oninput="mascaraCPF(this)"></br>

                                        <label for="telefone">Telefone:</label>
                                        <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" oninput="mascaraTelefone(this)">

                                        <label for="DataNascimento">Data de Nascimento:</label></br>
                                        <input type="date" id="dataNascimento" name="dataNascimento" min="2000-01-01" max="2099-12-31" required><br>

                                        <label for="sexo">Sexo:</label></br>
                                        <select name="sexo" id="sexo">
                                            <option value="Masculino" id="opsexo" name="opsexo">Masculino</option>
                                            <option value="Feminino" selected id="opsexo" name="opsexo">Feminino</option>
                                            <option value="Prefiro não dizer" id="opsexo" name="opsexo">Prefiro não dizer</option>
                                        </select></br></br>

                                        <label for="email">E-mail:</label></br>
                                        <input type="email" id="email" name="email" placeholder="" required></br>

                                        <label for="endereco">Endereço:</label></br>
                                        <input type="text" id="endereco" name="endereco" placeholder="" required></br>

                                        <label for="senha">Senha:</label></br>
                                        <div style="display: flex; align-items: center;">
                                            <input type="password" id="senha" name="senha" placeholder="">
                                            <button type="button" onclick="mostrarSenha()">Mostrar senha</button>
                                        </div></br>
                                    </div>
                                    <div style="text-align:center; margin-left: auto; margin-right: auto;">
                                        <button type="submit">Confirmar</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" id="cancel-button2">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Verficar Secretario -->
            <div id="modal3" style="display: none;">
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <dl class="row" style=" display: flex; align-items: center; flex-direction: column;">
                            <dt class="col-sm-3">Nome: <span id="NomeSecretario"></span></dt></br>
                            <dt class="col-sm-3">Telefone: <span id="TelefoneSecretario"></span></dt></br>
                            <dt class="col-sm-3">Email: <span id="EmailSecretario"></span></dt></br>
                            <dt class="col-sm-3">Cpf: <span id="CpfSecretario"></span></dt></br>
                            <dt><button type="button" class="cancel-button3" data-modal-id="modal3">Fechar</button></dt>
                        </dl>
                    </div>

                </div>
            </div>


            <!-- Modal Editar Secretario-->
            <div id="modal4" style="display: none;">
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <div class="fora-form">
                            <form method="post" action="/organizador/form/editar">
                                <div class="dentro-form">
                                    <h1>Editar Secretario</h1></br>
                                    <div class="form-dados">
                                        <input type="hidden" name="id" id="id" value="">
                                        <label for="nome">Nome do Organizador:</label></br>
                                        <input type="text" id="editNome" name="editNome" placeholder="" required></br>
                                        <label for="DataDeNascimento">Data de Nascimento:</label></br>
                                        <input type="date" id="editDataDeNascimento" name="editDataDeNascimento" placeholder="" required></br>
                                        <label for="CurriculoLattes">Curriculo-lattes:</label></br>
                                        <input type="text" id="editCurriculoLattes" name="editCurriculoLattes" placeholder="" required></br>
                                        <label for="Instituição">Instituição:</label></br>
                                        <input type="text" id="editInstituicao" name="editinstituicao" placeholder="" required></br>
                                        <label for="sexo">Sexo:</label></br>
                                        <select id="editsexo" name="editsexo">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Feminino">Feminino</option>
                                            <option value="Prefiro não dizer">Prefiro não dizer</option>
                                        </select></br></br>
                                        <label for="Telefone">Telefone:</label></br>
                                        <input type="number" id="editTelefone" name="editTelefone" placeholder="" required></br>
                                        <label for="Cpf">Cpf:</label></br>
                                        <input type="number" id="editCpf" name="editCpf" placeholder="" required></br>
                                    </div>
                                    <div style="text-align:center; margin-left: auto; margin-right: auto;">
                                        <button type="submit">Confirmar</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="cancel-button4" data-modal-id="modal4">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Remover Autor -->
            <div id="modal5" style="display: none;">
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <div class="fora-form">
                            <form method="post" action="/organizador/form/remover">
                                <div class="dentro-form">
                                    <h1 style="text-align: center;">Removendo Secretario</h1></br>
                                    <h2 style="text-align: center;">Aviso:</h2></br>
                                    <h3 style="text-align: center;">Você realmente deseja apagar o Secretario?</h3></br>
                                    <div style="text-align:center; margin-left: auto; margin-right: auto;">
                                        <button type="submit">Confirmar</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="cancel-button5" data-modal-id="modal5">Cancelar</button>
                                    </div>
                                    <input type="hidden" name="id_organizador" id="id_organizador_remover" value="">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dentro-bloco">
                <h3>Gerenciar Secretário</h3>
            </div>

            <div class="bt-container">
                <button id="btn2" name="btn2">Adicionar novo secretário</button>
            </div>

            <div class="container_table">
                <!--Caixa inteira...-->
                <!--MENU-->

                <div style="padding-top: 70px;padding-bottom: 90px;">
                <div>
                        <div class="itens_menu_esq"><a style="color: white;" href="/organizadoresAdm">Gerenciar Organizadores</a></div>  
                        <div class="itens_menu_esq"><a style="color: white;" href="/eventosAdm">Gerenciar Eventos</a></div> 
                        <div class="itens_menu_esq"><a style="color: white;" href="/autoresAdm">Gerenciar Autores</a></div>   
                        <div class="itens_menu_esq"><a style="color: white;" href="/artigosAdm">Gerenciar Artigos</a></div>
                        <div class="itens_menu_esq"><a style="color: white;" href="/secretario">Gerenciar Secretários</a></div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nome do Secretário</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($listaSecretarios) && !empty($listaSecretarios)) :
                            foreach ($listaSecretarios as $secretario) : ?>
                                <tr>
                                    <td><?php echo $secretario['Nome']; ?></td>
                                    <td><?php echo $secretario['Telefone']; ?></td>
                                    <td><?php echo $secretario['Email']; ?></td>
                                    <td>
                                        <button type="button"  id="<?php echo $secretario['Usuario_ID'];?>" data-modal-id="modal3" class="btn3"   onclick="visSecretario(id)"> Verificar</button>                                         
                                            
                                        <button type="button" data-modal-id="modal4" class="btn4" onclick="editOrganizador(id)" id="<?php echo $secretario['Usuario_ID'];?>">Editar</button>
                                                
                                        <button type="button" data-modal-id="modal5" class="btn5" data-target="#modal5" onclick="setOrganizadorIdRemover(<?php echo $secretario['Usuario_ID'];?>)">Remover</button> 
                                    </td>                    
                                <?php endforeach;
                        endif ?>
                    </tbody>
                </table>
            </div>
        </section>

        <script src="views/js/validacoes.js"></script>
        <script src="views/js/functions.js"></script>
        <script src="views/js/jquery-3.6.0.min.js"></script>
        <script src="views/js/functionsmodais.js"></script>

        <footer>
            <div class="wrapper">
                <div class="company-footer">
                    <img src="views/img/logo.png" style="width: 200px; height: 120px;">
                    <div class="text">
                        <h2>BCD © 2023 | All rights reserved.</h2>
                    </div>
                </div>
            </div>
        </footer>
    </body>

</html>