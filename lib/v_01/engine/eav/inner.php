<?PHP
		
	$CONTENT      = array();
	$PV['EKV_SESSION'] = $G->getEKV('MP','ekv_session');
	
	# if cookie not there	
	if(@$_SESSION['ekv_session']!=$PV['EKV_SESSION']){
		$G->setEKV('MP','ekv_session',$PV['EKV_SESSION']);
		$PV['MASTER'] = $SG->set_get_master_session($COACH['name_hash']);
	}else{
		$PV['MASTER'] = $_SESSION;
	}

	// set theme
	$THM = new Theme(array_filter($PV['MASTER'],
									function($k) {
										return in_array($k,['theme_blend_has_gate','theme_blend_has_menu',
															'theme_blend_has_header','theme_blend_has_footer',
															'theme_blend','theme']);
									},ARRAY_FILTER_USE_KEY));
				
	$THM->setTheme(['theme'=>get_config('theme'),
					  'blend'=>get_config('theme_blend'),
					  'path' =>get_config('theme_path')]);

	if(is_file($LIB_PATH."/inc/".$PAGE.".php")){
		
		$PAGE_NAME 	= $_GET[$PAGE];
		
		$entity_code    = array( 'blog'		=>'BL',
					 'news_events'	=>'NE',
					 'contact_card'	=>'CG'  );
		
		$page_info      = @page_setup( array('code'=>$entity_code[$PAGE_NAME]) );
		
		#print_r($page_info);
		
	} // direct page
	else{
	        $page_info	=  dynamic_page_content(array('manipulation' => " get_eav_addon_vc128uniq(entity_child.id,'PGCD') = '$PAGE' $COACH[filter]"  ));
		
		$temp_page_info =  @page_setup( array('code'     => $page_info['entity_code'],
						      'parent_id' => $page_info['parent_id'])
				   );
		
		$page_info['side_menu'] = @$temp_page_info['side_menu'];
		
	} // end of content retrieve
	
	// set layout & content
	
	#print_r($page_info);
	
	$LAYOUT 		= @$page_info['layout'];
		
	
	$CONTENT[@$PAGE]   	= 	array(
						    'add_on'	=> '',
							'layout'        => $LAYOUT,
							'lib_path'      => $LIB_PATH,
							
							'parent_key_code'=> @$page_info['parent_key_code'],
							'parent_name' 	=> @$page_info['parent_name'],
							'parent_right_image'=>@$page_info['parent_right_image'],
							'parent_header_image'=>@$page_info['parent_header_image'],
							
							'parent_title'      => @$page_info['parent_title'],
							'parent_keywords'   => @$page_info['parent_keywords'],
							'parent_description'=> @$page_info['parent_description'],
							
							'page_title'        => @$page_info['page_title'],
							'page_keywords'     => @$page_info['page_keywords'],
							'page_description'  => @$page_info['page_description'],
							'page_right_image'  => @$page_info['page_right_image'],
							'page_header_image' => @$page_info['page_header_image'],
							
							'id'  	        => @$page_info['id'],							
							'page'          => $PAGE,							
							'title'  		=> @$page_info['title'],							
							'side_menu'     => @$page_info['side_menu']														
					);
	
					
	
	//$CONTENT[@$PAGE]['page_content']  = page_content($CONTENT[@$PAGE]);

    function call_page_content(){
			global $CONTENT,$PAGE;
			$CONTENT[@$PAGE]['page_content']  = page_content($CONTENT[@$PAGE]);
	}					

	
	function page_setup($param){
				
		$page_info = array(
			
			'BL' 	=> array('layout'=>'layout_right',
				      'title'=>'Blog',
				      'side_menu'=> get_side_menu( array( 'manipulation' => "entity_code='BL' AND get_ec_parent_id_eav(id)=0 ",'is_blog'=>1,'menu_link'=>'d=blog', 'show_query'=>0) ),
				      'menu_name' => 'Blog',						 
				      ),
			
			'NE' 	=> array('layout'=>'layout_right', 'title'=>'News Events',
				      'side_menu'=> get_side_menu( array( 'manipulation' => "entity_code='ET' AND get_ec_parent_id_eav(id)=0 ",'is_blog'=>1,'menu_link'=>'d=news_events') ),
				      'menu_name' => 'News & Events'
				      ),
			
			
			'CG' 	=> array('layout'=>'layout_right', 'title'=>'Contact Us',
				      'side_menu'=> get_side_menu( array( 'manipulation' => "entity_code='CG' AND get_ec_parent_id_eav(id)=0 ",'is_blog'=>0,
									 'is_no_content'=>1, 'menu_link'=>'d=contact_card','show_query'=>0) ),
				      'menu_name' => 'Contact Us'
				      ),
			
			'PG' 	=> array(
				      'side_menu'=>$param['parent_id']?get_side_menu( array( 'manipulation' => "entity_code='$param[code]' AND get_ec_parent_id_eav(id)=$param[parent_id] ",'is_blog'=>0,'show_query'=>0)):''
				      ),
				  
		);
		
		return @$page_info[$param['code']];
		
	} // end
	
	
	
	// get series page content
	
	function page_content($content){
		
		global $COACH,$LIB_PATH,$PV,$THM;

				
		$page = $content['page'];
		
		if(!is_file($content['lib_path']."/inc/$page.php")){
				
					
					$page		= (is_file("$COACH[path]$COACH[name]/content/$page.html"))?$page:$COACH['step_in'];
					
					$lv 		= ['home'=>"$COACH[path]$COACH[name]/content/$page.html",
								   'gate'=>$THM->getThemeBlendGate()."$COACH[step_in].html"
								  ];								  								  
					
					// content					
					$c 		= new Template(array("filename" => $lv[$COACH['step_in']],
												 "debug"    => 0));
										
					if($COACH['step_in']=='gate'){

						// config keys			  
						$lv['gate_config']  = ['is_otp','is_open','auth_type','entry_gates','is_otp_mobile','has_gate_logo'];	
						$config				= [];
				
						foreach ($lv['gate_config'] as $gate_config) {
							$config[$gate_config]	= @$PV['MASTER'][$gate_config] ?$PV['MASTER'][$gate_config]:get_config($gate_config);
						}

						foreach (['has_welcome_content'] as $gate_config) {
							$config[$gate_config]	= @$PV['MASTER'][$gate_config]?get_config($gate_config):'';
						}
					

						$c->AddParam('IS_LDAP',( ($config['auth_type'] && ($config['auth_type']=='ldap'))?1:0));
						$c->AddParam('IS_OPEN',$config['is_open']);
						$c->AddParam('IS_OTP',$config['is_otp']);
						$c->AddParam('IS_OTP_MOBILE',$config['is_otp_mobile']);
						$c->AddParam('HAS_GATE_LOGO',$config['has_gate_logo']);
						$c->AddParam('HAS_WELCOME_CONTENT',$config['has_welcome_content']);
						$c->AddParam('TERMINAL_PATH',$COACH['terminal_path']);
						
						$lv['entry_gates_text'] = $config['entry_gates'];
						$lv_['gate']			= @$_GET['gate'];
						
						if($lv['entry_gates_text'] && $lv_['gate']){
							$lv['entry_gates'] 		= explode(',',$lv['entry_gates_text']);
							$c->AddParam('GATE',(in_array($lv_['gate'],$lv['entry_gates'])?$lv_['gate']:''));
						}						
					}
					
					if($content['add_on']){ $c->AddParam($content['add_on']); } 
					
					return $c->Output();
			
		}
		
	} // end
	
	
	
	
	// get dynamic page conent	
	function dynamic_page_content($param){
		
			global $rdsql;
			 
			global $PARAM;
			
			$select_data = "SELECT
						get_eav_addon_varchar(entity_child.id,'ECLN') as ln,						
						get_eav_addon_varchar(entity_child.id,'ECCD') as code,
						get_ec_parent_id_eav(entity_child.id) as parent_id,												        
					        get_page_parent_eav(get_ec_parent_id_eav(entity_child.id)) as parent_name,
						IFNULL(get_eav_addon_varchar(entity_child.id,'PGPL'),'layout_right') as page_layout,
						get_eav_addon_varchar(entity_child.id,'PGKW') as page_keywords,
						get_eav_addon_varchar(entity_child.id,'PGPD') as page_description,
						get_eav_addon_varchar(entity_child.id,'PGPT') as page_title,
						get_eav_addon_varchar(entity_child.id,'PGIB') as page_header_image,
						get_eav_addon_varchar(entity_child.id,'PGIC') as page_right_image,
						entity_code,
						id
					FROM
						entity_child
					WHERE
						$param[manipulation]
					 ";
			//echo $select_data;		  
			
			$exe_select_info = $rdsql->exec_query($select_data,'pag dy content');
			
			$get_row 	 = $rdsql->data_fetch_object($exe_select_info);		
			
			$temp_parent     = (@$get_row->parent_name)?(explode('[C]',@$get_row->parent_name)):['home','Home','','','','',''];
			
			return array(
				     'id' 	        => @$get_row->id,
				     'title' 	        => @$get_row->ln,
				     
				     'parent_id'        => @$get_row->parent_id,
				     
				     'page_title'       => @$get_row->page_title,
				     'page_keywords'    => @$get_row->page_keywords,
				     'page_description' => @$get_row->page_description,
				     'page_right_image' => @$get_row->page_right_image,
				     'page_header_image'=> @$get_row->page_header_image,
				     
				     'parent_key_code'     => $temp_parent[0],			     
				     'parent_name'         => $temp_parent[1],
				     'parent_header_image' => $temp_parent[2],
				     'parent_right_image'  => $temp_parent[3],
				     
				     'parent_title'       => $temp_parent[4],
				     'parent_description' => $temp_parent[5],
				     'parent_keywords'    => $temp_parent[6],
				     
				     'layout'  	        => @$get_row->page_layout,
				     'entity_code'      => @$get_row->entity_code				     				  
			);
			
	} // end of dynamic page content
		
	
	
	// get side menu
	function get_side_menu($param){
		
		global $rdsql;		
		global $PAGE_NAME;
		global $PAGE;
		global $G;
		global $LIB_PATH;
		
		$page      = $PAGE;
		$page_name = $PAGE_NAME;
		
		$temp_info	 = array();
		
		// query
		
		$select_data = "SELECT
					id,
					get_eav_addon_varchar(id,'ECSN') as sn,
					get_eav_addon_vc128uniq(id,'PGCD') as code,					
					get_eav_addon_num(id,'PGRD') as redirect_url
				FROM
					entity_child
				WHERE 1=1 AND 
					$param[manipulation] AND is_active=1	
				ORDER BY
					line_order ASC";
				 
		if(@$param['show_query']){
			
			echo $select_data.'-------<br>';			
		}
		
		$exe_select_info = $rdsql->exec_query($select_data,'error sub menu ');
			
		// fetch object		
				
		while($get_row = $rdsql->data_fetch_object($exe_select_info)){
			
			$temp 		   = array();
			
			$temp['menu_name'] = $get_row->sn;
			
			$temp['redirect_url'] = $get_row->redirect_url;
			
			$get_row->code = ($get_row->redirect_url)?$get_row->redirect_url:$get_row->code;
			
			if(@$param['is_blog']){				
				
				$no_row 		= $G->table_no_rows(array('table_name'=>'entity_child',
										 'WHERE_FILTER'=> " AND  get_eav_addon_ec_id(entity_child.id)=".$get_row->id.' AND is_active=1' ));
				$temp['is_no_content']  = $param['is_blog'];				
			
			}else{ // contact case
				
				//$no_row 		= $G->table_no_rows(array('table_name'=>'communication', 'WHERE_FILTER'=> ' AND is_active=1 AND comm_group_code=(SELECT code FROM entity_child WHERE id ='.$get_row->id.')','show_query'=>0));
				
				$temp['is_no_content']  = @$param['is_no_content'];
			}
			
			// sub menu
			
			if(is_file($LIB_PATH."/inc/".$page.".php")){
				
				$temp['code'] 		= $page.'='.$page_name.'&default_addon='.$get_row->id; //$get_row->code;			  
				$temp['no_data'] 	= $no_row[0];
			}else{
				
				$temp['no_data'] 	= $no_row[0];
				
				if(@$param['is_blog']){
				      $temp['code']  	     = @$param['menu_link'].'&default_addon='.$get_row->id;
				      $temp['is_no_content'] = $param['is_blog'];
				}else{
				    $temp['code']	     = strtolower(preg_replace('/\s+/', '_',$get_row->code )); //$get_row->code;				    
				}
			}
			
			array_push($temp_info,$temp);
		}
		
		return $temp_info;
	
	} // end	
		
		

	// menu create
	
	function menu_create($param){
			 
			global $rdsql;
			global $G;
			 
			$select_data =" SELECT id,
						get_eav_addon_varchar(id,'ECSN') as sn,
						get_eav_addon_vc128uniq(id,'PGCD') as code,
						get_eav_addon_varchar(id,'ECLN') as ln,
						get_ec_parent_id_eav(id) as parent_id,
						get_eav_addon_varchar(id,'PGRD') as redirect
					   FROM
						entity_child  
						$param[manipulation] AND is_active=1 ORDER BY line_order ";
			
			$exe_select_info = $rdsql->exec_query($select_data,'Test');
			 
			$result = array();
			 
			while($get_row	 = $rdsql->data_fetch_object($exe_select_info)){
				 
				$temp = array();
				$temp['menu_name']  = $get_row->sn;
				$temp['menu_title'] = $get_row->ln;
				$temp['menu_code']  = $get_row->code;
				$temp['menu_href']  = (!$get_row->redirect)?'?'.$get_row->code:$get_row->redirect;
				 
				if( (strpos($temp['menu_href'],'#') !== false) &&
				    ($param['is_home']==0)){					
					$temp['menu_href']  = '?home'.$temp['menu_href'];
				}
				 
				$parent_id =$get_row->id;
				 
				if($get_row->parent_id==0){
				  $temp['child_menu'] = menu_create(array('manipulation'=> " WHERE entity_code='PG' AND get_ec_parent_id_eav(id)=$parent_id" ));		
				}
				 
				array_push($result,$temp);
			}
			 		 
			return $result;
			 
	} // end
	
	
	
	
	// App menu create
	
	function app_menu_create($param){
			 
			global $rdsql;
			global $G;
			 
			$select_data =" SELECT
						id,
						get_ecb_parent_child_name_mode(user_page_id,'','MENU') as code_sn,
						parent_id,
						sn
					FROM
						user_role_page_matrix
					WHERE
						user_role_page_id IN (SELECT id FROM user_role_page WHERE 1=1 AND user_role_id=$param[user_role_id] ORDER BY line_order) AND parent_id=$param[parent_id]
					ORDER BY (SELECT line_order FROM user_role_page WHERE 1=1 AND user_role_id=$param[user_role_id] AND user_role_page_id=id)";
			
			$exe_select_info = $rdsql->exec_query($select_data,'Test');
			 
			$result = array();
			 
			while($get_row	 = $rdsql->data_fetch_object($exe_select_info)){
				 
				$temp = array();
				
				if($get_row->code_sn){
				
					list($temp['menu_title'],$temp['menu_href'])  = explode('[C]',$get_row->code_sn);

					$temp['menu_code'] = str_replace('=','___',$temp['menu_href']);
					 
					$temp['menu_href']="?".$temp['menu_href'];
					
					$temp['menu_title'] = (!$get_row->sn)?$temp['menu_title']:$get_row->sn;
							 
					 
					if($get_row->parent_id==0){
					  $temp['child_menu'] = app_menu_create(['user_role_id'=> $param['user_role_id'],
										 'parent_id'   => $get_row->id]);		
					}
					
				} # end
				 
				array_push($result,$temp);
			}
			 		 
			return $result;
			 
	} // end
	

?>