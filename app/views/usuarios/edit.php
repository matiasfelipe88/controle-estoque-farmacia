<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-edit me-2"></i>Editar Usuário</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_GET['erro']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=usuario&action=update" method="POST">
                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                        </div>

                        <hr>
                        <h6>Alterar Senha (opcional)</h6>
                        <div class="form-text mb-3">Deixe em branco se não quiser alterar a senha.</div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha">
                            <div class="form-text">Mínimo de 6 caracteres.</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=usuario&action=index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Atualizar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
<<<<<<< HEAD

=======
// Validar senhas em tempo real
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
document.getElementById('confirmar_senha').addEventListener('input', function() {
    const senha = document.getElementById('senha').value;
    const confirmarSenha = this.value;
    
    if (senha && senha !== confirmarSenha) {
        this.setCustomValidity('Senhas não coincidem');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>