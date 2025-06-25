<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit me-2"></i>Editar Produto</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_GET['erro']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=produto&action=update" method="POST">
                        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome do Produto *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" 
                                           value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="preco" class="form-label">Preço (R$) *</label>
                                    <input type="number" class="form-control" id="preco" name="preco" 
                                           step="0.01" min="0" value="<?php echo $produto['preco_venda']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="estoque" class="form-label">Quantidade em Estoque *</label>
                                    <input type="number" class="form-control" id="estoque" name="estoque" 
                                           min="0" value="<?php echo $produto['quantidade_estoque']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="validade" class="form-label">Data de Validade</label>
                                    <input type="date" class="form-control" id="validade" name="validade" 
                                           value="<?php echo $produto['validade']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="id_categoria" class="form-label">Categoria</label>
                                    <select class="form-control" id="id_categoria" name="id_categoria">
                                        <option value="">Selecione uma categoria</option>
                                        <?php if (isset($categorias)): ?>
                                            <?php foreach ($categorias as $categoria): ?>
                                                <option value="<?php echo $categoria['id']; ?>" 
                                                        <?php echo ($produto['id_categoria'] == $categoria['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($categoria['nome']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_fornecedor" class="form-label">Fornecedor</label>
                            <select class="form-control" id="id_fornecedor" name="id_fornecedor">
                                <option value="">Selecione um fornecedor</option>
                                <?php if (isset($fornecedores)): ?>
                                    <?php foreach ($fornecedores as $fornecedor): ?>
                                        <option value="<?php echo $fornecedor['id']; ?>" 
                                                <?php echo ($produto['id_fornecedor'] == $fornecedor['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($fornecedor['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=produto&action=index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Atualizar Produto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>