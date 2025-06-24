<?php
/**
 * Script para criar novos usuários autorizados no sistema
 * As senhas são criptografadas usando password_hash() do PHP
 */

require_once 'database.php';

class CriarUsuario {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Cria um novo usuário no banco de dados
     * @param string $nome Nome completo do usuário
     * @param string $email Email do usuário (deve ser único)
     * @param string $senha Senha em texto plano (será criptografada)
     * @return array Array com status da operação
     */
    public function criarUsuario($nome, $email, $senha) {
        try {
            // Validações básicas
            if (empty($nome) || empty($email) || empty($senha)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Todos os campos são obrigatórios!'
                ];
            }
            
            // Validar formato do email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Formato de email inválido!'
                ];
            }
            
            // Verificar se o email já existe
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Este email já está cadastrado!'
                ];
            }
            
            // Criptografar a senha usando bcrypt
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            
            // Inserir o novo usuário
            $stmt = $this->db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senha_hash]);
            
            return [
                'sucesso' => true,
                'mensagem' => 'Usuário criado com sucesso!',
                'id' => $this->db->lastInsertId()
            ];
            
        } catch (PDOException $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar usuário: ' . $e->getMessage()
            ];
        }
    }
}

// Interface de linha de comando para criar usuários
if (php_sapi_name() === 'cli') {
    echo "=== CRIADOR DE USUÁRIOS ===\n\n";
    
    $criador = new CriarUsuario();
    
    // Solicitar dados do usuário
    echo "Nome completo: ";
    $nome = trim(fgets(STDIN));
    
    echo "Email: ";
    $email = trim(fgets(STDIN));
    
    echo "Senha: ";
    $senha = trim(fgets(STDIN));
    
    // Criar o usuário
    $resultado = $criador->criarUsuario($nome, $email, $senha);
    
    echo "\n" . $resultado['mensagem'] . "\n";
}

// Interface web para criar usuários (quando acessado via navegador)
if (php_sapi_name() !== 'cli') {
    $criador = new CriarUsuario();
    $mensagem = '';
    $tipo_mensagem = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        $resultado = $criador->criarUsuario($nome, $email, $senha);
        $mensagem = $resultado['mensagem'];
        $tipo_mensagem = $resultado['sucesso'] ? 'success' : 'danger';
    }
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Criar Usuário - Sistema</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- CSS Customizado -->
        <link href="../assets/criar-usuario.css" rel="stylesheet">
    </head>
    <body>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="mb-0">Criar Novo Usuário</h4>
                        </div>
                        
                        <div class="card-body">
                            <?php if ($mensagem): ?>
                                <div class="alert alert-<?php echo $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($mensagem); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="senha" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Criar Usuário</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
?> 