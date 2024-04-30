<?PHP

		
	$default_addon = @$_GET['default_addon'];
	
        $LAYOUT	    	= 'layout_basic';
               
        $D_SERIES       =   array(
                                   'title'=>'Issue',
                                    
                                    #query display depend on the user
                                    
                                    'is_user_base_query'=>0,
				    
				    'gx' => 1,
				    
                                    #table data
                                    
                                    'data'=> array(
					                
							1=>array('th'=>'Name ',
								
                                                                'field' => "get_exav_addon_varchar(id,'ISNA')",
								   
								'td_attr' => ' class="label_father align_LM" width="15%"',
								
								'is_sort' => 0,
								
								),
							
							2=>array('th'=>'Description ',
								
                                                                'field' => "concat(substring_index(get_exav_addon_text(id,'ISDS'),' ',10),':',get_exav_addon_text(id,'ISDS'))",
								   
								'td_attr' => ' class="label_father align_LM" width="30%"',
								
								'is_sort' => 0,
								
								'filter_out'=>function($data_in){
									
									$temp = explode(':',$data_in);
									
									return "<a class='tip clr_gray_5'>$temp[0]...</a><span class='tooltiptext'>$temp[1]</span>";
										
								}
								),
					
							
							3=>array('th'=>'Raised On ',
								
								'field' => "date_format((SELECT exa_value FROM exav_addon_date WHERE parent_id = entity_child.id AND exa_token = 'ISRO'),'%d-%b-%Y')",
							
								//'field' => "(get_eav_addon_date(id,'CODB'))",
								
								'td_attr' => ' class="align_LM" width="15%"',
								
								'is_sort' => "(SELECT exa_value FROM exav_addon_date WHERE parent_id = entity_child.id AND exa_token = 'ISRO')",
								
								'filter_out' => function($data_in){
									
											//$temp = explode(':',$data_in);
											
											return "<div class='block normal txt_case_uppercase txt_size_11 clr_gray_a'>$data_in</div>";;
											       
									
								                }
								
									 
								),
							

							
							5 => array('th'=>'Priority ',
								    
								'field' => "(get_ecb_sn_by_token(get_exav_addon_exa_token(id,'ISPI')))",
								   
								'td_attr' => ' class="align_LM " width="10%"',
								
								'is_sort' => 0,
								
								'js_ca;'
								
								 ),
							
							7=>array('th'=>'Status ',
								 
								 'td_attr' => ' class="align_LM" width="10%"',
		
								'field'	=> "concat(id,':',get_ecb_sn_by_token(get_exav_addon_exa_token(entity_child.id,'ISST')))",
								
                                                                'filter_out'=>function($data_in){
                                                                            
													$temp = explode(':',$data_in);
									    
													$data_out = array('id'   => $temp[0],
												        'link_title'=>$temp[1],
														'wl_token'=>$temp[0].'.status',
												        'title'=>'Status View',
													'src'=>"?f=status&menu_off=1&mode=simple&default_addon=$temp[0]",
												        'style'=>"border:none;width:100%;height:600px;",
													'refresh_on_close'=>0);
													 return json_encode($data_out);
												 },
                                                                        
                                                                        'js_call'=>'d_series.set_nd'
								           
								    ),
							
							
							
							8=>array('th'=>'Log',
								 
								 'td_attr' => ' class="align_LM" width="5%"',
		
								'field'	=> "id",
								
                                                                'filter_out'=>function($data_in){
                                                                            
													$temp = explode(':',$data_in);
													
													$data_out = array('id'   => $temp[0],
												        'link_title'=>'View Status Log',
													 'is_fa'=>' fa fa-history clr_gray_6 fa-lg',
												         'title'=>'Status View',
												         'src'=>"?d=status&menu_off=1&mode=simple&default_addon=$temp[0]",
												         'style'=>"border:none;width:100%;height:600px;");
													 return json_encode($data_out);
												 },
												 
									'attr' => ['class'=>'align_CM'],
                                                                        
                                                                        'js_call'=>'d_series.set_nd'
                                                                        
								    ),
							
							
							6=>array('th'=>'Document',
									 
								'field'=>"get_exav_addon_varchar(id,'ISSO')",
									 
								'td_attr' => ' class="label_child align_CM" width="10%"',
								
								'filter_out'   =>	function($data_out){
									
									if(@$data_out){
										return  "<a href=".$data_out." target='_blank'>View</a>"; 
									}else{
										return "<div class='block normal txt_case_uppercase txt_size_11 clr_gray_a'>NA</div>";;
											 
									}
								   },
									 
								),
								
							9=>array('th'=>'Raised By',
									 
									'field'=>"concat(get_user_internal_name(user_id),',',date_format(timestamp_punch,'%d-%b-%y %T'))",
																			 
									'attr' => [ 'width'=>"12%"],
									
									'js_call'=> 'show_user_info_2l',
									
									'is_sort'=>'timestamp_punch'
									 
								),
							
					
								
								//6 => array('th'=>'Updation ',
//								    
//								    'field' => "concat(get_userinfo(user_id),' | ',date_format(updated_on,'%d-%b-%y %T'))",
//								    
//								    'td_attr' => ' class="align_LM" width="25%"',
//								    
//								    'is_sort'	=>1,
//								 ),
//							
							
					
								
                                                    ),
				    
					
                                        
                                       'action' => array('is_action'=>0, 'is_edit' =>1, 'is_view' =>0 ),
                                       
                                       'order_by'   =>'ORDER BY id ASC ' ,
				       
				       
				    #Filter Info
				    
					'custom_filter' => array(  			     						   
							      
									array(  'field_name' => 'Status:',
									      
										'field_id' => 'cf1', // 
										
										'filter_type' =>'option_list', 
												    
										'option_value'=> $G->option_builder_cache('entity_child_base','token,sn'," WHERE entity_code = 'IU' ORDER BY id"),
							    
										'html'=>'  title="Select Type"   data-width="160px"  ',
								    
										'cus_default_label'=>'Show All',
							    
										'filter_by'  => "get_exav_addon_exa_token(id,'ISST')" // main table value
									),
									
									
									
									array(  'field_name' => 'Priority:',
									      
										'field_id' => 'cf3', // 
										
										'filter_type' =>'option_list', 
												    
										'option_value'=> $G->option_builder_cache('entity_child_base','token,sn'," WHERE entity_code = 'IP' ORDER BY sn"),
							    
										'html'=>'  title="Select Type"   data-width="160px"  ',
								    
										'cus_default_label'=>'Show All',
							    
										'filter_by'  => "get_exav_addon_exa_token(id,'ISPI')" // main table value
									),
									
									array(  'field_name' => '<br>Raised By',
									      
										'field_id' => 'cf4', // 
										
										'filter_type' =>'option_list', 
												    
										'option_value'=> $G->option_builder_cache('user_info','id,get_user_internal_name(id)'," WHERE is_active=1"),
							    
										'html'=>'  title="Select Type"  class="selectpicker"  data-width="160px" data-live-search="true"  ',
								    
										'cus_default_label'=>'Show All',
							    
										'filter_by'  => "user_id" // main table value
									),
									
									
									
								),    
				       		
                                
				
                                    #Table Info
                                    
                                    'table_name' =>'entity_child',
                                    
                                    'key_id'    =>'id',
                                    
                                    # Default Additional Column
                                
                                    'is_user_id'       => 'user_id',
				    
				    'key_filter'     =>	 " AND  entity_code='IS'  ",
                                
                                    # Communication
                                
                                    'prime_index'   => 1,
				    
			  'summary_data'=>array(
							array(  'name'=>'No','field'=>'count(id)','html'=>'class=summary'),
				
					   ), 
                                    			   
				 #Search_info
				 
				 'search'=> 	array(
							  
							
							array(  'data'  =>array('table_name' 	=> 'entity_child',
										'field_id'	=> 'id',
										'field_name' 	=> 'get_issue_name(id)',
										'filter'	=> " AND entity_code='IS'" 
									 ),
							      
								'title' 		=> 'Name',										
								'search_key' 		=> "get_issue_name(id)",													       
								'is_search_by_text' 	=> 1, //( For Text search case)	      
							),
							
							//array(  'data'  =>array('table_name' 	=> 'entity_child',
							//			'field_id'	=> 'id',
							//			'field_name' 	=> 'get_issue_description(id)',
							//			'filter'	=> " AND entity_code='IS'" 
							//		 ),
							//      
							//	'title' 		=> 'Description',										
							//	'search_key' 		=> "get_issue_description(id)",													       
							//	'is_search_by_text' 	=> 1, //( For Text search case)	      
							//),
						),
	      
				'is_narrow_down'=>1,
				
				'before_delete'=>0,
				
				
				#check_field
								
					'check_field'   =>  array('user_id' => @$_GET['user_id'],'page_code' => @$_GET['page_code']),								
								
					'add_button' => array( 'is_add' =>1,'page_link'=>'f=issue', 'b_name' => 'Add Issue'),
								
					'del_permission' => array('able_del'=>1,'user_flage'=>1), 
								
					'date_filter'  => array( 'is_date_filter' =>1,'date_field' =>  'timestamp_punch'),	
					
					'list_sort'	=> array(  'set'=>array('label'=>'Show By '),					
										   1=>array('name'=>'Recently Added','query'=> ' timestamp_punch DESC'),						
										   2=>array('name'=>'Earlier Added', 'query'=> ' timestamp_punch ASC' ),
									),
								
				#export data
				
				'show_query'=>0,
				
				'has_cross_border_relations'=>['status_update'],
				
				'is_load_by_scroll'=>0,
				
				'js'=>['is_top'=>1],
				
				'hide_sno'=>0,
				
				'hide_header'=>0,
				
				'hide_pager'=>0,
				
				'export_csv'   => array('is_active' => 1, 
										 'button_name'    => 'E',
									) // end  
                            
		);
	
							
?>