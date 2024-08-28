<?PHP

    //F_series definition:
                            
    $F_SERIES	=	array(
				#Desk Title
				
				'title'	=>'External Attribute',
                                
                                'gx'=>1,
				
				#Table field
                    
				'data'	=>   array('0'  => ['field_name'=>'Basic',
								 'type'=>'heading',					 
								],
						   
                                                    
                                                   '1' =>array( 'field_name'=> 'Entity',
                                                               
                                                               'field_id' => 'entity_code',
                                                               
                                                               'type' => 'option',
                                                               
                                                               //'option_data'=>$G->option_builder('entity','code,sn'," ORDER by sn ASC"),
                                                               
                                                               'is_mandatory'=>1,
                                                               
                                                               'avoid_default_option'=>0,
                                                               
                                                               'input_html'=>'class="w_150"',
                                                               
                                                            ),
                                                   
                                                  
						   '2' =>array('field_name'=>'Token',
                                                               
                                                               'field_id'=>'token',
                                                               
                                                               'field_token'=>'TEST',
                                                               
                                                               'type'=>'text',
                                                               
                                                               'is_mandatory'=>1,
                                                               
                                                               'allow'  => 'w32',
                                                               
                                                               'hint'   => '',
                                                               
                                                               'input_html'=>'onchange="check_token(this);"',
                                                               
                                                               
                                                               ),
                                                   
						   '3' =>array('field_name'=>'Short Name',
                                                               
                                                               'field_id'=>'sn',
                                                               
                                                               'type'=>'text',
                                                               
                                                               'is_mandatory'=>1,
                                                               
       'input_html'=>'class="w_150"  onkeyup="(function(){G.$(\'X49\').value=G.$(\'X4\').value=G.$(\'X3\').value})();"',
	   
                                                'allow'=>'x100'
                                                               
                                                               ),
					
						   
						   
						   '4' =>array('field_name'=>'Long Name',
                                                               
                                                               'field_id'=>'ln',
                                                               
                                                               'type'=>'textarea',
                                                               
                                                               'is_mandatory'=>1,
                                                               
                                                               'input_html'=>'class="W_150"'
                                                               
                                                               ),
                                                   
                                                    '5' =>array(   'field_name'         => 'Label Content',
                                                                     
                                                                        'field_id'=>'note',
                                                               
                                                                        'type'=>'textarea',
                                                               
                                                                        'is_mandatory'=>0,
                                                               
                                                                        'input_html'=>'class="W_150"'
                                                                   
                                                                    
                                                               ),
						   
												
						   '6' =>array(     'field_name'          => 'Input Type',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'option',
                                                                    'option_data'         => $G->option_builder('entity_child_base','token,ln'," WHERE entity_code='IT' ORDER by ln ASC"),                                                               
                                                                    'is_mandatory'        => 1,
                                                                    //'is_hide'             => 1,
                                                                    'option_default'=> array('label'=>'Text','value'=>'ITTX'),
                                                                    //'input_html'          => ' onchange=input_type_action(this)',
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',            // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',              // attribute code field
                                                                    'child_attr_code'     => 'APIT',                 // attribute code
						   
                                                               ),
                                                   
                                                   
                                                    '8' =>array(
                                                                    'field_name'          => 'Option Data',
                                                                     'field_id'           => 'ea_value',
                                                                    'is_fibenistable'   => 1,
                                                                    'is_index'          => 1,
																	'type'              => 'fibenistable',
																  
                                                                    //'is_ro'               =>1,
                                                                    'is_mandatory'        => 0,
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',           // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',             // attribute code field
                                                                    'child_attr_code'     => 'APSL',                // attribute code
                                                                                                                        
                                                                        'default_rows_prop'=>array('start_rows'=>'1',
																								   'min_spare_rows'=>'1',
																								   'max_row'=>'1',
																					   
																	    ),
																		
																		
														'colHeaders'=> array(
																				array('column'=>'Table','width'=>'200','type'=>'dropDown',
																				'data'=>"<option value=Entity_Child_Base>Entity Child Base</option>".
																				        "<option value=Entity_Child>Entity Child</option>".
																						"<option value=user_info>User</option>"),
																									
																									
																				array('column'=>'Entity Code','width'=>'100','type'=>'dropDown',
																				'data'=> $G->ft_option_builder('entity','concat(code,\'->\',sn),sn'," WHERE is_lib=0 ORDER BY sn ASC")),
																									
																									
																				array('column'	=>'Option Value',	'width'=>'100',	'type'=>'dropDown',
																				
																						'data'	=>	"<option value=token>Token</option>".
																									"<option value=sn>SN</option>".
																									"<option value=ln>LN</option>".
																									"<option value=id>ID</option>"),
																						
																				array('column'=>'Option Label','width'=>'100','type'=>'dropDown',
																				
																					'data'=>"<option value=token>Token</option>".
																					        "<option value=sn>SN</option>".
																							"<option value=ln>LN</option>".
																							"<option value=id>ID</option>".
																							"<option value=get_user_internal_name(id)>User Name</option>"),
																							
																				array('column'=>'Filter','width'=>'300','type'=>'text')
																	 ),
                                                                     
                                                                     'is_hide' => 0, 
																	 
																	 'hint'=>"Mostly Use, If Entity Child Base -> Option Value(token) : Option Label(SN/LN)<br>If Entity Child  -> Option Value(id) : Option Label(SN)<br>If User Info  -> Option Value(id) : Option Label(User Name)<br>"
                                                                     
                                                               ),
															   
												    '55' =>array(     'field_name'         => 'Avoid Default Option',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          	   => 'toggle',
                                                                    'is_mandatory'         => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APAD'           // attribute code                                                                    
                                                            ),
															
															
														'59' =>array(     'field_name'         => 'Option Default Label',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          	   => 'text',
                                                                    'is_mandatory'         => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APLL'           // attribute code                                                                    
                                                            ),
															
														'60' =>array(     'field_name'         => 'Opt. Lbl. Col. Query',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          	   => 'text',
                                                                    'is_mandatory'         => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APOL'          // attribute code                                                                    
                                                            ),	
                                                        
                                                        
                                                      '9' =>array('field_name'=>'Line order',
                                                               
                                                               'field_id'=>'line_order',
                                                               
                                                               'type'=>'text',
                                                               
                                                               'allow'=>'d10[.]',
							       
																'is_mandatory'=>0,
                                                               
                                                               'input_html'=>' class="w_50 align_RM" '
						   
                                                               ),  
                                                        
                                                     '10'  => ['field_name'=>'General',
								 'type'=>'heading'					 
								],   
                                                    
                                                    '11' =>array(     'field_name'         => 'Class',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APCL',           // attribute code
                                                                    //'hint'                => '(Class Attribute)',
                                                                     'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    '12' =>array(     'field_name'         => 'HTML',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APIH',           // attribute code
                                                                    //'hint'                => '(Class Attribute)',
                                                                     'input_html'         => 'class="w_100"'
						   
                                                               ),
                                                    
                                                    
                                                    '13' =>array(     'field_name'         => 'Allow',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APAL',           // attribute code
                                                                    'hint'                => '(d10,w10,x10...etc)',
                                                                     'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    '14' =>array(   'field_name'            => 'Mandatory',                                                                
                                                                    'field_id'              => 'ea_value',				       
                                                                    'is_mandatory'          => 0,
                                                                    
                                                                    'type'                => 'toggle',
                                                                    'on_label'            => 'Yes',
                                                                    'off_label'            => 'No',
                                                                    'show_status_label'  => 1,
                                                                    'child_table'           => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'       => 'parent_id',    // parent field
                                                                    'child_attr_field_id'   => 'ea_code',   // attribute code field
                                                                    'child_attr_code'       => 'APMA',           // attribute code
                                                                    'input_html'            => 'class="w_60"',
                                                                    'avoid_default_option'  => 1
                                                                    
						   
                                                               ),
                                                    
                                                    '15' =>array(     'field_name'         => 'Hint',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APHT',           // attribute code
                                                                    'hint'                => '(d10,w10,x10...etc)',
                                                                     'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    
                                                   
                                                    
                                                    
                                                     '16' =>array(     'field_name'         => 'Hide',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'toggle',
                                                                    'on_label'            => 'Yes',
                                                                    'off_label'            => 'No',
                                                                     'show_status_label'  => 1,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APHD',           // attribute code
                                                                    'input_html'         => 'class="w_30"',
                                                                    'avoid_default_option' => 1
						   
                                                               ),
                                                     
                                                     
                                                        '17' =>array(     'field_name'         => 'Read Only',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'toggle',
                                                                    'on_label'            => 'Yes',
                                                                    'off_label'            => 'No',
                                                                     'show_status_label'  => 1,
                                                                   // 'option_data'         => "<option value=''>No</option><option value=1>Yes</option>",                                                               
                                                                    //'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APRO',           // attribute code
                                                                    'input_html'         => 'class="w_30"',
                                                                    
						   
                                                               ),
															   
															   
														'57' =>array(     'field_name'         => 'Avoid Empty/Zero',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'toggle',
                                                                    'on_label'            => 'Yes',
                                                                    'off_label'            => 'No',
                                                                     'show_status_label'  => 1,
                                                                   // 'option_data'         => "<option value=''>No</option><option value=1>Yes</option>",                                                               
                                                                    //'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APEZ',           // attribute code
                                                                    'input_html'         => 'class="w_30"',
                                                                    
						   
                                                               ),	   
                                                        
                                                    
                                                    
                                                     '18'  => ['field_name'=>'Date',
								 'type'=>'heading'					 
								],
                                                    
                                                    '19' =>array(     'field_name'         => 'Min Date',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APMD',           // attribute code
                                                                    'hint'                => '(-10Y,10Y,10D...etc)',
                                                                     'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    '20' =>array(     'field_name'         => 'Max Date',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APXD',           // attribute code
                                                                    'hint'                => '(-10Y,10Y,10D...etc)',
                                                                     'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    '21' =>array(     'field_name'         => 'Min Year',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APMY',           // attribute code
                                                                    'hint'                => '(Specify year eg.(2010))',
                                                                    'allow'               => 'd4',
                                                                     'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    '22' =>array(     'field_name'         => 'Max Year',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APXY',           // attribute code
                                                                    'hint'                => '(Specify year eg.(2019))',
                                                                    'allow'               => 'd4',
                                                                    'input_html'         => 'class="w_75"'
						   
                                                               ),
                                                    
                                                    '23' =>array(     'field_name'         => 'Default date',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'option',
                                                                    'option_data'         => '<option value=0>No</option><option value=1>Yes</option>',                                                               
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APDD',           // attribute code
                                                                   'input_html'         => 'class="w_30"',
                                                                   'avoid_default_option' => 1
						   
                                                               ),
                                                    
                                                     '24'  => ['field_name'=>'Option',
                                                                      'type'=>'heading'					 
                                                                    ],
                                                            
                                                    
                                                    '25' =>array(    'field_name'         => 'Avoid Default Option',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'option',
                                                                    'option_data'         => '<option value=0>No</option><option value=1>Yes</option>',                                                               
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APAD',           // attribute code
                                                                    'input_html'         => 'class="w_30"',
                                                                    'avoid_default_option' => 1
						   
                                                               ),
                                                    
                                                     //'31' =>array(     'field_name'         => 'Label Content',                                                                
                                                     //               'field_id'            => 'ea_value',				       
                                                     //               'type'                => 'textarea',
                                                     //               'is_mandatory'        => 0,
                                                     //                                                                   
                                                     //               //child table
                                                     //                       
                                                     //               'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                     //               'parent_field_id'     => 'parent_id',    // parent field
                                                     //                                       
                                                     //               'child_attr_field_id' => 'ea_code',   // attribute code field
                                                     //               'child_attr_code'     => 'APLC',           // attribute code
                                                     //               'input_html'         => 'class="w_200"',
                                                     //               
                                                     //          ),    
                                                   
                                                   
                                                   '26'  => ['field_name'=>'Fiben Table',
								 'type'=>'heading'					 
								],
                                                   
                                                   '27' =>array(     'field_name'         => 'Number Of Rows',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APFR',           // attribute code
                                                                    'hint'                => '(eg : 1,2..n)',
                                                                     'input_html'         => 'class="w_50"',
                                                                     'allow'              => 'd10'
						   
                                                               ),
                                                   
                                                    '28' =>array(     'field_name'         => 'Maximum Rows',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APMR',           // attribute code
                                                                    'hint'                => '(eg : 1,2..n)',
                                                                     'input_html'         => 'class="w_50"',
                                                                     'allow'              => 'd10'
						   
                                                               ),
                                                   
                                                         '29' =>array(     'field_name'         => 'Minimal Rows to fill',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                                                                        
                                                                    //child table
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field
                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APGR',           // attribute code
                                                                    'hint'                => 'Leave empty for all rows to fill. Work alongs with mandatory.',
                                                                     'input_html'         => 'class="w_50"',
                                                                     'allow'              => 'd10'
						   
                                                               ),
                                                         
                                                    '30' =>array(     'field_name'          => 'Template',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'option',
                                                                    'option_data'         => $G->option_builder('entity_child_base','token,sn'," WHERE entity_code='TM' ORDER by sn ASC"),                                                               
                                                                    'is_mandatory'        => 0,
                                                                    'input_html'          => ' onchange=input_type_action(this)',
                                                                                                                        
                                                                    //child table                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',            // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',              // attribute code field
                                                                    'child_attr_code'     => 'APTM',                 // attribute code
						   
                                                               ),
                                                    
                                                    '31' =>array(     'field_name'          => 'Table Heading TMPL',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type'                => 'code_editor',
                                                                    'is_mandatory'        => 0,
                                                                    'input_html'          => ' onchange=input_type_action(this)',
                                                                                                                        
                                                                    //child table                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',            // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',              // attribute code field
                                                                    'child_attr_code'     => 'APFH',                 // attribute code
						   
                                                               ),
                                                    
                                                    '46'  => ['field_name'=>'Fiben Table Columns',
								 'type'=>'heading'					 
								],
                                                       
                                                         
                                                    '32' =>array(   'field_name'          => 'Grid Detail',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'is_ro'               => 0,
                                                                    'is_fibenistable'   => 1,
                                                                    'is_index'          => 1,
								    'type'              => 'fibenistable',
                                                                    'is_mandatory'        => 0,
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',            // parent field
                                                                    'child_attr_field_id' => 'ea_code',              // attribute code field
                                                                    'child_attr_code'     => 'APFO',                 // attribute code
                                                                    'default_rows_prop'=>array('start_rows'=>'6',
											           'min_spare_rows'=>'2',
											           'max_rows'=>'10',
											    ),
								     'colHeaders'=> array(
						                                                   array('column'=>'Column Name',
                                                                                                          'width'=>'120',
                                                                                                          'type'=>'text'),
                                                                                                   
                                                                                                   array('column'=>'Width',
                                                                                                          'width'=>'75',
                                                                                                          'type'=>'text',
                                                                                                          'allow'=>'d10',
                                                                                                          //'source_url'=> "router.php?series=ax&action=rx_doctor&token=RXNW"
                                                                                                    ),
                                                                                                    
                                                                                                    array('column'=>'Type',
                                                                                                          'width'=>'100',
                                                                                                          'type'=>'dropDown',
                                                                                                          'data'=>"<option value=Text>Text</option><option value=Dropdown>Dropdown</option><option value=Autocomplete>Autocomplete</option><option value=Date>Date</option>"
                                                                                                     ),
                                                                                                    
									array('column'=>'Table',
										  'width'=>'100',
										  'type'=>'dropDown',
										  'data'=>"<option value='entity_child_base'>entity_child_base</option><option value='entity_child'>entity_child</option>"
									),
                                                                                                    
                                                                                                     array('column'=>'Op Id',
                                                                                                          'width'=>'50',
                                                                                                          'type'=>'dropDown',
                                                                                                          'data'=>"<option value=token>Token</option><option value=sn>SN</option><option value=ln>LN</option><option value=id>ID</option>"
                                                                                                          
                                                                                                    ),
                                                                                                    
                                                                                                    array('column'=>'Op Value',
                                                                                                          'width'=>'50',
                                                                                                          'type'=>'dropDown',
                                                                                                          'data'=>"<option value=token>Token</option><option value=sn>SN</option><option value=ln>LN</option><option value=id>ID</option>"
                                                                                                    ),
                                                                                                    
                                                                                                    array('column'=>'Entity Code',
                                                                                                          'width'=>'50',
                                                                                                          'type'=>'dropDown',
                                                                                                          'data'=> $G->ft_option_builder('entity','concat(code,\'->\',sn),sn'," ORDER BY sn ASC"),
                                                                                                        ),
                                                                                                    
                                                                                                    array('column'=>'A series',
                                                                                                          'width'=>'50',
                                                                                                          'type'=>'dropDown',
                                                                                                          'data'=> $G->ft_option_builder('entity_child_base','concat(token,\'->\',sn),sn',"WHERE entity_code = 'AX'  ORDER BY sn ASC"),
                                                                                                          
                                                                                                    ),
                                                                                                    
                                                                                                    array('column'=>'Allow',
                                                                                                          'width'=>'50',
                                                                                                          'type'=>'text'),
                                                                                                    
                                                                                                     array('column'=>'Pre-Fill',
                                                                                                          'width'=>'50',
                                                                                                          'type'=>'dropDown',
                                                                                                          'data'=>"<option value=no>No</option><option value=yes>Yes</option>"
                                                                                                    ),
                                                                                                     
                                                                                                     array('column'=>'HTML',
                                                                                                          'width'=>'60',
                                                                                                          'type'=>'text'),
                                                                                                    
                                                                                                     array('column'=>'Key Up Addon/Change',
                                                                                                          'width'=>'100',
                                                                                                          'type'=>'text'), 
                                                                                                    
                                                                                                  
                                                                                         ),
                                                                     
                                                                     'is_hide' => 0, 
                                                                     
                                                               ),
                                                    
                                                    
                                                            '33'  => ['field_name'=>'Document / Image',
                                                                      'type'=>'heading'					 
                                                                    ],
                                                   
                                                            '34' =>array(     'field_name'         => 'File Name',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APFN',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                    'allow'              => 'x50'
						   
                                                            ),
                                                            
                                                            '35' =>array(     'field_name'         => 'File Prefix',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APFP',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                    'allow'              => 'x50'						   
                                                            ),
                                                            
                                                            '36' =>array(     'field_name'         => 'File Suffix',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APFS',           // attribute code                                                                    
                                                                        
                                                                    'input_html'         => 'class="w_250"',
                                                                    'allow'              => 'x50'						   
                                                            ),
                                                            
                                                            '37' =>array(     'field_name'         => 'File Location',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APLO',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                    //'allow'              => 'x50'						   
                                                            ),
                                                            
                                                            '38' =>array(     'field_name'         => 'File Allow Type',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APFX',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                    //'allow'              => 'x50'						   
                                                            ),
                                                            
                                                            '39' =>array(     'field_name'         => 'File Maximum Size',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APFM',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                    //'allow'              => 'x50'						   
                                                            ),
                                                            
                                                            '40' =>array(   'field_name'          => 'Image Size',                                                                
                                                                    'field_id'            => 'ea_value',				       
                                                                    'is_ro'               => 0,
                                                                    'is_fibenistable'   => 1,
								    'type'              => 'fibenistable',
                                                                    'is_index'          => 1,
                                                                    'is_mandatory'        => 0,
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',            // parent field
                                                                    'child_attr_field_id' => 'ea_code',              // attribute code field
                                                                    'child_attr_code'     => 'APIS',                 // attribute code
                                                                    'default_rows_prop'=>array('start_rows'=>'4',
											           'min_spare_rows'=>'0',
											           'max_rows'=>'0',
											    ),
								     'colHeaders'=> array(
						                                                   array('column'=>'Width',
                                                                                                          'width'=>'120',
                                                                                                          'type'=>'text',
                                                                                                          'allow'=>'d10'),
                                                                                                   
                                                                                                   array('column'=>'Height',
                                                                                                          'width'=>'75',
                                                                                                          'type'=>'text',
                                                                                                          'allow'=>'d10'
                                                                                                    ),
                                                                                                    
                                                                                         ),
                                                                     
                                                                     'is_hide' => 0, 
                                                                     
                                                               ),
                                                            
                                                            
                                                            
                                                            '41'  => ['field_name'=>'Toggle',
                                                                      'type'=>'heading'					 
                                                                    ],
                                                            
                                                            
                                                              
                                                            '42' =>array(     'field_name'         => 'Show Status Label',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'toggle',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APTS',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                  
                                                                    
                                                                  
                                                                  					   
                                                            ),
                                                            
                                                            
                                                            '43' =>array(     'field_name'         => 'On Label',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APTN',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                            ),
                                                            
                                                            '44' =>array(     'field_name'         => 'Off Label',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'text',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APTF',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                            ),
                                                            
                                                            '45' =>array(     'field_name'         => 'Set On by Default',                                                                
                                                                     'field_id'            => 'ea_value',				       
                                                                    'type' 	          => 'toggle',
                                                                    'is_mandatory'        => 0,
                                                                            
                                                                    'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                    'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                    'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                    'child_attr_code'     => 'APTD',           // attribute code                                                                    
                                                                    
                                                                    'input_html'         => 'class="w_250"',
                                                                    'show_status_label'  => 1,
                                                                    'on_label'           =>'Yes',
                                                                    'off_label'           =>'No'
                                                            ),
                                                            
                                                            
                                                            '47'  => ['field_name'=>'Desk',
                                                                      'type'      =>'heading'					 
                                                                    ],
                                                            
                                                            '48' =>array(  'field_name'         => 'Add this to Desk?',                                                                
                                                                           'field_id'            => 'ea_value',				       
                                                                           'type' 	          => 'toggle',
                                                                           'is_mandatory'        => 0,
                                                                                   
                                                                           'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                           'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                           'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                           'child_attr_code'     => 'ADXI',           // attribute code                                                                    
                                                                           
                                                                           'input_html'         => 'class="w_250"',
                                                                           'show_status_label'  => 1,
                                                                           'on_label'           =>'Yes',
                                                                           'off_label'           =>'No'
                                                            ),
                                                            
                                                                                                                      
                                                            '49' =>array(     'field_name'        => 'Column Header Name',                                                                
                                                                              'field_id'          => 'ea_value',				       
                                                                              'type' 	          => 'text',
                                                                              'is_mandatory'      => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXN',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="x_300[=\']"',
                                                                            'allow'               => 'x256'
                                                            ),
                                                            
                                                            '50' =>array(     'field_name'        => 'Column Header Attr.',                                                                
                                                                              'field_id'          => 'ea_value',				       
                                                                              'type' 	          => 'text',
                                                                              'is_mandatory'      => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXH',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300[=\']"',
                                                                            'allow'               => "x256[=']"
                                                            ),
                                                            
                                                            '51' =>array(     'field_name'        => 'Column Attr.',                                                                
                                                                              'field_id'          => 'ea_value',				       
                                                                              'type' 	          => 'text',
                                                                              'is_mandatory'      => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXC',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300[=\']"',
                                                                            'allow'               => "x256[=']"
                                                            ),
                                                            
                                                            '52' =>array(     'field_name'        => 'Filter Out.',                                                                
                                                                              'field_id'          => 'ea_value',				       
                                                                              'type' 	          => 'textarea',
                                                                              'is_mandatory'      => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXF',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300"',
                                                                            'allow'               => "x256[=']"
                                                            ),
															
                                                            '53' =>array(     'field_name'        => 'JS Call',                                                                
                                                                              'field_id'          => 'ea_value',				       
                                                                              'type' 	          => 'textarea',
                                                                              'is_mandatory'      => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXJ',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300"',
                                                                            'allow'               => "x256[=']"
                                                            ),
                                                            
															
															'58' =>array(     'field_name'        => 'Col. Function',                                                                
                                                                              'field_id'          => 'ea_value',				       
                                                                              'type' 	          => 'text',
                                                                              'is_mandatory'      => 0,
																			'hint'				  =>"Default:get_ecb_sn_by_token<br>". "Custom:get_exav_addon_varchar([[this]],'DAV')",	
																			  
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXQ',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300" ',
                                                                            'allow'               => "w128[_]"
                                                            ),
                                                            
                                                            
                                                            '54' =>array(   'field_name'          => 'Sort',                                                                
                                                                            'field_id'            => 'ea_value',				       
                                                                            'type' 	          	  => 'text',
                                                                            'is_mandatory'        => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADXS',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300"',
                                                                            'allow'               => "x64"
                                                            ),
                                                            
														   '56' =>array(   'field_name'          => 'Line Order',                                                                
                                                                            'field_id'            => 'ea_value',				       
                                                                            'type' 	          	  => 'text',
                                                                            'is_mandatory'        => 0,                                                                            
                                                                            'child_table'         => 'ecb_av_addon_varchar', // child table 
                                                                            'parent_field_id'     => 'parent_id',    // parent field                                                                                            
                                                                            'child_attr_field_id' => 'ea_code',   // attribute code field
                                                                            'child_attr_code'     => 'ADLO',           // attribute code                                                                                                                                        
                                                                            'input_html'          => 'class="w_300"',
                                                                            'allow'               => "x64"
                                                            ),
                                ),
                                    
                                # form layout
                                
                                'form_layout' => 'form_50__40-60',
                                    
				#Table Name
				
				'table_name'    => 'entity_child_base',
                                
                                'divider'       => 'tab',
				
				#Primary Key
                                
			        'key_id'        => 'id',
                                
				# Default Additional Column
                                
				'is_user_id'       => 'user_id',
                                
				'js' => array('is_top' => 1, 'top_js' => $LIB_PATH.'def/external_attribute/f'),
				
				'css'=>1,
								
				# Communication
								
				'back_to'  => array( 'is_back_button' =>1, 'back_link'=>'?d=external_attribute', 'BACK_NAME'=>'Back'),
                                
				'prime_index'   => 1,
                                
				# File Include
                                'after_add_update'	=>0,
				
				'page_code'	=> 'FECB',
                                
                                'show_query' => 0,
                                
                                'default_fields'=>array("dna_code"=>"'EBAT'"),
                                
                                'is_field_id_as_token'=>1,
								
								'is_cc'=>1
				
			);
    
    
        
        
        
    
    
        // default addon
        
        if(@$_GET['default_addon']){
            
            $F_SERIES['data'][1]['option_data']          = $G->option_builder('entity','code,sn'," WHERE code='$_GET[default_addon]'");
            $F_SERIES['data'][1]['avoid_default_option'] = 1;
        
        }else{
            
            $F_SERIES['data'][1]['option_data']=$G->option_builder('entity','code,sn'," WHERE is_lib=0  ORDER by sn ASC");
        
        } // default addon
        
                
        //ext_at_addon
        
        $LAYOUT = 'external_attribute';
        
        $temp = [];
        
        $temp ['input_type'] = ['EX'    => [0,1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                            21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,
                                            41,42,43,44,45,46,55,59,60],
                                'GN'    => [0,1,2,3,4,5,6,9,10,11,12,14,15,16,17],
                                'ITTX'  => [13],
                                'ITUQ'  => [13],
                                'ITFT'  => [26,27,28,29,30,31,32,46],
                                'ITSL'  => [8,55,59,60],
                                'ITML'  => [8,55,59,60],
                                'ITTA'  => [13],
                                'ITIG'  => [13],
                                'ITNM'  => [13],
                                'ITCE'  => [],
                                'ITTE'  => [],
                                'ITSH'  => [],
                                'ITHD'  => [],
                                'ITHN'  => [],
                                'ITLA'  => [],
                                'ITTI'  => [],
                                'ITTG'  => [41,42,43,44,45],
                                'ITFI'  => [33,34,35,36,37,38,39,40],
                                'ITFD'  => [33,34,35,36,37,38,39,40],
                                'ITDT'  => [18,19,20,21,22,23],
                             ];
        
        if(@$_GET['i_t']){
                
                if (array_key_exists($_GET['i_t'],$temp['input_type'])){
                
                        $F_SERIES['data'][6]['option_data']=$G->option_builder('entity_child_base','token,ln'," WHERE entity_code='IT' AND token= '$_GET[i_t]' ORDER by ln ASC");
                        
                        $F_SERIES['data'][6]['avoid_default_option']= 1;
                        
                        $temp['to_set']=array_merge($temp ['input_type']['GN'],$temp ['input_type'][$_GET['i_t']]);
                        
                        $temp['to_set_final']=array_diff($temp['input_type']['EX'],$temp['to_set']); 
                
                }else{
                        
                        $temp['to_set_final']=array_diff($temp ['input_type']['EX'],$temp['input_type']['GN']);
                
                }       
        
        }else{
                
                $temp['to_set_final']=array_diff($temp ['input_type']['EX'],$temp['input_type']['GN']);
                
        }
        
        
        foreach($temp ['to_set_final'] as $key => $val){
                
                unset($F_SERIES['data'][$val]);
                
        };
        
        //end of ext_at_addon
        if(@$_GET['default_addon']){            
            $default_addon = $_GET['default_addon'];
            $F_SERIES['back_to']['is_back_button']=0;
            
            
        } // end
        
        // if not update
        if(!@$_GET['key']){
           
           $temp['where']=(@$default_addon)?"WHERE entity_code='$default_addon'":''; 
           $temp['line_order_value']=($G->get_count(['table'=>'entity_child_base','where'=>$temp['where']])+1);             
           $F_SERIES['data']['9']['input_html']=" value='$temp[line_order_value]'"; 
           $F_SERIES['data']['56']['input_html']=" value='$temp[line_order_value]'"; 
		   
        } // end)
    
?>
