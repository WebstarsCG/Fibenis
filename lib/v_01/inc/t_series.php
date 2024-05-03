<?PHP
		
		error_reporting(E_ALL);
		
		ini_set("display_errors",1);

		#include($LIB_PATH."/inc/lib/filter.php");
		
		$PAGE_ID   = $PAGE;
		
		$PAGE_INFO = '';	
		# loader
		
		if(($PAGE_ID=='t_series') || ($PAGE_ID=='t') || ($PAGE_ID=='tx') ){
															
				$router = action_router(array('page_id'      =>$PAGE_ID,
							'page_name' => $PAGE_NAME,
							'lib_path'  => $LIB_PATH
							));					
				include($router['action']);
				
				$PAGE_CODE_HASH = md5($PAGE_CODE);
				
				if($router['action']){
						
						if(@$_GET['session']=='off'){
						
								if(!$T_SERIES['session_off']){					
										$SG->s_destroy('index.php');
								}							
						}else{
							if(!$USER_ID && !$T_SERIES['session_off']){					
									$SG->s_destroy('index.php');		
							}else if($USER_ID){		
								$SG->check_entry($SG->get_permission_direct($PAGE_CODE_HASH));	
							}
						}
						
						$T_SERIES['page_code'] = $PAGE_CODE_HASH;	
						
						// key optimization
						$T_SERIES['data']	   = @$T_SERIES['fields'] ?? $T_SERIES['data'];		
		
				}else{
						http_response_code(404);
						
						include ("$LIB_PATH/template/error/404.php");
						
						exit;
				}
		} # app key	
		
		
		
		# template
				
		if((@$T_SERIES['template']) || (@$T_SERIES['template_content'])){
					
				// lockfile
				$T_SERIES['temp']['key']  = @$_GET['key'];
				$T_SERIES['temp']['file'] = $COACH['terminal_path']."/cache/$PAGE_CODE"."_".$T_SERIES['temp']['key'].".html";	
				
				if(is_file($T_SERIES['temp']['file']) && 
					((@$_GET['clear_cache']!=1) && (@$T_SERIES['is_cc']!=1))){				
						
					
						$fh  							= fopen($T_SERIES['temp']['file'],'r') or "Error";
						$T_SERIES['temp']['content']    = fread($fh, filesize($T_SERIES['temp']['file']));
						fclose($fh);
					
						$PAGE_INFO	= $T_SERIES['temp']['content']; 					
					
				}else{				
				
					if(is_file($T_SERIES['temp']['file'])){				
						unlink($T_SERIES['temp']['file']);
					}
		
					$options 	= array("debug"=>0,"loop_context_vars"=>1);					
					
					if(@$T_SERIES['template']){						
						$options['filename']=$T_SERIES['template'];
					}
					
					if(@$T_SERIES['template_content']){						
						$options['template_content']=$T_SERIES['template_content'];
					}
					
								
					$T 	 	= new Template($options);
					
					$T->AddParam((@$T_SERIES['fields']?'CONTENT':'DATA_INFO'),
								  build_template());
					
					# output to global var
					
					$T_SERIES['temp']['created_content'] = $T->Output();					
					
					// fseries to temp
					$fh = fopen($T_SERIES['temp']['file'],'w') or "Error";
					fputs($fh,$T_SERIES['temp']['created_content']);
					fclose($fh);	
					
					$PAGE_INFO = $T_SERIES['temp']['created_content'];
					
				} // fresh case			
				
		} // is template content exists
		
		# save
		$param = array( 'user_id'    => $USER_ID,
			        'page_code'  => $T_SERIES['page_code'],
				'action'     => 'Template Process with '.$PAGE_NAME);
		
		if(isset($T_SERIES['save_as'])){
				
				save_content(['t_series'=>$T_SERIES,
					      'lib_path'=>$LIB_PATH,
					      'content' =>$PAGE_INFO
					      ]);
				
				$param['action_type'] = 'TSAV';
		}else{
				$param['action_type'] = 'TRUN';
		}
		
		$G->set_system_log($param);
		
		
				
		// build template
		
	        function build_template(){
		
				global $T_SERIES;
				
				global $rdsql;			    
				
				$lv=[];
				
				$lv['temp_info']   = [];
				
				$field_name 	   = '';
				$parent_field_name = '';
				
				$lv['key_id']      = (@$T_SERIES['key_id'])?@$T_SERIES['key_id']:'';			    
				$lv['key']         =  @$_GET['key'];
				
				$lv['key_filter_content']  = ($lv['key_id'])?" AND $lv[key_id]='$lv[key]'":'';			    
				$lv['key_filter_content'].=(@$T_SERIES['key_filter'])?$T_SERIES['key_filter']:'';
				
				// prepare columns
				
				foreach($T_SERIES['data'] as $key=>$value){
				    
				   $is_child_addon =@$value['is_child_addon'];
				   
				   if(!$is_child_addon){
						$field_name.=(@$value['id'] ?? @$value['field']).' as '.$key.',';
				   }
				    
				} // for each column
				  
				//echo $parent_field_name;			       
			      
				$field_name  	          = substr($field_name,0,-1);
				
				$lv['select_right_query'] = ($T_SERIES['table'])?" FROM $T_SERIES[table]  WHERE 1=1 $lv[key_filter_content] ":"";
			     
				$lv['select_query'] 	  = " SELECT $field_name $lv[select_right_query]";
				
				if(@$T_SERIES['show_query']==1){
						
						echo $lv['select_query'];			
				}
			     
				$ex_query 	    = $rdsql->exec_query($lv['select_query']," Field does not matching!");
			     			     
				while($get_row = $rdsql->data_fetch_object($ex_query)){
				   
				  
						foreach($T_SERIES['data'] as $key => $value){
							
								@$value['data'] = @$value['cols'] ?? @$value['data'];
							   
								$is_child_addon = @$value['is_child_addon'];
								
								$filter_out    = @$value['filter_out'];
								#echo $define_data[$temp_i]['child_field'];
								
								if($is_child_addon){									   
								
								$temp[$key] = get_child_info(array('value' => $value,
								                                   'row'   => json_decode(json_encode($get_row), true)));									   
								
								}elseif(@$value['data'] && !$is_child_addon){
										
								    $temp[$key] = get_data_addon(array('field'=>$get_row->$key,'data'=>$value['data'],'filter_out'=>$filter_out));							   
								
								}
								
								else{  							   
								    //echo '===========>>>else'; 	
								    $temp[$key]  = ($filter_out)?$filter_out($get_row->$key):$get_row->$key;							   
								
								}
							   
						} // for each data 	
				
						array_push($lv['temp_info'],$temp);  						
				
				} // each result				
			     
				return $lv['temp_info'];    
			     
	        } // template
		
		
		
		
		# child addon case
		
		function get_child_info($param){
				
				global $rdsql;				
				
				$lv = [];
				$lv['temp_info'] 	= [];
				$child_info      	= $param['value'];
				$parent				= $param['row'];
				
				// prepare column
				
				$child_field = '';
				$child_key   = '';
				foreach($child_info['child_data'] as $child_key=>$child_value){
					   $child_field.=$child_value['field'].' as '.$child_value['key'].',';
					   $child_key.= $child_value['key'].',';		
				}				
				$field = substr($child_field,0,-1);
				
				// query
				
				$table	     = $child_info['table'];
				//$filter      = $child_info['key_filter'];
				
				$filter_parse  = function($m) use ($parent){
						return $parent[$m[4]];
				};
      
					// parent var replacement
				$filter     = preg_replace_callback('/(\[\[)(\w+)(\.)(\w+)(\]\])/i',
								     $filter_parse,
								     $child_info['key_filter']);
				
				// select
				$select_data = "SELECT $field  FROM $table WHERE 1=1 $filter";
				
				if(@$child_info['show_query']){						
						echo "<br>$select_data</br>";		
				} // end
				
				$other_ex_query = $rdsql->exec_query($select_data,"Field does not matching!");
												
				while($get_row = $rdsql->data_fetch_assoc($other_ex_query)){
					
						$temp =array();
						
						foreach($child_info['child_data'] as $child_key=>$child_value){	
						
								$filter_out 		   = @$child_value['filter_out'];						 
								
								if(@$child_value['data']){
									$temp[$child_value['key']] = get_data_addon(array('field'=> $get_row[$child_value['key']],
																					  'data' => $child_value['data'])
																			);							   
								}else{
									$temp[$child_value['key']] = (@$filter_out)?$filter_out($get_row[$child_value['key']]):$get_row[$child_value['key']]; 
								}
								
						} // each row
					    
						array_push($lv['temp_info'],$temp); 
				      
				} // each column
				
				return $lv['temp_info'];
			
		} // end of child info
		
		
		
		// data addon case
	
		function get_data_addon($param){
				
				$lv = [];
				global $rdsql;
				
				$lv['temp_info'] = [];
				$db_json_data = json_decode(json_encode($param['field']),true);				
				$db_json_data = json_decode($db_json_data,true);
				
				$define_data = $param['data'];
				
				if($db_json_data){
					
						for($data_i=0;$data_i<count($db_json_data);$data_i++ ){
								
								$temp = array();
								$col  = array();
								
								for($data_value_i=0;$data_value_i<count($define_data);$data_value_i++){
									
									$temp_i      = $data_value_i+1;
																
									$filter_out  = @$define_data[$temp_i]['filter_out'];
									
									$col['value'] = $db_json_data[$data_i][$data_value_i];
									$col['attr']  = $define_data[$temp_i];
									
									  
									if(@$col['attr']['field']){									
      
										// passing current value
										$col['field_neutral']     = preg_replace('/(\[\[)(this)(\]\])/i',
																						 $col['value'],
																						 $col['attr']['field']);
										
										$temp[$col['attr']['key']] = get_field_value(['rdsql'=>$rdsql,
																					  'field'=>$col['field_neutral']]);
										
									}else if(@$col['attr']['child_field']){
										
										$temp['param'] = array('key'		 => $col['value'], 
															   'child_field' => $col['attr']['child_field'], 
															   'child_key_id'=> $col['attr']['child_key_id'], 
															   'child_table' => $col['attr']['child_table'], 
															   'is_text'     => $col['attr']['is_text']);

										$temp[$col['attr']['key']] = get_entity_name($temp['param']);
									}	
										
									else{							
									    $temp[$col['attr']['key']]= ($filter_out)?$filter_out($col['value']):$col['value'];
									} 
								} // each inner column
								
								array_push($lv['temp_info'],$temp);	
						
						} // each data
				}
				
				return $lv['temp_info'];
		} // end
		
		
		
		//entity_name 
		function get_entity_name($param){
				
				global $rdsql;
				
				if($param['is_text']){
					$child_where = " AND  $param[child_key_id] like '%$param[key]%' ";		
				}else{
					$child_where = " AND  $param[child_key_id]= $param[key]";										
				}
				
				$lv['select_child_query'] = "SELECT $param[child_field] as child_value FROM $param[child_table] WHERE 1=1 $child_where ";
															
				$child_ex_query = $rdsql->exec_query($lv['select_child_query'],"Field does not matching!");
				
				$get_row = $rdsql->data_fetch_object($child_ex_query);
				
				return @$get_row->child_value; 

		} // entity name
		
		// get field value
		function get_field_value($param){
				
				$lv = [];
			
				$lv['field_query'] 		  = "SELECT $param[field] as field_value";
															
				$lv['field_query_result'] = $param['rdsql']->exec_query($lv['field_query'],"Field does not matching!");
				
				$lv['row'] 				  = $param['rdsql']->data_fetch_object($lv['field_query_result']);
				
				return @$lv['row']->field_value; 

		} // entity name
		
		
		
		// save content
		
		function save_content($param){
				
				$t_series = $param['t_series'];
				
				for($save_as_i=0; $save_as_i<count($t_series['save_as']); $save_as_i++){
						
						$param['save_as_i'] = $save_as_i;
						
						$t_series = $param['t_series'];
						
						$save_content 	= $t_series['save_as'][$save_as_i];
														
						$type      	= $save_content['type'];
						
						$file_name 	= $save_content['file_name'];
						
						$path  	   	=  $save_content['path'];				
						
						if($type == 'pdf'){
								
							//require_once("$param[lib_path]/comp/tcpdf3/config/tcpdf_config_alt.php");
							
							require_once("$param[lib_path]/comp/tcpdf3/tcpdf.php");
														
							class MYPDF extends TCPDF {
								
								var $get_param=array();
								
								function set_param($param){
									    //print_r($param);
								    $this->get_param=$param;
								}
										//Page header
										public function Header() {
											    
												$param = $this->get_param;
												
												$t_series = $param['t_series'];
												
												$header_info = @$t_series['save_as'][$param['save_as_i']]['header'];

												if(is_array($header_info)){
												
													if(array_key_exists('image_path',$header_info)){
													
														$logo = @$header_info['image_path'];
														
														if($logo){
															$image_file = K_PATH_IMAGES.$logo;	
														}
														else {
															$image_file = PDF_HEADER_LOGO.$param['lib_path'].'/images/nidhi_prayas.jpg';		
														}
														
														//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
														$this->Image($image_file, $header_info['margin_left'], $header_info['margin_top'],  $header_info['height'], '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
														// Set font
														$this->SetFont('helvetica', 'B', 20);
														// Title
														//echo $header_info['title'];
														$this->Cell(0, 15,(@$header_info['title']?$header_info['title']:''), 0, false, 'C', 0, '', 0, false, 'M', 'M');
													}

												} // is_array	
										}
								
										// Page footer
										public function Footer() {
										    
												$param = $this->get_param;
												
												$t_series = $param['t_series'];
																	
												if(array_key_exists('footer',
														     $t_series['save_as'][$param['save_as_i']])){
														
														$footer_info    = $t_series['save_as'][$param['save_as_i']]['footer'];
														
														$this->SetY(-15);
														// Set font
														$this->SetFont('helvetica', 'I', 8);
														
														$align = (@$footer_info['align'])?$footer_info['align']:'C';
														// Page number
														// Page number
														$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().$footer_info['glue'].$this->getAliasNbPages(), 0, false, "$align", 0, '', 0, false, 'T', 'M');
												}
										}
								} 
							
							// create new PDF document
							$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
							
							
							$pdf->set_param($param);
							// set document information
							$pdf->SetCreator(PDF_CREATOR);
							
							// set default header data
							$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
							
							// set header and footer fonts
							$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
							$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
							
							// set default monospaced font
							$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
							
							// set margins
							$pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
							$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
							$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
							
							// set auto page breaks
							$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
							
							
							
							// remove default header/footer
							if(@$t_series['save_as'][$save_as_i]['header']['is_disable']){
								$pdf->setPrintHeader(false);
							}
							
							if(@$t_series['save_as'][$save_as_i]['footer']['is_disable']){
								$pdf->setPrintFooter(false);
							}
								
							// set image scale factor
							$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
							
							// set some language-dependent strings (optional)
							if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
								require_once(dirname(__FILE__).'/lang/eng.php');
								$pdf->setLanguageArray($l);
							}
							
							
							// add a page
							$pdf->AddPage();
							
							// print a block of text using Write()
							$pdf->writeHTML($param['content'], true, false, true, false, ''); 
							ob_end_clean();
							
							//Close and output PDF document
							$pdf->Output($path.'/'.$file_name.'.'.$type, 'I');	
						
						}else{			 
							
							$fh = fopen($path.'/'.$file_name.'.'.$type, 'w') or die("can't open file");									      
							fwrite($fh,$param['content']);
							fclose($fh);
							
						} // end of other file
						
				} // each saveus
				
		} // end of save content
		
		
		 # page router
	        
		function action_router($p){
				
				
				$temp = array(
						
						't_series'=>function($p){
								
							$temp_path = "inc/data/".$p['page_id']."/".$p['page_name'].".php";	
							
							if(is_file($temp_path)){								
							     return array('action'=>$temp_path);
							}else{								
							     return array('action'=>false);
							} // end
							
						}, // end
						
						
						't'=>function($p){
								
							$p['page_name']=str_replace('__','/',$p['page_name']);	
								
						        $temp_path = $p['lib_path']."/def/".$p['page_name']."/".$p['page_id'].".php";
							
							if(is_file($temp_path)){
							     return array('action'=>$temp_path);						
							}else{								
							     return array('action'=>false);
							} // end
							
						}, // end
						
						'tx'=>function($p){
								
						        $p['page_name']=str_replace('__','/',$p['page_name']);
								
							$temp_path = "def/".$p['page_name']."/".$p['page_id'].".php";
							
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