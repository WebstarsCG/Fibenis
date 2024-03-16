<?PHP

    $LAYOUT	    = 'layout_basic';
    
    $F_SERIES	=	array(
				'title'	=>'ECB Import',
				
                                'table_name'    => 'entity_child_base',
				
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
									    
									   'child_table'         	=> 'ecb_av_addon_varchar', 	
								       
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
				
				'avoid_trans_key_direct'=>0,

				'is_cc'=>0
								
                                
			);
    
	
				$F_SERIES['after_add_update'] =function($key_id){
		    
							global $G,$rdsql,$USER_ID;
					
							$lv    = [];
							
							
							
							$default = ['query_block_limit'=>64];
							
							$lv['model_xml'] = $G->get_one_cell(['table'=>'entity_child_base',
																'field'=>"get_ecb_av_addon_varchar(id,'IMFL')",
																'manipulation'=> " WHERE id=$key_id"
																]);
							
							$xml = simplexml_load_file($lv['model_xml']);
						//	print_r($xml);

															
							$lv['mode']=$xml->mode->ecb;	
							
							// mode check
							if($lv['mode']=='a' || $lv['mode']=='w'){
								
								 if(is_object($xml->entities->entity)){
										
								
									foreach($xml->entities->entity as $entity_idx=>$entity){	
												
													$entity->code=$entity->code.'';
													$entity->name=$entity->name.'';
									
								/*	$lv['model_code'] = $G->get_one_cell(['table'=>'entity',
																		  'field'=>"get_ecb_av_addon_varchar(id,'IMFL')",
																		  'manipulation'=> " WHERE id=$key_id"
																		]);*/
									
								if(($lv['mode'])=='w'){

										
										// remove existing
																					
											$rdsql->exec_query("DELETE from entity_child WHERE entity_code='".$entity->code."'",'Remove entity_child');
											$rdsql->exec_query("DELETE from entity_child_base WHERE entity_code='".$entity->code."'",'Remove entity_child_bae');
											$rdsql->exec_query("DELETE from entity WHERE code='".$entity->code."'",'Remove entity');
										
										// insert entity
											$lv['entity']=[];
											array_push($lv['entity'],"'$entity->code'");
											array_push($lv['entity'],"'$entity->name'");
											array_push($lv['entity'],0);
											array_push($lv['entity'],$USER_ID);
											
										$rdsql->exec_query("INSERT INTO entity(code,sn,is_lib,user_id) VALUES(".implode(',',$lv['entity']).")",'insert entity child base');
								
										}
								
									// each atrribute
										if(is_object($entity->ecb_info->ecb)){
														

											foreach($entity->ecb_info->ecb as $ecb_idx => $ecb){
												
																						
													$lv['ecb_attr']=[];    
													
													$lv['ecb_attr']=(array)$ecb;  
													$lv['ecb_values'] = array_values($lv['ecb_attr']);
													$lv['ecb_attr_values']=implode(",",array_map(function($val){ global $rdsql;
																									return sprintf("'%s'",$rdsql->escape_string($val));},
																									
																								$lv['ecb_values'])
																					);
												//	print_r($lv['ecb_attr_values']);

													$lv['query_value_text']='';
													
													// insert entity_child_base values
													$lv['query_value_text'].="'$entity->code',";
													$lv['query_value_text'].="$lv[ecb_attr_values]";
													$lv['query_value_text'].=",$USER_ID";
													$lv['query'] ="INSERT INTO 	            entity_child_base(entity_code,token,sn,ln,note,dna_code,line_order,user_id)
																			VALUES($lv[query_value_text])";
												
													$rdsql->exec_query("$lv[query]","ERR01".$lv['query']);
										
												} // each base
																					
															
											} // each attribute
										
												
										} // has attribute
										
								
										
									
								} // each entity
								
								
							}	// check mode
												
						}//end
							
						
						
					
	?>