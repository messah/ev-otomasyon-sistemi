<?php ob_start(); ?>
<?php  
require '../lib/config.php';

$user = new g56('KULLANICI');
$user->load("id = '" . g56::get('SESSION.id') . "'");

if (isset($_POST['onay2'])) { // checkbox seçilmişse "on" değeri gönderiliyor
    $user->klima = 1 - $user->klima;
    $user->save();
    g56::set('SESSION.klima', $user->klima);
}

g56::call('index.php');

?>
<?php ob_end_flush(); ?>
