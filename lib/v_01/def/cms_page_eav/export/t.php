<?PHP

$T_SERIES = array(


	'table' => 'entity',

	'data' => array(

		'page_info' => array(

			'page_title' => array('field' => "get_eav_addon_varchar(id,'ECLN')"),
			'menu_name' => array('field' => "get_eav_addon_varchar(id,'ECSN')"),
			'page_code' => array('field' => "get_eav_addon_vc128uniq(id,'PGCD')"),
			'page_redirection_code' => array('field' => "get_eav_addon_varchar(id,'PGRD')"),
			'page_keyword' => array('field' => "get_eav_addon_varchar(id,'PGKW')"),
			'page_description' => array('field' => "get_eav_addon_varchar(id,'PGPD')"),
			'feature_image' => array('field' => "get_eav_addon_varchar(id,'PGIA')"),
			'header_image' => array('field' => "get_eav_addon_varchar(id,'PGIB')"),
			'right_image' => array('field' => "get_eav_addon_varchar(id,'PGIC')"),
			'page_layout' => array('field' => "get_eav_addon_varchar(id,'PGPL')"),
			'page_content' => array('field' => "get_eav_addon_varchar(id,'ECDT')"),
			'content_template' => array('field' => "get_eav_addon_varchar(id,'PGAT')"),
			'root' => array('field' => "get_eav_addon_varchar(id,'ECPR')"),


		),
	),

	'key_id' => '',


	'key_filter' => " AND code='PG'  ",

	'show_query' => 1,

	'template' => dirname(__FILE__) . '/t.html',


	// save data 
	'save_as' => array(

		array(
			'type' => 'xml',
			'file_name' => "csv/cms_page_export_" . time(),
			'path' => '.'

		)
	)

);
