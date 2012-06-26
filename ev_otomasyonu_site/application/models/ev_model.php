<?php
class Ev_model extends CI_Model
{
	 function __construct()
     {
         parent::__construct();
         $this->load->database();//database bağlantısı yapıyoruz.
     }
 
	function get_all_orders()
	{
		$query = $this->db->get('KULLANICI');//pizza tablosundaki bütün verileri çekiyoruz.
		return $query->result();//sonucu return ediyoruz.
	}
	function get_specific_order($id)
	{
		$query = $this->db->get_where('KULLANICI',array('id'=>$id));//id = 1 olan verileri seçiyoruz sadece.
		return $query->row_array();		

	}
	function genel()
	{
		$data['title']='akıllı ev sistemleri';
		$data['header']='<h1>Ev Otomasyonu Projesi</h1>';
		$data['footer']='© eren_ozdemir';
		
		$data['base']		= $this->config->item('base_url');//projemizin ana dizinini çekiyoruz.
		$data['css']		= $this->config->item('css');	//css dosyamızı çekiyoruz
		
		$this->load->library('MyMenu');//kütüphanemizi yüklüyoruz.
		$menu = new MyMenu; //classımızdan yeni bir obje oluşturuyoruz.
		$data['menu'] = $menu->show_menu();//objenin fonksiyonunu çağırarak menümüzü döndürüyoruz.
		
		$data['temiz_id']['value']=0;
		$data['temiz_kombi']['value']=0;
		$data['temiz_klima']['value']=0;
		
		$data['username']	 		= 'İsminiz  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
		$data['password']	 		= 'Şifreniz &nbsp&nbsp&nbsp&nbsp&nbsp';
		$data['kombi']	 	    	= 'Kombi Aç-Kapa &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
		$data['klima']	 			= 'Klima Aç-Kapa &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
		$data['adres']	 			= 'Adres &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
		
		//$data['temiz_id']       = array('name'=>'id',
		//								'size'=>30);
		$data['temiz_username']		= array('name'=>'username',
										'size'=>30);
		$data['temiz_password']		= array('name'=>'password',
										'size'=>30);								
										
		$data['temiz_kombi']= array('name'=>'kombi',
									'value'=>'yes',  
									'checked'=>TRUE );
		$data['temiz_klima']= array('name'=>'klima',
									'value'=>'yes',  
									'checked'=>TRUE );	
																							
		$data['temiz_adres']	= array('name'=>'adres',
										'rows'=>5,
										'cols'=>30);							
 
		$data['baslik']  = 'Kullanıcı Ekleme'; 
		return $data;
	}
	function insert_new_entry()
	{
 
		$data = array(
		 'username'=>$this->input->post('username'),
		 //'password'=>md5($this->input->post('password')),
		 'password'=>$this->input->post('password'),
		 'kombi'=>$this->input->post('kombi')=='yes'?1:0,
		 'klima'=>$this->input->post('klima')=='yes'?1:0,
		 'adres'=>$this->input->post('adres'),
 
/*
		 'cost'=>'20' //daha sonra bunun hesabı için fonksiyon yazılabilir.
*/
		 );
		  $this->db->insert('KULLANICI',$data); 
	}
	function order_update(){
		$data = array(
/*
		  'id'=>$this->input->post('id'),	
*/
          'username'=>$this->input->post('username'),//formdaki verileri teker teker arraya atıyoruz
          'password'=>$this->input->post('password'),
		  'kombi'=>$this->input->post('kombi')=='yes'?1:0,
		  'klima'=>$this->input->post('klima')=='yes'?1:0,
		  'adres'=>$this->input->post('adres'),
/*
		  'cost'=>'20',//burası dediğimiz gibi fiyat hesaplayan bir fonksiyon yazarak halledilebilir.
*/
        );
		$this->db->where('id',$this->input->post('id'));//id=$id olan satırı buluyoruz.
		$this->db->update('KULLANICI',$data);  //ve bu satırı $data arrayı ile güncelliyoruz.
	}
	function delete($id){
		$this->db->delete('KULLANICI', array('id' => $id)); //id = "bizim gönderdiğimiz id" olan verileri siliyor.
	}
	
}
?>
