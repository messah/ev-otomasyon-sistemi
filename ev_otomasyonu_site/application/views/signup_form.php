<h1>Hesap Yarat</h1>

<fieldset id="signup_form">
	<legend>Kişisel Bilgiler</legend>
	
	<?php
	
	echo form_open('login/create_member');
	echo form_input('first_name',set_value('first_name','Adın'));
	echo form_input('last_name',set_value('last_name','Soyadın'));
	echo form_input('email_address',set_value('email_address','Email Adresin'));
	?>

</fieldset>
<fieldset id="signup_form">
	<legend>Kullanıcı Bilgileri</legend>
	
	<?php
	
	echo form_open('login/create_member');
	echo form_input('user_name',set_value('user_name','Kullanıcı Adın'));
	echo form_input('password',set_value('password','Şifre'));
	echo form_input('password2',set_value('password2','Şifre Tekrar'));
	
	echo form_submit('submit','Hesap Yarat');
	
	?>
	
	<?php echo validation_errors('<p class="error">');?>
	<p><?php echo anchor('site/members_area',form_submit('','Çıkış'));?></p>
</fieldset>

<?php $this->load->view('includes/info.php');?>
