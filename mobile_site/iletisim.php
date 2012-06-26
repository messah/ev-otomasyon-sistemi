<?php
require 'lib/config.php';


// head // error and session // menu
$head = array('head.html', 'logo.html', 'error.html');

// body
$template = array('iletisim.html');

// footer
$footer = array('footer.html');

// page
g56::page($head, $template, $footer);
?>
