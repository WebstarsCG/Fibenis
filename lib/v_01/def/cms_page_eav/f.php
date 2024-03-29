<?php

include_once($LIB_PATH . "/inc/lib/f_addon.php");

use GuzzleHttp\Client;

use GuzzleHttp\Query;

if (@$_GET['key']) {

	$WHERE_FILTER = " WHERE entity_code='PG' AND get_eav_addon_varchar(id,'PGHS') IS NULL AND is_active=1 AND " .
		" get_page_coach_code(id) = '$COACH[name]' AND id NOT IN($_GET[key]) " .
		" ORDER BY sn";
} else {
	$WHERE_FILTER = " WHERE entity_code='PG' AND get_eav_addon_varchar(id,'PGHS') IS NULL AND is_active=1 AND " .
		" get_page_coach_code(id) = '$COACH[name]' ORDER BY sn";
}

$status_option = '<option value="2">Active</option><option value="1">In-Active</option>';

//F_series definition:

$F_SERIES	=	array(
	#Desk Title

	'title'	=> 'Page',

	'gx' => 1,

	#Table field

	'data'	=>   array(


		'17' => array(
			'field_name' => 'Basic',
			'type'       => 'heading',

		),



		'26' => array(
			'field_name' => 'Coach',

			'field_id' => 'ec_id',

			'type' => 'option',

			'option_data' => $G->option_builder('entity_child', "id,get_eav_addon_varchar(id,'ECSN')", " WHERE entity_code='CH' ORDER BY get_eav_addon_varchar(id,'ECSN'),line_order ASC "),

			'is_mandatory' => 1,


			'child_table'         => 'eav_addon_ec_id', // child table 

			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field

			'child_attr_code'     => 'PGCH',           // attribute code               
		),


		'14' => array(
			'field_name' => 'Root',

			'field_id' => 'ec_id',


			'child_table'         => 'eav_addon_ec_id', // child table 

			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field

			'child_attr_code'     => 'ECPR',           // attribute code

			'type' => 'option',

			'option_default' => array('label' => 'Select Parent Page', 'value' => ''),

			#'option_data'=>$G->option_builder('entity_child','id,IF((parent_id>0),concat((SELECT sn FROM entity_child as ec WHERE ec.id=entity_child.parent_id),\' -> \',sn),sn) as sn',$WHERE_FILTER.' ORDER BY sn,line_order ASC'),

			'option_data' => $G->option_builder('entity_child', "id,IF(( IFNULL(get_ec_parent_id_eav(id),0)>0),concat(get_eav_addon_varchar(get_ec_parent_id_eav(id),'ECSN'),' -> ',get_eav_addon_varchar(id,'ECSN')),get_eav_addon_varchar(id,'ECSN')) as sn", $WHERE_FILTER),

			'is_mandatory' => 0,

			'avoid_empty_zero' => 1,

			'input_html' => 'class="w_250"  ',


		),


		'1' => array(
			'field_name' => 'Entity',

			'field_id' => 'entity_code',

			'type' => 'option',

			'option_data' => $G->option_builder('entity', 'code,sn', " WHERE code='PG' OR code='BL'  ORDER by sn ASC"),

			'is_mandatory' => 1,

			'input_html' => 'class="w_100"'

		),

		'10' => array(
			'field_name' => 'Date',

			'field_id' => 'date',

			'type' => 'date',

			'is_mandatory' => 1,

			'input_html' => 'class="w_200"'
		),

		'11' => array(
			'field_name' => 'Date',

			'field_id' => 'date_II',

			'type' => 'date',

			'is_mandatory' => 1,

			'input_html' => 'class="w_200"'
		),

		'8' => array(
			'field_name' => 'Page Code',

			'field_id' => 'ea_value',

			'child_table'         => 'eav_addon_vc128uniq', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'PGCD',           // attribute code

			'type' => 'text',

			'is_mandatory' => 1,

			'input_html' => 'class="w_200" maxlength="75"  onkeypress ="return PR_All_Alpha_Numeric(event,\'-_.\');"'
		),

		'25' => array(
			'field_name' => 'Page Redirection Code ',

			'field_id' => 'ea_value',

			'type' => 'text',

			'child_table'         => 'eav_addon_varchar', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'PGRD',           // attribute code

			'is_mandatory' => 0,

			'input_html' => ' class="w_200" maxlength="256" onkeypress = "return PR_All_Alpha_Numeric(event,\'? -_.\');"'

		),

		'6' => array(
			'field_name' => 'Menu Name',

			'field_id' => 'ea_value',

			'child_table'         => 'eav_addon_varchar', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'ECSN',           // attribute code

			'type' => 'text',

			'is_mandatory' => 1,

			'input_html' => 'class="w_200"  maxlength="64"  onkeypress="return PR_All_Alpha_Numeric(event,\' -_.\');"'

		),

		'2' => array(
			'field_name' => 'Page Title',

			'field_id' => 'ea_value',

			'child_table'         => 'eav_addon_varchar', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'ECLN',           // attribute code

			'type' => 'text',

			'is_mandatory' => 1,

			'input_html' => 'class="w_350" maxlength="120" onkeypress = "return PR_All_Alpha_Numeric(event,\' -_.\');"'

		),

		'23' => array(
			'field_name' => 'Meta Cont.',
			'type'       => 'heading',

		),


		'24' => array(
			'field_name' => 'Page Title',

			'field_id' => 'ea_value',

			'type' => 'text',

			'child_table'         => 'eav_addon_varchar', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'PGPT',           // attribute code

			'is_mandatory' => 0,

			'input_html' => ' class="w_400" maxlength="256" onkeypress = "return PR_All_Alpha_Numeric(event,\' -_.\');"'

		),


		'15' => array(
			'field_name' => 'Page KeyWord',

			'field_id' => 'ea_value',

			'type' => 'textarea',

			'child_table'         => 'eav_addon_varchar', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'PGKW',           // attribute code

			'is_mandatory' => 0,

			'input_html' => ' class="w_350" maxlength="550" onkeypress = "return PR_All_Alpha_Numeric(event,\' -_.\');"'

		),
		'16' => array(
			'field_name' => 'Page Description',

			'field_id' => 'ea_value',

			'type' => 'textarea',

			'child_table'         => 'eav_addon_varchar', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'PGPD',           // attribute code

			'is_mandatory' => 0,

			'input_html' => ' class="w_350" maxlength="400" onkeypress = "return PR_All_Alpha_Numeric(event,\' -_.\');"'

		),

		'18' => array(
			'field_name' => 'Content',
			'type'      => 'heading',

		),



		'5' => array(
			'field_name' => 'Page Content',

			'field_id' => 'ea_value',


			'child_table'         => 'eav_addon_text', // child table 
			'parent_field_id'     => 'parent_id',    // parent field

			'child_attr_field_id' => 'ea_code',   // attribute code field
			'child_attr_code'     => 'ECDT',           // attribute code


			'type' => 'code_editor',

			//'type'=>'textarea',
			#'type'=>'textarea',

			//'editor'=>array('height'=>300),

			'is_mandatory' => 0,

			'input_html' => ' style="width:500px;font-weight:normal !important;" rows=15 ',



		),




		'19' => array(
			'field_name' => 'Others',
			'type' 	     => 'heading',

		),



		'3' => array(
			'field_name' => 'Status',

			'field_id' => 'is_active',

			'type' => 'option',

			'option_data' => $status_option, //$G->option_builder('entity_attribute','code,sn',' WHERE entity_code="PP"  ORDER BY sn ASC'),

			'filter_in' => function ($data_in) {

				return ($data_in - 1);
			},


			'filter_out' => function ($data_in) {

				return ($data_in + 1);
			},

			'avoid_default_option' => 1,

			'is_mandatory' => 1,

			'input_html' => ' class="W_150"'

		),


		'4' => array(
			'field_name' => 'Line Order',

			'field_id' => 'line_order',

			'type' => 'text',

			'is_mandatory' => 1,

			'input_html' => ' class="w_50" ',


		),




		'13' => array(
			'field_name' => 'Event Image',

			'field_id' => 'image',

			'type' => 'file',

			'upload_type' => 'image',

			'location' => 'images/gallery/',

			'image_size' => array(500 => 500, 300 => 300, 150 => 150),

			'is_mandatory' => 0,

			'input_html' => 'class="W_150"'

		),

		# addon Image A
		'21' => array(),

		# addon Image B
		'22' => array(),




	),

	#Table Name

	'table_name'    => 'entity_child',

	#Primary Key

	'key_id'        => 'id',


	'after_add_update' => 1,

	# tab

	'divider' => 'tab',

	'form_layout'   	=> 'form_100',

	# Default Additional Column

	'is_user_id'       => 'user_id',

	'default_fields'    => array('entity_code' => "'PG'"),

	# Communication

	'back_to'  => array('is_back_button' => 1, 'back_link' => '?d=cms_page_eav', 'BACK_NAME' => 'Back'),

	'prime_index'   => 1,

	# File Include
	//'after_add_update'	=>1,

	'js'            => array('is_top' => 1, 'top_js' => 'js/f_series/manage_cms'),


	'show_query'    => 0,

	'avoid_trans_key_direct' => 1

);




$no_row = $G->table_no_rows(array('table_name' => 'entity_child', 'WHERE_FILTER' => " AND entity_code='PG' AND get_eav_addon_num(id,'ECPR')=0"));

$line_order = $no_row[0] + 1;

$F_SERIES['data']['4'] = array(
	'field_name' => 'Line Order',

	'field_id' => 'line_order',

	'type' => 'text',

	'is_mandatory' => 1,

	'input_html' => 'class="w_50" value=' . $line_order,

);


$F_SERIES['data']['9'] = array(
	'field_name' => 'Page Layout',

	'field_id' => 'ea_value',

	'type' => 'option',

	'option_data' => $G->option_builder('entity_child_base', 'token,sn', " WHERE entity_code='PL' ORDER BY sn"),

	'child_table'         => 'eav_addon_varchar', // child table 
	'parent_field_id'     => 'parent_id',    // parent field

	'child_attr_field_id' => 'ea_code',   // attribute code field
	'child_attr_code'     => 'PGPL',

	'is_mandatory' => 1,

	'input_html' => ' class="w_125" value=' . $line_order,
);

$F_SERIES['data'][20]   = array(

	'type' 	  => 'option',
	'field_name' => 'Content Template & Addon Type',
	'field_id'   => 'ea_value',

	'child_table'         => 'eav_addon_varchar', // child table 
	'parent_field_id'     => 'parent_id',    // parent field

	'child_attr_field_id' => 'ea_code',   // attribute code field
	'child_attr_code'     => 'PGAT',

	//'option_default'=> array('label'=>'Basic','value'=>'basic'),

	'option_data' => $G->option_builder('entity_child_base', "get_ecb_av_addon_varchar(id,'ATKH'),ln", " WHERE entity_code='AT' "),


);


// Image size auto	

$page_img_size_auto =  $SG->get_session('page_img_size_auto');

$temp_coach_img_path = "$COACH[path]/$COACH[name]/";


$F_SERIES['data']['13'] = array(
	'field_name'	=> 'Feature Image',

	'field_id' 	=> 'ea_value',

	'type' 		=> 'file',

	'child_table'         => 'eav_addon_varchar', // child table 
	'parent_field_id'     => 'parent_id',    // parent field

	'child_attr_field_id' => 'ea_code',   // attribute code field
	'child_attr_code'     => 'PGIA',

	'upload_type' 	=> 'image',

	'save_file_name_prefix' => 'a_',

	'location' => $temp_coach_img_path . $SG->get_session('page_img_a_path'),
	'image_size' => json_decode($SG->get_session('page_img_a_size'), TRUE),
	'is_mandatory' => 0,
	'input_html' => 'class="w_150"'

);

if ($page_img_size_auto) {

	#$F_SERIES['data']['13']['image_size_auto'] = json_decode($page_img_size_auto,TRUE);
}



# addon image

$F_SERIES['data']['21'] = array(
	'field_name' => 'Header Image',

	'field_id' 	=> 'ea_value',

	'type' 		=> 'file',

	'child_table'         => 'eav_addon_varchar', // child table 
	'parent_field_id'     => 'parent_id',    // parent field

	'child_attr_field_id' => 'ea_code',   // attribute code field
	'child_attr_code'     => 'PGIB',

	'upload_type' 	=> 'image',

	'save_file_name_prefix' => 'b_',

	'location' => $temp_coach_img_path . $SG->get_session('page_img_b_path'),
	'image_size' => json_decode($SG->get_session('page_img_b_size'), TRUE),

	'is_mandatory' => 0,

	'input_html' => 'class="w_150"'

);


$F_SERIES['data']['22'] = array(
	'field_name' => 'Right Image',

	'field_id' 	=> 'ea_value',

	'type' 		=> 'file',

	'child_table'         => 'eav_addon_varchar', // child table 
	'parent_field_id'     => 'parent_id',    // parent field

	'child_attr_field_id' => 'ea_code',   // attribute code field
	'child_attr_code'     => 'PGIC',

	'upload_type' 	=> 'image',

	'save_file_name_prefix' => 'c_',

	'location' => $temp_coach_img_path . $SG->get_session('page_img_c_path'),
	'image_size' => json_decode($SG->get_session('page_img_c_size'), TRUE),

	'is_mandatory' => 0,

	'input_html' => 'class="w_150"',



);

$F_SERIES['page_code'] = 'FMPG';

unset($F_SERIES['data'][10]);  //date
unset($F_SERIES['data'][11]);  //date
unset($F_SERIES['data'][1]);  //entity code 


// image addon

if (@$SG->get_cookie('page_img_addon')) {

	array_push(
		$F_SERIES['data'],
		[
			'field_name' => "Image",
			'type' => 'heading'
		]
	);

	// add in image
	foreach (['c', 'd', 'e', 'f'] as $addon_img_key) {

		$temp['page_img_prefix']      = 'page_img_' . $addon_img_key;

		$temp['page_img_title']       = @$SG->get_cookie($temp['page_img_prefix'] . '_title');

		$temp['page_img_name_prefix'] = @$SG->get_cookie($temp['page_img_prefix'] . '_prefix');

		$temp['page_img_size_auto']   = @$SG->get_cookie($temp['page_img_prefix'] . '_size_auto');

		$temp['page_img_size']   = @$SG->get_cookie($temp['page_img_prefix'] . '_size');

		if (@$temp['page_img_title']) {


			$temp_image = array(
				'field_name' => $temp['page_img_title'],

				'field_id' => 'image_' . $addon_img_key,

				'type' => 'file',

				'upload_type' => 'image',

				//'save_file_name' => 'image_'.$addon_img_key.'_',  

				'location' => $SG->get_cookie($temp['page_img_prefix'] . '_path'),
				'image_size' => json_decode($temp['page_img_size'], TRUE),

				'is_mandatory' => 0,

				'save_file_name_prefix' => $temp['page_img_name_prefix'],

				'input_html' => 'class="w_250"'

			);

			if ($temp['page_img_size_auto']) {
				$temp_image['image_size_auto'] = json_decode($temp['page_img_size_auto'], TRUE);
			}

			array_push($F_SERIES['data'], $temp_image);
		} // img title end

	} // addon image
} // addon



// option token	

if (@$_GET['default_addon']) {

	$temp['addon'] = $_GET['default_addon'];

	@$F_SERIES['temp'] = f_addon([
		'g'		   => $G,
		'rdsql'		   => $rdsql,
		'is_cache'		  => 0,
		'f_series'     	   => ['data' => $F_SERIES['data']],
		'default_addon'	   => json_encode(['at' => $temp['addon']])
	]);

	if ($F_SERIES['temp']['rows'] > 0) {

		$F_SERIES['data'] = $F_SERIES['temp']['data'];
	}

	$F_SERIES['data']['20']['avoid_default_option'] = 1;

	$F_SERIES['data']['20']['option_data'] = $G->option_builder(
		' entity_child_base',
		" get_ecb_av_addon_varchar(id,'ATKH'),ln ",
		" WHERE entity_code='AT' "
	);
} // default addon

$F_SERIES['avoid_trans_key_direct'] = 1;

// after add update

function after_add_update($key_id)
{

	global $rdsql, $G, $LIB_PATH, $PASS_ID;

	$lv         = [];
	$lv['temp'] = [];

	$lib = $LIB_PATH . '/comp/guzzle_rest/vendor/autoload.php';

	require_once $lib;

	$lv['temp'] = $G->get_one_column([
		'field' => "concat(id,'[C]',get_eav_addon_vc128uniq(id,'PGCD'),'[C]',get_eav_addon_varchar(id,'PGAT'),'[C]',get_page_coach_code(id))",
		'table' => 'entity_child',
		'manipulation' => " WHERE id=$key_id"
	]);

	$lv['t_detail'] = explode('[C]', $lv['temp']);


	// addon template token

	$lv['addon_detail'] = $G->get_one_column([
		'field' => "concat(token,'[S]',sn)",
		'table' => 'entity_child_base',
		'manipulation' => " WHERE get_ecb_av_addon_varchar(id,'ATKH')='" . $lv['t_detail'][2] . "'"
	]);

	list($lv['engine'], $lv['def']) = explode('[S]', $lv['addon_detail']);

	$lv['trans_key'] = time() . rand() . $PASS_ID;

	$lv['temp_key'] = $G->encrypt($lv['temp'], $lv['trans_key']);



	$client = new Client([
		// You can set any number of default request options.
		'timeout'  => 2.0,
	]);

	#print_r($lv);

	//$node_res = 	$client->GET($_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"],
	//			     ['query'=>[  $lv['engine']  => $lv['def'],
	//				          'req'       => $lv['temp_key'],
	//				     	  'trans_key' => $lv['trans_key']
	//					]
	//				]
	//		);


	$node_res = 	$client->GET(
		$_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"],
		[
			'query' => [
				$lv['engine']  => 'cms_page_eav',
				'req'       => $lv['temp_key'],
				'trans_key' => $lv['trans_key'],
				'clear_cache' => 1
			]
		]
	);

	#print_r($node_res);

} // end
