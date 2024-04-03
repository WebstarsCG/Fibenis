<?PHP

    $F_SERIES=array( 'title'=>'User Role',
                    
                     'data'=>array(
					 				  '1' => array( 
									  		
											    'field_name'=> 'Code',  'field_id' => 'sn', 'type' => 'text','is_mandatory'=>1, 'allow' => 'w3',
											 
											    'validate' => 'data_validate(\'user_role\',this)', 'hint' => 'Give three letters'
											    
										       ),
											
				 					  '2' => array( 'field_name'=> 'Role Name',
										        'field_id' => 'ln',
											'type' => 'text',
											'is_mandatory'=>1,
											'allow' => 'w_100'),
									  
									  '3' => array( 'field_name'=> 'Home Page URL',
										        'field_id' => 'home_page_url',
											'type' => 'text',
											'is_mandatory'=>1,
											'allow' => 'w_100'),

									'4' => array( 'field_name'=> 'Session Active Time',
											'field_id' => 'session_time',
										'type' => 'text',
										'is_mandatory'=>1,
										'allow' => 'd7')
				    ),
					
					
                     'table_name'    => 'user_role',
                                
                     'key_id'        => 'id',
                                
                    # Default Additional Column
                                
                    'is_user_id'       => 'user_id',
								
                    # Communication
								
		    'back_to'  => array( 'is_back_button' =>1, 'back_link'=>'?d=user_role', 'BACK_NAME'=>'Back'),
                                
                     'prime_index'   => 1,

					 'is_cc'=>1,
                                
                    # File Include
                                
                    //'js'            => 'q_details',
				
		    'page_code'	=> 'FMUR'
                                
                    
                    
                    );
?>