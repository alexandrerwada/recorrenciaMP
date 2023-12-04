<?php
include 'planos.php';
include 'usuarios.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <!-- Bootstrap 4 CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Painel de Administração</h1>
        <br><br>
        <!-- Seção de Usuários -->
        <section>
            <h2>Usuários</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo $usuario['nome']; ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['assinante'] ? 'Assinante' : 'Não Assinante'; ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verUsuario('<?php echo $usuario['email']; ?>')">Ver</button>
                                <button class="btn btn-primary btn-sm" onclick="editarUsuario('<?php echo $usuario['email']; ?>')">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="apagarUsuario('<?php echo $usuario['email']; ?>')">Apagar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Adicionar Novo Usuário</button>
        </section>
        <br><br>
        <!-- Seção de Planos -->
        <section>
            <h2>Planos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Assinantes</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto) : ?>
                        <tr>
                            <td><?php echo $produto['nome']; ?></td>
                            <td><?php echo $produto['descricao']; ?></td>
                            <td><?php echo $produto['preco']; ?></td>
                            <td>
                                <!-- Aqui você poderia calcular o número de assinantes para cada plano -->
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verPlano('<?php echo $produto['codigo']; ?>')">Ver</button>
                                <button class="btn btn-primary btn-sm" onclick="editarPlano('<?php echo $produto['codigo']; ?>')">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="apagarPlano('<?php echo $produto['codigo']; ?>')">Apagar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addPlanModal">Adicionar Novo Plano</button>
        </section>
    </div>
    <!-- Exemplo de Modal para Adicionar Usuário -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Adicionar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Adição -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Exemplo de Modal para Adicionar Plano -->
    <div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-labelledby="addPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlanModalLabel">Adicionar Plano</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Adição de Plano -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Salvar Plano</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap 4 JavaScript e dependências via CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<script>
    $(document).ready(function() {
        $('#saveButton').on('click', function() {
            var userData = {
                // Colete os dados do formulário
            };

            $.ajax({
                type: 'POST',
                url: 'path_to_your_php_script.php', // Script PHP que processa os dados
                data: userData,
                success: function(response) {
                    // Tratar resposta
                }
            });
        });
    });

    function verUsuario(email) {
        // Implementar a lógica para ver os detalhes do usuário
    }

    function editarUsuario(email) {
        // Implementar a lógica para abrir o modal de edição do usuário
    }

    function apagarUsuario(email) {
        // Implementar a lógica para confirmar e apagar um usuário
    }

    // Funções similares para os planos
    function verPlano(codigo) {
        /* ... */
    }

    function editarPlano(codigo) {
        /* ... */
    }

    function apagarPlano(codigo) {
        /* ... */
    }
</script>

</html>