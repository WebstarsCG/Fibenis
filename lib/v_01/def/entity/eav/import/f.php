<?PHP

    $LAYOUT	    = 'layout_basic';
    
    $F_SERIES	=	array(
				'title'	=>'EAV DB',
				
                                'table_name'    => 'entity_child',
				
				'key_id'        => 'id',
				
				'default_fields'    => array('entity_code' => "'IM'"),
				
                                
				'data'		      =>array('1' =>array( 'field_name'=> 'XML File',
							                                                        
									    'field_id' => 'ea_value',
									       
									    'type' => 'file',
									       
									    'upload_type' => 'docs',
									    
									    'save_file_name_prefix'=> 'entity_export_',
								    
									    'allow_ext'   => array('xml'),
									    
									    'max_size'    => 5000,
								    
									    'location'    => 'doc/',
									    
									    'child_table'         	=> 'eav_addon_varchar', 	
								       
									    'parent_field_id'     	=> 'parent_id',    		
											       
									    'child_attr_field_id' 	=> 'ea_code',   		
								       
									    'child_attr_code'     	=> 'IMFL',
									       
									   
									       
									    'is_mandatory'=>1,
									       
									    'input_html'=>'class="w_200"',
															
								       )
							),
				
				'is_user_id'       => 'user_id',
				
				# Communication
				
				'back_to'  => array( 'is_back_button' =>1, 'back_link'=>'?dx=demo__eav', 'BACK_NAME'=>'Back'),
                                
				'flat_message'	=> 'Successfully Added',
				
				'show_query'  => 0,
				
				'after_add_update' =>1,
				
				'avoid_trans_key_direct'=>1,

				
                                
			);
    
	
				$F_SERIES['after_add_update'] =function($key_id){
		    
								global $G,$rdsql,$USER_ID;
						
								$lv    = [];
								
								$default = ['query_block_limit'=>64];
								
								$lv['model_xml'] = $G->get_one_cell(['table'=>'entity_child',
																	'field'=>"get_eav_addon_varchar(id,'IMFL')",
																	'manipulation'=> " WHERE id=$key_id"
																	]);
								
								$xml = simplexml_load_file($lv['model_xml']);
								
								//print_r($xml);
						
								if(is_object($xml->entity)){
												
												$lv['addon_query_text'] = '';
																										
												foreach($xml->entity as $entity_idx=>$entity){
									
																				//attributemap
																				if(is_object($entity->attributemap)){
																								$lv['attrmap'] = (array)$entity->attributemap;
																				}
																				
																				$entity->code=$entity->code.'';
																				$entity->name=$entity->name.'';
																				$entity->write_mode=$entity->write_mode.'';
																		
																		
								
								
								
								// remove existing
																
									if($entity->write_mode!='A'){		
									 
									$rdsql->exec_query("DELETE from entity_child WHERE entity_code='".$entity->code."'",'Remove entity_child');
									$rdsql->exec_query("DELETE from entity_child_base WHERE entity_code='".$entity->code."'",'Remove entity_child_bae');
									$rdsql->exec_query("DELETE from entity WHERE code='".$entity->code."'",'Remove entity');
														
									
																				// insert entity
																				$lv['entity']=[];
																				array_push($lv['entity'],"'$entity->code'");
																				array_push($lv['entity'],"'$entity->name'");
																				array_push($lv['entity'],0);
																				array_push($lv['entity'],$USER_ID);
																				
																				$rdsql->exec_query("INSERT INTO entity(code,sn,is_lib,user_id)
																				VALUES(".implode(',',$lv['entity']).")",'insert entity');
																				
									}
																				
																				// each atrribute
																				if(is_object($entity->attributes->attribute)){
																								
																								$lv['addon_query_text'] = '';
																	
																								foreach($entity->attributes->attribute as $field_idx=>$field_obj){
																									
																												$lv['attr']=[];
																												
																												$lv['attr'] = (array)$field_obj; 
																										
																												unset($lv['attr']['@attributes']);
																																		
																			foreach($field_obj->attributes() as $def_key => $def_val){ 
																							$lv['attr'][$def_key]=$def_val.'';
																			}
																												
																												$lv['ecb']=[];
							
							// attr query
							$lv['attr_query'] = "INSERT INTO entity_child_base(entity_code,token,sn,ln,line_order,dna_code,user_id)
																																																VALUES('".$entity->code."','".
																																																          $lv['attr']['token']."','".
																																																		  $lv['attr']['name']."','".
																																																		  $lv['attr']['description']."','".
																																																		  $lv['attr']['line_order']."','EBAT',$USER_ID)";
																												
																												$rdsql->exec_query($lv['attr_query'],'ecb');
																																																								
																												$lv['ecb_id']    = $rdsql->last_insert_id('entity_child_base');
																												
																												unset($lv['attr']['token']);
																												unset($lv['attr']['name']);
																												unset($lv['attr']['description']);
																												unset($lv['attr']['line_order']);
																													
																												#print_r($lv['attr']);	
																													
																												foreach($lv['attr'] as $akey => $aval){												$aval = preg_replace('/\'/','\\\'',$aval);						
														$lv['addon_query_text'].="($lv[ecb_id],'".$lv['attrmap'][$akey]."','".$aval."',$USER_ID),";
																												}						       
																																
																									
																								} // each attribute
																											
																								
																								if($lv['addon_query_text']){
																												
														$lv['addon_query_text_neutral']=substr($lv['addon_query_text'],0,-1);
																						
														
																						
														$lv['addon_query'] = "INSERT INTO ecb_av_addon_varchar(parent_id,ea_code,ea_value,user_id)
																																																				VALUES $lv[addon_query_text_neutral]";
																												
														 $rdsql->exec_query($lv['addon_query'],"ecb varchar".$lv['addon_query']);
																												
																								} // addon attribute query
																								
																} // has attribute
												
												} // each entity
												
								} // has entity
						
				} // end	
?>