<?php

session_start();


if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
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

if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantite'] as $produit_id => $quantite) {
        $quantite = (int)$quantite;
        if ($quantite > 0) {
            $_SESSION['panier'][$produit_id] = $quantite;
        } else {
            unset($_SESSION['panier'][$produit_id]);
        } 
    }
  
    header("Location: panier.php");
    exit();
}


if (isset($_GET['remove']) && isset($_SESSION['panier'][$_GET['remove']])) {
    unset($_SESSION['panier'][$_GET['remove']]);
    
    header("Location: panier.php");
    exit();
}


$parfum_personnalise = isset($_SESSION['parfum_personnalise']) ? $_SESSION['parfum_personnalise'] : null;


$produits_panier = [];
$total_panier = 0;


if (!empty($_SESSION['panier'])) {
    $produit_ids = array_keys($_SESSION['panier']);
    $ids_string = implode(',', $produit_ids);
    
    $sql = "SELECT * FROM produits WHERE id IN ($ids_string)";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['quantite'] = $_SESSION['panier'][$row['id']];
            $row['sous_total'] = $row['prix'] * $row['quantite'];
            $produits_panier[] = $row;
            $total_panier += $row['sous_total'];
        }
    }
}

// on ajoute le parfum personnalisé au total si présent
if ($parfum_personnalise) {
    $total_panier += floatval($parfum_personnalise['prix']);
}
// Compter le nombre total d'articles dans le panier
$nombre_articles = 0;
foreach ($_SESSION['panier'] as $quantite) {
    $nombre_articles += $quantite;
}

if ($parfum_personnalise) {
    $nombre_articles += 1;
}

if (isset($_POST['vider_panier'])) {
    $_SESSION['panier'] = [];
    if (isset($_SESSION['parfum_personnalise'])) {
        unset($_SESSION['parfum_personnalise']);
    }
  
    header("Location: panier.php");
    exit();
}


if (isset($_POST['commander'])) {
    // Ici, on peut ajouter le code pour enregistrer la commande dans la base de données et on redirige vers une page de paiement//
    // on a pris cet example nous allons simplement rediriger vers une page de confirmation
    header("Location: confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - HACHA LUXURY SCENT</title>
    
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

        
        .cart-section {
            padding: 80px 0;
            position: relative;
        }

        .cart-section::before {
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

        
        .cart-table {
            background: rgba(27, 40, 69, 0.7);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            border: 1px solid rgba(201, 176, 55, 0.2);
        }

        .cart-table th {
            background: rgba(10, 10, 10, 0.8);
            color: var(--secondary);
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            padding: 15px;
            border-bottom: 1px solid rgba(201, 176, 55, 0.3);
        }

        .cart-table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cart-table tr:last-child td {
            border-bottom: none;
        }

        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid rgba(201, 176, 55, 0.3);
            transition: all 0.3s ease;
        }

        .cart-img:hover {
            transform: scale(1.05);
            border-color: var(--secondary);
        }

        .product-name {
            font-weight: 500;
            color: white;
        }

        .product-price {
            color: var(--secondary);
            font-weight: 600;
        }

       
        .quantity-input {
            width: 70px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(201, 176, 55, 0.3);
            border-radius: 5px;
            color: white;
            text-align: center;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 10px rgba(201, 176, 55, 0.3);
        }

        .btn-remove {
            color: #e74c3c;
            background: transparent;
            border: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-remove:hover {
            color: #c0392b;
            transform: scale(1.1);
        }

       
        .cart-summary {
            background: rgba(27, 40, 69, 0.7);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            border: 1px solid rgba(201, 176, 55, 0.2);
            height: 100%;
        }

        .cart-summary h3 {
            color: var(--secondary);
            margin-bottom: 25px;
            font-size: 1.8rem;
            position: relative;
            display: inline-block;
        }

        .cart-summary h3::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: var(--gold-gradient);
            bottom: -10px;
            left: 0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .summary-item:last-of-type {
            border-bottom: none;
        }

        .summary-label {
            color: #ddd;
        }

        .summary-value {
            color: var(--secondary);
            font-weight: 600;
        }

        .total-row {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid rgba(201, 176, 55, 0.3);
        }

        .total-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
        }

        .total-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
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
            width: 100%;
            margin-top: 20px;
        }

        .btn-luxury:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(201, 176, 55, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--secondary);
            color: var(--secondary);
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 50px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .btn-outline:hover {
            background: rgba(201, 176, 55, 0.1);
            transform: translateY(-3px);
        }

      
        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }

        .empty-cart i {
            font-size: 5rem;
            color: rgba(201, 176, 55, 0.3);
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            color: var(--secondary);
            margin-bottom: 20px;
        }

  
        .custom-perfume {
            background: rgba(27, 40, 69, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(201, 176, 55, 0.3);
            position: relative;
        }

        .custom-perfume-label {
            position: absolute;
            top: -10px;
            right: 20px;
            background: var(--gold-gradient);
            color: var(--dark-bg);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .custom-perfume h4 {
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .notes-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .note-tag {
            background: rgba(201, 176, 55, 0.2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
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
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .cart-table {
                display: block;
                overflow-x: auto;
            }
            
            .cart-summary {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="indexi.php">HACHA LUXURY SCENT</a>
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
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="panier.php">
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
        <h1 data-aos="fade-up">Votre Panier</h1>
    </div>
</header>


<section class="cart-section">
    <div class="container">
        <?php if (empty($_SESSION['panier']) && !$parfum_personnalise): ?>
        
            <div class="empty-cart" data-aos="fade-up">
                <i class="fas fa-shopping-basket"></i>
                <h3>Votre panier est vide</h3>
                <p>Découvrez nos parfums d'exception et ajoutez-les à votre panier.</p>
                <a href="produits.php" class="btn btn-luxury mt-4">Découvrir nos parfums</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8" data-aos="fade-up">
                    <form method="post" action="panier.php">
                        <div class="cart-table mb-4">
                            <table class="table table-hover text-white mb-0">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th>Sous-total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produits_panier as $produit): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $produit['image']; ?>" alt="<?php echo $produit['nom']; ?>" class="cart-img me-3">
                                                <span class="product-name"><?php echo $produit['nom']; ?></span>
                                            </div>
                                        </td>
                                        <td class="product-price"><?php echo number_format($produit['prix'], 2); ?> €</td>
                                        <td>
                                            <input type="number" name="quantite[<?php echo $produit['id']; ?>]" value="<?php echo $produit['quantite']; ?>" min="0" class="quantity-input">
                                        </td>
                                        <td class="product-price"><?php echo number_format($produit['sous_total'], 2); ?> €</td>
                                        <td>
                                            <a href="panier.php?remove=<?php echo $produit['id']; ?>" class="btn-remove" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    
                                    <?php if ($parfum_personnalise): ?>
                                    <tr>
                                        <td colspan="5">
                                            <div class="custom-perfume">
                                                <span class="custom-perfume-label">Personnalisé</span>
                                                <h4><?php echo $parfum_personnalise['nom']; ?></h4>
                                                <p>Votre création unique de parfum personnalisé</p>
                                                
                                                <?php if (!empty($parfum_personnalise['notes'])): 
                                                    $notes = json_decode($parfum_personnalise['notes'], true);
                                                    if (!empty($notes)): ?>
                                                    <div class="notes-list">
                                                        <?php foreach ($notes as $note): ?>
                                                            <span class="note-tag"><?php echo $note['name']; ?> (<?php echo $note['percentage']; ?>%)</span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <span class="product-price"><?php echo number_format($parfum_personnalise['prix'], 2); ?> €</span>
                                                    <a href="panier.php?remove_custom=1" class="btn-remove" title="Supprimer">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="update_cart" class="btn btn-outline">
                                <i class="fas fa-sync-alt me-2"></i> Mettre à jour le panier
                            </button>
                            <button type="submit" name="vider_panier" class="btn btn-outline">
                                <i class="fas fa-trash me-2"></i> Vider le panier
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="cart-summary">
                        <h3>Récapitulatif</h3>
                        
                        <div class="summary-item">
                            <span class="summary-label">Sous-total</span>
                            <span class="summary-value"><?php echo number_format($total_panier, 2); ?> €</span>
                        </div>
                        
                        <div class="summary-item">
                            <span class="summary-label">Livraison</span>
                            <span class="summary-value">Gratuite</span>
                        </div>
                        
                        <div class="summary-item total-row">
                            <span class="total-label">Total</span>
                            <span class="total-value"><?php echo number_format($total_panier, 2); ?> €</span>
                        </div>
                        
                        <form method="post" action="panier.php">
                            <button type="submit" name="commander" class="btn btn-luxury">
                                Procéder au paiement
                            </button>
                        </form>
                        
                        <a href="produits.php" class="btn btn-outline">
                            <i class="fas fa-arrow-left me-2"></i> Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
</script>

</body>
</html>

<?php
// Fermer la connexion à la base de données 
if (isset($conn) && $conn) {
    $conn->close();
}
?>
