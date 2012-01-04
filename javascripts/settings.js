//+++++++++++++++++++++++++++++++++++++++++++
var WP_INC_URL = '../wp-content/plugins/alipay/includes/';
var $arr_tabs = [];//load once
var $watt = '';
var $ws_alipay_form_more_html = '';
var $ = jQuery.noConflict();


//+++++++++++++++++++++++++++++++++++++++++++
$(function(){//THE BEGINNING OF JQ
	ws_alipay_fn_register();//ENTRY
});//END OF JQ

//############################################################################
//Common fns library section
function ws_alipay_json_to_form( data ){
    if( data.empty !== true){
		data.reverse();
	}

	function watt_Class(){
		this.id 			= $this.id.table;
		this.class 			= $this.class.table;
		this.parentId 		= $this.id.tableParent;
		this.showCheckbox.visible  = 1;
		this.showMore = {visible:$this.bln.showMore,id:'',href:'',class:$this.getClassNoDot('more')} ;
		this.showCopy = {visible:$this.bln.showCopy,id:'',href:'',class:$this.getClassNoDot('copy')}
		this.showDelete = {visible:$this.bln.showDelete,id:'',href:'',class:$this.getClassNoDot('delete')}
		this.showEdit = {visible:$this.bln.showEdit,id:'',href:'',class:$this.getClassNoDot('edit')}
		this.arrHead		= $this.arr.head;
		this.arrFoot		= this.arrHead;
		this.arrBody		= data;
		this.data 			= data;
		this.nav.id			= $this.getClassNoDot('nav');
		this.nav.class		= $this.css.nav;
		this.showFields		= $this.showFields;	
		this.showLength		= $this.showLength;	
		this.colsWidth     = $this.arr.colsWidth;
	}
	
	watt_Class.prototype = new ws_alipay_table_Class();
	$watt = new watt_Class();
	$watt.create();
	
}

function ws_alipay_fn_register(){
	var arr_fns = Array(
		'ws_alipay_ajax_setup'
	);	
	for(i in arr_fns){eval(arr_fns[i] + '();');}
}

function ws_alipay_ajax_ready(){	
	$('#ws_alipay_child_wrap').hide();
	$('#ws_alipay_child_wrap').fadeIn(1000);
}

function ws_alipay_ajax_setup(){
	$.ajaxSetup({
		url:'../wp-content/plugins/alipay/includes/inc.dbloader.php',
		type:'POST',
		dataType:'JSON',
	});
	ws_alipay_attach_ajax();
}	

function ws_alipay_get_query(url,name){
	var svalue = url.search.match(new RegExp("[\?\&]" + name + "=([^\&]*)(\&?)","i"));
	return svalue ? svalue[1] : svalue;	
}	

function ws_alipay_page_init(){
	$('#ws_alipay_main_wrap :button').addClass('button-secondary');
	ws_alipay_attach_ajax();
	ws_alipay_get_json();
}

function ws_alipay_attach_ajax(){
	$('#ws_alipay_loading').bind({
		ajaxSend:function(){
			$(this).show();	
		},
		ajaxComplete:function(){
			$(this).fadeOut(1000);	
		}		
	});
};

function ws_alipay_after_load(){	
	ws_alipay_sl_multiPrice( $('.ws_alipay_select_protype') );
}

function ws_alipay_sl_multiPrice( $baseObj ){
	if( $baseObj.val() == 'ADP' || $baseObj.val() == 'LINK' )
		$('.ws_alipay_multiPrice').parent().show();
	else
		$('.ws_alipay_multiPrice').parent().hide();	
	
	$('.ws_alipay_multiPrice').each(function(){
		var $tmpVal = new Number($(this).val());
		$tmpVal = Math.abs($tmpVal);
		$(this).val( $tmpVal.toFixed(2));	
		
	});
}
//############################################################################

var ws_alipay_table_Class = function(){//THE CLASS OF TABLE
	this.id = '';
	this.class = '';
	this.parentId='';
	this.mainWrapId='';
	this.cols = 0;
	this.dataCols = 0;
	this.rows = 0;
	this.colsWidth =[];
	this.data = '';
	this.arrHead = '';
	this.arrFoot = '';
	this.arrBody = '';
	this.showFields = '';
	this.showLength = '';
	this.hideFields = '';
	this.showCheckbox = {visible:true,id:'',class:'',href:'',callback:''}
	this.showCopy = {visible:true,id:'',class:'',href:'',callback:''}
	this.showEdit = {visible:true,id:'',class:'',href:'',callback:''}
	this.showMore = {visible:true,id:'',class:'',href:'',callback:''}
	this.showDelete = {visible:true,id:'',class:'',href:'',callback:''}

	this.showCheckboxRet = function( bln_head ){
		var c = this.showCheckbox;
		var ret='';
		var twhat = ( bln_head )?'th':'td';
		var id = ( c.id == '')?'':' id="'+c.id+'"';
		var cls = ( c.class == '')?'':' cls="'+c.class+'"';
		var href= ( c.href == '')?'':' href="'+c.href+'"';
		if( c.visible ){
			ret = '<'+twhat+'><input type="checkbox"'+id+cls+href+'/></'+twhat+'>';
		}else{
			ret = '';
		}
		return ret;		
	}
	this.showCopyRet = function( bln_head ){
		var c = this.showCopy;
		var ret='';
		var twhat = ( bln_head )?'th':'td';
		var id = ( c.id == '')?'':' id="'+c.id+'"';
		var cls = ( c.class == '')?'':' class="'+c.class+'"';
		var href= ( c.href == '')?' href="javascript:void(0)"':' href="'+c.href+'"';
		if( c.visible ){
			var innerData = ( bln_head )?'复制':'<a'+id+cls+href+' >复制</a>';
			ret = '<'+twhat+'>'+innerData+'</'+twhat+'>';
		}else{
			ret = '';
		}
		return ret;		
	}
	this.showEditRet = function( bln_head ){
		var c = this.showEdit;
		var ret='';
		var twhat = ( bln_head )?'th':'td';
		var id = ( c.id == '')?'':' id="'+c.id+'"';
		var cls = ( c.class == '')?'':' class="'+c.class+'"';
		var href= ( c.href == '')?' href="javascript:void(0)"':' href="'+c.href+'"';
		var inner = ( bln_head);
		if( c.visible ){
			var innerData = ( bln_head )?'编辑':'<a'+id+cls+href+' >编辑</a>';
			ret = '<'+twhat+'>'+innerData+'</'+twhat+'>';
		}else{
			ret = '';
		}
		return ret;		
	}
	this.showMoreRet = function( bln_head ){
		var c = this.showMore;
		var ret='';
		var twhat = ( bln_head )?'th':'td';
		var id = ( c.id == '')?'':' id="'+c.id+'"';
		var cls = ( c.class == '')?'':' class="'+c.class+'"';
		var href= ( c.href == '')?' href="javascript:void(0)"':' href="'+c.href+'"';
		if( c.visible ){
			var innerData = ( bln_head )?'详情':'<a'+id+cls+href+' >详情</a>';
			ret = '<'+twhat+'>'+innerData+'</'+twhat+'>';
		}else{
			ret = '';
		}
		return ret;		
	}
	this.showDeleteRet = function( bln_head ){
		var c = this.showDelete;
		var ret='';
		var twhat = ( bln_head )?'th':'td';
		var id = ( c.id == '')?'':' id="'+c.id+'"';
		var cls = ( c.class == '')?'':' class="'+c.class+'"';
		var href= ( c.href == '')?' href="javascript:void(0)"':' href="'+c.href+'"';
		if( c.visible ){
			var innerData = ( bln_head )?'删除':'<a'+id+cls+href+' >删除</a>';
			ret = '<'+twhat+'>'+innerData+'</'+twhat+'>';
		}else{
			ret = '';
		}
		return ret;		
	}
	
	this.createThead = function( arr_data ){
		var ret = ''
		ret  = '<thead><tr>';
		ret += this.showCheckboxRet(true);
		this.dataCols = 0;
		for( var i in arr_data){
			this.dataCols ++;
			ret += '<th>'+arr_data[i]+'</th>';
		}
		ret += this.showCopyRet(true);
		ret += this.showEditRet(true);
		ret += this.showMoreRet(true);
		ret += this.showDeleteRet(true);
		ret += '</tr></thead>';
		return ret;	
	}
	this.createTfoot = function( arr_data ){
		var ret = ''
		ret  = '<tfoot><tr>';
		ret += this.showCheckboxRet(true);
		for( var i in arr_data){
			ret += '<th>'+arr_data[i]+'</th>';
		}
		ret += this.showCopyRet(true);
		ret += this.showEditRet(true);
		ret += this.showMoreRet(true);
		ret += this.showDeleteRet(true);
		ret += '</tr></tfoot>';
		return ret;	
	}
	this.createTbody =function( arr_data ){
		var ret = ''
		ret  = '<tbody>';
		arr_data = this.array_diff( arr_data, this.showFields);
		ret += this.createRow( arr_data );

		ret += '</tbody>';
		return ret;	
		
	}
	
	this.array_diff = function( array1, array2){
		var arr_ret = new Array();
		for( var i in array1){
			arr_ret[i] = []; 
			for( var j in array1[i]){
				for ( var k in array2){
					if( j==k ){
						if( array2[k]=='' ){
							arr_ret[i][j] = array1[i][j];	
						}else{
							arr_ret[i][j] = array2[k].replace( '\['+j+'\]', array1[i][j]);
							if( array2[k].indexOf('[') == -1){
								arr_ret[i][j] = eval(array2[k]+'('+array1[i][j]+')');
							}
							
						}
					}	
				}	
				
			}
	
		}	
		return arr_ret;
	}
	
	this.createRow = function( arr_data , bln_one){
		var ret='';
		var page_start = 0;
		var page_end =0;
		if( bln_one == true){
			page_start = 0;
			page_end = arr_data.length;
		}else{
			page_start = (this.nav.current-1) * this.nav.per;
			page_end = page_start + this.nav.per;	
			if( page_end > arr_data.length){
				page_end -= (page_end - arr_data.length)
			}
		}
		for( var i=page_start; i<page_end ; i++  ){
			
			ret += '<tr>';
			ret += this.showCheckboxRet(false);
			
			for( var j in this.showLength ){
				if( this.showLength[j] !== '' ){ 
					arr_data[i][j] = arr_data[i][j].substr(0,this.showLength[j]);
				}
			}
			
			for( var j in this.showFields ){
				if( arr_data[i][j] == ''){ arr_data[i][j]= '-'}
				ret += '<td>'+arr_data[i][j]+'</td>';
			}

			ret += this.showCopyRet(false);
			ret += this.showEditRet(false);
			ret += this.showMoreRet(false);
			ret += this.showDeleteRet(false);
			ret += '</tr>';
		}	
		return ret;	
	}

	this.addEmptyRow = function(){
		dataPre = [];
		for( var i in this.showFields ){
			dataPre[i] = '获取中...';
		}
		if( $('#' + this.id + ' tbody tr').length >= this.nav.per ){
			$('#' + this.id + ' tbody tr:last').remove();
		}
		this.addRow([dataPre], '', true);	
	}
	this.addRow = function( arr_data, fn_callback, bln_one ){
		var ret = this.createRow( arr_data , bln_one);
		$( '#' + this.id + ' tbody' ).prepend( ret );	
		if( typeof fn_callback !== 'undefined' && fn_callback !== '' )
			eval( fn_callback + '();' );
	}
	
	this.removeRow = function( e ){
		$(e).parent().parent().remove();
	}
	
	this.cls = function(){
		$('#' + this.parentId + ' tbody').html('');		
	}
		
	this.selectAll = function(){
		if($('#'+this.id + ' thead').ischecked ==true){}	
	}
	this.Rows = function(){
		var ret = $('#' + this.id +' tbody tr').length;
		this.rows = ret;
		return ret;
		
	}
	this.Cols = function(){
		var ret = $('#' + this.id +' thead tr th').length;
		this.cols = ret;
		return ret;
	}
	this.cell = function( row, col, data ){
		var ret;
		if( typeof data !=='undefined'){
			$('#' + this.id +' tbody tr:eq('+row+') td:eq('+col+')').text(data);	
			ret = data;
		}else{
			ret = $('#' + this.id +' tbody tr:eq('+row+') td:eq('+col+')').text(data);				
		}
		return ret;
	}	

	
	this.nav = {//THE NAV CHILD CLASS OF TABLE CLASS
		parent:'',
		data:'',
		id:'',
		class:'',
		pages:0,
		count:20,
		current:1,
		per:10,
		hotKeyId:'',
		lbound:function(){
			return ( this.current-1 ) * this.per;	
		},
		ubound:function(){
			return this.lbound() + this.per;	
		},
		page:function(n){
			if( n>this.pages || n<1){
				n= this.current;
			}
			this.current = n;
			this.parent.create();	
		},
		pagepp:function(){
			this.page(this.current+1);
		},
		pagemm:function(){
			this.page(this.current-1);
		},
		create:function(o){
			this.parent = o;
			this.data = o.data;
			this.count = this.data.length;
			this.pages = Math.ceil( this.count/this.per);
			var $lis='';
			for(var i=1; i<= this.pages; i++){
				$lis += '<li>'+ i +'</li>';	
			}
		
			$html_nav  = '<div id="'+this.id+'" class="'+this.class+'">';
			$html_nav += '<ul title="按左右键可以快速翻页">';
			$html_nav += '</ul>';
			$html_nav += '</div>';
	
			$('#' + this.parent.id).after( $html_nav );
			$('#' + this.id + ' ul').append($lis);
			

		}
	}

	this.create = function(){

		var id  = ( this.id=='' )?'':' id="'+this.id+'"';
		var cls = ( this.class=='' )?'':' class="'+this.class+'"';
		html  = '<table'+id+cls+'>';
		html += this.createThead( this.arrHead );
		html += this.createTfoot( this.arrFoot );
		
		if( this.arrBody.empty !== true ){
			html += this.createTbody( this.arrBody );
		}else{
			html += '<tbody><tr><td colspan="'+$this.num.cols+'" style="text-align:center">暂无记录</td></tr></tbody>'	
		}
		
		
		
		html += '</table>';
		
		this.remove();
		
		$('#' + this.parentId).append(html);
	
		this.nav.create(this);

		this.cols = this.Cols();
		
		for( var i in this.colsWidth ){
			$( '#' + this.id + ' thead tr th:eq('+i+')').css('width', this.colsWidth[i]);	
		}	
	}
	
	this.remove = function(){
		$('#' + this.id).remove();
		$('#' + this.nav.id).remove();
	}

}

//############################################################################
//THE AJAX FNS SECTION
function ws_alipay_data_pre( data ){
	if( typeof data.data == 'undefined'){
		var temp = {empty:true};
		data['data'] = temp;
	}
	return data;
}

function ws_alipay_get_json(){
	$.ajax({
		data:{
			'ws_security_check':$ws_alipay_security_code,
			'action':'78014',
			'fields':$this.fields,
			'fields_refer':$this.arr.fields_refer,
			'asc_fields':'',
			'limit':'0,999',
			'table': $this.tabname,
		},	
		success:function(data){ 
			data = ws_alipay_data_pre( data );
			ws_alipay_json_to_form(  data['data'] );
		}	
	});
	
	
}	

function ws_alipay_table_insert(){
	$.ajax({
		data:{
			'ws_security_check':$ws_alipay_security_code,
			'action':'78016',
			'fields':$this.fields,
			'fields_refer':$this.arr.fields_refer,
			'asc_fields':'',
			'limit':'0,999',
			'table': $this.tabname,
			'where': $this.primaryKey,
		},	
		success:function(data){ 
			data = ws_alipay_data_pre( data );
			ws_alipay_json_to_form( data['data'] ); 
		}	
	});
}	

function ws_alipay_table_delete(prival){
	$.ajax({
		data:{
			'ws_security_check':$ws_alipay_security_code,
			'action':'78017',
			'fields':$this.fields,
			'fields_refer':$this.arr.fields_refer,
			'asc_fields':'',
			'limit':'0,999',
			'where': $this.primaryKey + '=' + prival,
			'table': $this.tabname ,
		},	
		success:function(data){ 
			data = ws_alipay_data_pre( data );
			ws_alipay_json_to_form( data['data'] ); 
		}
	});
}

function ws_alipay_table_copy(prival){
	$.ajax({
		data:{
			'ws_security_check':$ws_alipay_security_code,
			'action':'78018',
			'fields':$this.fields,
			'fields_refer':$this.arr.fields_refer,
			'asc_fields':'',
			'limit':'0,999',
			'where': $this.primaryKey + '=' + prival,
			'table': $this.tabname ,
		},	
		success:function(data){ 
			data = ws_alipay_data_pre( data );
			ws_alipay_json_to_form( data['data'] ); 
		}
	});
}	

function ws_alipay_table_edit(prival){
	$.ajax({
		data:{
			'ws_security_check':$ws_alipay_security_code,
			'action':'78009',
			'fields':'*',
			//'fields_refer':$this.arr.fields_refer,
			'asc_fields':'',
			'limit':'0,999',
			'where': $this.primaryKey + '=' + prival,
			'table': $this.tabname ,
			'single':'1'
		},	
		success:function(data){
			
			//Extra fields filter
			//$('#' + $this.id.formMore).find('input[name=name]').parent().after(data['extra']);
			ws_alipay_form_extra( data['extra'] );
				
								
			$('.ws_alipay_loading_more').fadeOut(500);
			ws_alipay_json_to_form_more( data['data'] );
			
			
			
		}	
	});
}

function ws_alipay_form_extra( $extra ){
	if( $extra == '' ) return;

	var $ret = '';	
	
	
	for( var $k in $extra ){//FOR LOOP BEGIN
		if( typeof($extra[$k]['visible']) !== 'undefined' && !$extra[$k]['visible'] ) continue;

		//$ret = '<div><label for="'+ $extra[$k][0] +'">'+ $extra[$k][1] +'</label><input type="text" name="'+ $extra[$k][0] +'" value="" /></div>';
		$ret =	ws_alipay_label_input_html( $extra[$k] );
	
	if( typeof($extra[$k]['pos']) == 'undefined' ) continue;

	if( typeof($extra[$k]['pos']['name']) !== 'undefined' ){
		var testEleName = 
		$('#' + $this.id.formMore).find('input[name='+ $extra[$k]['pos']['name'] +']');
	
	}else if( typeof($extra[$k]['pos']['num']) !== 'undefined'){
		var testEleNum  = 
		$('#' + $this.id.formMore).find('input:eq('+ $extra[$k]['pos']['num'] +')');
		
	}else if( typeof($extra[$k]['pos']['ext']) !== 'undefined' ){
		if( $extra[$k]['pos']['ext'].toUpperCase() == 'FIRST' ){
			var testFirst   = $('#' + $this.id.formMore).find('input:eq(0)');	
			
		}else if($extra[$k]['pos']['ext'].toUpperCase() == 'LAST'){
			var testLast    = $('#' + $this.id.formMore).find('input[type=submit]');	
		}
	}

	if( typeof(testEleName) !== 'undefined' && testEleName.length  !== 0  ) 
		testCurrent = testEleName;

		
	if( typeof(testEleNum) !== 'undefined' && testEleNum.length  !== 0  ) 
		testCurrent = testEleNum;
	
	if( typeof testCurrent !== 'undefined' ){
		if( typeof($extra[$k]['pos']['rel']) !== 'undefined' ){
			if( $extra[$k]['pos']['rel'].toUpperCase() == 'BEFORE'){
				testCurrent.parent().before($ret);
			}else if( $extra[$k]['pos']['rel'].toUpperCase() == 'AFTER' ){
				testCurrent.parent().after($ret);
			}	
		}else{
			testCurrent.parent().after($ret);
		}
	
	}
	
	if( typeof(testFirst) !== 'undefined' && testFirst.length  !== 0  )
		testFirst.parent().before($ret);	
	if(typeof(testLast) !== 'undefined' && testLast.length  !== 0 )
		testLast.before($ret);	
	
	}//END OF FOR LOOP
	
	return $ret;
	//alert($ret);
	
}

// var $k in $extra  in= $extra[$k]
function ws_alipay_label_input_html( $item ){
	
	
	$ret  = '<div><label for="'+ $item[0] +'">'+ $item[1] +'</label>';
	
	if( typeof($item['type'] ) == 'undefined' )
		$item['type'] = 'text';
	
	switch( $item['type'].toLowerCase() ){
		case 'text':
			$ret += '<input type="text" name="'+ $item[0] +'" value="" />';
			break;
		case 'select':
			$ret += '<select name="'+ $item[0] +'">';
			for( var $v in $item['options']){
				$ret += '<option value="'+ $v +'">'+ unescape($item['options'][$v]) +'</option>';
			}
			$ret += '</select>';
			break;
		case 'textarea':
			
			break;
			
		
		
	}
	
	$ret += '</div>';
	
	return $ret;
}

function ws_alipay_table_update( $data ){
	$.ajax({
		data: $data +
			   '&ws_security_check='+ $ws_alipay_security_code +
			   '&action=78015&table=' +  $this.tabname  +
			   '&where=' + $this.primaryKey + '=' + $this.currentKey +
			   '&fields_refer=' + $this.arr.fields_refer
				,
		type:'post',
		success:function(data){
			$('.ws_alipay_loading_more').fadeOut(500);
			if( data == null ){
				//alert('更新成功!');
				var e = document.forms[ $this.id.formMore ].elements;
				var i = 1;
				
				for( var key in $this.showLength ){
					if( typeof e[key] !== 'undefined' ){
						if( $this.showLength[key] !== '' ){ 
							 e[key].value  =  e[key].value.substr(0,$this.showLength[key]);
						}
					}
				}
				
				for ( var key in $this.showFields ){
					if( typeof e[key] !== 'undefined' ){
						$watt.cell( $this.pos.rowIndex-1 ,i , e[key].value );
					}
					i++; 
				}	
			}
		}
	});
}


function ws_alipay_json_to_form_more( data ){
	var e = document.forms[ $this.id.formMore ].elements;
	for(var i in e){
		if( e[i].type !== 'submit' ){
			e[i].value = data[0][ e[i].name ];	
			if( e[i].value ==  'undefined' ){ e[i].value = '' }
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////////////
	//No name Field
	$('.ws_alipay_prolink').val($ws_alipay_cartUrl+'?proid='+data[0]['proid']);
	/////////////////////////////////////////////////////////////////////////////////////
	
	ws_alipay_check_select('ws_alipay_select_promote,ws_alipay_select_protime,ws_alipay_select_discountb,ws_alipay_select_spfre');
	ws_alipay_check_select('ws_alipay_select_autosend');
	
	ws_alipay_after_load();
}

function ws_alipay_hot_key_active( bln_active ){
	if( bln_active == true ){
		$('#' + $this.id.hotkey ).live('keydown',function(e){
			switch(e.which){
				case 37:
					$watt.nav.pagemm();
					break;
				case 39:
					$watt.nav.pagepp();
					break;		
			}		
		});		
	}else{
		$('#' + $this.id.hotkey ).die();
	}
	
}

function ws_alipay_filter_ordstatus(s){
	if ( parseInt(s)==1 ){
		return '<span style="color:#269926;font-weight:bold">已付款&nbsp;√</span>';
	}else{
		return '<span style="color:#F80012">待付款</span>';
	}
	
}

function ws_alipay_check_select( cls_causer ){
	var arr_causer = cls_causer.split(',');
	
	
	for( var i in arr_causer){
		if( $('.' + arr_causer[i]).length ==0 ) return;
		
		var _rel = $('.'+ arr_causer[i] +'_rel');
		if( $('.' + arr_causer[i]).val() == 0 ){
			
			_rel.attr({'readonly':'readonly','disabled':'disabled'}); 	
		}else{ 	
			_rel.removeAttr('readonly'); 
			_rel.removeAttr('disabled');	
		}
		$('.' + arr_causer[i]).die('change');
		$('.' + arr_causer[i]).live('change',function(){
			ws_alipay_check_select(cls_causer);
		});
		
	}
	
	
}	
//############################################################################
//THE EVENT SECTION INNER OF JQ
$(function(){//BEGINNING OF JQ
//PAGE	

$( $this.getId('nav') + ' ul li').live('click',function(){
		ws_alipay_hot_key_active( true )
		$watt.nav.page( parseInt( $(this).text()) );
});	
//COPY
$( $this.getClass( 'copy' ) ).live('click',function(){
	
	$tr = $(this).parent().parent().clone();
	
	if( $('#' + $watt.id + ' tbody tr').length >= $watt.nav.per ){
			$('#' + $watt.id + ' tbody tr:last').remove();
	}
		
	$('#' + $watt.id +' tbody').prepend($tr);
	
	for( var i = 1; i<= $watt.dataCols ; i++){
		$watt.cell( 0 ,i, $watt.cell(0,i)+'-复制中...' );
	}	
	var prival = $(this).parent().parent().children(':eq('+$this.pos.primaryKey+')').text();
	prival = $this.getPriKey(prival)
	ws_alipay_table_copy( prival );	
	
})	
//DELETE
$( $this.getClass( 'delete' ) ).live('click',function(){

	var row = $this.pos.rowIndex
	
	
	var prival = $(this).parent().parent().children(':eq('+$this.pos.primaryKey+')').text();
	prival = $this.getPriKey(prival)
	ws_alipay_table_delete( prival );	
	
	for( var i = 2; i<= $watt.dataCols ; i++){
		$watt.cell( row ,i, '-删除中' );//$watt.cell(row,i)+
	}
})	
//EDIT
$( $this.getClass( 'edit' ) ).live('click',function(){
	var $next = $(this).parent().parent().next();
	
	var m = $('#ws_alipay_item_more');
	if( m.length > 0 ){
		$ws_alipay_form_more_html = m.html();
		m.remove();	
	}
	
	if( !$next.is('.ws_table_tr_eidt') ){	
		$('.ws_table_tr_eidt').remove();
		$(this).parent().parent().after('<tr class="ws_table_tr_eidt" tabindex="998"><td colspan="'+$watt.cols+'">'+$ws_alipay_form_more_html+'</td></tr>');
		
		var e = document.forms[ $this.id.formMore ].elements;
		for(var i in e){
			if( e[i].type !== 'submit' ){
				e[i].value = 'loading';	
			}
		}
		
		var prival = $(this).parent().parent().children(':eq('+$this.pos.primaryKey+')').text();
		prival = $this.getPriKey(prival)
		$this.currentKey = prival;
		ws_alipay_table_edit( prival );
		$('html,body').animate( {scrollTop:  $(this).offset().top-50}, 1000 );
		ws_alipay_hot_key_active( false )
	}else{
		$next.remove();
		$('html,body').animate( {scrollTop:  0}, 1000 );
		ws_alipay_hot_key_active( true )
	}
		
	
})
//MORE
$( $this.getClass( 'more' )).live('click',function(){
	var $next = $(this).parent().parent().next();
	
	var m = $('#ws_alipay_item_more');
	if( m.length > 0 ){
		$ws_alipay_form_more_html = m.html();
		m.remove();	
	}
	
	if( !$next.is('.ws_table_tr_eidt') ){	
		$('.ws_table_tr_eidt').remove();
		$(this).parent().parent().after('<tr class="ws_table_tr_eidt"><td colspan="'+$watt.cols+'">'+$ws_alipay_form_more_html+'</td></tr>');
		
		var e = document.forms[ $this.id.formMore ].elements;
		for(var i in e){
			if( e[i].type !== 'submit' ){
				e[i].value = 'loading';	
			}
		}
		
		var prival = $(this).parent().parent().children(':eq('+$this.pos.primaryKey+')').text();
		prival = $this.getPriKey(prival)
		$this.currentKey = prival;
		ws_alipay_table_edit( prival );
		$('html,body').animate( {scrollTop:  $(this).offset().top-50}, 1000 );
	}else{
		$next.remove();
		$('html,body').animate( {scrollTop:  0}, 1000 );
	}
	
	
	
	
	
})
//SUBMIT
$('#ws_alipay_table_more_form').live('submit',function(){
	var row = $this.pos.rowIndex-1;
	for( var i = 2; i<= $watt.dataCols ; i++){
		if ( i!==$this.pos.primaryKey ){
			$watt.cell( row ,i, '-更新中...' );
		}
	}
	var $data = $(this).serialize();
	$('.ws_alipay_loading_more').show();
	ws_alipay_table_update( $data )
	return false;
});	

//NAV HOT KEYS
ws_alipay_hot_key_active( true );

//ADD
$('#ws_alipay_table_add').live('click',function(){
	$watt.addEmptyRow();
	ws_alipay_table_insert();
});

//CURRENT ROW INDEX
$('#' + $this.id.table +' tbody tr').live('mouseenter',function(){
	$this.pos.rowIndex = $(this).index();
});


//MAIN MENU
$('.ws_alipay_menu_a').bind({
	click:function(e){

		$('.ws_alipay_menu_active').addClass('ws_alipay_menu_a').removeClass('ws_alipay_menu_active');
		$(this).addClass('ws_alipay_menu_active') .removeClass('ws_alipay_menu_a');
		$.ajax({
			url: WP_INC_URL + 'tpl.settings_'+ws_alipay_get_query(e.target,'cpage')+'.php',	
			type:'POST',
			dataType:'html',
			success:function(data){
				
				$('#ws_alipay_child_wrap').html(data);	
				ws_alipay_ajax_ready();
			}	
		});
		return false;	
	}	
	
});

//$('.ws_alipay_prolink')
$('.ws_alipay_prolink').live('dblclick',function(){
	open($(this).val(),'_blank');	
});

$('.ws_alipay_select_protype').live('change',function(){
	ws_alipay_sl_multiPrice( $(this) );
});




});//END OF JQ

