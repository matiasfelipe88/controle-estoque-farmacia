<?php
class Fornecedor {
    private $conn;
    private $table = 'fornecedores';

    public function __construct() {
        try {
            $this->conn = Database::getInstance()->getConnection();
            if (!$this->conn) {
                throw new Exception("Falha na conexão com o banco de dados");
            }
        } catch (Exception $e) {
            error_log("Erro no Fornecedor::__construct(): " . $e->getMessage());
            throw $e;
        }
    }

    public function listarTodos() {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY nome";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Fornecedor::listarTodos(): " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Fornecedor::buscarPorId(): " . $e->getMessage());
            return false;
        }
    }

    public function criar($dados) {
        try {
            $query = "INSERT INTO " . $this->table . " (nome, email, telefone, endereco) 
                     VALUES (:nome, :email, :telefone, :endereco)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':email', $dados['email']);
            $stmt->bindParam(':telefone', $dados['telefone']);
            $stmt->bindParam(':endereco', $dados['endereco']);
            
            if ($stmt->execute()) {
                return ['sucesso' => true, 'id' => $this->conn->lastInsertId()];
            } else {
                return ['erro' => 'Erro ao criar fornecedor'];
            }
        } catch (Exception $e) {
            error_log("Erro em Fornecedor::criar(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }

    public function atualizar($id, $dados) {
        try {
            $query = "UPDATE " . $this->table . " 
                     SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco
                     WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':email', $dados['email']);
            $stmt->bindParam(':telefone', $dados['telefone']);
            $stmt->bindParam(':endereco', $dados['endereco']);
            
            if ($stmt->execute()) {
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Erro ao atualizar fornecedor'];
            }
        } catch (Exception $e) {
            error_log("Erro em Fornecedor::atualizar(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }

    public function excluir($id) {
        try {
            $queryCheck = "SELECT COUNT(*) as total FROM produtos WHERE id_fornecedor = :id";
            $stmtCheck = $this->conn->prepare($queryCheck);
            $stmtCheck->bindParam(':id', $id);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                return ['erro' => 'Não é possível excluir este fornecedor pois há produtos vinculados a ele'];
            }

            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Erro ao excluir fornecedor'];
            }
        } catch (Exception $e) {
            error_log("Erro em Fornecedor::excluir(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }
}
?>