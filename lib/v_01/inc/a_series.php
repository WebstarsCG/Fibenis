<?PHP
		
		error_reporting(E_ALL);
		
		ini_set("display_errors", 1);

		$ACTION = @$_GET['action'];
		
		$TOKEN  = @$_GET['token'];
		
		$SERIES = @$_GET['series'];
				
		$router = action_router(array('page_id'   => @$_GET['series'],
					      'action' 	  => $ACTION,
					      'lib_path'  => $LIB_PATH)
				);

		# eciu
		
		if($router['action']){
				
				include($router['action']);
				
				$A_SERIES['page_code'] = md5($ACTION.'__'.$SERIES);
				
				$param = array('user_id'		=> $USER_ID,					       
						    'page_code'		=> $A_SERIES['page_code'],																
						    'action_type'	=>'ARUT',						
						    'action'		=> "Token->".$TOKEN
						 );
							
				$G->set_system_log($param);			
				
				if(@$A_SERIES[$TOKEN]){
		
						echo $A_SERIES[$TOKEN]([
										'data'	  => @$_GET['param'],
										'G'	  => $G,
										'lwp'	  => $lwp,
										'pass_id' => @$PASS_ID,
										'sv' 	  => @$_GET['sv'],
										'rdsql'   => $rdsql,
										'token'	  =>$TOKEN,
										'user_id' => @$USER_ID
						]);
				}else{
						
						http_response_code(404);
						
						include ("$LIB_PATH/template/error/404.php");
						
						exit;	
				}
		}else{
				
				
				$param = array('user_id'		=> $USER_ID,					       
						'page_code'		=> 'ERRR',																
						'action_type'		=> 'UACE',						
						'action'		=> ''
						);
				
				$G->set_system_log($param);
				
				http_response_code(404);
						
				include ("$LIB_PATH/template/error/404.php");
						
				exit;
		}
		
		
		
		
		# action router
		
		# page router
	        
		function action_router($p){
				
				
				$temp = array(
						
						'a_series'=>function($p){
								
							$temp_path = "inc/data/".$p['page_id']."/".$p['action'].".php";	
							
							if(is_file($temp_path)){								
							     return array('action'=>$temp_path);
							}else{								
							     return array('action'=>false);
							} // end
							
						}, // end
						
						
						'a'=>function($p){
								
						       $p['action']=str_replace('__','/',$p['action']);
								
						       $temp_path = $p['lib_path']."/def/".$p['action']."/".$p['page_id'].".php";
							
							if(is_file($temp_path)){
							     return array('action'=>$temp_path);						
							}else{								
							     return array('action'=>false);
							} // end
							
						}, // end
						
						'ax'=>function($p){
								
						       $p['action']=str_replace('__','/',$p['action']);
								
						       $temp_path = "def/".$p['action']."/".$p['page_id'].".php";
							
							if(is_file($temp_path)){
							     return array('action'=>$temp_path);						
							}else{								
							     return array('action'=>false);
							} // end
							
						} // end
						
				);
				
				return $temp[$p['page_id']]($p); 
				
				
				
		} // end
?>