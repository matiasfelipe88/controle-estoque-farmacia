<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus me-2"></i>Cadastrar Novo Fornecedor</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_GET['erro']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=fornecedor&action=store" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Fornecedor *</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" 
                                           value="<?php echo htmlspecialchars($_POST['telefone'] ?? ''); ?>"
                                           placeholder="(11) 1234-5678">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <textarea class="form-control" id="endereco" name="endereco" rows="3"
                                      placeholder="Rua, número, bairro, cidade, CEP"><?php echo htmlspecialchars($_POST['endereco'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=fornecedor&action=index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Cadastrar Fornecedor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>