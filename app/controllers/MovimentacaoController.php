<?php
class MovimentacaoController {
    private function setMensagem($tipo, $texto) {
        $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
    }

    public function formulario() {
        $produtoModel = new Produto();
        $produtos = $produtoModel->listar(); // Requer o método listar() no Produto.php
        require_once BASE_PATH . '/app/views/movimentacoes/formulario.php';
    }

    public function salvar() {
        // Validações
        $id_produto = $_POST['id_produto'] ?? null;
        $tipo = $_POST['tipo'] ?? null;
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

        if (!$id_produto || !$tipo || $quantidade === false || $quantidade <= 0) {
            $this->setMensagem('danger', 'Todos os campos são obrigatórios e a quantidade deve ser um número positivo.');
            header('Location: index.php?controller=movimentacao&action=formulario');
            exit;
        }

        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $produtoModel = new Produto();
        $movimentacaoModel = new Movimentacao();

        try {
            $conn->beginTransaction();

            // 1. Verifica o estoque atual para saídas
            if ($tipo === 'saida') {
                $produto = $produtoModel->buscarPorId($id_produto);
                if ($produto['quantidade_estoque'] < $quantidade) {
                    throw new Exception('Estoque insuficiente para realizar a saída.');
                }
                $quantidade_a_atualizar = -$quantidade;
            } else {
                $quantidade_a_atualizar = $quantidade;
            }

            // 2. Atualiza o estoque do produto
            $produtoModel->atualizarEstoque($id_produto, $quantidade_a_atualizar);

            // 3. Registra a movimentação
            $dadosMovimentacao = [
                'id_produto' => $id_produto,
                'tipo' => $tipo,
                'quantidade' => $quantidade,
                'id_usuario' => $_SESSION['user_id'],
                'observacao' => $_POST['observacao'] ?? ''
            ];
            $movimentacaoModel->criar($dadosMovimentacao);

            // Se tudo deu certo, confirma a transação
            $conn->commit();
            $this->setMensagem('success', 'Movimentação de estoque realizada com sucesso!');
            header('Location: index.php?controller=produto&action=index');

        } catch (Exception $e) {
            // Se algo deu errado, desfaz tudo
            $conn->rollBack();
            $this->setMensagem('danger', 'Erro ao processar a movimentação: ' . $e->getMessage());
            header('Location: index.php?controller=movimentacao&action=formulario');
        }
    }
}
?>
