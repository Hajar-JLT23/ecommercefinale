<?php
session_start();

if (!isset($_SESSION['panier'])) {
  $_SESSION['panier'] = [];
}

$nombre_articles = 0;
foreach ($_SESSION['panier'] as $quantite) {
  $nombre_articles += $quantite;
}

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "hacha_luxury";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

?>

<style>
    .team-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .team-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .team-img img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Pour s'assurer que toutes les colonnes aient la même hauteur */
    .row > [class*="col-"] {
        display: flex;
        flex-direction: column;
    }
</style>


<style>
    .team-img img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 10px; /* Optionnel */
    }
</style>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - HACHA LUXURY SCENT</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
    
        :root {
            --primary: #1b2845; 
            --secondary: #c9b037; 
            --accent: #ffd700; 
            --dark-bg: #0a0a0a; 
            --gold-gradient: linear-gradient(135deg, #bf953f, #fcf6ba, #b38728, #fbf5b7); 
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), #0d1b2a);
            color: white;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        .navbar {
            background: rgba(10, 10, 10, 0.8) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            border-bottom: 1px solid rgba(201, 176, 55, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--secondary) !important;
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
        }
        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: var(--gold-gradient);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--accent) !important;
            transform: translateY(-2px);
        }

    
        .hero {
            height: 80vh; 
            background: linear-gradient(rgba(10, 10, 10, 0.7), rgba(10, 10, 10, 0.7)), 
                        url('https://images.unsplash.com/photo-1596203721435-99e556d3fbb2?ixlib=rb-4.0.3') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-content {
            text-align: center;
            z-index: 1;
        }

        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: var(--gold-gradient);
            --webkit-background-clip: text;
            --webkit-text-fill-color: transparent;
            text-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        .hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

       
        .btn-luxury {
            background: var(--gold-gradient);
            border: none;
            color: var(--dark-bg);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(201, 176, 55, 0.3);
        }

        .btn-luxury:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(201, 176, 55, 0.4);
        }

   
        .about-section {
            padding: 100px 0;
        }

      
        .about-section h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .about-section h2::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 3px;
            background: var(--gold-gradient);
            bottom: -10px;
            left: 0;
        }

        .about-section h3 {
            color: var(--accent);
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .about-section p, .about-section ul {
            font-size: 1.1rem;
            line-height: 1.8;
        }

       
        .about-img {
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

     
        .about-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 100%);
            transform: skewX(-25deg);
            transition: all 0.75s ease;
        }

        .about-img:hover::before {
            left: 125%;
        }

        .about-img:hover {
            transform: scale(1.03);
        }

      
        .icon-box {
            background: rgba(27, 40, 69, 0.6);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: 1px solid rgba(201, 176, 55, 0.2);
        }

        .icon-box:hover {
            transform: translateY(-10px);
            background: rgba(27, 40, 69, 0.8);
            border-color: var(--secondary);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }


        .icon {
            color: var(--secondary);
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

      
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 0;
        }

      
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background: var(--gold-gradient);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            border-radius: 10px;
        }

      
        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }

        .timeline-item:nth-child(odd) {
            left: 0;
        }

        .timeline-item:nth-child(even) {
            left: 50%;
        }

        
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -13px;
            background: var(--gold-gradient);
            border-radius: 50%;
            top: 15px;
            z-index: 1;
        }

        .timeline-item:nth-child(even)::after {
            left: -12px;
        }

     
        .timeline-content {
            padding: 20px 30px;
            background: rgba(27, 40, 69, 0.6);
            border-radius: 10px;
            border: 1px solid rgba(201, 176, 55, 0.2);
            position: relative;
        }

        .timeline-content h3 {
            margin-top: 0;
        }

       
        .team-section {
            padding: 100px 0;
            background: linear-gradient(rgba(10, 10, 10, 0.8), rgba(10, 10, 10, 0.8)), 
                        url('https://images.unsplash.com/photo-1556228578-8c89e6adf883?ixlib=rb-4.0.3') no-repeat center center fixed;
            background-size: cover;
        }

        .team-card {
            background: rgba(27, 40, 69, 0.7);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            border: 1px solid rgba(201, 176, 55, 0.2);
            margin-bottom: 30px;
        }

        .team-card:hover {
            transform: translateY(-10px);
            border-color: var(--secondary);
        }

       
        .team-img {
            position: relative;
            overflow: hidden;
        }

        .team-img img {
            transition: all 0.5s ease;
        }

        .team-card:hover .team-img img {
            transform: scale(1.1);
        }

     
        .team-info {
            padding: 25px;
            text-align: center;
        }

        .team-info h4 {
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .team-info p {
            color: #ddd;
            margin-bottom: 15px;
        }

     
        .team-social a {
            color: white;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .team-social a:hover {
            color: var(--accent);
            transform: translateY(-3px);
        }

       
        .testimonial-section {
            padding: 100px 0;
        }

        
        .testimonial-card {
            background: rgba(27, 40, 69, 0.6);
            border-radius: 10px;
            padding: 30px;
            margin: 15px;
            position: relative;
            border: 1px solid rgba(201, 176, 55, 0.2);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            border-color: var(--secondary);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

     
        .testimonial-card::before {
            content: '\f10d';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 2rem;
            color: rgba(201, 176, 55, 0.2);
        }

      
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            padding-top: 20px;
        }

      
        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid var(--secondary);
        }

        .author-info h5 {
            margin-bottom: 5px;
            color: var(--secondary);
        }

     
        footer {
            background: var(--dark-bg);
            padding: 60px 0 30px;
            position: relative;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gold-gradient);
        }

        .footer-heading {
            color: var(--secondary);
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--accent);
            transform: translateX(5px);
        }

      
        .social-links {
            margin-top: 30px;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(201, 176, 55, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            color: var(--secondary);
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--gold-gradient);
            color: var(--dark-bg);
            transform: translateY(-5px);
        }

  
        .copyright {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

       
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .fade-up.active {
            opacity: 1;
            transform: translateY(0);
        }

       
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

     
        .gold-border {
            position: relative;
            padding: 3px;
            border-radius: 10px;
            background: var(--gold-gradient);
        }

        .gold-border-inner {
            background: rgba(27, 40, 69, 0.9);
            border-radius: 7px;
            padding: 30px;
            height: 100%;
        }

      
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--gold-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-bg);
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-5px);
        }
        
      
        .signature-section {
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .signature-bottle {
            position: relative;
            z-index: 2;
            transform: rotate(-5deg);
            transition: all 0.5s ease;
        }
        
        .signature-bottle:hover {
            transform: rotate(0deg) scale(1.05);
        }
        
        .signature-content {
            position: relative;
            z-index: 1;
        }
        
        .signature-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 50%, rgba(201, 176, 55, 0.1) 0%, transparent 70%);
            z-index: 0;
        }
        
        .ingredient-tag {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(201, 176, 55, 0.2);
            border-radius: 20px;
            margin: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .ingredient-tag:hover {
            background: var(--gold-gradient);
            color: var(--dark-bg);
            transform: translateY(-3px);
        }
        
   
        @media not all and (min-resolution:.001dpcm) { 
            @supports (-webkit-appearance:none) {
                .hero h1 {
                    text-shadow: none;
                }
            }
        }
        
      
        @media (max-width: 768px) {
            .timeline::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-item:nth-child(even) {
                left: 0;
            }
            
            .timeline-item:nth-child(odd)::after,
            .timeline-item:nth-child(even)::after {
                left: 18px;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
   
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">HACHA LUXURY SCENT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produits
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="produits.php?genre=homme">Parfums Homme</a></li>
                            <li><a class="dropdown-item" href="produits.php?genre=femme">Parfums Femme</a></li>
                            <li><a class="dropdown-item" href="produits.php?genre=unisexe">Parfums Unisexe</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="produits.php">Tous les Parfums</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="personnalisation.php">Personnalisation</a></li>
                    <li class="nav-item"><a class="nav-link active" href="apropos.php">À Propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger"><?php echo $nombre_articles; ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
  
    <section class="hero">
        <div class="container hero-content">
            <h1 data-aos="fade-up">Notre Histoire de Luxe</h1>
            <p data-aos="fade-up" data-aos-delay="200">Découvrez l'univers raffiné de HACHA LUXURY SCENT, où chaque parfum raconte une histoire d'élégance et de passion.</p>
            <a href="#notre-histoire" class="btn btn-luxury" data-aos="fade-up" data-aos-delay="400">Découvrir Notre Histoire</a>
        </div>
    </section>
    
    <section id="notre-histoire" class="about-section">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2>À Propos de HACHA LUXURY SCENT</h2>
                    <p>Fondée en 2024 par deux passionnées de parfumerie, HACHA LUXURY SCENT est née d'une vision commune : créer des parfums qui racontent une histoire et évoquent des émotions profondes. Notre marque incarne l'élégance et la sophistication à travers des créations olfactives uniques.</p>
                    <p>Chaque parfum est soigneusement élaboré dans notre atelier, en utilisant des ingrédients rares comme la rose de Damas, le bois de oud marocain et l'ambre gris. Notre quête d'excellence nous pousse à explorer sans cesse de nouvelles combinaisons pour offrir des expériences sensorielles inoubliables.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="gold-border">
                        <div class="gold-border-inner">
                            <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?ixlib=rb-4.0.3" alt="Parfums de luxe" class="img-fluid about-img">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="icon-box">
                        <i class="fas fa-gem icon"></i>
                        <h3>Notre Vision</h3>
                        <p>Devenir une référence dans l'univers des parfums de niche, en créant des fragrances qui transcendent les tendances éphémères pour devenir des classiques intemporels.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box">
                        <i class="fas fa-bullseye icon"></i>
                        <h3>Notre Mission</h3>
                        <p>Créer des parfums qui révèlent la personnalité unique de chaque personne, en utilisant des ingrédients nobles et des techniques artisanales transmises de génération en génération.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon-box">
                        <i class="fas fa-heart icon"></i>
                        <h3>Nos Valeurs</h3>
                        <p>Excellence dans la création, authenticité dans nos ingrédients, créativité sans limites et respect profond de l'environnement et des traditions parfumières.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="signature-section">
        <div class="signature-bg"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="signature-bottle">
                        <img src="mystre.jpg" alt="Notre parfum signature" class="img-fluid rounded-3">
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="signature-content">
                        <h2 class="mb-4">Notre Parfum Signature</h2>
                        <p>Le "Mystère de Marrakech" est notre création emblématique, inspirée par nos voyages au Maroc et la richesse de ses senteurs. Ce parfum complexe s'ouvre sur des notes fraîches d'agrumes et de menthe, avant de révéler un cœur floral de rose et de jasmin, pour finir sur un fond chaleureux de bois de oud, d'ambre et de musc.</p>
                        <p>Chaque flacon est numéroté à la main et contient une concentration exceptionnelle d'huiles essentielles pour une tenue longue durée.</p>
                        
                        <div class="mt-4">
                            <h5>Ingrédients principaux :</h5>
                            <div class="mt-3">
                                <span class="ingredient-tag">Rose de Damas</span>
                                <span class="ingredient-tag">Oud Marocain</span>
                                <span class="ingredient-tag">Ambre Gris</span>
                                <span class="ingredient-tag">Bergamote de Calabre</span>
                                <span class="ingredient-tag">Jasmin de Grasse</span>
                                <span class="ingredient-tag">Menthe Nanah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
  
    <section class="timeline-section parallax" style="background-image: linear-gradient(rgba(10, 10, 10, 0.8), rgba(10, 10, 10, 0.8)), url('https://images.unsplash.com/photo-1547887538-e3a2f32cb1cc?ixlib=rb-4.0.3');">
        <div class="container text-center mb-5">
            <h2 data-aos="fade-up" style="color: var(--secondary);">Notre Parcours</h2>
            <p data-aos="fade-up" data-aos-delay="200">Les étapes clés de notre aventure parfumée</p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item" data-aos="fade-right">
                <div class="timeline-content">
                    <h3>Janvier 2024</h3>
                    <p>Naissance de HACHA LUXURY SCENT après deux années de recherche et développement de nos premières fragrances. Notre vision commune prend vie.</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-left">
                <div class="timeline-content">
                    <h3>Mars 2024</h3>
                    <p>Lancement de notre première collection exclusive "Essences du Maroc", inspirée de nos racines et de la richesse des senteurs marocaines.</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-right">
                <div class="timeline-content">
                    <h3>Juin 2024</h3>
                    <p>Ouverture de notre premier espace de vente à Casablanca, un écrin de luxe où nos clients peuvent découvrir l'univers HACHA.</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-left">
                <div class="timeline-content">
                    <h3>2025</h3>
                    <p>Projets d'expansion vers Paris et Dubai, avec des collections exclusives pour chaque destination.</p>
                </div>
            </div>
        </div>
    </section>
    
   
    <section class="team-section">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up" style="color: var(--secondary);">Les Créatrices Passionnées</h2>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mx-auto" data-aos="fade-up">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3" alt="Fondatrice" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>Chaimae Ajam</h4>
                            <p>Fondatrice & Directrice Créative</p>
                            <p class="small">Passionnée de parfumerie depuis l'enfance, Chaimae a étudié l'art des senteurs à Grasse avant de créer HACHA.</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mx-auto" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="pexels-augustocarneirojr-30479362.jpg" alt="Maître Parfumeuse" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>Hajar Jelthi</h4>
                            <p>Maître Parfumeuse</p>
                            <p class="small">Avec sa créativité sans limites, Hajar compose des fragrances uniques qui captivent les sens.</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
 
    <section class="testimonial-section">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up" style="color: var(--secondary);">Ce Que Disent Nos Clients</h2>
            
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Le parfum 'Mystère de Marrakech' m'accompagne depuis sa sortie. Sa tenue est exceptionnelle et j'adore comment il évolue tout au long de la journée. Un vrai coup de cœur !"
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client">
                            <div class="author-info">
                                <h5>Leila M.</h5>
                                <p>Casablanca</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "J'ai offert Ambre Royal à mon épouse et elle l'adore. L'ambre est parfaitement dosé et la fragrance évolue magnifiquement tout au long de la journée."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client">
                            <div class="author-info">
                                <h5>Karim R.</h5>
                                <p>Rabat</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "En tant que collectionneuse de parfums, je peux affirmer que les créations de HACHA sont d'une qualité exceptionnelle. L'attention aux détails, du flacon à la fragrance, est remarquable."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Client">
                            <div class="author-info">
                                <h5>Yasmine T.</h5>
                                <p>Marrakech</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h4 class="footer-heading">HACHA LUXURY SCENT</h4>
                    <p>Découvrez l'art de la parfumerie de luxe à travers nos créations d'exception qui captivent les sens et évoquent des émotions profondes.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h4 class="footer-heading">Liens Rapides</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="produits.php">Produits</a></li>
                        <li><a href="personnalisation.php">Personnalisation</a></li>
                        <li><a href="apropos.php">À Propos</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-heading">Informations</h4>
                    <ul class="footer-links">
                        <li><a href="#">Politique de Confidentialité</a></li>
                        <li><a href="#">Conditions Générales</a></li>
                        <li><a href="#">Livraison & Retours</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-heading">Contact</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 27 Rue des Parfumeurs, Casablanca</li>
                        <li><i class="fas fa-phone me-2"></i> +212 522 123 456</li>
                        <li><i class="fas fa-envelope me-2"></i> contact@hachaluxury.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="text-center copyright">
                <p>&copy; 2024 HACHA LUXURY SCENT. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <div class="scroll-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
 
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    
    <script>
        // Initialisation des animations AOS
        document.addEventListener('DOMContentLoaded', function() {
            // J'ai eu un bug avec Safari qui n'affichait pas les animations correctement
            // Cette solution a fonctionné après plusieurs tests
            setTimeout(function() {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true,
                    mirror: false
                });
            }, 100);
        });
        
        // Bouton de retour en haut - apparaît après 300px de scroll
        const scrollTopBtn = document.querySelector('.scroll-top');
        
        window.addEventListener('scroll', function() {
            // Afficher le bouton après avoir scrollé un peu
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('active');
            } else {
                scrollTopBtn.classList.remove('active');
            }
            
    
        });
        
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
       
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
       
        if (window.innerWidth > 768) {
            window.addEventListener('scroll', function() {
                const parallaxElements = document.querySelectorAll('.parallax');
                
                parallaxElements.forEach(element => {
                    const scrollPosition = window.pageYOffset;
                    const elementPosition = element.offsetTop;
                    const distance = (scrollPosition - elementPosition) * 0.3;
                    
                    if (scrollPosition > elementPosition - window.innerHeight && 
                        scrollPosition < elementPosition + element.offsetHeight) {
                        element.style.backgroundPositionY = `calc(50% + ${distance}px)`;
                    }
                });
            });
        }
        
       
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.bottom >= 0
            );
        }
        
       
        const fadeElements = document.querySelectorAll('.fade-up');
        
        function checkFade() {
            fadeElements.forEach(element => {
                if (isInViewport(element)) {
                    element.classList.add('active');
                }
            });
        }
        
     
        window.addEventListener('load', checkFade);
        window.addEventListener('scroll', checkFade);
    </script>
</body>
</html>

<?php
// Fermer la connexion à la base de données//
    $conn->close();

?>
