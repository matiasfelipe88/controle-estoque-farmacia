<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

// Habilitar exibição de erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carregar a conexão com o banco PRIMEIRO
require_once BASE_PATH . '/config/database.php';

// Autoloader melhorado
spl_autoload_register(function ($class_name) {
    // Tentar carregar de models
    $model_file = BASE_PATH . '/app/models/' . $class_name . '.php';
    if (file_exists($model_file)) {
        require_once $model_file;
        return;
    }

    // Tentar carregar de controllers
    $controller_file = BASE_PATH . '/app/controllers/' . $class_name . '.php';
    if (file_exists($controller_file)) {
        require_once $controller_file;
        return;
    }

    // Tentar carregar de config (para classe Database)
    $config_file = BASE_PATH . '/config/' . $class_name . '.php';
    if (file_exists($config_file)) {
        require_once $config_file;
        return;
    }
});

// Roteamento
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'ProdutoController';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// --- Verificação de Segurança ---
// Se o usuário NÃO estiver logado E a página que ele tenta acessar NÃO for a de login/autenticação...
if (!isset($_SESSION['user_id']) && 
    !($controllerName === 'AuthController' && ($actionName === 'login' || $actionName === 'autenticar'))) 
{
    // ...redireciona para o login.
    header('Location: index.php?controller=auth&action=login');
    exit;
}

// Se o usuário ESTIVER logado e tentar acessar a página de login...
if (isset($_SESSION['user_id']) && $controllerName === 'AuthController' && $actionName === 'login') {
    // ...redireciona para a página principal de produtos.
    header('Location: index.php?controller=produto&action=index');
    exit;
}


// Verificar se o controller existe
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    
    // Verificar se a ação (método) existe no controller
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        die("Ação '{$actionName}' não encontrada no controller '{$controllerName}'.");
    }
} else {
    die("Controller '{$controllerName}' não encontrado.");
}
?>
