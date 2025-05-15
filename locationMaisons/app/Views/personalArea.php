<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace personnel</title>
    <link rel="stylesheet" href="<?= base_url('/public/assets/css/style.css') ?>">
</head>
<body>

<?= view('navBar'); ?>

<div class="container mt-5 mb-5">
    <h1 class="section-heading">Bienvenue <?= session()->get('prenom'); ?> <?= session()->get('nom'); ?> !</h1>

    <div class="row">
        <div class="col-md-4 text-center border-end">
            <div class="mt-4 w-100">
               <?php if (!empty($user['photo'])): ?>
                            <img src="<?= base_url($user['photo']) ?>" alt="Photo de profil" width="100">
                        <?php else: ?>
                            <img src="<?= base_url('uploads/users/defaut.png') ?>" alt="Photo par défaut" width="100">
                        <?php endif; ?>
                <form action="userData" method="get">
                    <button type="submit" class="btn btn-primary w-100">
                        Modifier son profil
                    </button>
                </form>
            </div>
        </div>

        <!-- Colonne droite : informations -->
        <div class="col-md-8 ps-4">
            <h2>Vos maisons louées</h2>

            <?php if (!empty($maisons)): ?>
                <div class="card">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom de la maison</th>
                                <th>Adresse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($maisons as $maison): ?>
                                <tr>
                                    <td><?= esc($maison['titre']); ?></td>
                                    <td><?= esc($maison['village']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Aucune maison réservée pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= view('footer'); ?>

</body>
</html>