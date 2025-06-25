<?php
class ProdutoController {
    private $produtoModel;

    public function __construct() {
        $this->produtoModel = new Produto();
    }

    public function index() {
        $produtos = $this->produtoModel->listarTodos();
        require_once BASE_PATH . '/app/views/produtos/index.php';
    }

    public function create() {
        $categorias = $this->produtoModel->listarCategorias();
        $fornecedores = $this->produtoModel->listarFornecedores();
        require_once BASE_PATH . '/app/views/produtos/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validações básicas
            $nome = trim($_POST['nome'] ?? '');
            $preco = floatval($_POST['preco'] ?? 0);
            $estoque = intval($_POST['estoque'] ?? 0);

            if (empty($nome)) {
                header('Location: index.php?controller=produto&action=create&erro=Nome do produto é obrigatório');
                exit;
            }

            if ($preco <= 0) {
                header('Location: index.php?controller=produto&action=create&erro=Preço deve ser maior que zero');
                exit;
            }

            if ($estoque < 0) {
                header('Location: index.php?controller=produto&action=create&erro=Estoque não pode ser negativo');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'descricao' => trim($_POST['descricao'] ?? ''),
                'preco' => $preco,
                'estoque' => $estoque,
                'validade' => $_POST['validade'] ?? null,
                'id_categoria' => !empty($_POST['id_categoria']) ? intval($_POST['id_categoria']) : null,
                'id_fornecedor' => !empty($_POST['id_fornecedor']) ? intval($_POST['id_fornecedor']) : null
            ];

            if ($this->produtoModel->criar($dados)) {
                header('Location: index.php?controller=produto&action=index&msg=Produto "' . urlencode($dados['nome']) . '" adicionado com sucesso!');
            } else {
                header('Location: index.php?controller=produto&action=create&erro=Erro ao adicionar produto. Verifique os dados e tente novamente.');
            }
            exit;
        }
        header('Location: index.php?controller=produto&action=create');
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=produto&action=index');
            exit;
        }

        $produto = $this->produtoModel->buscarPorId($id);
        if (!$produto) {
            header('Location: index.php?controller=produto&action=index&erro=Produto não encontrado');
            exit;
        }

        $categorias = $this->produtoModel->listarCategorias();
        $fornecedores = $this->produtoModel->listarFornecedores();
        require_once BASE_PATH . '/app/views/produtos/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: index.php?controller=produto&action=index');
                exit;
            }

            $nome = trim($_POST['nome'] ?? '');
            $preco = floatval($_POST['preco'] ?? 0);
            $estoque = intval($_POST['estoque'] ?? 0);

            if (empty($nome)) {
                header('Location: index.php?controller=produto&action=edit&id=' . $id . '&erro=Nome do produto é obrigatório');
                exit;
            }

            if ($preco <= 0) {
                header('Location: index.php?controller=produto&action=edit&id=' . $id . '&erro=Preço deve ser maior que zero');
                exit;
            }

            if ($estoque < 0) {
                header('Location: index.php?controller=produto&action=edit&id=' . $id . '&erro=Estoque não pode ser negativo');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'descricao' => trim($_POST['descricao'] ?? ''),
                'preco' => $preco,
                'estoque' => $estoque,
                'validade' => $_POST['validade'] ?? null,
                'id_categoria' => !empty($_POST['id_categoria']) ? intval($_POST['id_categoria']) : null,
                'id_fornecedor' => !empty($_POST['id_fornecedor']) ? intval($_POST['id_fornecedor']) : null
            ];

            if ($this->produtoModel->atualizar($id, $dados)) {
                header('Location: index.php?controller=produto&action=index&msg=Produto "' . urlencode($dados['nome']) . '" atualizado com sucesso!');
            } else {
                header('Location: index.php?controller=produto&action=edit&id=' . $id . '&erro=Erro ao atualizar produto');
            }
            exit;
        }
        header('Location: index.php?controller=produto&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=produto&action=index');
            exit;
        }

        $produto = $this->produtoModel->buscarPorId($id);
        $nomeProduto = $produto ? $produto['nome'] : 'Produto';

        if ($this->produtoModel->excluir($id)) {
            header('Location: index.php?controller=produto&action=index&msg=Produto "' . urlencode($nomeProduto) . '" excluído com sucesso!');
        } else {
            header('Location: index.php?controller=produto&action=index&erro=Erro ao excluir produto');
        }
        exit;
    }
}
?>
