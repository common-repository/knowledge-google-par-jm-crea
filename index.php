<?php
/**
 * Plugin Name: Knowledge Google par JM Créa
 * Plugin URI: http://www.jm-crea.com
 * Description: Ajoutez vos liens vers les réseaux sociaux directement dans les résultats Google.
 * Version: 1.4
 * Author: JM Créa
 * Author URI: http://www.jm-crea.com
 */

//On créé la table mysql
function creer_table_kg() {
global $wpdb;
$table_kg = $wpdb->prefix . 'kg';
$req = "CREATE TABLE IF NOT EXISTS $table_kg (
id_kg int(11) NOT NULL AUTO_INCREMENT,
kg_actif text DEFAULT NULL,
kg_logo text DEFAULT NULL,
kg_tel text DEFAULT NULL,
kg_type_tel text DEFAULT NULL,
kg_type text DEFAULT NULL,
kg_nom text DEFAULT NULL,
kg_facebook text DEFAULT NULL,
kg_twitter text DEFAULT NULL,
kg_googleplus text DEFAULT NULL,
kg_instagram text DEFAULT NULL,
kg_linkedin text DEFAULT NULL,
UNIQUE KEY id (id_kg)
);";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $req );
}
//On insere les infos dans la table
function insert_table_kg() {
global $wpdb;
$table_kg = $wpdb->prefix . 'kg';
$wpdb->insert( 
$table_kg, 
array(
'id_kg'=>' ',
'kg_actif'=>'ON',
'kg_logo'=>'#',
'kg_tel'=>'#',
'kg_type_tel'=>'#',
'kg_type'=>'Organization',
'kg_nom'=>'#',
'kg_facebook'=>'http://',
'kg_twitter'=>'http://',
'kg_googleplus'=>'http://',
'kg_instagram'=>'http://',
'kg_linkedin'=>'http://'
), 
array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')
);
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}
register_activation_hook( __FILE__, 'creer_table_kg' );
register_activation_hook( __FILE__, 'insert_table_kg' );


//Appel du css
add_action( 'admin_enqueue_scripts', 'style_kg_jm_crea' );
function style_kg_jm_crea() {
wp_register_style('css_kg_jm_crea', plugins_url( 'css/style.css', __FILE__ ));
wp_enqueue_style('css_kg_jm_crea');	
}


//Affichage du formulaire
function kg_jmcrea_form() {

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
global $wpdb;
$table_kg = $wpdb->prefix . "kg";
$voir_kg = $wpdb->get_row("SELECT * FROM $table_kg WHERE id_kg='1'");

echo "<h1>Knowledge Google par JM Créa</h1>
<h2>Ajoutez vos liens vers les réseaux sociaux directement dans les résultats Google.</h2>";

//MAJ des paramètres
if (isset($_POST['maj'])) {
$kg_actif = stripslashes($_POST['kg_actif']);
$kg_logo = stripslashes($_POST['kg_logo']);
$kg_tel = stripslashes($_POST['kg_tel']);
$kg_type_tel = stripslashes($_POST['kg_type_tel']);
$kg_nom = stripslashes($_POST['kg_nom']);
$kg_type = stripslashes($_POST['kg_type']);
$kg_facebook = stripslashes($_POST['kg_facebook']);
$kg_twitter = stripslashes($_POST['kg_twitter']);
$kg_googleplus = stripslashes($_POST['kg_googleplus']);
$kg_instagram = stripslashes($_POST['kg_instagram']);
$kg_linkedin = stripslashes($_POST['kg_linkedin']);

global $wpdb;
$table_kg = $wpdb->prefix . "kg";
$wpdb->query($wpdb->prepare("UPDATE $table_kg SET kg_actif='$kg_actif',kg_logo='$kg_logo',kg_tel='$kg_tel',kg_type_tel='$kg_type_tel',kg_nom='$kg_nom',kg_type='$kg_type',kg_facebook='$kg_facebook',kg_twitter='$kg_twitter',kg_googleplus='$kg_googleplus',kg_instagram='$kg_instagram',kg_linkedin='$kg_linkedin'  WHERE id_kg='1'",APP_POST_TYPE));
echo '<script>document.location.href="admin.php?page=kg&tab=parametres&action=maj-ok"</script>';

}
if (isset($_GET['action'])&&($_GET['action'] == 'maj-ok')) {
echo '<div class="updated"><p>Knowledge Google mis à jour avec succès !.</p></div>';		
}

echo '<div class="wrap"><h2 class="nav-tab-wrapper">';

if ( (isset($_GET['tab']))&&($_GET['tab'] == 'parametres') ) {
echo '<a class="nav-tab nav-tab-active" href="' . admin_url() . 'admin.php?page=kg&tab=parametres">Pramètres</a>';
}
else {
echo '<a class="nav-tab" href="' . admin_url() . 'admin.php?page=kg&tab=parametres">Pramètres</a>';	
}
if ( (isset($_GET['tab']))&&($_GET['tab'] == 'autres_plugins') ) {
echo '<a class="nav-tab nav-tab-active" href="' . admin_url() . 'admin.php?page=kg&tab=autres_plugins">Mes autres plugins</a>';
}
else {
echo '<a class="nav-tab" href="' . admin_url() . 'admin.php?page=kg&tab=autres_plugins">Mes autres plugins</a>';	
}
echo '</h2></div>';


/* TABS PARAMETRES */
if ( (isset($_GET['tab']))&&($_GET['tab'] == 'parametres') ) {
echo "
<div id='cadre_blanc_kg'>
<form id='form1' name='form1' method='post' action=''>
<table border='0' cellspacing='8' cellpadding='0'>
<tr>
<td colspan='3'><h2>Paramétrage</h2></td>
</tr>
<tr>
<td>Activer ou désactiver Knowledge Google:</td>
<td>";
if ($voir_kg->kg_actif == 'ON') {
echo "
<input type='radio' name='kg_actif' id='radio' value='ON' checked='checked' /> ON 
<input type='radio' name='kg_actif' id='radio2' value='OFF' /> OFF ";
}
else {
echo "
<input type='radio' name='kg_actif' id='radio' value='ON' /> ON 
<input type='radio' name='kg_actif' id='radio2' value='OFF' checked='checked' /> OFF ";	
}
echo "
</td>
</tr>
<tr>
<td>URL de votre logo :</td>
<td><input name='kg_logo' type='text' id='kg_logo' value='" . $voir_kg->kg_logo . "'></td>
</tr>
<tr>
<td>Type de site :</td>
<td>
<select name='kg_type' id='kg_type'>";
if ($voir_kg->kg_type == 'Organization') {
echo "<option value='Organization'>Société</option>";
echo "<option value='Person'>Personnel</option>	";
}
else {
echo "<option value='Person'>Nom personnel</option>	";
echo "<option value='Organization'>Société</option>";
}
echo "
</select>
</td>
</tr>
<tr>
<td>Votre téléphone <code>Ex : +331-01-02-03-04</code>:</td>
<td><input name='kg_tel' type='text' id='kg_tel' value='" . $voir_kg->kg_tel. "'></td>
</tr>
<tr>
<td>Type de contact par téléphone :</td>
<td>
<select name='kg_type_tel' id='kg_type_tel'>
<option value='" . $voir_kg->kg_type_tel . "'>" . $voir_kg->kg_type_tel . "</option>
<option value='customer support'>customer support</option>
<option value='technical support'>technical support</option>
<option value='billing support'>billing support</option>
<option value='bill payment'>bill payment</option>
<option value='sales'>sales</option>
<option value='reservations'>reservations</option>
<option value='credit card support'>credit card support</option>
<option value='emergency'>emergency</option>
<option value='baggage tracking'>baggage tracking</option>
<option value='roadside assistance'>roadside assistance</option>
<option value='package tracking'>package tracking</option>
</select>
</td>
</tr>
<tr>
<td>Nom personnel ou de votre société :</td>
<td><input type='text' name='kg_nom' id='kg_nom' value='" . $voir_kg->kg_nom . "'></td>
</tr>

<tr>
<td>URL Facebook :</td>
<td><input type='text' name='kg_facebook' id='kg_facebook' value='" . $voir_kg->kg_facebook . "'></td>
</tr>
<tr>
<td>URL Twitter :</td>
<td><input type='text' name='kg_twitter' id='kg_twitter' value='" . $voir_kg->kg_twitter . "'></td>
</tr>
<tr>
<td>URL Google + : </td>
<td><input type='text' name='kg_googleplus' id='kg_googleplus' value='" . $voir_kg->kg_googleplus. "'></td>
</tr>
<tr>
<td>URL Instagram :</td>
<td><input type='text' name='kg_instagram' id='kg_instagram' value='" . $voir_kg->kg_instagram . "'></td>
</tr>
<tr>
<td>URL Linkedin :</td>
<td><input type='text' name='kg_linkedin' id='kg_linkedin' value='" . $voir_kg->kg_linkedin . "'></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan='3' align='right'><input type='submit' name='maj' id='maj' value='Mettre à jour' class='button button-primary' /></td>
</tr>
<tr>
<td colspan='3' align='right'>&nbsp;</td>
</tr>
</table>
</form>
</div>";
}

/* TABS AUTRES PLUGINS */
if ( (isset($_GET['tab']))&&($_GET['tab'] == 'autres_plugins') ) {
echo '
<div id="listing_plugins">
<h3>Social Share</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/social-share-par-jm-crea.jpg', __FILE__ ) . '" alt="Social Share par JM Créa" />
<p>Social Share par JM Créa vous permet de partager votre contenu sur les réseaux sociaux.</p>
<div align="center"><a href="https://fr.wordpress.org/plugins/social-share-by-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>

<div id="listing_plugins">
<h3>Search box Google</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/search-box-google-par-jm-crea.jpg', __FILE__ ) . '" alt="Search Box Google par JM Créa" />
<p>Search Box Google permet d’intégrer le mini moteur de recherche de votre site dans les résultats Google.</p>
<div align="center"><a href="https://fr.wordpress.org/plugins/search-box-google-par-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>

<div id="listing_plugins">
<h3>Notify Update</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/notify-update-par-jm-crea.jpg', __FILE__ ) . '" alt="Notify Update par JM Créa" />
<p> Notify Update par JM Créa vous notifie par email et sms (pour les abonnés freemobile) lors d’une mise à jour de votre WordPress.</p>
<div align="center"><a href="https://fr.wordpress.org/plugins/notify-update-par-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>


<div id="listing_plugins">
<h3>Notify Connect</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/notify-connect-par-jm-crea.jpg', __FILE__ ) . '" alt="Notify Connect par JM Créa" />
<p>Notify connect créé par JM Créa permet d’être notifié par email et sms (pour les abonnés freemobile) lorsqu’un admin se connecte sur l\'admin.</p>
<div align="center"><a href="https://fr.wordpress.org/plugins/notify-connect-par-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>


<div id="listing_plugins">
<h3>Simple Google Adsense</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/simple-google-adsense-par-jm-crea.jpg', __FILE__ ) . '" alt="Simple Google Adsense par JM Créa" />
<p>Simple Google Adsense par JM Créa permet d’afficher vos publicités Google Adsense avec de simples shortcodes.</p>
<div align="center"><a href="https://fr.wordpress.org/plugins/simple-google-adsense-par-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>

<div id="listing_plugins">
<h3>Scan Upload</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/scan-upload-par-jm-crea.jpg', __FILE__ ) . '" alt="Scan Upload par JM Créa" />
<p>Scan Upload par JM Créa détecte les fichiers suspects de votre wp-upload et permet de les supprimer en 1 clic.</p>
<div align="center"><a href="https://fr.wordpress.org/plugins/scan-upload-par-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>

<div id="listing_plugins">
<h3>Knowledge Google</h3>
<img src="' . plugins_url( 'autres-plugins-jm-crea/knowledge-google-par-jm-crea.jpg', __FILE__ ) . '" alt="Knowledge Google par JM Créa" />
<p>Knowledge Google par JM Créa permet d\'afficher les liens de vos réseaux sociaux directement dans les résultats Google.</p>
<div align="center"><a href="https://wordpress.org/plugins/knowledge-google-par-jm-crea/" target="_blank"><button class="button button-primary">Télécharger</button></a></div>
</div>';

}
elseif (!isset($_GET['tab'])) {
echo '<script>document.location.href="tools.php?page=kg&tab=parametres"</script>';
}

}


function afficher_kg() {
global $wpdb;
$table_kg = $wpdb->prefix . "kg";
$voir_kg = $wpdb->get_row("SELECT * FROM $table_kg WHERE id_kg='1'");

if ($voir_kg->kg_actif == 'ON') {
echo "\n<!-- KNOWLEDGE GOOGLE PAR JM CREA POUR WORDPRESS -->";
//Logo
if ($voir_kg->kg_logo) {
echo '
<script type="application/ld+json">
{
"@context": "http://schema.org",
"@type": "' . $voir_kg->kg_type . '",
"url": "' . get_site_url() . '",
"logo": "' .  $voir_kg->kg_logo . '"
}';
}
//Téléphone
echo '
{
"@context" : "http://schema.org",
"@type": "' . $voir_kg->kg_type . '",
"url": "' . get_site_url() . '",
"contactPoint" : [{
"@type" : "ContactPoint",
"telephone" : "' .  $voir_kg->kg_tel . '",
"contactType" : "' .  $voir_kg->kg_type_tel . '"
}]
}';
//Réseaux sociaux
echo '
{
"@context" : "http://schema.org",
"@type": "' . $voir_kg->kg_type . '",
"name" : "' . $voir_kg->kg_nom . '",
"url": "' . get_site_url() . '",
"sameAs" : [';
if ($voir_kg->kg_facebook !== 'http://') {	
echo  "\n" . '"' . $voir_kg->kg_facebook . '",';
}
if ($voir_kg->kg_twitter !== 'http://') {	
echo  "\n" . '"' . $voir_kg->kg_twitter . '",';
}
if ($voir_kg->kg_googleplus !== 'http://') {
echo  "\n" . '"' . $voir_kg->kg_googleplus . '",';
}
if ($voir_kg->kg_instagram !== 'http://') {	
echo  "\n" . '"' . $voir_kg->kg_instagram . '",';
}
if ($voir_kg->kg_linkedin !== 'http://') {	
echo  "\n" . '"' . $voir_kg->kg_linkedin . '"';
}
echo "\n";
echo ']
}
</script>';
echo "\n\n";	
}

}
add_action('wp_head', 'afficher_kg');

//On créé le menu
function menu_kg_jmcrea() {
add_submenu_page( 'tools.php', 'Knowledge Google', 'Knowledge Google', 'manage_options', 'kg', 'kg_jmcrea_form' ); 
}
add_action('admin_menu', 'menu_kg_jmcrea');


function head_meta_kg_jm_crea() {
echo("<meta name='Knowledge Google par JM Créa' content='1.4' />\n");
}
add_action('wp_head', 'head_meta_kg_jm_crea');
?>
