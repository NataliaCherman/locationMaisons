<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des maisons</title>

    <!-- Bootstrap & DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="bg-light">

<?= view('navBar'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Toutes les maisons disponibles sur la plateforme :</h2>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="mb-3 text-end">
        <a href="<?= base_url('/createGuesthouse') ?>" class="btn btn-primary btn-lg">
            Ajouter une Maison
        </a>
    </div>

    <div class="table-responsive">
        <table id="datatable" class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Village</th>
                    <th>Pays</th>
                    <th>Photo</th>
                    <th>Attractions</th>
                    <th>Modifier</th>
                    <th>Anonymiser</th>
                    <th>Indisponibilités</th> <!-- Nouvelle colonne pour l'indisponibilité -->
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<?= view('footer'); ?>

<script>
    const baseUrl = "<?= base_url('allGuesthouses') ?>/";

    $(document).ready(function () {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url('/getGuesthousesData') ?>",
                type: "POST",
                data: function(d) {
                    d.search.value = $('input[type="search"]').val();
                }
            },
            columns: [
                { data: "idGuesthouse" },
                { data: "titre" },
                { data: "detail" },
                { data: "village" },
                { data: "pays" },
                {
                    data: "photos",
                    render: function(data) {
                        if (data) {
                            return `<img src="<?= base_url() ?>/${data}" class="img-thumbnail" width="100">`;
                        } else {
                            return '<span class="text-muted">Pas d\'image</span>';
                        }
                    }
                },
                { data: "attractions" },
                {
                    data: "idGuesthouse",
                    render: function(data) {
                        return `<a href="${baseUrl}edit/${data}" class="btn btn-warning btn-sm">Modifier</a>`;
                    }
                },
                {
                    data: "idGuesthouse",
                    render: function(data) {
                        return `<a href="${baseUrl}anonymize/${data}" class="btn btn-danger btn-sm">Anonymiser</a>`;
                    }
                },
                {
                    data: "idGuesthouse",
                    render: function(data) {
                        return `<a href="<?= base_url('indisponibilite') ?>/${data}/create" class="btn btn-info btn-sm">Gérer les indisponibilités</a>`;
                    }
                }
            ]
        });
    });
</script>

</body>
</html>