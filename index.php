<?php
include 'planos.php';
include 'usuarios.php';
include 'configs.php';

// Suponha que você tenha alguma lógica para identificar o usuário aqui
// Para o exemplo, vou criar uma variável de exemplo
$usuarioAtualNome = $usuarios[0]['nome']; // Isso seria dinamicamente definido na realidade
$usuarioAtual = $usuarios[0]['email']; // Isso seria dinamicamente definido na realidade
$usuarioAtualId = $usuarios[0]['id'];

// Verifica se o usuário atual é um assinante
$eAssinante = false;
foreach ($usuarios as $usuario) {
    if ($usuario['email'] === $usuarioAtual && $usuario['assinante'] === true) {
        $eAssinante = true;

        break;
    }
}


?>


<!DOCTYPE html>
<html>

<head>
    <title>Checkout Pagamento Recorrente</title>
    <!-- Bootstrap 4 via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("APP_USR-7b1462b3-2205-4957-8e64-7a6b9f9bc644");
        const bricksBuilder = mp.bricks();


    </script>
</head>

<body>

    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Início <span class="sr-only">(atual)</span></a>
                </li>
                <?php if ($eAssinante) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Histórico de pagamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Alterar cartão</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link alert-danger" href="#">CANCELAR ASSINATURA</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="navbar-nav">
                <a class="nav-item nav-link btn btn-primary text-white" href="admin.php">ADMIN</a>
            </div>
        </div>
    </nav>


    <!-- Tabela de Preços com Botões de Assinar -->
    <div class="container mt-4">
        <h2>Tabela de Preços</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($produtos as $produto) {
                    echo '<tr>';
                    echo "<td>{$produto['nome']}</td>";
                    echo "<td>{$produto['preco']}</td>";
                    echo "<td>{$produto['descricao']}</td>";
                    echo "<td><button class='btn btn-primary assinar-btn' data-toggle='modal' data-target='#checkoutModal'   data-id-plano='{$produto['id_plano']}'  data-produto='{$produto['nome']}' data-preco='{$produto['preco']}' data-preco-sem-formatacao='{$produto['preco_sem_formatacao']}' data-descricao='{$produto['descricao']}' data-codigo='{$produto['codigo']}'>Assinar</button></td>";
                    echo '</tr>';
                }
?>
            </tbody>
        </table>
    </div>

    <div class="container mt-4">
        <?php if ($eAssinante) : ?>
            <div class="alert alert-success" role="alert">
                Obrigado por ser um assinante!
            </div>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                Você ainda não é nosso assinante.
            </div>
        <?php endif; ?>
    </div>


    <!-- Modal de Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout de Pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="produtoEscolhido"></h4>
                    <h5 id="precoProduto"></h5>
                    <p id="descricaoProduto"></p>
                    <p id="codigoProduto"></p>
                    <br>
                    <div id="paymentBrick_container"></div>
                    <!-- Formulário de Pagamento -->
                    <!-- <form>
                        <div class="form-group">
                            <label for="cardNumber">Número do Cartão</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="form-group">
                            <label for="cardExpiration">Data de Expiração</label>
                            <input type="text" class="form-control" id="cardExpiration" placeholder="MM/AA">
                        </div>
                        <div class="form-group">
                            <label for="cardCVC">CVC</label>
                            <input type="text" class="form-control" id="cardCVC" placeholder="CVC">
                        </div>
                        <button type="submit" class="btn btn-primary">Efetuar Pagamento</button>
                    </form> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Bootstrap 4 e jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            const renderPaymentBrick = async (bricksBuilder, valor, id_plano) => {
                    const settings = {
                    initialization: {
                        amount: valor,
                        redirectMode: 'modal'
                    },
                    customization: {
                        paymentMethods: {
                        creditCard: "all",
                        },
                    },
                    callbacks: {
                        onReady: () => {
                        /*
                            Callback chamado quando o Brick estiver pronto.
                            Aqui você pode ocultar loadings do seu site, por exemplo.
                        */
                        },
                        onSubmit: ({ selectedPaymentMethod, formData }) => {
                            formData['id_plano'] = id_plano;
                        // callback chamado ao clicar no botão de submissão dos dados
                        return new Promise((resolve, reject) => {
                            fetch("/checkout.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(formData),
                            })
                            .then((response) => response.text())
                            .then((response) => {
                                alert(response);
                                resolve();
                            })
                            .catch((error) => {
                                alert(error);
                                // lidar com a resposta de erro ao tentar criar o pagamento
                                resolve();
                            });
                        });
                        },
                        onError: (error) => {
                        // callback chamado para todos os casos de erro do Brick
                        console.error(error);
                        },
                    },
                    };
                    window.paymentBrickController = await bricksBuilder.create(
                    "payment",
                    "paymentBrick_container",
                    settings
                    );
                };
            
            
            
            $('.assinar-btn').on('click', function() {
                var produto = $(this).data('produto');
                var id_plano = $(this).data('id-plano');
                var preco = $(this).data('preco');
                var precoSemFormatacao = $(this).data('preco-sem-formatacao');
                
                var descricao = $(this).data('descricao');
                var codigo = $(this).data('codigo');

                if (window.paymentBrickController) {
                    window.paymentBrickController.unmount();
                }

                renderPaymentBrick(bricksBuilder, precoSemFormatacao, id_plano);

                $('#produtoEscolhido').text('Produto: ' + produto);
                $('#precoProduto').text('Preço: ' + preco);
                $('#descricaoProduto').text('Descrição: ' + descricao);
                $('#codigoProduto').text('Código: ' + codigo);
            });
        });
    </script>


</body>

</html>