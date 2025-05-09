<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Maison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        /* Image Carousel */
        .carousel-item img {
            height: 550px;
            object-fit: cover;
            width: 100%;
            border-radius: 5px;
        }

        /* Section Titles */
        .section-title {
            font-size: 1.5rem;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-top: 30px;
            color: #000000;
        }

        .section-content {
            font-size: 1rem;
            color: #000000;
        }

        /* Card Container */
        .card {
            border: none;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        /* Card Body */
        .card-body {
            margin-top: 30px;
            background-color: #fff;
        }

        /* Button Styles */
        .btn-primary {
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: bold;
            border: none;
            text-transform: uppercase;
        }

        .text-center a {
            text-decoration: none;
        }

    </style>
</head>
<body>

    <?= view('navBar'); ?>

    <div class="container mt-5 mb-5">
        <!-- Title -->
        <h1 class="section-heading"><?= esc($maison['titre']) ?></h1>

        <div class="row">
            <!-- Colonne gauche : image -->
            <div class="col-md-6">
                <?php
                    $photos = !empty($maison['photos']) ? json_decode($maison['photos'], true) : [];
                    $carouselId = 'carousel_' . uniqid();
                ?>
                <?php if (!empty($photos)): ?>
                    <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($photos as $index => $photo): ?>
                                <div class="carousel-item<?= $index === 0 ? ' active' : '' ?>">
                                    <img src="<?= base_url($photo) ?>" alt="Photo de <?= esc($maison['titre']) ?>" class="d-block w-100">
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
                <?php else: ?>
                    <img src="https://via.placeholder.com/500" class="img-fluid rounded-3" alt="Image par défaut">
                <?php endif; ?>
            </div>

            <!-- Colonne droite : Détails de la maison -->
            <div class="col-md-6">
                <div>
                    <h3 class="section-title">Description</h3>
                    <p class="section-content"><?= esc($maison['detail']) ?></p>

                    <h3 class="section-title">Localisation</h3>
                    <p class="section-content"><strong>Village:</strong> <?= esc($maison['village']) ?></p>
                    <p class="section-content"><strong>Pays:</strong> <?= esc($maison['pays'] === 'BE' ? 'Belgique' : ($maison['pays'] === 'FR' ? 'France' : 'Italie')) ?></p>

                    <h3 class="section-title">Attractions</h3>
                    <p class="section-content"><?= esc($maison['attractions']) ?: 'Aucune attraction spécifiée.' ?></p>
                </div>

                <!-- Book Button -->
                <div class="text-center">
                    <a href="#" class="btn btn-primary">Réserver Maintenant</a>
                </div>
            </div>
        </div>

    </div>

    <?= view('footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>