<?php
		# custom lib
				
		include($LIB_PATH."/inc/lib/upload.php");		
		
		$PAGE_ID = $PAGE;

		$F_DEFAULT = ['user_id'   	=> 'user_id',
			          'created_by'	=> 'created_by',
					  'f_series'  	=> array('f_series'=>'d_series','f'=>'d','fx'=>'dx'),
					  'any_user_id' => 1, // anonymous user id
					  'last_insert_action_type' => ['1'=>'post_to_parent','2'=>'call_last_insert_action']
				  ];
              		
		$F_MESSAGE = '';		
		
		# Check for app key
		
		if(($PAGE_ID=='f_series') || ($PAGE_ID=='f') || ($PAGE_ID=='fx') ){
		
				$app_key	= $PAGE_NAME;
		
				# check file availability				
				
				$router = action_router(array('page_id'      =>$PAGE_ID,
							      'page_name' => $PAGE_NAME,
							      'lib_path'  => $LIB_PATH
							      ));
				
				if($router['action']){
					
		
						include($router['action']);
						$F_SERIES['data'] = @$F_SERIES['fields'] ?? @$F_SERIES['data'];
						
						# set code
						
						$F_SERIES['page_code'] = md5($PAGE_CODE);
						
						$session_off = @$F_SERIES['session_off'];
						
						// commented for session implementaion by R		
						if(@$_GET['session']=='off'){
								
								if(!$F_SERIES['session_off']){					
										$SG->s_destroy('index.php');
								}							
						}else{								
							if(!$USER_ID && array_key_exists('session_off',$F_SERIES)==false){					
									$SG->s_destroy('index.php');		
							}else if($USER_ID){	
								if(array_key_exists('session_off',$F_SERIES)==false){
									$SG->check_entry($SG->get_permission_direct($F_SERIES['page_code']));	
								}
							}
						}
						 
						# if custom lib
						
						if( (@$F_SERIES['cascade_action'])    ||
						    (@$F_SERIES['before_add_update']) ||
						    (@$F_SERIES['after_add_update'])
						){
						
						    if(is_file("inc/data/f_series/".$app_key."_action.php")){	 	
						
								include("inc/data/f_series/".$app_key."_action.php");
						    } // end
						}
											
						
						if(@$F_SERIES['menu_off']){					
							$MENU_OFF=1;
						}
												
						#set_system_log
						
						$param = array('user_id'=>$USER_ID,
							       
								'page_code'=>$F_SERIES['page_code'],
								
								'action_type'=>'FVEW',
								
								'action'=>'View '.$app_key.' page');
						
						$G->set_system_log($param);
				}else{
						http_response_code(404);
						
						include ("$LIB_PATH/template/error/404.php");
						
						exit;
				}
				
				
		} # App key
	
		# Action		
		
		/*******************************************************************************************************************************************/
		
			$PAGE_TITLE = $F_SERIES['title'];

			
			 
		/*******************************************************************************************************************************************/	 
	 
	
		if(isset($_POST['ADD']) || isset($_POST['SAVE'])  ){
				
				# Action before insert & update
				
				// action before add_update
				
				if(is_object(@$F_SERIES['before_add_update'])){
						
					@$F_SERIES['before_add_update']($_POST);
					
				}else if(@$F_SERIES['before_add_update']==1){						
						
						before_add_update($_POST);
						
				} // end
				
				
				# update
			
				if(@$_POST['UPDATE']){
				
						$has_fields		=  update_data(array('data_def'   	  =>$F_SERIES['data'],
											  'table_name' 	  =>$F_SERIES['table_name'],
											  'key_id'    	  =>$F_SERIES['key_id'],
											  'key_value'  	  =>$_POST['UPDATE'],
											  'is_user_id'    =>@$F_SERIES['is_user_id'],
											  'prime_index'   =>@$F_SERIES['prime_index']));
												
						@$row_id		= $_POST['UPDATE'];
						
						
						$param = array('user_id'=>$USER_ID,
							       
							       'page_code'=>$F_SERIES['page_code'],
							       
							       'action_type'=>'UPDT',
							       
							       'action'=>'update the '.$app_key.' data');
						
						$G->set_system_log($param);
					       					       
					        if(@$F_SERIES['after_update']){
						
								$F_SERIES['after_update']();
						
						} // end
				
				}else{ 			 
						
						$row_id  =	insert_data(array('data_def'   	  =>$F_SERIES['data'],
										  'table_name' 	  =>$F_SERIES['table_name'],
										  'key_id'    	  =>$F_SERIES['key_id'],
										  'is_user_id'    =>@$F_SERIES['is_user_id'],
										  'is_created_by' =>@$F_SERIES['is_created_by'],
										  'prime_index'   =>@$F_SERIES['prime_index']));
							
						$has_fields = $row_id;	
						
					
					//set_system_log
					
						$param = array('user_id'=>$USER_ID,
						       
						       'page_code'=>$F_SERIES['page_code'],
						       
						       'action_type'=>'ADDN',
						       
						       'action'=>'Insert the '.$app_key.' data');
					
						 $G->set_system_log($param);
										  
						if(@$F_SERIES['built_in_fun']['is_fun']){
							
							$F_SERIES['built_in_fun']['fun_name']();
						}				  
										  									
				}
				
				
				# for saving 				
				if(isset($_POST['ADD']) || isset($_POST['SAVE'])){
				
						//action after add_update
						
						if(is_object(@$F_SERIES['after_add_update'])){			

							@$F_SERIES['after_add_update']($row_id);							
						
						}else if(@$F_SERIES['after_add_update']==1){					
						
							after_add_update($row_id);
								
						} // end
						
						
						// message part
						if($has_fields==0){			
							//echo $F_MESSAGE = 'block_fail:<b>Give atleast one mandatory field or one default column</b>';

							$F_MESSAGE		= [ 'status' =>'pass',
												'message'=>'Give atleast one mandatory field or one default column'
												];							
						}else{
							if(@$F_SERIES['flat_message']){										
									//$F_MESSAGE = 'block_pass:'.$F_SERIES['flat_message'];
									$F_MESSAGE		= [ 'status'=>'pass',
														'message'=>$F_SERIES['flat_message']
														];
							}else{
									
									$custom_message  = @$F_SERIES['message'] ?? '';  	
												
									if(strlen(@$custom_message)>0 && $row_id){
										
										$select_message = " SELECT $custom_message as message FROM $F_SERIES[table_name] WHERE $F_SERIES[key_id]=$row_id";										
										$exe_message 	= $rdsql->exec_query($select_message,' ADD message Error!');										
										$message_row  	= $rdsql->data_fetch_object($exe_message);										
										$dip_message 	= $message_row ->message;										
										#$F_MESSAGE 		= 'block_pass:<b>'.$dip_message.'</b> Successfully Added.';
										$F_MESSAGE		= ['status'=>'pass',
														   'message'=>'<b>'.$dip_message.'</b> Successfully Added.'];
									}
									else if(isset($F_SERIES['prime_index'])){
										//$F_MESSAGE 		=  'block_pass:<b>'.@$_POST['X'.$F_SERIES['prime_index']].'</b> Successfully
										//Added';
										$F_MESSAGE		= ['status'=>'pass',
														   'message'=>'<b>'.@$_POST['X'.$F_SERIES['prime_index']].'</b> Successfully Added.'];
									}								
							} //end
						} // end
							
				
						if(@$F_SERIES['alert']['is_after_add']){
							
							$alert_mail_data = @$F_SERIES['alert']['mail']['data'];
							
							$mail_msg		  = '';
							
							if(count(array_keys($alert_mail_data))){
							
								$mail_field = '';
								
								foreach($alert_mail_data as $key=>$value){
									
									$mail_field.=$value.' as '.$key.',';
								}
								
								$mail_field = substr($mail_field,0,-1);
								
								$select_mail_data = "SELECT $mail_field FROM $F_SERIES[table_name] WHERE $F_SERIES[key_id] =$row_id";
								
								
								$exe_mail_data = $rdsql->exec_query($select_mail_data,'Select_mail_data!');
							
								$mail_row  = $rdsql->data_fetch_object($exe_mail_data);
									
								
								$mail_msg='<table width="90%" style="font-family:Tahoma;font-size:13px;border:none;">';
								
								foreach($alert_mail_data as $key=>$value){
									
									$mail_msg.='<tr >'.
									               '<td width="30%" style="color:#818181;font-size:12px;padding-top:7px;padding-bottom:7px;border-bottom:1px solid #cacaca;">'.$key.'</td>'.
									               '<td  width="5%" style="font-weight:bold;padding-top:7px;padding-bottom:7px;border-bottom:1px solid #cacaca;">&nbsp;</td>'.
												'<td  width="65%" style="color:#454545;padding-top:7px;padding-bottom:7px;border-bottom:1px solid #cacaca;">'.$mail_row->$key.'</td>'.
											 '</tr>';
								}			
							
								$mail_msg.='</table>';
							}
							
							$mail_msg=($F_SERIES['alert']['message'])?$mail_msg.$F_SERIES['alert']['message']:$mail_msg;
								
								
							$mail_param=array(
										'from'    	=> $SG->get_session('mail_send_by'),					
										'to'     	=> $F_SERIES['alert']['to'], //'ratbew@gmail.com',
										'cc'     	=> @$F_SERIES['alert']['cc'],
										'bcc'    	=> @$F_SERIES['alert']['bcc'],
										'subject'	=> $F_SERIES['alert']['subject'],						     
										'message' 	=> $mail_msg); 
								 
							mail_send_smtp($mail_param);	
						}
												
						if(@$F_SERIES['is_send_mail']){							
							mail_send_action();
						} // end
						
				} // end
				
				// get_last_insert
				if(in_array(is_int(@$F_SERIES['get_last_insert']),
							[1,2])
				){	
					$F_MESSAGE[$F_DEFAULT['last_insert_action_type'][@$F_SERIES['get_last_insert']]] = get_last_insert((object) ['post' => $_POST,
																		'id'	=> $row_id,
																		'da'	=> @$_GET['default_addon'] // default addon
																		]);				
				} // end

				// send to parent
				if(is_array(@$F_SERIES['send_to_parent'])){
					$F_MESSAGE['post_to_parent'] = 	array_merge($F_SERIES['send_to_parent'],
																['id'	=> $row_id,
																'da'	=> @$_GET['default_addon']]);
				} // post to parent

				// redirect
				if(@$F_SERIES['redirect']){
					$F_MESSAGE['redirect'] = $F_SERIES['redirect'];
				}
				
				http_response_code(200);
				header("content-type: application/ld+json"); 
				echo json_encode($F_MESSAGE);
				exit();
				
		} // end
		
		
			 
		/********************************************************************************************/
		
		###TRANSKEY-R-17072018
		if(isset($_POST['ADD']) || isset($_POST['SAVE'])){				
				
				$uniq_trans_key     = md5($row_id.$USER_ID.$PASS_ID.time().rand());
				setcookie($uniq_trans_key,$F_MESSAGE,(time()+360));				
				
				$update_trans_query  = (@$_POST['UPDATE'])?"&key=".@$_POST['UPDATE']:'';
				$temp_req_query      = $_SERVER['QUERY_STRING'];
				$temp_req_query_trim = preg_replace('/(\&trans_key\s*=\s*[0-9a-fA-F]{32})/i','',$temp_req_query);
				
				if($update_trans_query){										
					$temp_req_query_trim = preg_replace('/(\&key\s*=\s*[0-9]{1,32})/i','',$temp_req_query_trim);
				}
				
				if(!@$F_SERIES['avoid_trans_key_direct']){					
						header("Location:?$temp_req_query_trim&trans_key=$uniq_trans_key$update_trans_query");			
				}
				
		} # end		
		 		
		// cache path		
		$F_SERIES['temp']['cache_key'] = md5(join("_",array_keys(@$_GET)));
		$F_SERIES['temp']['cache_form'] = $COACH['terminal_path']."/cache/F_$PAGE_CODE"."_".$USER_ROLE.$F_SERIES['temp']['cache_key'].".html";
		
		if(is_file($F_SERIES['temp']['cache_form']) && (!@$F_SERIES['is_cc'])){	
			$F_SERIES['temp']['content_form']	=$G->getFileContent($F_SERIES['temp']['cache_form']);
			
		}else{
		
			$options 	= array("filename"=>$LIB_PATH."/template/f_series.html", "debug"=>0,"loop_context_vars"=>1);
						
			$T 	 	= new Template($options);
			
			$T->AddParam('LIB_PATH',$LIB_PATH);
			$T->AddParam('DEF_PATH',$router['def_path']);
			
			$T->AddParam('version',@$F_SERIES['version']);
			$T->AddParam('is_top_js',@$F_SERIES['js']['is_top']);		
			$T->AddParam('top_js_file',@$F_SERIES['js']['top_js']);
			
			$T->AddParam('is_bottom_js',@$F_SERIES['js']['is_bottom']);		
			$T->AddParam('bottom_js_file',@$F_SERIES['js']['bottom_js']);
			
			$T->AddParam('is_function',@$F_SERIES['is_function']);
			
			$T->AddParam('form_layout',@$F_SERIES['form_layout']);			
			
			$T->AddParam('title',@$F_SERIES['title']);
			
			$T->AddParam('add',@$F_SERIES['button_name']);
			
			// css
			if(@$F_SERIES['css']){
				
				$T->AddParam('is_css',1);
				
				if(is_string($F_SERIES['css'])){
					$F_SERIES['css']=str_replace('.css','',strtolower($F_SERIES['css']));
					$T->AddParam('css_path',$F_SERIES['css']);
				}
			}// end of css
			
			if(@$F_SERIES['label']){
			
					$T->AddParam(@$F_SERIES['label']);
			}
			
			# header & footer
			
			if(@$F_SERIES['header']){
			
					$T->AddParam(@$F_SERIES['header']);
			}
			
			if(@$F_SERIES['footer']){
			
					$T->AddParam(@$F_SERIES['footer']);
			}
			
			$T->AddParam('f_series',$PAGE_ID);
			$T->AddParam('d_series',$F_DEFAULT['f_series'][$PAGE_ID]);
			
			
			$T->AddParam('app_key',$PAGE_NAME);
			
			$T->AddParam('user_role',@$USER_ROLE);
			
			$T->AddParam('is_custom_button',@$F_SERIES['is_custom_button']);
			
			$T->AddParam('is_title',@$F_SERIES['is_title']);
			
			$T->AddParam('gx',@$F_SERIES['gx']); // generation
			
			$T->AddParam('is_field_id_as_token',@$F_SERIES['is_field_id_as_token']); // field_to_token_map

			if(@$F_SERIES['on_submit']){
				$T->AddParam(@$F_SERIES['on_submit']);
			}
			//$T->AddParam('ask_once_')
			
			# header & footer
			
			// back to
			
			if(@$F_SERIES['back_to']){
				$T->AddParam(get_back_action(@$F_SERIES['back_to']));
			} // end
			
			$T->AddParam('addon_actions',@$F_SERIES['addon_actions']);				
			$T->AddParam(build_form_data(@$F_SERIES['data']));
			
			// addon message			
			$T->AddParam('message','<TMPL_VAR MESSAGE>');
			$T->AddParam('key_template_var','<TMPL_VAR KEY>');
			
			// key based templates
			$T->AddParam('update_template_var','<TMPL_IF KEY>value="<TMPL_IF ADD>'.
			                                    '<TMPL_VAR ADD><TMPL_ELSE>Update <TMPL_VAR TITLE></TMPL_IF>"</TMPL_IF>');
			
			$T->AddParam('save_button_template_var',
						'<TMPL_IF KEY><TMPL_IF IS_SAVE_FORM>'.					
						'<input type="submit" id="SAVE" name="SAVE" class = "button" value="Save <TMPL_VAR TITLE>">'.
						'</TMPL_IF></TMPL_IF>');
							
			$T->AddParam('after_prefill_action_template_var',
						'<TMPL_IF AFTER_PREFILL_ACTION>after_prefill_action(<TMPL_IF KEY>"<TMPL_VAR KEY>"</TMPL_IF>);</TMPL_IF>');
						
			$T->AddParam('default_addon_var',
						'<TMPL_IF DEFAULT_ADDON>E_V_PASS("default_addon","<TMPL_VAR DEFAULT_ADDON>");</TMPL_IF>');
						
			$T->AddParam('f_series_query_var',			
						'<TMPL_IF F_SERIES_QUERY>?<TMPL_VAR F_SERIES_QUERY></TMPL_IF>');
							
			$T->AddParam('show_data_info_template_var',$G->getFileContent("$LIB_PATH/template/f_series_show_data.html"));
			$T->AddParam('image_info_template_var',$G->getFileContent("$LIB_PATH/template/f_series_image_info.html"));
			$T->AddParam('last_id_template_var','<TMPL_VAR LAST_ID>');
			
			// template output			
			$F_SERIES['temp']['content_form'] = $T->Output();
			$G->putFileContent(['path'		=> $F_SERIES['temp']['cache_form'],
								'content'	=> $F_SERIES['temp']['content_form']]);
		
		} // cache check
		
		# template addon_actions
		$TFA 	 	= new Template(['template_content'=>$F_SERIES['temp']['content_form'],"loop_context_vars"=>1]);
		
		# show data
		
		if(@$_GET['key'] || ( @$F_SERIES['is_clone'] && @$_GET['clone'])){
			
			$TFA->AddParam('title',@$F_SERIES['title']);
		
			$TFA->AddParam('add',@$F_SERIES['button_name']);		
			$TFA->AddParam('is_save_form',@$F_SERIES['is_save_form']);			
			$TFA->AddParam('after_prefill_action',@$F_SERIES['after_prefill_action']);

			#set_system_log:
			$param = array(	'user_id'=>$USER_ID,
					        'page_code'=>$F_SERIES['page_code'],
							'action_type'=>'PSDT'
						);
			
			if(@$_GET['key']){
				
				$TFA->AddParam('key',@$_GET['key']);
				$TFA->AddParam(show_data($F_SERIES['data'],$F_SERIES['table_name'],$F_SERIES['key_id'],$_GET['key']));
				
				// log
				$param['action'] = 'View the information by using '.$_GET['key'];

			}else if(@$_GET['clone']){ // if

				if(check_key_clone_in(['f_series'=>$F_SERIES,
									'g'		  => $G,
									'id' => $_GET['clone']
									])==1){

					$TFA->AddParam('after_prefill_action',@$F_SERIES['after_prefill_action']);
					$TFA->AddParam(show_data($F_SERIES['data'],$F_SERIES['table_name'],$F_SERIES['key_id'],$_GET['clone']));					
					$param['action'] = 'Clone the entry with'.$_GET['clone']; // log						

				}else{
					$param['action'] = 'Invalid cloning of '.$_GET['clone'];		
				} // clone 
			
			} // end of if
			
			$G->set_system_log($param);
						
		} # app key

		
		
		// transkey message
		if(@$_COOKIE[@$_GET['trans_key']]){
				$TFA->AddParam('message',@$_COOKIE[@$_GET['trans_key']]);	
				setcookie($_GET['trans_key'],'',(time()-360));	
		}elseif($F_MESSAGE){
				$TFA->AddParam('message',$F_MESSAGE);
		}
		
		// passes
		$TFA->AddParam('default_addon',$DEFAULT_ADDON);
		$TFA->AddParam('f_series_query',$_SERVER['QUERY_STRING']);
		
		// template output			
		$PAGE_INFO = $TFA->output();
		
		
		
		# build form data		
		function build_form_data($data_def){
				
				global $F_SERIES,$G;
				
				$temp_info	  = array();
				
				$mandatory_fields = array();
				
				$field_name_csv   = '';
				
				$lv               = [];
				
				$lv['allow']['pattern'] = array( 'd'=> 'is_integer',
								 'w'=> 'is_atoz',
								 'x'=> 'is_atoz_1to9_default',
								 'c'=>'is_decimal',
								 'v'=>'is_value',
								 'p'=>'is_regx'
								);
				
				// divide
				
				
				
				
				$lv['result']             = '';
				$lv['heading']            = [];
				$lv['divider']            = 0;
				$lv['last_divider_id']    = '';
				$lv['is_divider_type']    = '';
				$lv['has_sub_heading']    = 0;
				$lv['form']               = ['has_code_editor'    =>0,
											'has_fibenis_grid'    =>0,
											'has_handsontable'    =>0,
											'has_textarea_editor' =>0							     
											]; 
				
				$lv['type']['divider'] 	  = array('tab'=>1,'accordion'=>1);
				
				if(@$lv['type']['divider'][@$F_SERIES['divider']]){				
						$lv['divider']            = 1;
						$lv['is_divider_type']  = $F_SERIES['divider'];
				}
				
				$lv['counter']['divider'] = 0;
				
				// field_id_as_token -> fit
				$lv['is_fit']             = (@$F_SERIES['is_field_id_as_token'])?'Y':'N';
				$lv['action_fit']['Y']    = function($param){								
								return  (@$param['child_attr_code'])?$param['child_attr_code']:((@$param['field_id'])?$param['field_id']:strtolower(str_replace(" ","_",$param['field_name'])));  
						            };
				$lv['action_fit']['N']    = function(){ return '';};  
				
		    
				foreach($data_def as $key=>$value){
						
						$temp 			   	= array();
						
						# token alias 
						$value['field_name']		= @$value['label'] ?? @$value['field_name'];
						$value['field_id']			= @$value['id']    ?? @$value['field_id'];
						$value['is_mandatory']		= @$value['is_must'] ?? @$value['is_mandatory'];
						
						
						$temp['field_name']  	   	= $value['field_name'];
						
						$temp['field_token']       	= (@$value['field_token'])?@$value['field_token']:$lv['action_fit'][$lv['is_fit'] ]($value);
						
						$temp['field_id']   	   	= $key;
						
						$temp['is_mandatory']      	= (@$value['is_mandatory'])?1:0;
	
						$lv['attr']			= '';
	
						
						
						$temp['hint']		   	= (@$value['hint'])?@$value['hint']:'';
						
						$temp['is_hide']	   	= (@$value['is_hide'])?@$value['is_hide']:'';
						
						$temp['is_divider']     	= $lv['divider'];
						
						$temp['ro']             	= (@$value['ro'])?1:0;
	
			
							
						// heading
						
						if(@$value['type']=='heading'){
	
								$temp['field_type_heading'] = 0;
	
								$lv['counter']['divider']++;		
							       
								$temp['field_type_heading'] ='heading';
								
								if($lv['divider']){
						    
										array_push($lv['heading'],['label'    => $temp['field_name'],
																						 'id'       => $temp['field_id']
																						]
													);
										
										$temp['is_divider_'.$lv['is_divider_type']]=1;
						    
								} // if divider
						    
						// sub heading
		
							    $lv['last_divider_id']        	= $temp['field_id'];
							    $lv['counter']['sub_heading'] 	= 0;						    
							    $temp['has_sub_divider']      	= $lv['has_sub_heading'];
							    $lv['has_sub_heading']        	= 0;
							    
						}elseif((@$value['type']=='sub_heading') && ($lv['last_divider_id'])){
								
								$temp['field_type_sub_heading'] ='sub_heading';
								$lv['has_sub_heading']          = 1;
								$lv['counter']['sub_heading']++;
								
								$temp['is_first_sub_divider']		= $lv['counter']['sub_heading'];
								$temp['last_divider_id']     		= $lv['last_divider_id'];
								
								$lv['counter']['sub_heading']		=-1;
						} // end
						
	
						
						// label
	
						elseif(@$value['type']=='label'){
	
							$temp['field_type_label'] =1;
							
						}
		
						// toggle
					
						elseif(@$value['type']=='toggle'){								
								$temp['field_type_toggle'] 	    	= 	1;
								$temp['is_round']                	=	(@$value['is_round'])?1:0;
								$temp['show_status_label']       	=	(@$value['show_status_label'])?1:0;
								$temp['on_label']       	    	=	(@$value['on_label'])?$value['on_label']:'On';
								$temp['off_label']          	    	=	(@$value['off_label'])?$value['off_label']:'Off';
								$temp['is_default_on']            	=	(@$value['is_default_on'])?1:0;								
						}
						
						// code editor
						
						elseif(@$value['type']=='code_editor'){
									
									$temp['field_type_code_editor']     = 1;
									$lv['form']['has_code_editor']      = 1; 
						}
						
						// Field Date
		
						elseif(@$value['type']=='date'){
						
								$temp['field_type_date']    = (@$value['type'] =='date')?'date':0;
								$temp['min_date']           =  @$value['set']['min_date'];
								$temp['max_date']           =  @$value['set']['max_date'];
								$temp['year_range']         =  @$value['year_range'];
								$temp['default_date']       =  @$value['default_date'];
						
						}
						
						// Field Text
						elseif(@$value['type']=='text'){
							
								$temp['field_type_text']   	= (@$value['type'] =='text')?'text':0;
								
								$temp['validate']   		= (@$value['validate'])?'1':0;
								
								$temp['validate_fun']   	= @$value['validate'];
								
								if(@$value['is_line_order']){
										@$value['attr']['value'] = (($G->get_one_cell(['table'=>$F_SERIES['table_name'],
															   						  'field'=>'IFNULL(line_order,0)',
															    		 'manipulation'=>" ORDER BY line_order DESC LIMIT 1  "])));
								}
						
						}
						
						// Field Password
		
						elseif(@$value['type']=='password'){						
								$temp['field_type_password']   = (@$value['type']=='password')?'password':0;						
						}
						
						// is hidden
		
						elseif(@$value['type']=='hidden'){						
								$temp['field_type_hidden']     = (@$value['type']=='hidden')?'hidden':0;																
						}
						
						// auto complete
		
						elseif(@$value['type']=='autocomplete'){
									
								$temp['field_type_autocomplete']   = (@$value['type'] =='autocomplete')?'autocomplete':0;
								
								$temp['field_type_auto_complete_v2']  	= (@$value['type']=='auto_complete')?'auto_complete':0;	
								
								$temp['remote_link']  	  	= @$value['remote_link'];
								
								$temp['restrict_new_entry']  	= @$value['restrict_new_entry'];
								
								if( (@$value['default']['id']) && (@$value['default']['label'])){
										
									$temp['default_id'] = @$value['default']['id'];
									$temp['default_label'] = @$value['default']['label'];
								
								};
						}
						
						// Range
		
						elseif(@$value['type']=='range'){
						
								$temp['field_type_range']  	= (@$value['type']=='range')?'range':0;
								
								if($temp['field_type_range']){
								
										$temp['start_label']  	= @$value['start_label'];
										$temp['end_label']  	= @$value['end_label'];
										
										$temp['start_place_holder']  	= @$value['start_place_holder'];
										$temp['end_place_holder']  	= @$value['end_place_holder'];
								
								} // end
						
							}
						
						// HMS
		
						elseif(@$value['type']=='hms'){
						
								$temp['field_type_hms']  	= (@$value['type']=='hms')?'hms':0;
						}
										
						// Field File
		
						elseif(@$value['type']=='file'){
							
								$temp['field_type_file']   = (@$value['type'] =='file')?'file':0;
								
								$temp['allow_ext']         = (@$value['allow_ext'])?implode(',',$value['allow_ext']):'';
								
								$temp['max_size']          = (@$value['max_size'])?(@$value['max_size']):512;
								
								// doubt
								$temp['up_key']      = (@$_GET['key'])?@$_GET['key']:0;
						}
				
						// Field Textarea Editor
						
						elseif(@$value['type']=='textarea_editor'){
						
								$temp['field_type_textarea_editor']   = 1;
						
								$temp['editor_style'] 	      = (@$value['editor']['style'])?$value['editor']['style']:'';
						
								$temp['editor_width'] 	      = (@$value['editor']['width'])?$value['editor']['width']:'';
						
								$temp['editor_height'] 	      = (@$value['editor']['height'])?$value['editor']['height']:'';
								
								$lv['form']['has_textarea_editor'] = 1;
								
						}
						
						//Field Textarea
		
						elseif(@$value['type']=='textarea'){
												
									$temp['field_type_textarea']  = (@$value['type'] =='textarea')?'textarea':0;
						}elseif(@$value['type']=='checkbox'){
												
									$temp['field_type_checkbox']  = (@$value['type'] =='checkbox')?'checkbox':0;
									
									$temp['options']			  = @$value['options'];

																		

									// multistate
									if(@$value['is_multistate']){
										
											$temp['is_multistate'] = @$value['is_multistate'];
											$temp['maxstate'] 	   = @$value['maxstate'];
											foreach($temp['options'] as $cb_key=>$cb_value){
												
												$temp['options'][$cb_key]['is_multistate']='_S_0';
												if(@$value['change_action']){
													$temp['options'][$cb_key]['change_action']=@$value['change_action'];
												}
											} // end of option

									} // if multistate
									
								#print_r($temp['options']);									
									
						}elseif(@$value['type']=='radio'){
												
									$temp['field_type_radio']  = (@$value['type'] =='radio')?'radio':0;
									
									$temp['options']			  = @$value['options'];		
									
						}
						
						// Field Option
		
						elseif(@$value['type']=='option'){
						
								$temp['field_type_option']   = (@$value['type'] =='option')?'option':0;
														
								$temp['option_multiple']     = (@$value['is_list'])?1:0;
								
								$temp['option_data']   	     = @$value['option_data'];													
							
								$temp['option_fun']          = @$value['option_fun'];
								
								$temp['option_label']        = (@$value['option_default']['label'])?@$value['option_default']['label']:'Select';
										
								$temp['option_value']        = @$value['option_default']['value'];
								
								$temp['avoid_default_option'] = @$value['avoid_default_option'];
						}
						
						// Field List Dual
		
						elseif(@$value['type']=='list_left_right'){
								
								$temp['field_type_list_left_right']   = (@$value['type'] =='list_left_right')?'list_left_right':0;
															
								if(@$value['option_is_quick_search']){
								
										$temp['option_is_quick_search']	= $key;
										$temp['option_id_name']	     = @$value['option_id_name'];
										$temp['option_data']   	     = [];
								}else{
										$temp['option_is_quick_search']	= 0;
										$temp['option_id_name']	     = [];
										$temp['option_data']   	     = @$value['option_data'];
								}
								
								$temp['option_existing_data']= @$value['option_existing_data'];
								
								$temp['is_left_right_action']         = (@$value['is_left_right_action'])?@$value['is_left_right_action']:0;
								
								$temp['right_option_limit']           = (@$value['right_option_limit'])?@$value['right_option_limit']:0;
														
						}
						
						//plug_in
						
						elseif(@$value['type']=='handsontable_type'){
							
							$temp['handsontable_type'] = (@$value['type'] =='handsontable')?'handsontable':0;
							$temp['min_spare_rows']    =  (@$value['default_rows_prop']['min_spare_rows'])?(@$value['default_rows_prop']['min_spare_rows']):1;
							$temp['start_rows']        =  (@$value['default_rows_prop']['start_rows'])?(@$value['default_rows_prop']['start_rows']):3;
							$temp['max_rows']          =  (@$value['default_rows_prop']['max_rows'])?(@$value['default_rows_prop']['max_rows']):3;
							$temp['min_rows']          =  (@$value['default_rows_prop']['min_rows'])?(@$value['default_rows_prop']['min_rows']):3;							
						
						}
												
						//$temp['colHeaders']  		 =	 	json_encode(@$value['colHeaders']);
						
						//Handsontable Row properties(1st Apr 2015)
				
						elseif(@$value['is_plugin']){
							
								$temp['is_plugin']  		 = @$value['is_plugin'];
						
								$handson_data_info = array();
								
								$COUNTER = 0;
								
								foreach($value['colHeaders'] as $colkey=>$colvalue){
												
												$col_data = $COUNTER;
												
												$handson_temp = array();
												
												$handson_temp['column'] 	  =  $colvalue['column'];
												
												$handson_temp['width'] 	 	 =  $colvalue['width'];
												
												$handson_temp['is_text'] 	 =  (@$colvalue['type']== 'text')?1:0;
												
												$handson_temp['is_select']       =  (@$colvalue['type']== 'select')?1:0;
												
												//$handson_temp['is_autocomplete'] =  (@$colvalue['type']== 'autocomplete')?1:0;
												
												$handson_temp['is_numeric']  	  =  (@$colvalue['type']== 'numeric')?1:0;
												
												$handson_temp['is_renderer'] 	  =  (@$colvalue['type']== 'renderer')?1:0;  
												
												$handson_temp['is_autocomplete']   =  (@$colvalue['type']=='autocomplete')?1:0;
												
												
												
												if($handson_temp['is_autocomplete'] ){													
													
													$handson_temp['source_url'] = @$colvalue['source_url'];
													
												}
																										
												$handson_temp['renderer'] 	  =	@$colvalue['renderer'];
												
												$handson_temp['source']  	  =  @$colvalue['source'];
												
												
												
												//$handson_temp['strict']  	  =  (@$colvalue['strict'])?@$colvalue['strict']:true;
												
												array_push($handson_data_info,$handson_temp);
												
												$COUNTER++;
								}
								
								$temp['handson_data_info']  = 	$handson_data_info;
								
								$lv['form']['has_handsontable'] = 1;
						}
						
						
						elseif(@$value['is_fibenistable']){
							
								$temp['is_fibenistable']  		= 	@$value['is_fibenistable'];
								$lv['form']['has_fibenis_grid'] = 1;
								
								$temp['start_rows']        		=  	(@$value['default_rows_prop']['start_rows'])?(@$value['default_rows_prop']['start_rows']):3;
								
								$num_colum 			= 	count($value['colHeaders'])-1;
								
								$fibenisTable_row = array();
								
								$max_row = (@$value['default_rows_prop']['max_row'])?(@$value['default_rows_prop']['max_row']):0;
								
								//print_r( $value['update_route_point']);
								for($start_row_i=1; $start_row_i<=$temp['start_rows']; $start_row_i++){
									
									$temp_row = array();
									$temp_row['fibenistable_cell_info'] = get_fibenisTable_cel_info(
															array('colHeaders'=> $value['colHeaders'],
															      'key' => $key,
															      'row_counter' => $start_row_i,
															      'tot_no_rows' => $temp['start_rows'],
															      'max_no_rows' => $max_row,
															      'update_route_point' => @$value['update_route_point']
															      )
														 );
									
									$temp_row['is_index'] = @$value['is_index'];
									array_push($fibenisTable_row,$temp_row);								
								}
								
								$temp['fibenistable_head_info'] = get_fibenisTable_head_info(array('colHeaders' => $value['colHeaders'],
																     'key'	 => $key
																     ));							
								$temp['default_data']           = @$value['default_data'];							
								$temp['fibenistable_row_info']  = $fibenisTable_row;
								$temp['min_rows_to_fill']       = @$value['min_rows_to_fill'];
								
						} // end of columns
						
						
						$temp['last_divider_id']  = ($lv['last_divider_id'])?$lv['last_divider_id']:'';						
						$temp['is_first_divider'] =  $lv['counter']['divider'];
						$lv['counter']['divider'] = -1;
										
						// attr
						if(@$value['attr']){
								
								foreach(@$value['attr'] as $attr_key=> $attr_value ){
										
										$lv['attr'].= " $attr_key=\"$attr_value\""; 
								}
						}
	
	
						$temp['input_html']	   	= (@$value['input_html'])?@$value['input_html']:$lv['attr'];
						
						// allow addition
						
						if(@$value['allow']){
								
								$lv['allow_matches']=null;
								preg_match('/([dwxcv]){1}(\d+)([\=\-\,]*)(\d*)((\[)(.*)(\]))*/i',$value['allow'],$lv['allow_matches']);
								
								//if($lv['allow_matches'][1])
								
								if(in_array(@$lv['allow_matches'][1],
									    array_keys($lv['allow']['pattern'])
									)
								){
										// set match pattern		
										$temp[$lv['allow']['pattern'][ $lv['allow_matches'][1] ] ]  = 1;									
										$temp['special_in'] = (@$lv['allow_matches'][7])?@$lv['allow_matches'][7]:'';
										
										if( (@$lv['allow_matches'][2]) && (@$lv['allow_matches'][3]=='=')){										
												$temp['max_length'] = ($lv['allow_matches'][2])?$lv['allow_matches'][2]:'';
												$temp['length_match']=@$lv['allow_matches'][3];
												
										}else if( (@$lv['allow_matches'][1]=='v') && (@$lv['allow_matches'][2]) && (@$lv['allow_matches'][3]=='-') && (@$lv['allow_matches'][4]) ){
												
												$temp['min_value']   = $lv['allow_matches'][2];												
												$temp['max_value']   = $lv['allow_matches'][4];
												$temp['max_length']  = strlen($lv['allow_matches'][4]);
										
										}else if( (@$lv['allow_matches'][1]!='v') &&(@$lv['allow_matches'][2]) && (@$lv['allow_matches'][3]=='-') && (@$lv['allow_matches'][4]) ){
												
												$temp['min_length']   = $lv['allow_matches'][2];												
												$temp['max_length']   = $lv['allow_matches'][4];
										
										}else if((@$lv['allow_matches'][2]) && (@$lv['allow_matches'][3]==',') && (@$lv['allow_matches'][4]) ){
												
												$temp['left_length']   = $lv['allow_matches'][2];												
												$temp['right_length']   = $lv['allow_matches'][4];
												$temp['max_length']     = ($lv['allow_matches'][2]+$lv['allow_matches'][4]+1);
										
										}else if(@$lv['allow_matches'][2]){
												
												$temp['max_length']   = $lv['allow_matches'][2];
										}
										
										$temp['is_format'] = (!$temp['is_mandatory'])?1:0;
								}else{
										
										
										$lv['allow_matches']=null;
										preg_match('/^(p)(\[)(.*?)(\])((\[)(.*)(\]))*$/i',$value['allow'],$lv['allow_matches']);
										
										if(in_array(@$lv['allow_matches'][1],array_keys($lv['allow']['pattern']))){
										
												// set match pattern
												$temp[ $lv['allow']['pattern'][ $lv['allow_matches'][1] ] ]  = 1;
												$temp['pattern']   = $lv['allow_matches'][3];
												$temp['special_in'] = (@$lv['allow_matches'][5])?@$lv['allow_matches'][5]:'';										
										}

										$temp['is_format'] = (!$temp['is_mandatory'])?1:0;
								}
								
								#print_r($lv['allow_matches']);
						}
										
						array_push($temp_info,$temp);
						
						if(!@$value['avoid_auto_focus']){
								$field_name_csv.="'X".$temp['field_id']."',";
						}
						
						# mandatory elements
						
						if($temp['is_mandatory']){
								
							array_push($mandatory_fields,array('id' => 'X'.$temp['field_id']));
							
						} # end
				
				} # foreach
				
				$field_name_csv_trimmed	= substr($field_name_csv,0,-1);
				
				// result
				
				$lv['result'] = array('FIELD_INFO'	=>$temp_info,
						      //'FIELD_CSV'	=>$field_name_csv_trimmed,
						      'VALIDATE_INFO'    =>$mandatory_fields
					    );
				
				if($lv['divider']){
						$lv['result']['has_sub_divider']= $lv['has_sub_heading'];
						$lv['result']['divider']        = $lv['heading'];
						$lv['result']['is_divider_'.$lv['is_divider_type']]=1;						
				} // end
				
				# has traverse
				foreach($lv['form'] as $has_flag=>$has_result){
						
					$lv['result'][$has_flag] = $has_result;	
				}
						    
				return $lv['result'];
		
		} # end
		
		
		function get_fibenisTable_head_info($param){
				$colHeaders = $param['colHeaders'];
				$key	    = $param['key']; 
				$fibenistable_info = array();
				
		          foreach($colHeaders as $colkey=>$colvalue){
				$fibenistable_temp = array();
				$fibenistable_temp['column']      =  $colvalue['column'];
				$fibenistable_temp['field_id'] 	  =  $key;
				array_push($fibenistable_info,$fibenistable_temp);
			}
			
			 return $fibenistable_info; 
			  
		}//get head info 
		
		
		function get_fibenisTable_cel_info($param){
				
				$colHeaders = $param['colHeaders'];
				$key	    = $param['key']; 	
						
				$fibenistable_info = array();
				$COUNTER = 0;
				$num_colum = count($colHeaders)-1;
				
				$lv['allow']['pattern'] = array( 'd'=> 'is_integer',
								 'w'=> 'is_atoz',
								 'x'=> 'is_atoz_1to9_default' 
								);
				
				
				foreach($colHeaders as $colkey=>$colvalue){
												
						$col_data = $COUNTER;
						$fibenistable_temp = array();
						$fibenistable_temp['field_id'] = $key;
						$fibenistable_temp['column']      =  $colvalue['column'];
						$fibenistable_temp['width']     =  @$colvalue['width'];
						
						$fibenistable_temp['is_text']     =  (@$colvalue['type']== 'text')?1:0;
						
						//E_$fibenistable_temp['default_value'] = json_encode(@$colvalue['default_value']);
						
						$fibenistable_temp['is_dropdown'] =  (@$colvalue['type']== 'dropDown')?1:0;
						
						$fibenistable_temp['is_default_value'] = (@$colvalue['is_default_value'])?1:0;
						
						$fibenistable_temp['select_data']      = @$colvalue['data'];
						
						$fibenistable_temp['is_multiple_select'] =  (@$colvalue['type']== 'multiple_select')?1:0;
						
						$fibenistable_temp['is_autocomplete']  =  (@$colvalue['type']== 'autocomplete')?1:0;
						
						$fibenistable_temp['is_date']  =  (@$colvalue['type']== 'date')?1:0;

						$fibenistable_temp['is_label_value'] =  (@$colvalue['type']== 'label_value')?1:0;
						
						$fibenistable_temp['is_update_route_point']  =  @$param['update_route_point']['is_update_route_point'];
						
						
						if($fibenistable_temp['is_update_route_point'] && @$_GET['key']){
								
								$fibenistable_temp['route_url']  =  @$param['update_route_point']['url'].'&key='.$_GET['key'];
								
								//$fibenistable_temp['update_key']  = $_GET['key'];
						}
						
						
						if(@$colvalue['allow']){
							$lv['allow_matches']=null;
							preg_match('/([a-zA-Z]){1}(\d+)((\[)(.*)(\]))*/i',$colvalue['allow'],$lv['allow_matches']);
							if(in_array(@$lv['allow_matches'][1],
									    array_keys($lv['allow']['pattern'])
									    )
								){
								
										// set match pattern
										$fibenistable_temp[ $lv['allow']['pattern'][ $lv['allow_matches'][1] ] ]  = 1;										
										$fibenistable_temp['max_length'] = ($lv['allow_matches'][2])?$lv['allow_matches'][2]:'';										
										$fibenistable_temp['special_in'] = (@$lv['allow_matches'][5])?@$lv['allow_matches'][5]:'';
								}
						}

						if(($fibenistable_temp['is_text']) || $fibenistable_temp['is_dropdown']){								
							$fibenistable_temp['key_up_addon'] = (@$colvalue['key_up_addon'])?@$colvalue['key_up_addon']:'';						
						}

						if($fibenistable_temp['is_autocomplete']){								
							$fibenistable_temp['get_data_url'] = @$colvalue['get_data_url'];
						}
												
						$fibenistable_temp['max_no_rows'] = $param['max_no_rows'];
						if($num_colum == $colkey){
							$colvalue['type'];	
						    $fibenistable_temp['entry_new_row'] ='ftNextrows';
						}
						
						$fibenistable_temp['input_html'] =@$colvalue['input_html'];		
							
						
						$fibenistable_temp['restrict_new_entry'] = @$colvalue['restrict_new_entry'];
						//row counter coll counter
						$fibenistable_temp['row_counter']  = $param['row_counter'];
						$fibenistable_temp['col_counter']  = $COUNTER+1;
						$fibenistable_temp['col_data'] 	   = '';
						$fibenistable_temp['is_first_row'] = ($param['row_counter']==1)?1:0;

						if($fibenistable_temp['is_label_value'] && $fibenistable_temp['is_first_row']==1){
							$fibenistable_temp['col_data'] = @$colvalue['data']; 
						}
						
						array_push($fibenistable_info,$fibenistable_temp);
						
						$COUNTER++;
				 }
								
								
				return $fibenistable_info;				
									
						
				
		} //function 
		
		
		# insert data
		
		function insert_data($param){
				
				global $USER_ID;
				
				global $F_SERIES;
				
				global $rdsql;
				
				global $F_DEFAULT;
				
				$data_def  	            = $param['data_def'];
				
				$table_name 		    = $param['table_name'];
				
				$key_id			    = $param['key_id'];
				
				$is_user_id		    = is_numeric($param['is_user_id'])?$F_DEFAULT['user_id']:$param['is_user_id'];
				
				$is_created_by		    = is_numeric($param['is_created_by'])?$F_DEFAULT['created_by']:$param['is_created_by'];
				
				$prime_index		    = $param['prime_index'];
				
				$temp			    = [];
				
				$temp['is_required_flag_value'] = 0;
				
				# variables
								
				$key_csv		    =	'';
				
				$value_csv		    =	'';
				
				$is_required_flag	    =	0;
				
				$is_required_value	    =	'';
								
				$file_fields		    =   array();
				
				$matrix_file_fields	    =   array();
				
				$key_value		    =	'';
				
				$vertical_eav		    =   array();
				
			 	foreach($data_def as $key=>$value){
							
						# token alias	
						$value['field_name']		= @$value['label'] ?? @$value['field_name'];
						$value['field_id']			= @$value['id']    ?? @$value['field_id'];
						$value['is_mandatory']		= @$value['is_must'] ?? @$value['is_mandatory'];
						
						$temp['field_name']  	   	= $value['field_name'];
						
						@$value['ro']              = ((@$value['type']=='heading') || (@$value['type']=='sub_heading') || (@$value['type']=='label') )?1:$_POST["X".$key."_RO"];
						
						if($value['type']=='checkbox'){
							
							@$_POST["X".$key]=(@$_POST["X".$key])?implode(',',@$_POST["X".$key]):'';
						}
						
						# avoid read only
						if(@$value['ro']!=1) {						
												
								if(@$value['is_mandatory']==1){
								
										$is_required_flag  = 1;						
										$is_required_value.=($value['type']!='file')?@$_POST["X".$key]:$_FILES["X".$key]['name'];
								}						
								
								if( ($value['type']!='file')  && (@$value['is_plugin']!==1) && (!@$value['child_table'])){
								
										$key_csv.=$value['field_id'].',';
										
										if(@$value['filter_in']){											
										
												$key_value.="'".@$value['data_prefix'].$F_SERIES['data'][$key]['filter_in'](@$_POST["X".$key]).@$value['data_suffix']."',"; 											
										
										}
										
										else if($value['type']=='autocomplete'){
											
												$key_value.= "'".@$value['data_prefix'].$rdsql->escape_string(@$_POST["X".$key."_hidden"]).@$value['data_suffix']."',";	
												
										}
										
										else{
										
												$key_value.= "'".@$value['data_prefix'].$rdsql->escape_string(@$_POST["X".$key]).@$value['data_suffix']."',";
										}
								}
								
																
								if(@($value['child_table'] && $value['child_attr_code'])){
										
										@$_POST["X".$key]=($value['type']=='autocomplete')?@$_POST["X".$key."_hidden"]:@$_POST["X".$key];										
										
										array_push($vertical_eav,$key);
																	
								}else if(@$value['is_plugin']==1){
										
									       array_push($matrix_file_fields,$key);								
								}
								
								if($value['type']=='file'){
										
										array_push($file_fields,$key);								
								} #if
						} # end
						
				} # end
				
				#print_r($F_SERIES['deafult_value']);
				
				$default_key =''; 
				
				$default_value ='';
				
				if(@$F_SERIES['deafult_value']){
				
						foreach(@$F_SERIES['deafult_value'] as $key=>$value){
							
							$default_key.=  $key.',';
							
							$default_value.=  $value.',';
						}
				
				} // end
				
				// for wrong column avoidance
				
				if(@$F_SERIES['default_fields']){
				
						foreach(@$F_SERIES['default_fields'] as $key=>$value){
														
							$default_key.=$key.',';
							
							$value_neutraled = preg_replace('/(\'|\")/','',$value);
							$default_value.="'".$value_neutraled."',";
							
							$temp['is_required_flag_value']=(($key) && ($value))?1:0;
							
							if(!$temp['is_required_flag_value']){
								
								unset($F_SERIES['default_fields']);
							}
							
						} // end
						
						$is_required_flag  = $temp['is_required_flag_value'];
						$is_required_value = '1';
				} // end
				
				
				# for add user						
				if($is_user_id){
					$key_csv.='user_id,';
					$key_value.="'".($USER_ID ?? $F_DEFAULT['any_user_id'])."',";								
				} # end
				
				# created_by
				if($is_created_by){
					$key_csv.='created_by,';
					$key_value.="'".($USER_ID ?? $F_DEFAULT['any_user_id'])."',";								
				} # end
				
				# remove last character
				
				$key_csv_trimmed   = @$default_key.substr($key_csv,0,-1);
				
				$key_value_trimmed = @$default_value.substr($key_value,0,-1);
				
				# without required field
				
				//if($is_required_flag==0){
				//		$is_required_flag  = 1;
				//		$is_required_value = '1';
				//}
				
				if($is_required_flag==1){
						
						if(strlen($is_required_value)>0){
								
								
								# insert
						
								if(@$F_SERIES['is_ip_address']){
								
										$key_csv_trimmed    =  $key_csv_trimmed.','.'ip_add'; 											
										$key_value_trimmed  =  $key_value_trimmed.',"'.$F_SERIES['is_ip_address'].'"';
								}
								
								
								$insert_query   = " INSERT INTO $table_name ($key_csv_trimmed) VALUES ($key_value_trimmed)";
								
								if(@$F_SERIES['show_query']){
										echo $insert_query;
								}
								
								$exe_query      = $rdsql->exec_query($insert_query,'Error in '.$table_name.'');	
								
								$last_insert_id = $rdsql->last_insert_id($table_name);
								
								#for vertical scaling eav model
								
								foreach($vertical_eav as $key){
										
										# eav process
																				
										eav_process(array('column'=>$data_def[$key],
												 // 'column_value'=>$rdsql->escape_string(@$_POST["X".$key]),
												  'column_value'=>@$_POST["X".$key],
												  'id'	 =>$last_insert_id,
												  'rdsql'=>$rdsql,
												  'user_id'=>$USER_ID ?? $F_DEFAULT['any_user_id']
										));
										
								} // end 
								
								# for each file
								
								foreach($file_fields as $data_idx){
										
										$temp_file_column = $data_def[$data_idx];
								
										$location	= $data_def[$data_idx]['location'];
										
										$field_id	= $data_def[$data_idx]['field_id'];
										
										$path           = @$data_def[$data_idx]['path_field'];
										
										$save_ext_type	=  @$data_def[$data_idx]['save_ext_type'];
										
										$image_size 	=  @$data_def[$data_idx]['image_size']; 	
										
										$img_id  	= $last_insert_id;
										
										$img_data_id    = "X".$data_idx;
										
										$current_image_name = $_FILES[$img_data_id]['name'];
										
										$define_image_name  =  @$data_def[$data_idx]['save_file_name'];
										
										$define_image_name_prefix  =  @$data_def[$data_idx]['save_file_name_prefix'];
										
										$define_image_name_suffix  =  @$data_def[$data_idx]['save_file_name_suffix'];
										
										$img_name  	= ($define_image_name)?$define_image_name:$img_id;
										
										$img_name  	= ($define_image_name_prefix)?$define_image_name_prefix.$img_name:$img_name;
										
										$img_name  	= ($define_image_name_suffix)?$img_name.$define_image_name_suffix:$img_name;
																				
										$upload_type 	= @$data_def[$data_idx]['upload_type'];
																				
										#print_r($temp_file_column);
																														
										if($current_image_name){
										
												 $upload_image 	 = 		upload(array(   'image_name'    =>$img_data_id,
																		'location'      =>$location,
																		'img_name'      =>$img_name,
																		'image_size'    =>$image_size,
																		'key_id'        =>$img_id,
																		'old_image'     =>@$old_image_file,
																		'save_ext_type' =>$save_ext_type,
																		'upload_type'   =>$upload_type,
																		'allow_ext'     =>@$data_def[$data_idx]['allow_ext'],
																		'data_def'      =>$data_def[$data_idx]));
												
												//$save_img_name  = ($define_image_name)?$define_image_name:$upload_image;
												
												if(@$temp_file_column['child_table'] && @$temp_file_column['child_attr_code']){
														
														$image_update_query = "UPDATE
																		$temp_file_column[child_table]
																       SET
																		$field_id='$upload_image'
																       WHERE
																		$temp_file_column[parent_field_id]=$img_id AND
																		$temp_file_column[child_attr_field_id]='$temp_file_column[child_attr_code]'
																";
												
												}else{
														$image_update_query = "UPDATE $table_name SET $field_id =  '$upload_image' WHERE $key_id=$img_id";		
												}
												
												
												$rdsql->exec_query($image_update_query,'Update in->'.$table_name.'');
												
										} // img update
								} # file	
								
								
								foreach($matrix_file_fields as $plug_idx){
										
										$matrix_key_id 	= $last_insert_id;
										
										$data_id    	= $_POST["X".$plug_idx];
										
										$field_id	= $data_def[$plug_idx]['field_id'];
										
										$plugin_update_query = "UPDATE $table_name SET $field_id = '$data_id' WHERE $key_id=$matrix_key_id";
										
										$rdsql->exec_query($plugin_update_query,'Update in->'.$table_name.'');
												
								} // each				
					
								return $last_insert_id;
						
						} # end req alue
				}else{
								return 0;
						//return array('block_fail:<b>Give atleast one mandatory field or one default column.',0);	
						
				} # end req flag
				
				
						
		} # end
		
				
		
		# show data
		
		function show_data($data_def,$table_name,$key_id,$key_value){
				
		       global $rdsql,$USER_ID;
			
			global $F_SERIES;
			global $G;
			global $PASS_ID;
			
			$lv = [];
			
			$temp_info = array();	
			
		        $is_image = array();
			
			$file_type =array(); 
				
			$is_plugin = array();
			
			$is_filter_out = array();	
			
			$image_info = array();	
			
			$key_csv = '';
			
			$plugin_info =array();
			
			$fibenistable_info = array();			
			$autocomplete_info =array();
			$temp_auto = array();
			
			foreach($data_def as $key=>$value){
				
				$lv['file_attr']=[];
				
				#@$value['ro']              =((@$value['type']=='heading') || (@$value['type']=='sub_heading'))?1:@$value['ro'];
				@$value['ro']              =((@$value['type']=='heading') || (@$value['type']=='sub_heading') || (@$value['type']=='label') )?1:0;
				
				$value['field_name']		= @$value['label'] ?? @$value['field_name'];
				$value['field_id']			= @$value['id']    ?? @$value['field_id'];
			
				
				if(@$value['ro']!=1){	
				
						# Variable
						
						if(@$value['child_table']){
								
								$temp_query = "(SELECT
												$value[field_id]
										FROM
												$value[child_table]
										WHERE
												$value[parent_field_id]='$key_value' AND
												$value[child_attr_field_id]='$value[child_attr_code]'
										)";
				
								$key_csv.=$temp_query.' as '.'X'.@$key.',';
								
								if($value['type']=='date'){
							
										$key_csv.='date_format('.$temp_query.',\'%d-%m-%Y\') as '.'X'.@$key.'_SHOW,';
								}
																
								if($value['type']=='file'){
										
										$lv['file_attr']=['data_I'  => $G->encrypt($value['child_table'],$PASS_ID),
														'data_II' => $G->encrypt(@$value['field_id'],$PASS_ID),
														'data_III'=> $G->encrypt(@$_GET['key'],$PASS_ID),
														'data_IV' => $G->encrypt('X'.$key,$PASS_ID),
														'data_V'  => $G->encrypt($value['parent_field_id'],$PASS_ID),
														'data_VI' => $G->encrypt($value['child_attr_field_id'],$PASS_ID),
														'data_VII'=> $G->encrypt($value['child_attr_code'],$PASS_ID)
												   ]; 
								}
								
								
						}else{
								$key_csv.=@$value['field_id'].' as '.'X'.@$key.',';
								
								if($value['type']=='date'){
							
										$key_csv.='date_format('.@$value['field_id'].',\'%d-%m-%Y\') as '.'X'.@$key.'_SHOW,';
								}
								
								if($value['type']=='file'){
										
										$lv['file_attr']=['data_I'  => $G->encrypt($F_SERIES['table_name'],$PASS_ID),
											     'data_II' => $G->encrypt(@$value['field_id'],$PASS_ID),
											     'data_III'=> $G->encrypt(@$_GET['key'],$PASS_ID),
											     'data_IV' => $G->encrypt('X'.$key,$PASS_ID),
											     'data_V'  => $G->encrypt($F_SERIES['key_id'],$PASS_ID),
											   ]; 
								}
						}
						//
						//# Date
						//
						//if($value['type']=='date'){
						//	
						//	$key_csv.='date_format('.@$value['field_id'].',\'%d-%m-%Y\') as '.'X'.@$key.'_SHOW,';
						//}
						//
						if($value['type']=='hms'){
							
							$key_csv.='IFNULL(time_format('.$temp_query.',\'%h\'),0) as '.'X'.@$key.'_1,';
							$key_csv.='IFNULL(time_format('.$temp_query.',\'%i\'),0) as '.'X'.@$key.'_2,';
							$key_csv.='IFNULL(time_format('.$temp_query.',\'%p\'),0) as '.'X'.@$key.'_3,';
						}
						
						#auto complete
						
						if($value['type']=='autocomplete'){
							
							
							$temp_auto['X'.$key] = 'autocomplete';
							
							$temp_auto['X'.$key.'remote_link'] = $value['remote_link'];
							
							//$temp_auto_info['remote_link'] = $value['remote_link'];
							
							//array_push($autocomplete_info,$temp_auto_info);  
								
						}
						
						# File
						
						if($value['type']=='file'){							
							$is_image['X'.$key] 	=  @$value['location'];
							
							$file_type['X'.$key]    =  @$value['upload_type'];
							
							/*
							in data
								data_I  = table
								data_II = field
								data_III = Key								
								data_IV = content_area
								data_v = key_id
								data_VI = eav case child field
								data_VII = eav case child attr code
							*/
							$del_data_info['X'.$key] =json_encode( array(
										
										'label' => 'Page',
										'action'=>'general',
										'series'=>'a',
										'token' =>'DELI',
										
										'data' => $lv['file_attr']
									      ));
							
							
						
						}
						//echo $del_data_info;
						
						# Plugin
						
						if(@$value['is_plugin']==1){						       
								 $is_plugin['X'.$key] =  $key ;  //$value['is_plugin'];								       
						}
						
						if(@$value['is_fibenistable']==1){	
								$is_plugin['X'.$key] =  $key ;
								$fibenistable_info['X'.$key] = 1;
						}		
						
						# Filter out						
						if(@$value['filter_out']){
							$is_filter_out['X'.$key] = $value['filter_out'];					
						}
						
						
						  
					} // take read only
				
		        } # end
		       
				$key_csv_trimmed   = substr($key_csv,0,-1);
				
				
				if(@$F_SERIES['key_filter']){
				  $WHERE_FILTER = $F_SERIES['key_filter'];		
				}
				else{
				  $WHERE_FILTER = ' AND  '.$key_id.'='.$key_value;		
				}

				$select_query	= "SELECT $key_csv_trimmed, $key_id as key_id FROM $table_name WHERE 1=1 $WHERE_FILTER";
				//echo $select_query;
				  
				
				if(@$F_SERIES['show_query']){
				 
				  echo $select_query;
				} 
				
				$select_data	 	= $rdsql->exec_query($select_query,"-->>>>");
				
				$select_result		= $rdsql->data_fetch_assoc($select_data);
				
				foreach($select_result as $key=>$value){
					
					
						$key               = strtoupper($key);

						$value   	   = (@$value ?? '');

						$temp_type         = '';
						
						$temp_remote_link  = '';
					 
						$temp_value = $rdsql->escape_string($value);
						#$temp_value = $value;
						
						if(@$is_filter_out[$key]){
								
								$temp_value=$is_filter_out[$key]($temp_value);
								
						} # filter out
					
					       if(@$temp_auto[$key]){
						
						   $temp_type='autocomplete';
						   
						   $temp_remote_link = $temp_auto[$key.'remote_link'];
						   
						  
						  // echo $restrict_new_entry =  $temp_auto['restrict_new_entry'];
						   
						   /*array_push($autocomplete_info, array(
											'remote_link' => $temp_auto[$key.'remote_link'],
											'value' => $temp_value
											)
							      );*/
						
					       }
						
						
						if(@$is_image[$key]){						
							 
								$key_value = $rdsql->escape_string($value);							
							
								if($file_type[$key] == 'docs'){
									
										if(is_file($value)){	
										    
										    $data_src = '<a class ="icon doc" target="_blank" href="'.$value.'">View Doc</a>';
										    
										}
								
								}elseif($file_type[$key] == 'image'){
									
										// image path split
										$temp_images = explode(",",(@$value ?? ''));
								
										if(is_file($temp_images[0])){								
																		    
												$data_src  = '<img src="'.$temp_images[0].'" width="100px" >';
										}
								
								}else{
										if(is_file($value)){	
										    $data_src = '<a class ="icon doc" target="_blank" href="'.$value.'">View</a>';
										}	
								}
							
							
								array_push($image_info,array('id'	  => $key,
										     'key_id'     => $key_value,
										     'location'   => $is_image[$key],
										     'value'	  => $temp_value,
										     'image_loc'  => @$value,
										     'data_src'   => @$data_src,
										     'del_data_info' => $del_data_info[$key])
								);	
							
							
						}elseif(@$key=='KEY_ID'){
						    
								$last_id = $value;
						     
						}else{
								array_push($temp_info,array(
										'id'		    => $key,
										'value'             => $temp_value,
										'auto_type'	    => $temp_type,
										'auto_remote_link'  => $temp_remote_link,										
										'fibenistable_info' => @$fibenistable_info[$key],
										'plugin_key'	    => @$is_plugin[$key]));
							
						}
					 
				} # for 
				
				return array('SHOW_DATA_INFO'=> $temp_info,
					     'IMAGE_INFO'    => $image_info,
					     'last_id'	     => $last_id
			      
						 	 //'plugin_info'	 => $plugin_info
					   );
				
		} # show data


		# Update
		
		function update_data($param){
				
				global $USER_ID;
				
				global $F_SERIES;
				
				global $G;
				
				global $rdsql;
				
				global $F_DEFAULT;
				
				# param
				
				$data_def  	= $param['data_def'];
				
				$default_key	= '';
				
				$default_key_value='';
				
				$table_name 	= $param['table_name'];
				
				$key_id			= $param['key_id'];
				
				$key_value		= $param['key_value'];
				
				$is_user_id		= is_numeric($param['is_user_id'])?$F_DEFAULT['user_id']:$param['is_user_id'];
				
				$prime_index	= $param['prime_index'];
				
				$hidden_field	= @$param['hidden_field'];
				
				$temp           = [];
				$temp['is_required_flag_value'] =0;
								
				# variables
				
				$key_query		    =	'';
				
				$is_required_flag	    =	0;
				
				$is_required_value	    =	'';
								
				$file_fields		    =   array();
				
				$matrix_file_fields		 =   array();
				
				$vertical_eav		    =   array();
				# key varied
				
			 	foreach($data_def as $key=>$value){
							
						$value['field_name']		= @$value['label'] ?? @$value['field_name'];
						$value['field_id']			= @$value['id']    ?? @$value['field_id'];
						$value['is_mandatory']		= @$value['is_must'] ?? @$value['is_mandatory'];
						
						$temp['field_name']  	   	= $value['field_name'];
						
						$temp['hidden_field']	   = @$value['hidden_field'];
						
						@$value['ro']              = ((@$value['type']=='heading') || (@$value['type']=='sub_heading') || (@$value['type']=='label'))?1:$_POST["X".$key."_RO"];
						
						if($value['type']=='checkbox'){							
							@$_POST["X".$key]=is_array(@$_POST["X".$key])?implode(',',@$_POST["X".$key]):'';
						}
						
						# avoid read only
						
						if(@$value['ro']!=1){
								
								
								if(@$value['no_edit']==1){								
										$key_query.=$value['hidden_field'].'='."'".$_POST["X".$key]."',";
								}
								
								if(@$value['is_mandatory']==1){								
										$is_required_flag=1;								
										$is_required_value.=($value['type']!='file')?@$_POST["X".$key]:$_FILES["X".$key]['name'];
								}
								
								if(@($value['child_table'] && $value['child_attr_code'])){										
										@$_POST["X".$key]=($value['type']=='autocomplete')?@$_POST["X".$key."_hidden"]:@$_POST["X".$key];
										array_push($vertical_eav,$key);																	
								}
								
								if((@$value['type']!='file') && (!@$value['child_table'])){
									
										if(@$value['filter_in']){
										
												$key_query.=$value['field_id'].'='."'".$F_SERIES['data'][$key]['filter_in'](@$_POST["X".$key])."',";
										
										}else if($value['type']=='autocomplete'){
												
												$key_query.=$value['field_id'].'='."'".$_POST["X".$key.'_hidden']."',";
													
										}else{
												$key_query.=$value['field_id'].'='."'".@$value['data_prefix'].$rdsql->escape_string(@$_POST["X".$key]).@$value['data_suffix']."',";
										}
								}
								
								if(@$value['is_plugin']==1){
										array_push($matrix_file_fields,$key);
								}
								
								
								if(@$value['type']=='file'){
										
										array_push($file_fields,$key);								
								} #if
						} # read only
				} # end
				
				# user id
				
				if($is_user_id){
						
						$key_query.=$is_user_id.'='."'".$USER_ID."',";								
				}
				
				
				if(@$F_SERIES['deafult_value']){
				
						foreach(@$F_SERIES['deafult_value'] as $key=>$value){
							
							$default_key.=  $key;
							
							$default_key_value.= $key.'='.$value.',';
						}
				
				} // end
				
				if(@$F_SERIES['default_fields']){
				
						foreach(@$F_SERIES['default_fields'] as $key=>$value){
														
							$default_key.=$key;							
							$value_neutraled = preg_replace('/(\'|\")/','',$value);
							
							@$default_value.="'".$value_neutraled."'";
							$default_key_value.= $default_key.'='.$default_value.',';
							
							$temp['is_required_flag_value']=(($key) && ($value))?1:0;
							
							if(!$temp['is_required_flag_value']){
								
								unset($F_SERIES['default_fields']);
							}
							
						} // end
						
						$is_required_flag  = $temp['is_required_flag_value'];
						$is_required_value = '1';
				} // end
				

				# remove last character
				
				
				$key_query_trimmed   = substr($default_key_value.$key_query,0,-1);
				
				if($is_required_flag==1){
						
						if(strlen($is_required_value)>0){
								
								# update
								
								if(@$F_SERIES['key_filter']){
										$WHERE_FILTER = $F_SERIES['key_filter'];		
							        }else{
										$WHERE_FILTER = ' AND '.$key_id.'='.$key_value;
								}
								
							 	$update_query   = " UPDATE $table_name SET  $key_query_trimmed WHERE 1=1 $WHERE_FILTER ";
									
								if(@$F_SERIES['show_update_query']){
									echo $update_query;		
								}
								
								$exe_query      = $rdsql->exec_query($update_query,"Update Error");
																
								#for vertical scaling eav model
								
								foreach($vertical_eav as $key){
										
										# eav process
																				
										eav_process(array('column'=>$data_def[$key],
												  //'column_value'=>$rdsql->escape_string(@$_POST["X".$key]),
												  'column_value'=>@$_POST["X".$key],
												  'id'	 =>$key_value,
												  'rdsql'=>$rdsql,
												  'reset'=>1,
												  'user_id'=>$USER_ID
										));
										
								} // end 
								
								# for each file
								
								foreach($file_fields as $data_idx){
										
										$temp_file_column =@$data_def[$data_idx];
										
										$location	  = @$data_def[$data_idx]['location'];
										
										$save_ext_type    = @$data_def[$data_idx]['save_ext_type'];
										
										$field_id	  = $data_def[$data_idx]['field_id'];
										
										$image_size       =@$data_def[$data_idx]['image_size'];
										
										$img_id  	  = $key_value;
										
										$img_data_id      = "X".$data_idx;
										
										$current_image_name = $_FILES[$img_data_id]['name'];
										
										$existing_doc_name = $_POST['hidden_'.$img_data_id];
										
										#echo $param
										
										$define_image_name  =  @$data_def[$data_idx]['save_file_name'];
										
										$define_image_name_prefix  =  @$data_def[$data_idx]['save_file_name_prefix'];
										
										$define_image_name_suffix  =  @$data_def[$data_idx]['save_file_name_suffix'];
										
										$img_name  	= ($define_image_name)?$define_image_name:$img_id;
										
										$img_name  	= ($define_image_name_prefix)?$define_image_name_prefix.$img_name:$img_name;
										
										$img_name  	= ($define_image_name_suffix)?$img_name.$define_image_name_suffix:$img_name;	
										
										$upload_type = @$data_def[$data_idx]['upload_type'];
										
										#print_r($_POST);
										
										if($current_image_name){
												
												
												$old_image_name = $_POST["hidden_X".$data_idx];
												$old_image_file  =  $location.$old_image_name;
												if(is_file(@$image_file )){
												    #upload($img_data_id,$location,$img_id);
												   // unlink($image_file);		
												}
																						
												
												$upload_image = upload(array('image_name'=>$img_data_id,
															     'location'=>$location,'img_name'=>$img_name,'image_size'=>$image_size,
															     'key_id'=>$img_id,'old_image' =>$old_image_file,'save_ext_type'=>$save_ext_type,
															     'upload_type'=>$upload_type, 'allow_ext' => $data_def[$data_idx]['allow_ext'],'data_def'=>$data_def[$data_idx]
															     ));
												
												
												#$save_img_name  = ($define_image_name)?$define_image_name:$upload_image;
												if(@$temp_file_column['child_table'] && @$temp_file_column['child_attr_code']){
														
														$image_update_query = "UPDATE
																		$temp_file_column[child_table]
																       SET
																		$field_id='$upload_image'
																       WHERE
																		$temp_file_column[parent_field_id]=$img_id AND
																		$temp_file_column[child_attr_field_id]='$temp_file_column[child_attr_code]'
																";
												
												}else{
														$image_update_query = "UPDATE $table_name SET $field_id =  '$upload_image' WHERE $key_id=$img_id";
												}
												
												$rdsql->exec_query($image_update_query,'Update in->'.$table_name.'');
										
										}elseif($existing_doc_name){
												
												if(@$temp_file_column['child_table'] && @$temp_file_column['child_attr_code']){
														
														$image_update_query = "UPDATE
																				$temp_file_column[child_table]
																		       SET
																				$field_id='$existing_doc_name'
																		       WHERE
																				$temp_file_column[parent_field_id]=$img_id AND
																				$temp_file_column[child_attr_field_id]='$temp_file_column[child_attr_code]'
																		";
																		
														$rdsql->exec_query($image_update_query,'Update in->'.$table_name.'');
														
												} // end				
										
										} // img update
										
								} # file								
								
						} // end value
						
						return 1;
						
				}else{
						
						return 0;
						
				} # end req flag
				
				
		} # update end
		
		
		# eav process
		
		function eav_process($param){
				
			 	global $F_SERIES,$FILTER;
				
				$column			= $param['column'];
														//
				$child_table		= $column['child_table'];
				
				$child_attr_code	= "'".$column['child_attr_code']."'";
				
				$child_atttr_field_id	= $column['child_attr_field_id'];
				
				$parent_field_id	= $column['parent_field_id'];
				
				$field_id		= $column['field_id'];
				
				if(@$column['filter_in']){					
						
						$param['column_value']=$column['filter_in']($param['column_value']);						 
				}
				
				$field_value		= ($column['type']!='file')?"'".@$column['data_prefix'].$param['rdsql']->escape_string($param['column_value']).@$column['data_suffix']."'":"''";
				
				$filter_allow_flag      = (@$column['avoid_empty_zero'])?$FILTER['avoid_empty_zero']($param['column_value']):1;      
								
				# empty first
				
				if(@$param['reset']){						
						$eav_empty_query  = "DELETE FROM $child_table WHERE $parent_field_id='$param[id]' AND  $child_atttr_field_id=$child_attr_code ";						
						$param['rdsql']->exec_query($eav_empty_query,'Error in '.$child_table.'');						
				} // end
				
				
				
				$v_eav_insert_query	= "INSERT INTO $child_table ($child_atttr_field_id,$parent_field_id,$field_id,user_id) VALUES
				                                                    ($child_attr_code,$param[id],$field_value,$param[user_id])";				
				
				if(@$F_SERIES['show_query']){						
						echo $v_eav_insert_query;
				}
				
				if($filter_allow_flag){
						
						$exe_query      	= $param['rdsql']->exec_query($v_eav_insert_query,'Error in '.$child_table.'');
				}
				
		} // eav process
		
		
		# router
		
		 # page router
	        
		function action_router($p){
				
				
				$temp = array(
						
						'f_series'=>function($p){
								
							$def_path    = "inc/data/".$p['page_id']."/";	
							$action_path = $def_path.$p['page_name'].".php";	
							
							if(is_file($action_path)){								
							     return array('action'=>$action_path,'def_path'=>$def_path);
							}else{								
							     return array('action'=>false);
							} // end
							
						}, // end
						
						
						'f'=>function($p){
								
							$p['page_name']=str_replace('__','/',$p['page_name']);
								
						        $def_path 	   = $p['lib_path']."/def/".$p['page_name']."/";
								$action_path   = $def_path.$p['page_id'].".php";
							
							if(is_file($action_path)){
							     return array('action'=>$action_path,'def_path'=>$def_path);						
							}else{								
							     return array('action'=>false);
							} // end
							
						}, // end
						
						'fx'=>function($p){
								
						        $p['page_name']=str_replace('__','/',$p['page_name']);
								
								$def_path    = "def/".$p['page_name']."/";
								$action_path = $def_path.$p['page_id'].".php";
							
							if(is_file($action_path)){
							     return array('action'=>$action_path,'def_path'=>$def_path);						
							}else{								
							     return array('action'=>false);
							} // end
							
						} // end
						
				);
				
				return $temp[$p['page_id']]($p); 
				
				
				
		} // end
		
	// f_series back normalization
	function get_back_action($back){
		
		$lv=['back_keys'=>['is_active'	   => 'is_back_button',
						   'url'	  	   => 'back_link',
						   'label'	  	   => 'back_name',
						   'menu_off' 	   => 'back_menu_off',
						   'default_addon' => 'back_default_addon']
			];
		
		if(gettype($back)=='integer'){			
			return ['is_back_button' => 1];			
		}elseif(gettype($back)=='array'){
			
			foreach($lv['back_keys'] as $new_key => $old_key){
			
				if(array_key_exists($new_key,$back)){
					$back[$old_key]=$back[$new_key];
					unset($back[$new_key]);
				}
			}
			
			return $back;
		}
		
	} // end

	// function gey_key_cloneid_check
	function check_key_clone_in($param){

		$lv = (object)['match_count'=>0,'where'=>[],'key_clone_id' ];

		// context var
		$f_series 		  = $param['f_series'];
		$lv->key_clone_id = $param['id'];

		// default_fields to prepare
		if(@$f_series['default_fields']){			
			foreach($f_series['default_fields'] as $df_key => $df_val){
				array_push($lv->where," AND $df_key=$df_val");
			}
		} // end
				
		$lv->match_count = $param['g']->get_one_column(['table'=>$f_series['table_name'],
														'field' => 'count(*)',
														'manipulation'=> " WHERE 1=1  AND $f_series[key_id]=$lv->key_clone_id".
																		   implode('',$lv->where)
										]);

		return $lv->match_count;

	} // end

	// get_last_insert
	function get_last_insert($param){
			return array_merge($param->post,['id'=>$param->id,
									 		 'default_addon'=>$param->da]);
	} // end

////////////////////////////////////////////////////////////////////////
// 07-Aug-2015 addition to cascade before_add_update and after_add_update added for inclding action file
// 25-08-2015 left_right_action added
// 25-08-2015 type hidden added
// 09-09-2015 type range added
// 15-09-2015 Quick Search added for left right
// 	      option_id_name addded
//            option_is_quick_search_added
// 21-09-2015 Right Option limit
// 13-11-2015 HMS type added
////////////////////////////////////////////////////////////////////////
?>
