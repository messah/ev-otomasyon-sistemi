<?php
class MyMenu{
 	function show_menu(){
  		$obj =& get_instance();
  		$obj->load->helper('url');
  		$menu  = "<ul>";
  		$menu .= "<li>";
  		$menu .= anchor("ev/index","Ev Sistemleri");
  		$menu .= "</li>";
  		$menu .= "<li>";		
  		$menu .= anchor("ev/order","Ev Sistemlerini Düzenle");		
  		$menu .= "</li>";
  		$menu .= "<li>";		
  		$menu .= anchor("login/signup","Admin sayfası");		
  		$menu .= "</li>";
  		$menu .="<li>";		
  		$menu .= anchor("login/logout","Cikis");		
  		$menu .= "</li>";		
  		$menu .= "</ul>";
 
  		return $menu;
 	}
}
?>
