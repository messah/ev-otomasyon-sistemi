<?php
require 'g56.php';

if (!strlen(session_id())) {
	//Veri tabanı bağlantısı için adres yolu verilir
	//g56::config(g56::path() . "lib/g56.ini");
	g56::config("/home/xxx/public_html/xxx/xxx/xxx");
	session_start();
}

// kick
g56::run();
?>
