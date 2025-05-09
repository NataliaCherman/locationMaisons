<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Location de maisons de vacances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .about-us {
        padding: 120px 0;
        background-color: #f8f9fa;
    }

    .about-us .col-md-6 {
        padding: 30px;
    }


    .about-us .section-title {
        font-family: 'Roboto', sans-serif;
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    .about-us .lead {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 20px;
    }

    .about-us p {
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .about-us .row {
            flex-direction: column;
            text-align: center;
        }

        .about-us .col-md-6 {
            width: 100%;
        }
    }
    </style>
</head>
<body>

<?= view('navBar'); ?>

<div class="container-fluid p-0">
    <div class="position-relative text-white">
        <img src="<?php echo base_url('images/hero.jpg'); ?>" class="img-fluid w-100" style="height: 500px; object-fit: cover; filter: brightness(70%);" alt="Maison de vacances">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="fw-bold">Trouvez votre maison de vacances idéale</h1>
            <p class="lead">Explorez et réservez les meilleures maisons en Belgique, France et Italie.</p>
            <a href="<?= base_url('vitrineGuesthouses') ?>" class="btn btn-primary">Voir les maisons</a>
        </div>
    </div>
</div>

<section class="about-us">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6">
                <img src="<?php echo base_url('images/about.jpg'); ?>" alt="Maison en italie" class="img-fluid rounded">
            </div>

            <div class="col-md-6 section-title">
                <h2>À propos de nous</h2>
                <p class="lead">
                    Bienvenue sur notre plateforme de location de maisons !
                </p>
                <p>
                    Notre mission est simple : vous aider à trouver la maison idéale pour vos séjours en
                    France, Belgique ou Italie. Que vous rêviez d’une villa en bord de mer,
                    d’un chalet au cœur des Alpes ou d’une maison typique dans un charmant village, nous avons ce qu’il vous faut.
                </p>
                <p>
                    Nous rassemblons des hébergements uniques, soigneusement sélectionnés pour leur confort, leur authenticité
                    et leur emplacement. Que ce soit pour des vacances en famille, un week-end en amoureux ou une escapade
                    entre amis, vous trouverez ici des lieux où il fait bon vivre.
                <p>
                    Laissez-vous inspirer, explorez, réservez… et profitez pleinement de votre prochain séjour.
                </p>
                
            </div>
        </div>
    </div>
</section>


<?= view('footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>