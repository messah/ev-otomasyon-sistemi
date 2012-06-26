<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" 
      href="<?php echo $base.'css/'.$css?>">
</head>
<body>
<div id="header">
<?php $this->load->view('ev_header'); ?>
</div>
<div id="menu">
<?php 	$this->load->view('ev_menu'); ?>
</div>
 
<?php echo heading($baslik,2) ?>

<?php echo form_open('ev/order'); ?>

<?php echo form_hidden ('id',$temiz_id['value']).br(); ?> 

<?php echo $username.':'.form_input($temiz_username).br(); ?>

<?php echo $password.':'.form_input($temiz_password).br(); ?>
  
<?php echo $kombi.':'.form_checkbox($temiz_kombi).br(); ?> 

<?php echo $klima.':'.form_checkbox($temiz_klima).br(); ?> 

<?php echo $adres.':'.form_textarea($temiz_adres).br(); ?> 

<?php echo form_submit('mysubmit','Düzenle!');  ?>
<?php echo form_close(); ?>
 
<div id="footer">
<?php $this->load->view('ev_footer'); ?>
</div>
 
</body>
</html>
