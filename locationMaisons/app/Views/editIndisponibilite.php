<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Indisponibilité</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?= view('navbar'); ?>

<div class="container">
    <h1 class="my-4">Modifier une Indisponibilité</h1>

    <form action="<?= site_url('indisponibilites/update/' . $indisponibilite['id']); ?>" method="post">
        <div class="form-group">
            <label for="idGuesthouse">Maison :</label>
            <input type="text" name="idGuesthouse" id="idGuesthouse" class="form-control" value="<?= esc($indisponibilite['idGuesthouse']); ?>" required>
        </div>

        <div class="form-group">
            <label for="dateDebut">Date de début :</label>
            <input type="date" name="dateDebut" id="dateDebut" class="form-control" value="<?= esc($indisponibilite['dateDebut']); ?>" required>
        </div>

        <div class="form-group">
            <label for="dateFin">Date de fin :</label>
            <input type="date" name="dateFin" id="dateFin" class="form-control" value="<?= esc($indisponibilite['dateFin']); ?>" required>
        </div>

        <div class="form-group">
            <label for="raison">Raison :</label>
            <textarea name="raison" id="raison" class="form-control"><?= esc($indisponibilite['raison']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="<?= base_url('indisponibilites/all'); ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

</body>
</html>
