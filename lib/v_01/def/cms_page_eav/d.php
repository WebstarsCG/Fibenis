<?PHP
$LAYOUT	    = 'layout_basic';

$D_SERIES       =   array(
	'title' => 'Pages',

	#query display depend on the user

	'is_user_base_query' => 0,

	'gx' => 1,

	#table data

	'data' => array(

		7 => array(
			'th' => 'Coach',

			'field' => "get_page_coach_code(id)",


			'td_attr' => ' class="label_grand_child align_LM" width="10%"',

		),

		1 => array(
			'th' => 'Menu Name',

			'field' => "get_eav_addon_varchar(id,'ECSN')",

			/*'html'      =>  'style	= "cursor:pointer" onclick="JavaScript:E_V_PASS(\'sort_field\',1);E_V_PASS(\'sort_direction\',GET_E_VALUE(\'sort_col_1\'));filter_data();"',
								  
								'font'      =>  'class="sort"',*/

			'span'      =>  '<span id="sort_icon_1" name="sort_icon_1"></span>',

			'td_attr' => ' width="10%" class="clr_dark_blue"',

		),


		//3=>array('th'=>'Page Title ',
		//		 
		//	'field'=>"get_eav_addon_varchar(id,'ECLN')",
		//                                                            
		//		 
		//	'attr' => [ 'class'=>'label_father align_LM', 'width'=>'15%'],
		//		 
		//	),
		//


		6 => array(
			'th' => 'Parent',

			'field' => " ifnull((get_eav_addon_varchar(get_ec_parent_id_eav(id),'ECSN')),' NA ')",

			'td_attr' => ' class="label_grand_child align_LM" width="10%"',

		),


		8 => array(
			'th' => 'Addon',

			'field' => "(SELECT ln FROM entity_child_base as ecb WHERE get_ecb_av_addon_varchar(ecb.id,'ATKH')=get_eav_addon_varchar(entity_child.id,'PGAT'))",


			'td_attr' => ' class="align_LM clr_gray_9" width="10%" ',

			'filter_out' => function ($data_in) {

				return str_replace('[S]', '=', $data_in);
			}
		),

		2 => array(
			'th' => 'Status',

			'field' => "CONCAT(id,'[C]',is_active)",

			'filter_out' => function ($data_in) {

				$temp     = explode('[C]', $data_in);

				$flag     = [1, 0];

				$data_out = array(
					'data' => array(
						'id'   => $temp[0],
						'key'  => md5($temp[0]),
						'label' => 'Page',
						'cv'   => $temp[1],
						'fv'   => $flag[$temp[1]],
						'action' => 'entity_child',
						'series' => 'a',
						'token' => 'ECAI'
					)
				);

				return json_encode($data_out);
			},


			'td_attr' => ' class="align_CM" width="5%"',

			'js_call' => 'd_series.inline_on_off',

		),

		10 => array(
			'th'	=> 'Section', 'th_attr' => ' colspan=2 ',

			'field'	=> "concat(id,':',(SELECT COUNT(*) FROM eav_addon_ec_id WHERE ea_code='ECPR' AND ec_id=entity_child.id AND parent_id IN (SELECT id FROM entity_child WHERE entity_code='SC')))",

			'attr' =>  ['class' => "align_CM", 'width' => "5%"],

			'filter_out' => function ($data_in) {
				$temp = explode(':', $data_in);

				$data_out = array(
					'id'   => $temp[0],

					'link_title' => '  ' . $temp[1],
					'is_fa' => ' fa-chevron-circle-right clr_dark_blue fa-lg ',
					'is_fa_btn' => ' btn-default btn-sm ',
					'title' => 'Child View',
					'src' => "?d=page_section&menu_off=1&mode=simple&default_addon=$temp[0]",
					'style' => "border:none;width:100%;height:600px;"
				);
				return json_encode($data_out);
			},

			'js_call' => 'd_series.set_nd'



		),

		11 => array(
			'th'	=> '',

			'field'	=> 'id',

			'attr' =>  ['class' => "brdr_right align_CM", 'width' => '5%'],

			'filter_out' => function ($data_in) {

				$data_out = array(
					'id'   => $data_in,
					'link_title' => 'Add Child',
					'is_fa' => ' fa fa-plus-square-o clr_dark_blue fa-lg',
					'title' => 'Add Child',
					'src' => "?f=page_section&menu_off=1&mode=simple&default_addon=$data_in",
					'style' => "border:none;width:100%;height:600px;"
				);

				return json_encode($data_out);
			},

			'js_call' => 'd_series.set_nd'

		),

		26 => array(
			'th' => 'Template',

			'td_attr' => ' class="align_CM no_wrap" width="5%"',

			'field'     =>  "concat(id,':',ifnull(get_eav_addon_ecb_id(id,'PGTM'),''))",

			'filter_out' => function ($data_in) {

				$temp  = explode(':', $data_in);
				$param = array('p' => $temp[0]);

				if ($temp[1] == '') {
					$link_title = 'Add Child';
					$fa = ' fa fa-plus-square-o clr_dark_blue fa-lg';
					$title = 'Add Template';
				} else {
					$fa = ' fa fa-edit clr_dark_blue fa-lg';
					$title = 'Modify Template';
					$param['t'] = $temp[1];
				}

				$temp[2] = urlencode(json_encode($param));

				$data_out = array(
					'id'   => $temp[0],
					'link_title' => $link_title,
					'is_fa' => $fa,
					'title' => $title,
					'src' => "?f=page_section__set_template&menu_off=1&mode=simple&default_addon=$temp[2]",
					'style' => "border:none;width:100%;height:600px;",
					'refresh_on_close' => 1
				);

				return json_encode($data_out);
			},

			'js_call' => 'd_series.set_nd'


		),

		25 => array(
			'th'        =>  'Pub.',

			'field'     =>  "id",

			'td_attr'   =>  ' class="label_child align_CM" width="5%"',

			'filter_out' => function ($data_in) {

				return '<a class="pointer clr_gray_b txt_size_11 tip_bottom" onclick="JavaScript:coach_content(' . "'$data_in'" . ');">' .
					'<i class="fa fa-send clr_green txt_size_18" aria-hidden="true"></i>&nbsp;' .
					'</a><span class="tooltiptext">Update Page</span>';


				//return '<a href="JavaScript:coach_content('."'$data_in'".');">Publish</a>';

			}, // end of function

		),



		5 => array(
			'th' => 'Updation',

			'field' => "concat(get_user_internal_name(user_id),',',date_format(timestamp_punch,'%d-%b-%y %T'))",

			'td_attr' => 'width="18%"',

			'js_call' => 'show_user_info',

			'is_sort' => 'timestamp_punch'

		),


		9 => array(
			'th' => 'Action',

			'field' => "concat(id,':',IFNULL(get_eav_addon_varchar(id,'PGAT'),0))",

			'td_attr' => 'width="10%"',

			'filter_out' => function ($data_in) {

				$temp = explode(':', $data_in);

				return '<a class="ficon" href=?f=cms_page_eav&key=' . $temp[0] . (($temp[1]) ? "&default_addon=$temp[1]" : '') . '>' .
					'<i class="fa fa-edit"></i>Edit' .
					'</a>';
			}
		),




		//  5=>array('th'=>'Content',
		//		 
		//	'field'=>'detail as v5',
		//                                                            
		//	//'html'      =>  'style	= "cursor:pointer" onclick="JavaScript:E_V_PASS(\'sort_field\',2);E_V_PASS(\'sort_direction\',GET_E_VALUE(\'sort_col_2\'));filter_data();"',
		//	  
		//	//'font'      =>  'class="sort"',
		//									
		//	
		//		 
		//	'td_attr' => ' class="label_child align_LM" width="50%"',
		//		 
		//	),
		//





	),


	#Sort Info

	'sort_field' => array(
		"get_eav_addon_varchar(id,'ECCD')",

		"get_eav_addon_varchar(id,'ECSN')"
	),

	'action' => array('is_action' => 0, 'is_edit' => 0, 'is_view' => 0),

	'order_by'   => 'ORDER BY id ASC ',


	#Table Info

	'table_name' => 'entity_child',

	'key_id'    => 'id',

	# Default Additional Column

	'is_user_id'       => 'user_id',

	'key_filter'     =>	 " AND  entity_code='PG' AND get_eav_addon_bool(id,'PGHS') IS NULL ",

	# Communication

	'prime_index'   => 1,

	'search' => array(

		array(
			'data' 	=> array(
				'table_name' => 'entity_child',
				'field_id'   => 'id',
				'field_name' => "get_eav_addon_varchar(id,'ECLN')",
				'filter'	    => " AND entity_code='PG' "
			),

			'title' => 'Page Title',

			'search_key' => 'id',

		),

	),

	'is_narrow_down' => 1,

	'before_delete' => 1,


	# include

	'js'            => array(
		'is_top' => 1, 'top_js' => $LIB_PATH . 'def/cms_page_eav/d',

	),


	'bulk_action' => array(
		array(
			'is_bulk_button' => 1,
			'button_name'    => ' Update Content ',
			'js_call'        => 'recreate_page'
		)

	),



	# summary:

	/*'summary_data'=>array(
							array(  'name'=>'No Data','field'=>'count(id)','html'=>'class=summary'),
				
				                   ),*/

	'custom_filter' => array(

		array(
			'field_name' 	=> 'Coach',

			'field_id' 	=> 'cf_ii',

			'filter_type' 	=> 'option_list',

			'option_value'	=> $G->option_builder('entity_child', "id,get_eav_addon_varchar(id,'ECSN')", " WHERE entity_code='CH'  ORDER BY get_eav_addon_varchar(id,'ECSN'),line_order ASC"),

			'attr'		=> ['class' => 'w_150'],

			'cus_default_label' => 'Show All',

			'filter_by'  	=> "get_eav_addon_ec_id(id,'PGCH')"
		),


		array(
			'field_name' 	=> 'Parent',

			'field_id' 	=> 'cf_i',

			'filter_type' 	=> 'option_list',

			'option_value'	=> $G->option_builder(
				'entity_child',
				"id,IF(( IFNULL(get_ec_parent_id_eav(id),0)>0),concat(get_eav_addon_varchar(get_ec_parent_id_eav(id),'ECSN'),' -> ',get_eav_addon_varchar(id,'ECSN')),get_eav_addon_varchar(id,'ECSN')) as sn",
				" WHERE entity_code='PG' AND get_eav_addon_bool(id,'PGHS') IS NULL AND is_active=1 ORDER BY sn,line_order ASC"
			),

			'attr'		=> ['class' => 'w_150'],

			'cus_default_label' => 'Show All',

			'filter_by'  	=> "get_ec_parent_id_eav(id)"
		),


		array(
			'field_name' 	=> 'Addon Type',

			'field_id' 	=> 'cf_iii',

			'filter_type' 	=> 'option_list',

			'option_value'	=> $G->option_builder('entity_child_base', "get_ecb_av_addon_varchar(id,'ATKH'),ln", " WHERE entity_code='AT'  ORDER BY sn,line_order ASC"),

			'attr'		=> ['class' => 'w_150'],

			'cus_default_label' => 'Show All',

			'filter_by'  	=> "get_eav_addon_varchar(id,'PGAT')"
		),

	),


	#check_field

	'check_field'   =>  array('user_id' => @$_GET['user_id'], 'page_code' => @$_GET['page_code']),

	'add_button' => array('is_add' => 1, 'page_link' => 'f=cms_page_eav', 'b_name' => 'Add'),

	'del_permission' => array('able_del' => 1, 'user_flage' => 1),

	'date_filter'  => array('is_date_filter' => 0, 'date_field' =>  ''),

	#'action'        =>['is_edit'=>1],

	#export data

	'export_csv'   => array('is_export_file' => 0, 'button_name' => 'Create CSV', 'csv_file_name' => 'csv/log_' . time() . '.csv'),



	'show_query' => 0,

);


// after delete
function before_delete($param)
{

	$lv 	      = array();


	$lv['result'] = $param['g']->get_one_columm([
		'table' => 'entity_child',
		'field' => "get_eav_addon_varchar(id,'ECCD')",
		'manipulation' => " WHERE id=$param[key_id]"
	]);

	$content_page = 'template/page_content/' . $lv['result'] . ".html";

	// delete template associated with page
	$param['rdsql']->exec_query("DELETE FROM eav_addon_ecb_id WHERE parent_id=$param[key_id] AND ea_code='PGTM'", "Error");

	// delete associated sections
	$param['rdsql']->exec_query("DELETE FROM entity_child WHERE entity_code='SC' AND get_ec_parent_id_eav($param[key_id])", "Error");

	if (is_file($content_page)) {

		unlink($content_page);
	}
} // end


$temp_addon = (@$_COOKIE['cms_pageget_field_id2']) ? $_COOKIE['cms_pageget_field_id2'] : @$_GET['cf_iii'];

# addon
if (($temp_addon) && ($temp_addon != -1)) {

	$D_SERIES['add_button']['page_link'] = "f=cms_page_eav&default_addon=$temp_addon";
}
