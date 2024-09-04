	<?php

	//$year = date("Y");

	function f_addon($param){
		
		$lv = [];
		
		# addon
		if(@$param['default_addon']){
			
			
				// lockfile
				$lv['lock_file']	= $param['coach']['terminal_path']."/cache/$param[page_code].inc";
							
				if(($param['is_cache']) && 					
				   (is_file($lv['lock_file']))
				){						
											
						// read data to temp
						$fh  					= fopen($lv['lock_file'],'r') or "Error";
						$lv['lock_content']     = fread($fh, filesize($lv['lock_file']));
						fclose($fh);
											
						// temp to fseries
						$lv['unlock_content']  	= unserialize($lv['lock_content']);		
						
						return $lv['unlock_content'];
				
				}else{
			
							$g     = $param['g'];
							
							$rdsql = $param['rdsql'];
							
							$f_series=[];
					
							$f_series['data']     = $param['f_series']['data'];
							$f_series['data_map'] = [];
							
												
							$temp_input_to_table = ['ITTX'=>['table'=>'varchar','action'=>function($data_in){  $data_in['allow']='x128';$data_in['maxlength']='128'; $data_in['attr']['class']="w_250"; return $data_in; }],
													'ITNM'=>['table'=>'decimal','action'=>function($data_in){  $data_in['allow']='d14[.]';$data_in['maxlength']='15';$data_in['attr']['class']="w_150"; return $data_in; }],
													'ITHD'=>['table'=>''],
								'ITHN'=>['table'=>'varchar'],
								'ITLA'=>['table'=>''],
								'ITIG'=>['table'=>'num'],
													'ITTA'=>['table'=>'text'],
								'ITCB'=>['table'=>'text'],
								'ITCE'=>['table'=>'text'],
								'ITTG'=>['table'=>'bool'],
								'ITTE'=>['table'=>'text'],
								'ITSL'=>['table'=>'varchar'],
								'ITML'=>['table'=>'varchar',
								'			action'=>function($data_in){  $data_in['is_list']=1; 
																$data_in['input_html']=" class='w_300' style='height:100px' ";  return $data_in; }],
									
								'ITST'=>['table'=>'exa_token'],			
								
								'ITFT'=>['table'=>'text'],
								'ITFD'=>['table'=>'varchar'],
								'ITFI'=>['table'=>'varchar'],
								'ITDT'=>['table'=>'date'],
								'ITTI'=>['table'=>'time'],
								'ITRG'=>['table'=>'varchar','action'=>function($data_in){return $data_in;}],
								'ITTB'=>['table'=>'varchar','action'=>function($data_in){  $data_in['end_label']='';
																							$data_in['attr']['class']="w_50"; 
																							$data_in['start_place_holder'] = '';
																							$data_in['end_place_holder']   = '';
																							
																							return $data_in;}],
								'ITUQ'=>['table'=>'vc128uniq',
										 'action'=>function($data_in){  $data_in['allow']='p[([a-zA-Z0-9]){1,128}][_]';$data_in['maxlength']='128'; $data_in['attr']['class']="w_200"; return $data_in; }]
							];
							
							$temp['addon'] = json_decode($param['default_addon']);							  
							
							if( (isset($temp['addon']->at)) || (isset($temp['addon']->en)) ){
									
									$view_query='';
															  
										if($temp['addon']->at){ // atrribute consolidated
										
							$temp['addon']->query  = "SELECT
															(SELECT token FROM entity_child_base WHERE id=ecb_child_id) as token,
																				(SELECT sn FROM entity_child_base WHERE id=ecb_child_id) as title,
												(SELECT sn FROM entity_child_base WHERE id=ecb_child_id) as sn,
												(SELECT ln FROM entity_child_base WHERE id=ecb_child_id) as ln,
											(SELECT note FROM entity_child_base WHERE id=ecb_child_id) as note,
											get_ecb_addon_varchar(ecb_child_id,'APIT') as exa_type,
											get_ecb_addon_varchar(ecb_child_id,'APSL') as simple_list,
											get_ecb_addon_varchar(ecb_child_id,'APGO') as grid_option,
											get_ecb_addon_varchar(ecb_child_id,'APFO') as fiben_option,
											get_ecb_addon_varchar(ecb_child_id,'APMD') as min_date_attr,
											get_ecb_addon_varchar(ecb_child_id,'APXD') as max_date_attr,
											get_ecb_addon_varchar(ecb_child_id,'APMY') as min_year_date,
											get_ecb_addon_varchar(ecb_child_id,'APXY') as max_year_date,
											get_ecb_addon_varchar(ecb_child_id,'APHT') as hint_attr,
											get_ecb_addon_varchar(ecb_child_id,'APCL') as class_attr,
											get_ecb_addon_varchar(ecb_child_id,'APIH') as input_html_attr,
											get_ecb_addon_varchar(ecb_child_id,'APAL') as allow_attr,
											get_ecb_addon_varchar(ecb_child_id,'APMA') as mandatory_attr,
											get_ecb_addon_varchar(ecb_child_id,'APDD') as default_date_attr,
											get_ecb_addon_varchar(ecb_child_id,'APAD') as avoid_default_option_attr,
											get_ecb_addon_varchar(ecb_child_id,'APFR') as fiben_table_row,
											get_ecb_addon_varchar(ecb_child_id,'APMR') as fiben_table_row_max,
											get_ecb_addon_varchar(ecb_child_id,'APGR') as fiben_table_min_rows_to_fill,
											get_ecb_addon_varchar(ecb_child_id,'APHD') as is_hide,
											get_ecb_addon_varchar(ecb_child_id,'APRO') as ro,
											get_ecb_addon_varchar(ecb_child_id,'APLC') as label_content,
											get_ecb_addon_varchar(ecb_child_id,'APLO') as file_location,
											get_ecb_addon_varchar(ecb_child_id,'APFM') as file_max_size,
											get_ecb_addon_varchar(ecb_child_id,'APFX') as file_allow_ext,
											get_ecb_addon_varchar(ecb_child_id,'APFN') as file_name,
											get_ecb_addon_varchar(ecb_child_id,'APFP') as file_prefix,
											get_ecb_addon_varchar(ecb_child_id,'APFS') as file_suffix,
											get_ecb_addon_varchar(ecb_child_id,'APIS') as image_size,								    
											get_ecb_addon_varchar(ecb_child_id,'APTS') as toggle_show_status_label,
											get_ecb_addon_varchar(ecb_child_id,'APTN') as toggle_on_label,
											get_ecb_addon_varchar(ecb_child_id,'APTF') as toggle_off_label,
											get_ecb_addon_varchar(ecb_child_id,'APTD') as toggle_default_on,
											get_ecb_addon_varchar(ecb_child_id,'APEZ') as avoid_empty_zero,
											get_ecb_addon_varchar(ecb_child_id,'APLL') as list_label,
											get_ecb_addon_varchar(ecb_child_id,'APOL') as list_label_query
											
																  FROM
																		  ecb_parent_child_matrix WHERE ecb_parent_id=(SELECT id FROM entity_child_base WHERE entity_code='AT' AND get_ecb_av_addon_varchar(id,'ATKH')='".$temp['addon']->at."')  $view_query ORDER BY id";
										
										}elseif($temp['addon']->en){ // attribute entity oriented
											 
	$lv['token_filter'] = ($temp['addon']->tokens)?"AND token IN(".implode(',',
																			array_map(function($a){return "'$a'";},
																					  $temp['addon']->tokens)
																			).")":'';
			
											 $temp['addon']->query  = "SELECT
											entity_code,
																			token,
											ln,
											note,
											".(($param['field_label'])?$param['field_label']:'sn')." as title,                                                                    
											get_ecb_addon_varchar(entity_child_base.id,'APIT') as exa_type,
											get_ecb_addon_varchar(entity_child_base.id,'APSL') as simple_list,
											get_ecb_addon_varchar(entity_child_base.id,'APGO') as grid_option,
											get_ecb_addon_varchar(entity_child_base.id,'APFO') as fiben_option,
											get_ecb_addon_varchar(entity_child_base.id,'APMD') as min_date_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APXD') as max_date_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APMY') as min_year_date,
											get_ecb_addon_varchar(entity_child_base.id,'APXY') as max_year_date,
											get_ecb_addon_varchar(entity_child_base.id,'APHT') as hint_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APCL') as class_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APIH') as input_html_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APAL') as allow_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APMA') as mandatory_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APDD') as default_date_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APAD') as avoid_default_option_attr,
											get_ecb_addon_varchar(entity_child_base.id,'APFR') as fiben_table_row,
											get_ecb_addon_varchar(entity_child_base.id,'APMR') as fiben_table_row_max,
											get_ecb_addon_varchar(entity_child_base.id,'APGR') as fiben_table_min_rows_to_fill,
											get_ecb_addon_varchar(entity_child_base.id,'APHD') as is_hide,
											get_ecb_addon_varchar(entity_child_base.id,'APRO') as ro,
											get_ecb_addon_varchar(entity_child_base.id,'APLC') as label_content,
											get_ecb_addon_varchar(entity_child_base.id,'APLO') as file_location,
											get_ecb_addon_varchar(entity_child_base.id,'APFM') as file_max_size,
											get_ecb_addon_varchar(entity_child_base.id,'APFX') as file_allow_ext,
											get_ecb_addon_varchar(entity_child_base.id,'APFN') as file_name,
											get_ecb_addon_varchar(entity_child_base.id,'APFP') as file_prefix,
											get_ecb_addon_varchar(entity_child_base.id,'APFS') as file_suffix,
											get_ecb_addon_varchar(entity_child_base.id,'APIS') as image_size,								    
											get_ecb_addon_varchar(entity_child_base.id,'APTS') as toggle_show_status_label,
											get_ecb_addon_varchar(entity_child_base.id,'APTN') as toggle_on_label,
											get_ecb_addon_varchar(entity_child_base.id,'APTF') as toggle_off_label,
											get_ecb_addon_varchar(entity_child_base.id,'APTD') as toggle_default_on,
											get_ecb_addon_varchar(entity_child_base.id,'APEZ') as avoid_empty_zero,
											get_ecb_addon_varchar(entity_child_base.id,'APLL') as list_default_option_label,
											get_ecb_addon_varchar(entity_child_base.id,'APOL') as list_option_label_query
										FROM
											entity_child_base WHERE entity_code='".$temp['addon']->en."' AND dna_code='EBAT'
											$lv[token_filter]
											AND  is_active=TRUE ORDER BY line_order ";	
											//entity_child_base WHERE entity_code='".$temp['addon']->en."' AND dna_code='EBAT' AND is_active=1 ORDER BY line_order ";
										
											
										} // end of diversion
									
									
						//echo $temp['addon']->query;                            
										
										$temp['addon']->result = $rdsql->exec_query($temp['addon']->query ,"UPI");

										//version conflict
										//$temp['addon']->result_rows = $rdsql->num_rows($temp['addon']->result);
														
										if($temp['addon']->result->num_rows>0){                                        
												   
												if(!$param['hide_addon_tab']){   
										
												array_push($f_series['data'],['field_name'	=>'Addon',        
																			  'type'		=>'heading']);
																			
												} //
										}
											
										while($get_row = $rdsql->data_fetch_object($temp['addon']->result)){
												
													
														
												 
														if($get_row->exa_type=="ITHD"){
																
																$temp_input = [
																							   'field_name'=>$get_row->title,
																							   
																							   'type'=>'heading',
																			  ];
																
																
														}elseif($get_row->exa_type=="ITSH"){
																
																$temp_input = [
																							   'field_name'=>$get_row->title,
																							   
																							   'type'=>'sub_heading',
																			  ];
																
																
														}elseif($get_row->exa_type=="ITLA"){
																
																$temp_input = [
																							   'field_name'=>$get_row->note,
																							   
																							   'type'=>'label',
													   
													   'attr'      => ['class'=>' col-md-12' ]
																			  ];
																
																
														}elseif( ($get_row->exa_type=="ITRG") || ($get_row->exa_type=="ITTB")){
																				
																		//echo $get_row->exa_type;
												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'range',
																							   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																							   
																							   //'data_prefix'    => '[',
																							   //
																							   //'data_suffix'    => ']',
																								
																							  // 'input_html'     => ' class="w_50" onkeypress="JavaScript:return PR_All_Numeric(event);" ' ,
													   
													   'attr'           => [ 'class' => "w_50",
																 'onkeypress="JavaScript:return PR_All_Numeric(event);" '
															   ]
																							   
																						];
														
														
																		$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
														
														}elseif($get_row->exa_type=="ITTG"){
																				
																		//echo $get_row->exa_type;
												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'toggle',
																							   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_round'            =>1
																						];
										
										
											if($get_row->toggle_show_status_label){
												
												$temp_input['show_status_label']    = 1;
												$temp_input['on_label']		    = $get_row->toggle_on_label;
												$temp_input['off_label']	    = $get_row->toggle_off_label;
												$temp_input['is_default_on']	    = $get_row->toggle_default_on;
											}								                                                
														
														}elseif($get_row->exa_type=="ITTA"){
																				
																		//echo $get_row->exa_type;
												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'textarea',
																							   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																							   
																							   'allow' => 'x1024',
																								
													   'attr'           => [ 'class' => "w_400"]
																							   
																						];
														
														
																		#$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
														
														}elseif($get_row->exa_type=="ITTE"){
																				
																		//echo $get_row->exa_type;
												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'textarea_editor',
																							   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																							   
																							   'allow' => 'x4096',
																							   
																						];
														
														
																		#$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
														
														}elseif($get_row->exa_type=="ITCE"){
																				
																		//echo $get_row->exa_type;
												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'code_editor',
																							   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																						];
														
														
																		#$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
														
														}elseif($get_row->exa_type=="ITIG"){
																				
																		//echo $get_row->exa_type;
												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'text',
																							   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																							   
																							   'allow' => 'd100',
																								
																							   'attr'           => [ 'class' => "w_400",
																 'rows'=>4 
															   ]
																							   
																						];
														
														
																		#$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
														
														}elseif($get_row->exa_type=="ITDT"){
																				
																		$year = date("Y");
											
										$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'date',
																							   
													   'set'  => array('min_date'=>'-75Y',
															   'max_date'=>'+0D'),
													   
													   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'year_range'	     => '1950:'.$year.'',
													   
													   //'year_range'	     => '2020:2050',
													   
													   'is_mandatory'	     => 0,
																							   
													   //'default_date'=>date("d-m-Y"),
																								
																								'attr'           => [ 'class' => "w_100",
															
															   ]
													   
																						];
														
									$min_max_date_year = null;
														
						}elseif($get_row->exa_type=="ITFT"){
									
									global $G,$rdsql;
									
									$temp_grid = json_decode(stripslashes($get_row->fiben_option));
										
																$temp_grid_columns = [];
									
									$dd = [];
																							
											
									foreach($temp_grid as $key=>$value){
										
										$temp_grid_prop    = [];
										$entity_code = explode("->",$value[6]);
										$a_series_token = explode('->',$value[7]);
										
										if(strlen(@$value[0])>0){
																				
											if($value[2] == 'Text'){
												
												$temp_grid_prop['column'] = ($value[0])?$value[0]:'';                       
																																				
												$temp_grid_prop['width']  = ($value[1])?$value[1]:120;
												
												$temp_grid_prop['input_html']  = ($value[10])?$value[10]:'';
																				
												$temp_grid_prop['type']   = 'text';
												
												$temp_grid_prop['allow']   = ($value[8])?$value[8]:'x1024';
												
												$temp_grid_prop['key_up_addon']  = ($value[11])?$value[11]:'';
												
												if($value[9]=='yes'){
													
													$dd_info =	 prefill_grid(['table'=>$value[3],
																				'field'=>$value[5],
																				'code'=>$entity_code[0],
																				'rdsql'=>$rdsql]);
																
													$dd = count($dd_info);
													$dd_val  = json_encode($dd_info);
													
												}
												
											}
											
											elseif($value[2] == 'Date'){
												
												$temp_grid_prop['column'] = ($value[0])?$value[0]:'';                       
																																				
												$temp_grid_prop['width']  = ($value[1])?$value[1]:120;
																				
												$temp_grid_prop['type']   = 'date';
												
												$temp_grid_prop['input_html']  = ($value[10])?$value[10]:'';
																			
												$temp_grid_prop['change_addon']  = ($value[11])?$value[11]:'';
											}
											
											elseif($value[2] == 'Autocomplete'){
												
												$temp_grid_prop['column'] = $value[0];                        
																																				
												$temp_grid_prop['width']  = ($value[1])?$value[1]:120;
																				
												$temp_grid_prop['type']   = ($value[2])?strtolower($value[2]):'text';
											
												$temp_grid_prop['table']   = $value[3];
												
												$temp_grid_prop['type']   = 'autocomplete';
											
												$temp_grid_prop['get_data_url']   = 'router.php?series=ax&key=x&action=fiben_a_test&token='.$a_series_token[0].'';
												
												//$temp_grid_prop['get_data_url']   = 'router.php?series=ax&key=x&action=fiben_a_test&token=AUDU';
											
											}
											
											elseif($value[2] == 'Dropdown')
											
											{
												
												if($value[9]=='yes'){
												
													$dd_info =	 prefill_grid(['table'=>$value[3],
																				'field'=>$value[4],
																				'code'=>$entity_code[0],
																				'rdsql'=>$rdsql]);
									
													$dd = count($dd_info);
													$dd_val  = json_encode($dd_info);
														
												}
												
												$option_id = $value[4];
												
												$option_data = $value[5];
												
												$table = $value[3];
												
												$ec_code = $entity_code[0];
												
												$temp_grid_prop['column'] =  $value[0];
												
												$temp_grid_prop['width']  = ($value[1])?$value[1]:120;
												
												$temp_grid_prop['type']   = 'dropDown';
												
												$temp_grid_prop['is_default_value']   = 0;
												
												$temp_grid_prop['input_html']  = ($value[10])?$value[10]:'';
																		 
																		 
												$temp_grid_prop['key_up_addon']  = ($value[11])?$value[11]:'';						 
																		 
												if(strlen(@$entity_code[0])>0){
													if(@$value[3]=='entity_child_base'){												
														$temp_grid_prop['data'] = $G->ft_option_builder(''.$table.'',''.$option_id.','.$option_data.'',"WHERE 1=1 AND dna_code = 'EBMS' AND entity_code = '".$ec_code." ' ORDER BY line_order,".$option_id." ASC");																						}
													else if(@$value[3]=='entity_child'){
														$temp_grid_prop['data'] = $G->ft_option_builder(''.$table.'',''.$option_id.','.$option_data.'',"WHERE entity_code='$ec_code' ORDER BY ".$option_id.",line_order ASC");
													}
												}
												
												
												
											}
																			   
																				array_push($temp_grid_columns,$temp_grid_prop);
											
																		} // end
																	   
																}
																 
									if(!$dd){
											$min_row	= empty($get_row->fiben_table_row)? 4 : $get_row->fiben_table_row;
											$max_row	= empty($get_row->fiben_table_row_max)? 10 : $get_row->fiben_table_row_max;
									}else{
											$min_row = $dd;
											$max_row = $dd;
									}
									 
									 
													
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'is_fibenistable'=>1,
													
													   'type' => 'fibenistable',
													   
														'is_index' =>1,
													   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
													   
														//'is_default_value' =>1,
													   
													   'default_data'  => $dd_val,
													   
													/*   'update_route_point' =>	[ 	'is_update_route_point' => 1,
																	'method' => 'post',
																	'url'    => 'router.php?series=ax&action=fiben_a_test&token=FT_UPDATE&attr='.$get_row->token.'',	
																],*/
													   
													   'default_rows_prop'=>array('start_rows'=> $min_row ,'max_row'=>$max_row),
													   
													   'min_rows_to_fill'=>$get_row->fiben_table_min_rows_to_fill,
													   
													   //'default_rows_prop'=>array('start_rows'=>count($dd),'max_row'=>count($dd)),
													   
													   'colHeaders'=>$temp_grid_columns,
													   
																						];
										
										$dd_val = NULL;
														
										}elseif(($get_row->exa_type=="ITSL") || ($get_row->exa_type=="ITML") || ($get_row->exa_type=="ITST") ){
															
															$lv['option'] 		= [];
															
															$temp_grid 			= json_decode(stripslashes($get_row->simple_list));
															
															$option_data 		= $temp_grid[0];
															
															$temp_entity_token 	= explode('->',$option_data[1]);
															
															$lv['option_where'] = ($option_data[4])? " AND ".$option_data[4]:'';
																					
										
											if($option_data[0]=='user_info'){
												$temp_where = " $lv[option_where]";
											}else{
												$lv['order']	=(preg_match("/(ORDER)(\s+)(BY)/i",$lv['option_where'])==0)?" ORDER BY line_order,id":'';
												$temp_where 	= " AND entity_code='$temp_entity_token[0]' $lv[option_where] $lv[order]";
											} // end																	
														
														
					$lv['label_column_query'] = (strlen($get_row->list_option_label_query) > 0)?$get_row->list_option_label_query:$option_data[3];					
																$temp_input =   [
																					   'field_name'=>$get_row->title,
																					   
																					   'field_id'=>'exa_value',
																					   
																					   'type'=>'option',
																					   
																					   'option_data'=>$g->option_builder(strtolower($option_data[0]),"$option_data[2],$lv[label_column_query]",
																					   "WHERE 1=1 $temp_where "  ),
																					   
																					   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																					   
																					   'parent_field_id'     => 'parent_id',              // parent field
																											   
																					   'child_attr_field_id' => 'exa_token',                // attribute code field
																					   
																					   'child_attr_code'     => $get_row->token,           // attribute code
																					   
																					   'is_mandatory'	     => 0,
																					   
																					   'allow' 				 => 'x1024',
																						
																					   'attr'           	 => [ 'class' => "w_200"]
																					   
																				];
														
										if($get_row->list_default_option_label){													
											$temp_input['option_default']	=   array('label'=>$get_row->list_default_option_label ?? 'Select',
																						'value'=>'');
										} // end
														
										if(isset($temp_input_to_table[$get_row->exa_type]['action'])){
											$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
										}

										if($get_row->exa_type=="ITST"){													
											$temp_input['field_id']	=   'exa_value_token';
										} // end
																		
														
									}elseif($get_row->exa_type=="ITFD"){
																		
										$doc_location	= empty($get_row->file_location)? 'doc/' : $get_row->file_location;
										$doc_allow_ext	= empty($get_row->file_allow_ext)? ['pdf'] : explode(',',$get_row->file_allow_ext);
										$doc_max_size	= empty($get_row->file_max_size)? 100 : $get_row->file_max_size;
																								 
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'file',
													   
														   'upload_type' => 'docs',
													   
													   'allow_ext'   => $doc_allow_ext,  # images
													   
													   'location'    => $doc_location,
													   
													   'max_size'    => $doc_max_size,
													   
													   //'location'    => 'images/entity_child/', # file save location 
																							   
													   //'location'	=> isset($get_row->file_location)? $get_row->location : 'images/entity_child/',
													   
																							   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																							   
													   'save_file_name'=>$get_row->file_name,     # file_name
													   
													   'save_file_name_prefix'=>$get_row->file_prefix,     # file name prefix
																		 
													   'save_file_name_suffix'=>$get_row->file_suffix,     # file name suffix    
																							   
																							   //'allow' => 'x1024',
																								
																								'attr'           => [ 'class' => "w_200"]
																							   
																						];
										
										
										
														
								}elseif($get_row->exa_type=="ITFI"){
																		
										$img_location	= empty($get_row->file_location)? 'image/' : $get_row->file_location ;
										$doc_allow_ext	= empty($get_row->file_allow_ext)? array('jpg','jpeg','png') : explode(',',$get_row->file_allow_ext);
										$doc_max_size	= empty($get_row->file_max_size)? 100 : $get_row->file_max_size;
																												
																		$temp_input =   [
																							   'field_name'=>$get_row->title,
																							   
																							   'field_id'=>'exa_value',
																							   
																							   'type'=>'file',
													   
														   'upload_type' => 'file',
													   
													   'allow_ext'   => $doc_allow_ext,  # images
													   
													   'location'    => $img_location,
													   
													   'max_size'    => $doc_max_size,
													   //'location'	=> isset($get_row->file_location)? $get_row->location : 'images/payment/',
													   
													   'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],      // child table 
																							   
																							   'parent_field_id'     => 'parent_id',              // parent field
																													   
																							   'child_attr_field_id' => 'exa_token',                // attribute code field
																							   
																							   'child_attr_code'     => $get_row->token,           // attribute code
																							   
																							   'is_mandatory'	     => 0,
																							   
													   'save_file_name'=>$get_row->file_name,     # file_name
													   
													   'save_file_name_prefix'=>$get_row->file_prefix,     # file name prefix
																		 
													   'save_file_name_suffix'=>$get_row->file_suffix,     # file name suffix    
																							   
													   'attr'           => [ 'class' => "w_200"]
																							   
																						];
										
										if(isset($get_row->image_size)){
												$temp_input['image_size']=$get_row->image_size;
										}
										
														
							}elseif($get_row->exa_type=="ITTI"){			
									$temp_input = [
													'field_name'=>$get_row->title,																		
													'field_id'=>'exa_value',																		
													'type'=>'hms',																		
													'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],    // child table 
													'parent_field_id'     => 'parent_id',              // parent field																			
													'child_attr_field_id' => 'exa_token',                // attribute code field													
													'child_attr_code'     => $get_row->token,           // attribute code													
													'is_mandatory'	     => 0,														
												];													
													
							}elseif($get_row->exa_type=="ITHN"){	

								$temp_input = [
									'field_name'=>$get_row->title,																		
									'field_id'=>'exa_value',																		
									'type'=>'hidden',																		
									'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],    // child table 
									'parent_field_id'     => 'parent_id',              // parent field																			
									'child_attr_field_id' => 'exa_token',                // attribute code field													
									'child_attr_code'     => $get_row->token,           // attribute code													
									'is_mandatory'	     => 0,														
								];	
							
			
							}else{			
										$temp_input = [
														'field_name'=>$get_row->title,																		
														'field_id'=>'exa_value',																		
														'type'=>'text',																		
														'child_table'         => 'exav_addon_'.$temp_input_to_table[$get_row->exa_type]['table'],    // child table 
														'parent_field_id'     => 'parent_id',              // parent field																			
														'child_attr_field_id' => 'exa_token',                // attribute code field													
														'child_attr_code'     => $get_row->token,           // attribute code													
														'is_mandatory'	     => 0,													
														'allow'               => 'x128',  													
														'attr'           => [ 'class' => "w_200"]													
													];		
													
										if(@$temp_input_to_table[$get_row->exa_type]['action']){														
											$temp_input= $temp_input_to_table[$get_row->exa_type]['action']($temp_input);
										}

								} // end
								
								
								if($get_row->class_attr!=null){
									unset($temp_input['attr']['class']);
									$temp_input['attr']['class']= $get_row->class_attr;
									
								}
								if($get_row->allow_attr!=null){							
									unset($temp_input['allow']);
									$temp_input['allow'] = $get_row->allow_attr;
									//print_r($temp_input);
								}
								if($get_row->hint_attr!=null){							
									unset($temp_input['hint']);
									$temp_input['hint'] = $get_row->hint_attr;
									//print_r($temp_input);
								}
								if($get_row->mandatory_attr==1){
									
									unset($temp_input['is_mandatory']);
									$temp_input['is_mandatory'] = 1;
									//print_r($temp_input);
									
								}
														if($get_row->default_date_attr==1){
									
									unset($temp_input['default_date']);
									$temp_input['default_date'] = date("d-m-Y");
									//print_r($temp_input);
									
								}
								if($get_row->avoid_default_option_attr==1){
									
									unset($temp_input['avoid_default_option']);
									$temp_input['avoid_default_option'] = 1;
									//print_r($temp_input);
									
								}
								if(($get_row->min_date_attr!=null)||($get_row->max_date_attr!=null)){
									
									if($get_row->min_date_attr==null){
									
										$get_row->min_date_attr = '-75Y'; 
									
									}
									
									if($get_row->max_date_attr==null){
											
											$get_row->min_date_attr = '180D';
									}
									
									unset($temp_input['set']);
									
									$temp_input['set'] = array('min_date'=>$get_row->min_date_attr,
												   'max_date'=>$get_row->max_date_attr);
									
								}
								
								
								if(($get_row->min_year_date!=null) || ($get_row->max_year_date!=null)){
									
									if($get_row->min_year_date==null){
									
										$get_row->min_year_date = ($year-75); 
									
									}
									
									if($get_row->max_year_date==null){
											
											$year = date("Y");
											
											$get_row->max_year_date = ($year+1);
											
									}
									
									$range = "'".$get_row->min_year_date.":".$get_row->max_year_date."'";
									
									unset($temp_input['year_range']);
									
									$temp_input['year_range'] = ''.$get_row->min_year_date.':'.$get_row->max_year_date.'';
									
								}
								
								
								if($get_row->input_html_attr!=null){
									$temp_input['input_html']=$get_row->input_html_attr;							
								}
								
								if($get_row->ro!=null){
									$temp_input['ro']= $get_row->ro;							
								}
								
								if($get_row->is_hide!=null){
									$temp_input['is_hide']=$get_row->is_hide;							
								}
								
								if($get_row->avoid_empty_zero!=null){
									$temp_input['avoid_empty_zero']=$get_row->avoid_empty_zero;							
								}
								
								$temp_input['field_token'] = $get_row->token;
								
								array_push($f_series['data'],$temp_input);
														
								} // each element
								
							} // end
							
							if(@$f_series['data']){
									
									foreach($f_series['data'] as $dky => $dkv){
											if(@$dkv['field_token']){
												$f_series['data_map'][$dkv['field_token']]=$dky;
											}
									}
							}
				
				
							$lv['result']	= array('rows'=>$temp['addon']->result->num_rows,
													 'addon'=>$temp['addon'],
													 'data'=>$f_series['data'],
													 'data_map'=>$f_series['data_map']
													 );
				
				
							  if($param['is_cache']){
									
									// fseries to temp
									$fh = fopen($lv['lock_file'],'w') or "Error";
									fputs($fh,serialize($lv['result']));
									fclose($fh);
							  }
							
							return $lv['result'];
				}
				
		} // default addon            
		
		return false;
	  
		
	} // end


	//f_addon_static_builder

	function f_addon_static_builder($param,$grid_row_value){                
			
			$temp            = explode(',',$grid_row_value[3]);                                                                                                                                                                                
			$temp            = array_map(function($n){ return "'$n'";},$temp);
			$param['source'] = implode(',',$temp);
			$param['type']   = 'select';
			
			return $param; 
			
	} // end

	// f_addon dynamic builder

	function f_addon_dynamic_builder($param,$grid_row_value){                
			
			global $G;                                                                                        
			$temp            = explode('->',$grid_row_value[6]);
			$param['source'] = $G->get_list($grid_row_value[5],"$grid_row_value[7],$grid_row_value[8]", " WHERE entity_code='$temp[0]'");                                                                                                                                                                                
			$param['type']   = 'select';
			
			return $param; 
			
	} // end

	//prefill grid
	// param-> field,table,code,rdsql
	function prefill_grid($param){

		$po = (object)$param;

		$lv = ['prefill_data'=>'','prefill_info'=>[]];
		$lv['entity_child_base'] = ['where'=>function(){ return " AND dna_code='EBMS' ";  }];
		$lv['entity_child']		 = ['where'=>function(){ return " ";  }];
		$lv['where_addon']		 = $lv[$po->table]['where'](); 

		$lv['prefill_data']  = $po->rdsql->exec_query("	SELECT 
												$po->field 
										  	FROM 
												$po->table 
											WHERE 
												entity_code= '$po->code' 
												$lv[where_addon]
											ORDER BY
												id ASC","Failed prefill selection");
		

		while($prefill_item = $po->rdsql->data_fetch_row($lv['prefill_data'])){	
				array_push($lv['prefill_info'],[$prefill_item[0]]);														
		};

		return $lv['prefill_info'];

	} // end


	// object 
	
	class FormAddon{
		
		private $def	   = [];
		private $temp	   = ['field'=>'','key'=>''];
		private $default__ = ['field_prefix'=>'X'];
		
	
		public function __construct($def){
			$this->def =$def;			
		}	
		
		//get field
		public function getFieldMap($token){			
			return @$this->def['data_map'][$token] ?? die("Undefined Key:$token");			
		}
		
		//get field
		public function getFieldKey($token){			
			return @$this->default__['field_prefix'].$this->getFieldMap($token);			
		}
		
		//get field
		public function getFieldByToken($token){
			$this->temp['field'] = $token;
			@$this->def['data'][$this->getFieldMap($token)] ?? die("Undefined Key:$token");
			return $this;
		}
		
		public function getKey($key){
			$this->temp['key'] = $key;
			return $this; 
		}
	
		public function setValue($value){
			return $this->def['data'][@$this->def['data_map'][$this->temp['field']]][$this->temp['key']]=$value; 
		}
		
		public function setKeyValues($key_values){
			
			$temp_field = $this->def['data'][@$this->def['data_map'][$this->temp['field']]];
			
			foreach($key_values as $k => $v){
					 $temp_field[$k]=$v; 
			}	
			
			$this->def['data'][@$this->def['data_map'][$this->temp['field']]] = $temp_field;	
			
		} // end
		
		
		public function unsetFields($fields){
			foreach($fields as $k => $v){
				unset($this->def['data'][@$this->def['data_map'][$v]]);
			}	
		} // end
		
		public function removeDefaultHeading(){
			unset($this->def['data'][0]);
		}
		
		public function getFields(){
			return $this->def['data']; 
		}
		
		public function getPostByToken($token){
			return $_POST[$this->getFieldKey($token)];
		}
		
	 
	} // addon
	
	

	?>