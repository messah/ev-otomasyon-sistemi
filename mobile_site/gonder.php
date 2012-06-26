<?php ob_start(); ?>
<?php 
require 'lib/config.php';

//formdan gelen bilgileri bu sayfaya çektik
$isim=$_POST['name'];
$mail=$_POST['email'];
$konu=$_POST['subject'];
$icerik=$_POST['Body'];

$emailadresi="kendi e-mail adresinizi yazin.";
$emailkonusu=$konu;  //gönderilen e-mailde konu olarak ne görünmesiniz istiyorsaniz buraya onu yazin.
//$emailkonusu="Site iletisim Formu"; 

//bos alanlari kontrol ediyoruz..
if (empty($isim) or empty($konu) or empty($mail) or empty($icerik)){  //burayi kendinize göre çogaltabilirsiniz
	g56::set('SESSION.error', "LÜTFEN TÜM ALANLARI DOLDURUNUZ");
	g56::call('iletisim.php');
}

elseif(!empty($mail) and !preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>]+\.+[a-z]{2,6}))$#si',$mail)){
		g56::set('SESSION.error', "GEÇERSİZ MAİL ADRESİ");
		g56::call('iletisim.php');

}

//bos alan yok ise asagidan da e-mail gönderilecektir.
else { 
	$emailicerigi="
	isim: $isim    
	E-Mail: $mail
	Konu: $konu  
	İçerik: $icerik";  
	if(mail($emailadresi,$emailkonusu,$emailicerigi)){
		//bu uyari yazisida mail gönderildiginde çikacaktir..
		if(g56::get('SESSION.ok') == 1 ){
			g56::call('user/index.php');
		}else{
			g56::call('index.php');
		} 	
		
	}
} 

?>
<?php ob_end_flush(); ?>
