<?PHP

    $D_SERIES   =   array(
	
			    'title' => 'Entity Dashboard',
	
			    'data'=> array(
				
					    1=> array(
						       'field_composite'=>  [  
										'fields'=>['x'    => ' (SELECT sn FROM entity WHERE code=entity_code)',
											   'Total'=> 'count' ],
										'table' =>'entity_count'
									    ],
						       
						       'js_call'	=> 'c3001.graphDonut',
						       'attr' 		=> [	'class'	   	=> "col-md-12 pad_lr mar_top_25",
										'data-title' 	=> "Entity Count",
										'data-type'  	=> 'bar',
									    ]
					    ),
						
						
					    2=> array(
						      
						       'field_composite'=>  [
									      
									      'fields'=>['Date'=>'date',
											 'Total'=>'total',
											// 'Total 20'=>'(total+20)',
											// 'Rand'=>"(ROUND((RAND()*(30-5)+5),0))"
											 ],
									      
									      'table' => 'page_view_log_by_day',
									      'filter'=> " page_code='f6a493b8ef6b14b86c060917f15595c4' ORDER BY DATE ASC "
									    ],
						       
						       'js_call'	=> 'c3001.graphBase',
						       
						       'attr' 		=> [
								  
										'class'      	=> "col-md-12 pad_lr mar_top_25",
										'data-title' 	=> "Login Count by Day",
										'data-type'  	=> 'line',
										#'data-bar-width'=> 50,
										'data-grid-x'	=> true,
										'data-grid-y'	=> true
									    ]
						       ),							
						
					), # columns
			    			    
			    'mode' 	=> 'graph',
			    
		    );    
?>