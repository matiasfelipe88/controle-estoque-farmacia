<?php
class Movimentacao {
    private $conn;
    private $table = 'movimentacoes';

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function criar($dados) {
        $query = "INSERT INTO " . $this->table . " (id_produto, tipo, quantidade, id_usuario, observacao) 
                  VALUES (:id_produto, :tipo, :quantidade, :id_usuario, :observacao)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_produto', $dados['id_produto']);
        $stmt->bindParam(':tipo', $dados['tipo']);
        $stmt->bindParam(':quantidade', $dados['quantidade']);
        $stmt->bindParam(':id_usuario', $dados['id_usuario']);
        $stmt->bindParam(':observacao', $dados['observacao']);
        
        return $stmt->execute();
    }
}
?>
