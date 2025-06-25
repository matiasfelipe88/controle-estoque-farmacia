<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<h2>Movimentar Estoque</h2>

<form action="index.php?controller=movimentacao&action=salvar" method="POST" class="card p-3">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="id_produto" class="form-label">Produto</label>
            <select class="form-select" id="id_produto" name="id_produto" required>
                <option value="">Selecione um produto...</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= $produto['id'] ?>">
                        <?= htmlspecialchars($produto['nome']) ?> (Estoque: <?= $produto['quantidade_estoque'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo de Movimentação</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo" id="entrada" value="entrada" checked>
                    <label class="form-check-label" for="entrada">Entrada</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo" id="saida" value="saida">
                    <label class="form-check-label" for="saida">Saída</label>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="observacao" class="form-label">Observação (Opcional)</label>
            <input type="text" class="form-control" id="observacao" name="observacao">
        </div>
    </div>
    
    <div class="mt-3">
        <button type="submit" class="btn btn-success">Registrar Movimentação</button>
        <a href="index.php?controller=produto&action=index" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>
