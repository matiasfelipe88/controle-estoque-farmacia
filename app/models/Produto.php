<?php
class Produto {
    private $conn;
    private $table = 'produtos';

    public function __construct() {
        try {
            $this->conn = Database::getInstance()->getConnection();
            if (!$this->conn) {
                throw new Exception("Falha na conexão com o banco de dados");
            }
        } catch (Exception $e) {
            error_log("Erro no Produto::__construct(): " . $e->getMessage());
            throw $e;
        }
    }

    public function listarTodos() {
        try {
            $query = "SELECT p.*,
                             c.nome as categoria_nome,
                             f.nome as fornecedor_nome
                      FROM " . $this->table . " p
                      LEFT JOIN categorias c ON p.id_categoria = c.id
                      LEFT JOIN fornecedores f ON p.id_fornecedor = f.id
                      ORDER BY p.id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Produto::listarTodos(): " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $query = "SELECT p.*,
                             c.nome as categoria_nome,
                             f.nome as fornecedor_nome
                      FROM " . $this->table . " p
                      LEFT JOIN categorias c ON p.id_categoria = c.id
                      LEFT JOIN fornecedores f ON p.id_fornecedor = f.id
                      WHERE p.id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Produto::buscarPorId(): " . $e->getMessage());
            return false;
        }
    }

    public function criar($dados) {
        try {
            $query = "INSERT INTO " . $this->table . "
                     (nome, descricao, preco_venda, quantidade_estoque, validade, id_categoria, id_fornecedor)
                     VALUES (:nome, :descricao, :preco_venda, :quantidade_estoque, :validade, :id_categoria, :id_fornecedor)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':descricao', $dados['descricao']);
            $stmt->bindParam(':preco_venda', $dados['preco']);
            $stmt->bindParam(':quantidade_estoque', $dados['estoque']);
            $stmt->bindParam(':validade', $dados['validade']);
            $stmt->bindParam(':id_categoria', $dados['id_categoria']);
            $stmt->bindParam(':id_fornecedor', $dados['id_fornecedor']);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro em Produto::criar(): " . $e->getMessage());
            return false;
        }
    }

    public function atualizar($id, $dados) {
        try {
            $query = "UPDATE " . $this->table . "
                     SET nome = :nome, descricao = :descricao, preco_venda = :preco_venda,
                         quantidade_estoque = :quantidade_estoque, validade = :validade,
                         id_categoria = :id_categoria, id_fornecedor = :id_fornecedor
                     WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':descricao', $dados['descricao']);
            $stmt->bindParam(':preco_venda', $dados['preco']);
            $stmt->bindParam(':quantidade_estoque', $dados['estoque']);
            $stmt->bindParam(':validade', $dados['validade']);
            $stmt->bindParam(':id_categoria', $dados['id_categoria']);
            $stmt->bindParam(':id_fornecedor', $dados['id_fornecedor']);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro em Produto::atualizar(): " . $e->getMessage());
            return false;
        }
    }

    public function excluir($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro em Produto::excluir(): " . $e->getMessage());
            return false;
        }
    }

    public function listarCategorias() {
        try {
            $query = "SELECT * FROM categorias ORDER BY nome";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Produto::listarCategorias(): " . $e->getMessage());
            return [];
        }
    }

    public function listarFornecedores() {
        try {
            $query = "SELECT * FROM fornecedores ORDER BY nome";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro em Produto::listarFornecedores(): " . $e->getMessage());
            return [];
        }
    }
}
?>
