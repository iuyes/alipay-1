<?php 

class ws_alipay_db{
	//private $wpdb;
	private $al_chr_clt;
	private $al_prefix;
	private $tbls = array('products', 'orders', 'templates');
	
	function __construct(){
		include_once( ABSPATH . '/wp-admin/includes/upgrade.php');
		global $wpdb;
		
		
		if($wpdb->supports_collation()){
			if(!empty($wpdb->charset)){
				$charset_collate  = "DEFAULT CHARACTER SET $wpdb->charset "; 
			}
			if(!empty($wpdb->collate)){
				$charset_collate .= "COLLATE $wpdb->collate";
			}
		}
		
		
		//if( WPLANG == 'zh_CN')
			//$wpdb->query( "SET time_zone='+8:00';" );
		
		//$this->wpdb = $wpdb;
		$this->al_chr_clt = $charset_collate;
		$this->al_prefix = $wpdb->wsaliprefix;
		//$wpdb->show_errors();
		
		
		
		
		$this->cdb_orders();
		$this->cdb_products();
		$this->cdb_templates();
		//$this->cdb_wsali_pro_meta();
		//$this->cdb_wsali_ord_meta();
		//$this->cdb_wsali_tpl_meta();
		
		$this->cdb_wsali_meta();
		
		//$this->update_pack_v2();
		
		$opt_name='ws_alipay_update_pack';
		$opt_value="2.0";
		if($opt_value!==get_option($opt_name))
		{
			$this->update_pack_v2();
			update_option($opt_name,$opt_value);
		}
		
		
	}
	


	
	
	
	
		function update_pack_v2()
	{
		global $wpdb;
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `proid` `proid` INT NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `series` `series` VARCHAR(20) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `aliacc` `aliacc` VARCHAR(100) NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `buynum` `buynum` SMALLINT NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `email` `email` VARCHAR(30) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `phone` `phone` VARCHAR(20) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `address` `address` VARCHAR(100) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `remarks` `remarks` VARCHAR(255) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `message` `message` VARCHAR(255) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `otime` `otime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `stime` `stime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `status` `status` SMALLINT NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `referer` `referer` VARCHAR(255) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `postcode` `postcode` VARCHAR(10) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `emailsend` `emailsend` BOOLEAN NOT NULL DEFAULT FALSE DEFAULT false;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `ordname` `ordname` VARCHAR(20) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `ordfee` `ordfee` DOUBLE(10,2) NOT NULL DEFAULT '0.00';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliorders` CHANGE `sendsrc` `sendsrc` TEXT;");

//-----------------------------------------------------------------------
//
//----------------------------------------------------------------------- 
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `name` `name` VARCHAR(128) NOT NULL DEFAULT '未命名商品';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `price` `price` DOUBLE(10,2) NOT NULL DEFAULT 0.01;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `discountb` `discountb` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `discount` `discount` FLOAT(3,2) NOT NULL DEFAULT '0.85';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `num` `num` INT NOT NULL DEFAULT '99999';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `description` `description` TEXT;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `images` `images` TEXT;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `service` `service` SMALLINT NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `download` `download` VARCHAR(255) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `callback` `callback` VARCHAR(100) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `conotice` `conotice` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `csnotice` `csnotice` BOOLEAN NOT NULL DEFAULT TRUE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `sonotice` `sonotice` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `ssnotice` `ssnotice` BOOLEAN NOT NULL DEFAULT TRUE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `categories` `categories` INT NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `tags` `tags` VARCHAR(50) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `freight` `freight` DOUBLE(8,2) NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `spfre` `spfre` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `location` `location` VARCHAR(20) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `atime` `atime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `btime` `btime` DATETIME NOT NULL DEFAULT '2011-10-11 11:11:11';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `etime` `etime` DATETIME NOT NULL DEFAULT '2111-11-11 11:11:11';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `promote` `promote` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `probdate` `probdate` DATE NOT NULL DEFAULT '2011-11-11';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `proedate` `proedate` DATE NOT NULL DEFAULT '2111-11-11';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `protime` `protime` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `probtime` `probtime` TIME NOT NULL DEFAULT '00:00:00';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `proetime` `proetime` TIME NOT NULL DEFAULT '23:59:59';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `html` `html` TEXT;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `tplid` `tplid` INT NOT NULL DEFAULT 1;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `mailcontent` `mailcontent` TEXT;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `snum` `snum` INT UNSIGNED NOT NULL DEFAULT 0;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `weight` `weight` DOUBLE(6,2) UNSIGNED NOT NULL DEFAULT '0.99';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `autosend` `autosend` BOOLEAN NOT NULL DEFAULT FALSE;");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `autosep` `autosep` VARCHAR(255) NOT NULL DEFAULT '';");
$wpdb->query("ALTER TABLE `$wpdb->wsaliproducts` CHANGE `autosrc` `autosrc` TEXT;");

//-----------------------------------------------------------------------
//
//----------------------------------------------------------------------- 
$wpdb->query("ALTER TABLE `$wpdb->wsalitemplates` CHANGE `tplname` `tplname` VARCHAR(20) NOT NULL DEFAULT '未命名模版';");
$wpdb->query("ALTER TABLE `$wpdb->wsalitemplates` CHANGE `tpldescription` `tpldescription` VARCHAR(255) NOT NULL DEFAULT '模版简要描述';");
$wpdb->query("ALTER TABLE `$wpdb->wsalitemplates` CHANGE `tpljs` `tpljs` TEXT;");
$wpdb->query("ALTER TABLE `$wpdb->wsalitemplates` CHANGE `tplcss` `tplcss` TEXT;");
$wpdb->query("ALTER TABLE `$wpdb->wsalitemplates` CHANGE `tplhtml` `tplhtml` TEXT;");
	}
	
	
	private function cdb_orders(){
		global $wpdb;
		$table_name = $wpdb->wsaliorders;
		$sql = "CREATE TABLE $table_name (
			ordid INT NOT NULL AUTO_INCREMENT,
			proid INT NOT NULL DEFAULT 0,
			series VARCHAR(20) NOT NULL DEFAULT '',
			aliacc VARCHAR(100) NOT NULL DEFAULT '',
			buynum SMALLINT NOT NULL DEFAULT 0,
			email VARCHAR(30) NOT NULL DEFAULT '',
			phone VARCHAR(20) NOT NULL DEFAULT '',
			address VARCHAR(100) NOT NULL DEFAULT '',
			remarks VARCHAR(255) NOT NULL DEFAULT '',
			message VARCHAR(255) NOT NULL DEFAULT '',
			otime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			stime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			status SMALLINT NOT NULL DEFAULT 0,
			referer VARCHAR(255) NOT NULL DEFAULT '',
			postcode VARCHAR(10) NOT NULL DEFAULT '',
			emailsend BOOLEAN NOT NULL DEFAULT FALSE DEFAULT false,
			ordname VARCHAR(20) NOT NULL DEFAULT '',
			ordfee DOUBLE(10,2) NOT NULL DEFAULT '0.00',
			sendsrc TEXT,
			PRIMARY KEY (ordid))
			AUTO_INCREMENT = 100
			$this->al_chr_clt;
			";
		maybe_create_table($table_name, $sql);
	}
	
	
	private function cdb_products(){
		global $wpdb;
		$table_name = $wpdb->wsaliproducts;	
		$sql = "CREATE TABLE $table_name (
			proid INT NOT NULL AUTO_INCREMENT,
			name VARCHAR(128) NOT NULL DEFAULT '商品名称',
			price DOUBLE(10,2) NOT NULL DEFAULT 0.01,
			discountb BOOLEAN NOT NULL DEFAULT FALSE,
			discount FLOAT(3,2) NOT NULL DEFAULT '0.85',
			num INT NOT NULL DEFAULT '99999',
			description TEXT,
			images TEXT,
			service SMALLINT NOT NULL DEFAULT 0,
			download VARCHAR(255) NOT NULL DEFAULT '',
			callback VARCHAR(100) NOT NULL DEFAULT '',
			conotice BOOLEAN NOT NULL DEFAULT FALSE,
			csnotice BOOLEAN NOT NULL DEFAULT TRUE,
			sonotice BOOLEAN NOT NULL DEFAULT FALSE,
			ssnotice BOOLEAN NOT NULL DEFAULT TRUE,
			categories INT NOT NULL DEFAULT 0,
			tags VARCHAR(50) NOT NULL DEFAULT '',
			freight DOUBLE(8,2) NOT NULL DEFAULT 0,
			spfre BOOLEAN NOT NULL DEFAULT FALSE,
			location VARCHAR(20) NOT NULL DEFAULT '',
			atime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			btime DATETIME NOT NULL DEFAULT '2011-10-11 11:11:11',
			etime DATETIME NOT NULL DEFAULT '2111-11-11 11:11:11',
			promote BOOLEAN NOT NULL DEFAULT FALSE,
			probdate DATE NOT NULL DEFAULT '2011-11-11',
			proedate DATE NOT NULL DEFAULT '2111-11-11',
			protime BOOLEAN NOT NULL DEFAULT FALSE,
			probtime TIME NOT NULL DEFAULT '00:00:00',
			proetime TIME NOT NULL DEFAULT '23:59:59',
			html TEXT,
			tplid INT NOT NULL DEFAULT 101,	
			mailcontent TEXT,
			snum INT UNSIGNED NOT NULL DEFAULT 0,
			weight DOUBLE(6,2) UNSIGNED NOT NULL DEFAULT '0.99',
			autosend BOOLEAN NOT NULL DEFAULT FALSE,
			autosep VARCHAR(255) NOT NULL DEFAULT '',
			autosrc TEXT,
			PRIMARY KEY (proid))
			AUTO_INCREMENT = 100
			$this->al_chr_clt;
			";
		maybe_create_table($table_name, $sql);
		
	}
		
	private function cdb_templates(){
		global $wpdb;
		$table_name = $wpdb->wsalitemplates;
		$sql = "CREATE TABLE $table_name (
			tplid INT NOT NULL AUTO_INCREMENT,
			tplname VARCHAR(20) NOT NULL DEFAULT '模板名称',
			tpldescription VARCHAR(255) NOT NULL DEFAULT '模版描述',
			tpljs TEXT,
			tplcss TEXT,
			tplhtml TEXT, 
			PRIMARY KEY (tplid))
			$this->al_chr_clt;
			";
		
		maybe_create_table($table_name, $sql);
		
	}	


	private function cdb_wsali_meta(){
		global $wpdb;
		foreach( $this->tbls as $v ){
			$meta_type  = $wpdb->{'wsali' . $v . 'metatype'};
			$table_name = $wpdb->{'wsali' . $v . 'meta'};
			
			$sql = "CREATE TABLE $table_name (
			meta_id INT NOT NULL AUTO_INCREMENT,
			{$meta_type}_id INT NOT NULL DEFAULT 0,
			meta_key VARCHAR(255) NOT NULL DEFAULT '',
			meta_value LONGTEXT,
			PRIMARY KEY (meta_id))
			$this->al_chr_clt;
			";
		
			maybe_create_table( $table_name, $sql );
			
			$wpdb->{'wsali'.$v.'meta'} =  $table_name;	
		}
		
	}
	
	function getTimeZoneStr(){
		$gmt_offset = get_option('gmt_offset');	
		
		
	}
}

$ws_ali_db = new ws_alipay_db;


?>