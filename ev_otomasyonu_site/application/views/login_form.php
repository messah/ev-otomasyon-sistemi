<div id="login_form"><!--id olarak login_form diyoruz ki daha sonra hazırlayacağımız css dosyasıyla burayı düzenleyebilelim-->
	<h1> Giriş!</h1>
	
	<?php
	
		echo form_open('login/validate_credentials');//Submit edildiğinde login.php altındaki validate_credentials fonksiyonu çağrılacak ve kullanıcının doğruluğunu kontrol edecek.
		echo form_input('username','Kullanıcı Adı');//Kullanıcı Adı Alanı
		echo form_password('password','Şifre');//Password Alanı
		echo form_submit('submit','Giriş');//Giriş Butonu
/*
		echo anchor('login/signup','Yeni Kayıt');//Yeni Kullanıcı Kayıt Butonu
*/
	
	?>
</div>
<?php $this->load->view('includes/info.php');?>
