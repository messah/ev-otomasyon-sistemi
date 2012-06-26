<?php ob_start(); ?>
<?php
require '../lib/config.php';

if(g56::get('SESSION.ok') == 1 ){	

$user = new g56('KULLANICI');
$user->load("id = '" . g56::get('SESSION.id') . "'");

	if (g56::exists('SESSION.error'))
		g56::clear('SESSION.error');
		
	g56::set('SESSION.kombi', $user->kombi);
	g56::set('SESSION.klima', $user->klima);
	
	g56::call('index.php');

}else{
	g56::call('../index.php');
} 

?>
<?php ob_end_flush(); ?>
