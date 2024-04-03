<?PHP
//            define("PAGE_CODE", "MANAGE_USER");
//		
//	    define('PAGE_PERM', $_SESSION['MANAGE_USER']);
    
            $D_SERIES       =   array(
			              #Title:
			              
                                      'title'=>'User Role and Permission',

                                      #query display depend on the user

                                      'is_user_base_query'=>0,
                                    
                                     'is_narrow_down' =>1,
                                      #table data
                                    
                                       'data'=> array(
                                                            1=>array('th'=>'Code',
                                                                     
                                                                     'field'=>'sn',
                                                                            
                                                                    'html' => 'style	= "cursor:pointer" onclick="JavaScript:E_V_PASS(\'sort_field\',1);E_V_PASS(\'sort_direction\',GET_E_VALUE(\'sort_col_1\'));filter_data();"',
								  
								    'font'=>  'class="sort"',
																
								    'span'=>'<span id="sort_icon_1" name="sort_icon_1"></span>'
                                                                    
                                                            ),
                                                            
                                                            2=>array('th'=>'Role',
                                                                     
                                                                     'field'=>'ln',
								    
                                                                    'html' => 'style	= "cursor:pointer" onclick="JavaScript:E_V_PASS(\'sort_field\',2);E_V_PASS(\'sort_direction\',GET_E_VALUE(\'sort_col_2\'));filter_data();"',
								  
								    'font'=>  'class="sort"',
																
								    'span'=>'<span id="sort_icon_2" name="sort_icon_2"></span>'
                                                                    
                                                            ),
                                                            
                                                            3=>array('th'=>'Default URL',
                                                                     
                                                                     'field'=>'home_page_url',
								     
                                                                     'attr'=>["width"=>"25%"]
                                                            ),

                                                            's'=>array('th'=>'Session Active Time(Seconds)',
                                                                     
                                                                     'field'=>"IF((session_time=0),'Default',session_time)",
								     
                                                                     'attr'=>["width"=>"10%",'class'=>'align_RM']
                                                            ),
							    
							    
                                                            
                                                            4=>array('th'=>'Permission',
                                                                     
                                                                     'field'=>"concat(id,':',IFNULL((SELECT user_permission_ids FROM user_role_permission WHERE user_role_id=user_role.id),''),':',".
                                                                                            "IFNULL((SELECT user_role_permission.id FROM user_role_permission WHERE user_role_id=user_role.id LIMIT 1),''))",
								     
                                                                     'attr'=>["width"=>"10%",
                                                                              "class"=>"align_CM"],
                                                                     
                                                                    'filter_out'=>function($data_in){
												
                                                                                                        $temp = explode(':',$data_in);
                                                                                                        
                                                                                                        
                                                                                                        $data_out = array('id'         => $temp[0],
                                                                                                                          'link_title' => '',
                                                                                                                           'is_fa'=>' fa-plus clr_green ',
													                   'is_fa_btn'=>' btn-default ',
                                                                                                                          'title'      => 'Set Permission',
                                                                                                                            'src'  =>  "?f=user_role_permission&default_addon=$temp[0]&menu_off=1",
                                                                                                                            'style'=>  "border:none;width:100%;height:600px;",
                                                                                                                             
                                                                                                         );
                                                                                                        
                                                                                                        if($temp[1]){
                                                                                                                $data_out['is_fa']            = ' fa-edit clr_blue ';
                                                                                                                $data_out['src']              = "?f=user_role_permission&default_addon=$temp[0]&menu_off=1&key=$temp[2]";
                                                                                                        }else{
                                                                                                                $data_out['refresh_on_close'] = 1;  
                                                                                                        }
                                                                                                    
													return json_encode($data_out);
									},
                                                                        
                                                                        'js_call'=>'d_series.set_nd'
                                                            ),
                                                            
                                                            
                                                            5=>array('th'=>'Pages',
                                                                     
                                                                     'th_attr'=>' colspan=2',
                                                                     
                                                                     'field'=>"concat(id)",
								     
                                                                     'attr'=>["width"=>"5%",
                                                                              "class"=>"align_CM"],
                                                                     
                                                                    'filter_out'=>function($data_in){
												        
                                                                                                        $data_out = array( 'id'              => $data_in,
                                                                                                                           'link_title'      => '',
                                                                                                                           'is_fa'           => ' fa-plus clr_green ',
													                   'is_fa_btn'       => ' btn-default ',
                                                                                                                           'title'           => 'Set User Role Pages',
                                                                                                                           'src'             => "?f=user_role_page&default_addon=$data_in&menu_off=1",
                                                                                                                           'style'           => "border:none;width:100%;height:600px;",
                                                                                                                           'refresh_on_close'=> 1
                                                                                                                        );
                                                                                                        					
													return json_encode($data_out);
									},
                                                                        
                                                                        'js_call'=>'d_series.set_nd'
                                                            ),
                                                            
                                                            6=>array('th'=>'',
                                                                     
                                                                     'field'=>"concat(id)",
								     
                                                                     'attr'=>["width"=>"5%",
                                                                              "class"=>"align_CM"],
                                                                     
                                                                    'filter_out'=>function($data_in){
												        
                                                                                                        $data_out = array( 'id'              => $data_in,
                                                                                                                           'link_title'      => '',
                                                                                                                           'is_fa'           => ' fa-edit clr_green ',
													                   'is_fa_btn'       => ' btn-default ',
                                                                                                                           'title'           => 'Set User Role Pages',
                                                                                                                           'src'             => "?d=user_role_page&default_addon=$data_in&menu_off=1",
                                                                                                                           'style'           => "border:none;width:100%;height:600px;",
                                                                                                                           #'refresh_on_close'=> 1
                                                                                                                        );
                                                                                                        					
													return json_encode($data_out);
									},
                                                                        
                                                                        'js_call'=>'d_series.set_nd'
                                                            ),
                                                            
                                                            
							    
						),
				       
				                                           
                                    #Table Info
                                    
                                    'table_name' =>'user_role',
                                    
                                    'key_id'    =>'id',
                                    
                                    'is_user_id'       => 'user_id',
                                
                                    'search'=> array(
							  
							array(  'data'  =>array('table_name' 	=> 'user_role',
										'field_id'	=> 'id',
										'field_name' 	=> 'ln',
									     ),
												     
								'title' 		=> 'Role',										
								'search_key' 		=> 'id',													       
								'is_search_by_text' 	=> 0,
							     ),							
							
						       ),
				   
				   
				    'check_field'   =>  array('id' => @$_GET['id']),
				   
				    'date_filter'  => array( 'is_date_filter' =>0,'date_field' =>'timestamp_punch'),
				
				    'sort_field' =>array('sn','ln'),
				    
				    'order_by'   =>'ORDER BY id ASC',
				    
				    'action' => array('is_action'=>1, 'is_edit' => 1, 'is_view' =>0),
                                       
                                    'add_button' => array( 'is_add' =>1,'page_link'=>'f=user_role', 'b_name' => 'Add User Role' ),
				    
				    'del_permission' => array('able_del'=>1,'user_flage'=>1), 
								
			            'prime_index'   => 2,
                                    
                                
                            
                            );