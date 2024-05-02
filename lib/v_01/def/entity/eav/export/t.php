<?PHP
        $t_series       = ['filter'=>'','modes'=>['A','a'],'is_valid_key'=>1,'wm'=>'',];	
		$key        	= @$_GET['key'];

		if(!$key){
			
			http_response_code(400);
			echo $G->sendContentTypeJSON(['status'=>false,'message'=>"Give the entity code in key param to export the entity attributes."]);
			exit();

		}else{

			$key = $G->getCleanAlphaNum($key);

			$t_series['is_valid_key'] = $G->get_one_columm(['table'		  => 'entity',
															'field'		  => 'count(*)',
			                                                'manipulation'=> " WHERE code='$key' and is_lib=0"]	);
			if($t_series['is_valid_key']==0){
				http_response_code(400);
				echo $G->sendContentTypeJSON(['status'=>false,'message'=>"The given entity_code is not a valid one"]);
				exit();
			}

		} // end
		
		
		$t_series['wm'] = @$_GET['wm'] ?? '';
    																														
		if(isset($_GET['tokens'])){			
			$t_series['filter'] =  set_filter($_GET['tokens']);			
		}

		// mode
		if($t_series['wm']){

			if (in_array($t_series['wm'],$t_series['modes'])==false) {
				http_response_code(400);
				echo $G->sendContentTypeJSON(['status'=>false,'message'=>"The given write mode is not a valid one"]);
				exit();
			}

		} // end

        $T_SERIES       = array(
		
								'table'	=>	'entity',
								 
								'data'=>	array(
													'code'=>array('field' => 'code'),
													'name'=>array('field' => 'sn'),
													'wm'=>array('field' => "UPPER('$t_series[wm]')"), //write_mode
													'attributes'=>array(
'is_child_addon' =>1,

'child_data'   =>array(

				'1'=>array('key'=>'token','field'=>'token'),
				'2'=>array('key'=>'name','field'=>'sn'), 
				'3'=>array('key'=>'description','field'=>'ln'),
						
						//rxmatch
						//(\'|\")(\d+)(\'|\")(\=\>)(\w+)(\(\s*)(\'|\")(key)(\'|\")(\=\>)(\'|\")(\w+)(\'|\")(\s*)(.*?)(id,\s*\')(\w{4})([\'\)\"\s]+)(\,)
						//<TMPL_IF \12><\12><TMPL_VAR \12></\12></TMPL_IF>
						
				'4'=>array( 'key'=>'input_type',										'field'=>"get_ecb_av_addon_varchar(id,'APIT')" ),
				'5'=>array( 'key'=>'class',															'field'=>"get_ecb_av_addon_varchar(id,'APCL')" ),
				'6'=>array( 'key'=>'html',																'field'=>"get_ecb_av_addon_varchar(id,'APIH')" ),
				'7'=>array( 'key'=>'mandatory',											'field'=>"get_ecb_av_addon_varchar(id,'APMA')" ), 
				'8'=>array( 'key'=>'hint',																'field'=>"get_ecb_av_addon_varchar(id,'APHT')" ),
				'9'=>array( 'key'=>'hide',																'field'=>"get_ecb_av_addon_varchar(id,'APHD')" ),
				'10'=>array('key'=>'read_only',											'field'=>"get_ecb_av_addon_varchar(id,'APRO')" ),
						
				'11'=>array( 'key'=>'allow',											   'field'=>"get_ecb_av_addon_varchar(id,'APAL')" ),
				
				'12'=>array( 'key'=>'list_option_data',			 'field'=>"get_ecb_av_addon_varchar(id,'APSL')"
								
				),
				'13'=>array( 'key'=>'list_avoid_default',		'field'=>"get_ecb_av_addon_varchar(id,'APAD')" ),
				
				'14'=>array( 'key'=>'min_date',											 'field'=>"get_ecb_av_addon_varchar(id,'APMD')" ),
				'15'=>array( 'key'=>'max_date',										  'field'=>"get_ecb_av_addon_varchar(id,'APXD')" ),																							
				'16'=>array( 'key'=>'min_year',											 'field'=>"get_ecb_av_addon_varchar(id,'APMY')" ),
				'17'=>array( 'key'=>'max_year',										  'field'=>"get_ecb_av_addon_varchar(id,'APXY')" ),
				'18'=>array( 'key'=>'default_date',						  'field'=>"get_ecb_av_addon_varchar(id,'APDD')" ),
				
				'19'=>array( 'key'=>'fg_start_rows', 					 'field'=>"get_ecb_av_addon_varchar(id,'APFR')" ),
				'20'=>array( 'key'=>'fg_max_rows',							  'field'=>"get_ecb_av_addon_varchar(id,'APMR')" ),																							
				'21'=>array( 'key'=>'fg_rows_to_fill',	    'field'=>"get_ecb_av_addon_varchar(id,'APGR')" ),
				'22'=>array( 'key'=>'fg_content_template',	'field'=>"get_ecb_av_addon_varchar(id,'APTM')" ),
				'23'=>array( 'key'=>'fg_heading_template',	'field'=>"get_ecb_av_addon_varchar(id,'APFH')" ),
				'24'=>array( 'key'=>'fg_detail',          	'field'=>"get_ecb_av_addon_varchar(id,'APFO')" ),
				
				'25'=>array( 'key'=>'file_name', 			 'field'=>"get_ecb_av_addon_varchar(id,'APFN')" ),
				'26'=>array( 'key'=>'file_name_prefix',		  'field'=>"get_ecb_av_addon_varchar(id,'APFP')" ),																							
				'27'=>array( 'key'=>'file_name_suffix',    'field'=>"get_ecb_av_addon_varchar(id,'APFS')" ),
				'28'=>array( 'key'=>'file_location',	      'field'=>"get_ecb_av_addon_varchar(id,'APLO')" ),
				'29'=>array( 'key'=>'file_allow_type',    	'field'=>"get_ecb_av_addon_varchar(id,'APFX')" ),
				'30'=>array( 'key'=>'file_max_size',      	'field'=>"get_ecb_av_addon_varchar(id,'APFM')" ),
				'31'=>array( 'key'=>'file_img_size',      	'field'=>"get_ecb_av_addon_varchar(id,'APIS')" ),
																													
				'32'=>array( 'key'=>'tg_show_status_label','field'=>"get_ecb_av_addon_varchar(id,'APTS')" ),																							
				'33'=>array( 'key'=>'tg_on_label',         'field'=>"get_ecb_av_addon_varchar(id,'APTN')" ),
				'34'=>array( 'key'=>'tg_off_label',	       'field'=>"get_ecb_av_addon_varchar(id,'APTF')" ),
				'35'=>array( 'key'=>'tg_is_default_on',   	'field'=>"get_ecb_av_addon_varchar(id,'APTD')" ),																							
				'36'=>array( 'key'=>'label_content',      	'field'=>"get_ecb_av_addon_varchar(id,'APLC')" ),

				'37'=>array('key'=>'line_order','field'=>'line_order'), // base
				
				// desk
				'38'=>array( 'key'=>'is_desk_exists',			'field'=>"get_ecb_av_addon_varchar(id,'ADXI')" ),
				'39'=>array( 'key'=>'desk_col_header_name',		'field'=>"get_ecb_av_addon_varchar(id,'ADXN')" ),
				'40'=>array( 'key'=>'desk_col_header_attr',		'field'=>"get_ecb_av_addon_varchar(id,'ADXH')" ),
				'41'=>array( 'key'=>'desk_col_attr',			'field'=>"get_ecb_av_addon_varchar(id,'ADXC')" ),
				'42'=>array( 'key'=>'desk_col_filter_out',		'field'=>"get_ecb_av_addon_varchar(id,'ADXF')" ),
				'43'=>array( 'key'=>'desk_col_js_call',			'field'=>"get_ecb_av_addon_varchar(id,'ADXJ')" ),
				'44'=>array( 'key'=>'desk_col_sort',			'field'=>"get_ecb_av_addon_varchar(id,'ADXS')" ),
				'45'=>array( 'key'=>'desk_col_line_order',		'field'=>"get_ecb_av_addon_varchar(id,'ADLO')" ),
				
				'46'=>array( 'key'=>'avoid_empty_zero',			'field'=>"get_ecb_av_addon_varchar(id,'APEZ')" ),
				
				'47'=>array( 'key'=>'desk_column_query',			'field'=>"get_ecb_av_addon_varchar(id,'ADXQ')" ),
				
				'48'=>array( 'key'=>'option_label',					'field'=>"get_ecb_av_addon_varchar(id,'APLL')" ),
				
				'49'=>array( 'key'=>'option_lbl_col_query',		'field'=>"get_ecb_av_addon_varchar(id,'APOL')" ),
				
				
				
	),
									
								'table'=> ' entity_child_base',
								'key_filter'=>" AND entity_code='$key' AND dna_code='EBAT' 
												$t_series[filter]",
								'show_query'=>0,
								

							),

	),	
								
								
		'key_id' 	=> 'code',								
		'key_filter'=> '',								
		'is_cc'		=>1,
		'template'	=> dirname(__FILE__).'/t.html',													// save data 
																																
		'save_as'	=> array(																																		
								array(	'type'	 	=> 'xml',
											'file_name' =>"entity_export_".$key."_".time(),																				
											'path'	 	=>  'csv/'																													
									)																												
							)

	);
		



	//  set token
	function set_filter($in){	
				
		$lv = ['neutral'=>[]];

		$lv['tokens']=explode(',',$in);
		
		foreach($lv['tokens'] as $k => $v){
			array_push($lv['neutral'],"'".$v."'");
		}
		
		return " AND token IN (".implode(',',$lv['neutral']).")";
		
		
	}
		    	    
?>