<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace personnel</title>
    <style>
        .section-heading {
            font-size: 1.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #ddd;
            padding-top: 20px;
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>
<body>

<?= view('navBar'); ?>

<div class="container mt-5 mb-5">
    <h1 class="section-heading">Bienvenue <?= session()->get('prenom'); ?> <?= session()->get('nom'); ?> !</h1>

    <div class="row">
        <div class="col-md-4 text-center border-end">
           <div class="mt-4 w-100">
                <form action="userData" method="get">
                    <button type="submit" class="btn btn-primary w-100">Modifier son profil</button>
                </form>
            </div>
        </div>

        <!-- Colonne droite : informations -->
        <div class="col-md-8 ps-4">
            <h2>Vos maisons louées</h2>

            <?php if (!empty($maisons)): ?>
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
            <?php else: ?>
                <p>Aucune maison réservée pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= view('footer'); ?>

</body>
</html>