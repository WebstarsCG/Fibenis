<?PHP
		//ini_set('display_errors', 1);
		//
		//ini_set('display_startup_errors', 1);
		//
		//error_reporting(E_ALL);
		
		use GuzzleHttp\Client;
				
		use GuzzleHttp\Query;
		
 		include("YfSLT9CRm55cBPGH.php");
		
		$P_V['lib_path']      =  get_lib_path();
		
		$LIB_PATH             =  $P_V['lib_path'];		
			
		include($LIB_PATH.'/inc/lib/header_wo_template.php');
		
		# lwp - guzzle lib
		
		$lwp_lib = $LIB_PATH.'/comp/guzzle_rest/vendor/autoload.php';
		
		require_once $lwp_lib ;
				
		$lwp = new Client([
		     // You can set any number of default request options.
		     'timeout'  => 2.0,
		]);
				
		@$session_off = 0;

		$COACH = [];

		$COACH['domain_name']	=   (get_config('is_multiple')==1)?str_replace("www.","",$_SERVER['HTTP_HOST']):'default';
		 
		if(!isset($_SESSION['COACH_ID_'.$COACH['domain_name']])){
		    
		    list($COACH['id'],
			 $COACH['name']) =    explode('[C]',$G->get_one_cell(['table'        => 'entity_child',
							  'field'        => "concat(id,'[C]',get_eav_addon_vc128uniq(id,'CHCD'))",
							  'manipulation' => " WHERE entity_code='CH' AND get_eav_addon_varchar(id,'CHDN') ='$COACH[domain_name]' ",
		 		        ]));
		    
		    $_SESSION['COACH_ID_'.$COACH['domain_name']]       = $COACH['id'];
		    $_SESSION['COACH_NAME_'.$COACH['domain_name']]     = $COACH['name'];
		    
		}else{		    
		    $COACH['name'] = $_SESSION['COACH_NAME_'.$COACH['domain_name']];
		    $COACH['id'] = $_SESSION['COACH_ID_'.$COACH['domain_name']];
		} 
				
		$COACH['name_hash']     =   md5($COACH['name']);
	
		# SET COACH
		$G->set_coach($COACH);
		
		# actions
		
		$ROUTER_ACTION['RCPC']=function($param){
				
				
				
				$page_id_list = $param['get']['page_id_list'];				
				
				$page_result=$param['rdsql']->exec_query("SELECT code,addon,sn FROM entity_child WHERE id IN($page_id_list) AND entity_code='PG'","0");
				
				$recreated_pages = [];
				
				while($row=$param['rdsql']->data_fetch_object($page_result)){
						
						$script_name= $_SERVER["SCRIPT_NAME"];
						
						$script_name=str_replace("router.php","index.php",$script_name);
						  
						$req = $param['lwp']->GET($_SERVER["HTTP_HOST"].$script_name,
										['query'=>['t_series'=>$row->addon,
											   'key'     =>$row->code
											   ]
										]
									    );	
						
						array_push($recreated_pages,$row->sn);
						
				} // each page
				
				$result=array("status"=>1,
					      "recreated_pages"=>implode('<br>',$recreated_pages)
					      );
				
				return json_encode($result);
		}; # end
		
		
		if(@$_GET['action']){
				
		   # path
		   		   
				$temp_route =  $LIB_PATH.'/inc/'.@$_GET['series'].'.php';
				
				if(is_file($temp_route)){
					     
					     include($temp_route);
					     
				} # is file
				
				if(@$ROUTER_ACTION[@$_GET['action']]){
					     
					     echo $ROUTER_ACTION['RCPC'](array('rdsql'=>$rdsql,
									  'g'       => $G,
									  'get'     => $_GET,
									  'user_id' => $USER_ID,
									  'lwp'     => $lwp,
								));
				} # if
				
		} # action
		
	
?>