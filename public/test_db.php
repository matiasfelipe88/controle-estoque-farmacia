<?php
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "Conexão com banco: OK<br>";
    
    $stmt = $db->query("SELECT * FROM usuarios WHERE email = 'admin@farmacia.com'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "Usuário encontrado: " . $user['nome'] . "<br>";
        echo "Email: " . $user['email'] . "<br>";
        echo "Senha hash: " . $user['senha'] . "<br>";
        
        // Testar verificação de senha
        if (password_verify('admin', $user['senha'])) {
            echo "Senha 'admin' confere!<br>";
        } else {
            echo "Senha 'admin' NÃO confere!<br>";
        }
    } else {
        echo "Usuário admin não encontrado!<br>";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>