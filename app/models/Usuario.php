<?php
class Usuario {
    private $conn;
    private $table = 'usuarios';

    public function __construct() {
        try {
            $this->conn = Database::getInstance()->getConnection();
            if (!$this->conn) {
                throw new Exception("Falha na conexão com o banco de dados");
            }
        } catch (Exception $e) {
            error_log("Erro no Usuario::__construct(): " . $e->getMessage());
            throw $e;
        }
    }

    public function buscarPorEmail($email) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Usuario::buscarPorEmail(): " . $e->getMessage());
            return false;
        }
    }

    public function listarTodos() {
        try {
            $query = "SELECT id, nome, email, criado_em FROM " . $this->table . " ORDER BY nome";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Usuario::listarTodos(): " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $query = "SELECT id, nome, email, criado_em FROM " . $this->table . " WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Usuario::buscarPorId(): " . $e->getMessage());
            return false;
        }
    }

    public function criar($dados) {
        try {
            // Verificar se o email já existe
            if ($this->buscarPorEmail($dados['email'])) {
                return ['erro' => 'Este email já está cadastrado'];
            }

            $query = "INSERT INTO " . $this->table . " (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $this->conn->prepare($query);

            // Hash da senha
            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);

            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':email', $dados['email']);
            $stmt->bindParam(':senha', $senhaHash);

            if ($stmt->execute()) {
                return ['sucesso' => true, 'id' => $this->conn->lastInsertId()];
            } else {
                return ['erro' => 'Erro ao criar usuário'];
            }
        } catch (Exception $e) {
            error_log("Erro em Usuario::criar(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }

    public function atualizar($id, $dados) {
        try {
            // Verificar se o email já existe em outro usuário
            $usuarioExistente = $this->buscarPorEmail($dados['email']);
            if ($usuarioExistente && $usuarioExistente['id'] != $id) {
                return ['erro' => 'Este email já está sendo usado por outro usuário'];
            }

            $query = "UPDATE " . $this->table . " SET nome = :nome, email = :email";
            $params = [
                ':id' => $id,
                ':nome' => $dados['nome'],
                ':email' => $dados['email']
            ];

            // Se uma nova senha foi fornecida, incluir na atualização
            if (!empty($dados['senha'])) {
                $query .= ", senha = :senha";
                $params[':senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
            }

            $query .= " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            if ($stmt->execute($params)) {
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Erro ao atualizar usuário'];
            }
        } catch (Exception $e) {
            error_log("Erro em Usuario::atualizar(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }

    public function excluir($id) {
        try {
            // Não permitir excluir o usuário admin (id = 1)
            if ($id == 1) {
                return ['erro' => 'Não é possível excluir o usuário administrador'];
            }

            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Erro ao excluir usuário'];
            }
        } catch (Exception $e) {
            error_log("Erro em Usuario::excluir(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }
}
?>
