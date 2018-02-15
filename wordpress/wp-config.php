<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wordpressResto');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', '127.0.0.1:8889');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'L53<=O)L`9-bC6jSJZwT^ALDGb8RXvg:%X5o2FeGbN0DR/A9EP>j:Zzf7!o>OQ2<');
define('SECURE_AUTH_KEY',  'O@fBhLgv<0/3;_+^pHWx>btaO(Yl)`!B/Qf<Ks$2(xhE=Zeh;I$TA!YTgkgKy+,8');
define('LOGGED_IN_KEY',    '/#&?!.57NWK*pjxp+pBk%mBA8;p^)wMdg;aPUg3DXvvJx]#32tylZ/-bkBYPQEav');
define('NONCE_KEY',        '(.k;0g^~alU>9+a8C);R%[$2 &k!2P54c}S2,ic{TJUiZ1N6!q%r8d>f_EC6wngG');
define('AUTH_SALT',        'p. C_MKlX,XO/!1n6;*@~={(-l%mw#[pfK|oyBaN nG=~2?#3:SZ!Px]RwLOZlvF');
define('SECURE_AUTH_SALT', 'hv~06!k`7kStfyhPmAGoo^K>,HMf|^Db*4r,%[lY5Ey 6uGX@%]RIKVxkC?ER]+]');
define('LOGGED_IN_SALT',   'Qh[6t?3Y5nR!A-sJa|$J#DW@,k]V`&e7LArh~aq2e^Bl8tV1yAqev_:fG#;:77 /');
define('NONCE_SALT',       '}84@Z_$U?Mi`RW>h.blBXY]8ipd9(^{vUvBGP!*DFVBDm48OLOh5#{0b$5p}RRjz');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');