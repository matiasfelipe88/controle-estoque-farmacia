<?php
class Categoria {
    private $conn;
    private $table = 'categorias';

    public function __construct() {
        try {
            $this->conn = Database::getInstance()->getConnection();
            if (!$this->conn) {
                throw new Exception("Falha na conexão com o banco de dados");
            }
        } catch (Exception $e) {
            error_log("Erro no Categoria::__construct(): " . $e->getMessage());
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
            error_log("Erro em Categoria::listarTodos(): " . $e->getMessage());
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
            error_log("Erro em Categoria::buscarPorId(): " . $e->getMessage());
            return false;
        }
    }

    public function criar($dados) {
        try {
            $query = "INSERT INTO " . $this->table . " (nome, descricao) 
                     VALUES (:nome, :descricao)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':descricao', $dados['descricao']);
            
            if ($stmt->execute()) {
                return ['sucesso' => true, 'id' => $this->conn->lastInsertId()];
            } else {
                return ['erro' => 'Erro ao criar categoria'];
            }
        } catch (Exception $e) {
            error_log("Erro em Categoria::criar(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }

    public function atualizar($id, $dados) {
        try {
            $query = "UPDATE " . $this->table . " 
                     SET nome = :nome, descricao = :descricao
                     WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':descricao', $dados['descricao']);
            
            if ($stmt->execute()) {
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Erro ao atualizar categoria'];
            }
        } catch (Exception $e) {
            error_log("Erro em Categoria::atualizar(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }

    public function excluir($id) {
        try {
            $queryCheck = "SELECT COUNT(*) as total FROM produtos WHERE id_categoria = :id";
            $stmtCheck = $this->conn->prepare($queryCheck);
            $stmtCheck->bindParam(':id', $id);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                return ['erro' => 'Não é possível excluir esta categoria pois há produtos vinculados a ela'];
            }

            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Erro ao excluir categoria'];
            }
        } catch (Exception $e) {
            error_log("Erro em Categoria::excluir(): " . $e->getMessage());
            return ['erro' => 'Erro interno do servidor'];
        }
    }
}
?>