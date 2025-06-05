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
$password = "";
$dbname = "hacha_luxury";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connexion échouée: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

$produits_commande = [];
$total_commande = 0;

if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $produit_id => $quantite) {
      
        $sql = "SELECT id, nom, prix, image FROM produits WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $produit = $result->fetch_assoc();
            $produit['quantite'] = $quantite;
            $produit['sous_total'] = $produit['prix'] * $quantite;
            $produits_commande[] = $produit;
            $total_commande += $produit['sous_total'];
        }
    }
}

if (empty($produits_commande)) {
    header("Location: panier.php");
    exit();
}

$numero_commande = "CMD-" . date("YmdHis") . "-" . rand(1000, 9999);
$date_commande = date("d/m/Y H:i");


$adresse_livraison = "15 Avenue des Champs-Élysées, 75008 Paris, France";
$delai_livraison = "3-5 jours ouvrables";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmation de Commande - HACHA LUXURY SCENT</title>
  
  
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

      /* Navbar */
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

      /* Page Header */
      .page-header {
          background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                      url('https://images.unsplash.com/photo-1596203721435-99e556d3fbb2?ixlib=rb-4.0.3') no-repeat center center;
          background-size: cover;
          padding: 150px 0 80px;
          position: relative;
      }

      .page-header::before {
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

      .page-header h1 {
          position: relative;
          z-index: 1;
          font-size: 3rem;
          background: var(--gold-gradient);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          text-shadow: 0 5px 15px rgba(0,0,0,0.5);
      }

     
      .confirmation-section {
          position: relative;
          padding: 80px 0;
      }

      .confirmation-section::before {
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

      .confirmation-card {
          background: rgba(27, 40, 69, 0.7);
          border-radius: 15px;
          overflow: hidden;
          box-shadow: 0 15px 30px rgba(0,0,0,0.3);
          border: 1px solid rgba(201, 176, 55, 0.3);
          position: relative;
          z-index: 1;
      }

      .confirmation-header {
          background: var(--gold-gradient);
          padding: 30px;
          text-align: center;
          color: var(--dark-bg);
      }

      .confirmation-header h2 {
          margin: 0;
          font-weight: 700;
      }

      .confirmation-body {
          padding: 40px;
      }

      .confirmation-icon {
          font-size: 5rem;
          color: #4BB543;
          margin-bottom: 20px;
      }

      .order-details {
          margin-top: 40px;
      }

      .order-details h3 {
          color: var(--secondary);
          margin-bottom: 20px;
          font-size: 1.5rem;
      }

      .detail-row {
          display: flex;
          justify-content: space-between;
          margin-bottom: 15px;
          padding-bottom: 15px;
          border-bottom: 1px solid rgba(255,255,255,0.1);
      }

      .detail-row:last-child {
          border-bottom: none;
      }

      .detail-label {
          font-weight: 600;
          color: var(--secondary);
      }

      .detail-value {
          text-align: right;
      }

      .product-list {
          margin: 30px 0;
      }

      .product-item {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 15px 0;
          border-bottom: 1px solid rgba(255,255,255,0.1);
      }

      .product-item:last-child {
          border-bottom: none;
      }

      .product-image {
          width: 60px;
          height: 60px;
          border-radius: 8px;
          overflow: hidden;
          margin-right: 15px;
      }

      .product-image img {
          width: 100%;
          height: 100%;
          object-fit: cover;
      }

      .product-info {
          flex: 1;
          display: flex;
          flex-direction: column;
      }

      .product-name {
          font-weight: 600;
          color: var(--secondary);
      }

      .product-meta {
          display: flex;
          justify-content: space-between;
          margin-top: 5px;
          font-size: 0.9rem;
          color: #ddd;
      }

      .product-price {
          text-align: right;
          font-weight: 600;
      }

      .total-row {
          display: flex;
          justify-content: space-between;
          margin-top: 20px;
          padding-top: 20px;
          border-top: 2px solid var(--secondary);
      }

      .total-label {
          font-weight: 700;
          font-size: 1.2rem;
          color: var(--secondary);
      }

      .total-value {
          font-weight: 700;
          font-size: 1.2rem;
      }

    
      .tracking-steps {
          margin: 40px 0;
          position: relative;
      }

      .tracking-line {
          position: absolute;
          top: 30px;
          left: 0;
          width: 100%;
          height: 3px;
          background: rgba(255,255,255,0.1);
          z-index: 0;
      }

      .tracking-progress {
          position: absolute;
          top: 30px;
          left: 0;
          width: 25%; /* Première étape complétée */
          height: 3px;
          background: var(--gold-gradient);
          z-index: 1;
      }

      .steps-container {
          display: flex;
          justify-content: space-between;
          position: relative;
          z-index: 2;
      }

      .step {
          text-align: center;
          width: 60px;
      }

      .step-icon {
          width: 60px;
          height: 60px;
          border-radius: 50%;
          background: rgba(27, 40, 69, 0.9);
          display: flex;
          align-items: center;
          justify-content: center;
          margin: 0 auto 10px;
          border: 2px solid rgba(255,255,255,0.1);
          font-size: 1.5rem;
      }

      .step.active .step-icon {
          background: var(--gold-gradient);
          color: var(--dark-bg);
          border-color: var(--secondary);
      }

      .step-label {
          font-size: 0.8rem;
          margin-top: 10px;
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

      .actions {
          margin-top: 40px;
          text-align: center;
      }

      .action-buttons {
          display: flex;
          justify-content: center;
          gap: 20px;
          flex-wrap: wrap;
      }

      .btn-outline-luxury {
          background: transparent;
          border: 2px solid var(--secondary);
          color: var(--secondary);
          font-weight: 600;
          padding: 12px 30px;
          border-radius: 50px;
          transition: all 0.3s ease;
      }

      .btn-outline-luxury:hover {
          background: var(--gold-gradient);
          color: var(--dark-bg);
          transform: translateY(-5px);
          box-shadow: 0 10px 20px rgba(201, 176, 55, 0.4);
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

      .info-box {
          background: rgba(201, 176, 55, 0.1);
          border-left: 4px solid var(--secondary);
          padding: 15px;
          margin: 20px 0;
          border-radius: 0 5px 5px 0;
      }

      .info-box i {
          color: var(--secondary);
          margin-right: 10px;
      }

      
      @media (max-width: 768px) {
          .page-header h1 {
              font-size: 2.5rem;
          }
          
          .confirmation-body {
              padding: 20px;
          }
          
          .product-item {
              flex-wrap: wrap;
              padding: 15px 0;
          }
          
          .product-image {
              margin-bottom: 10px;
          }
          
          .product-info {
              width: 100%;
              margin-bottom: 10px;
          }
          
          .product-meta {
              flex-direction: column;
              align-items: flex-start;
          }
          
          .product-price {
              margin-top: 10px;
          }

          .steps-container {
              flex-wrap: wrap;
              justify-content: center;
              gap: 20px;
          }

          .tracking-line, .tracking-progress {
              display: none;
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
    <li class="nav-item">
        <a class="nav-link" href="index.php">Accueil</a>
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
        <a class="nav-link" href="index.php#contact">Contact</a>
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

  
  <header class="page-header text-center">
      <div class="container">
          <h1 data-aos="fade-up">Confirmation de Commande</h1>
      </div>
  </header>


  <section class="confirmation-section">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-lg-8">
                  <div class="confirmation-card" data-aos="fade-up">
                      <div class="confirmation-header">
                          <h2>Merci pour votre commande !</h2>
                      </div>
                      <div class="confirmation-body text-center">
                          <div class="confirmation-icon">
                              <i class="fas fa-check-circle"></i>
                          </div>
                          <h3>Votre commande a été confirmée</h3>
                          <p>Un email de confirmation a été envoyé à votre adresse email avec tous les détails.</p>
                          
                          <div class="info-box">
                              <i class="fas fa-info-circle"></i>
                              Votre commande sera préparée avec soin et expédiée dans les plus brefs délais.
                          </div>
                          
                          <div class="tracking-steps">
                              <div class="tracking-line"></div>
                              <div class="tracking-progress"></div>
                              <div class="steps-container">
                                  <div class="step active">
                                      <div class="step-icon">
                                          <i class="fas fa-check"></i>
                                      </div>
                                      <div class="step-label">Commande confirmée</div>
                                  </div>
                                  <div class="step">
                                      <div class="step-icon">
                                          <i class="fas fa-box"></i>
                                      </div>
                                      <div class="step-label">En préparation</div>
                                  </div>
                                  <div class="step">
                                      <div class="step-icon">
                                          <i class="fas fa-shipping-fast"></i>
                                      </div>
                                      <div class="step-label">Expédiée</div>
                                  </div>
                                  <div class="step">
                                      <div class="step-icon">
                                          <i class="fas fa-home"></i>
                                      </div>
                                      <div class="step-label">Livrée</div>
                                  </div>
                              </div>
                          </div>
                          
                          <div class="order-details text-start">
                              <h3>Résumé de la commande</h3>
                              
                              <div class="detail-row">
                                  <div class="detail-label">Numéro de commande</div>
                                  <div class="detail-value"><?php echo $numero_commande; ?></div>
                              </div>
                              
                              <div class="detail-row">
                                  <div class="detail-label">Date</div>
                                  <div class="detail-value"><?php echo $date_commande; ?></div>
                              </div>
                              
                              <div class="detail-row">
                                  <div class="detail-label">Statut du paiement</div>
                                  <div class="detail-value"><span class="badge bg-success">Payé</span></div>
                              </div>
                              
                              <div class="detail-row">
                                  <div class="detail-label">Adresse de livraison</div>
                                  <div class="detail-value"><?php echo $adresse_livraison; ?></div>
                              </div>
                              
                              <div class="detail-row">
                                  <div class="detail-label">Délai de livraison estimé</div>
                                  <div class="detail-value"><?php echo $delai_livraison; ?></div>
                              </div>
                              
                              <h3 class="mt-5">Produits commandés</h3>
                              
                              <div class="product-list">
                                  <?php foreach ($produits_commande as $produit): ?>
                                  <div class="product-item">
                                      <div class="product-image">
                                          <img src="<?php echo $produit['image']; ?>" alt="<?php echo $produit['nom']; ?>">
                                      </div>
                                      <div class="product-info">
                                          <div class="product-name"><?php echo $produit['nom']; ?></div>
                                          <div class="product-meta">
                                              <span>Quantité: <?php echo $produit['quantite']; ?></span>
                                              <span><?php echo number_format($produit['prix'], 2); ?> € / unité</span>
                                          </div>
                                      </div>
                                      <div class="product-price"><?php echo number_format($produit['sous_total'], 2); ?> €</div>
                                  </div>
                                  <?php endforeach; ?>
                              </div>
                              
                              <div class="total-row">
                                  <div class="total-label">Total</div>
                                  <div class="total-value"><?php echo number_format($total_commande, 2); ?> €</div>
                              </div>
                          </div>
                          
                          <div class="actions">
                              <div class="action-buttons">
                                  <a href="index.php" class="btn btn-luxury">Retour à l'accueil</a>
                                  <a href="#" class="btn btn-outline-luxury">Suivre ma commande</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

 
  <footer class="bg-dark text-white py-5">
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
                      <li><a href="index.php">Accueil</a></li>
                      <li><a href="produits.php">Produits</a></li>
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

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
      // Initialisation des animations AOS//
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
  </script>

</body>
</html>

<?php
// Fermer la connexion à la base de données//
$conn->close();
?>

