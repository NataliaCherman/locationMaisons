<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace personnel</title>
</head>
<body>

<?= view('navBar'); ?>

<div class="container">
    <h1>Bienvenue <?= session()->get('prenom'); ?> <?= session()->get('nom'); ?> !</h1>
    <h2>Vos maisons louées</h2>

    <?php if (!empty($maisons)): ?>
        <table>
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

<?= view('footer'); ?>

</body>
</html>
