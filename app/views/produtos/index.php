<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Produtos</h2>
        <a href="index.php?controller=produto&action=create" class="btn btn-success">Adicionar Produto</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['erro']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php if (empty($produtos)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Nenhum produto cadastrado. <a href="index.php?controller=produto&action=create">Clique aqui para adicionar o primeiro produto</a>.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Validade</th>
                                <th>Categoria</th>
                                <th>Fornecedor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($produto['id']); ?></td>
                                    <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                                    <td>R$ <?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge <?php echo $produto['quantidade_estoque'] <= 10 ? 'bg-danger' : 'bg-success'; ?>">
                                            <?php echo $produto['quantidade_estoque']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        if ($produto['validade']) {
                                            $validade = new DateTime($produto['validade']);
                                            $hoje = new DateTime();
                                            $diff = $hoje->diff($validade);

                                            if ($validade < $hoje) {
                                                echo '<span class="badge bg-danger">Vencido</span>';
                                            } elseif ($diff->days <= 30) {
                                                echo '<span class="badge bg-warning">Vence em ' . $diff->days . ' dias</span>';
                                            } else {
                                                echo $validade->format('d/m/Y');
                                            }
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($produto['categoria_nome'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($produto['fornecedor_nome'] ?? '-'); ?></td>
                                    <td>
                                        <a href="index.php?controller=produto&action=edit&id=<?php echo $produto['id']; ?>"
                                           class="btn btn-primary btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=produto&action=delete&id=<?php echo $produto['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Tem certeza que deseja excluir o produto \'<?php echo htmlspecialchars($produto['nome']); ?>\'?');"
                                           title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>
