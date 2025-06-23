<?php require_once BASE_PATH . '/app/views/partials/header.php'; ?>

<h2><?= isset($categoria['id']) ? 'Editar Categoria' : 'Nova Categoria' ?></h2>

<form action="index.php?controller=categoria&action=salvar" method="POST">
    <?php if (isset($categoria['id'])): ?>
        <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Categoria</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($categoria['nome'] ?? '') ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="index.php?controller=categoria&action=index" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once BASE_PATH . '/app/views/partials/footer.php'; ?>
