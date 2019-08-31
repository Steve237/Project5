-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 01 août 2019 à 23:47
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `monblog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `titre_article` char(50) NOT NULL,
  `pseudo_auteur` char(30) NOT NULL,
  `descriptif_article` char(200) NOT NULL,
  `contenu` text NOT NULL,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_liste_article` char(50) NOT NULL,
  `image_article` char(50) NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre_article`, `pseudo_auteur`, `descriptif_article`, `contenu`, `date_modification`, `image_liste_article`, `image_article`) VALUES
(1, 'Martin Luther King', 'Essama237', 'Martin Luther King Jr, né à Atlanta le 15 janvier 1929 et mort assassiné le 4 avril 1968 à Memphis, est un pasteur baptiste afro-américain, militant non-violent pour les droits civiques des Noirs.', 'Il organise et dirige des actions telles que le boycott des bus de Montgomery pour défendre le droit de vote, la déségrégation et l\'emploi des minorités ethniques. Il prononce un discours célèbre le 28 août 1963 devant le Lincoln Memorial à Washington durant la marche pour l\'emploi et la liberté : « I have a dream ». Il est soutenu par John Kennedy dans la lutte contre la ségrégation raciale aux États-Unis ; la plupart de ces droits seront promus par le Civil Rights Act et le Voting Rights Act sous la présidence de Lyndon B. Johnson.\r\n\r\nMartin Luther King devient le plus jeune lauréat du prix Nobel de la paix en 1964 pour sa lutte non-violente contre la ségrégation raciale et pour la paix. Il commence alors une campagne contre la guerre du Viêt Nam et la pauvreté, qui prend fin en 1968 avec son assassinat officiellement attribué à James Earl Ray, dont la culpabilité et la participation à un complot sont toujours débattues.\r\n\r\nIl se voit décerner à titre posthume la médaille présidentielle de la Liberté par Jimmy Carter en 1977, le prix des droits de l\'homme des Nations unies en 1978, la médaille d\'or du Congrès en 2004, et est considéré comme l\'un des plus grands orateurs américains1. Depuis 1986, le Martin Luther King Day est un jour férié aux États-Unis.', '2019-07-28 15:29:44', 'public/img/portfolio/martin_luther_king.jpeg', 'public/img/portfolio/martin_luther_king.jpeg'),
(5, 'Malcolm X', 'Essama237', 'Malcolm X, né Malcolm Little le 19 mai 1925 à Omaha (Nebraska) et mort assassiné le 21 février 1965 à Harlem, est un prêcheur musulman afro-américain.', 'Aux yeux de ses supporteurs, il est un défenseur impliqué des droits des Afro-Américains ayant mis en accusation le gouvernement fédéral des États-Unis pour sa ségrégation de la communauté noire6. En revanche, ses détracteurs l\'accusent d\'avoir alimenté une forme de racisme, le suprémacisme noir et la violence7,8,9,10,11.\r\n\r\nNé Malcolm Little, il adopte le pseudonyme de Malcolm X lors de son passage en 1952 au sein du mouvement Nation of Islam. Il s\'éloigne finalement de celui-ci en 1964, principalement en raison de désaccords sur la passivité de l\'organisation dans le combat contre la ségrégation raciale. Il évolue alors, peu avant sa mort, vers des positions socialistes et internationalistes. Il est assassiné le 21 février 1965 par trois militants de Nation of Islam mais une possible implication du FBI est évoquée12.', '2019-07-30 19:44:19', 'public/img/portfolio/malcolm.jpg', 'public/img/portfolio/malcolm.jpg'),
(6, 'Nelson Mandela', 'Essama237', 'Nelson Rolihlahla Mandela, né le 18 juillet 1918 à Mvezo (province du Cap) et mort le 5 décembre 2013 à Johannesburg, est un homme d\'État sud-africain', ' il a été l\'un des dirigeants historiques de la lutte contre le système politique institutionnel de ségrégation raciale (apartheid) avant de devenir président de la République d\'Afrique du Sud de 1994 à 1999, à la suite des premières élections nationales non ségrégationnistes de l\'histoire du pays.\r\n\r\nNelson Mandela entre au Congrès national africain (ANC) en 19434, afin de lutter contre la domination politique de la minorité blanche et la ségrégation raciale imposée par celle-ci. Devenu avocat, il participe à la lutte non-violente contre les lois de l\'Apartheid, mises en place par le gouvernement du Parti national à partir de 1948. L\'ANC est interdit en 1960 et, comme la lutte pacifique ne donne pas de résultats tangibles, Mandela fonde et dirige la branche militaire de l\'ANC, Umkhonto we Sizwe, en 1961, qui mène une campagne de sabotage contre des installations publiques et militaires. Le 5 août 1962, il est arrêté par la police sud-africaine sur indication de la CIA, puis est condamné à la prison et aux travaux forcés à perpétuité lors du procès de Rivonia. Dès lors, il devient un symbole de la lutte pour l\'égalité raciale et bénéficie d\'un soutien international croissant.\r\n\r\nAprès vingt-sept années d\'emprisonnement dans des conditions souvent très dures[réf. souhaitée], et après avoir refusé d\'être libéré pour rester en cohérence avec ses convictions, Mandela est relâché le 11 février 1990. S\'inspirant alors de la pensée ubuntu dans laquelle il a été élevé, il soutient la réconciliation et la négociation avec le gouvernement du président Frederik de Klerk. En 1993, il reçoit avec ce dernier le prix Nobel de la paix pour avoir conjointement et pacifiquement mis fin au régime de l\'apartheid et jeté les bases d\'une nouvelle Afrique du Sud démocratiqueN 1.\r\n\r\nAprès une transition difficile où de Klerk et lui évitent une guerre civile entre les partisans de l\'apartheid, ceux de l\'ANC et ceux de l\'Inkhata à dominante zoulou, Nelson Mandela devient le premier président noir d\'Afrique du Sud en 1994. Il mène une politique de réconciliation nationale entre Noirs et Blancs ; il lutte contre les inégalités économiques, mais néglige le combat contre le sida, en pleine expansion en Afrique du Sud. Après un unique mandat, il se retire de la vie politique active, mais continue à soutenir publiquement le Congrès national africain tout en condamnant ses dérives.\r\n\r\nImpliqué par la suite dans plusieurs associations de lutte contre la pauvreté ou contre le sida, il demeure une personnalité mondialement reconnue en faveur de la défense des droits de l\'homme. Il est salué comme le père d\'une Afrique du Sud multiethnique et pleinement démocratique, qualifiée de « nation arc-en-ciel », même si le pays souffre d\'inégalités économiques, de tensions sociales et de replis communautaires.', '2019-07-30 19:50:49', 'public/img/portfolio/nelson_mandela.jpg', 'public/img/portfolio/nelson_mandela.jpg'),
(7, 'Patrice Lumumba', 'Essama237', 'D\'employé des postes à Premier ministre du Congo indépendant en quelques années  : Patrice Lumumba a mis toute ses forces dans la lutte contre le colonialisme, ne reculant devant aucun sacrifice', 'Autodidacte, charismatique et idéaliste, Patrice Lumumba a su fédérer les aspirations indépendantistes des Congolais. Son combat à mort contre le colonialisme lui a valu une reconnaissance bien au-delà des frontières de son pays, fondant un véritable mythe Lumumba.\r\n\r\nLe 30 janvier 1960, les images de son discours lors des cérémonies d\'indépendance font le tour du monde. \"Nul Congolais ne pourra oublier que l\'[indépendance] a été conquise par la lutte, une lutte qui fut de larmes, de feu et de sang \", déclare-t-il, avant de détailler en présence du roi des Belges Baudouin les injustices subies par les Congolais pendant la période coloniale.\r\n\r\nLumumba a rédigé, tout au long de sa vie, articles, essais et discours qui précisent sa pensée politique, s\'attaquant aussi bien à des sujets de société qu\'aux destins du Congo et de l\'Afrique. Ses écrits et sa personnalité ont inspiré des générations d\'intellectuels et activistes anti-impérialistes d\'Afrique et d\'ailleurs, dont son contemporain Aimé Césaire (Une saison au Congo, 1966).', '2019-07-30 20:10:49', 'public/img/portfolio/patrice-lumumba.jpg', 'public/img/portfolio/patrice-lumumba.jpg'),
(8, 'Rosa Parks', 'Essama237', 'Rosa Parks, née le 4 février 1913 à Tuskegee, en Alabama, et morte le 24 octobre 2005 à Détroit, est une femme qui devint une icone de la lutte contre le racisme.', 'Elle est devenue célèbre le 1er décembre 1955, à Montgomery (Alabama) en refusant de céder sa place à un passager blanc dans l\'autobus conduit par James F. Blake. Arrêtée par la police, elle se voit infliger une amende de 15 dollars. Le 5 décembre 1955, elle fait appel de ce jugement.\r\n\r\nUn jeune pasteur noir de 26 ans, Martin Luther King, avec le concours de Ralph Abernathy, lance alors une campagne de protestation et de boycott contre la compagnie de bus qui durera 380 jours. Le 13 novembre 1956, la Cour suprême des États-Unis casse les lois ségrégationnistes dans les bus, les déclarant anticonstitutionnelles.', '2019-07-30 20:22:09', 'public/img/portfolio/rosa_parks.jpg', 'public/img/portfolio/rosa_parks.jpg'),
(9, 'Thomas Sankara', 'Essama237', 'Thomas Sankara, né le 21 décembre 1949 et mort assassiné le 15 octobre 1987, est un homme d\'État anti-impérialiste, chef du Burkina Faso, de 1983 à 1987.', 'l est le président du pays durant la période de la première révolution burkinabè du 4 août 1983 au 15 octobre 1987, qu\'il finit par totalement incarner. Durant ces quatre années, il mène à marche forcée, et y compris en recourant à la répression de certains syndicats ou organisations politiques rivales, une politique d\'émancipation nationale (qui passe par exemple par le changement du nom de Haute-Volta issu de la colonisation en un nom issu de la tradition africaine : Burkina Faso, qui est un mélange de moré et de dioula et signifie Pays [ou Patrie] des hommes intègres), de développement du pays, de lutte contre la corruption ou encore de libération des femmes.\r\n\r\nIl est abattu lors d\'un coup d\'État qui amène au pouvoir Blaise Compaoré, le 15 octobre 1987. Son souvenir reste vivace dans la jeunesse burkinabé mais aussi plus généralement en Afrique, qui en a fait une icône, un « Che Guevara africain », aux côtés notamment de Patrice Lumumba.', '2019-07-30 20:30:11', 'public/img/portfolio/thomas_sankara.jpg', 'public/img/portfolio/thomas_sankara.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `pseudo_auteur_commentaire` char(50) NOT NULL,
  `contenu_commentaire` text NOT NULL,
  `date_creation_commentaire` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `id_article` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
