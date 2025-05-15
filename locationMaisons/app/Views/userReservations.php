<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach ($mes_reservations as $res): ?>
    <div class="card p-3 mb-3">
        <h5>Maison #<?= esc($res['idMaison']) ?> - <?= esc($res['dateDebut']) ?> à <?= esc($res['dateFin']) ?></h5>
        <p>Statut : <strong><?= esc($res['statut']) ?></strong></p>
        <?php if (!$res['paiementEffectué']): ?>
            <a href="<?= base_url("reservation/signalerPaiement/{$res['idReservation']}") ?>" class="btn btn-primary">J’ai effectué le paiement</a>
        <?php else: ?>
            <span class="badge bg-success">Paiement confirmé</span>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>