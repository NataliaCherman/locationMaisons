<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maisons à louer</title>
    <link rel="stylesheet" href="<?= base_url('/public/assets/css/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .listing {
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 40px;
            padding-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            transition: box-shadow 0.2s ease;
        }

        .listing:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .carousel-inner img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 6px;
        }

        .listing-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 10px;
            color: #222;
        }

        .listing-location {
            color: #777;
            font-size: 0.95rem;
        }

        .listing-buttons {
            margin-top: 15px;
        }

        .btn-sm-custom {
            padding: 6px 14px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<?= view('navBar'); ?>

<div class="container mt-5">
    <h2 class="section-heading">Consultez notre catalogue</h2>

    <div class="mb-4">
        <label for="filter-pays" class="form-label">Filtrer par pays :</label>
        <select id="filter-pays" class="form-select w-auto mb-4">
            <option value="">Tous les pays</option>
            <option value="BE">Belgique</option>
            <option value="FR">France</option>
            <option value="IT">Italie</option>
        </select>
    </div>

    <div class="row" id="listing-container">
        <?= view('partials/guesthousesList', ['maisons' => $maisons]) ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#filter-pays').on('change', function () {
            var selectedCountry = $(this).val();

            $.ajax({
                url: '<?= base_url('/guesthouses/filter') ?>',
                method: 'GET',
                data: { pays: selectedCountry },
                success: function (response) {
                    $('#listing-container').html(response);
                },
                error: function () {
                    alert("Erreur lors du chargement des maisons.");
                }
            });
        });
    });
</script>

<?= view('footer'); ?>
</body>
</html>