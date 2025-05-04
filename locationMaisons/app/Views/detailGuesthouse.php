<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la maison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?= view('navBar'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4"><?= esc($maison['titre']) ?></h2>
    <div class="row">
        <div class="col-md-6">
            <?php
            $photos = json_decode($maison['photos'] ?? '[]', true);
            if (!empty($photos) && file_exists(FCPATH . $photos[0])) {
                $imgUrl = base_url($photos[0]);
            } elseif (!empty($photos)) {
                $imgUrl = $photos[0]; // fallback si déjà absolu
            } else {
                $imgUrl = 'https://via.placeholder.com/400x250?text=Pas+de+photo';
            }
            ?>
            <img src="<?= $imgUrl ?>" class="img-fluid mb-4" alt="<?= esc($maison['titre']) ?>">
        </div>
        <div class="col-md-6">
            <h4>Description :</h4>
            <p><?= esc($maison['detail']) ?></p>
            <h5>Adresse :</h5>
            <p><strong>Village :</strong> <?= esc($maison['village']) ?></p>
            <p><strong>Pays :</strong> <?= esc($maison['pays']) ?></p>

            <?php if (!empty($maison['attractions'])): ?>
                <h5>Attractions :</h5>
                <p><?= esc($maison['attractions']) ?></p>
            <?php endif; ?>

            <h5>Contact :</h5>
            <p><strong>Téléphone :</strong> <?= esc($maison['telephone'] ?? 'Non renseigné') ?></p>
            <p><strong>Email :</strong> <?= esc($maison['email'] ?? 'Non renseigné') ?></p>

            <a href="#" class="btn btn-primary">Réserver maintenant</a>
        </div>
    </div>
</div>

<?= view('footer'); ?>

</body>
</html>