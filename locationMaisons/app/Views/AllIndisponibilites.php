<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Indisponibilités</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?= view('navbar', ['class' => 'fixed-top']); ?>

<div class="container">
    <h1 class="my-4">Toutes les Indisponibilités</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Maison</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Raison</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($indisponibilites as $indisponibilite): ?>
                <tr>
                    <td><?= esc($indisponibilite['idIndisponibilite']); ?></td>
                    <td><?= esc($indisponibilite['idGuesthouse']); ?></td>
                    <td><?= esc($indisponibilite['dateDebut']); ?></td>
                    <td><?= esc($indisponibilite['dateFin']); ?></td>
                    <td><?= esc($indisponibilite['raison']); ?></td>
                    <td>
                        <a href="<?= base_url('indisponibilites/edit/' . $indisponibilite['idIndisponibilite']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="<?= base_url('indisponibilites/delete/' . $indisponibilite['idIndisponibilite']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette indisponibilité ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

