<?PHP
		
	#define class
	
	$SG = new Session_Gate();
	
	class Session_Gate{
				
				protected $rdsql;	 
				protected $g;
				 				
				function __construct(){	
				
					$this->rdsql = new rdsql();	
					$this->g 	 = new General();	
				}	
				
				//set the session variable for user_info & user_permission
				function set_session($param){
							
						   global $rdsql;	
						 
						   global $PV;
						   
						   global $COACH;
						   
						   $active ='';
						   
						   //$internal=1;
						   
						   $internal=get_config('is_internal');
						   
						   $parent  =get_config('is_parent');
						   
						   
						// Login Neutral   
						//   $communication = (@$internal==1)?',communication_id,
						//			(SELECT sn FROM user_role WHERE id=user_role_id) as user_role,
						//			(SELECT sn FROM communication WHERE id=communication_id) as user_name':',(SELECT sn FROM user_role WHERE id=user_role_id)as user_role,user_name';
						//			
			                           #$communication.= (@$parent==1)?',(SELECT parent_id FROM communication WHERE id=communication_id) as parent_id ':'';
						   
						    
						   
						         $sql_user_info="SELECT 
											id,											
											get_eav_addon_varchar(is_internal,'COEM') as email,
											get_eav_addon_varchar(is_internal,'COFN') as user_name,
											is_active,
											(SELECT sn FROM user_role WHERE id=user_role_id) as user_role,
											user_role_id,											
											is_internal,
											(SELECT home_page_url FROM user_role WHERE user_role.id=user_role_id) as home_page_url,
										    (SELECT session_time FROM user_role WHERE user_role.id=user_role_id) as session_time
									 FROM 
											$param[table]											
									 WHERE 1=1 
											AND is_active =1 AND id=$param[id]";
											
									
							$exe_query = $rdsql->exec_query($sql_user_info,'user detail-->');
									
							$get_user_row = $rdsql->data_fetch_object($exe_query);
							
							// session id generate
							session_commit(); //  close the current sessions
							$session_id = $this->g->hashKeyGenerator($get_user_row->id,$get_user_row->email);

							if($get_user_row->session_time>0){
								ini_set('session.cookie_lifetime',$get_user_row->session_time);
							}

							session_id($session_id);
							session_start();
							
							//$_SESSION['communication_id']= @$get_user_row->communication_id;
							
							$_SESSION['user_role']	     = @$get_user_row->user_role;
							
							$_SESSION['user_role_id']    = @$get_user_row->user_role_id;
							
							$_SESSION['user_id']	     = @$get_user_row->id;
							
							$_SESSION['user_name'] 	     = @$get_user_row->user_name.$session_id;
							
							$_SESSION['PASS_ID']	     = $session_id;
							
							$_SESSION['user_email']	     = @$get_user_row->email;
							
							$_SESSION['home_page_url']   = @$get_user_row->home_page_url;
							
							#earlier session stored check,replaced by live check
							#$this->user_role_permission(@$get_user_row->user_role_id);
							
							$_SESSION['gate']			 = @$param['gate'];
							
							// domain
							
							$_SESSION[$COACH['name']]    = $COACH['name_hash'];
							
							if($parent){							
									$_SESSION['parent_id'] = @$get_user_row->parent_id;
							}
							
							# master cookie
							
							$this->set_get_master_session($COACH['name_hash']);
							
						         return array($_SESSION['user_id'],
								      $_SESSION['user_name'],
								      $_SESSION['user_email'],
								      $_SESSION['PASS_ID'],								      
								      $_SESSION['user_role']);
				
			} //end of set the session variable 
				
		   //get permission page for accessing
		    function get_user_detail(){
            
					#session_start();
					#echo     $_SESSION['user_email'];

					if(@$_SESSION['user_id']){
						
						return array($_SESSION['user_id'],
							     $_SESSION['user_name'],
							     $_SESSION['user_email'],							     
							     $_SESSION['PASS_ID'],							     
							     $_SESSION['user_role']);  
					}           
              
           			 return NULL;
		     } // end of get user detail
		   
		   
		   function s_destroy($redirect){
		   
		   		session_destroy();
				
				header('Location:'.$redirect.'');
				
				unset($_SESSION);
		   }//end of session destroy
		  
		   //define the user permission function
		   //get the user_id
		   //and check permission page for user
		   //display the permission page
		   function user_role_permission($user_role_id){
			
						global $rdsql;
						
						$user_permission = array();
						
						if($user_role_id){
						
									$user_role_filter  = ($user_role_id)?" AND user_role_id = $user_role_id":'';
						
									$sql =  "SELECT 
											id, user_role_id,(SELECT parent_child_hash FROM ecb_parent_child_matrix WHERE id = user_permission_id) as permission, user_permission_id
										FROM 
											user_role_permission_matrix WHERE 1=1 ".$user_role_filter;
										
										$exe_query = $rdsql->exec_query($sql,"Error in user_role permission function");		
										
										
										
									while($get_perm = $rdsql->data_fetch_object($exe_query)){
										
										$temp = array();
										
										array_push($user_permission,$get_perm->permission);
										
										$_SESSION[$get_perm->permission]=1;
									}
						}
						
						return 1;
			
			} //end
		
		   
			//define the function for user to view the permission page only
			//give the permission page
			//check the session for the permission page
			//and permission page set 1 as flag
			//return the permission page flag
			function get_permission($perm){
			     
				     if(@($_SESSION[$perm])){
					     
					     return $perm=1;
				     }else{
					     
					     return $perm=0;
			             }
			    
			      return $perm;
		        }//end of get_permission


			//getpermissiondirect
			function get_permission_direct($page_code){
						
				 $lv = [];		
						
				$lv['permission_query'] = "SELECT
									id
						            FROM
									user_role_permission_matrix
						            WHERE
									user_role_id=$_SESSION[user_role_id] AND
									user_permission_id=(SELECT
												      id
									                    FROM
												       ecb_parent_child_matrix
									                    WHERE
												        parent_child_hash='$page_code')";		
			
			          		$lv['exec_query'] = $this->rdsql->exec_query($lv['permission_query'],'permission check');
									
						$lv['permission'] = $this->rdsql->data_fetch_assoc($lv['exec_query']);
									  							
						return (@$lv['permission']['id'])?1:0;
						
			} // code

			

			       
			       function check_entry($perm){
						
				     if($perm!=1)
				     {
					return header('Location:index.php');
				     }
			       }//end of check permission entry
			
			// get master info
			function get_master_info($domain_hash){
			  
						global $rdsql;	
					   	
						$lv = [];
						
						if($domain_hash){
						
									
						
									$select_sql = "SELECT id,									      
											      entity_key,
											      entity_value
											FROM
											      entity_key_value
											WHERE
											     entity_code = 'MP' AND domain_hash='$domain_hash'";
									
									$exe_query = $rdsql->exec_query($select_sql,'master detail-->');
									
									
									while($master_row = $rdsql->data_fetch_object($exe_query)){
									  
											$lv[$master_row->entity_key]=$master_row->entity_value;
									 
									} // end
									
						}
						
						return $lv;						
			}
				  
			
			
			// set get master session
			function set_get_master_session($coach_match){
			  
						global $rdsql;	
					       
						$lv = array();
						
						$lv['coach_filter'] = (is_numeric($coach_match))?" coach_id=$coach_match ":" domain_hash='$coach_match'";
						
						if($coach_match){
									$select_sql = " SELECT id,									      
											      entity_key,
											      entity_value
											FROM
											      entity_key_value
											WHERE
											      entity_code = 'MP' AND $lv[coach_filter] ";
								    
									$exe_query = $rdsql->exec_query($select_sql,'master detail-->');
									
									while($master_row = $rdsql->data_fetch_object($exe_query)){
												
											$_SESSION[$master_row->entity_key] = $master_row->entity_value;	
											$lv[$master_row->entity_key]       = $master_row->entity_value;
											
									} // end
						} // coach match			
												
						return $lv;
						
			} // end
			
			///////// get session //////////////////////////////////////////////////////////////////////////////////////
			
			function get_session($key){
				  //todo-doubts
				  #$this->get_master_info();		
				  return @$_SESSION[$key];
			} // end
			
			
			// set master cookie
			function set_coach_cookie($coach_code){
			  
						global $rdsql;	
					       
						$lv = array();
						    
						$select_sql = "SELECT 
								      code,
								      ln
								FROM
								      entity_child
								WHERE
								     
									entity_code='HX'
									AND parent_id=get_entity_child_of_child_from_code('$coach_code','HX')
									AND get_ec_status(parent_id)=1
									ORDER BY line_order 
									";
					    
						$exe_query = $rdsql->exec_query($select_sql,'master detail-->');
						
						while($master_row = $rdsql->data_fetch_object($exe_query)){							   
							       
									array_push($lv,['binder' => $master_row->sn,
											'content'=> $master_row->ln
											]);
													 
						} // end
								
						setcookie($coach_code,json_encode($lv),time()+3600, "",$_SERVER["SERVER_NAME"]);								
											
						return $lv;
						
			} // end
			
			
			// get cookie			
			function get_cookie($key){				  
				 return (@$_COOKIE[$key])?@$_COOKIE[$key]:null;
			} // end
			
			
			
			// addition of new user
		function add_new_user($param){
			
			global $rdsql;

			$lv = [];
			
			$lv['contact_cols']	= ['COFN'=>'user_name',
								   'COEM'=>'user_email',
								   'COMB'=>'user_mobile'];
			
			# insert contact
			$lv['contact_query'] = "INSERT INTO
										entity_child(entity_code,user_id)
								       VALUES
										('CO',1)";						
					
			$rdsql->exec_query($lv['contact_query'],"Contact Query");						
			$lv['ec_id'] = $rdsql->last_insert_id('entity_child');
						
			# insert contact detail	
			$lv['contact_detail_values'] = [];
	
			foreach($lv['contact_cols'] as $contact_code =>$contact_key){
				if(@$param[$contact_key]){
					$lv['contact_eav'] = @$param[$contact_key];
					array_push($lv['contact_detail_values'],"($lv[ec_id],'$contact_code','$lv[contact_eav]',1)");				
				} // check key exists
			} // end

			// addon
			if(@$param['contact_addon']){

					// each addon $a -> $addon
					foreach($param['contact_addon'] as $a_key => $a_val){
						array_push($lv['contact_detail_values'],"($lv[ec_id],'$a_key','$a_val',1)");
					} // traverse

			} // contact addon
				
			$lv['contact_detail_query']="INSERT INTO
										eav_addon_varchar(parent_id,ea_code,ea_value,user_id)
									   VALUES
										".implode(',',$lv['contact_detail_values']);
										
			$rdsql->exec_query($lv['contact_detail_query'],"Contact Detail Query");

			// is_mail_active
			$lv['is_mail_active'] = (array_key_exists('is_mail_active',$param)?$param['is_mail_active']:1);

			
			# insert user info
			$lv['user_info_query']= "INSERT INTO
										 user_info(password,user_role_id,is_internal,is_mail_check,is_active,user_id)
										 VALUES
										 ('$param[password]',(SELECT id FROM user_role WHERE sn='$param[user_role_code]'),$lv[ec_id],
										 $lv[is_mail_active],1,1)";
							
						
			$lv['user_info_result'] =$rdsql->exec_query($lv['user_info_query'],'User Info');
						
			$lv['user_info_id']     = $rdsql->last_insert_id('user_info');
			
			$lv['user_inactive_query']= "UPDATE user_info SET is_active=0 WHERE id=$lv[user_info_id]";
			
			$lv['user_inactive_query_upd']=$rdsql->exec_query($lv['user_inactive_query'],'Error Inactive Update');
			
			return $lv['user_info_id'];
			
		} // add user

		//set new user
		function setNewUser($param){

			global $rdsql;
			$lv=[];

			// is_mail_active
			$lv['is_mail_active'] = (array_key_exists('is_mail_active',$param)?$param['is_mail_active']:1);
			# insert user info
			$lv['user_info_query']= "INSERT INTO
										 user_info(password,user_role_id,is_internal,is_mail_check,is_active,user_id)
										 VALUES
										 ('$param[password]',(SELECT id FROM user_role WHERE sn='$param[user_role_code]'),$param[co_ec_id],
										 $lv[is_mail_active],1,$param[curr_user_id])";
							
						
			$lv['user_info_result'] =$rdsql->exec_query($lv['user_info_query'],'User Info');
						
			$lv['user_info_id']     = $rdsql->last_insert_id('user_info');

			return $lv['user_info_id'];

		}//end

		
		//camelCase
		function getSessId(){
			return @$_SESSION['PASS_ID'] ?? false;
		}

		function getSess($kv){
			return @$_SESSION[$kv] ?? '';
		}

	}//class						
			
?>