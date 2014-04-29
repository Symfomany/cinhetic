-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 21 Avril 2014 à 10:29
-- Version du serveur: 5.5.35-0ubuntu0.13.10.2
-- Version de PHP: 5.5.3-1ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `cinhetic`
--

-- --------------------------------------------------------

--
-- Structure de la table `actors`
--

CREATE TABLE IF NOT EXISTS `actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `lastname` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `city` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `nationality` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `biography` text CHARACTER SET utf8 COLLATE utf8_bin,
  `roles` text CHARACTER SET utf8 COLLATE utf8_bin,
  `recompenses` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `actors`
--

INSERT INTO `actors` (`id`, `firstname`, `lastname`, `dob`, `city`, `nationality`, `biography`, `roles`, `recompenses`, `date_created`) VALUES
(1, 'Ian', 'McKellen', '2013-02-10', 'New York', 'Américaine', '<p>Sir Ian McKellen, CH, KBE, n&eacute; le 25 mai 1939 &agrave; Burnley, est un com&eacute;dien britannique, actif dans le th&eacute;&acirc;tre classique et contemporain ainsi qu&#39;au cin&eacute;ma. Il est &eacute;galement connu pour son militantisme en faveur des droits des personnes LGBT. Parmi ses r&ocirc;les les plus connus, Ian McKellen interpr&egrave;te Gandalf dans les trilogies Le Seigneur des anneaux et Le Hobbit de Peter Jackson, et Magn&eacute;to dans la trilogie cin&eacute;matographique X-men.</p>', '<p>Acteur, Producteur, Com&eacute;dien, R&eacute;alisateur</p>', '<p>5 Oscars</p>', '2014-04-01 07:19:00'),
(2, 'Martin', 'Freeman', '1965-04-01', 'Birmingham', 'Anglaise', 'Martin John C. Freeman est un acteur britannique, né le 8 septembre 1971 à Aldershot, dans le comté de Hampshire, Angleterre (Royaume-Uni) . Il est connu principalement pour le rôle de Tim Canterbury dans la série britannique The Office qui a gagné un Golden Globe, du docteur Watson dans la série Sherlock, d''Arthur Dent dans H2G2 : Le Guide du voyageur galactique et de Bilbon Sacquet dans la trilogie Le Hobbit de Peter Jackson.\r\n', 'Acteur', '8 Oscars', '2014-04-02 13:37:00');

-- --------------------------------------------------------

--
-- Structure de la table `actors_movies`
--

CREATE TABLE IF NOT EXISTS `actors_movies` (
  `actors_id` int(150) NOT NULL,
  `movies_id` int(150) NOT NULL,
  PRIMARY KEY (`actors_id`,`movies_id`),
  KEY `movies_id` (`movies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `actors_movies`
--

INSERT INTO `actors_movies` (`actors_id`, `movies_id`) VALUES
(2, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `date_created`) VALUES
(1, 'Fantastique', 'Fantastiques et Magiques', '2014-04-03 00:00:00'),
(2, 'Action', '<p>Film d&#39;action</p>', NULL),
(3, 'Arts Martiaux', '<p>Film d&#39;Arts Martiaux</p>', NULL),
(4, 'Dramatique', '<p>Film dramatique</p>', NULL),
(5, 'Guerre', '<p>Film de guerre</p>', NULL),
(6, 'Horreur', '<p>Film d&#39;horreur</p>', NULL),
(7, 'Sciences-fictions', '<p>Film de sciences-fictions</p>', NULL),
(8, 'Thriller', '<p>Film&nbsp;Thriller</p>', NULL),
(9, 'Aventure', '<p>Film d&#39;aventure</p>', '2014-04-07 11:27:42'),
(12, 'Autobiographie', 'Film autobiographique français', '2014-04-07 21:01:32');

-- --------------------------------------------------------

--
-- Structure de la table `cinema`
--

CREATE TABLE IF NOT EXISTS `cinema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `cinema`
--

INSERT INTO `cinema` (`id`, `title`, `ville`, `date_created`) VALUES
(1, 'UGC', 'Paris 2eme', '2014-04-15 00:00:00'),
(2, 'Pathé', 'Paris 5eme', '2014-04-01 08:00:00'),
(3, 'Gaumont', 'Paris 15eme', '2014-04-02 00:00:00'),
(4, 'Le Grand Rex', 'Paris 2eme', '2014-04-01 00:00:00'),
(5, 'Espace Saint Michel', 'Paris 3eme', '2014-03-11 00:00:00'),
(6, 'Les 7 Parnassiens', 'Paris 4eme', '2014-03-24 09:25:00');

-- --------------------------------------------------------

--
-- Structure de la table `cinema_movies`
--

CREATE TABLE IF NOT EXISTS `cinema_movies` (
  `cinemas_id` int(11) NOT NULL,
  `movies_id` int(11) NOT NULL,
  PRIMARY KEY (`cinemas_id`,`movies_id`),
  KEY `movies_id` (`movies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cinema_movies`
--

INSERT INTO `cinema_movies` (`cinemas_id`, `movies_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `movies_id` int(11) DEFAULT NULL,
  `note` int(11) DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movies_id` (`movies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `movies_id`, `note`, `content`, `date_created`) VALUES
(1, 2, 1, 4, 'Film juste magnifique', '2014-03-18 00:00:00'),
(2, 2, 2, 4, 'Très beau film :)', '2014-03-24 15:00:00'),
(3, 2, 1, 5, 'Film inoubliable...', '2014-04-02 08:00:00'),
(4, 2, 1, 4, 'Film trop beau du début jusqu''à la fin', '2014-04-01 10:29:00'),
(5, NULL, 1, 2, 'sqdqsdqsd', '2014-04-09 09:43:32'),
(6, 2, 1, 1, 'qsdqsdqsd', '2014-04-09 09:50:59'),
(8, 2, 1, 2, 'Un joli film!', '2014-04-09 10:21:56'),
(9, 2, 1, 2, 'sdfsdfsdf', '2014-04-10 10:21:41'),
(10, 2, 1, 2, 'test alpha', '2014-04-10 16:46:14'),
(11, NULL, 2, 3, 'zeezrerzerez', '2014-04-11 15:18:18'),
(12, 2, 2, 2, 'Un joli film!', '2014-04-11 16:32:04'),
(13, 2, 2, 3, 'jhjbjbjhbjbjbj', '2014-04-12 09:07:56'),
(14, 2, 2, 2, 'qsdqsdqs', '2014-04-12 09:12:03'),
(15, 2, 1, 1, 'qsdqsdqsd', '2014-04-13 17:06:26');

-- --------------------------------------------------------

--
-- Structure de la table `directors`
--

CREATE TABLE IF NOT EXISTS `directors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `lastname` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `biography` text CHARACTER SET utf8 COLLATE utf8_bin,
  `note` float DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `directors`
--

INSERT INTO `directors` (`id`, `firstname`, `lastname`, `biography`, `note`, `date_created`) VALUES
(1, 'Peter', 'Jackson', 'Peter Jackson est un réalisateur, un producteur et un scénariste néo-zélandais né le 31 octobre 1961 à Wellington, en Nouvelle-Zélande. Il est surtout connu pour avoir réalisé la trilogie du Seigneur des anneaux, d''après l''œuvre de J. R. R. Tolkien, et un remake de King Kong. Il réalise ensuite Le Hobbit, l''adaptation cinématographique en trois volets du roman de J. R. R. Tolkien.\r\n', 4.5, '2014-04-01 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `directors_movies`
--

CREATE TABLE IF NOT EXISTS `directors_movies` (
  `directors_id` int(11) NOT NULL,
  `movies_id` int(11) NOT NULL,
  PRIMARY KEY (`directors_id`,`movies_id`),
  KEY `movies_id` (`movies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `directors_movies`
--

INSERT INTO `directors_movies` (`directors_id`, `movies_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movies_id` int(11) NOT NULL,
  `nature` int(11) DEFAULT NULL,
  `picture` text CHARACTER SET utf8 COLLATE utf8_bin,
  `video` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `medias`
--

INSERT INTO `medias` (`id`, `movies_id`, `nature`, `picture`, `video`) VALUES
(1, 0, 1, 'http://www.fond-ecran-wallpaper.fr/wallpapers/le-seigneur-des-anneaux-le-retour-du-roi-03.jpg', NULL),
(2, 0, 1, 'http://jolstatic.fr/www/captures/1885/4/53684.jpg', NULL),
(3, 0, 1, 'http://series-parlotte.eu/ressources/images/Film/LeSeigneurDesAnneaux_LaCommunauteDeLAnneau.jpg', NULL),
(4, 0, 1, 'http://image.toutlecine.com/photos/s/e/i/seigneur-des-anneaux-1-05-g.jpg', NULL),
(5, 0, 1, 'http://www.maxi-fond-ecran.com/fond-ecran/cinema/le_seigneur_des_anneaux_le_retour_du_roi_023.jpg', NULL),
(6, 0, 1, 'http://mondesimaginaires.m.o.pic.centerblog.net/725muiyh.jpg', NULL),
(7, 0, 2, '', '<iframe width="560" height="315" src="//www.youtube.com/embed/nalLU8i4zgs" frameborder="0" allowfullscreen></iframe>'),
(8, 0, 2, NULL, '<iframe width="560" height="315" src="//www.youtube.com/embed/tyQ2n6W78PM" frameborder="0" allowfullscreen></iframe>'),
(9, 0, 2, NULL, '<iframe width="420" height="315" src="//www.youtube.com/embed/BEm0AjTbsac" frameborder="0" allowfullscreen></iframe>');

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_film` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `synopsis` text CHARACTER SET utf8 COLLATE utf8_bin,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `image` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `trailer` text CHARACTER SET utf8 COLLATE utf8_bin,
  `categories_id` int(11) DEFAULT NULL,
  `languages` varchar(11) DEFAULT NULL,
  `distributeur` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `bo` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `budget` float DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `date_release` date DEFAULT NULL,
  `note_presse` float DEFAULT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  `cover` tinyint(4) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_id` (`categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `movies`
--

INSERT INTO `movies` (`id`, `type_film`, `title`, `synopsis`, `description`, `image`, `trailer`, `categories_id`, `languages`, `distributeur`, `bo`, `annee`, `budget`, `duree`, `date_release`, `note_presse`, `visible`, `cover`, `date_created`) VALUES
(1, 'Long-Metrage', 'Le Hobbit : Un voyage inattendu', 'Recruté par Gandalf le Gris, Bilbon Sacquet rejoint une bande de 13 nains dont le chef n''est autre que le légendaire guerrier Thorin Écu-de-Chêne qui cherche à reprendre le Royaume perdu des Nains d''Erebor, conquis par le redoutable dragon Smaug. Leur périple les conduit au coeur du Pays Sauvage, où ils devront affronter des Gobelins, des Orques, des Ouargues meurtriers, des Araignées géantes, des Métamorphes et des Sorciers... Bien qu''ils se destinent à mettre le cap sur l''est et les terres désertiques du Mont Solitaire, ils doivent d''abord échapper aux tunnels des Gobelins, où Bilbon rencontre la créature qui changera à jamais le cours de sa vie : Gollum. C''est là, sur les rives d''un lac souterrain, que le modeste Bilbon Sacquet non seulement se surprend à faire preuve d''un courage et d''une intelligence inattendus, mais qu''il parvient à mettre la main sur le "précieux" anneau qui recèle des pouvoirs cachés... Ce simple anneau d''or est lié au sort de la Terre du Milieu, sans que Bilbon s''en doute encore...\r\n', 'Recruté par Gandalf le Gris, Bilbon Sacquet rejoint une bande de 13 nains dont le chef n''est autre que le légendaire guerrier Thorin Écu-de-Chêne qui cherche à reprendre le Royaume perdu des Nains d''Erebor, conquis par le redoutable dragon Smaug. Leur périple les conduit au coeur du Pays Sauvage, où ils devront affronter des Gobelins, des Orques, des Ouargues meurtriers, des Araignées géantes, des Métamorphes et des Sorciers... Bien qu''ils se destinent à mettre le cap sur l''est et les terres désertiques du Mont Solitaire, ils doivent d''abord échapper aux tunnels des Gobelins, où Bilbon rencontre la créature qui changera à jamais le cours de sa vie : Gollum. C''est là, sur les rives d''un lac souterrain, que le modeste Bilbon Sacquet non seulement se surprend à faire preuve d''un courage et d''une intelligence inattendus, mais qu''il parvient à mettre la main sur le "précieux" anneau qui recèle des pouvoirs cachés... Ce simple anneau d''or est lié au sort de la Terre du Milieu, sans que Bilbon s''en doute encore...\nLe hobbit Bilbo BessacN 1 (Bilbo Baggins) mène une existence paisible dans son trou de Cul-de-Sac (Bag End) jusqu’au jour où il croise le magicien Gandalf. Le lendemain, il a la surprise de voir venir prendre le thé chez lui non seulement Gandalf, mais également une compagnie de treize nains menée par Thorin Lécudechesne (Thorin Oakenshield) et composée de Balin, Dwalin, Fili, Kili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur et Bombur. La compagnie est en route vers la Montagne Solitaire, où elle espère vaincre le dragon Smaug, qui a jadis dépossédé les nains de leur royaume et de leurs trésors. Cependant, pour mener à bien leurs projets, il leur faut un expert-cambrioleur, et Gandalf leur a recommandé Bilbo. Celui-ci est plus que réticent à l’idée de partir à l’aventure, mais il finit par accompagner la troupe.\n\nEn chemin pour les Montagnes de Brume (Monts Brumeux), la compagnie est capturée par trois trolls et ne s’en sort que grâce à l’astuce de Gandalf. Le magicien, connaissant le point faible de ces créatures, les distrait jusqu’à l’aube, moment où ils se transforment en pierre sous l’effet de la lumière du soleil. Dans le repaire des trolls, la compagnie découvre des épées de l’ancien royaume elfique de Gondolin. Thorin et Gandalf prennent chacun une épée, tandis que Bilbo reçoit une dague qu’il baptise par la suite Dard. Peu après, la compagnie atteint Fendeval (Rivendell), la demeure du semi-elfe Elrond, qui les aide à déchiffrer la carte du trésor de Smaug et les inscriptions runiques des épées.\n\n\n\nThorin et Cie à l’orée de Grand’Peur.\nUne fois dans les Montagnes de Brume, une tempête oblige la compagnie à se réfugier dans une caverne pleine de gobelins qui les prennent en chasse. Dans la confusion, Bilbo perd ses compagnons de vue. Après avoir découvert un mystérieux anneau, le hobbit parvient sur la berge d’un lac souterrain, où vit une créature nommée Gollum. Celui-ci le soumet à un jeu d’énigmes : si Gollum l’emporte, il pourra manger Bilbo ; dans le cas contraire, il conduira le hobbit jusqu’à la sortie. Bilbo remporte le concours en se demandant involontairement à haute voix « Qu’est-ce qu’il y a dans ma poche ? », question à laquelle Gollum ne parvient pas à répondre. Celui-ci n’a aucune intention de remplir sa part du marché et part à la recherche de son anneau pour tuer Bilbo, qui découvre que l’objet lui confère l’invisibilité lorsqu’il le passe au doigt. Grâce à lui, le hobbit parvient à s’enfuir des grottes et à rejoindre ses compagnons. Ils sont à nouveau pourchassés par un groupe de gobelins et de wargs, mais l’intervention des aigles géants leur permet de s’en sortir vivants.\n\nLa compagnie descend des montagnes et arrive à la demeure de Beorn, un homme qui peut se changer en ours. Beorn leur prête des armes et des poneys pour qu’ils puissent rejoindre la forêt de Grand’Peur (Mirkwood). Arrivés à l’orée des bois, Gandalf les quitte pour vaquer à ses propres affaires. Durant leur longue et pénible traversée de la forêt, les nains, épuisés et affamés, sont capturés à deux reprises, d’abord par des araignées géantes, puis par les elfes sylvains, mais dans les deux cas, Bilbo met à profit son anneau magique pour libérer ses compagnons.\n\n\n\nLa compagnie arrive finalement à l’établissement humain de Bourg-du-Lac (Lacville), où elle prend un peu de repos avant de se diriger vers la Montagne. Grâce à l’anneau, Bilbo se faufile jusqu''à la tanière du dragon et, après une conversation avec la créature, s’échappe en dérobant une coupe en or. Smaug s’en avise et, croyant le vol perpétré par les hommes de Bourg-du-Lac, se dirige vers la ville pour la détruire. L’archer Bard (Barde), héritier des princes du Val (Dale), parvient à le tuer : sa flèche noire trouve le seul point du ventre de Smaug que ne couvre pas son armure de pierres précieuses.\n\nLe trésor de Smaug n’a désormais plus de maître, et les hommes de Bourg-du-Lac comme les elfes de la Forêt se dirigent vers la Montagne. Ils découvrent que les nains ont renforcé les défenses, et Thorin refuse toute négociation, convaincu que le trésor tout entier lui revient de droit. Alors que les hommes et les elfes se préparent à attaquer la montagne, Bilbo se rend dans leur campement avec la Pierre Arcane (Arkenstone), l’objet du trésor le plus précieux aux yeux de Thorin. Le hobbit espère ainsi éviter un bain de sang inutile.\n\nLe lendemain arrivent des renforts nains conduits par Dain, le cousin de Thorin, qui persiste dans son refus de toute négociation. Les deux camps sont prêts à croiser le fer lorsqu’ils sont surpris par une immense armée de gobelins. Nains, elfes et hommes s’unissent alors pour les combattre lors de la bataille des Cinq Armées, qui semble perdue jusqu’à l’arrivée des aigles, ainsi que de Beorn. Celui-ci tue Bolg, le chef des gobelins, et leur armée, démoralisée, est aisément vaincue. La victoire est acquise, mais Thorin et ses neveux Fili et Kili trouvent la mort durant l’affrontement. Le trésor est réparti entre les vainqueurs, et Bilbo sort de son aventure plus riche de deux petits coffres, l’un rempli d’or et l’autre d’argent, ainsi que de l’anneau magique.\n\nContexte[modifier | modifier le code]\n\n\nLe Val et la Montagne Solitaire.\nLe royaume sous la Montagne est fondé en l’an 1999 du Troisième Âge par les nains du peuple de Durin, qui ont dû fuir leur demeure ancestrale de la Moria quelques années auparavant. Ils connaissent une grande prospérité en commerçant avec les hommes du Val, cité établie au pied de la Montagne, ainsi qu’avec les elfes de Grand’Peur. Leur richesse attire l’attention du dragon Smaug, qui attaque la Montagne en 2770. Les nains sont décimés, la cité du Val anéantie, et les quelques survivants du désastre, dont le roi Thror, son fils Thrain et son petit-fils Thorin, doivent s’enfuir et sont réduits à une vie de misère et d’errance. Ils s’établissent dans les Montagnes Bleues2.\n\nUn siècle avant les événements du Hobbit, en 2841, Thrain, devenu roi, décide de retourner à la Montagne. En chemin, il est capturé et emprisonné à Dol Guldur, où on lui extorque le dernier des Sept anneaux des Nains. Neuf ans plus tard, le magicien Gandalf pénètre en secret à Dol Guldur. Il y découvre par hasard le vieux nain à l’agonie, qui lui remet la carte et la clef de la Montagne avant de mourir. Gandalf découvre également que le maître de Dol Guldur n’est autre que Sauron, le Seigneur des Ténèbres. Il tente de convaincre le Conseil Blanc d’attaquer la forteresse avant qu’il ne soit redevenu trop puissant, mais le chef du Conseil, Saroumane, s’y oppose. Peu après, ce dernier commence à rechercher l’Anneau unique dans les Champs aux Iris3.\n\nEn réalité, l’Anneau ne s’y trouve plus depuis plusieurs siècles : le hobbit Déagol l’a découvert dans les Champs aux Iris vers 2460, pour être aussitôt assassiné par son cousin Sméagol. Celui-ci utilise l’Anneau à mauvais escient et finit par être chassé par son peuple. Il se réfugie dans les cavernes des Montagnes de Brume. L’Anneau prolonge son existence de plusieurs siècles et en fait une créature corrompue et contrefaite, Gollum3.', NULL, '<iframe width="560" height="315" src="//www.youtube.com/embed/5xpcwquIpRQ" frameborder="0" allowfullscreen></iframe>', 1, 'fr', 'Warner Bros', 'VOST', 2012, 1325150, 3, '2014-04-15', 4, 1, 1, '2014-04-02 09:22:22'),
(2, 'Long Metrage', 'Le Seigneur des anneaux : La Communauté de l''anneau', 'Sur la Terre du Milieu, dans la paisible Comté, vit le Hobbit Frodon Sacquet. Comme tous les Hobbits, Frodon est un bon vivant, amoureux de la terre bien cultivée et de la bonne chère. Orphelin alors qu''il n''était qu''un enfant, il s''est installé à Cul-de-Sac chez son oncle Bilbon, connu de toute la Comté pour les aventures extraordinaires qu''il a vécues étant jeune et les trésors qu''il en a tirés. Le jour de ses 111 ans, Bilbon donne une fête grandiose à laquelle est convié le puissant magicien Gandalf le Gris. C''est en ce jour particulier que Bilbon décide de se retirer chez les Elfes pour y finir sa vie. Il laisse en héritage à Frodon son trou de Hobbit ainsi qu''un mystérieux anneau qu''il a autrefois trouvé dans une galerie souterraine des Monts Brumeux et qui a le pouvoir de rendre invisible quiconque le porte à son doigt.\r\n', 'Sur la Terre du Milieu, dans la paisible Comté, vit le Hobbit Frodon Sacquet. Comme tous les Hobbits, Frodon est un bon vivant, amoureux de la terre bien cultivée et de la bonne chère. Orphelin alors qu''il n''était qu''un enfant, il s''est installé à Cul-de-Sac chez son oncle Bilbon, connu de toute la Comté pour les aventures extraordinaires qu''il a vécues étant jeune et les trésors qu''il en a tirés. Le jour de ses 111 ans, Bilbon donne une fête grandiose à laquelle est convié le puissant magicien Gandalf le Gris. C''est en ce jour particulier que Bilbon décide de se retirer chez les Elfes pour y finir sa vie. Il laisse en héritage à Frodon son trou de Hobbit ainsi qu''un mystérieux anneau qu''il a autrefois trouvé dans une galerie souterraine des Monts Brumeux et qui a le pouvoir de rendre invisible quiconque le porte à son doigt.\r\n\r\nGandalf est intrigué par l''anneau laissé à Frodon et surtout par les circonstances confuses dans lesquelles Bilbon l''a trouvé. Après avoir lu le récit de la vie d''Isildur, un ancien roi de l''Arnor et du Gondor, il découvre que cet objet n''est autre que l''Anneau unique forgé il y a bien longtemps par Sauron, le Seigneur des Ténèbres, et qui fut perdu 3000 ans auparavant. Cet anneau maléfique est une arme redoutable qui permettrait au seigneur du Mordor de régner sur la Terre du Milieu et de réduire tous ses peuples en esclavage. Gandalf relate alors à Frodon la malédiction de l''Anneau et l''informe que les serviteurs de Sauron sont déjà en route pour retrouver le précieux objet. Il lui demande de l''emporter en secret à Fondcombe, demeure de l''Elfe Elrond, où l''on pourra prendre une décision à son sujet, pendant que lui-même va consulter Saroumane, le supérieur de son ordre.Sur la Terre du Milieu, dans la paisible Comté, vit le Hobbit Frodon Sacquet. Comme tous les Hobbits, Frodon est un bon vivant, amoureux de la terre bien cultivée et de la bonne chère. Orphelin alors qu''il n''était qu''un enfant, il s''est installé à Cul-de-Sac chez son oncle Bilbon, connu de toute la Comté pour les aventures extraordinaires qu''il a vécues étant jeune et les trésors qu''il en a tirés. Le jour de ses 111 ans, Bilbon donne une fête grandiose à laquelle est convié le puissant magicien Gandalf le Gris. C''est en ce jour particulier que Bilbon décide de se retirer chez les Elfes pour y finir sa vie. Il laisse en héritage à Frodon son trou de Hobbit ainsi qu''un mystérieux anneau qu''il a autrefois trouvé dans une galerie souterraine des Monts Brumeux et qui a le pouvoir de rendre invisible quiconque le porte à son doigt.\r\n\r\nGandalf est intrigué par l''anneau laissé à Frodon et surtout par les circonstances confuses dans lesquelles Bilbon l''a trouvé. Après avoir lu le récit de la vie d''Isildur, un ancien roi de l''Arnor et du Gondor, il découvre que cet objet n''est autre que l''Anneau unique forgé il y a bien longtemps par Sauron, le Seigneur des Ténèbres, et qui fut perdu 3000 ans auparavant. Cet anneau maléfique est une arme redoutable qui permettrait au seigneur du Mordor de régner sur la Terre du Milieu et de réduire tous ses peuples en esclavage. Gandalf relate alors à Frodon la malédiction de l''Anneau et l''informe que les serviteurs de Sauron sont déjà en route pour retrouver le précieux objet. Il lui demande de l''emporter en secret à Fondcombe, demeure de l''Elfe Elrond, où l''on pourra prendre une décision à son sujet, pendant que lui-même va consulter Saroumane, le supérieur de son ordre.\r\n\r\n\r\n\r\nL''Anneau unique.\r\nArrivé à Orthanc, demeure de Saroumane, Gandalf s''aperçoit que celui-ci est passé du côté de Sauron, et il est emprisonné après avoir été vaincu dans un duel de magie. Frodon prend la route vers l''est, accompagné de Samsagace Gamegie (Sam), son jardinier, et de ses deux cousins Meriadoc Brandebouc (Merry) et Peregrin Touque (Pippin). Traqués par les Nazgûls, esprits servants de l''Anneau, les quatre Hobbits gagnent le village de Bree et y rencontrent le Rôdeur surnommé Grands-Pas, qui s''avère être Aragorn, héritier légitime du royaume du Gondor. Cet homme mystérieux a été informé par Gandalf de la nature de leur mission et se propose de les conduire jusqu''à Fondcombe. Après maints périls (Frodon étant notamment gravement blessé par le Roi-Sorcier d''Angmar, chef des Nazgûls, sur le Mont Venteux), ils arrivent grâce à l''aide d''Arwen, fille d''Elrond aimée d''Aragorn, à Fondcombe et participent tous, avec Gandalf (qui a réussi à s''évader) et des ambassadeurs venus de différentes contrées, à un Conseil secret organisé par Elrond. Les débats sur l''Anneau sont houleux mais la décision est finalement prise de tenter de détruire ce fléau en le jetant dans le feu de la Montagne du Destin, volcan situé au cœur même du Mordor.\r\n\r\nFrodon est chargé de porter l''Anneau et huit compagnons vont le protéger dans cette tâche : Gandalf, l''Elfe Legolas, le Nain Gimli, les Hommes Boromir et Aragorn, et les Hobbits Sam, Merry et Pippin. La Communauté de l''Anneau commence ce long voyage vers le sud-est par l''ascension du col de Caradhras, dans laquelle ils échouent, et se voient alors contraints de traverser les mines de la Moria, ancien royaume des Nains. Ils y sont poursuivis par des Orques, puis par un Balrog, ancien et puissant démon que Gandalf arrête au prix de sa vie, les deux adversaires tombant dans des abysses sans fond. Le reste de la communauté arrive dans la Lothlórien, territoire des Elfes, où ils sont accueillis par Galadriel, qui offre à Frodon une fiole lumineuse.\r\n\r\nPoursuivant sa route à bord d''embarcations sur le fleuve Anduin, la communauté est traquée par des Uruk-hai envoyés par Saroumane alors que Boromir, corrompu par l''Anneau, essaie de le prendre à Frodon. Ce dernier fait comprendre à Aragorn qu''il faut qu''il continue seul sa route vers le Mordor, et Aragorn le laisse partir alors que les Uruks-hais les rattrapent. Boromir, qui a retrouvé ses esprits, protège Merry et Pippin avant d''être finalement mortellement blessé par Lurtz, le chef des Uruks-hais. Aragorn tue ensuite Lurtz et, après la mort de Boromir, décide de partir sur les traces des Uruks-hais qui ont enlevé Merry et Pippin, accompagné par Legolas et Gimli. Pendant ce temps, Sam retrouve Frodon et part avec lui pour le Mordor.', NULL, '<iframe width="420" height="315" src="//www.youtube.com/embed/qx6RR5tPcGg" frameborder="0" allowfullscreen></iframe>', 1, 'fr', 'Warner Bros', 'VOST', 2001, 2153220, 3, '2015-04-02', 4.5, 1, 0, '2014-04-02 12:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `related_movies`
--

CREATE TABLE IF NOT EXISTS `related_movies` (
  `movies_id` int(11) NOT NULL,
  `movies_id_related` int(11) NOT NULL,
  PRIMARY KEY (`movies_id`,`movies_id_related`),
  KEY `movies_id_related` (`movies_id_related`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `related_movies`
--

INSERT INTO `related_movies` (`movies_id`, `movies_id_related`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movies_id` int(11) DEFAULT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `date_session` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movies_id` (`movies_id`),
  KEY `movies_id_2` (`movies_id`),
  KEY `cinema_id` (`cinema_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `sessions`
--

INSERT INTO `sessions` (`id`, `movies_id`, `cinema_id`, `date_session`) VALUES
(1, 1, 2, '2014-04-09 12:00:00'),
(2, 1, 4, '2014-04-09 14:00:00'),
(3, 2, 3, '2014-04-24 14:00:00'),
(4, 2, 5, '2014-04-24 10:00:00'),
(5, 1, 6, '2014-04-12 20:00:00'),
(6, 1, 1, '2014-04-12 22:00:00'),
(7, 2, 2, '2014-04-17 15:00:00'),
(8, 2, 1, '2014-04-17 17:00:00'),
(9, 2, 4, '2014-04-18 11:00:00'),
(10, 2, 6, '2014-04-18 15:00:00'),
(11, 1, 6, '2015-04-02 12:06:00');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(400) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `tags`
--

INSERT INTO `tags` (`id`, `word`) VALUES
(1, 'Hobbit'),
(2, ' La Communauté de l''anneau'),
(3, 'Terre du Milieu'),
(4, 'Gollum'),
(5, 'Gondor'),
(6, 'Frodon Sacquet'),
(7, ' magicien Gandalf'),
(8, 'Tolkien'),
(9, 'Fondcombe'),
(10, 'la Comté'),
(11, 'Orques'),
(12, 'hobbit');

-- --------------------------------------------------------

--
-- Structure de la table `tags_movies`
--

CREATE TABLE IF NOT EXISTS `tags_movies` (
  `movies_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`movies_id`,`tags_id`),
  KEY `tags_id` (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tags_movies`
--

INSERT INTO `tags_movies` (`movies_id`, `tags_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 4),
(1, 5),
(2, 5),
(2, 6),
(1, 7),
(1, 8),
(2, 8),
(1, 9),
(2, 9),
(1, 10),
(2, 10),
(1, 11),
(2, 11);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ville` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `tel` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `expired` tinyint(1) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `username_canonical` varchar(255) DEFAULT NULL,
  `email_canonical` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COMMENT '(DC2Type:array)',
  `extras` text,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `credentials_expired` tinyint(1) DEFAULT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `ville`, `zipcode`, `tel`, `ip`, `enabled`, `last_login`, `expired`, `locked`, `username_canonical`, `email_canonical`, `salt`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `extras`, `longitude`, `latitude`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`) VALUES
(2, 'julien@meetserious.com', 'julien', 'paOTOYatQy9M50y4wYEf5OJNAfu12f0yed++gl7maL9buXWpE8OUi5SakZCm2jnd0q7REJUVmspxvmrqo4scrg==', 'Lyon', 69005, '0674585648', '127.0.0.1', 1, '2014-04-21 11:13:11', 0, 0, 'julien', 'julien@meetserious.com', 'btel3h204q8swo8gwswkkosgk08s480', NULL, NULL, NULL, 'a:0:{}', NULL, NULL, NULL, 0, NULL, '2014-04-03 10:27:30', '2014-04-03 10:27:30');

-- --------------------------------------------------------

--
-- Structure de la table `user_favoris`
--

CREATE TABLE IF NOT EXISTS `user_favoris` (
  `user_id` int(11) NOT NULL,
  `movies_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`movies_id`),
  KEY `movies_id` (`movies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_favoris`
--

INSERT INTO `user_favoris` (`user_id`, `movies_id`) VALUES
(2, 1),
(2, 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `actors_movies`
--
ALTER TABLE `actors_movies`
  ADD CONSTRAINT `actors_movies_ibfk_1` FOREIGN KEY (`actors_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actors_movies_ibfk_2` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cinema_movies`
--
ALTER TABLE `cinema_movies`
  ADD CONSTRAINT `cinema_movies_ibfk_1` FOREIGN KEY (`cinemas_id`) REFERENCES `cinema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cinema_movies_ibfk_2` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`);

--
-- Contraintes pour la table `directors_movies`
--
ALTER TABLE `directors_movies`
  ADD CONSTRAINT `directors_movies_ibfk_1` FOREIGN KEY (`directors_id`) REFERENCES `directors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `directors_movies_ibfk_2` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `related_movies`
--
ALTER TABLE `related_movies`
  ADD CONSTRAINT `related_movies_ibfk_1` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `related_movies_ibfk_2` FOREIGN KEY (`movies_id_related`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tags_movies`
--
ALTER TABLE `tags_movies`
  ADD CONSTRAINT `tags_movies_ibfk_1` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tags_movies_ibfk_2` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_favoris`
--
ALTER TABLE `user_favoris`
  ADD CONSTRAINT `user_favoris_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_favoris_ibfk_2` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
