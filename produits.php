<?php
//demarrer la session pour gérer le panier//
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

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}


$genre_filter = isset($_GET['genre']) ? $_GET['genre'] : '';

$categorie_filter = isset($_GET['categorie']) ? $_GET['categorie'] : '';


$sort = isset($_GET['sort']) ? $_GET['sort'] : 'nom_asc';

$order_by = "nom ASC"; 
if ($sort == 'prix_asc') {
    $order_by = "prix ASC";
} elseif ($sort == 'prix_desc') {
    $order_by = "prix DESC";
} elseif ($sort == 'nom_desc') {
    $order_by = "nom DESC";
}


$sql = "SELECT p.*, c.nom as categorie_nom FROM produits p 
        LEFT JOIN categories c ON p.categorie_id = c.id 
        WHERE 1=1";

if (!empty($genre_filter)) {
    $sql .= " AND p.genre = '$genre_filter'";
}

if (!empty($categorie_filter)) {
    $sql .= " AND p.categorie_id = $categorie_filter";
}

$sql .= " ORDER BY $order_by";

$result = $conn->query($sql);
$produits = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $produits[] = $row;
    }
}

$sql_categories = "SELECT * FROM categories ORDER BY nom";
$result_categories = $conn->query($sql_categories);
$categories = [];

if ($result_categories->num_rows > 0) {
    while($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
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
    
 
    header("Location: produits.php" . (empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']));
    exit();
}

$page_title = "Tous nos parfums";
if (!empty($genre_filter)) {
    $page_title = "Parfums " . ucfirst($genre_filter);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?> - HACHA LUXURY SCENT</title>
  
 
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

      /* Animations - j'ai ajouté un délai pour que ça soit plus naturel */
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

    
      .page-header {
          background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                      url('https://images.unsplash.com/photo-1596203721435-99e556d3fbb2?ixlib=rb-4.0.3') no-repeat center center;
          background-size: cover;
          padding: 150px 0 80px;
          position: relative;
          text-align: center;
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
          margin-bottom: 1rem;
          background: var(--gold-gradient);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          display: inline-block;
      }

     
      .filters {
          background: rgba(10, 10, 10, 0.7);
          padding: 20px;
          border-radius: 10px;
          margin-bottom: 30px;
          border: 1px solid rgba(201, 176, 55, 0.2);
      }

      .filters label {
          color: var(--secondary);
          font-weight: 500;
      }

      .filters select {
          background: rgba(255, 255, 255, 0.1);
          border: 1px solid rgba(201, 176, 55, 0.3);
          color: white;
          padding: 8px 15px;
          border-radius: 5px;
      }

      .filters select:focus {
          background: rgba(255, 255, 255, 0.15);
          border-color: var(--secondary);
          color: white;
          box-shadow: 0 0 0 0.25rem rgba(201, 176, 55, 0.25);
      }

      .filters option {
          background-color: #1b2845;
          color: white;
      }


      .products {
          position: relative;
          padding: 50px 0;
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

      
      .genre-badge {
          position: absolute;
          top: 10px;
          right: 10px;
          padding: 5px 10px;
          border-radius: 20px;
          font-size: 0.8rem;
          font-weight: 600;
          z-index: 2;
      }

      .badge-homme {
          background: linear-gradient(135deg, #1a2a6c, #2a4858);
          color: white;
      }

      .badge-femme {
          background: linear-gradient(135deg, #b91372, #6b0f1a);
          color: white;
      }

      .badge-unisexe {
          background: linear-gradient(135deg, #8e2de2, #4a00e0);
          color: white;
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
          .page-header h1 {
              font-size: 2.5rem;
          }
          
          .product-card {
              height: auto;
          }
          
          .product-card img {
              height: 250px;
          }
          
          .filters .row > div {
              margin-bottom: 15px;
          }
      }
       
      @media not all and (min-resolution:.001dpcm) { 
          @supports (-webkit-appearance:none) {
              .page-header h1, .feature-icon {
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
      
      
      .pagination {
          margin-top: 30px;
      }
      
      .page-link {
          background: rgba(27, 40, 69, 0.7);
          color: var(--secondary);
          border: 1px solid rgba(201, 176, 55, 0.3);
          transition: all 0.3s ease;
      }
      
      .page-link:hover {
          background: rgba(201, 176, 55, 0.2);
          color: var(--accent);
          border-color: var(--secondary);
      }
      
      .page-item.active .page-link {
          background: var(--gold-gradient);
          border-color: var(--secondary);
          color: var(--dark-bg);
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
                      <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

 
  <header class="page-header">
      <div class="container">
          <h1 data-aos="fade-up"><?php echo $page_title; ?></h1>
      </div>
  </header>

  
  <section class="products py-5">
      <div class="container">
        
          <div class="filters" data-aos="fade-up">
              <form action="produits.php" method="get" id="filter-form">
                  <?php if (!empty($genre_filter)): ?>
                      <input type="hidden" name="genre" value="<?php echo $genre_filter; ?>">
                  <?php endif; ?>
                  
                  <div class="row align-items-end">
                      <?php if (empty($genre_filter)): ?>
                      <div class="col-md-3 mb-3">
                          <label for="genre" class="form-label">Genre</label>
                          <select class="form-select" id="genre" name="genre" onchange="this.form.submit()">
                              <option value="">Tous</option>
                              <option value="homme" <?php echo $genre_filter == 'homme' ? 'selected' : ''; ?>>Homme</option>
                              <option value="femme" <?php echo $genre_filter == 'femme' ? 'selected' : ''; ?>>Femme</option>
                              <option value="unisexe" <?php echo $genre_filter == 'unisexe' ? 'selected' : ''; ?>>Unisexe</option>
                          </select>
                      </div>
                      <?php endif; ?>
                      
                      <div class="col-md-3 mb-3">
                          <label for="categorie" class="form-label">Catégorie</label>
                          <select class="form-select" id="categorie" name="categorie" onchange="this.form.submit()">
                              <option value="">Toutes les catégories</option>
                              <?php foreach ($categories as $categorie): ?>
                                  <option value="<?php echo $categorie['id']; ?>" <?php echo $categorie_filter == $categorie['id'] ? 'selected' : ''; ?>>
                                      <?php echo $categorie['nom']; ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      
                      <div class="col-md-3 mb-3">
                          <label for="sort" class="form-label">Trier par</label>
                          <select class="form-select" id="sort" name="sort" onchange="this.form.submit()">
                              <option value="nom_asc" <?php echo $sort == 'nom_asc' ? 'selected' : ''; ?>>Nom (A-Z)</option>
                              <option value="nom_desc" <?php echo $sort == 'nom_desc' ? 'selected' : ''; ?>>Nom (Z-A)</option>
                              <option value="prix_asc" <?php echo $sort == 'prix_asc' ? 'selected' : ''; ?>>Prix (croissant)</option>
                              <option value="prix_desc" <?php echo $sort == 'prix_desc' ? 'selected' : ''; ?>>Prix (décroissant)</option>
                          </select>
                      </div>
                      
                      <div class="col-md-3 mb-3">
                          <a href="produits.php" class="btn btn-outline-light">Réinitialiser les filtres</a>
                      </div>
                  </div>
              </form>
          </div>
       
          <div class="row">
              <?php
              if (!empty($produits)) {
                  foreach ($produits as $produit) {
                      
                      $badge_class = '';
                      switch ($produit['genre']) {
                          case 'homme':
                              $badge_class = 'badge-homme';
                              break;
                          case 'femme':
                              $badge_class = 'badge-femme';
                              break;
                          case 'unisexe':
                              $badge_class = 'badge-unisexe';
                              break;
                      }
                      ?>
                      <div class="col-md-3 mb-4" data-aos="fade-up">
                          <div class="product-card">
                              <span class="genre-badge <?php echo $badge_class; ?>"><?php echo ucfirst($produit['genre']); ?></span>
                              <img src="<?php echo $produit['image']; ?>" class="card-img-top" alt="<?php echo $produit['nom']; ?>">
                              <div class="card-body text-center">
                                  <h5 class="card-title"><?php echo $produit['nom']; ?></h5>
                                  <p class="text-muted"><?php echo number_format($produit['prix'], 2); ?> €</p>
                                  <form method="post" action="produits.php<?php echo empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']; ?>">
                                      <input type="hidden" name="produit_id" value="<?php echo $produit['id']; ?>">
                                      <button type="submit" name="ajouter_panier" class="btn btn-primary w-100">Ajouter au Panier</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                      <?php
                  }
              } else {
                  
                  echo '<div class="col-12 text-center"><p>Aucun produit ne correspond à votre recherche.</p></div>';
              }
              ?>
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
  </script>

</body>
</html>

<?php
// Fermer la connexion à la base de données//
$conn->close();
?>

