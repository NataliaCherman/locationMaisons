<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Indisponibilité</title>

    <script>
        // Fonction pour mettre à jour la date minimale
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0]; // Obtenir la date d'aujourd'hui au format YYYY-MM-DD
            document.getElementById('dateDebut').setAttribute('min', today);
        });
    </script>
</head>
<body>
    <?= view('navBar'); ?>

    <div class="container mt-5">
        <h2>Créer une Indisponibilité pour la Maison : <?= esc($guesthouse['titre']) ?></h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('indisponibilite/store') ?>" method="post" class="container mt-4">
            <input type="hidden" name="idMaison" value="<?= esc($idMaison) ?>">

            <div class="mb-3">
                <label for="motif" class="form-label">Motif</label>
                <input type="text" class="form-control" id="motif" name="motif" required>
            </div>

            <div class="mb-3">
                <label for="dateDebut" class="form-label">Date de début</label>
                <input type="date" class="form-control" id="dateDebut" name="dateDebut" required>
            </div>

            <div class="mb-3">
                <label for="dateFin" class="form-label">Date de fin</label>
                <input type="date" class="form-control" id="dateFin" name="dateFin" required>
            </div>

            <button type="submit" class="btn btn-success">Créer l'indisponibilité</button>
        </form>

        <!-- Liste des indisponibilités existantes -->
        <?php if (!empty($indisponibilites)): ?>
            <h3 class="mt-5">Indisponibilités existantes :</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Motif</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($indisponibilites as $indisponibilite): ?>
                        <tr>
                            <td><?= esc($indisponibilite['motif']) ?></td>
                            <td><?= esc($indisponibilite['dateDebut']) ?></td>
                            <td><?= esc($indisponibilite['dateFin']) ?></td>
                            <td>
                                <!-- Bouton de suppression -->
                                <form action="<?= base_url('indisponibilite/delete/' . esc($indisponibilite['idIndisponibilite'])) ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette indisponibilité ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">Aucune indisponibilité pour cette maison.</p>
        <?php endif; ?>
    </div>

    <?= view('footer'); ?>
</body>
</html>