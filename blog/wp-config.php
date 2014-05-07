<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'cinhetic');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'djscrave');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'JA=L(sHqHP8re)l>t}o].{n]3+?*xb52N#7)+WGLI;0w={&djMokd(yrxmY?4+?q');
define('SECURE_AUTH_KEY',  '[uv8#_q,,3-$gvl`6vW:%g=Q/,UYA~dsF<[mn9!-aON.z_DwsW<#AJaN?|hMVjKF');
define('LOGGED_IN_KEY',    '-m+I@6z?3.Qy)X~:$gAasaDg5t=JKb7?Sqm}eBxS%?=T2y=+V6B@[Yh#ZW#~p|lI');
define('NONCE_KEY',        'S+C?cpaa%)4}u~:|c=9aW1Ve$6[R^[s.h~|<_4Oj}[47|:jt%}=UMUhBuFie[-<O');
define('AUTH_SALT',        '-j+tRI~AwGFY&>~7D@S|}M{)9i9U~4Chyx$loswrg;1;D[B,F6Nww0.|ywx#nWL?');
define('SECURE_AUTH_SALT', 'H,z`?e>E$BNu|#X?7k@-ibvPIAV4y^m$|~Xbkw+fC(|I+=MFFqs`1#ON,Bb4l|Vo');
define('LOGGED_IN_SALT',   'A5OSN#FC_3yQ~p&jiq(|;MEpc!d;SC.o,Hv#e+)vIzZBZ<F#cv^h4|h`/nE53dCF');
define('NONCE_SALT',       'k3[/^8_J(KfKT3nB7W &M2x3)#f^CKr~z-)n>ELl+@z+[M*+dVM A|<mlW(?*jiI');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');