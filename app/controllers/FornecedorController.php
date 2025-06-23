<?php
class FornecedorController {
    private $fornecedorModel;

    public function __construct() {
        $this->fornecedorModel = new Fornecedor();
    }

    public function index() {
        $fornecedores = $this->fornecedorModel->listarTodos();
        require_once BASE_PATH . '/app/views/fornecedores/index.php';
    }

    public function create() {
        require_once BASE_PATH . '/app/views/fornecedores/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $endereco = trim($_POST['endereco'] ?? '');

            if (empty($nome)) {
                header('Location: index.php?controller=fornecedor&action=create&erro=Nome é obrigatório');
                exit;
            }

            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?controller=fornecedor&action=create&erro=Email inválido');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'endereco' => $endereco
            ];

            $resultado = $this->fornecedorModel->criar($dados);

            if (isset($resultado['sucesso'])) {
                header('Location: index.php?controller=fornecedor&action=index&msg=Fornecedor "' . urlencode($nome) . '" criado com sucesso!');
            } else {
                header('Location: index.php?controller=fornecedor&action=create&erro=' . urlencode($resultado['erro']));
            }
            exit;
        }
        header('Location: index.php?controller=fornecedor&action=create');
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=fornecedor&action=index');
            exit;
        }

        $fornecedor = $this->fornecedorModel->buscarPorId($id);
        if (!$fornecedor) {
            header('Location: index.php?controller=fornecedor&action=index&erro=Fornecedor não encontrado');
            exit;
        }

        require_once BASE_PATH . '/app/views/fornecedores/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: index.php?controller=fornecedor&action=index');
                exit;
            }

            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $endereco = trim($_POST['endereco'] ?? '');

            if (empty($nome)) {
                header('Location: index.php?controller=fornecedor&action=edit&id=' . $id . '&erro=Nome é obrigatório');
                exit;
            }

            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?controller=fornecedor&action=edit&id=' . $id . '&erro=Email inválido');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'endereco' => $endereco
            ];

            $resultado = $this->fornecedorModel->atualizar($id, $dados);

            if (isset($resultado['sucesso'])) {
                header('Location: index.php?controller=fornecedor&action=index&msg=Fornecedor "' . urlencode($nome) . '" atualizado com sucesso!');
            } else {
                header('Location: index.php?controller=fornecedor&action=edit&id=' . $id . '&erro=' . urlencode($resultado['erro']));
            }
            exit;
        }
        header('Location: index.php?controller=fornecedor&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=fornecedor&action=index');
            exit;
        }

        $fornecedor = $this->fornecedorModel->buscarPorId($id);
        $nomeFornecedor = $fornecedor ? $fornecedor['nome'] : 'Fornecedor';

        $resultado = $this->fornecedorModel->excluir($id);

        if (isset($resultado['sucesso'])) {
            header('Location: index.php?controller=fornecedor&action=index&msg=Fornecedor "' . urlencode($nomeFornecedor) . '" excluído com sucesso!');
        } else {
            header('Location: index.php?controller=fornecedor&action=index&erro=' . urlencode($resultado['erro']));
        }
        exit;
    }
}
?>