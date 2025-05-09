<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Maison d'Hôte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
        .form-group label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .btn-primary {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 0.375rem;
        }
        .alert {
            margin-bottom: 20px;
        }
        .form-text {
            font-size: 0.9rem;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
        }
        .mb-3 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?= view('navbar'); ?>

<div class="container mt-5 mb-5">
    <h1 class="section-heading">Ajouter une Maison d'Hôte</h1>

    <!-- Affichage des messages de session (succès/erreur) -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout d'une maison d'hôte -->
    <form action="<?= site_url('/createGuesthouse') ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group mb-3">
            <label for="titre">Nom de la Maison d'Hôte :</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>

        <div class="form-group mb-3">
            <label for="detail">Description :</label>
            <textarea class="form-control" id="detail" name="detail" rows="4" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="village">Village :</label>
            <input type="text" class="form-control" id="village" name="village" required>
        </div>

        <div class="form-group mb-3">
            <label for="pays">Pays :</label>
            <select class="form-control" id="pays" name="pays" required>
                <option value="BE">Belgique</option>
                <option value="FR">France</option>
                <option value="IT">Italie</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="photos">Photos :</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple required>
            <small class="form-text text-muted">Sélectionnez plusieurs photos à télécharger (JPEG, PNG, etc.).</small>
        </div>

        <div class="form-group mb-3">
            <label for="attractions">Attractions à proximité :</label>
            <textarea class="form-control" id="attractions" name="attractions" rows="4"></textarea>
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">Ajouter la Maison d'Hôte</button>
        </div>
    </form>
</div>

<?= view('footer'); ?>
</body>
</html>