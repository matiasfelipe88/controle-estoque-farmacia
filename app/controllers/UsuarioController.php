<?php
class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function index() {
        $usuarios = $this->usuarioModel->listarTodos();
        require_once BASE_PATH . '/app/views/usuarios/index.php';
    }

    public function create() {
        require_once BASE_PATH . '/app/views/usuarios/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar_senha'] ?? '';

            if (empty($nome)) {
                header('Location: index.php?controller=usuario&action=create&erro=Nome é obrigatório');
                exit;
            }

            if (empty($email)) {
                header('Location: index.php?controller=usuario&action=create&erro=Email é obrigatório');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?controller=usuario&action=create&erro=Email inválido');
                exit;
            }

            if (empty($senha)) {
                header('Location: index.php?controller=usuario&action=create&erro=Senha é obrigatória');
                exit;
            }

            if (strlen($senha) < 6) {
                header('Location: index.php?controller=usuario&action=create&erro=Senha deve ter pelo menos 6 caracteres');
                exit;
            }

            if ($senha !== $confirmarSenha) {
                header('Location: index.php?controller=usuario&action=create&erro=Senhas não coincidem');
                exit;
            }

            $dados = [
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha
            ];

            $resultado = $this->usuarioModel->criar($dados);

            if (isset($resultado['sucesso'])) {
                header('Location: index.php?controller=usuario&action=index&msg=Usuário "' . urlencode($nome) . '" criado com sucesso!');
            } else {
                header('Location: index.php?controller=usuario&action=create&erro=' . urlencode($resultado['erro']));
            }
            exit;
        }
        header('Location: index.php?controller=usuario&action=create');
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=usuario&action=index');
            exit;
        }

        $usuario = $this->usuarioModel->buscarPorId($id);
        if (!$usuario) {
            header('Location: index.php?controller=usuario&action=index&erro=Usuário não encontrado');
            exit;
        }

        require_once BASE_PATH . '/app/views/usuarios/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: index.php?controller=usuario&action=index');
                exit;
            }

            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar_senha'] ?? '';

            if (empty($nome)) {
                header('Location: index.php?controller=usuario&action=edit&id=' . $id . '&erro=Nome é obrigatório');
                exit;
            }

            if (empty($email)) {
                header('Location: index.php?controller=usuario&action=edit&id=' . $id . '&erro=Email é obrigatório');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?controller=usuario&action=edit&id=' . $id . '&erro=Email inválido');
                exit;
            }

            if (!empty($senha)) {
                if (strlen($senha) < 6) {
                    header('Location: index.php?controller=usuario&action=edit&id=' . $id . '&erro=Senha deve ter pelo menos 6 caracteres');
                    exit;
                }

                if ($senha !== $confirmarSenha) {
                    header('Location: index.php?controller=usuario&action=edit&id=' . $id . '&erro=Senhas não coincidem');
                    exit;
                }
            }

            $dados = [
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha
            ];

            $resultado = $this->usuarioModel->atualizar($id, $dados);

            if (isset($resultado['sucesso'])) {
                header('Location: index.php?controller=usuario&action=index&msg=Usuário "' . urlencode($nome) . '" atualizado com sucesso!');
            } else {
                header('Location: index.php?controller=usuario&action=edit&id=' . $id . '&erro=' . urlencode($resultado['erro']));
            }
            exit;
        }
        header('Location: index.php?controller=usuario&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=usuario&action=index');
            exit;
        }

        if ($id == $_SESSION['user_id']) {
            header('Location: index.php?controller=usuario&action=index&erro=Você não pode excluir sua própria conta');
            exit;
        }

        $usuario = $this->usuarioModel->buscarPorId($id);
        $nomeUsuario = $usuario ? $usuario['nome'] : 'Usuário';

        $resultado = $this->usuarioModel->excluir($id);

        if (isset($resultado['sucesso'])) {
            header('Location: index.php?controller=usuario&action=index&msg=Usuário "' . urlencode($nomeUsuario) . '" excluído com sucesso!');
        } else {
            header('Location: index.php?controller=usuario&action=index&erro=' . urlencode($resultado['erro']));
        }
        exit;
    }
}
?>