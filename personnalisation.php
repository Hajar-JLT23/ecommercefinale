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

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}
if (isset($_POST['ajouter_personnalise'])) {
    $nom_parfum = $_POST['nom_parfum'];
    $notes = $_POST['notes']; 
    $prix = $_POST['prix'];
   
    //  ajouter un produit spécial au panier
    $_SESSION['parfum_personnalise'] = [
        'nom' => $nom_parfum,
        'notes' => $notes,
        'prix' => $prix
    ];
    
    header("Location: panier.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personnalisation de Parfum - HACHA LUXURY SCENT</title>
  
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
          
          /* Couleurs pour les notes de parfum */
          --note-floral: #e0a2c5;
          --note-boise: #8b5a2b;
          --note-epice: #d35400;
          --note-agrume: #f39c12;
          --note-oriental: #8e44ad;
          --note-frais: #3498db;
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
          min-height: 50vh;
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

     
      .customization-section {
          padding: 100px 0;
          position: relative;
      }

   
      .customization-section::before {
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

      .customization-section h2 {
          position: relative;
          font-size: 2.5rem;
          margin-bottom: 2rem;
          color: var(--secondary);
          display: inline-block;
      }

      .customization-section h2::after {
          content: '';
          position: absolute;
          width: 80px;
          height: 3px;
          background: var(--gold-gradient);
          bottom: -10px;
          left: 50%;
          transform: translateX(-50%);
      }

      
      .bottle-container {
          position: relative;
          height: 400px;
          display: flex;
          justify-content: center;
          align-items: center;
          margin-bottom: 50px;
      }

     
      .perfume-bottle {
          position: relative;
          width: 120px;
          height: 300px;
          background: rgba(255, 255, 255, 0.1);
          border-radius: 60px 60px 30px 30px;
          overflow: hidden;
          box-shadow: 0 10px 30px rgba(0,0,0,0.3);
          border: 1px solid rgba(255, 255, 255, 0.2);
          transition: all 0.5s ease;
      }

      .bottle-neck {
          position: absolute;
          top: -20px;
          left: 50%;
          transform: translateX(-50%);
          width: 40px;
          height: 40px;
          background: rgba(255, 255, 255, 0.2);
          border-radius: 20px 20px 0 0;
          border: 1px solid rgba(255, 255, 255, 0.2);
      }

      .bottle-cap {
          position: absolute;
          top: -50px;
          left: 50%;
          transform: translateX(-50%);
          width: 50px;
          height: 30px;
          background: var(--gold-gradient);
          border-radius: 10px 10px 0 0;
          box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }

      .bottle-content {
          position: absolute;
          bottom: 0;
          left: 0;
          width: 100%;
          height: 0%;
          background: linear-gradient(to bottom, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
          transition: height 1s ease, background 1s ease;
      }

      
      .perfume-bottle::before {
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

      .perfume-bottle:hover::before {
          left: 125%;
      }

    
      .bottle-reflection {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%);
          pointer-events: none;
      }

     
      .notes-container {
          margin-top: 50px;
      }

      .note-category {
          margin-bottom: 30px;
      }

      .note-category h3 {
          color: var(--secondary);
          margin-bottom: 20px;
          font-size: 1.8rem;
      }

      .notes-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
          gap: 15px;
      }

      .note-item {
          background: rgba(27, 40, 69, 0.7);
          border-radius: 10px;
          padding: 15px;
          text-align: center;
          cursor: pointer;
          transition: all 0.3s ease;
          border: 1px solid rgba(201, 176, 55, 0.1);
          position: relative;
          overflow: hidden;
      }

      .note-item:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 20px rgba(0,0,0,0.2);
          border-color: var(--secondary);
      }

      .note-item.selected {
          border: 2px solid var(--secondary);
          box-shadow: 0 0 15px rgba(201, 176, 55, 0.5);
      }

      .note-item img {
          width: 50px;
          height: 50px;
          object-fit: cover;
          border-radius: 50%;
          margin-bottom: 10px;
          border: 2px solid rgba(201, 176, 55, 0.3);
      }

      .note-item h4 {
          font-size: 1rem;
          margin-bottom: 5px;
          color: white;
      }

      .note-item p {
          font-size: 0.8rem;
          color: #ddd;
          margin-bottom: 0;
      }

      .note-percentage {
          position: absolute;
          top: 5px;
          right: 5px;
          background: var(--gold-gradient);
          color: var(--dark-bg);
          font-weight: bold;
          width: 25px;
          height: 25px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 0.7rem;
          opacity: 0;
          transition: opacity 0.3s ease;
      }

      .note-item.selected .note-percentage {
          opacity: 1;
      }

      
      .creation-summary {
          background: rgba(27, 40, 69, 0.7);
          border-radius: 15px;
          padding: 30px;
          margin-top: 50px;
          border: 1px solid rgba(201, 176, 55, 0.2);
          box-shadow: 0 15px 30px rgba(0,0,0,0.3);
      }

      .creation-summary h3 {
          color: var(--secondary);
          margin-bottom: 20px;
          font-size: 1.8rem;
      }

      .summary-list {
          margin-bottom: 20px;
      }

      .summary-item {
          display: flex;
          justify-content: space-between;
          margin-bottom: 10px;
          padding-bottom: 10px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .summary-item:last-child {
          border-bottom: none;
      }

      .summary-name {
          color: white;
          font-weight: 500;
      }

      .summary-percentage {
          color: var(--secondary);
          font-weight: 600;
      }

      .creation-name {
          margin-top: 30px;
      }

      .creation-name label {
          display: block;
          margin-bottom: 10px;
          color: var(--secondary);
          font-weight: 500;
      }

      .creation-name input {
          width: 100%;
          padding: 12px 15px;
          background: rgba(255, 255, 255, 0.1);
          border: 1px solid rgba(201, 176, 55, 0.3);
          border-radius: 5px;
          color: white;
          margin-bottom: 20px;
      }

      .creation-name input:focus {
          outline: none;
          border-color: var(--secondary);
          box-shadow: 0 0 10px rgba(201, 176, 55, 0.3);
      }

      .creation-name input::placeholder {
          color: rgba(255, 255, 255, 0.5);
      }

      .total-price {
          font-size: 1.5rem;
          color: var(--secondary);
          margin: 20px 0;
          text-align: right;
          font-weight: 600;
      }

      .checkout-btn {
          width: 100%;
          padding: 15px;
          font-size: 1.1rem;
      }

      /* Animations */
      @keyframes bottleFill {
          0% { height: 0%; }
          100% { height: var(--fill-height); }
      }

      @keyframes bottleGlow {
          0% { box-shadow: 0 0 10px rgba(201, 176, 55, 0.3); }
          50% { box-shadow: 0 0 30px rgba(201, 176, 55, 0.5); }
          100% { box-shadow: 0 0 10px rgba(201, 176, 55, 0.3); }
      }

      .bottle-glow {
          animation: bottleGlow 2s infinite;
      }

   
      .tooltip-custom {
          position: absolute;
          background: rgba(10, 10, 10, 0.9);
          color: white;
          padding: 10px 15px;
          border-radius: 5px;
          font-size: 0.9rem;
          z-index: 100;
          opacity: 0;
          transition: opacity 0.3s ease;
          pointer-events: none;
          box-shadow: 0 5px 15px rgba(0,0,0,0.3);
          border: 1px solid rgba(201, 176, 55, 0.3);
          max-width: 250px;
      }

      .tooltip-custom::after {
          content: '';
          position: absolute;
          top: 100%;
          left: 50%;
          margin-left: -5px;
          border-width: 5px;
          border-style: solid;
          border-color: rgba(10, 10, 10, 0.9) transparent transparent transparent;
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

      @media (max-width: 768px) {
          .hero h1 {
              font-size: 2.5rem;
          }
          
          .notes-grid {
              grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
          }
          
          .bottle-container {
              height: 350px;
          }
          
          .perfume-bottle {
              width: 100px;
              height: 250px;
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
                      <a class="nav-link active" href="personnalisation.php">Personnalisation</a>
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

<section class="hero">
    <div class="container hero-content">
        <h1 class="display-4 mb-4" data-aos="fade-up">Créez Votre Parfum Unique</h1>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="200">Composez une fragrance personnalisée avec nos notes marocaines d'exception et révélez votre signature olfactive</p>
    </div>
</section>

<section class="customization-section">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Personnalisez Votre Fragrance</h2>
        
       
        <div class="bottle-container" data-aos="fade-up">
            <div class="perfume-bottle">
                <div class="bottle-neck"></div>
                <div class="bottle-cap"></div>
                <div class="bottle-content" id="bottleContent"></div>
                <div class="bottle-reflection"></div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8" data-aos="fade-up">
             
                <div class="notes-container">
                  
                    <div class="note-category">
                        <h3>Notes de Tête</h3>
                        <p>Les premières impressions de votre parfum, fraîches et vives.</p>
                        <div class="notes-grid">
                            <div class="note-item" data-category="tete" data-name="Bergamote" data-color="#f39c12" data-description="Agrume frais et pétillant, apporte une fraîcheur immédiate">
                                <div class="note-percentage">0%</div>
                                <img src="agrume.jpeg" alt="Bergamote">
                                <h4>Bergamote</h4>
                                <p>Agrume frais</p>
                            </div>
                            <div class="note-item" data-category="tete" data-name="Menthe Nanah" data-color="#3498db" data-description="Menthe marocaine rafraîchissante avec des notes herbacées et vivifiantes">
                                <div class="note-percentage">0%</div>
                                <img src="menth.jpeg" alt="Menthe Nanah">
                                <h4>Menthe Nanah</h4>
                                <p>Fraîche et vive</p>
                            </div>
                            <div class="note-item" data-category="tete" data-name="Néroli" data-color="#f1c40f" data-description="Huile essentielle de fleur d'oranger amère, délicate et légèrement épicée">
                                <div class="note-percentage">0%</div>
                                <img src="floral.jpeg" alt="Néroli">
                                <h4>Néroli</h4>
                                <p>Floral délicat</p>
                            </div>
                            <div class="note-item" data-category="tete" data-name="Citron de l'Atlas" data-color="#f9ca24" data-description="Agrume cultivé dans les montagnes de l'Atlas, vif et ensoleillé">
                                <div class="note-percentage">0%</div>
                                <img src="https://images.unsplash.com/photo-1590502593747-42a996133562?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Citron de l'Atlas">
                                <h4>Citron de l'Atlas</h4>
                                <p>Zesté et vif</p>
                            </div>
                        </div>
                    </div>
                 
                    <div class="note-category">
                        <h3>Notes de Cœur</h3>
                        <p>L'âme de votre parfum, florales et épicées.</p>
                        <div class="notes-grid">
                            <div class="note-item" data-category="coeur" data-name="Rose de Damas" data-color="#e84393" data-description="Rose cultivée au Maroc, riche et veloutée avec des facettes miellées">
                                <div class="note-percentage">0%</div>
                                <img src="rose de damas .jpeg" alt="Rose de Damas">
                                <h4>Rose de Damas</h4>
                                <p>Florale veloutée</p>
                            </div>
                            <div class="note-item" data-category="coeur" data-name="Jasmin Sambac" data-color="#dff9fb" data-description="Fleur blanche exotique aux notes sensuelles et envoûtantes">
                                <div class="note-percentage">0%</div>
                                <img src="jasmin.jpeg" alt="Jasmin Sambac">
                                <h4>Jasmin Sambac</h4>
                                <p>Floral exotique</p>
                            </div>
                            <div class="note-item" data-category="coeur" data-name="Safran" data-color="#e67e22" data-description="Épice précieuse du Maroc aux notes chaudes et légèrement métalliques">
                                <div class="note-percentage">0%</div>
                                <img src="saafarn .jpeg" alt="Safran">
                                <h4>Safran</h4>
                                <p>Épicé et chaud</p>
                            </div>
                            <div class="note-item" data-category="coeur" data-name="Fleur d'Oranger" data-color="#ffeaa7" data-description="Fleur emblématique du Maroc, douce et légèrement miellée">
                                <div class="note-percentage">0%</div>
                                <img src="fleur doranger .jpeg" alt="Fleur d'Oranger">
                                <h4>Fleur d'Oranger</h4>
                                <p>Douce et miellée</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="note-category">
                        <h3>Notes de Fond</h3>
                        <p>La signature durable de votre parfum, boisée et ambrée.</p>
                        
                        <div class="notes-grid">
                            <div class="note-item" data-category="fond" data-name="Oud Marocain" data-color="#8b5a2b" data-description="Bois précieux aux notes chaudes, boisées et légèrement animales">
                                <div class="note-percentage">0%</div>
                                <img src="aoud.jpeg" alt="Oud Marocain">
                                <h4>Oud Marocain</h4>
                                <p>Boisé précieux</p>
                            </div>
                            <div class="note-item" data-category="fond" data-name="Ambre Gris" data-color="#cd6133" data-description="Note ambrée rare et précieuse, chaude et sensuelle">
                                <div class="note-percentage">0%</div>
                                <img src="ambre.jpeg" alt="Ambre Gris">
                                <h4>Ambre Gris</h4>
                                <p>Ambré et sensuel</p>
                            </div>
                            <div class="note-item" data-category="fond" data-name="Cèdre de l'Atlas" data-color="#795548" data-description="Bois marocain noble aux notes sèches et boisées">
                                <div class="note-percentage">0%</div>
                                <img src="cedre.jpeg" alt="Cèdre de l'Atlas">
                                <h4>Cèdre de l'Atlas</h4>
                                <p>Boisé et sec</p>
                            </div>
                            <div class="note-item" data-category="fond" data-name="Musc Blanc" data-color="#dcdde1" data-description="Note douce et enveloppante, apporte de la sensualité et de la durabilité">
                                <div class="note-percentage">0%</div>
                                <img src="muuuuusc .jpeg" alt="Musc Blanc">
                                
</cut_off_point>
                                <h4>Musc Blanc</h4>
                                <p>Doux et sensuel</p>
                            </div>
                            <div class="note-item" data-category="fond" data-name="Vanille de Madagascar" data-color="#f5cd79" data-description="Note gourmande et réconfortante, apporte de la douceur et de la chaleur">
                                <div class="note-percentage">0%</div>
                                <img src="vanille.jpeg" alt="Vanille de Madagascar">
                                <h4>Vanille</h4>
                                <p>Douce et gourmande</p>
                            </div>
                            <div class="note-item" data-category="fond" data-name="Benjoin" data-color="#e58e26" data-description="Résine orientale aux notes vanillées et balsamiques">
                                <div class="note-percentage">0%</div>
                                <img src="benjoin .jpeg" alt="Benjoin">
                                <h4>Benjoin</h4>
                                <p>Balsamique et doux</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                
                <div class="creation-summary">
                    <h3>Votre Création</h3>
                    <div id="summaryList" class="summary-list">
                        <p class="text-center text-muted">Sélectionnez des notes pour composer votre parfum</p>
                    </div>
                    
                    <form method="post" action="personnalisation.php" id="parfumForm">
                        <div class="creation-name">
                            <label for="perfumeName">Nommez votre création</label>
                            <input type="text" id="perfumeName" name="nom_parfum" placeholder="Ex: Mon Rêve Marocain" class="form-control" required>
                            <input type="hidden" id="selectedNotes" name="notes" value="">
                            <input type="hidden" id="parfumPrice" name="prix" value="150.00">
                        </div>
                        
                        <div class="total-price">
                            Prix: <span id="totalPrice">150.00 €</span>
                        </div>
                        
                        <button type="submit" id="checkoutBtn" name="ajouter_personnalise" class="btn btn-luxury checkout-btn" disabled>
                            Ajouter au panier
                        </button>
                    </form>
                </div>
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
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="produits.php">Produits</a></li>
                    <li><a href="personnalisation.php">Personnalisation</a></li>
                    <li><a href="apropos.php">À Propos</a></li>
                    <li><a href="#">Politique de Confidentialité</a></li>
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


<div class="tooltip-custom" id="tooltip"></div>


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
        
       
        initCustomization();
    });
    
    function initCustomization() {
        const noteItems = document.querySelectorAll('.note-item');
        const bottleContent = document.getElementById('bottleContent');
        const summaryList = document.getElementById('summaryList');
        const totalPrice = document.getElementById('totalPrice');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const tooltip = document.getElementById('tooltip');
        const selectedNotesInput = document.getElementById('selectedNotes');
        const parfumPriceInput = document.getElementById('parfumPrice');
        
        let selectedNotes = [];
        let totalPercentage = 0;
        const MAX_NOTES = 6; 
        
        // Gestion des notes de parfum
        noteItems.forEach(item => {
            // Affichage du tooltip au survol
            item.addEventListener('mouseenter', function(e) {
                const description = this.getAttribute('data-description');
                tooltip.textContent = description;
                tooltip.style.opacity = '1';
                
              // Positionnement du tooltip
                const rect = this.getBoundingClientRect();
                tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
                tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            });
            
            item.addEventListener('mouseleave', function() {
                tooltip.style.opacity = '0';
            });
            
            // POUR LA Sélection des notes
            item.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const category = this.getAttribute('data-category');
                const color = this.getAttribute('data-color');
                
                // Vérifier si la note est déjà sélectionnée
                if (this.classList.contains('selected')) {
                    // Désélectionner la note
                    this.classList.remove('selected');
                    
                    // Mettre à jour le tableau des notes sélectionnées
                    const index = selectedNotes.findIndex(note => note.name === name);
                    if (index !== -1) {
                        totalPercentage -= selectedNotes[index].percentage;
                        selectedNotes.splice(index, 1);
                    }
                } else {
                    // Vérifier si le maximum de notes est atteint
                    if (selectedNotes.length >= MAX_NOTES) {
                        alert(`Vous ne pouvez sélectionner que ${MAX_NOTES} notes maximum.`);
                        return;
                    }
                    
                    // Sélectionner la note
                    this.classList.add('selected');
                    
                    // Ajouter la note au tableau
                    const percentage = 10; // Pourcentage par défaut
                    selectedNotes.push({
                        name: name,
                        category: category,
                        color: color,
                        percentage: percentage
                    });
                    
                    totalPercentage += percentage;
                }
                
                // Mettre à jour l'affichage
                updateBottle();
                updateSummary();
                
                // Mettre à jour le champ caché pour le formulaire
                selectedNotesInput.value = JSON.stringify(selectedNotes);
            });
        });
        
       
        function updateBottle() {
            if (selectedNotes.length === 0) {
                bottleContent.style.height = '0%';
                bottleContent.style.background = 'linear-gradient(to bottom, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1))';
                document.querySelector('.perfume-bottle').classList.remove('bottle-glow');
                return;
            }
            
            // Calculer la hauteur de remplissage, on a fait (max 95%)
            const fillHeight = Math.min(totalPercentage, 100) * 0.95;
            bottleContent.style.setProperty('--fill-height', fillHeight + '%');
            
            // Créer un dégradé de couleurs basé sur les notes sélectionnées
            let gradientColors = selectedNotes.map(note => note.color);
            if (gradientColors.length === 1) {
                gradientColors.push(gradientColors[0]); 
            }
            
            const gradient = `linear-gradient(to top, ${gradientColors.join(', ')})`;
            bottleContent.style.background = gradient;
             //pour l'animation de la bouteille//
            bottleContent.style.animation = 'bottleFill 1s forwards';
            
            // Effet de brillance si la bouteille est suffisamment remplie
            if (fillHeight > 30) {
                document.querySelector('.perfume-bottle').classList.add('bottle-glow');
            } else {
                document.querySelector('.perfume-bottle').classList.remove('bottle-glow');
            }
        }
        
    
        function updateSummary() {
            if (selectedNotes.length === 0) {
                summaryList.innerHTML = '<p class="text-center text-muted">Sélectionnez des notes pour composer votre parfum</p>';
                checkoutBtn.disabled = true;
                return;
            }
            
           
            const sortedNotes = [...selectedNotes].sort((a, b) => {
                const order = { 'tete': 1, 'coeur': 2, 'fond': 3 };
                return order[a.category] - order[b.category];
            });
            
           
            let html = '';
            sortedNotes.forEach(note => {
                html += `
                <div class="summary-item">
                    <span class="summary-name">${note.name}</span>
                    <span class="summary-percentage">${note.percentage}%</span>
                </div>
                `;
                
               
                const noteItem = document.querySelector(`.note-item[data-name="${note.name}"]`);
                if (noteItem) {
                    const percentageEl = noteItem.querySelector('.note-percentage');
                    percentageEl.textContent = note.percentage + '%';
                }
            });
            
            summaryList.innerHTML = html;
            
        
            checkoutBtn.disabled = selectedNotes.length < 3;
            
            // Calculer le prix en fonction du nombre de notes//
            const basePrice = 150;
            const pricePerNote = 15;
            const finalPrice = basePrice + (selectedNotes.length - 3) * pricePerNote;
            const displayPrice = Math.max(finalPrice, basePrice).toFixed(2);
            
            totalPrice.textContent = `${displayPrice} €`;
            parfumPriceInput.value = displayPrice;
        }
        
        // Ajuster les pourcentages des notes //
        document.querySelectorAll('.note-percentage').forEach(el => {
            el.addEventListener('click', function(e) {
                e.stopPropagation(); 
                
                const noteItem = this.closest('.note-item');
                const noteName = noteItem.getAttribute('data-name');
                const note = selectedNotes.find(n => n.name === noteName);
                
                if (note) {
                    
                    const newPercentage = prompt(`Ajustez le pourcentage pour ${noteName} (5-30%):`, note.percentage);
                    
                    if (newPercentage !== null) {
                        const percentage = parseInt(newPercentage);
                        
                        if (!isNaN(percentage) && percentage >= 5 && percentage <= 30) {
                           
                            totalPercentage = totalPercentage - note.percentage + percentage;
                            
                     
                            if (totalPercentage > 100) {
                                alert('Le pourcentage total ne peut pas dépasser 100%.');
                                return;
                            }
                            
                           
                            note.percentage = percentage;
                            this.textContent = percentage + '%';
                            
                           
                            updateBottle();
                            updateSummary();
                            
                           
                            selectedNotesInput.value = JSON.stringify(selectedNotes);
                        } else {
                            alert('Veuillez entrer un pourcentage valide entre 5 et 30.');
                        }
                    }
                }
            });
        });
    }
    
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
// Fermer la connexion à la base de données //
if (isset($conn) && $conn) {
    $conn->close();
}
?>

