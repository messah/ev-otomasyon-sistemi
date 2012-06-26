<?php

// PHP 5'de çalışan bir class çalışması
// gdemir => gFe => g56


class g56 {

    private $table;
    private $fields;
    private $empty;
    static $global;
    static $_ini;

    public function __construct($_table) {

		$this->table = $_table;

		// example init
		//
		// $admin = new g56("ADMIN");
		// $admin->name = "foo";
		// $admin->password = "secret";
		// $admin->super = 1;
		// $admin->save(); // insert into table. see : save()

		$this->fields = self::get_fields();
		$this->empty = true;
	}

	// example serve_root
	//
	// project place : /var/www/bilet-x
	// serve root :    www.foo.com/bilet-x

	public static function serve_root() {
		return 'http://' . $_SERVER['SERVER_NAME'] . '/' . self::root();
	}

	// example path
	//
	// project place : /var/www/bilet-x
	// access place :  /var/www/bilet-x/foo  or
	//                 /var/www/bilet-x/bar  or
	//                 /var/www/bilet-x
	// path : "/var/www/bilet-x"

	public static function path() {
		return $_SERVER['DOCUMENT_ROOT'] . '/' . self::root();
	}

	// example path
	//
	// project place : /var/www/bilet-x
	// access place :  /var/www/bilet-x/foo  or
	//                 /var/www/bilet-x/bar  or
	//                 /var/www/bilet-x
	// root : "bilet-x"

	public static function root() {
		$root = '';
		$split = preg_split(
			'/\//', $_SERVER['SCRIPT_NAME']
			);
		return (count($split) > 1) ? $split[1] . '/' : '';
	}

	// exapmle get_form
	//
	// $_POST["name"] = "hop";
	// $_POST["password"] = "pop";
	// $_POST["super"] = 1;
	// $admin->get_form($_POST);
	// echo $admin->password;
	// $admin->save(); // insert to table

	public function get_form($fields) {
		foreach ($fields as $name => $value)
			if (array_key_exists($name, $this->fields))
				$this->fields[$name] = $value;
			else
				die("tabloda böyle bir key bulunmamaktadır!");
	}

	// load fields in the '$this->fields'
	//

	private function get_fields() {
		$_temp = array();
		foreach (SQLdb::fields($this->table) as $field)
			$_temp[$field] = '';
		return $_temp;
	}

	// exapmle find
	//
	// if ($admin->find("name = 'kill'"))
	//        echo "bu isimde bir admin var";
	// else
	//        echo "bu isimde bir admin yok!";

	public function find($units) {
		return self::_lookup($units) ? true : false;
	}

	// look, do you have ?
	//

	private function _lookup($units) {
		return SQLdb::select($this->table, $units);
	}

	// example load
	// $admin = new g56("ADMIN");
	// $admin->load("name = 'kill'");
	// echo $admin->password;
	// $admin->name = "foo";
	// $admin->save(); // update to table

	public function load($units) { // ok
		foreach (self::_lookup($units) as $_name => $_value)
			$this->fields[$_name] = $_value;
		$this->empty = false;
	}

	// example erase
	//
	// $admin->load("admin_name = 'kill'");
	// echo $admin->admin_password;
	// $admin->erase();

	public function erase() {
		$_fields = '';
		foreach ($this->fields as $field => $value)
			$_fields .= ($_fields? ' and ' : '') . ($field . '="' . $value . '"');
		SQLdb::erase($this->table, $_fields);
	}

	// example save
	//
	// see, load and get_form

	public function save() {
		if (!$this->empty) {
			$_sets = '';
			$_keys = '';
			$_key = SQLdb::key($this->table);
			foreach ($this->fields as $field => $value)
				if ($_key == $field)
					$_keys .= ($_keys ? ',' : '') . ($field . '="' . $value .'"');
				else
					$_sets .= ($_sets ? ',' : '') . ($field . '="' . $value .'"');
			//print $_sets;
			SQLdb::update($this->table, $_sets, $_keys);
		} else {
			$_fields = '';
			$_values = '';
			foreach ($this->fields as $field => $value) {
				$_fields .= ($_fields ? ',' : '') . $field;
				$_values .= ($_values ? ',' : '') . '"' . $value . '"';
			}
			SQLdb::save($this->table, $_fields, $_values);
		}
	}

	// example call
	//
	// g56::call('login.html');

	public static function call($page) {
		header('Location: ' . $page);
	}

	// example get
	//
	// $name = g56::get('POST.name');
	// $pass = g56::get('SESSION.password');

	public static function get($name) { //tekrar var  düzenlenmeli bk: set
		if (($part = self::_lookvalid($name)))
			if (isset(self::$global[$part[0]][$part[1]]))
				return self::$global[$part[0]][$part[1]];
		return null;
	}

	// example set
	//
	// g56::set('POST.name', 'kill');
	// g56::set('SESSION.password', '12894789127');

	public static function set($name, $value) { //tekrar var düzenlenmeli bk : get
		if (($part = self::_lookvalid($name)))
			self::$global[$part[0]][$part[1]] = $value;
	}

	// example clear
	//
	// if (g56::exists('SESSION.error'))
	//     g56::clear('SESSION.error');

	public static function clear($name) {
		if (($part = self::_lookvalid($name)))
			unset(self::$global[$part[0]][$part[1]]);
	}

	// if SESSION.x or POST.x return true
	//

	private static function _lookvalid($name) {
		$part = explode('.', $name);
		if (count($part) == 2)
			if (array_key_exists($part[0], self::$global))
				return array($part[0], $part[1]);
		return null;
	}

	// example exists
	//
	// if (g56::exists('SESSION.error'))
	//     echo g56::get('SESSION.error');

	public static function exists($name) {
		return self::get($name) ? true : false;
	}

	//
	// Framework kick!
	//

	public static function run() {
		self::$global = array(
				'SESSION' => &$_SESSION, // DIKKAT! adres alınmalı.
				'POST'    => &$_POST,
				'FILES'   => &$_FILES,
				);
	}

	public function __get($name) {
		if (array_key_exists($name, $this->fields))
			return $this->fields[$name];
		else
			die("Tabloda böyle  bir $name key (anahtar) mevcut değil<br/>");
	}

	public function __set($name, $value) {
		if (array_key_exists($name, $this->fields))
			$this->fields[$name] = $value;
		else
			die("Tabloda böyle bir $name $value key/value için key mevcut değil<br/>");
	}

	// example rows
	//
	// $admin = new g56("ADMIN");
	// $adminler = $admin->rows("admin_id = '1'");
	// foreach ($adminler['items'] as $indis => $admin)
	//   foreach ($admin as $key => $value)
	//	   echo $key . " : " . $value ;
	//
	//  or
	//
	// $admin = new g56("ADMIN");
	// $adminler = $admin->rows();
	// foreach ($adminler['items'] as $indis => $admin)
	//   foreach ($admin as $key => $value)
	//	   echo $key . " : " . $value ;
	//
	//  or
	//
	// $admin = new g56("ADMIN");
	// $adminler = $admin->rows("admin_id = '1'", "name, super");
	// foreach ($adminler['items'] as $indis => $admin)
	//   foreach ($admin as $key => $value)
	//	   echo $key . " : " . $value ;
	//

	public function rows($_units = NULL, $_request = NULL) {
		return SQLdb::rows($this->table, $_units, $_request);
	}

	// example img_small
	//
	// g56::img_small('old_image.jpg', 'new_image.jpg', 250);

	public static function img_small($_old_img, $_new_img, $_withd) {
		Image::small($_old_img, $_new_img, $_withd);
	}

	// example img_upload
	//
	// $file = g56::get('FILES.file');
	// g56::img_upload('resim', $file, 'new-img.jpg');

	public static function img_upload($_dest, $_file, $_img_name) {
		return Image::upload($_dest, $_file, $_img_name);
	}
	public static function img_wh($_old_img) {
		return Image::withd_height($_old_img);
	}

	// example config
	//
	// g56::config('.g56.ini');
	// gdemir@hummer$ cat .g56.ini
	// DB.user=root
	// DB.name=bilet_x
	// DB.password=****
	// DB.host=localhost

	public static function config($file) {
		$_file = file($file);
		self::$_ini = array(
			'DB' => array(
				'name' => '',
				'user' => '',
				'password' => '',
				'host' => '',
				),
			'BODY' => '',
			'GUI' => '',
			);
		foreach ($_file as $row) {
			if ($row[0] == ';' || $row == "\n") continue;
			$part = preg_split(
				'/[\. | \=]/', $row
				);
			if (array_key_exists($part[0], self::$_ini))
				if (count($part) == 3) {
					$part[2] = trim($part[2]);
					self::$_ini[$part[0]][$part[1]] = $part[2];
				} elseif (count($part) == 2) {
					$part[1] = trim($part[1]);
					self::$_ini[$part[0]] = $part[1];
				}
		}
		$_connect = self::$_ini['DB'];
		SQLdb::connect(
				$_connect['host'],
				$_connect['user'],
				$_connect['password'],
				$_connect['name']
				);
	}

	//
	// example page
	//
	// // head
	// head = array('head.htm', 'session.htm', 'menu.htm', 'error.htm');
	//
	// // body
	// $template = array('template.htm');
	//
	// // footer
	// $footer = array('footer.htm');


	//Gerekli yollar gösterilmelidir.
	public static function page($head, $template, $footer) {
		foreach ($head as $item)
			//include self::path() . self::$_ini['BODY'] . '/' . $item;
			include '/home/xxx/public_html/xxx/' . self::$_ini['BODY'] . '/' . $item;
		foreach ($template as $item)
			//include self::path() . self::$_ini['GUI'] . '/' . $item;
			include '/home/xxx/public_html/xxx/' . self::$_ini['GUI'] . '/' . $item;
		foreach ($footer as $item)
			//include self::path() . self::$_ini['BODY'] . '/' . $item;
			include '/home/xxx/public_html/xxx/' . self::$_ini['BODY'] . '/' . $item;
	}
}

class SQLdb {

	public static function key($_table) {
		return mysql_fetch_field(mysql_query('select * from '. $_table))->name;
	}
	public static function query($ask) {
		return mysql_query($ask);
	}
	public static function fields($_table) {
		$result = mysql_query('select * from ' . $_table);
		$_fields = array();
		while ($field = mysql_fetch_field($result))
			array_push($_fields, $field->name);
		return $_fields;
	}
	public static function rows($_table, $_fields = NULL, $_request = NULL) {
		$_requests = ($_request) ? $_request : '*';
		$_finds = ($_fields) ? ' where ' . $_fields : '';
		$result = mysql_query('select ' . $_requests . ' from ' . $_table . $_finds);
		$_rows = array(
			'items' => array(),
			'count' => null
			);
		while ($row = mysql_fetch_assoc($result))
			array_push($_rows['items'], $row);
		$result = mysql_fetch_assoc(mysql_query('select count(*) from ' . $_table . $_finds));
		$_rows['count'] = $result['count(*)'];
		return $_rows;
	}
	public static function select($_table, $_units) {
		return mysql_fetch_assoc(mysql_query('select * from ' . $_table . ' where '. $_units));
	}
	public static function erase($_table, $_units) {
		return mysql_query('delete from ' . $_table . ' where '. $_units);
	}
	public static function save($_table, $_fields, $_values) {
		if (!(is_null($_fields) && is_null($_fields) && is_null($_values)))
			mysql_query(
				'insert into ' . $_table .
				          ' (' . $_fields . ') ' .
				     'values(' . $_values . ')'
			);
	}
	public static function update($_table, $_sets, $_keys) {
		if (!(is_null($_table) && is_null($_sets) && is_null($_keys)))
			mysql_query(
				'update ' . $_table .
				  ' set ' . $_sets .
				' where ' . $_keys
			);
	}
	public static function connect($_host, $_user, $_pass, $_name) {
		if (!($connector = mysql_connect($_host, $_user, $_pass)))
			die("error : db user or password is wrong<br/>");
		if (!mysql_select_db($_name, $connector))
			die("error : dbname is wrong<br/>");
		mysql_query('set names "utf8"');
		mysql_query('set character set "utf8"'); // dil secenekleri
		mysql_query('set collation_connection = "utf8_general_ci"');
		mysql_query('set collation-server = "utf8_general_ci"');
	}
}

class Image {
	public static function small($old_img, $new_img, $withd) {
		$img = imagecreatefromjpeg($old_img);
		$x = imagesx($img);
		$y = imagesy($img);
		$height = floor($y * ($withd / $x));
		$make_new_img = imagecreatetruecolor($withd, $height);
		imagecopyresized($make_new_img, $img, 0, 0, 0, 0, $withd, $height, $x, $y);
		imagejpeg($make_new_img, $new_img);
	}
	public static function upload($dest = "resim",  $file, $_uploadname) {
		$_realfile   = $file['tmp_name'];
		$_uploadsize = $file['size'];
		$_uploadtype = $file['type'];
		$dest = g56::path() . $dest . "/" . $_uploadname;

		if (empty($file))
			return "Resim yok";

		if (is_uploaded_file($_realfile)) {
			if ($_uploadtype != 'image/jpeg') {
				return "Resim jpeg formatında olmalıdır.";
			} else if ($_uploadsize > 600000) {
				return "Resim çok büyük.";
			} else if (file_exists($dest . "/" . $_uploadname)) {
				return "Resim zaten kaydedilmiş";
			} else if (!move_uploaded_file($_realfile, $dest)) {
				return "Dosya yükleme hatası.";
			} else
				return null;
		} else {
			return "Dosya geçerli bir yükleme değil";
		}
		return "Geçerli bir resim yok";
	}
	public static function withd_height($old_img) {
		$img = imagecreatefromjpeg($old_img);
		return array(
			'withd' => imagesx($img),
			'height' => imagesy($img),
			);
	}
}

// DEMO :
// require 'lib/g56.php';
// g56::config('.g56.ini');
?>
