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
		
		$this->cdb_orders();
		$this->cdb_products();
		$this->cdb_templates();
		//$this->cdb_wsali_pro_meta();
		//$this->cdb_wsali_ord_meta();
		//$this->cdb_wsali_tpl_meta();
		
		$this->cdb_wsali_meta();
		
	}
	

	
	private function cdb_orders(){
		global $wpdb;
		$table_name = $wpdb->wsaliorders;
		$sql = "CREATE TABLE $table_name (
			ordid INT NOT NULL AUTO_INCREMENT,
			proid INT NOT NULL,
			series VARCHAR(20) NOT NULL,
			aliacc VARCHAR(30) NOT NULL,
			buynum SMALLINT NOT NULL,
			email VARCHAR(30) NOT NULL,
			phone VARCHAR(20) NOT NULL,
			address VARCHAR(100) NOT NULL,
			remarks VARCHAR(255) NOT NULL,
			message VARCHAR(255) NOT NULL,
			otime DATETIME NOT NULL,
			stime DATETIME NOT NULL,
			status BOOLEAN NOT NULL,
			referer VARCHAR(255) NOT NULL,
			postcode VARCHAR(10) NOT NULL,
			emailsend BOOLEAN NOT NULL DEFAULT FALSE,
			ordname VARCHAR(20) NOT NULL,
			ordfee DOUBLE(10,2) NOT NULL,
			sendsrc TEXT NOT NULL,
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
			discountb BOOLEAN NOT NULL,
			discount FLOAT(3,2) NOT NULL DEFAULT '0.85',
			num INT NOT NULL DEFAULT '99999',
			description TEXT NOT NULL,
			images TEXT NOT NULL,
			service SMALLINT NOT NULL,
			download VARCHAR(255) NOT NULL,
			callback VARCHAR(100) NOT NULL,
			conotice BOOLEAN NOT NULL DEFAULT FALSE,
			csnotice BOOLEAN NOT NULL DEFAULT TRUE,
			sonotice BOOLEAN NOT NULL DEFAULT FALSE,
			ssnotice BOOLEAN NOT NULL DEFAULT TRUE,
			categories SMALLINT NOT NULL,
			tags VARCHAR(50) NOT NULL, 
			freight DOUBLE(8,2) NOT NULL,
			spfre BOOLEAN NOT NULL DEFAULT FALSE,
			location VARCHAR(20) NOT NULL,
			atime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			btime DATETIME NOT NULL DEFAULT '2011-10-11 11:11:11',
			etime DATETIME NOT NULL DEFAULT '2111-11-11 11:11:11',
			promote BOOLEAN NOT NULL DEFAULT FALSE,
			probdate DATE NOT NULL DEFAULT '2011-11-11',
			proedate DATE NOT NULL DEFAULT '2111-11-11',
			protime BOOLEAN NOT NULL DEFAULT FALSE,
			probtime TIME NOT NULL DEFAULT '00:00:00',
			proetime TIME NOT NULL DEFAULT '23:59:59',
			html TEXT NOT NULL,
			tplid INT NOT NULL DEFAULT 1,	
			mailcontent TEXT NOT NULL,
			snum INT UNSIGNED NOT NULL,
			weight DOUBLE(6,2) UNSIGNED NOT NULL DEFAULT '0.99',
			autosend BOOLEAN NOT NULL,
			autosep VARCHAR(255) NOT NULL,
			autosrc TEXT NOT NULL,
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
			tpljs TEXT NOT NULL,
			tplcss TEXT NOT NULL ,
			tplhtml TEXT NOT NULL, 
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
			{$meta_type}_id INT NOT NULL,
			meta_key VARCHAR(255) NOT NULL,
			meta_value LONGTEXT NOT NULL,
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