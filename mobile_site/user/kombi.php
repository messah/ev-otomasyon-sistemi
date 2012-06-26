<?php ob_start(); ?>
<?php  
require '../lib/config.php';

$user = new g56('KULLANICI');
$user->load("id = '" . g56::get('SESSION.id') . "'");

if (isset($_POST['onay'])) { // checkbox seçilmişse "on" değeri gönderiliyor
    $user->kombi = 1 - $user->kombi;
    $user->save();
    g56::set('SESSION.kombi', $user->kombi);
}

g56::call('index.php');

?>
<?php ob_end_flush(); ?>
