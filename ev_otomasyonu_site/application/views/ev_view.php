<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css"  href="<?php echo $base.'css/'.$css?>"><!-- Css dosyamızı burada include ettik -->
</head>
 
<body>
<div id="header">
<?php $this->load->view('ev_header'); ?><!-- header dosyamızı burada include ettik -->
</div>
<div id="menu">
<?php 	$this->load->view('ev_menu'); ?><!-- menü dosyamızı burada include ettik -->
</div>

<h3>Ev Otomasyonu</h3> 
<table border="1">
<tr><th>İsim</th><th>şifre</th><th>kombi</th><th>klima</th><th>Adres</th><th>Düzenle</th><th>Sil</th></tr>
<?php foreach($orders as $row){ ?>
<tr>
<td>
<?php echo $row->username;?>
</td>
<td>
<?php echo $row->password;?>
</td>
<td>
<?php if($row->kombi)
{
	echo "Evet";
}
else
{
	echo "Hayır";
}
?>
</td>
<td>
<?php if($row->klima)
{
	echo "Evet";
}
else
{
	echo "Hayır";
}
?>
</td>


<td>
<?php echo $row->adres;?>
</td>
<td>
<?php echo anchor('ev/order/'.$row->id,'Düzenle');?>
</td>
<td>
<?php echo anchor('ev/del/'.$row->id,'Sil') ;?>
</td>
</tr>
<?php } ?>
 
</table>

<div id="footer">
<?php $this->load->view('ev_footer'); ?><!-- footer dosyamızı burada include ettik -->
</div>

</body>
</html>
