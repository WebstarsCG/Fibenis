<?PHP
                        
	     $F_SERIES	=	array(
				    
				    'title'	=>'Coach',
				    
				    # Table field
			
				    'data'	=>   array(
				       
						    '8'=>array( 'field_name'          => 'Primary',								
								'type'                => 'heading'
						         ),
						       
						       
						       '1' =>array('field_name'=>'Code',
								   
								   'field_id'=>"ea_value",
								   
								   'type'=>'text',
								   
								   'is_mandatory'=>1,
								   
								   'child_table'         => 'eav_addon_vc128uniq', // child table 
								  
								   'parent_field_id'     => 'parent_id',         // parent field
											 
								   'child_attr_field_id' => 'ea_code',   	      // attribute code field
								
								   'child_attr_code'     => 'CHCD',
								   
								   'attr'=>['class'=>"w_300",'onchange'=>"check_code(this);"]
					      
								   ),
						       
				       
						       '2' =>array('field_name'=>'Name',
								   
								 'field_id'=>"ea_value",
								 
								 'type'=>'text',
								 
								 'is_mandatory'=>1,
								 
								 'child_table'         => 'eav_addon_varchar', // child table 
								 
								 'parent_field_id'     => 'parent_id',         // parent field
											 
								 'child_attr_field_id' => 'ea_code',   	      // attribute code field
								
								 'child_attr_code'     => 'ECSN', 
								   
								 'attr'=>['class'=>"w_300"]
								   
							),
						       
							'3'=>array(
								'field_name'          => 'Domain Name',                                                                
								
								'field_id'            => 'ea_value',				       
								
								'type' 	              => 'text',
								
								'is_mandatory'        => 1,
						
								'child_table'         => 'eav_addon_varchar', // child table 
								
								'parent_field_id'     => 'parent_id',         // parent field
											 
								'child_attr_field_id' => 'ea_code',   	      // attribute code field
								
								'child_attr_code'     => 'CHDN',          // attribute code
								
								'attr'=>['class'=>"w_300"]
								 
							    ),	
								
						       
						       '4'=>array(
								'field_name'          => 'Images',
								
								'type'                => 'heading'
						      ),
						       
						       
						        
						       '7'=>array( 'field_name'          => 'Logo',                                                                
								
								 'field_id'            => 'ea_value',				       
								 
								 'type'                => 'file',
								 
								 'upload_type'         => 'image',
								 
								  'allow_ext'  		 => array('jpg','jpeg','png'), 
								
								 'child_table'         => 'eav_addon_varchar', // child table 
								 
								 'parent_field_id'     => 'parent_id',         // parent field
											 
								 'child_attr_field_id' => 'ea_code',   	      // attribute code field
								
								 'child_attr_code'     => 'CHIL', 
											
								 'image_size'           => json_decode($SG->get_session('logo_size'),TRUE),
								 
								  'save_file_name' => 'logo' 
				
							),
						       
						       
						       '9'=>array( 'field_name'          => 'Favicon',                                                                
								
								 'field_id'            => 'ea_value',				       
								 
								 'type'                => 'file',
								 
								 'upload_type'         => 'image',
								 
							     'allow_ext'  		 => array('jpg','jpeg','png'),  
								
								 'child_table'         => 'eav_addon_varchar', // child table 
								 
								 'parent_field_id'     => 'parent_id',         // parent field
											 
								 'child_attr_field_id' => 'ea_code',   	      // attribute code field
								
								 'child_attr_code'     => 'CHIF', 
											
								 'image_size'           => ["32"=>"32"],
								 
								 'save_file_name'	=> 'favicon' 
				
							),
							
							 '10'=>array(
								'field_name'          => 'Entity',
								
								'type'                => 'heading'
						      ),
							  
							  
							  '11'=>array(
								'field_name'          => 'Entity',                                                                
								
								'field_id'            => 'ea_value',				       
								
								'type' 	              => 'list_left_right',
								
								'is_mandatory'        => 1,
						
								'child_table'         => 'eav_addon_text', // child table 
								
								'parent_field_id'     => 'parent_id',         // parent field
											 
								'child_attr_field_id' => 'ea_code',   	      // attribute code field
								
								'child_attr_code'     => 'CHET',          // attribute code
								
								'option_data'  => $G->option_builder("entity","code,sn","WHERE is_lib = 0 order by sn ASC"),
                                                                    
                                'input_html'   =>  ' class="w_200" rows="2"  style="height:200px !important"  ',

								 
							    ),	

							'12'=>array(
									'field_name'          => 'Access Roles',
									
									'type'                => 'heading'
								  ),	

							'13'=>array(
									'field_name'          => 'Entity',                                                                
									
									'field_id'            => 'ea_value',				       
									
									'type' 	              => 'list_left_right',
									
									'is_mandatory'        => 1,
							
									'child_table'         => 'eav_addon_varchar', // child table 
									
									'parent_field_id'     => 'parent_id',         // parent field
												 
									'child_attr_field_id' => 'ea_code',   	      // attribute code field
									
									'child_attr_code'     => 'CHRL',          // attribute code
									
									'option_data'  => $G->option_builder("user_role","sn,ln"," order by sn ASC"),
																		
									'input_html'   =>  ' class="w_200" rows="2"  style="height:200px !important"  ',
	
									 
								),	
						    
						      
						       
						       
						     
				    ),
					
				    #Table Name
				    
				    'table_name'    => 'entity_child',
				    
				    #Primary Key
				    
				    'key_id'        => 'id',
				  				    
				    # Communication
								    
				    'add_button' => array( 'is_add' =>1,'page_link'=>'f=entity_child', 'b_name' => 'Add Entity child' ),
			 
				    'back_to'  => array( 'is_back_button' =>1, 'back_link'=>'?d=coach_eav', 'BACK_NAME'=>'Back'),
				    
				    'prime_index'   => 2,
				    
				    'default_fields' => array("entity_code" => "'CH'",),
				    
				    # File Include
				    'after_add_update'	=>1,
				    'before_add_update'	=>1,
				    
			            'is_user_id' 	=>'user_id',
				    
				    'js'=> ['is_top'=>1,'top_js'=>$LIB_PATH.'def/coach_eav/f'],
			
				    'page_code'	=> 'FECA',
				    
				    'show_update_query' => 0,
				       
				    'avoid_trans_key_direct' => 1,
				    
				    'divider' => 'tab',

					'is_cc'=>1
				    
                                
			);
	     
	     
	     if(@$_GET['key']){
			  
							$temp_key_id = @$_GET['key'];
							
							$F_SERIES['temp']['terminal']=$G->get_one_column(['table'				=> 'eav_addon_vc128uniq',
																																'field'				=> 'ea_value',
																																'manipulation'=> " WHERE parent_id=$temp_key_id AND ea_code='CHCD'"]);
							
							$F_SERIES['data']['7']['location'] = "$COACH[path]/".$F_SERIES['temp']['terminal']."/images/";
							$F_SERIES['data']['9']['location'] = "$COACH[path]/".$F_SERIES['temp']['terminal']."/images/";
							
							$F_SERIES['data']['1']['ro']=1;
							$F_SERIES['data']['1']['attr']['disabled']='true';
			  			  
	     }
			 
	     # before add update
	     
	     function before_add_update(){
			  
			  global $F_SERIES,$COACH;
			  
			  $lv = [];
			  
			  $lv['theme_child_query_data'] = [];
			  
			  $lv['coach_child_query_data'] = [];
			  
			  $lv['coach_code']            = $_POST['X1'];
			  
			  $lv['coach_code_hash']       = md5($lv['coach_code']);
			  
			  
			  // folder creation during new coach addition
			  if(!$_POST['UPDATE']){
				       
				       $lv['coach_path']      =get_config('coach_path');		    
				       
				       $lv['coach_cache_path']=$lv['coach_path']."/$lv[coach_code]/cache/";
				       
				       mkdir($lv['coach_path']."/$lv[coach_code]",0755,true);
				       
				       mkdir($lv['coach_cache_path'],0755,true);
				       
				       mkdir($lv['coach_path']."/$lv[coach_code]/content",0755,true);
				       
				       mkdir($lv['coach_path']."/$lv[coach_code]/images",0755,true);
				       
				       $theme_content_file = fopen($lv['coach_cache_path']."/t.html","w") or die("Unable to open file!");		
				       
				       fclose($theme_content_file);
			      
			  } // end
		
			  $F_SERIES['data']['7']['location'] = "$COACH[path]".$_POST['X1']."/images/";
			  $F_SERIES['data']['9']['location'] = "$COACH[path]".$_POST['X1']."/images/";
			 
	     }
	     
	     # after add update
	     function after_add_update($key_id){
		 
	     } // end of after add update
?>
    