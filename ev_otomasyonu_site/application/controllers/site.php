<?php
class Site extends CI_Controller
{
	function __construct()//site classı her çağrıldığında otomatik çalışan fonksiyon
	{
		parent::__construct();
		$this->is_logged_in();//members_area her çağrıldığında öncelikle bu fonksiyon çalışacak
	}
	function members_area()
	{
		$this->load->view('members_area');
	}
	function is_logged_in()//giriş yapmış kullanıcı var ise members_area erişimine izin verecek aksi halde engelleyecek.
	{
		$is_logged_in = $this->session->userdata('is_logged_in');//Burada oturumdan is_logged_in değerini çekiyoruz. Eğer true dönerse bir kullanıcı giriş yapmış demektir.
		
		if(!isset($is_logged_in) || $is_logged_in != true)//is_logged_in set edilmiş mi ve set edildi ise değeri true mu? Cevabımız evet ise bu fonksiyon bir problem çıkarmıyor ve yolumuza devam edip sayfamıza erişiyoruz.
		{
			echo 'Bu sayfaya eri�im yetkiniz yok <a href="../login">Giri�</a>';//Aksi halde erişim yok uyarısı verip,
			die();//işlemi durduruyoruz.
		}
	}
}
?>