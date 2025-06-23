<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-truck me-2"></i>Gerenciar Fornecedores</h2>
        <a href="index.php?controller=fornecedor&action=create" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Novo Fornecedor
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
            <?php if (empty($fornecedores)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Nenhum fornecedor cadastrado. <a href="index.php?controller=fornecedor&action=create">Clique aqui para adicionar o primeiro fornecedor</a>.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Endereço</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fornecedor['id']); ?></td>
                                    <td><?php echo htmlspecialchars($fornecedor['nome']); ?></td>
                                    <td>
                                        <?php if (!empty($fornecedor['email'])): ?>
                                            <a href="mailto:<?php echo htmlspecialchars($fornecedor['email']); ?>">
                                                <?php echo htmlspecialchars($fornecedor['email']); ?>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($fornecedor['telefone'])): ?>
                                            <a href="tel:<?php echo htmlspecialchars($fornecedor['telefone']); ?>">
                                                <?php echo htmlspecialchars($fornecedor['telefone']); ?>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $endereco = htmlspecialchars($fornecedor['endereco']);
                                        echo !empty($endereco) ? (strlen($endereco) > 50 ? substr($endereco, 0, 50) . '...' : $endereco) : '-';
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if (isset($fornecedor['created_at'])) {
                                            $data = new DateTime($fornecedor['created_at']);
                                            echo $data->format('d/m/Y');
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="index.php?controller=fornecedor&action=edit&id=<?php echo $fornecedor['id']; ?>" 
                                           class="btn btn-primary btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=fornecedor&action=delete&id=<?php echo $fornecedor['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Tem certeza que deseja excluir o fornecedor \'<?php echo htmlspecialchars($fornecedor['nome']); ?>\'?');"
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