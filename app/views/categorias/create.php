<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus me-2"></i>Cadastrar Nova Categoria</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_GET['erro']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=categoria&action=store" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria *</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>" 
                                   placeholder="Ex: Medicamentos, Cosméticos, Higiene..." required>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4"
                                      placeholder="Descreva o tipo de produtos desta categoria..."><?php echo htmlspecialchars($_POST['descricao'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=categoria&action=index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Cadastrar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>