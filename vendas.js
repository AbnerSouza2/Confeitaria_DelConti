
document.addEventListener('DOMContentLoaded', function() {
    var opcoesPagamento = document.querySelectorAll('input[name="forma_pagamento"]');
    var valorRecebidoContainer = document.getElementById('valor-recebido-container');
    var trocoContainer = document.getElementById('troco-container');
    var clienteFiadoContainer = document.getElementById('cliente-fiado-container');

    opcoesPagamento.forEach(function(opcao) {
        opcao.addEventListener('change', function() {
            if (this.value === 'dinheiro') {
                valorRecebidoContainer.style.display = 'block';
                trocoContainer.style.display = 'block';
                clienteFiadoContainer.style.display = 'none';
            } else if (this.value === 'fiado') {
                valorRecebidoContainer.style.display = 'none';
                trocoContainer.style.display = 'none';
                clienteFiadoContainer.style.display = 'block';
            } else {
                valorRecebidoContainer.style.display = 'none';
                trocoContainer.style.display = 'none';
                clienteFiadoContainer.style.display = 'none';
            }
        });
    });

    document.getElementById('valor_recebido').addEventListener('input', function() {
        var precoProduto = parseFloat(document.getElementById('produto').selectedOptions[0].getAttribute('data-preco'));
        var quantidade = parseInt(document.getElementById('quantidade').value);
        var valorTotal = precoProduto * quantidade;
        var valorRecebido = parseFloat(this.value);
        var troco = valorRecebido - valorTotal;
        document.getElementById('troco').textContent = troco.toFixed(2);
    });

    document.getElementById('btn-confirmar-venda').addEventListener('click', function(event) {
        event.preventDefault();

        var produto = document.getElementById('produto').value;
        var quantidade = document.getElementById('quantidade').value;
        var formaPagamento = document.querySelector('input[name="forma_pagamento"]:checked').value;
        var clienteFiado = document.getElementById('cliente_fiado').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'bd_vendas.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);
                    if (response.success) {
                        document.querySelector('form').reset();
                    }
                } catch (e) {
                    alert('Erro ao processar a resposta do servidor.');
                }
            } else {
                alert('Erro na requisição: ' + xhr.status);
            }
        };
        xhr.send('produto=' + produto + '&quantidade=' + quantidade + '&forma_pagamento=' + formaPagamento + '&cliente_fiado=' + clienteFiado);
    });
    
});
