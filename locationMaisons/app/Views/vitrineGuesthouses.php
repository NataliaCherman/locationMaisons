<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maisons à louer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
        }

        .section-heading {
            font-size: 1.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #ddd;
            padding-top : 20px;
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: #333;
        }

        .listing {
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 40px;
            padding-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            transition: box-shadow 0.2s ease;
        }

        .listing:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .carousel-inner img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 6px;
        }

        .listing-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 10px;
            color: #222;
        }

        .listing-location {
            color: #777;
            font-size: 0.95rem;
        }

        .listing-buttons {
            margin-top: 15px;
        }

        .btn-sm-custom {
            padding: 6px 14px;
            font-size: 0.9rem;
        }

        .carousel-controls button {
            background: rgba(0, 0, 0, 0.3);
            border: none;
        }
    </style>
</head>
<body>

<?= view('navBar'); ?>

<div class="container mt-5">
    <h2 class="section-heading">Consultez notre catalogue </h2>
    <div class="row">
        <?php foreach ($maisons as $maison): ?>
            <div class="col-md-4 listing">
                <?php
                    $photos = json_decode($maison['photos'] ?? '[]', true);
                    $carouselId = 'carousel_' . uniqid();
                ?>

                <?php if (!empty($photos)): ?>
                    <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($photos as $index => $photo): ?>
                                <div class="carousel-item<?= $index === 0 ? ' active' : '' ?>">
                                    <img src="<?= base_url($photo) ?>" alt="Photo de <?= esc($maison['titre']) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="listing-title"><?= esc($maison['titre']) ?></div>
                <div class="listing-location"><?= esc($maison['village']) ?>, <?= esc($maison['pays']) ?></div>

                <p class="mt-2"><?= esc($maison['detail']) ?></p>

                <?php if (!empty($maison['attractions'])): ?>
                    <p><strong>Attractions :</strong> <?= esc($maison['attractions']) ?></p>
                <?php endif; ?>

                <div class="listing-buttons d-flex gap-2">
                    <a href="" class="btn btn-outline-secondary btn-sm-custom">Voir les disponibilités</a>
                    <a href="<?= base_url('reserveGuesthouse') ?>" class="btn btn-primary btn-sm-custom">Réserver</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= view('footer'); ?>

</body>
</html>