<?PHP
						
		ini_set('display_errors',1);		
		
		error_reporting(E_ALL);

		use GuzzleHttp\Client;
				
		use GuzzleHttp\Query;

		$ACCESS_KEY;
		
		$PV = [];
		
		# gateaction - md5(GATE__<code>)
		$PV['GATE_CODE'] = ['AAKY' => 'e89a83384d48a4ac572bc84fc468ed9d', # add key
							'AAKV' => '226d370c039d2ab26f7d6c776dc09952', # key verification
							'ACKY' => '7f84cf049cd1ca1ec04c0150d4d0c356', # Check Password/User
							'ACHP' => 'f68a5834818e3b481d2108e3fb0ea5a3', # change password
							'AFGK' => 'db3aeab2d92092e5586b7375fd885ba0', # forget password
							'AGTO' => '2d4a92e779d30cc823a3feffafa56c8c', # logout
							'ACUE' => 'e9eb891ad083d2470230f6a4b61528ae', # check user exists
							'AOTP' => '98b470c3e60a5c7f23da85efa36cb04f'  # otp
						];
		
		if(@$_POST['request'] OR @$_GET['request']){
				
				include("config.php");

				include("../../fE7zRhHqYfSLT9CRm55cBPGHjAGuhqhhjKGSZrB.php");
				
							
				$CRm55cBPGH 		=  get_temp_config($temp_config);
			
				$get_db_conn 		=  get_config('db_engine').'_connection';
				
				$db_conn_info 		=  $get_db_conn();			
				
				$PV['plugin_path'] 	=  get_config('plugin_path');
				
				$PV['domain_name'] 	=  get_config('domain_name');
				
				$PV['lib_path']    	=  get_lib_path();
				
				$PV['is_smtp_mail'] = get_config('is_smtp_mail');
				
				include("../../".$PV['lib_path']."inc/lib/".get_config('db_engine').".php");
				
				include("../../".$PV['lib_path']."inc/lib/general.php");
		
				include("../../".$PV['lib_path']."inc/lib/s_gate.php");
				
				include("../../".$PV['lib_path']."comp/PHPMailer/smtp.php");

				$lwp_lib = "../../".$PV['lib_path'].'comp/guzzle_rest/vendor/autoload.php';

				require_once $lwp_lib;
				$LWP = new Client([
					// You can set any number of default request options.
					'timeout'  => 2.0,
			   ]);
				  
							
				# coach
				$COACH=[];
				
				# domain name setup
				if(get_config('is_multiple')==1){					
					$COACH['domain_name']	=	str_replace("www.","",$_SERVER['HTTP_HOST']);

					$PV['domain_name']		= 	"http".(($_SERVER['HTTPS'])?'s':'')."://www.".$_SERVER['HTTP_HOST'];

				}else{
					$COACH['domain_name']	=	'default';
				}
				
		    
				list($COACH['id'],
				     $COACH['name']) =    explode('[C]',$G->get_one_cell(['table'        => 'entity_child',
																		  'field'        => "concat(id,'[C]',get_eav_addon_vc128uniq(id,'CHCD'))",
																		  'manipulation' => " WHERE get_eav_addon_varchar(id,'CHDN') ='$COACH[domain_name]' ",
						    ]));
													    
				$COACH['name_hash']     =   md5($COACH['name']);
								
				$PV['login_table'] 		= 'user_info';
				
				$PV['login_email'] 		=  "get_eav_addon_varchar(is_internal,'COEM')";
				
				$PV['login_name']  		=  "get_eav_addon_varchar(is_internal,'COFN')";

				$PV['login_mobile']  	=  "get_eav_addon_varchar(is_internal,'COMB')";
				
				$PV['temp_session'] = $SG->set_get_master_session($COACH['name_hash']);	

				
		
		} // end	
		
		
		//sign up data
		
		if(@$_POST['action']=='AKY'){
				
				$user_name   = $_POST['user_name'];				
				$user_email	 = strtolower($_POST['user_email']);				
				$user_mobile = strtolower($_POST['mobile']);				
				$entryType   = $_POST['entryType'];				
				$password    = md5($_POST['user_key']);
				
				$no_row = $G->table_no_rows(
				 					array(
											'table_name' =>$PV['login_table'],									
										  	'WHERE_FILTER'=>" AND $PV[login_email]='$user_email'"
										  )
				 				  );
								  
				if($no_row[0]==0){
					
					$action_code = 'AAKY';
					$new_user_id=add_new_user([ 'user_name'	=> $user_name,
								   'user_email'	=> $user_email,
								   'user_mobile'=> $user_mobile,
								   'user_role_code' => 'BAS',
								   'action_code'	=> $action_code,
								   'action_hash'	=> $PV['GATE_CODE'][$action_code],
								   'rdsql'		=> $rdsql,
								   'g'			=> $G,
								   'password'	=> $password]);		
					
					//send mail
					$def = array( 'user_name'  => $user_name,
								  'user_email' => $user_email,
								  'user_key'   => $_POST['user_key'],
						          'domain_name' => $PV['domain_name']);
								 
					$msg = custom_mail_message($def);
					
					//echo $msg['REG_MSG'];
					$MAIL=array(
								'from'    => $SG->get_session('mail_send_by').'  Admin ',					
								'to'      => $_POST['user_email'], //'ratbew@gmail.com',
								'cc'	  => get_config('cc_mail'),
								'bcc'	  => get_config('bcc_mail'),
								'subject' => $SG->get_session('mail_send_by').' | Registration Confirmation',					
								'message' => $msg['REG_MSG']);
					
					
					
					if($PV['is_smtp_mail']){						
					    mail_send_smtp($MAIL);
					}else{
						$send = $G->mail_send($MAIL);
					}
					
					$mail_param=array('user_id'=>$new_user_id,'page_code'=>$PV['GATE_CODE']['AAKY'],'action_type'=>'AAKY','action'=>'Mail->Sign Up by '.$user_email.$msg['REG_MSG']);
							 
					$G->set_system_log($mail_param);
						
					echo 1;
					
				}else{						
					echo 0;	
				}
				
		} // end of AKY/SignUp
		
		
		//key verification
		if(@$_GET['action']=='KV'){
			
			$user_email = strtolower( $_GET['user_email']);
			
			$mail_crypt =  base64_encode($user_email);
			
			$no_row = $G->table_no_rows(
				 					array(
											'table_name' =>$PV['login_table'],
									
										  	'WHERE_FILTER'=>" AND $PV[login_email]='$user_email' AND is_active=1 ",
											
											//'show_query' =>1
											
										  )
									
				 				  );
			
			//echo $no_row[0];
			if($no_row[0]>0){
				
				//base64_encode
				header('Location:'.$PV['domain_name'].'?e_mail='.$mail_crypt);
				
			}
			else{
			
				$update = "UPDATE user_info SET is_active=1 WHERE $PV[login_email] = '$user_email' ";
				
				$exe_update = $rdsql->exec_query($update,'Error! KV');
				
				$in=array('user_id'=>$no_row[1],'page_code'=>$PV['GATE_CODE']['AAKV'],'action_type'=>'AAKV','action'=>'Active login user '.$user_email);
						         
				$G->set_system_log($in);
					
				
				//base64_encode
				header('Location:'.$PV['domain_name'].'?e_mail='.$mail_crypt);
			}
			
		} // kv
		
		
		// sign in
		if(@$_POST['action']=='CKY'){
				
			if(@$_POST['user_mobile']){
				$access_lock 		= $PV['login_mobile'];
				$access_key 		= $_POST['user_mobile'];
				$access_lock_type 	= 'mobile';
			}else{
				$access_lock 		= $PV['login_email'];
				$access_key  		= strtolower($_POST['user_email']);
				$access_lock_type 	= 'email';
			}
								
			@$password   	= md5($_POST['password']);	

			$PV['gate']		= $_POST['gate'];	
			
			$auth_key  	= [	'table'   		=> $PV['login_table'],
							'key_field'		=> $access_lock,
							'login_name'	=> $PV['login_name'],
							'user_key_pub'	=> $rdsql->escape_string(stripslashes($access_key)),
							'user_key_pvt'	=> $rdsql->escape_string(stripslashes($_POST['password']))
							];
						
											
			$auth_type 	= get_config('auth_type');
			
			$auth_type  = in_array($auth_type,['base','ldap'])?$auth_type:'NONE';
			
			// auth 
			if( ($auth_type) && ($auth_type!='base')){
			
					$auth_option 	= get_config($auth_type);					
					
					if(in_array($auth_key['user_key_pub'],$auth_option['exclude_users'])){
						$auth_type 	= 'BASE';
					}							
					
			} // end
			
			$auth_key['auth_type'] =  $auth_type;
			
			// auth type
			$PV['check_auth_query']	= check_auth($auth_key);			
			
			$PV['check_auth_query_result'] = $rdsql->exec_query($PV['check_auth_query'],'Error! CK');
			
			$get_row =  $rdsql->data_fetch_object($PV['check_auth_query_result']);
			
			if(@$get_row->id){
				
				if($get_row->is_active){
					
				# echo user_role
				// page_redirect($user_role_code);
					$session = $SG->set_session(['table'   => $PV['login_table'],
												'id'		=> $get_row->id,
												'gate'	=> $PV['gate']]);
											
										
					$_SESSION['COMM_KEY'] = md5($get_row->id);
					
					$page_name =  $_SESSION['home_page_url'];
									
					$update_query="UPDATE user_info SET last_login= NOW() WHERE id =$get_row->id";
					
					$exe_up_query = $rdsql->exec_query($update_query,'Error! CK Update');

					$in=array('user_id'=>@$get_row->id,'page_code'=>$PV['GATE_CODE']['ACKY'],'action_type'=>'ACKY','action'=>'login');
								
					$G->set_system_log($in);
					
						echo '{"status":"1","redirect_page":"'.$page_name.'"}';
				
				}else{
				
					echo '{"status":"-2"}';
					
					$in=array('user_id'=>@$get_row->id,
							  'page_code'=>$PV['GATE_CODE']['ACKY'],
							  'action_type'=>'ACKY',
							  'action'=>'Login failed for In-active user '.$access_key);
								
					$G->set_system_log($in);
				
				}
			
			}else{
				
				echo '{"status":"-1"}';
					
				$in=array('user_id'=>@$get_row->id,
						  'page_code'=>$PV['GATE_CODE']['ACKY'],
						  'action_type'=>'ACKY',
						  'action'=>'Given input seems invalid. Kindly recheck & entry.');
					
				$G->set_system_log($in);
					
			} 				 
				
		} // end
		
		// auth type
		function check_auth($param){
			
			$lv = ['auth'=>[]];
			
			$lv['auth_type'] = $param['auth_type'] ?? 'BASE';			
			
			$lv['auth']['BASE'] = function($in){
				
									return 	"SELECT
												id,
												$in[key_field],
												$in[login_name],
												is_active
										FROM
												$in[table]
										WHERE
												LOWER($in[key_field])=LOWER('$in[user_key_pub]') AND password=md5('$in[user_key_pvt]')";
								
			};
			
			
			$lv['auth']['LDAP'] = function($in){
				
				
									return 	"SELECT
												id,
												$in[key_field],
												$in[login_name],
												is_active
										FROM
												$in[table]
										WHERE
												$in[login_name]='$in[user_key_pub]' AND 1=".check_ldap_auth($in);
								
			};
			
			$lv['auth']['NONE'] = function($in){
				
				
									return 	"SELECT
												id
										FROM
												$in[table]
										WHERE
												1=0";
								
			};
			
			return  $lv['auth'][strtoupper($lv['auth_type'])]($param);
			
			
		} //  end
		
		// ldap auth
		function check_ldap_auth($param){
			
			$lv = [];

			$ldap 			= 	get_config('ldap');	
			
			$lv['conn']		= 	ldap_connect($ldap['host']); 
			
			// option
			ldap_set_option($lv['conn'],LDAP_OPT_PROTOCOL_VERSION,3);
			
			//domain name
			$lv['dn'] 		=	"cn=$param[user_key_pub],$ldap[usersdn],$ldap[basedn]";
			
			// bind ldap			
			return (ldap_bind($lv['conn'],$lv['dn'],$param['user_key_pvt']))?1:0;
			
							
		} // end
		
		
		// email OTP
		if(@$_POST['action']=='AOTP'){
			
			if(@$_POST['user_mobile']){
				$access_lock 		= $PV['login_mobile'];
				$access_key 		= $_POST['user_mobile'];
				$access_lock_type 	= 'mobile';
				$access_token       = 'user_'.$access_lock_type;
			}else{
				$access_lock 		= $PV['login_email'];
				$access_key  		= strtolower($_POST['user_email']);
				$access_lock_type 	= 'email';
				$access_token       = 'user_'.$access_lock_type;
			}
					
			$no_row = $G->table_no_rows(['table_name'   => $PV['login_table'],
										 'WHERE_FILTER' => " AND $access_lock='$access_key'"]);
										
			$current_time	= date('is');
			$pass			= "0".$current_time;
			//$new_key		= substr($pass,0,6);
			$new_key		= '123456';
			$password  		=  md5($new_key);
			
			$action_type 	= 'AOTP';
			$page_code		= $PV['GATE_CODE'][$action_type];
														
			if($no_row[0]==1){
				
				$set_otp_query = "UPDATE user_info SET password='$password' WHERE $access_lock = '$access_key' ";					
				$exe_set_otp_query = $rdsql->exec_query($set_otp_query,'Error! CK Update');
				
				$login_user_id = $G->get_one_column(['table'=>'user_info','field'=>'is_internal',
														  'manipulation'=>" WHERE $access_lock = '$access_key' "]);
				
				send_gate_access_code(['access_code'	=> $new_key,
									   'access_key' 	=> $access_key,
									   'is_smtp_mail'	=> $PV['is_smtp_mail'],
									   'lock_type'		=> $access_lock_type,
									   'g'				=> $G,
									   'sg'				=> $SG,
									   'lwp'			=> $LWP										   
									]);
								
				$otp_signin_log = array('user_id'		=> $login_user_id,
										  'page_code'	=>  $page_code,
										  'action_type'	=>  $action_type,
										  'action'		=> 'Sign In by '.$access_key);
				
				$G->set_system_log($otp_signin_log);
				 
				echo '{"status":"1","message":"Sign In "}';
				
			}else if($no_row[0]==0){	

				if($SG->get_session('is_open')==1){
				
					$new_user_id = add_new_user([  "$access_token"	=> $access_key,								   
												   'user_role_code' => (get_config('signup_user_role') ?? 'BAS'),
												   'rdsql'		=> $rdsql,
												   'g'			=> $G,
												   'password'	=> $password]);							
								
					send_gate_access_code(['access_code'	=> $new_key,
									   'access_key' 	=> $access_key,
									   'is_smtp_mail'	=> $PV['is_smtp_mail'],
									   'lock_type'		=> $access_lock_type,
									   'g'				=> $G,
									   'sg'				=> $SG,
									   'lwp'			=> $LWP											   
									]);
					
					$otp_signup_log = array('user_id'		=> $new_user_id,
											  'page_code'	=> $page_code,
											  'action_type'	=>  $action_type,
											  'action'		=> 'Sign Up by '.$access_key);
					
					$G->set_system_log($otp_signup_log);
					
					echo '{"status":"1","message":"Sign Up"}';
					
				}else{						
					echo '{"status":"0","message":"Sorry, it seems the user email is invalid"}';
				}							
							   
			} // new user					
			
			exit;
			
		} // end of AOTP
		
		// email OTP
		if(@$_POST['action']=='ROTP'){
			$user_email = strtolower($_POST['user_email']);	
			//$new_key	= create_otp();
			$new_key = '123456';
			$password  	=  md5($new_key);
			$action_type 	= 'AOTP';
			$page_code		= $PV['GATE_CODE'][$action_type];
			
			$msg		 = custom_mail_message(['user_key'   => $new_key]);
			
			$set_rotp_query = "UPDATE user_info SET password='$password' WHERE $PV[login_email] = '$user_email' ";					
			$exe_set_rotp_query = $rdsql->exec_query($set_rotp_query,'Error! CK Update');					
			$login_user_id = $G->get_one_column(['table'=>'user_info','field'=>'is_internal',
											     'manipulation'=>" WHERE $PV[login_email] = '$user_email' "]);					
				
			$MAIL_ROTP=array(
						'from'    => $SG->get_session('mail_send_by').' Admin ',					
						'to'      => $user_email, //'ratbew@gmail.com',
						
						'cc'	  =>  get_config('cc_mail'),
						'bcc'	  => get_config('bcc_mail'),
						
						'subject' =>  $SG->get_session('mail_send_by').' | OTP for Sign In',
						'message' => $msg['OTP_MSG'],
					);
					
			if($PV['is_smtp_mail']){						
				mail_send_smtp($MAIL_ROTP);
			}else{
				$send = $G->mail_send($MAIL_ROTP);
			}
			
			$otp_signup_log = array('user_id'		=> $login_user_id,
									  'page_code'	=> $page_code,
									  'action_type'	=>  $action_type,
									  'action'		=> 'Sign Up by '.$user_email);
			
			$G->set_system_log($otp_signup_log);
			
			echo '{"status":"1","message":"Sign In with New OTP"}';
		
			
		} // end
		
		// change password
		
		if(@$_POST['action']=='CP'){
				
			$old_pswrd  =  md5($_POST['old_pswrd']);
			
			$user_email  = strtolower($_POST['user_email']);
			
			
			
			$no_row = $G->table_no_rows(
				 					array(
											'table_name' =>$PV['login_table'],
									
										  	'WHERE_FILTER'=>" AND $PV[login_email]='$user_email' AND password='$old_pswrd' AND is_active=1"
										 )
									
				 				  );
			
			if($no_row[0]==1){
				if($old_pswrd &&  ($_POST['new_pswrd'] ==  $_POST['cnfrm_pswrd']) ){
											
					$password  	=  md5($_POST['new_pswrd']);
					
					$update_psswrd  = "UPDATE user_info SET password='$password' WHERE $PV[login_email] = '$user_email' AND is_active=1";
					
					$rdsql->exec_query($update_psswrd,'Error! CP');
					
					$param		= array('user_id'=>$no_row[1],'page_code'=>$PV['GATE_CODE']['ACHP'],'action_type'=>'ACHP','action'=>'Active login user '.$user_email);
						         
				        $G->set_system_log($param);
						
					echo '{"status":"1","message":"Successfully changed your password"}';
				}
					
			}
			else{
				
				 echo '{"status":"0","message":"Please check your old password"}';
			}
			
		}
		
		
		// forget password
		if(@$_POST['action']=='FK'){
				
				$user_email 		= strtolower($_POST['user_email']);
				
				$current_time	= date('is');
								
				$pass		= "0".$current_time;
							
				$new_key	= substr($pass,0,6);
				
				$password  	=   md5($new_key);
				
				#echo  $PV['login_table']." AND emai='$user_email'  AND is_active=1";
				$no_row = $G->table_no_rows(
				 					array(
											'table_name' => $PV['login_table'],
									
										  	'WHERE_FILTER'=>" AND $PV[login_email]='$user_email'  AND is_active=1",
											'show_query'  =>0
										 )
									
				 				  );
				
				//echo $no_row[0];
				if($no_row[0] ==1){
						
					$update_fk_pswrd = "UPDATE user_info SET password='$password' WHERE $PV[login_email] = '$user_email' AND is_active=1";
					
					$rdsql->exec_query($update_fk_pswrd,'Error! FK');
					
					
					//select data
					
					$select_info = "SELECT $PV[login_name] as user_name FROM user_info WHERE  $PV[login_email]='$user_email' AND is_active=1 ";
					$sele_exe_query = $rdsql->exec_query($select_info,'Error! Select ');
					
					$get_row = $rdsql->data_fetch_object($sele_exe_query);
					
					
					
					$def = array( 'user_name'  => $get_row->user_name,
						     'user_email' => $user_email,
						     'user_key'   => $new_key,
						     
						   );
					$msg = custom_mail_message($def);
					
					
					
					
					$param=array('user_id'=>$no_row[1],'page_code'=>$PV['GATE_CODE']['AFGK'],'action_type'=>'AFGK','action'=>'Forgot password '.$user_email);
						         
				        $G->set_system_log($param);
					
				
                                      //   echo $msg['FK_MSG'];
					$MAIL_FK=array(
								'from'    => $SG->get_session('mail_send_by').' Admin ',					
								'to'      => $user_email, //'ratbew@gmail.com',
								
								'cc'	  =>  get_config('cc_mail'),
								'bcc'	  => get_config('bcc_mail'),
								
								'subject' =>  $SG->get_session('mail_send_by').' - Forgot password',
								'message' => $msg['FK_MSG'],
							);
					
					
					
					
					if($PV['is_smtp_mail']){		
						$send = mail_send_smtp($MAIL_FK);
						
						$mail_param=array('user_id'=>$no_row[1],'page_code'=>'GATE','action_type'=>'FMAL','action'=>'Forgot password <br>'.$msg['FK_MSG']);
						         
						$G->set_system_log($mail_param);
					}
					else{
						
						$send = $G->mail_send($MAIL_FK);
												
						$mail_param=array('user_id'=>$no_row[1],'page_code'=>'GATE','action_type'=>'FMAL','action'=>'Forgot password <br>'.$msg['FK_MSG']);
						         
						$G->set_system_log($mail_param);
					}
						
					echo 1;
						
				}
				else{
					echo 0;	
				}
				
	
		}
		
		
		if(@$_POST['action']=='GTO'){
				
			//echo $_GET['uid'];
			
			$param=array('user_id'=>$_POST['uid'],'page_code'=>$PV['GATE_CODE']['AGTO'],'action_type'=>'AGTO','action'=>'Logout ');
						         
			$G->set_system_log($param);
			get_out();
		}
		
		function get_out(){
		        
			global $PV;
			
			$USER_ID 	= 0;			
			$USER_NAME 	= '';
			
			session_start();	
			session_destroy();		
			unset($_SESSION['PHPSESSID']);	
			unset($_COOKIE['PHPSESSID']);
			
			session_start();			
			session_id($G->hashKeyGenerator(rand(),base64_encode(rand())));
			
			header('Location:'.$PV['DOMAIN_NAME'].'/index.php');
			return $USER_ID=0;
			
		} // get out
	
	
		if(@$_POST['action']=='CUE'){
			
			$user_email      =  @$_POST['user_email'];
					
			$is_ext          =  @$_POST['is_ext'];
			
			$no_row = $G->table_no_rows(
							array(
									'table_name' => $PV['login_table'],
							
									'WHERE_FILTER'=>" AND $PV[login_email]='$user_email'  AND is_active=1"
								 )
							
						  );
			
			if($no_row[0]){
			  echo 1;
			}else{
			  echo 0;		
			}
		}
		
		
		// addition of new user
		function add_new_user($param){

			$lv = [];
			
			$lv['contact_cols']	= ['COFN'=>'user_name',
								   'COEM'=>'user_email',
								   'COMB'=>'user_mobile'];
			
			# insert contact
			$lv['contact_query'] = "INSERT INTO
										entity_child(entity_code,user_id)
								       VALUES
										('CO',1)";						
					
			$param['rdsql']->exec_query($lv['contact_query'],"Contact Query");						
			$lv['ec_id'] = $param['rdsql']->last_insert_id('entity_child');
						
			# insert contact detail	
			$lv['contact_detail_values'] = [];
	
			foreach($lv['contact_cols'] as $contact_code =>$contact_key){
				if(@$param[$contact_key]){
					$lv['contact_eav'] = @$param[$contact_key];
					array_push($lv['contact_detail_values'],"($lv[ec_id],'$contact_code','$lv[contact_eav]',1)");				
				} // check key exists
			} // end
				
			$lv['contact_detail_query']="INSERT INTO
										eav_addon_varchar(parent_id,ea_code,ea_value,user_id)
									   VALUES
										".implode(',',$lv['contact_detail_values']);
										
			$param['rdsql']->exec_query($lv['contact_detail_query'],"Contact Detail Query");
			
			# insert user info
			$lv['user_info_query']= "INSERT INTO
										 user_info(password,user_role_id,is_internal,is_mail_check,is_active,user_id)
										 VALUES
										 ('$param[password]',(SELECT id FROM user_role WHERE sn='$param[user_role_code]'),$lv[ec_id],1,1,1)";
							
						
			$lv['user_info_result'] = $param['rdsql']->exec_query($lv['user_info_query'],'User Info');
						
			$lv['user_info_id']     = $param['rdsql']->last_insert_id('user_info');
			
			return $lv['user_info_id'];
			
		} // add user
	
		// create new password
		function create_otp(){						
			return $new_key		= substr(str_shuffle(rand()),0,5);			
		} //end

		// send_gate_access_code
		function send_gate_access_code($param){

			$lv = (object) ['msg'=>'','pay_load'=>''];

			// email
			if($param['lock_type']=='email'){

				$lv->msg = custom_mail_message(['user_key'   => $param['access_code']]);

				$lv->pay_load	=	array(
										'from'    => $param['sg']->get_session('mail_send_by').' Admin ',					
										'to'      => $param['access_key'], //'ratbew@gmail.com',
										
										//'cc'	  =>  $param['sg']->get_session('mail_send_by')
										'bcc'	  =>  (@$param['sg']->get_session('secondary_mail') ?? get_config('bcc_mail')),
										
										'subject' =>  $param['sg']->get_session('mail_send_by').' | OTP for Sign In',
										'message' =>  $lv->msg['OTP_MSG'],
									);			

				if($param['is_smtp_mail']){						
					mail_send_smtp($lv->pay_load);
				}else{
					$param['g']->mail_send($lv->pay_load);
				}

			}else if($param['lock_type']=='mobile'){

				$param['lwp']->request('POST', 'https://control.msg91.com/api/v5/flow/', [
					'body' => '{"template_id":"654a057ad6fc05039a1dd4a2","sender":"O2D3", 
					"short_url":"0","mobiles":91'.$param['access_key'].',"OTP":"'.$param['access_code'].'"}',
					'headers' => [
					'accept' => 'application/json',
					'authkey' => '409078AslqkurQc8bD654a077aP1',
					'content-type' => 'application/json',
					],
				]);

			} // end // end

		} // end of function
?>