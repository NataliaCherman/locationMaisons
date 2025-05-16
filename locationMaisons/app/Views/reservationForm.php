<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Réserver une maison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<?= view('navBar'); ?>

<div class="container mt-5">
    <h2 class="mb-4">Réserver la maison : <?= esc($maison['titre'] ?? 'N/A') ?></h2>

    <div id="alertMsg"></div>

    <form id="reservationForm">
        <input type="hidden" name="idMaison" value="<?= esc($maison['idGuesthouse']) ?>" />
        <input type="hidden" name="idUtilisateur" value="<?= session()->get('idUtilisateur') ?>" />

        <div class="mb-3">
            <label for="dateDebut" class="form-label">Date de début</label>
            <input type="date" class="form-control" id="dateDebut" name="dateDebut" required min="<?= date('Y-m-d') ?>" />
        </div>

        <div class="mb-3">
            <label for="dateFin" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="dateFin" name="dateFin" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>" />
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix total estimé (€)</label>
            <input type="text" class="form-control" id="prix" name="prix" value="0,00" readonly />
        </div>

        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>

<?= view('footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Fonction pour mettre à jour le prix automatiquement
    function majPrix() {
        let idMaison = $('input[name="idMaison"]').val();
        let dateDebut = $('#dateDebut').val();
        let dateFin = $('#dateFin').val();

        if (idMaison && dateDebut && dateFin && dateFin > dateDebut) {
            $.ajax({
                url: "<?= base_url('reservation/calculerPrix') ?>",
                method: "POST",
                data: { idMaison, dateDebut, dateFin },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#prix').val(response.prix);
                    } else {
                        $('#prix').val('Erreur');
                    }
                },
                error: function() {
                    $('#prix').val('Erreur');
                }
            });
        } else {
            $('#prix').val('0,00');
        }
    }

    // Mise à jour du prix à chaque changement de date
    $('#dateDebut, #dateFin').on('change', majPrix);

    // Gestion de la soumission du formulaire en AJAX
    $('#reservationForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('reservation/create') ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alertMsg').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' 
                        + response.message 
                        + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        + '</div>');
                    $('#reservationForm')[0].reset();
                    $('#prix').val('0,00');
                } else {
                    $('#alertMsg').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' 
                        + response.message 
                        + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        + '</div>');
                }
            },
            error: function(jqXHR) {
                let response = {};
                try {
                    response = JSON.parse(jqXHR.responseText);
                } catch(e) {
                    response.message = 'Erreur inconnue';
                }
                $('#alertMsg').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' 
                    + (response.message || 'Erreur serveur') 
                    + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                    + '</div>');
            }
        });
    });
});
</script>


</body>
</html>