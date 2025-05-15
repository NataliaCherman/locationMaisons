<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= view('navbar'); ?>

    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Maison</th>
            <th>Client</th>
            <th>Date Début</th>
            <th>Paiement prévu</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= esc($res['idReservation']) ?></td>
                <td><?= esc($res['idMaison']) ?></td>
                <td><?= esc($res['idUtilisateur']) ?></td>
                <td><?= esc($res['dateDebut']) ?></td>
                <td><?= esc($res['datePaiementPrévu']) ?></td>
                <td><?= esc($res['statut']) ?><?= $res['paiementEffectué'] ? ' ✅' : ' ❌' ?></td>
                <td>
                    <?php if (!$res['paiementEffectué']): ?>
                        <a href="<?= base_url("reservation/marquerPaiementEffectue/{$res['idReservation']}") ?>" class="btn btn-success btn-sm">Marquer payé</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('footer'); ?>
</body>
</html>