-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 16 mai 2025 à 17:37
-- Version du serveur : 8.0.39
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hacha_luxury`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `produit_id` int NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `note` int NOT NULL,
  `commentaire` text,
  `date_avis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approuve` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `produit_id`, `utilisateur_id`, `nom`, `email`, `note`, `commentaire`, `date_avis`, `approuve`) VALUES
(1, 2, 2, 'Karim Romani', 'karim.romani@example.com', 4, 'J\'ai offert Ambre Royal à mon épouse et elle l\'adore. L\'ambre est parfaitement dosé et la fragrance évolue magnifiquement tout au long de la journée.', '2024-02-22 15:30:00', 1),
(3, 6, 3, 'Karim El Amrani', 'karim.elamrani@example.com', 5, 'Le meilleur parfum à l\'oud que j\'ai jamais essayé. Il est à la fois authentique et moderne, parfait pour les occasions spéciales.', '2024-02-28 08:45:00', 1),
(4, 5, 4, 'Leila Benali', 'leila.benali@example.com', 4, 'La fleur d\'oranger est capturée à la perfection dans ce parfum. Il me rappelle les jardins de mon enfance à Fès.', '2024-03-03 13:20:00', 1),
(5, 1, 5, 'Carlos Garcia', 'carlos.garcia@example.com', 5, 'J\'ai découvert ce parfum lors d\'un voyage au Maroc et je ne peux plus m\'en passer. Il est unique et mystérieux, exactement comme son nom l\'indique.', '2024-03-07 10:10:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `image`, `date_creation`) VALUES
(1, 'Oriental', 'Des parfums riches et envoûtants avec des notes d\'épices, de résines et de vanille.', 'categories/oriental.jpg', '2025-03-16 22:30:57'),
(2, 'Boisé', 'Des parfums chaleureux et sophistiqués avec des notes de bois précieux comme le santal, le cèdre et l\'oud.', 'categories/boise.jpg', '2025-03-16 22:30:57'),
(3, 'Floral', 'Des parfums élégants et féminins avec des notes de fleurs comme la rose, le jasmin et la fleur d\'oranger.', 'categories/floral.jpg', '2025-03-16 22:30:57'),
(4, 'Frais', 'Des parfums légers et vivifiants avec des notes d\'agrumes, de menthe et d\'herbes aromatiques.', 'categories/frais.jpg', '2025-03-16 22:30:57'),
(5, 'Épicé', 'Des parfums chaleureux et exotiques avec des notes de safran, de cardamome et de poivre.', 'categories/epice.jpg', '2025-03-16 22:30:57'),
(6, 'Gourmand', 'Des parfums délicieux et addictifs avec des notes de vanille, de caramel et de chocolat.', 'categories/gourmand.jpg', '2025-03-16 22:30:57');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `date_commande` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('en attente','confirmée','expédiée','livrée','annulée') NOT NULL DEFAULT 'en attente',
  `total` decimal(10,2) NOT NULL,
  `adresse_livraison` text,
  `ville_livraison` varchar(100) DEFAULT NULL,
  `code_postal_livraison` varchar(20) DEFAULT NULL,
  `pays_livraison` varchar(100) DEFAULT NULL,
  `methode_paiement` varchar(50) DEFAULT NULL,
  `reference_paiement` varchar(100) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `utilisateur_id`, `date_commande`, `statut`, `total`, `adresse_livraison`, `ville_livraison`, `code_postal_livraison`, `pays_livraison`, `methode_paiement`, `reference_paiement`, `notes`) VALUES
(1, 1, '2024-02-15 13:30:00', 'livrée', 340.00, '123 Rue de Paris', 'Paris', '75001', 'France', 'carte', 'PAY-123456789', NULL),
(2, 2, '2024-02-20 09:15:00', 'expédiée', 160.00, '456 Avenue des Champs-Élysées', 'Paris', '75008', 'France', 'paypal', 'PAY-987654321', NULL),
(3, 3, '2024-02-25 15:45:00', 'confirmée', 400.00, '789 Boulevard Mohammed V', 'Casablanca', '20000', 'Maroc', 'carte', 'PAY-456789123', NULL),
(4, 4, '2024-03-01 08:30:00', 'en attente', 155.00, '321 Rue des Jardins', 'Rabat', '10000', 'Maroc', 'carte', 'PAY-789123456', NULL),
(5, 5, '2024-03-05 12:20:00', 'confirmée', 220.00, '567 Calle Mayor', 'Madrid', '28001', 'Espagne', 'paypal', 'PAY-321654987', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `poste` varchar(100) NOT NULL,
  `bio` text,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `ordre` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nom`, `prenom`, `poste`, `bio`, `image`, `email`, `linkedin`, `instagram`, `twitter`, `ordre`) VALUES
(1, 'Ajam', 'Chaimae', 'Fondatrice & Directrice Créative', 'Passionnée de parfumerie depuis l\'enfance, Chaimae a étudié l\'art des senteurs à Grasse avant de créer HACHA LUXURY SCENT.', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3', 'chaimae@hachaluxury.com', 'https://linkedin.com/in/chaimae-ajam', 'https://instagram.com/chaimae_ajam', 'https://twitter.com/chaimae_ajam', 1),
(2, 'Jelthi', 'Hajar', 'Maître Parfumeuse', 'Avec sa créativité sans limites, Hajar compose des fragrances uniques qui captivent les sens.', 'pexels-augustocarneirojr-30479362.jpg', 'hajar@hachaluxury.com', 'https://linkedin.com/in/hajar-jelthi', 'https://instagram.com/hajar_jelthi', 'https://twitter.com/hajar_jelthi', 2),
(3, 'Benali', 'Yasmine', 'Responsable Marketing', 'Experte en marketing digital, Yasmine a travaillé pour de grandes maisons de parfum avant de rejoindre l\'aventure HACHA.', 'https://randomuser.me/api/portraits/women/68.jpg', 'yasmine@hachaluxury.com', 'https://linkedin.com/in/yasmine-benali', 'https://instagram.com/yasmine_benali', 'https://twitter.com/yasmine_benali', 3),
(4, 'El Fassi', 'Mehdi', 'Directeur Commercial', 'Fort de son expérience dans le luxe, Mehdi développe la présence de HACHA sur les marchés internationaux.', 'https://randomuser.me/api/portraits/men/32.jpg', 'mehdi@hachaluxury.com', 'https://linkedin.com/in/mehdi-elfassi', 'https://instagram.com/mehdi_elfassi', 'https://twitter.com/mehdi_elfassi', 4);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` enum('tete','coeur','fond') NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `nom`, `type`, `description`, `image`) VALUES
(1, 'Bergamote', 'tete', 'Agrume frais et pétillant, apporte une fraîcheur immédiate', 'ingredients/bergamote.jpg'),
(2, 'Menthe Nanah', 'tete', 'Menthe marocaine rafraîchissante avec des notes herbacées et vivifiantes', 'ingredients/menthe.jpg'),
(3, 'Néroli', 'tete', 'Huile essentielle de fleur d\'oranger amère, délicate et légèrement épicée', 'ingredients/neroli.jpg'),
(4, 'Citron de l\'Atlas', 'tete', 'Agrume cultivé dans les montagnes de l\'Atlas, vif et ensoleillé', 'ingredients/citron.jpg'),
(5, 'Rose de Damas', 'coeur', 'Rose cultivée au Maroc, riche et veloutée avec des facettes miellées', 'ingredients/rose.jpg'),
(6, 'Jasmin Sambac', 'coeur', 'Fleur blanche exotique aux notes sensuelles et envoûtantes', 'ingredients/jasmin.jpg'),
(7, 'Safran', 'coeur', 'Épice précieuse du Maroc aux notes chaudes et légèrement métalliques', 'ingredients/safran.jpg'),
(8, 'Fleur d\'Oranger', 'coeur', 'Fleur emblématique du Maroc, douce et légèrement miellée', 'ingredients/fleur_oranger.jpg'),
(9, 'Oud Marocain', 'fond', 'Bois précieux aux notes chaudes, boisées et légèrement animales', 'ingredients/oud.jpg'),
(10, 'Ambre Gris', 'fond', 'Note ambrée rare et précieuse, chaude et sensuelle', 'ingredients/ambre.jpg'),
(11, 'Cèdre de l\'Atlas', 'fond', 'Bois marocain noble aux notes sèches et boisées', 'ingredients/cedre.jpg'),
(12, 'Musc Blanc', 'fond', 'Note douce et enveloppante, apporte de la sensualité et de la durabilité', 'ingredients/musc.jpg'),
(13, 'Vanille de Madagascar', 'fond', 'Note gourmande et réconfortante, apporte de la douceur et de la chaleur', 'ingredients/vanille.jpg'),
(14, 'Benjoin', 'fond', 'Résine orientale aux notes vanillées et balsamiques', 'ingredients/benjoin.jpg'),
(15, 'Cardamome', 'tete', 'Épice fraîche et aromatique avec des notes légèrement citronnées', 'ingredients/cardamome.jpg'),
(16, 'Poivre Noir', 'tete', 'Épice piquante et chaude qui apporte du caractère', 'ingredients/poivre.jpg'),
(17, 'Cannelle', 'coeur', 'Épice chaude et sucrée avec des notes boisées', 'ingredients/cannelle.jpg'),
(18, 'Iris', 'coeur', 'Fleur poudrée et élégante avec des facettes boisées', 'ingredients/iris.jpg'),
(19, 'Tubéreuse', 'coeur', 'Fleur blanche intense et crémeuse, très sensuelle', 'ingredients/tubereuse.jpg'),
(20, 'Patchouli', 'fond', 'Note terreuse et boisée avec des facettes camphrées', 'ingredients/patchouli.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `date_inscription`, `actif`) VALUES
(1, 'marie.durand@example.com', '2024-01-10 08:30:00', 1),
(2, 'pierre.martin@example.com', '2024-01-15 13:45:00', 1),
(3, 'fatima.benali@example.com', '2024-01-20 10:20:00', 1),
(4, 'thomas.dubois@example.com', '2024-01-25 15:10:00', 1),
(5, 'sarah.johnson@example.com', '2024-02-01 09:30:00', 1),
(6, 'ahmed.hassan@example.com', '2024-02-05 12:45:00', 1),
(7, 'julie.petit@example.com', '2024-02-10 14:20:00', 1),
(8, 'carlos.rodriguez@example.com', '2024-02-15 08:15:00', 1),
(9, 'nadia.alaoui@example.com', '2024-02-20 11:30:00', 1),
(10, 'david.smith@example.com', '2024-02-25 13:10:00', 1),
(11, 'jiji@gmail.com', '2025-03-17 10:59:48', 1),
(12, 'chaimaedfdfzeq@gmail.com', '2025-04-09 09:12:37', 1);

-- --------------------------------------------------------

--
-- Structure de la table `parfums_personnalises`
--

CREATE TABLE `parfums_personnalises` (
  `id` int NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `commande_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `parfums_personnalises`
--

INSERT INTO `parfums_personnalises` (`id`, `utilisateur_id`, `nom`, `notes`, `prix`, `date_creation`, `commande_id`) VALUES
(1, 1, 'Mon Rêve Marocain', '[{\"name\":\"Rose de Damas\",\"category\":\"coeur\",\"color\":\"#e84393\",\"percentage\":20},{\"name\":\"Oud Marocain\",\"category\":\"fond\",\"color\":\"#8b5a2b\",\"percentage\":15},{\"name\":\"Bergamote\",\"category\":\"tete\",\"color\":\"#f39c12\",\"percentage\":10},{\"name\":\"Vanille de Madagascar\",\"category\":\"fond\",\"color\":\"#f5cd79\",\"percentage\":15}]', 180.00, '2024-02-16 10:30:00', NULL),
(2, 3, 'Nuit Étoilée', '[{\"name\":\"Jasmin Sambac\",\"category\":\"coeur\",\"color\":\"#dff9fb\",\"percentage\":15},{\"name\":\"Ambre Gris\",\"category\":\"fond\",\"color\":\"#cd6133\",\"percentage\":20},{\"name\":\"Citron de l\'Atlas\",\"category\":\"tete\",\"color\":\"#f9ca24\",\"percentage\":10},{\"name\":\"Musc Blanc\",\"category\":\"fond\",\"color\":\"#dcdde1\",\"percentage\":15}]', 195.00, '2024-02-26 13:45:00', 3);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '10',
  `genre` enum('homme','femme','unisexe') NOT NULL,
  `categorie_id` int DEFAULT NULL,
  `notes_tete` varchar(255) DEFAULT NULL,
  `notes_coeur` varchar(255) DEFAULT NULL,
  `notes_fond` varchar(255) DEFAULT NULL,
  `concentration` enum('eau de cologne','eau de toilette','eau de parfum','parfum') DEFAULT 'eau de parfum',
  `volume` int DEFAULT '100',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `best_seller` tinyint(1) DEFAULT '0',
  `nouveau` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `image`, `stock`, `genre`, `categorie_id`, `notes_tete`, `notes_coeur`, `notes_fond`, `concentration`, `volume`, `date_creation`, `best_seller`, `nouveau`) VALUES
(1, 'Coco Chanel', 'Un parfum intemporel alliant élégance et sensualité, où les notes de jasmin, de rose et de vanille se mêlent à la douceur des muscs pour une signature inoubliable. ', 120.00, 'coooco.jpeg', 15, 'femme', 1, 'Jasmin,rose,vanille', 'Jasmin,rose,vanille', 'Jasmin,rose,vanille', 'eau de parfum', 100, '2025-03-16 22:30:57', 1, 0),
(2, 'Valentino', 'Un parfum audacieux et raffiné, où la vanille chaleureuse rencontre la vivacité de la bergamote et la douceur des fleurs blanches, laissant une empreinte élégante et inoubliable. ', 150.99, 'valentino.jpeg', 20, 'femme', 2, 'Bergamote, fleur blanche,vanille', 'Bergamote, fleur blanche,vanille', 'Bergamote, fleur blanche,vanille', 'eau de parfum', 100, '2025-03-16 22:30:57', 1, 0),
(3, 'Kayali Cherry', 'Un parfum gourmand et addictif, où la cerise juteuse se mêle aux amandes sucrées, à la vanille sensuelle et à une touche de bois fumé pour une empreinte à la fois audacieuse et envoûtante. ', 180.99, 'kayali.jpeg', 18, 'femme', 3, 'Amende sucrée, cerise, bois fumé', 'Amende sucrée, cerise, bois fumé', 'Amende sucrée, cerise, bois fumé', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 1),
(4, 'Interdit ', 'Un parfum mystérieux et sophistiqué, où la fleur d\'oranger lumineuse contraste avec la profondeur du patchouli et des notes boisées, créant une signature audacieuse et inoubliable.', 169.99, 'rouge.jpg', 25, 'femme', 2, 'Poire, Bergamote', ' Fleur d’oranger, Jasmin, Tubéreuse', 'Patchouli, Vanille, Vétiver, Ambroxan\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(5, 'Miss Dior', 'Le parfum Miss Dior est une fragrance florale et élégante, qui incarne la féminité moderne.', 90.00, 'miiiiss.jpeg', 22, 'femme', 3, 'Mandarine, Bergamote', 'Rose de Grasse, Gardenia, Jasmin', 'Patchouli, Musc, Bois de rose', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(6, 'Sauvage', '', 100.99, 'sauvage.jpg', 10, 'homme', 2, 'Safran, Encens, Poivre rose', 'Ambroxan, Cèdre, Patchouli', 'Ambre, Musc, Patchouli', 'parfum', 50, '2025-03-16 22:30:57', 1, 0),
(7, 'Hugo Boss', 'Le parfum Hugo Boss  est une fragrance élégante et sophistiquée, idéale pour l’homme moderne', 120.21, 'hugoboss6.jpg', 15, 'homme', 5, 'Pomme, Agrumes, Prune', 'Cannelle, Clou de girofle, Géranium', 'Oud, Ambre, Vanille', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 1),
(8, 'Stronger with you ', 'Stronger With You d\'Emporio Armani est un parfum masculin moderne et élégant, incarnant une sensualité chaleureuse et magnétique. ', 89.34, 'homme1.jpg', 30, 'homme', 4, 'Cardamome, Poivre rose, Feuille de violette, Menthe', 'Sauge, Ananas, Melon, Lavande, Cannelle', ' Vanille, Châtaigne, Cèdre, Bois ambré', 'eau de toilette', 100, '2025-03-16 22:30:57', 0, 0),
(9, 'Million Gold', 'Million Gold de Paco Rabanne est une édition luxueuse et captivante du célèbre 1 Million. ', 165.00, 'pacorabanehomme4.jpg', 20, 'homme', 6, '', 'Vanille, Fleur d\'oranger, Jasmin', 'Ambre, Benjoin, Musc', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(10, 'L\'Homme', '', 175.00, 'hommeYSL7.jpg', 18, 'homme', 2, 'Bergamote, Cardamome, Safran', 'Cuir, Rose, Iris', 'Bois de cèdre, Oud, Ambre', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(11, 'Versace', 'Eros de Versace est un parfum masculin intense et séduisant, inspiré par la mythologie grecque et la puissance du dieu de l’amour.', 160.00, 'varsace.jpeg', 22, 'femme', 3, 'Bergamote, Néroli, Mandarine', 'Jasmin Sambac, Tubéreuse, Ylang-ylang', 'Musc blanc, Vanille, Bois de santal', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(12, 'Black Opium', 'Black Opium d\'Yves Saint Laurent est un parfum féminin audacieux et envoûtant, incarnant une féminité moderne et rebelle', 170.00, 'black.jpeg', 20, 'femme', 5, 'Poire, Poivre rose, Fleur d\'oranger', 'Safran, Rose, Encens', 'Oud, Ambre, Vanille', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(13, 'Bois Noir', 'Bois mystérieux et raffiné, symbole de force et d’élégance intemporelle', 115.50, 'bois noir .jpeg', 25, 'homme', 4, 'Bergamote, Citron, Mandarine', 'Néroli, Petit grain, Fleur d\'oranger', 'Musc, Vétiver, Bois de cèdre', 'eau de toilette', 100, '2025-03-16 22:30:57', 0, 0),
(14, 'Elixir Floral', 'Elixir Floral, une  essence naturelle pour harmoniser les émotions et retrouver l’équilibre intérieur.', 129.99, 'elixir.jpeg', 15, 'femme', 2, 'Cardamome, Bergamote, Safran', 'Bois de santal, Rose, Iris', 'Ambre, Vanille, Musc', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(15, 'Ambre Royal', 'Inspiré par le fruit emblématique du Maroc, à la fois sucré et frais.', 175.00, 'amber .jpeg', 20, 'femme', 6, 'Figue, Bergamote, Feuilles vertes', 'Jasmin, Noix de coco, Iris', 'Bois de cèdre, Vanille, Musc', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 1),
(16, 'Qaed Lattafa  DUBAI ', 'Qaed Lattafa est un parfum intense et envoûtant, idéal pour ceux qui aiment les fragrances orientales et sophistiquées.', 150.00, 'qaid.jpeg', 25, 'unisexe', 1, 'Ananas, agrumes, safran', 'Musc blanc, Jasmin, Fleur d\'oranger', 'Jasmin, bois de cèdre, lavande ', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(17, 'Glacier Homme', 'Une fragrance boisée et fumée, mystérieuse et captivante.', 175.00, 'glacier .jpeg', 18, 'homme', 2, 'Bergamote, Poivre noir, Cardamome', 'Bois de gaïac, Cyprès, Vétiver', 'Oud, Ambre, Encens', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(18, 'Delina Dubai ', 'Delina de Parfums de Marly est une fragrance féminine sophistiquée et envoûtante.\r\n\r\nUn parfum élégant et sensuel, parfait pour celles qui aiment les senteurs raffinées et romantiques', 185.00, 'delina.jpeg', 15, 'femme', 3, 'Bergamote, Mandarine, Litchi', 'Tubéreuse, Jasmin, Ylang-ylang', 'Vanille, Musc, Bois de santal', 'parfum', 50, '2025-03-16 22:30:57', 0, 0),
(19, 'Bleu de Channel', 'Une interprétation moderne et fumée de cette racine emblématique.', 165.00, 'bleu de chanel .jpeg', 20, 'homme', 2, 'Bergamote, Citron, Poivre noir', 'Vétiver, Cyprès, Bois de cèdre', 'Ambre, Musc, Encens', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(20, 'Amoouage', 'Une vanille riche et crémeuse, récoltée à Madagascar et sublimée par notre savoir-faire.', 140.00, 'amouage.jpeg', 22, 'unisexe', 6, 'Bergamote, Mandarine, Cardamome', 'Vanille Bourbon, Fleur d\'oranger, Jasmin', 'Ambre, Benjoin, Musc', 'eau de parfum', 100, '2025-03-16 22:30:57', 0, 0),
(21, 'Cuire de Marrakech', 'Cuire de Marrakech est un parfum envoûtant aux accents orientaux, mêlant des épices chaudes, des bois précieux et une touche florale enivrante', 120.00, 'devotion .jpeg', 10, 'unisexe', 5, ' Agrumes, épices (safran, cannelle), encens', 'Rose, jasmin, bois de cèdre, patchouli', ' Ambre, musc, oud, vanille', 'eau de parfum', 100, '2025-03-25 23:00:00', 0, 1),
(22, 'Q\'AED Fursan DUBAI', 'Qaed Fragrance - Dubai est un parfum de luxe réputée pour ses créations orientales sophistiquées et puissantes', 120.00, 'dubai.jpeg', 10, 'unisexe', 1, 'Rose, Safran, Agrumes', 'Oud, Bois de santal, Jasmin', ' Vanille, Ambre, Musc', 'eau de parfum', 100, '2025-03-26 12:16:42', 0, 0),
(23, 'Vétiver Sauvage', 'Le Vétiver Sauvage de Guerlain est une fragrance masculine qui incarne la fraîcheur, l\'élégance et la puissance d\'une nature sauvage et intacte.', 125.00, 'vetiver.jpeg', 10, 'homme', 2, 'gingembre,citron, safran', 'vétiver,lavande', 'musc, bois de santal', 'eau de parfum', 100, '2025-03-26 12:45:08', 0, 0),
(24, 'Baccarat Rouge', 'Baccarat Rouge 540 de Maison Francis Kurkdjian est l\'une des créations les plus célèbres et prisées de la parfumerie contemporaine', 200.00, 'baccarat rouge .jpeg', 10, 'unisexe', 4, 'safran,jasmin,oud', 'ambre gris, bois de cèdre,safran', 'musc blanc, bois de santal,gingembre', 'eau de parfum', 100, '2025-03-26 12:52:02', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit_ingredients`
--

CREATE TABLE `produit_ingredients` (
  `produit_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  `pourcentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit_ingredients`
--

INSERT INTO `produit_ingredients` (`produit_id`, `ingredient_id`, `pourcentage`) VALUES
(1, 1, 5.00),
(1, 2, 2.00),
(1, 4, 3.00),
(1, 5, 15.00),
(1, 7, 10.00),
(1, 9, 20.00),
(1, 10, 15.00),
(1, 12, 10.00),
(2, 1, 5.00),
(2, 10, 20.00),
(2, 11, 15.00),
(2, 12, 10.00),
(2, 13, 10.00),
(2, 16, 3.00),
(2, 20, 5.00),
(3, 1, 5.00),
(3, 5, 25.00),
(3, 6, 10.00),
(3, 10, 10.00),
(3, 11, 10.00),
(3, 12, 10.00),
(4, 1, 5.00),
(4, 4, 8.00),
(4, 10, 15.00),
(4, 11, 30.00),
(4, 12, 10.00),
(5, 1, 5.00),
(5, 3, 10.00),
(5, 6, 10.00),
(5, 8, 25.00),
(5, 12, 15.00),
(5, 13, 10.00),
(6, 5, 15.00),
(6, 7, 10.00),
(6, 9, 30.00),
(6, 10, 15.00),
(6, 12, 10.00),
(6, 20, 5.00),
(7, 1, 5.00),
(7, 5, 15.00),
(7, 6, 10.00),
(7, 7, 20.00),
(7, 9, 15.00),
(7, 10, 10.00),
(7, 13, 10.00),
(7, 15, 5.00);

-- --------------------------------------------------------

--
-- Structure de la table `temoignages`
--

CREATE TABLE `temoignages` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `texte` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `temoignages`
--

INSERT INTO `temoignages` (`id`, `nom`, `ville`, `texte`, `image`, `date_creation`, `actif`) VALUES
(1, 'Leila M.', 'Casablanca', 'Le parfum \'Mystère de Marrakech\' m\'accompagne depuis sa sortie. Sa tenue est exceptionnelle et j\'adore comment il évolue tout au long de la journée. Un vrai coup de cœur !', 'https://randomuser.me/api/portraits/women/44.jpg', '2024-01-20 09:15:00', 1),
(2, 'Karim R.', 'Rabat', 'J\'ai offert \'Nuit d\'Ambre\' à mon mari pour notre anniversaire et c\'est devenu son parfum signature. La qualité des ingrédients se ressent immédiatement.', 'https://randomuser.me/api/portraits/men/32.jpg', '2024-01-25 13:30:00', 1),
(3, 'Yasmine T.', 'Marrakech', 'En tant que collectionneuse de parfums, je peux affirmer que les créations de HACHA sont d\'une qualité exceptionnelle. L\'attention aux détails, du flacon à la fragrance, est remarquable.', 'https://randomuser.me/api/portraits/women/68.jpg', '2024-02-01 08:45:00', 1),
(4, 'Mohammed L.', 'Fès', 'Le service client de HACHA est à la hauteur de leurs parfums : exceptionnel. J\'ai reçu des conseils personnalisés qui m\'ont permis de trouver le parfum idéal.', 'https://randomuser.me/api/portraits/men/65.jpg', '2024-02-10 15:20:00', 1),
(5, 'Sophie D.', 'Paris', 'J\'ai découvert HACHA lors d\'un voyage au Maroc et j\'ai immédiatement été séduite par la richesse et la complexité de leurs fragrances. Je commande maintenant régulièrement en ligne.', 'https://randomuser.me/api/portraits/women/22.jpg', '2024-02-15 10:30:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `adresse` text,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`, `date_inscription`, `derniere_connexion`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@example.com', '$2y$10$abcdefghijklmnopqrstuuWzAC6Y0UVVSEFPEMVBEMuaB0aQJLvS6', '123 Rue de Paris', 'Paris', '75001', 'France', '+33612345678', '2024-01-15 09:30:00', NULL),
(2, 'Martin', 'Sophie', 'sophie.martin@example.com', '$2y$10$abcdefghijklmnopqrstuuWzAC6Y0UVVSEFPEMVBEMuaB0aQJLvS6', '456 Avenue des Champs-Élysées', 'Paris', '75008', 'France', '+33623456789', '2024-01-20 13:45:00', NULL),
(3, 'El Amrani', 'Karim', 'karim.elamrani@example.com', '$2y$10$abcdefghijklmnopqrstuuWzAC6Y0UVVSEFPEMVBEMuaB0aQJLvS6', '789 Boulevard Mohammed V', 'Casablanca', '20000', 'Maroc', '+212612345678', '2024-01-25 08:15:00', NULL),
(4, 'Benali', 'Leila', 'leila.benali@example.com', '$2y$10$abcdefghijklmnopqrstuuWzAC6Y0UVVSEFPEMVBEMuaB0aQJLvS6', '321 Rue des Jardins', 'Rabat', '10000', 'Maroc', '+212623456789', '2024-02-01 15:20:00', NULL),
(5, 'Garcia', 'Carlos', 'carlos.garcia@example.com', '$2y$10$abcdefghijklmnopqrstuuWzAC6Y0UVVSEFPEMVBEMuaB0aQJLvS6', '567 Calle Mayor', 'Madrid', '28001', 'Espagne', '+34612345678', '2024-02-10 10:30:00', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avis_produits` (`produit_id`),
  ADD KEY `fk_avis_utilisateurs` (`utilisateur_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_commandes_utilisateurs` (`utilisateur_id`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `parfums_personnalises`
--
ALTER TABLE `parfums_personnalises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parfums_personnalises_utilisateurs` (`utilisateur_id`),
  ADD KEY `fk_parfums_personnalises_commandes` (`commande_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produits_categories` (`categorie_id`);

--
-- Index pour la table `produit_ingredients`
--
ALTER TABLE `produit_ingredients`
  ADD PRIMARY KEY (`produit_id`,`ingredient_id`),
  ADD KEY `fk_produit_ingredients_ingredients` (`ingredient_id`);

--
-- Index pour la table `temoignages`
--
ALTER TABLE `temoignages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `parfums_personnalises`
--
ALTER TABLE `parfums_personnalises`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `temoignages`
--
ALTER TABLE `temoignages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_produits` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_avis_utilisateurs` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `fk_commandes_utilisateurs` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `parfums_personnalises`
--
ALTER TABLE `parfums_personnalises`
  ADD CONSTRAINT `fk_parfums_personnalises_commandes` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_parfums_personnalises_utilisateurs` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produits_categories` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `produit_ingredients`
--
ALTER TABLE `produit_ingredients`
  ADD CONSTRAINT `fk_produit_ingredients_ingredients` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_produit_ingredients_produits` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
