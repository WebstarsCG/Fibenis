<?PHP

    $LAYOUT	    = 'layout_basic';
    
    $F_SERIES	=	array(
				'title'	=>'Contact',
				
				'data'	=>   array(
						   '1' =>array( 'field_name'=> 'Name ',
                                                               
                                                               'field_id' => 'ea_value',
                                                               
                                                               'type' => 'text',
							       
							       'child_table'         => 'eav_addon_varchar', // child table
							       
							       'parent_field_id'     => 'parent_id',    // parent field
										       
							       'child_attr_field_id' => 'ea_code',   // attribute code field
							       
							       'child_attr_code'     => 'COFN',           // attribute code test
							       
							       'input_html'=>'class="w_200"',
							       
							       'allow'		=> 'w128[ .]',
                                                               
							       'is_mandatory'=>1,
                                                               
                                                               ),
						   
						   '2' =>array( 'field_name'=> 'Mobile ',
                                                               
                                                               'field_id' => 'ea_value',
                                                               
                                                               'type' => 'text',
							       
							       'child_table'         => 'eav_addon_varchar', // child table
							       
							       'parent_field_id'     => 'parent_id',    // parent field
										       
							       'child_attr_field_id' => 'ea_code',   // attribute code field
							       
							       'child_attr_code'     => 'COMB',           // attribute code
							       
							       'input_html'=> "class='w_200'  onchange='check_mobile(this);'",
                                                               
							       'is_mandatory'=>1,
							       
							       'allow' => 'd10',

								   'filter_in' => $FILTER['digit_in']
                                                               
                                ),
						    
						    '3' =>array( 'field_name'=> 'Email ',
                                                               
                                                               'field_id' => 'ea_value',
                                                               
                                                               'type' => 'text',
							       
							       'child_table'         => 'eav_addon_varchar', // child table
							       
							       'parent_field_id'     => 'parent_id',    // parent field
										       
							       'child_attr_field_id' => 'ea_code',   // attribute code field
							       
							       'child_attr_code'     => 'COEM',           // attribute code
							       
							       'input_html'=>"class='w_200' onchange='check_email(this);'",
							       
							       'is_mandatory'=>1,	

								    'filter_in'=>$FILTER['nospace']
                                                               
                                                               ),
						    
					    
					    ),
                                    
				'table_name'    => 'entity_child',
				
				'key_id'        => 'id',
				
				'default_fields'    => array('entity_code' => "'CO'"),
				
				'js'=> ['is_top'=>1,'top_js'=>$LIB_PATH.'def/contact_eav/f'],
				
				'is_user_id'       => 'user_id',
								
				'back_to'  => array( 'is_back_button' =>1, 'back_link'=>'?d=contact_eav', 'BACK_NAME'=>'Back'),
                                
				'prime_index'   => 1,
                                
			);
	
?>