<?
require 'lib/config.php';

// head
$head = array('head.html','logo.html','error.html');

// body
$template = array('userlogin.html');

// footer
$footer = array('footer.html');

// page
g56::page($head, $template, $footer);

$ok = 0; 
g56::set('SESSION.ok', $ok);

?>
