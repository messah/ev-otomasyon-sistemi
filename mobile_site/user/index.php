<?php
// config
require '../lib/config.php';

// head // look at the body directory
$head = array('userhead.html','userlogo.html','error.html');

// body // look at the gui directory
$template = array('evbilgiler.html');

// footer // look at the body directory
$footer = array('footer.html');

g56::page($head, $template, $footer);
?>

