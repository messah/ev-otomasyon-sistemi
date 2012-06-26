<?php
 
class Ev extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$this->load->model('ev_model');
		$data=$this->ev_model->genel();
		$data['orders']=$this->ev_model->get_all_orders();
		$this->load->view('ev_view',$data);
/*
 
		$this->load->model('ev_model');//pizza_model classımızı projemize yüklüyoruz.
		$data['orders']=$this->ev_model->get_all_orders();//get_all_orders fonksiyonunu çağırıyoruz ve sonucu $data değişkenimize atıyoruz.
		$data+=$this->ev_model->genel();		
		$this->load->view('ev_view',$data);
*/
		
	}
	
	function order($id = 0)
	{
		$this->load->helper('form');//form oluşturabilmek için form yardımcısını yüklüyoruz. 
		$this->load->helper('html');//html tagları için html helper kütüphanesini yükledik.
		$this->load->model('ev_model');
		
		if($this->input->post('mysubmit'))//formda sumbit tuşuna basıldığında çalışacak fonksiyon
		{
			if($this->input->post('id')){
				$this->ev_model->order_update();
			}
			else{
				$this->ev_model->insert_new_entry();  //yeni elemanı database eklemek için model dosyamızı çağırıyoruz
		    }
		}
 
		$data=$this->ev_model->genel();
		if((int)$id > 0){// id sıfırdan büyükse, mevcut siparişi düzenleyeceğimiz anlamına geliyor.
 
			$query = $this->ev_model->get_specific_order($id);//model dosyamızdaki fonksiyonumuzu çağırıyoruz.
			$data['temiz_id']['value'] = $query['id'];//tablodan verileri çekip arraya atıyoruz.
			$data['temiz_username']['value'] = $query['username'];
			$data['temiz_password']['value'] = $query['password'];
			
			if($query['kombi']=='yes'){
			$data['temiz_kombi']['checked'] = TRUE;
			}else{
			$data['temiz_kombi']['checked'] = FALSE;	  
			}
			if($query['klima']=='yes'){
			$data['temiz_klima']['checked'] = TRUE;
			}else{
			$data['temiz_klima']['checked'] = FALSE;	  
			}
			$data['temiz_adres']['value'] = $query['adres'];
			
 
	}
		$this->load->view('ev_order',$data);
	}
	
	function a_ev($id='1') //veri tabanın özel veri çekmeye yarar.
	{
		$data['title']='akıllı ev sistemleri';
		$data['header']='<h1>Ev Otomasyonu Projesi</h1>';
		$data['footer']='© eren_ozdemir';
 
		$this->load->model('ev_model');
		$data['orders']=$this->ev_model->get_specific_order($id);
 
		$this->load->view('ev_view',$data);
	}
	
	function get_method($username='',$unit='')
	{
		$data['title']='akıllı ev sistemleri';
		$data['header']='<h1>Ev Otomasyonu Projesi</h1>';
		if(!$username || !$unit)
		{
			$data['orders']='Düzenleme Yok';
		}
		else
		{
			$data['orders']='Adı: '.$username.' Adedi: '.$unit;
		}
 
		$this->load->view('ev_view',$data);
 
	}
	function del($id){
		$this->load->model('ev_model');//model dosyamızı yükledik.
 
		if((int)$id > 0){//eğer id sıfırdan büyükse ilgili datayı silmek için delete fonksiyonunu id ile çağırıyoruz.
			$this->ev_model->delete($id);
		}
 
		$data = $this->ev_model->genel();//sonra kalan siparişleri ekrana yazabilmek için index() fonksiyonunda yaptığımız işlemleri yapıyoruz.
		$data['orders'] = $this->ev_model->get_all_orders();
 
		$this->load->view('ev_view',$data);    
	}
 
}
?>
