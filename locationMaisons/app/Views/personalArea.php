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
        .blocked-message {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .blocked-content {
            opacity: 0.5;
            background-color: #f5f5f5;
        }
        .disabled-button {
            cursor: not-allowed;
            opacity: 0.6;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            width: 100%;
        }
        .btn-primary:disabled {
            background-color: #d6d6d6;
            border-color: #d6d6d6;
            color: #9c9c9c;
        }
        .card {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
                <?php if (!empty($user['photo'])): ?>
                        <img src="<?= base_url('/uploads/users/' . esc($user['photo'])) ?>" alt="Photo de profil" width="100" height="auto">
                    <?php else: ?>
                        <img src="<?= base_url('/uploads/users/defaut.PNG') ?>" alt="Photo de profil par défaut" width="100" height="auto">
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