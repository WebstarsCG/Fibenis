<?PHP
				
				function get_config($key){
						
						global $CRm55cBPGH;
						
						if(@$CRm55cBPGH[$key]){
							
							return $CRm55cBPGH[$key];
								
						} // end
						
				} // end
				
				function get_temp_config($data_in_json){
												
						return $data_in_json;
				}
				
				//Library Path:
				//input:lib_path
				//output:lib/inc/lib or lib_v2/inc/lib
				
				function get_lib_path(){
						
						$lib_domain = get_config('lib_path');
						
						return $lib_domain;
				}//end
				
				
				function get_json_data_to_array($filename){
						
						$read_file = fopen($filename, "r");
						
						$data_in_json = file_get_contents($filename);
						
						$data_in_array=json_decode($data_in_json,true);
						
						$data = json_encode($data_in_array);
						
						return $data_in_array;
				}
				
				function get_json_txt_to_array($data_in_json){
												
						$data_in_array=json_decode($data_in_json,true);
												
						return $data_in_array;
				
				}
				
				
				
				
				function set_session_config(){
						
						session_start();
						
				                return 1;
						
				}//end
				
				//db connection
				function rdsql_mysqli_connection(){
					
					$host 	     = get_config('host');
					$db_username = get_config('user');
					$db_name     = get_config('db_name');
					$db_pass     = get_config('pass');
					
					$conn=mysqli_connect($host,$db_username,$db_pass,$db_name) or die("Cannot connect====>".mysqli_error());
					$db=mysqli_select_db($conn,"$db_name") or die("Database".mysqli_error());
					
					return $conn;
				}
				
				
				
				function rdsql_mysqli_connection_close($conn){
				           mysqli_close($conn);
				}
				
				
				function custom_mail_message($def){
					
					global  $SG;
					
					$title = $SG->get_session('title');
					
					$domain_name = $SG->get_session('domain_name');
					
					$mail_send_by = $SG->get_session('mail_send_by');
					
					$primary_mail = $SG->get_session('primary_mail');
					
					$secondary_mail = $SG->get_session('secondary_mail');
					
					$mail_regards = $SG->get_session('mail_regards');
					
					$MAIL_MESSAGE = array( 'REG_MSG' => '
								Dear  '.@$def['user_name'].',<br><br><p>'.
								'Thank you for signing up with '.$title.', '.
								'your login credentials are as follows:<br><br>'.
								'Login name: <b>'.@$def['user_email'].'</b><br>'.
								'Your password:<b>'.@$def['user_key'].'</b>'.
							       '<br><br><a href="'.@$def['domain_name'].'/plugin/inc/wp_login.php'.
							       '?user_email='.@$def['user_email'].
							       '&action=KV&request=1">Please click here to activate your account</a><br/><br>'.
							       'For feedback & further assistance kindly send an email to '.$primary_mail.'<br>'.
                                                               '<br><br>'.
							       'Warm Regards,<br>'.$mail_regards.'<br><br></p>',
							       
							       'FK_MSG' => 'Dear '.@$def['user_name'].',<br><br> Your '.$title.' password has been reset<br><br>
								              Login name : <b>'.@$def['user_email'].'</b><br> New Password  : <b>'.@$def['user_key'].'</b> <br><br>
									      Thanks,<br>'.$secondary_mail,
							       
							       'ADM_MSG' => 'Dear '.@$def['user_name'].',<br><br> Your '.$title.' password has been reset by admin<br>
								              Login name : <b>'.@$def['user_email'].'</b><br> New Password  : <b>'.@$def['user_key'].'</b> <br> <br>
									      Thanks, '.$secondary_mail,
							       
							       /*'REQ_MSG' => 'Dear Admin,<BR><br>'.
									    '<a  href="'.@$def['domain_name'].'?f_series=edit_user_type&key='.@$def['user_comm'].'&layout=full&pro_key='.@$def['pro_key'].'&isup=1">Please Upgrade my plan to premium. </a>'.
									    'My Profile Id: '.@$def['pro_key'].'',*/
									     
									     
								'REQ_MSG' => 'Dear Admin,<BR><br>'.
									    'Please Upgrade my plan to premium. <br>'.
									    'My Name: '.@$def['user_name'].'<br>'.
									    'My Profile Id: '.@$def['pro_key'].'<br><br> Thank You',
									    
							        'UP_PLAN' => 'Dear '.@$def['user_name'].',<br><br>'.
									      'Your Basic plan pgradet to premium.<br>'.
									      '<a href="'.@$P_V['domain_name'].'?e_mail='.@$def['user_email'].'" >Please Visit our site </a><br>Thank You',
									      
								/*'PT_MSG' => 'Dear '.@$def['user_name'].', <br><br>'.
									    'Your Profile is upgrade to '.@$def['code'].', <a href="'.@$P_V['domain_name'].'?e_mail='.@$def['user_email'].'" >Please Visit our site </a><br>Thank You ',*/
								
								'PT_MSG' => 'Dear '.@$def['user_name'].', <br><br>'.
									    'Your Profile('.@$def['pro_key'].') has been upgraded to Premium. You can view up to 30 profile details fully. Kindly check it. <br> <br>
									    Thanks, '.$secondary_mail,
								
								'INA_MSG' => 'Dear '.@$def['user_name'].', <br><br>'.
									    'Your Profile('.@$def['pro_key'].') has been inactivated.If you have any feedback & suggestions on our service, kindly reach us by
									    '.$primary_mail,
								
									    
								'PUR_MSG' =>' Dear '.@$def['user_name'].'<br><br>'. 
									     'Your profile ('.@$def['pro_key'].') seems filled partially. We kindly request you to fill the required information fully.<br>'.
								   	     'Update your profile.  Get access to profile view <br> <br>'.
									      'Thanks.<br>'
									     .$secondary_mail,
										 
								 'OTP_MSG' => '
								 Dear User,<br><br><p>'.
								'One Time Password(OTP) for Sign In: '.@$def['user_key'].'<br><br></p>'.
							    'Regards,<br>'.$mail_regards.'<br><br></p>',


								'WEL' =>  "Dear User,<br><br><p>Welcome to $title.<br><br>Your login details are<br>".
								          "User Name: ".@$def['user_name']."<br>Password: ".@$def['user_key']."<br><br>".
										  "Regards,<br>$mail_regards<br><br>"
								   
								   
								);
					
								return $MAIL_MESSAGE;	
				}
				
				
				
		//}
				
		


?>