<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une maison</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?= view('navbar'); ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Modifier la maison</h2>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"> <?= session()->getFlashdata('error'); ?> </div>
    <?php endif; ?>

    <div class="card p-4 shadow">
        <form action="<?= base_url('allGuesthouses/update/' . $guesthouse['idGuesthouse']); ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Titre :</label>
                <input type="text" name="titre" class="form-control" value="<?= esc($guesthouse['titre']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description :</label>
                <textarea name="detail" class="form-control" rows="3" required><?= esc($guesthouse['detail']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Village :</label>
                <input type="text" name="village" class="form-control" value="<?= esc($guesthouse['village']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pays :</label>
                <select name="pays" class="form-select" required>
                    <option value="FR" <?= esc($guesthouse['pays']) == 'FR' ? 'selected' : ''; ?>>France</option>
                    <option value="BE" <?= esc($guesthouse['pays']) == 'BE' ? 'selected' : ''; ?>>Belgique</option>
                    <option value="IT" <?= esc($guesthouse['pays']) == 'IT' ? 'selected' : ''; ?>>Italie</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Attractions :</label>
                <textarea name="attractions" class="form-control" rows="3" required><?= esc($guesthouse['attractions']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Photos actuelles :</label><br>
                <?php 
                    $photos = json_decode($guesthouse['photos'], true);
                    if (!empty($photos) && is_array($photos)) :
                        foreach ($photos as $photo) :
                ?>
                    <img src="<?= base_url($photo); ?>" class="img-thumbnail me-2 mb-2" width="100">
                <?php endforeach; else: ?>
                    <span class="text-muted">Aucune photo disponible</span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Ajouter de nouvelles photos :</label>
                <input type="file" name="photos[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>