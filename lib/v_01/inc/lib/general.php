<?php
 
 
		   /*********************************************************************************************************************
		   *		Page Name:  
		   *			  general.php
		   *		
		   *		Class Name : General
		   *********************************************************************************************************************/
	
		   $G = new General();
		  
		   
			class General{
				
			//  file location
				
			var $file_location;
			  
			protected $rdsql;	 
			protected $coach=array();
			protected $user_id;
			protected $month_short;
				
		// 1. create construct for db
		
				function __construct(){		
						
					       #$this->dbh = $dbh;
					       
						$this->month_short = array('jan' =>1,
								     'feb' =>2,
								     'mar' =>3,
								     'apr' =>4,
								     'may' =>5,
								     'jun' =>6,
								     'jul' =>7,
								     'aug' =>8,
								     'sep' =>9,
								     'oct' =>10,
								     'nov' =>11,
								     'dec' =>12);
									 
						$this->rdsql = new rdsql();	
					
				} // end
				
				function set_coach($coach){				
						$this->coach = $coach;
				}

				function setUserId($user_id){				
					$this->user_id = $user_id;
				}

				function getUserId(){				
					return @$_SESSION['user_id'];
				}
	
	/***************************************************************************************************************/			
			
	
	
	/***************************************************************************************************************/				
	// 2. pager single ac		
	function pager_single_act($nrow,$per_page,$start){
		
		$lv = [];

		//$lv['pager_records']    = $nrow;
		$lv['pager_total']	   	= ceil($nrow/$per_page);  //calculate the number of pages		
		$lv['pager_prev'] 		= $start-$per_page;	//calcuclate previous page, if available or not
		$lv['pager_prev'] 		= ($lv['pager_prev']<0)?0:$lv['pager_prev'];
		$lv['pager_next']	  	= ($start+$per_page);	//calculate next page, if available or not							
		$lv['pager_last']	  	= ($lv['pager_total']-1)*$per_page;
		$lv['pager_current']    = ($nrow>0)?ceil($start/$per_page)+1:0;
		$lv['pager_has_next']	= ($lv['pager_total']>=$lv['pager_current'])?1:0;

		return $lv;
				
	} // pager single act
	/***************************************************************************************************************/
		
	
	
		
		// 3. pager select act
		/*************************** 3. pager select act ************************************************************************************/
				function pager_select_act($nrow,$per_page,$start){
						
						   $npage	    =	ceil($nrow/$per_page);  		//calculate the number of pages
					  
						   $tmp			=	($start+$per_page);					//calculate next page, if available or not	
						  
						   $nxt			=	ceil($start/$per_page)+1;
						   
						   $prv			=	$start-$per_page;					//calcuclate previous page, if available or not
						
						   $first		=	1;	
						   
						   $last		=	($npage-1)*$per_page;
						
						
						// for first page
							if($first){
						
								$pagelink.= "<a href='JavaScript:pager_act(".($first-1)."0);'& page= $per_page >&nbsp;First&nbsp;</a>&nbsp;&nbsp;";	// first page is enable
						
							}
							
							
						// for previous pages	
							
							if($prv>=0){
							
									$pagelink.= "<a href='JavaScript:pager_act(".$prv.");'&page=$per_page>&nbsp;&laquo;&nbsp;</a>&nbsp;&nbsp;";	//previous button is ennable
							}
							
							else{
								$pagelink.= "<a href=''>&nbsp;&laquo;&nbsp;</a>&nbsp;&nbsp;";	//previous button is ennable
							}
						
								
						// for create select list 	
							$pagelink.=	 '<select id="pager_no"  name="pager_no" class="" onchange="JavaScript:pager_act(this.value)" >';
							
							$select_page = 0;
							for($npage_i = 1; $npage_i<=$npage; $npage_i ++){
									
									
								if($npage_i == 1){
								
										$pagelink.='<option  value = "0" >'.$npage_i.'-'.$npage.'</option>'; 
									
								}
								else{
								 $select_page=$per_page+$select_page  ;
							
								
										$pagelink.='<option  value = "'.$select_page.'" >'.$npage_i.'-'.$npage.'</option>'; 
								}
									
									
							}
							
							
							$pagelink.=	'</select>';
								
								
							// create next pages	
									
								if($nxt<$npage){
									$pagelink.= "&nbsp;&nbsp;<a href='JavaScript:pager_act(".$tmp.");'&page=$per_page>&nbsp;&raquo;&nbsp;</a>";	//next button is enable
								}
							
							
								else{
							
								   $pagelink.="&nbsp;&nbsp<a href=''>&nbsp;&raquo;&nbsp;</a>";
								}		
								
							 
							 // create next pages
							 
							  if($npage){
						
								 $pagelink.= "&nbsp;&nbsp;<a href='JavaScript:pager_act(".$last.");'&page=$per_page>&nbsp;Last&nbsp;</a>";	//Last page enable
								 
							  }	
									
						
						
								$pagelink.= '<script language="javascript" type="text/javascript" >	
								
												E_V_PASS("pager_no",'.$start.')		
												
											 </script>';
						
						return $pagelink;	
						
						
					}// pager select act
		
		   /**************************** option builder ***********************************************************************************/  		
				
				      function option_builder($tbl_name,$field,$manipulate){
				                    
							#global $rdsql;
				
						    $sql="SELECT $field FROM $tbl_name $manipulate";
						   
							$exe_query = $this->rdsql->exec_query($sql,"ERROR in option_builder<br>$sql");
						
							$option_box='';	
							$select_count=1;
							while($option=$this->rdsql->data_fetch_array($exe_query)){								    
									$option_box.="<option id='$option[0]' value='$option[0]'  data-ax='".@$option[2]."'>".
									             "$option[1]".
												 "</option>";
									$select_count++;
							}	
							
							 return $option_box;
				      
				      } // end of option builder
					  
			/**************************** checkbox option builder cache 				  ***********************************************************************************/  	
			function option_builder_cache($tbl_name,$field,$manipulate){

				$lv = [];	
						
				$lv['cache_key'] 	  = 'OB_'.md5('OB_'.$tbl_name.$field.$manipulate);				
				$lv['cache_key_info'] = $this->coach['terminal_path']."/cache/$lv[cache_key].html";
						
				if(is_file($lv['cache_key_info'])){					
					$lv['temp_content']	=$this->getFileContent($lv['cache_key_info']);
				}else{
					$lv['temp_content']		   = $this->option_builder($tbl_name,$field,$manipulate);					
					$this->putFileContent(['path'=>$lv['cache_key_info'],
										  'content'=>$lv['temp_content']]);
				}								
				
				return $lv['temp_content'];
				      
			} // end of option builder cache

/***************************************************************************************************************************************
			* Function Name: checkbox_option_builder
			*
			* Desc : Pass table name and field label and value for checckbox
			*
			****************************************************************************************************************************/
					  
					  function checkbox_option_builder($param){
								
								$lv				= [];
								$lv['temp'] 	= [];
								$lv['exe_query']= '';
								
								if($param['field_label'] && $param['field_value']){
									
								$lv['sql']="SELECT $param[field_label] as label, $param[field_value] as value FROM  $param[table]"." ".@$param['where'];
										
								$lv['exe_query'] = $this->rdsql->exec_query($lv['sql'],"ERROR in checkbox_option_builder<br>$lv[sql]");
							
								while($option = $this->rdsql->data_fetch_assoc($lv['exe_query'])){								
										
										array_push($lv['temp'],['label'=>$option['label'],'value'=>$option['value']]);
								}
								
							  }
							  return $lv['temp'];
					     } // end of option builder
					  
/**************************** checckbox option builder ***********************************************************************************/  		
/**************************** radio option builder ***********************************************************************************/  	

/***************************************************************************************************************************************
			* Function Name: radio_option_builder
			*
			* Desc : Pass table name and field label and value for checckbox
			*
			****************************************************************************************************************************/
					  
					  function radio_option_builder($param){
								
								$lv				= [];
								$lv['temp'] 	= [];
								$lv['exe_query']= '';
								
								if($param['field_label'] && $param['field_value']){
									
								$lv['sql']="SELECT $param[field_label] as label, $param[field_value] as value FROM  $param[table]"." ".@$param['where'];
										
								$lv['exe_query'] = $this->rdsql->exec_query($lv['sql'],"ERROR in checkbox_option_builder<br>$lv[sql]");
							
								while($option = $this->rdsql->data_fetch_assoc($lv['exe_query'])){								
										
										array_push($lv['temp'],['label'=>$option['label'],'value'=>$option['value']]);
								}
							  }
							  return $lv['temp'];
					     } // end of option builder
					  
/**************************** radio option builder ***********************************************************************************/		   
		   // ft option builder
		   
		   function ft_option_builder($tbl_name,$field,$manipulate){
                   
							 global $rdsql;
						
						   $sql="SELECT $field FROM $tbl_name $manipulate";
						  
						   $exe_query = $rdsql->exec_query($sql,"ERROR in option_builder");
						
						$option_box='';
						$select_count=1;
						while($option=$rdsql->data_fetch_array($exe_query)){
						
						$option_box.='<option value="'.$option[0].'">'.$option[1].'</option>';
						$select_count++;
						}
						
						return $option_box;
		   }
				      
		   /////////////////////////////////////////////////////////////////////////////////////////////////////
		   
				      function get_list($tbl_name,$field,$manipulate){
				                    
							 global $rdsql;
							 
							 $temp = array();
							 
							 $sql="SELECT $field FROM $tbl_name $manipulate";						   
							 
							 $exe_query = $rdsql->exec_query($sql,"ERROR in option_builder");
							 
							 while($option=$rdsql->data_fetch_array($exe_query)){
								
									    array_push($temp,"'$option[0]'");
							 }	
							
							 return implode(',',$temp);
						
				      
				      } // end of option builder
				      
				      
		   /**************************** get_id_name ***********************************************************************************/  		
				
				      function get_id_name($tbl_name,$field,$manipulate){
							 
							 global $rdsql;
							 
							 $lv 	       = array();
				
							 $sql          = "SELECT $field FROM $tbl_name $manipulate";
						   
							 $exe_query    = $rdsql->exec_query($sql,"ERROR in option_builder");
						
							 $lv['info']   = array();	
							 
							 while($option=$rdsql->data_fetch_array($exe_query)){
								
									array_push($lv['info'],array('ID'   => $option[0],
												     'SN' => $option[1]
												     ));
							 }	
							
							 return $lv['info'];
				      
				      } // end of option builder
				      
				      
				      
				
				 function get_ennum_values($tbl_name,$field){
				  
					    global $rdsql;
	
				      $sql = "SHOW COLUMNS FROM $tbl_name WHERE Field = '$field'";
				      
				      $type = $rdsql->exec_query($sql,"Error");
    
				      $row = $rdsql->data_fetch_array($type);

				      preg_match('/^enum\((.*)\)$/', $row[1], $matches);
    
				      foreach( explode(',', $matches[1]) as $value ){

				           $enum[] = trim( $value, "'" );

				      }
        
				      return $enum;
		   
				}
				
				function ennum_option_builder($tbl_name,$field) {
				      
				      $option = $this->get_ennum_values($tbl_name,$field);
				      
				      $count = count($option);
				      
				      $option_box='';	
				      
				      $select_count=1;
				      
				      for($i = 0;$i<$count;$i++){
							 $option_box.="<option value='$option[$i]'>$option[$i]</option>";
							 $select_count++;
				      }
		   		      return $option_box;
				      
				}
				
				
				function enum_option_builder($tbl_name,$field) {
				      
				      $option = $this->get_ennum_values($tbl_name,$field);
				      
				      $count = count($option);
				      
				      $option_box='';	
				      
				      $select_count=1;
				      
				      for($i = 0;$i<$count;$i++){
							 $option_box.="<option value='$option[$i]'>$option[$i]</option>";
							 $select_count++;
				      }
		   		      return $option_box;
				      
				}
		/***************************************************************************************************************/	
				
				
		/***********************  4. customize mysql to json ****************************************************************************************/	
		
				function get_table_details(&$table_def){
							                      
									      global $rdsql;
										$l_v=array();
								
										$field_split = split(',',$table_def['fields_name']);
											
										$no_field = count($field_split);	
													
									 	$l_v['query']='SELECT '.$table_def['fields_name'].' FROM '.$table_def['table_name'].'  '. $table_def['condition'];
								
											
										$p_details_query=$rdsql->exec_query("$l_v[query]","Error");	
										
										// no of keys
										$no_json_key = count($json_details['key_details']);
										
									/// if key is not defin ... 
									/// than key field will be key
									 	
										$json_key = ($table_def['key_details'])?$table_def['key_details']:$table_def['fields_name'];
										
									
									// spilt
										$key_split    =  split(',',$json_key);
										
										 
											while($details_result = $rdsql->data_fetch_array($p_details_query)){
											
													// for evry fields
											
														
													$cell_data.='{';
													
													
													for($no_fields_i = 0; $no_fields_i<$no_field; $no_fields_i++){
															
														$cell_data.=$key_split[$no_fields_i].':\''.$details_result [$no_fields_i].'\',';
													
													} // for
											
													$cell_data=substr($cell_data,0,-1);
														
														
																						
													$cell_data.='},';
													
													$l_v['result']=$cell_data;
													
													
											} // while 
										
										return substr($l_v['result'],0,-1);		
										
										
					}// get_table_details	
					
					
					function get_mysql_json(&$json_details){
					
						return	$json_value = $this->get_table_details($json_details);
					
					}
	
						
		/***************************************************************************************************************/	
		
		/***************************** 5. create dir ********************************************************************************/	
							function make_dir($path){
											
											if(!(is_dir($path))){
												 
												mkdir("$path"); 
											
											}	
								}
					
		/***************************************************************************************************************/	
				
				
		/************************  rmv dir ***************************************************************************************/					
				
				function rmdir_recursive($dir) {
				
							if(is_dir($dir)){
								$files = scandir($dir);
								
								array_shift($files);    // remove '.' from array
								
								array_shift($files);    // remove '..' from array
								
								foreach ($files as $file) {
									$file = $dir . '/' . $file;
									if (is_dir($file)) {
								//	rmdir_recursive($file);
									rmdir($file);
								} 
								else {
									unlink($file);
								  }// else
								  
								}  //for each
						
								rmdir($dir);
						}	
					} // rmdir
					
					
					
		/***************************************************************************************************************/			
				
				
		/*********************** set file path  ****************************************************************************************/			
				
				/* Desc : set file name
					
							0 ->  file path	 
						return file in given location	
					*/
					
					function set_file_name($path){
					
								return $this->file_location = $path;
					}
				
				
				
	/***************************************************************************************************************/			
				
		/****************************  write file***********************************************************************************/				
				
			/* DESC : file write
						  0 -> content
						
					 returnt write file with given content
							
				*/ 	
					function file_write($file_content){
							
							$file_name=$this->file_location;
							
							$fh = fopen($file_name, 'w+') or die("can't open file");
							
							fwrite($fh, $file_content);
							fclose($fh);
					}	
									
		/***************************************************************************************************************/			
				
		/************************ page_reload / page_refresh***************************************************************************************/			
				  function page_reload($page_name,$pass_value){	
				  
				  			header("Location:$page_name?$pass_value");
				  }
				
				
				
		
		
						function page_refresh($pass_id){
							
							$page_name=$_SERVER['PHP_SELF'];
							
							if($pass_id){	
								
								 header("location:$page_name?PASS_ID=$pass_id");
								 
							}else{
								
								  header("location:$page_name");
							}
				}
				
		/***************************************************************************************************************/	
		
		
		/*********************** word slice ****************************************************************************************/					
					
							function word_split($str,$words) {
							 		
									$arr = preg_split("/[\s]+/", $str,$words+1);
									$arr = array_slice($arr,0,$words);
									return join(' ',$arr);
							}		
	
	
	
		
		
		
		/*********************** time_difference ****************************************************************************************/					
					
				      function time_difference($time) {
						
						global $rdsql;
						
						$select_time = $rdsql->exec_query("SELECT current_time","Time selection Failed");
						
						$sys_time = $rdsql->data_fetch_row($select_time);
						
						$sys_time_explode = explode(':',$sys_time[0]);
						
						$sys_min = $sys_time_explode[0]*60+$sys_time_explode[1];
							 		
						if (strpos($time, ':') !== false) { 
		
							 $time_difference =  explode(':',$time);
	
							 $sign = substr($time_difference[0],0,1);
							 
							 if(($sign == '+')||($sign == '-')){
	
									    $min = substr($time_difference[0],1)*60+$time_difference[1];
	
									    switch($sign){
											       case "-":
														  $time_min = $sys_min - $min;
														  break;

											       case "+";
														  $time_min = $sys_min + $min;
														  break;
									    }
							 }
							 else{
		
									    $time_min = $sys_min + substr($time_difference[0],0) * 60 + $time_difference[1];
							 }
						 }
						 else{
							 
							 $time_min = $sys_min + $time;
									
						 }
						 
						 $time_min_hour = intval($time_min/60); 
						 
						 $time_min_min = fmod($time_min,60);
						 
						 return $time_min_hour.':'.$time_min_min;
				      }	 	
	
	
					
					
		/*********************** simple ulpoad ****************************************************************************************/								
							function simple_upload($name,$location,$id){
		
										$file_name		= $_FILES[$name]['name'];			// store file
										
										$file_source	= $_FILES[$name]['tmp_name'];		// temp location of file	
										
										$file_location	= $location.$id.".jpg";
										
										move_uploaded_file($file_source,$file_location);
										
										//chmod("$file_location",0644);
										
										return $file_name;
						}
	
	/*********************** ****************************************************************************************/								
	
	
	
	/*******************  set system log   ********************************************************************************************/
	
				
				function set_system_log(&$def){
							
					global $rdsql;
					
					$any_id = 1;
 					
					$computer_name =	gethostname();//getenv(REMOTE_ADDR);
					
					@$access_key   = @$def['access_key'];
					
					$def['user_id'] = ($def['user_id'])?$def['user_id']:$any_id;
					
					if($access_key){
					
					  $insert_sql="INSERT INTO 
										sys_log
										(
											user_id, sys_access_ip, sys_access_name, page_code, action, action_type,access_key
										 ) 
										 VALUES (
											'$def[user_id]', '$_SERVER[REMOTE_ADDR]','$computer_name','$def[page_code]','$def[action]','$def[action_type]','$access_key'
										 )";
										 
						$insert_query =$rdsql->exec_query($insert_sql,"Error set_system_log");	
						
					}else{
							 
						$insert_sql="INSERT INTO 
										sys_log
										(
											user_id, sys_access_ip, sys_access_name, page_code, action, action_type
										 ) 
										 VALUES (
											'$def[user_id]', '$_SERVER[REMOTE_ADDR]','$computer_name','$def[page_code]','$def[action]','$def[action_type]'
										 )";
										 
						$insert_query =$rdsql->exec_query($insert_sql,"Error set_system_log");	
							 
						
					}
					
					return $insert_query;
				}
 
			/***************************************************************************************************************/			
				
				
				
				
		/****************************  current value ***********************************************************************************/			
				
				// pass format
				function current_($format){
						
						 $current_value = date("$format");
						
						 return $current_value;
				} 
		/***************************************************************************************************************/			
		
		
		
		
		/****************************  get no rows ***********************************************************************************/			
		
				/* pass = table name, condition 
				
				   **return no rows;
				   Example:  $nrow_def=array('table_name'=> 'seat',
				   							  'WHERE_FILTER'=> $WHERE_FILTER);	
											  			   
				*/
				
				function table_no_rows($nrow_def){
						
						global $rdsql;
						
						if(@$nrow_def['table_name']){
												
							 $select_num="SELECT count(*) as no_row FROM  $nrow_def[table_name] WHERE 1=1 $nrow_def[WHERE_FILTER]";
							
							// echo $select_num; 
							 if(@$nrow_def['show_query']){
								echo $select_num;		    
							 }
							 
						
							 $exe_query = $rdsql->exec_query($select_num,"Error Table no! $select_num");
						
							 $get_row = $rdsql->data_fetch_object($exe_query);
							 
							 // setcookie('start',@$_GET['start']);
					 
							 //$get_start = (@$_GET['start'])?@$_GET['start']:@$_COOKIE['start'];
							 
							 $start   =  (@$_GET['start'])?@$_GET['start']:0;//(@$get_start)?$get_start:0;
							 
							 //setcookie('page',@$_GET['page']);
							 
							 //$get_page = (@$_GET['page'])?@$_GET['page']:@$_COOKIE['page'];
							 
							 $per_page  = @$_GET['page'];//(@$get_page)?$get_page:5;
							 
							 return array($get_row->no_row,$start,$per_page);
						 }else{
							  return array(1,0,1);
						 }
						
					
				}  // end
				
				
			/***************************************************************************************************************/	
		
		
		
	/********************************************************************************************************
	* Function Name: getQuarterByMonth 
	*
	*  Desc : Send month nuber
	*		  return month ifo. as array
	*
	****************************************************************************************************************************/
	
	
	
	function get_quarter_by_month($monthNumber) {
			
				 $month_info = array();
 				
				 $quater_number=floor(($monthNumber - 1) / 3) + 1;
				
				 if($quater_number==1){
				 	
				 	  	$month_name = array("Jan","Feb","Mar");
						$month_id   = array(1,2,3);
				 }
				
				if($quater_number==2){
				 
				 		$month_name = array("April","May","Jun");
						$month_id   = array(4,5,6);
				 }
				
				 if($quater_number==3){
				 
				 		$month_name = array("July","Aug","Sep");
						$month_id   = array(7,8,9);
				 }
				 
				 if($quater_number==4){
				 
				 		$month_name = array("Oct","Nov","Dec");
						$month_id   = array(10,11,12);
				 }
				 
				array_push($month_info,$month_name,$month_id);
				
				return $month_info; 
		}
		
		
		
		
			
		/********************************************************************************************************
		* Function Name: get_quater_month_name_no 
		*
		*  Desc : Send quater no
		*		  return month name, month no. as a array
		*
		****************************************************************************************************************************/
		
		
		
				function get_quater_month_name_no($quater_no){
				
						$current_qtr  =($quater_no)?$quater_no:date('n');
						
						$quater_data  = $this->get_quarter_by_month($current_qtr);
					   
						list($quater_info,$quater_info_id)	= $quater_data;
						
						$total_no_month				= count($quater_info);
						
						$MONTH_INFO=array();
						
						for($total_no_month_i=0;$total_no_month_i<$total_no_month;$total_no_month_i++){
				
								$temp_count=$total_no_month_i+1;												// before not there
							   
								$temp_info=array();
								
								$temp_info['MONTH_NAME'] = $quater_info[$total_no_month_i];
								
								$temp_info['MONTH_ID']   = $quater_info_id[$total_no_month_i];					// before $total_no_month_i+date('n');	
								
								array_push($MONTH_INFO,$temp_info);
						}
					
						return $MONTH_INFO;
						
			 }// function get qtr month id
			 
			 
			 
			 
			 
			 
			/********************************************************************************************************
			* Function Name: get_machine_variable 
			*
			*  Desc : Send  table name, field name
			*		 get global variable	
			*
			***************************************************************************************************************************/

	
			
				function get_key_value($fields,$table_name,$where){
				 
						    global $rdsql;
				
							$lv=array();							
							$lv['field_keys']=[];
							$lv['result']	 =[];
							$lv['query_result'] = [];
							
							if(is_array($fields)){
								$lv['fields'] 	  = implode(',',array_values($fields));
								$lv['field_keys'] = array_keys($fields);
							}else{
								$lv['fields'] = $fields;
								$lv['field_keys'] = explode(',',$lv['fields']);
							}
							
							$lv['query']  		= "SELECT $lv[fields] FROM $table_name WHERE 1=1 $where";	
																
						// query execute						
							$lv['query_data']=$rdsql->exec_query("$lv[query]","Error");
						
						// for single row						
							$lv['query_result']=$rdsql->data_fetch_array($lv['query_data']);
														
							foreach($lv['field_keys'] as $key=>$val){									
									$lv['result'][$lv['field_keys'][$key]]=$lv['query_result'][$key];						
							}		
							
							return 	$lv['result'];				 		
				}
		
		/********************************************************************************************************/									
						
						
			/********************************************************************************************************
			* Function Name: data_packet_builder 
			*
			*  Desc : Pass table name and field 
			*	 	 	 and  return  as a data packet
			*
			****************************************************************************************************************************/
			
				
			function data_packet_builder($tbl_name,$field,$orderby){
			 
							global $rdsql;
					
							 $sql= "SELECT $field FROM $tbl_name $orderby ";
				
							$select =$rdsql->exec_query($sql,"Error in data packet_builder");
							
							$select_count=1;
							
							
							while($row_select =$rdsql->data_fetch_array($select)){
							  
								$data_packet.="$row_select[0]$row_select[1]";
								$packet_count++;
									} 
									
				
							
					return $data_packet;
				}		
				
						
				
			/********************************************************************************************************
			* Function Name: data_packet_builder 
			*
			*  Desc : Pass table name and field 
			*	 	 	 and  return  as a data packet
			*
			****************************************************************************************************************************/
				function get_last_id(&$table_def){
				 
				 global $rdsql;
	
							$sql =$rdsql->exec_query("SELECT id FROM $table_def[table_name] ORDER BY ID DESC LIMIT 0,1","Error");
							
							$get_row = $rdsql->data_fetch_array($sql);
							 
							$last_id = $get_row[0];
							
							return $last_id;
					
					}
			/****************************************************************************************************************************/		
		
		
			/********************************************************************************************************
			* Function Name: truncate_table 
			*
			*  Desc : Pass table name and field 
			*	 	 	 and  trunacte table
			*
			****************************************************************************************************************************/
			
		
			function truncate_table($table_name){
			 
			               global $rdsql;
				$truncate_sql = $rdsql->exec_query("TRUNCATE	
													 TABLE
													$table_name","Truncate Error");
	
			}
		
		
		
			/********************************************************************************************************
			* Function Name: truncate_table 
			*
			*  Desc : Pass table name and field 
			*	 	 	 and  trunacte table
			*
			****************************************************************************************************************************/
			
		
		
		
			function set_bulk_data(&$def){
			
			
				//echo "INSERT INTO 
				//						$def[table_name]
				//						(
				//						$def[field_name]
				//						) 
				//						VALUES 
				//						$def[data]
				//						";
					
			
					if($def['data']){
					
				
					 $insert_sql = $this->dbh->query("INSERT INTO 
										$def[table_name]
										(
										$def[field_name]
										) 
										VALUES 
										$def[data]
										"
								) or die('error in insert ...general lib>>');
					
					
					   //$insert_id = $dbh->lastInsertId();
					   
					} 
					
					return 	 $insert_id;
				
			}
		
		
		
			/********************************************************************************************************/
			
			function file_upload(&$file_def){
					
					  // encrypt data fetch 
					  		$current_time	= date('is');
								
							$data			= "0".$current_time;
												
							$encode_key		= $this-> encode("$data");    // encode function call
					  
					 // file store in temp file 
					     $file_name=$_FILES[$file_def['file_name']]['name'];				// store file
						
						$file_source=$_FILES[$file_def['file_name']]['tmp_name'];		// temp location of file	
						
						if($file_name){
						
						 $upload_file_name = $encode_key.'_'.$file_name;
						}
						// store file name concat with crypt code
						
							$file_location=$file_def['file_location'].$upload_file_name;

							$up_id= move_uploaded_file($file_source,$file_location);
						
							///chmod("$up_id",0777);
							
					
						return $upload_file_name;
				}
			
			
			
			
			/***********************************************************************************/
			
				
						
					 function encode($data){
					 
								$crypt=array(
								
										array('a','m','e','w','g','x','j','q','o','y'),										
										array('z','t','c','v','b','n','q','w','e','r'),										
										array ('p','o','i','u','y','f','e','s','c','a')
									);	
						
							$len=strlen($data);
							
							$hash_key=rand(0,2);
							
							$temp='';
							
							for($char=0;$char<$len;$char++){
							
								//substr($data,$char,1)
								//echo $crypt[$hash_key][0];
							
							   $temp.=$crypt[$hash_key][substr($data,$char,1)];
							
							}
							
							return $temp;
					 }
	 /****************************************************************************************************/
			
			
			
		 /****************************************************************************************************/
			
		 /****************************************************************************************************/
			
					
			
			 function radio_builder(&$radio_def){
			                     global $rdsql;
		
						$select_sql="SELECT $radio_def[field_name] FROM $radio_def[table_name]";
				
						$select_mysql=$rdsql->exec_query($select_sql,"Error");
						
						$select_count=1;
						
						while($select_row=$rdsql->data_fetch_array($select_mysql)){
						
									
							 $select_radio.='<input type="radio" id="'.$tb_nm.'_'.$select_row[0].'" name="'.$tb_nm.'" value='.$select_row[0].' /> '.$select_row[1].''."<br>";
										
						
						}
						
						return  $select_radio;
					}	
			
		 /****************************************************************************************************/
			
			
				
		 /****************************************************************************************************/
							
			
		   function build_where_filter($where_filter){
     
				      $l_v=array();
				    
				      $no_key = count($where_filter);
				      
				      for($no_key_i = 0;$no_key_i<$no_key;$no_key_i++){
					      
							 $keys    = array_keys($where_filter);											       
							 $values  = array_values($where_filter);	
							 
							 if	($values[$no_key_i]){
							  
								$l_v['WHERE_FIlTER'].=  " AND $keys[$no_key_i]='$values[$no_key_i]'";
							 }	
				      }

				      return  $l_v['WHERE_FIlTER'];								
		   
		   } // build where filter			
		
					
		/****************************************************************************************************/
		// create csv file	
								
			function create_csv_file(&$DATA){
				
				
				$file_name     =  $DATA['key_id'].'_'.strftime('%d_%b_%Y_%H_%M_%S').'.csv';
			
				$file_location = $DATA['file_location'].'/'.$file_name;
			
						
				 $export_query = "SELECT
								    $DATA[field_name]
								INTO OUTFILE '$file_location'
								
								FIELDS TERMINATED BY ','  ENCLOSED BY '\"'
								
								lines
									terminated by '\r\n'
								FROM 
									$DATA[table_name]
									WHERE 1=1
									$DATA[WHERE_FILTER] 
									$DATA[BUILD_ORDER] 
									$DATA[PAGER]";
				
				$execute_export_query = $this->dbh->query($export_query)or die('export--');
				
				
				// error
				
				
				return $file_name;
		
			} // csv
			
			
			
			
		 /****************************************************************************************************/
		 
		  /***************** dynmic replace text ***************************************************************************************************************************************************************************************/		
			 function dynamic_placing_write($message,$arg){
		
						$l_v =array();
							
						$l_v['message_arg_spit']   = split(',',$arg);
							
						 $l_v['message_arg_legth']   = count($l_v['message_arg_spit']);	
								
						$l_v['message_text']  = $message;		
			
					//	echo $l_v['message_text'].'------------ddd--'.$arg.'--we-';
						
						$pattern     = "/(%)[a-z]+/i";
					
					
						for($no_matches_i = 0; $no_matches_i<$l_v['message_arg_legth']; $no_matches_i++){
								
								$l_v['get_replace_text'] = preg_replace($pattern, $l_v['message_arg_spit'][$no_matches_i], $l_v['message_text'],1);
			 
								$l_v['message_text']	= $l_v['get_replace_text'];
						}
						
						return $l_v['message_text']; 
		
			}
		
	 /***************** set data into csv file***************************************************************************************************************************************************************************************/		
	
			function set_csv_data($def){
			
					$html_data = explode("[R]",$def['csv_data']);
					
				//	print_r($html_data );
				
					$file_name = $def['file_name'];	
					
					$fh = fopen($file_name, 'w') or die("can't open file");
						
					//fwrite($fh,$html_data);
				
					foreach ($html_data as $line) {
				
						   $html_data = explode("::",$line);
							//print_r($html_data);
						   fputcsv($fh,$html_data);
					}
					
					fclose($fh);
					
					return $file_name;
			}
			
			// 4 Mar 2015
			
		      function set_html_file($html_content,$file_name){
				      
				      $file = fopen($file_name,'w') or die("can't open");
				      
				      fwrite($file,$html_content);
				      
				      fclose($file);
				      
				      return $file_name;
		      }//end
	/********************************************************************************************************************************************************************************************************/	
	
	/******** set cookies ************************************************************************************************************************************************************************************************/
		//,$is_cookies_expire
	
		/*function get_cookies($key,$value,$default,$is_expire){
			
				$expiry = time()+3600;
			
				if(isset($value)){
					
					setcookie($key,$value,$expiry);
					
				}
				elseif( (isset($_COOKIE[$key])==false) && (isset($default)==true) ){
					
					setcookie($key,$default,$expiry);			
				}
				
				elseif(@$is_expire ){ 
						
						
					 	unset($_COOKIE[$key]);
						
						 setcookie($key, '', time()-3600);
				
				}
				
				#echo @$_COOKIE[$key];
				
				
				
				if($default){
					return $default;
				}
				
				elseif(@$_COOKIE[$key] == true ){	
					return isset($_COOKIE[$key])?$_COOKIE[$key]:NULL;			
				}
				else{
			
					return NULL;
				}
			
		} */// end
		
		
		
		
/******************************************************************************************************************************************************/
	
		function get_cookies($key,$value,$default,$is_expire){
				
				#echo $key.'------'.$value.'------'.$default.'------'.$is_expire.'---<br>';
				$expiry = time()+3600;
			
				if(isset($value)){
					setcookie($key,$value,$expiry,'/','',true,true);					
				}elseif( (isset($_COOKIE[$key])==false) && (isset($default)==true) ){					
					setcookie($key,$default,$expiry,'/','',true,true);			
				}elseif(@$is_expire ){ 
					 	unset($_COOKIE[$key]);
						setcookie($key,'', time()-3600,'/','',true,true);
				}
				
				
				if($default){
					return $default;
				}elseif(@$_COOKIE[$key] == true ){	
					return isset($_COOKIE[$key])?$_COOKIE[$key]:NULL;			
				}elseif(@$_COOKIE[$key] == false){
					return NULL;
				}else{	
					return NULL;
				}
				
		} // end
		
		
		function get_cookies_ii($param){
				
				$key		= $param['key'];
				$key_id		= $param['key_id'];
				$value		= $param['value'];
				$default	= $param['default'];
				$is_expire	= @$param['is_expire'];
				
				$expiry = time()+3600;
				
				
				if(isset($value) || 
				   (array_key_exists($key_id,@$_GET) && (!@$_GET[$key_id])) 
			    ){
					setcookie($key,$value,$expiry,'/','',true,true);					
				}elseif( (isset($_COOKIE[$key])==false) && (isset($default)==true) ){					
					setcookie($key,$default,$expiry,'/','',true,true);			
				}elseif(@$is_expire ){ 
					 	unset($_COOKIE[$key]);
						setcookie($key,'', time()-3600,'/','',true,true);
				}				
				
				if($default){
					return $default;
				}elseif((@$_COOKIE[$key] == true )&& (array_key_exists($key_id,@$_GET)==false)){				
					return isset($_COOKIE[$key])?$_COOKIE[$key]:NULL;			
				}elseif(@$_COOKIE[$key] == false){
					return NULL;
				}else{	
					return NULL;
				}
				
		} // end
	
/*********************************************************************************************************************/		
	
		
	/*********** Create Inc File (AoA) *********************************************************************************************************************************************************************************************/		
	
			function table_to_inc(&$def){
			
				$lv = array();
			 	$select_data = "SELECT 
										$def[field_name]
								FROM 
									$def[table_name]
									$def[manipulation]";
									
				$exe_stmt =  $this->dbh->query($select_data)or die('AOAError!--');	
			
				$lv['get_data'] =''; 	
				
				while($get_row = $exe_stmt->fetchObject()){
					 
					$lv['data_array'] = '';	
					 
					 for($label_i=0; $label_i<count($def['label_name']); $label_i++){
					
							$lv['data_array'].= ' '.$def['label_name'][$label_i].'=>'.$get_row->$def['label_name'][$label_i];
					 }
					 
					
					$lv['get_data'].=  'array('.$lv['data_array'].'),';	
					
					
				}
					
					
				$inc_data = '<?PHP $AOA[\'machine_info\']=  array('.substr($lv['get_data'],0,-1).') ?>';
			  
			  	$this->set_file_name($def[file_location]);
				
				$this->file_write($inc_data);
							  
			}
	/********************************************************************************************************************************************************************************************************/		
	
	/*************** table to csv *****************************************************************************************************************************************************************************************/		
		
			function table_to_csv(&$def){
					
					$lv= array();
					
					$select_data = "SELECT 
										$def[field_name]
								FROM 
									$def[table_name]
									$def[manipulation]";
									
					$exe_stmt =  $this->dbh->query($select_data)or die('Table_TO_CSVError!--');	
					
					$lv['get_csv_data']='';
					
					while($get_row = $exe_stmt->fetchObject()){
					 
					$lv['csv_data'] = '';	
					 
					 for($label_i=0; $label_i<count($def['label_name']); $label_i++){
					
							$lv['csv_data'].= $get_row->$def['label_name'][$label_i].'::';
					 }
					 
					
					$lv['get_csv_data'].=  ''.$lv['csv_data'].'[R]';	
					
					
				}
				
				$this->set_csv_data(
									$def=array(	
					     
										  'csv_data' => $lv['get_csv_data'],
										
										   'file_name' => $def['file_location']  // '../csv/alaram_'.time().'.csv'
										)
							);
				
				//print $lv['get_csv_data'];	
					
			} // desk			
		
		/**************************************** date picker to iso **********************************/
		/* i/p -> 02-Jun-2012 10:10                                                                   */
		/* o/p -> 2012-06-02-10-10-00								      */
		/**********************************************************************************************/
		
		function get_datetime_picker_to_iso($date_picker){
			
			 $matches = array();
			 		 
			 preg_match('/(\d+)(\-)(\w+)(\-)(\d+)(\s+)(\d+)(\:)(\d+)/',$date_picker,$matches);
			 
			 return $matches[5].'-'.$this->month_short[strtolower($matches[3])].'-'.$matches[1].'-'.$matches[7].'-'.$matches[9].'-00';
							
		} # end
		
		
		/**************************************** date picker to pg **********************************/
		/* i/p -> 02-Jun-2012 10:10                                                                   */
		/* o/p -> 2012-06-02 10:10:00								      */
		/**********************************************************************************************/
		
		function get_datetime_picker_to_pg($date_picker){
			
			 $matches = array();
			 		 
			 preg_match('/(\d+)(\-)(\w+)(\-)(\d+)(\s+)(\d+)(\:)(\d+)/',$date_picker,$matches);
			 
			 return $matches[5].'-'.$this->month_short[strtolower($matches[3])].'-'.$matches[1].' '.$matches[7].':'.$matches[9].':00';
							
		} # end
		
		

		function sec_to_0h00m00s ($sec){   return  sec_to_00h00m00s_core($sec,1); }
		
		function sec_to_00h00m00s ($sec){  return  sec_to_00h00m00s_core($sec,2); }
		
		// sec2hms core conversion
		
		function sec_to_dhms($sec){
		  
		      $sec = round($sec, 0, PHP_ROUND_HALF_EVEN);
		      
		      // start with a blank string   
		  
			$hms = "";
			    
			$padHours = true;    
				
			    if( (is_null($sec)) || ($sec==0)){
				   
				return '0';    
			    }
			    else{
				
				// seconds to day conversion:
			      
				$days = intval(intval($sec) / 86400);
				
				if($days>0){
				
						$hms .= $days. "<b title=Days>d</b> ";
				}
				// seconds to hours
				
				$hours = intval(($sec/3600) % 24); 
			    
				// add hours to $hms (with a leading 0 if asked for)
				$hms .= ($padHours) 
				      ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
				      : $hours. ":";
				
				// dividing the total seconds by 60 will give us the number of minutes
				// in total, but we're interested in *minutes past the hour* and to get
				// this, we have to divide by 60 again and then use the remainder
				$minutes = intval(($sec / 60) % 60); 
			    
				// add minutes to $hms (with a leading 0 if needed)
				$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
			    
				// seconds past the minute are found by dividing the total number of seconds
				// by 60 and using the remainder
				$seconds = intval($sec % 60); 
			    
			    
				//$microsec = round($sec - intval($sec),1);
			    
			       // $seconds = $seconds + $microsec;
			    
				//print $microsec;
				// add seconds to $hms (with a leading 0 if needed)
				
				$hms .= str_pad($seconds,2,"0",STR_PAD_LEFT)."";
				    //print $sec%;
				
				// done!
				return $hms;
			    
			    } // end
				
		      } //end

  
 
			// sec_00h00m00s
			
			
			function sec_to_00h00m00s_core ($sec,$padding) 
			{
			
			$sec = round($sec, 0, PHP_ROUND_HALF_EVEN);
			// start with a blank string   
			
			$hms = "";
			    
			$padHours = true;    
				
			    if( (is_null($sec)) || ($sec==0)){
				   
				return '0';    
			    }
			    else{
				
				$days    = intval(intval($sec) / 86400);
				
				$hours   = intval(($sec/3600) % 24); 
			    
				$temp_hours[1] = "24:";
					    
				// add hours to $hms (with a leading 0 if asked for)
				$temp_hours[0] = ($padHours) 
						  ? str_pad($hours,$padding, "0", STR_PAD_LEFT). ":"
						  : $hours. ":";
						  
				$hms     =   $temp_hours[$days];                
							
				$minutes = intval(($sec / 60) % 60); 
			    
				$hms    .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
			    
				$seconds = intval($sec % 60); 
				
				$hms    .= str_pad($seconds,2,"0",STR_PAD_LEFT)."";
			    
				return $hms;
			    
			    } // end
				
			} // end
			
		    /*************************************************************************************************************************/
		    
		    	
		    
		    /********************************************************************************************************
		    * Function Name: Max no
		    *
		    *  Desc : get maximum no from table
		    *	 
		    *
		    ****************************************************************************************************************************/   
		       function get_max_id($def){
			     
			                  global $rdsql;
					  
					 $selct_sql="SELECT 
												max($def[field])
										 FROM
												$def[table]
										  		$def[manipulation]"; 
												
								$select_query=$rdsql->exec_query($selct_sql,"Error Max No");
															
								$result=$rdsql->data_fetch_array($select_query);
									
								$bill_id=$result[0];
									
							return 	($bill_id)?($bill_id)+1:1;
			}
		/********************************************************************************************************************************************************************************************************/		
		
		
		   /********************************************************************************************************
		   * Function Name: Max no
		   *
		   *  Desc : get maximum no from table
		   *	 
		   *
		   ****************************************************************************************************************************/   
		   function get_count($def){
				      
				      $lv=[];
				      
				      $lv['query']="SELECT 
									    count(*)
							     FROM
									    $def[table]
									    $def[where]"; 
									     
				      $lv['query_exec']=$this->rdsql->exec_query($lv['query'],"Error Get Count");
											      
				      $lv['result']    =$this->rdsql->data_fetch_array($lv['query_exec']);
					      
				      $lv['count']     =$lv['result'][0];
						     
				     return ($lv['count'])?($lv['count']):0;
		    }
		   /********************************************************************************************************************************************************************************************************/		
		
	  
		//set_custom_cookies
		//input:array of value
	       //set cookies depend on condition
	       //output:return cookie
           
          function set_custom_cookies($key){
                    
                    $cookie='';
                    
                   foreach($key as $element){
                    
                        if((strlen(@$_GET[$element])>0)||(@$_POST[$element])){
                                
                                //echo $_GET[$element];
                                
                            setcookie($element,$_GET[$element]);
                            
                            
                        }//end if
                        
                        else{
                                    
                                    $_GET[$element]=$_COOKIE[$element];
                                    
                                    $cookie = $_GET[$element];
                            
                        }//end elseif
                        
                   }//end of for_each
                   
                  
          }//end
	  
	  
	  
	  
	  function get_parent_option_builder($tbl_name,$field,$manipulate){
				 
						   global $rdsql;
				
						   $sql="SELECT $field FROM $tbl_name $manipulate";
						   
						   $exe_query = $rdsql->exec_query($sql,"ERROR in get_parent_option_builder");
						
							$option_box='';
							
							$select_count=1;
							
							while($option=$rdsql->data_fetch_array($exe_query)){
								        
								       $_SESSION['title']='';
									
								       $this->get_parent($option[0]);
									
									$option_box.="<option id=$option[0] value='$option[0]'>".$_SESSION['title']."</option>";
									
									$select_count++;
							}	
							return $option_box;
					}
				
				
	  
	  //define the function get_parent_menu
	//input: parent_id
	
	   function get_parent($monk_id){
	    
	                       global $rdsql;
					
				$parent = $rdsql->exec_query("SELECT sn, parent_id FROM content_info WHERE id = $monk_id ORDER BY parent_id ASC ","ERROR in get_parent");   
				
				$row = $rdsql->data_fetch_row($parent);
				   
				 if($row){							//if rows are available
					
				      $_SESSION['title']=$row[0]."->".$_SESSION['title'];   	//monk name of the perticular id  
						
				       $this->get_parent($row[1]);			
														
				 }
					
					return  $_SESSION['b_c'];					//print the bread crumb
		}//end
		
		
		//entity_value:
		
		function get_entity_value($entity_code,$entity_key){
		 
		            global $rdsql;
	 
	          $entity_value_query ="SELECT
		                              entity_value
					 FROM
					       entity_key_value
					 WHERE
					       entity_key='$entity_key'";
					       
		  $entity_value_query_exec = $rdsql->exec_query($entity_value_query,"Error in get_entity_value");
		  
		  $row  = $rdsql->data_fetch_array($entity_value_query_exec);
		  
		  $entity_value = $row['entity_value'];
		  
		  return $entity_value;
		  
	  }//end entity_value
		
	  
	//Column Value
	//input: Table Name, Field, Where Filter
	//return single colum value
	function get_column_value($table_name,$field,$manupulation){
		   
		global $rdsql;
		
		$column_value_query = "SELECT
									$field
						FROM
						$table_name
							$manupulation";

		$column_value_query_exec = $rdsql->exec_query($column_value_query,"ERROR");		   
		$get_row = $rdsql->data_fetch_array($column_value_query_exec);

		if(@$get_row[$field]){		   
			$temp[$field] = $get_row[$field];			
			return $temp[$field];
		}else{
			return false;
		}
		   
	} //end  
	  
	  
	  
	  // mail_send
	  
			  function mail_send($param){
				
						$message='';
						$message.="	<html>
										<head>
										<title>
											</title>
									</head>	
									<body>";
									
						$message.=$param['message'];
						
						$message.="</body></html>";
						
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers.='From: '.$param['subject']. "\r\n";
						
						if(@$param['cc']){
						
							$headers .= 'Cc: '.$param['cc'].' ' . "\r\n";
						}
						
						if(@$param['bcc']){
		
							$headers .= 'Bcc: '.$param['bcc'].' ' . "\r\n";
						}	
									
						if($mailsent=mail($param['to'],$param['subject'],$message,$headers)){
							return 1;
						}	
						else {return 2;}
						
						
						
				}
				
				
				function generate_hash($def){
				      
				      $current_time	= "0".date('is');
								
				      $current_time_substr	= substr($current_time,0,6);
				      
				      $combone_code = $def['user_id'].$current_time_substr.rand();
				      
				      return md5(sha1($combone_code));
				}
				
				function get_one_columm($param){
				      
				          global $rdsql;
				         
					  $select_data = "SELECT $param[field] as field_1 FROM $param[table] $param[manipulation] ";

					  if(@$param['show_query']==1){
						echo $select_data;
					  }
			 
					  $exe_select_data = $rdsql->exec_query($select_data,'select data--->');
							 
					  $get_sel_data = $rdsql->data_fetch_object($exe_select_data);
							 
					   return is_object($get_sel_data)?$get_sel_data->field_1:'';
				}
				
				
				function get_one_column($param){
				      
				          global $rdsql;
						  
						if(@$param['table']){								
								$param['table']= " FROM $param[table] ";	
						}else{
								$param['table'] = '';
								 $param['manipulation'] = '';
						}							
				         
					   $select_data = "SELECT $param[field] as field_1 $param[table] $param[manipulation] ";

					   if(@$param['show_query']==1){
						echo $select_data;
					  	}
			 
					   $exe_select_data = $rdsql->exec_query($select_data,'select data--->');
							 
					   $get_sel_data = $rdsql->data_fetch_object($exe_select_data);
					  		 
					   return is_object($get_sel_data)?$get_sel_data->field_1:'';
				}
				
				
				function get_one_cell($param){
				      
				          global $rdsql;
				         
					   $select_data = "SELECT $param[field] as field_1 FROM $param[table] $param[manipulation] ";
			 
					   $exe_select_data = $rdsql->exec_query($select_data,'select data--->');
							 
					   $get_sel_data = $rdsql->data_fetch_object($exe_select_data);
					  		 
					   return is_object($get_sel_data)?$get_sel_data->field_1:'';
				}
				
/***********************************************************************************************************************************************************************************************************/				
				/*
				      Data cryp & decrpt
				      $ses =  session_id();
				      $cryp_value = encrypt(1234, $ses);
				      echo '<br><--------><br>';
				      echo decrypt($cryp_value, $ses);
				*/
				
				function encrypt($sData,$sKey){	
				      $sResult = '';
				      for($i=0;$i<strlen($sData);$i++){
					  $sChar    = substr($sData, $i, 1);
					  $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
					  $sChar    = chr(ord($sChar) + ord($sKeyChar));
					  $sResult .= $sChar;
				      }
				      return $this->encode_base64($sResult);
			      }
		      
			      function decrypt($sData,$sKey){
				      $sResult = '';
				      $sData   = $this->decode_base64($sData);
				      for($i=0;$i<strlen($sData);$i++){
					      $sChar    = substr($sData, $i, 1);
					      $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
					      $sChar    = chr(ord($sChar) - ord($sKeyChar));
					      $sResult .= $sChar;
				      }
				     return $sResult;
			      }

				  // encrypt reverse mix
				  function encryptRMIX($content,$key){

						return $this->encrypt($this->encrypt($content,$key),
														   strrev((string) $key)
								);

				  } // end of reverse mix
				      
				// derypt rmix
				function decryptRMIX($content,$key){
					return $this->decrypt($this->decrypt($content,strrev((string) $key)),
										  $key);
				} // decrypt remix

				 
				      
			       function encode_base64($sData){
				      $sBase64 = base64_encode($sData);
				      return str_replace('=', '', strtr($sBase64, '+/', '-_'));
			      }

				  
			      
			      function decode_base64($sData){
				      $sBase64 = strtr($sData, '-_', '+/');
				      return base64_decode($sBase64.'==');
			      }

				function encodeBase64($content){ return $this->encode_base64($content);        } // end
				function decodeBase64($enc_content){ return $this->decode_base64($enc_content);} // end
				  
				  // key generator
				  function hashKeyGenerator($starter,$tailend){
					  
							$starter = $starter ?? rand();
							$tailend = $tailend ?? rand();
											
							return md5($starter.rand(1,4).rand().rand(10,100).time().$tailend);
					  
				  } // end
				  
/*get_ekv
* get entity key value
* i/p - entity_code, key
  o/p - entity_key_value
*/

function getEKV($entity_code,$key){	

	$coach = $this->coach['id'];
	if($entity_code && $key){

		//echo " WHERE coach_id=$coach AND entity_code='$entity_code' AND entity_key='$key' ";

		return $this->get_column_value('entity_key_value',
									   'entity_value',
									   " WHERE coach_id=$coach AND entity_code='$entity_code' AND entity_key='$key' ");
	}

} // end

///// set CEKV/////////////////////////////////////////////////////
// i/p -> entity_code,entity_key,entity_value
// o/p -> successfull update -> true, not logged user -> false
/////////////////////////////////////////////////////////////////
function setCEKV($coach,$entity_code,$key,$val){

	$lv = (object)['query'=>'','coach_id'=>'','coach_hash'=>'','is_exist'=>'','user_id'=>''];

	$lv->coach_id 	= @$coach ?? $this->coach['id'];
	$lv->coach_hash	= $this->get_one_column([	'table'			=> 'entity_child',
												'field'			=> "md5(get_eav_addon_vc128uniq(id,'CHCD'))",
												'manipulation'  => " WHERE id=$lv->coach_id" ]);
	$lv->user_id = $this->getUserId();

	if(@$lv->user_id){

		
			$lv->is_exist = $this->get_one_column(['table'=>'entity_key_value',
												'field'=>'count(*)',
												'manipulation'=> " WHERE domain_hash='$lv->coach_hash' 
																	 AND entity_code='$entity_code'
																	 AND entity_key='$key' "
												]);

		if($lv->is_exist==0){

			$lv->query = "INSERT INTO 
										entity_key_value(coach_id,domain_hash,entity_code,entity_key,entity_value,user_id)
								VALUES
										($lv->coach_id,md5(get_eav_addon_vc128uniq($lv->coach_id,'CHCD')),
										'$entity_code','$key','$val',$lv->user_id)";

		}else if($lv->is_exist>0){

			$lv->query =" UPDATE 
								entity_key_value
							SET
								entity_value='$val',
								user_id		= $lv->user_id
							WHERE 
									domain_hash='$lv->coach_hash' 
									AND entity_code='$entity_code'
									AND entity_key='$key' ";			
						

		} // is exists

			$this->rdsql->exec_query($lv->query," Set EKV Failed");
			return true;

	} // userid

	return false;

} // end


///set EKV
function setEKV($entity_code,$key,$val){

	$this->setCEKV($this->coach['id'],$entity_code,$key,$val);

} // end


/**********************************************************************************************************************************************************************************************************/		
	
	// put file content	
	function putFileContent($param){		
		$fh  			  	   = fopen($param['path'],'w') or "File Open Error";
		fputs($fh,$param['content']);
		fclose($fh);
	} // end
	
	// get file content	
	function getFileContent($file_path){		
		$fh  			  	   = fopen($file_path,'r') or "File Open Error";
		$temp_content   	   = fread($fh,filesize($file_path));
		fclose($fh);
		return $temp_content;
	} //end
	
	//getClean
	function getCleanAlphaNum($in){
		return preg_replace('/\W/i','',$in);
	} // end

	//get number only
	function getCleanNum($in){
		return preg_replace('/\D/i','',$in);
	} // end	

	//get number only
	function getCleanAlpha($in){
		return preg_replace('/[^a-zA-Z]/i','',$in);
	} // end

	function getCleanToken($in){
		return preg_replace('/[^a-zA-Z\_]/i','',$in);
	} // end

	//////////////////////////////////////////
	/// i/p -> string
	//////////////////////////////////////////
	function setHeaderContentType($content_type){
		
		$content_type_list = ['json'=>"application/json; charset=UTF-8"];		
		//return (@$content_type_list[$content_type])?@$content_type_list[$content_type]:throw new Exception("Undefined Type $content_type given");
		return @$content_type_list[$content_type];
	} // end

	//////////////////////////////////////////
	/// i/p -> associatve array key & values level 1
	//////////////////////////////////////////
	function sendContentTypeJSON(array $key_values){

		$header = $this->setHeaderContentType('json');		
		header("Content-Type: $header");		
		return json_encode($key_values);

	} // end

	////////////////////////////////////////////
	/// i/p -> ecb's token
	/////////////////////////////////////////////
	function getEcbShortNameByToken($token){
		$token=$this->getCleanAlphaNum($token);
		return $this->rdsql->data_fetch_array($this->rdsql->exec_query("SELECT sn FROM entity_child_base WHERE token='$token'","ECB query"))[0];
	}

	function getEcbShortNameByTokenCache($token){

		if($token){
			$token=$this->getCleanAlphaNum($token);			
			return $this->rdsql->data_fetch_array($this->rdsql->exec_query("SELECT sn FROM entity_child_base WHERE token='$token'","ECB query"))[0];
		}
	}

} // end of class
    
include(dirname(__FILE__)."/status.php");
    
////////////////////////////////////////////////////////////////////////
// 18-Jul-2015 general.php table_no_rows->defined
////////////////////////////////////////////////////////////////////////
    
          

?>