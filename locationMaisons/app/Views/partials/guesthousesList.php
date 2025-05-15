<?php foreach ($maisons as $maison): ?>
    <?php if (isset($maison['titre']) && strtolower($maison['titre']) === 'anonyme') continue; ?>

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
            <a href="<?= base_url("/indisponibilite/{$maison['idGuesthouse']}") ?>" class="btn btn-outline-secondary btn-sm-custom">Voir les disponibilités</a>
            <a href="<?= base_url("reservation/maison/{$maison['idGuesthouse']}") ?>" class="btn btn-primary btn-sm-custom">Réserver</a>
            <a href="<?= base_url("/guesthouse/showDetails/{$maison['idGuesthouse']}") ?>" class="btn btn-info btn-sm-custom" target="_blank">Voir les détails</a>
        </div>
    </div>
<?php endforeach; ?>