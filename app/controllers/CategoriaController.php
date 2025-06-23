<?php
class CategoriaController {
    private $categoriaModel;

    public function __construct() {
        $this->categoriaModel = new Categoria();
    }

    public function index() {
        $categorias = $this->categoriaModel->listarTodos();
        require_once BASE_PATH . '/app/views/categorias/index.php';
    }

    public function create() {
        require_once BASE_PATH . '/app/views/categorias/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');

            if (empty($nome)) {
                header('Location: index.php?controller=categoria&action=create&erro=Nome é obrigatório');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'descricao' => $descricao
            ];

            $resultado = $this->categoriaModel->criar($dados);

            if (isset($resultado['sucesso'])) {
                header('Location: index.php?controller=categoria&action=index&msg=Categoria "' . urlencode($nome) . '" criada com sucesso!');
            } else {
                header('Location: index.php?controller=categoria&action=create&erro=' . urlencode($resultado['erro']));
            }
            exit;
        }
        header('Location: index.php?controller=categoria&action=create');
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=categoria&action=index');
            exit;
        }

        $categoria = $this->categoriaModel->buscarPorId($id);
        if (!$categoria) {
            header('Location: index.php?controller=categoria&action=index&erro=Categoria não encontrada');
            exit;
        }

        require_once BASE_PATH . '/app/views/categorias/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: index.php?controller=categoria&action=index');
                exit;
            }

            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');

            if (empty($nome)) {
                header('Location: index.php?controller=categoria&action=edit&id=' . $id . '&erro=Nome é obrigatório');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'descricao' => $descricao
            ];

            $resultado = $this->categoriaModel->atualizar($id, $dados);

            if (isset($resultado['sucesso'])) {
                header('Location: index.php?controller=categoria&action=index&msg=Categoria "' . urlencode($nome) . '" atualizada com sucesso!');
            } else {
                header('Location: index.php?controller=categoria&action=edit&id=' . $id . '&erro=' . urlencode($resultado['erro']));
            }
            exit;
        }
        header('Location: index.php?controller=categoria&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=categoria&action=index');
            exit;
        }

        $categoria = $this->categoriaModel->buscarPorId($id);
        $nomeCategoria = $categoria ? $categoria['nome'] : 'Categoria';

        $resultado = $this->categoriaModel->excluir($id);

        if (isset($resultado['sucesso'])) {
            header('Location: index.php?controller=categoria&action=index&msg=Categoria "' . urlencode($nomeCategoria) . '" excluída com sucesso!');
        } else {
            header('Location: index.php?controller=categoria&action=index&erro=' . urlencode($resultado['erro']));
        }
        exit;
    }
}
?>