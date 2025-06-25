<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-tags me-2"></i>Gerenciar Categorias</h2>
        <a href="index.php?controller=categoria&action=create" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nova Categoria
        </a>
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
            <?php if (empty($categorias)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Nenhuma categoria cadastrada. <a href="index.php?controller=categoria&action=create">Clique aqui para adicionar a primeira categoria</a>.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                                    <td>
                                        <span class="badge bg-primary me-2">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <?php echo htmlspecialchars($categoria['nome']); ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $descricao = htmlspecialchars($categoria['descricao']);
                                        echo !empty($descricao) ? (strlen($descricao) > 80 ? substr($descricao, 0, 80) . '...' : $descricao) : '-';
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if (isset($categoria['created_at'])) {
                                            $data = new DateTime($categoria['created_at']);
                                            echo $data->format('d/m/Y');
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="index.php?controller=categoria&action=edit&id=<?php echo $categoria['id']; ?>" 
                                           class="btn btn-primary btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=categoria&action=delete&id=<?php echo $categoria['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Tem certeza que deseja excluir a categoria \'<?php echo htmlspecialchars($categoria['nome']); ?>\'?');"
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