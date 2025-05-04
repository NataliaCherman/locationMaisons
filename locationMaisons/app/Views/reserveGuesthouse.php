<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?= view('navbar'); ?>

<div class="container">
    <h1 class="my-4">Réservez votre maison de vacances en quelques clics seulement !</h1>

    <form action="<?= site_url('reserveGuesthouse/save'); ?>" method="POST">
        <div class="form-group">
            <label for="idUtilisateur">Utilisateur</label>
            <input type="hidden" id="user_id" name="user_id" value="<?= esc(session()->get('idUtilisateur')); ?>">
            <p class="form-control-plaintext">
                <?= esc(session()->get('nom')); ?> - <?= esc(session()->get('email')); ?>
            </p>
        </div>

        <div class="form-group">
            <label for="idGuesthouse">Maison</label>
            <select id="idGuesthouse" name="idGuesthouse" class="form-control" required>
                <option value="">Sélectionner une maison</option>
                <?php foreach ($maisons as $maison): ?>
                    <option value="<?= esc($maison['idGuesthouse']); ?>"><?= esc($maison['titre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="debut">Date de début</label>
            <input type="date" id="debut" name="debut" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fin">Date de fin</label>
            <input type="date" id="fin" name="fin" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select id="statut" name="statut" class="form-control" required>
                <option value="En attente">En attente</option>
                <option value="Confirmée">Confirmée</option>
                <option value="Annulée">Annulée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>

<?= view('footer')?>
</body>
</html>