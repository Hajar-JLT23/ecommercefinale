<?php

session_start();


if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}


$nombre_articles = 0;
foreach ($_SESSION['panier'] as $quantite) {
    $nombre_articles += $quantite;
}


// Connexion à la base de données
$servername = "localhost";
$username = "root"; 
$password = "123ML@#jklhhh"; 
$dbname = "hacha_luxury";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connexion échouée: " . $conn->connect_error);
    }
    
    // pour récupérer  les produits depuis la base de données
    $sql = "SELECT * FROM produits ORDER BY id";
    $result = $conn->query($sql);
    $produits = [];

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $produits[] = $row;
        }
    }
} catch (Exception $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}


$message_newsletter = "";
if (isset($_POST['newsletter_submit']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    
   
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      
        $check_sql = "SELECT * FROM newsletter WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows == 0) {
        
            $insert_sql = "INSERT INTO newsletter (email) VALUES ('$email')";
            if ($conn->query($insert_sql) === TRUE) {
                $message_newsletter = '<div class="alert alert-success mt-3">Merci pour votre inscription à notre newsletter!</div>';
            } else {
                $message_newsletter = '<div class="alert alert-danger mt-3">Erreur: ' . $conn->error . '</div>';
            }
        } else {
            $message_newsletter = '<div class="alert alert-info mt-3">Vous êtes déjà inscrit à notre newsletter.</div>';
        }
    } else {
        $message_newsletter = '<div class="alert alert-danger mt-3">Veuillez entrer une adresse email valide.</div>';
    }
}


if (isset($_POST['ajouter_panier']) && isset($_POST['produit_id'])) {
    $produit_id = $_POST['produit_id'];
    $quantite = 1;
    
   
    if (isset($_SESSION['panier'][$produit_id])) {
        $_SESSION['panier'][$produit_id] += $quantite;
    } else {
        $_SESSION['panier'][$produit_id] = $quantite;
    }
    
    
    header("Location: index.php#produits");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HACHA LUXURY SCENT - Parfums d'Exception</title>
  
 
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
          scroll-behavior: smooth;
          background: linear-gradient(135deg, var(--primary), #0d1b2a);
          color: white;
      }

      h1, h2, h3, h4 {
          font-family: 'Playfair Display', serif;
          letter-spacing: 1px;
      }

      /* Animations - on  a  ajouté un délai pour que ça soit plus naturel */
      @keyframes fadeIn {
          from { 
              opacity: 0; 
              transform: translateY(20px); 
          }
          to { 
              opacity: 1; 
              transform: translateY(0); 
          }
      }

      .fade-in {
          animation: fadeIn 1s ease-out;
      }

    
      .navbar {
          background: rgba(10, 10, 10, 0.8) !important;
          backdrop-filter: blur(10px);
          box-shadow: 0 4px 30px rgba(0,0,0,0.3);
          border-bottom: 1px solid rgba(201, 176, 55, 0.3);
          transition: all 0.3s ease;
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
          background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                      url('https://images.unsplash.com/photo-1596203721435-99e556d3fbb2?ixlib=rb-4.0.3') no-repeat center center;
          background-size: cover;
          min-height: 90vh;
          display: flex;
          align-items: center;
          color: white;
          position: relative;
      }

     
      .hero::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');
          opacity: 0.1;
          z-index: 0;
      }

      .hero-content {
          position: relative;
          z-index: 1;
          text-align: center;
          opacity: 0;
          animation: fadeIn 1s ease-out forwards;
      }

      .hero h1 {
          font-size: 3.5rem;
          margin-bottom: 1.5rem;
          background: var(--gold-gradient);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
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

    
      .products {
          position: relative;
          padding: 100px 0;
      }

      
      .products::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-image: url('https://www.transparenttextures.com/patterns/moroccan-flower.png');
          opacity: 0.05;
          z-index: 0;
      }

      .products h2 {
          position: relative;
          font-size: 2.5rem;
          margin-bottom: 2rem;
          color: var(--secondary);
          display: inline-block;
      }

      .products h2::after {
          content: '';
          position: absolute;
          width: 80px;
          height: 3px;
          background: var(--gold-gradient);
          bottom: -10px;
          left: 50%;
          transform: translateX(-50%);
      }

      .product-card {
          border: none;
          background: rgba(27, 40, 69, 0.7);
          border-radius: 10px;
          overflow: hidden;
          transition: all 0.4s ease;
          margin-bottom: 2rem;
          height: 450px;
          position: relative;
          box-shadow: 0 15px 30px rgba(0,0,0,0.3);
          border: 1px solid rgba(201, 176, 55, 0.1);
      }

      .product-card:hover {
          transform: translateY(-10px);
          box-shadow: 0 20px 40px rgba(0,0,0,0.4);
          border-color: var(--secondary);
      }

      .product-card img {
          height: 300px;
          width: 100%;
          object-fit: cover;
          object-position: center;
          transition: transform 0.5s ease;
      }

      .product-card:hover img {
          transform: scale(1.05);
      }


      .product-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: -100%;
          width: 50%;
          height: 100%;
          background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 100%);
          transform: skewX(-25deg);
          transition: all 0.75s ease;
          z-index: 1;
      }

      .product-card:hover::before {
          left: 125%;
      }

      .card-body {
          padding: 1.5rem;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          background-color: rgba(27, 40, 69, 0.9) !important;
          color: white;
      }

      .card-title {
          color: var(--secondary);
          font-family: 'Playfair Display', serif;
      }

      .text-muted {
          color: #ddd !important;
      }

    
      .btn-primary {
          background: var(--gold-gradient);
          border: none;
          color: var(--dark-bg);
          font-weight: 600;
          transition: all 0.3s ease;
      }

      .btn-primary:hover {
          background: var(--gold-gradient);
          transform: translateY(-2px);
          box-shadow: 0 5px 15px rgba(201, 176, 55, 0.3);
      }

      .features {
          background: rgba(10, 10, 10, 0.8);
          position: relative;
          padding: 80px 0;
      }

      
      .features::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 3px;
          background: var(--gold-gradient);
      }

      .features::after {
          content: '';
          position: absolute;
          bottom: 0;
          left: 0;
          width: 100%;
          height: 3px;
          background: var(--gold-gradient);
      }

      .feature-icon {
          color: var(--secondary);
          transition: transform 0.3s ease;
          background: var(--gold-gradient);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
      }

      .features h3 {
          color: var(--secondary);
          margin: 15px 0;
      }

      .features p {
          color: #ddd;
      }

      .feature-icon:hover {
          transform: translateY(-5px);
      }

      /* Newsletter section */
      .newsletter {
          padding: 100px 0;
          position: relative;
      }

    
      .newsletter::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-image: url('https://www.transparenttextures.com/patterns/moroccan-flower.png');
          opacity: 0.05;
          z-index: 0;
      }

      .newsletter h3 {
          color: var(--secondary);
          font-size: 2rem;
          margin-bottom: 1rem;
      }

      .newsletter input {
          background: rgba(255, 255, 255, 0.1);
          border: 1px solid rgba(201, 176, 55, 0.3);
          color: white;
          padding: 12px 20px;
      }

      .newsletter input::placeholder {
          color: rgba(255, 255, 255, 0.7);
      }

      .newsletter input:focus {
          background: rgba(255, 255, 255, 0.15);
          border-color: var(--secondary);
          color: white;
          box-shadow: 0 0 0 0.25rem rgba(201, 176, 55, 0.25);
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

      footer h4 {
          color: var(--secondary);
          margin-bottom: 25px;
          font-size: 1.5rem;
      }

      footer p {
          color: #ddd;
      }

      footer a {
          color: #ddd;
          text-decoration: none;
          transition: all 0.3s ease;
      }

      footer a:hover {
          color: var(--accent);
          text-decoration: none;
      }

      /* Social Icons */
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

    
      @media (max-width: 768px) {
          .hero h1 {
              font-size: 2.5rem;
          }
          
          .product-card {
              height: auto;
          }
          
          .product-card img {
              height: 250px;
          }
      }
      
   
      @media not all and (min-resolution:.001dpcm) { 
          @supports (-webkit-appearance:none) {
              .hero h1, .feature-icon {
                  text-shadow: none;
              }
          }
      }

     
      .dropdown-menu {
          background: rgba(10, 10, 10, 0.9);
          backdrop-filter: blur(10px);
          border: 1px solid rgba(201, 176, 55, 0.3);
      }

      .dropdown-item {
          color: white;
          transition: all 0.3s ease;
      }

      .dropdown-item:hover {
          background: rgba(201, 176, 55, 0.2);
          color: var(--accent);
          transform: translateX(5px);
      }
      
      #voir-tous-parfums {
          display: inline-block;
          cursor: pointer;
          text-decoration: none;
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
                  <li class="nav-item">
                      <a class="nav-link" href="#accueil">Accueil</a>
                  </li>
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
                  <li class="nav-item">
                      <a class="nav-link" href="personnalisation.php">Personnalisation</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="apropos.php">À Propos</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#contact">Contact</a>
                  </li>
        
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


  <section class="hero" id="accueil">
      <div class="container hero-content">
          <h1 class="display-4 mb-4" data-aos="fade-up">Découvrez Votre Parfum Signature</h1>
          <p class="lead mb-4" data-aos="fade-up" data-aos-delay="200">Une collection de parfums d'exception inspirés des senteurs du Maroc et créés pour les amateurs de luxe</p>
          <div class="dropdown" data-aos="fade-up" data-aos-delay="400">
              <button class="btn btn-luxury btn-lg dropdown-toggle" type="button" id="collectionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  Découvrir la Collection
              </button>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="collectionDropdown">
                  <li><a class="dropdown-item" href="#produits" data-filter="all">Tous les parfums</a></li>
                  <li><a class="dropdown-item" href="#produits" data-filter="homme">Parfums Homme</a></li>
                  <li><a class="dropdown-item" href="#produits" data-filter="femme">Parfums Femme</a></li>
                  <li><a class="dropdown-item" href="#produits" data-filter="unisexe">Parfums Unisexe</a></li>
              </ul>
          </div>
      </div>
  </section>

  <section class="products py-5" id="produits">
      <div class="container">
          <h2 class="text-center mb-5" data-aos="fade-up">Nos Parfums De Luxe</h2>
          <div class="row">
              <?php
            
              if (!empty($produits)) {
                  
                  $produits_limite = array_slice($produits, 0, 14);
                  
                  foreach ($produits_limite as $produit) {
                      ?>
                      <div class="col-md-3 product-item" data-category="<?php echo $produit['genre']; ?>" data-aos="fade-up">
                          <div class="product-card">
                              <img src="<?php echo $produit['image']; ?>" class="card-img-top" alt="<?php echo $produit['nom']; ?>">
                              <div class="card-body text-center">
                                  <h5 class="card-title"><?php echo $produit['nom']; ?></h5>
                                  <p class="text-muted"><?php echo number_format($produit['prix'], 2); ?> €</p>
                                  <form method="post" action="index.php">
                                      <input type="hidden" name="produit_id" value="<?php echo $produit['id']; ?>">
                                      <button type="submit" name="ajouter_panier" class="btn btn-primary w-100">Ajouter au Panier</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                      <?php
                  }
              } else {
                  // Si aucun produit n'est trouvé dans la base de données, afficher un message//
                  echo '<div class="col-12 text-center"><p>Aucun produit disponible pour le moment.</p></div>';
              }
              ?>
          </div>
          <div class="text-center mt-4">
    <button class="btn btn-luxury btn-lg" id="voir-tous-parfums" onclick="window.location.href='produits.php';">Voir tous nos parfums</button>
</div>

      </div>
  </section>

  <section class="features py-5">
      <div class="container">
          <div class="row text-center">
              <div class="col-md-4" data-aos="fade-up">
                  <i class="fas fa-shipping-fast fa-3x mb-3 feature-icon"></i>
                  <h3>Livraison Gratuite</h3>
                  <p>Pour toute commande supérieure à 100 €</p>
              </div>
              <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                  <i class="fas fa-lock fa-3x mb-3 feature-icon"></i>
                  <h3>Paiement Sécurisé</h3>
                  <p>Transactions 100% sécurisées</p>
              </div>
              <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                  <i class="fas fa-gift fa-3x mb-3 feature-icon"></i>
                  <h3>Offres Spéciales</h3>
                  <p>Sur nos parfums premium</p>
              </div>
          </div>
      </div>
  </section>

  
  <section class="newsletter py-5">
      <div class="container text-center">
          <h3 data-aos="fade-up">Inscrivez-vous à Notre Newsletter</h3>
          <p class="mb-4" data-aos="fade-up" data-aos-delay="200">Recevez nos dernières collections et offres exclusives</p>
          <div class="row justify-content-center">
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <form class="d-flex gap-2" method="post" action="index.php#newsletter">
                      <input type="email" name="email" class="form-control" placeholder="Votre adresse email" required>
                      <button type="submit" name="newsletter_submit" class="btn btn-luxury">S'inscrire</button>
                  </form>
                  <?php echo $message_newsletter; ?>
              </div>
          </div>
      </div>
  </section>

  
  <footer class="bg-dark text-white py-5" id="contact">
      <div class="container">
          <div class="row">
              <div class="col-md-4">
                  <h4>À Propos</h4>
                  <p>Découvrez des parfums d'exception inspirés des senteurs marocaines qui définissent le luxe et l'élégance.</p>
                  <div class="social-links mt-4">
                      <a href="#"><i class="fab fa-facebook-f"></i></a>
                      <a href="#"><i class="fab fa-instagram"></i></a>
                      <a href="#"><i class="fab fa-twitter"></i></a>
                      <a href="#"><i class="fab fa-pinterest"></i></a>
                  </div>
              </div>
              <div class="col-md-4">
                  <h4>Liens Rapides</h4>
                  <ul class="list-unstyled footer-links">
                      <li><a href="#accueil">Accueil</a></li>
                      <li><a href="#produits">Produits</a></li>
                      <li><a href="apropos.php">À Propos</a></li>
                      <li><a href="#">Politique de Confidentialité</a></li>
                      <li><a href="#">Conditions Générales</a></li>
                  </ul>
              </div>
              <div class="col-md-4">
                  <h4>Contactez-nous</h4>
                  <ul class="list-unstyled footer-links">
                      <li><i class="fas fa-map-marker-alt me-2"></i> 27 Rue des Parfumeurs, Casablanca</li>
                      <li><i class="fas fa-phone me-2"></i> +212 522 123 456</li>
                      <li><i class="fas fa-envelope me-2"></i> contact@hachaluxury.com</li>
                  </ul>
              </div>
          </div>
          <hr class="mt-4">
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
   
      document.addEventListener('DOMContentLoaded', function() {
          
          setTimeout(function() {
              AOS.init({
                  duration: 800,
                  easing: 'ease-in-out',
                  once: true,
                  mirror: false
              });
          }, 100);
      });
      
   
      window.addEventListener('scroll', function() {
          const navbar = document.querySelector('.navbar');
          if (window.scrollY > 50) {
              navbar.style.padding = '0.5rem 1rem';
          } else {
              navbar.style.padding = '1rem';
          }
      });

    
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', function (e) {
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

    
      const scrollTopBtn = document.querySelector('.scroll-top');
      
      window.addEventListener('scroll', function() {
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
      
     
      function isInViewport(element) {
          const rect = element.getBoundingClientRect();
          return (
              rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
              rect.bottom >= 0
          );
      }
      
      const fadeElements = document.querySelectorAll('.fade-in');
      
      function checkFade() {
          fadeElements.forEach(element => {
              if (isInViewport(element)) {
                  element.classList.add('active');
              }
          });
      }
      
    
      window.addEventListener('load', checkFade);
      window.addEventListener('scroll', checkFade);

      
      document.addEventListener('DOMContentLoaded', function() {
          const voirTousBtn = document.getElementById('voir-tous-parfums');
          if (voirTousBtn) {
              voirTousBtn.addEventListener('click', function(e) {
                  window.location.href = 'produits.php';
              });
          }
      });
  </script>

  <script>
      
      document.addEventListener('DOMContentLoaded', function() {
          const filterLinks = document.querySelectorAll('[data-filter]');
          
          filterLinks.forEach(link => {
              link.addEventListener('click', function(e) {
                  e.preventDefault();
                  
                  const filterValue = this.getAttribute('data-filter');
                  const productItems = document.querySelectorAll('.product-item');
                  
                  productItems.forEach(item => {
                      if (filterValue === 'all') {
                          item.style.display = 'block';
                      } else {
                          if (item.getAttribute('data-category') === filterValue) {
                              item.style.display = 'block';
                          } else {
                              item.style.display = 'none';
                          }
                      }
                  });
                  
                  const productsSection = document.querySelector('#produits');
                  productsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
              });
          });
      });
  </script>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>

