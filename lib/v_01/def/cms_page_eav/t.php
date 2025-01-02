<?PHP

list($page_id, $page_code, $page_addon, $page_coach_code)    = explode('[C]', $G->decrypt(
	$_GET['req'],
	$_GET['trans_key']
));
$_GET['key']    = $page_id;

$T_SERIES       =   array(

	'table'		=> 'entity_child',

	'data'		=>  array(),


	'key_id' 	=> 'id',

	'key_filter'	=> '',

	'show_query'	=> 1,

	# 'template'      => dirname(__FILE__).'/t.html',

	'template_content' => '',


	// saving the output

	'save_as' => array(

		array(
			'type'		=> 'html',
			'file_name'	=> $page_code,
			'path'		=> "terminal/$page_coach_code/content/"
		)

	)

);



list($T_SERIES['data'], $T_SERIES['template_content']) = get_page_addon_template_content([
	'page_addon_hash' => $page_addon,
	'rdsql' => $rdsql,
	'G' => $G
]);

function get_page_addon_template_content($param)
{


	#print_r($param);

	$lv           = [];

	$lv['content'] = '';
	$lv['t_data']  = [];


	$lv['IT'] = [
		'ITTX' => function ($data_in) {
			return ['field' => "get_exav_addon_varchar(id,'$data_in')"];
		},
		'ITTA' => function ($data_in) {
			return ['field' => "get_exav_addon_text(id,'$data_in')"];
		}


	];

	$lv['page_addon_id'] = $param['G']->get_one_column([
		'table' => 'ecb_av_addon_varchar',
		'field' => 'parent_id',
		'manipulation' => "WHERE ea_code='ATKH' AND ea_value='$param[page_addon_hash]'"
	]);



	$lv['template']  =  $param['G']->get_one_column([
		'table' => 'ecb_av_addon_text',
		'field' => "ea_value",
		'manipulation' => "WHERE ea_code='ATTM' AND parent_id=$lv[page_addon_id]"
	]);

	# each element
	$lv['page_addon_element_result'] = $param['rdsql']->exec_query("SELECT ecb_child_id FROM ecb_parent_child_matrix WHERE ecb_parent_id=$lv[page_addon_id]", "Error");

	while ($lv['page_addon_elements'] = $param['rdsql']->data_fetch_assoc($lv['page_addon_element_result'])) {

		foreach ($lv['page_addon_elements'] as $idx => $element_id) {

			$lv['page_addon_ele_detail_query'] = "SELECT token,get_ecb_av_addon_varchar(id,'APIT') as input_type FROM entity_child_base WHERE id=$element_id";

			$lv['element'] = $param['rdsql']->data_fetch_assoc($param['rdsql']->exec_query($lv['page_addon_ele_detail_query'], "Error"));

			$lv['t_data'][$lv['element']['token']] = $lv['IT'][$lv['element']['input_type']]($lv['element']['token']);
		}
	}

	if (count($lv['t_data']) == 0) {
		$lv['t_data']['DETAIL'] = array('field' => "get_eav_addon_text(id,'ECDT')");
	}

	return [$lv['t_data'], $lv['template']];
} # end
