<?PHP

    include_once($LIB_PATH."/inc/lib/f_addon.php");
                        
    $F_SERIES	=	array(
				#Desk Title
				
				'title'	=>'Entity Child',
				
				#Table field
                    
				'data'	=>   array(),
                                    
				#Table Name
				
				'table_name'    => 'entity_child',
				
				#Primary Key
                                
			        'key_id'        => 'id',
					
                                
				# Default Additional Column
                                
				'is_user_id'       => 1,
				
				'is_field_id_as_token'=>1,
								
				# Communication
								
				'add_button' => array( 'is_add' =>1,'page_link'=>'f=entity_child', 'b_name' => 'Add Entity child' ),
                     
				'back_to'  => array( 'is_back_button' =>1, 'back_link'=>''),
                                
				'prime_index'   => 2,
                                
				# File Include
                                'after_add_update'	=>0,
				
				'divider' => 'tab', 
				
				'get_last_insert'=>1,
				
				'js'=> ['is_top'=>1],
				'avoid_trans_key_direct'=>1,
				
				'gx'=>1, 

				'is_cc'=>1,

				'show_query'=>0
			);
    
			if(isset($_GET['default_addon'])){
			
				list($default_addon,$parent_id) = (strpos(@$_GET['default_addon'],':'))?explode(':',@$_GET['default_addon']):[@$_GET['default_addon'],0];
				
				if($default_addon){													
									
					// faddon array										
					@$F_SERIES['temp']=f_addon(['g'		        => $G,
												'rdsql'		    => $rdsql,
												'f_series'     	=> ['data'=>$F_SERIES['data']],
												'default_addon' => json_encode(['en'=>$default_addon]),
												'coach'			=> $COACH,
												'is_cache'		=> 0,
												'page_code'		=> $default_addon.'_'.$PAGE_CODE
										]);										
									
					$F_SERIES['data']=$F_SERIES['temp']['data'];
					
					// inserts the entity code finally in data array & remove the earlier.				
					array_push($F_SERIES['data'],[ 'field_name'		=>'Entity Code',
												   'field_id' 		=> 'entity_code',                                           
												   'type' 			=> 'hidden',
												   'attr'			=> ['value'=>$default_addon],
												   'is_mandatory'	=>1]);														
					
					
					
					//parent field id
					$F_SERIES['data']['lo']=['field_name'=>'Parent Id',
												  'field_id' => 'line_order',                                                               
												  'type' => 'hidden', 
												  'attr'=>['value'=>$parent_id],
												  'ro'=>1
										    ];		
										
					$F_SERIES['back_to']['back_default_addon']=$default_addon;		
					
				} // end
			
			} # end
    

			if(isset($_GET['menu_off'])){
			    $menu_off = @$_GET['menu_off'];
			    $F_SERIES['back_to']['back_menu_off']=$menu_off;			    
			    $F_SERIES['back_to']['is_back_button']=0;
			}     
			
?>
