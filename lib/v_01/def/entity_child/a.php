<?PHP
       
	 
        $A_SERIES       =   array(
		
		
					'ECIU'=>function($param){
						
								
						                if($param['user_id']){ 
						
									$inline_param     = json_decode($param['data']);
									
									$inline_value     = $param['sv'];									
													
									$param['rdsql']->exec_query("UPDATE
												entity_child
											   SET
												detail='$inline_value'
											   WHERE
												id=$inline_param->id AND
												md5(sn)='$inline_param->key'
											   ",'0');
									
									# one column
									
									return $param['G']->get_one_columm(array('table'        => 'entity_child',
												      'field'        => 'count(*)',
												      'manipulation' => "WHERE
																id=$inline_param->id AND
																md5(sn)='$inline_param->key'"
											));
									
								}else{
									
									return 0;			
								}
						
						
					}, // end
					
					# active inactive
					
					
					'ECAI'=>function($param){
						
								
						                if($param['user_id']){ 
						
									$inline_param     = json_decode($param['data']);
									
									$inline_value     = $param['sv'];									
																					
									$param['rdsql']->exec_query("UPDATE
												entity_child
											   SET
												is_active=$inline_param->fv
											   WHERE
												id=$inline_param->id 
											   ",'0');
									
									# one column
									
									return $param['data'];
									
								}else{
									
									return 0;			
								}
						
						
					}, // end

					// EC bulk
					'ECAIBL'=>function($param){
						
								$inline_param     = json_decode($param['data']);
							    
							    if($param['user_id'] && @$inline_param->code){ 					    
								    								    
									$status 	 = ($inline_param->fv==1)?1:0;
									$entity_code = $param['G']->decryptRMIX($inline_param->code,$param['G']->getSessId());

									if($entity_code){

										$where 		 = " entity_code='$entity_code' AND ";
																						
										$param['rdsql']->exec_query("UPDATE
														entity_child
													SET
														is_active =$status
													WHERE
														$where
														id IN ($inline_param->id) 
													",'0');
										
										# one column										
										return $param['data'];

									}else{
										return 0;
									}
								    
							    }else{								    
								    return 0;			
							    }
				    }, // end
					
					// entitychild, external attribute
					
					'ECAV'=>function($param){
						
								
						                if($param['user_id']){ 
						
									$inline_param     = json_decode(urldecode($param['data']));
									
									$inline_value     = $param['sv'];									

									//echo "DELETE FROM 
									//					eav_addon_varchar											   
									//				WHERE
									//					parent_id=$inline_param->id AND
									//					ea_code='$inline_param->ea_code'
									//				";
									$param['rdsql']->exec_query("DELETE FROM 
														eav_addon_varchar											   
													WHERE
														parent_id=$inline_param->id AND
														ea_code='$inline_param->ea_code'
													",'D');
									
									
													
									$param['rdsql']->exec_query("INSERT
													eav_addon_varchar
														(parent_id,ea_code,ea_value,user_id)
													VALUES
														($inline_param->id,'$inline_param->ea_code','$inline_value',$param[user_id])																									
													",'I');
									
									# one column
									
									//return 1;
									
									return $param['G']->get_one_columm(array('table'        => 'eav_addon_varchar',
												      'field'        => 'count(*)',
												      'manipulation' => "WHERE
																parent_id=$inline_param->id AND
																ea_code='$inline_param->ea_code'"
											));
									
								}else{
									
									return 0;			
								}
						
						
					}, // end
					
					'ECLI'=>function($param){
						
								
						                if($param['user_id']){ 
						
									$inline_param     = json_decode($param['data']);
									
									$inline_value     = $param['sv'];									
																					
									$param['rdsql']->exec_query("UPDATE
												entity_child
											   SET
												line_order=$inline_value
											   WHERE
												id=$inline_param->id 
											   ",'0');
									
									# one column
									
									return $param['data'];
									
								}else{
									
									return 0;			
								}
						
						
					}, // end
					
					'SEUR'=>function($param){
						
							$temp = [];
							
							$temp['decrypt'] = json_decode($param['G']->decrypt($_GET['req'],$_GET['trans_key']),true);
							
							if(($param['user_id']==$temp['decrypt']['user_id'])&&($param['pass_id']==$temp['decrypt']['pass_id'])){
								
								$temp['temp']    = $param['G']->decrypt($temp['decrypt']['data'],$temp['decrypt']['trans_key']);
								
								$temp['ext'] = strtolower(pathinfo($temp['temp'], PATHINFO_EXTENSION));
								
								$temp['type_temp'] = [	'pdf'=>'application',
											'jpeg'=>'image',
											'png'=>'image',
											'html'=>'text',
											'jpg'=>'image',
											'csv'=>'text'];
								
								function data_uri($file, $mime){
									
									ob_end_clean();																    
									header("content-type: $mime");							   
									return file_get_contents($file);
									
							    };
							       
								$temp['mime_pre'] = $temp['type_temp'][$temp['ext']].'/'.$temp['ext'];
							    
								$temp['op'] = data_uri($temp['temp'],$temp['mime_pre']);
							    
								return $temp['op'];
						
							}else{
								
								header('HTTP/1.0 401 Unauthorized');
								exit;
							}
							
						      
					     },

			'ECAIADDON'=>function($param){
						
								
				if($param['user_id']){ 
			
						$inline_param     = json_decode($param['data']);
						
						$inline_value     = $param['sv'];			
						
						$is_exist         = $param['G']->get_one_column(['table'=>'exav_addon_bool',
																		 'field'=> "count(*)",
																		 'manipulation'=> " WHERE parent_id=$inline_param->id   
																		                          AND exa_token='$inline_param->addon' "
																	]);
						
																		
						if($is_exist==0){
																	
							$param['rdsql']->exec_query("INSERT INTO
															exav_addon_bool(parent_id,exa_token,exa_value,user_id)
														VALUES
															($inline_param->id,'$inline_param->addon',$inline_param->fv,$param[user_id])",
														'0');

						}else{																				
							$param['rdsql']->exec_query("UPDATE
														exav_addon_bool
													SET
														exa_value=$inline_param->fv
													WHERE
														parent_id=$inline_param->id  AND exa_token='$inline_param->addon'",
													'0');
						}
						
						
						# one column						
						return $param['data'];
						
					}else{						
						return 0;			
					}
			
			}, // end
	);
	
	
	
	
	
    
?>