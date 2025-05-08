<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des Indisponibilités</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .indispo-container {
            max-width: 900px;
            margin: auto;
            margin-top: 40px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?= view('navBar'); ?>

    <div class="indispo-container">
        <h1>Calendrier des Indisponibilités</h1>
        <h2>Indisponibilités pour la maison : <?= esc($titre) ?></h2>

        <?php if (!empty($indisponibilites)): ?>
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Motif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($indisponibilites as $indisponibilite): ?>
                        <tr>
                            <td><?= esc($indisponibilite['dateDebut']) ?></td>
                            <td><?= esc($indisponibilite['dateFin']) ?></td>
                            <td><?= esc($indisponibilite['motif']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">Aucune indisponibilité enregistrée pour cette maison.</p>
        <?php endif; ?>
    </div>

    <?= view('footer'); ?>

    <!-- Bootstrap JS (optionnel si tu n'utilises pas les composants JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>