<?php ob_start(); ?>
<?php
require 'lib/config.php';

$kullanici = new g56('KULLANICI');
if ($kullanici->find("username = '" . g56::get('POST.username') . "' and password = '" . g56::get('POST.password') . "'")) {
	$kullanici->load("username = '" . g56::get('POST.username') . "' and password = '" . g56::get('POST.password') . "'");

	if (g56::exists('SESSION.error'))
		g56::clear('SESSION.error');

	$ok = 1; 
	g56::set('SESSION.ok', $ok);

	g56::set('SESSION.kullanici', $kullanici->username);
	g56::set('SESSION.password', $kullanici->password);
	g56::set('SESSION.id', $kullanici->id);
	g56::set('SESSION.kombi', $kullanici->kombi);
	g56::set('SESSION.klima', $kullanici->klima);
	g56::set('SESSION.adres', $kullanici->adres);
	
	g56::call('user/index.php');

} else {
	g56::set('SESSION.error', "KULLANICI YA DA ŞİFRE HATALI");
	g56::call('index.php');
}
?>
<?php ob_end_flush(); ?>
