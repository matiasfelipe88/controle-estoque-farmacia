<?php
class AuthController {
    public function login() {
        $erro = isset($_GET['erro']);
        require_once BASE_PATH . '/app/views/auth/login.php';
    }

    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = $_POST['email'] ?? '';
                $senha = $_POST['senha'] ?? '';

                if (empty($email) || empty($senha)) {
                    header('Location: index.php?controller=auth&action=login&erro=1');
                    exit;
                }

                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->buscarPorEmail($email);

                if ($usuario && password_verify($senha, $usuario['senha'])) {
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['user_name'] = $usuario['nome'];
                    header('Location: index.php?controller=produto&action=index');
                    exit;
                } else {
                    header('Location: index.php?controller=auth&action=login&erro=1');
                    exit;
                }
            } catch (Exception $e) {
                error_log("Erro em AuthController::autenticar(): " . $e->getMessage());
                header('Location: index.php?controller=auth&action=login&erro=1');
                exit;
            }
        } else {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
?>
