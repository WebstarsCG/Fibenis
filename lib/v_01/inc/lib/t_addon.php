<?php


        function t_addon($param){
			
			global $T_ADDON_ACTION;
            
			$lv = [ 
					'template_cols'						=> [],
					'data' 								=> @$param['t_series']['data'],
					'template_content'					=> @$param['t_series']['template_content'],
					'entity_code'						=> @$param['default_addon']['entity_code'],
					'entity_tokens'						=> @$param['default_addon']['tokens'],
				    'dkeys'								=> ['token','input_type','sn'],
										 
					'input_type'   						=> ['ITTX'=>['table'=>'varchar'],
															'ITNM'=>['table'=>'decimal'],
															'ITHD'=>['table'=>''],
															'ITLA'=>['table'=>''],
															'ITIG'=>['table'=>'num'],
															'ITTA'=>['table'=>'text'],
															'ITCE'=>['table'=>'text'],
															'ITTG'=>['table'=>'bool'],
															'ITTE'=>['table'=>'text'],
															'ITSL'=>['table'=>'varchar'],									
															'ITML'=>['table'=>'varchar'],
															'ITFT'=>['table'=>'text'],
															'ITFD'=>['table'=>'varchar'],
															'ITFI'=>['table'=>'varchar'],
															'ITDT'=>['table'=>'date'],
															'ITRG'=>['table'=>'varchar'],
															'ITTB'=>['table'=>'varchar'],
															'ITCB'=>['table'=>'text'],
															'ITUQ'=>['table'=>'vc128uniq']
														],
					'key_filter'						=> ''
				];
																
				$lv['counter'] = ['row'=>1];
				
				$lv['token_filter'] = (@$lv['entity_tokens'])?"AND token IN(".implode(',',
																		array_map(function($a){return "'$a'";},
																				  $lv['entity_tokens'])
																		).")":''; 
			
																
				$lv['t_query'] = "SELECT
											token,
											get_ecb_av_addon_varchar(id,'APIT') as input_type,											
											sn,
											get_ecb_av_addon_varchar(id,'APTN') as tg_on_label,
											get_ecb_av_addon_varchar(id,'APTF') as tg_off_label,
											get_ecb_av_addon_varchar(id,'APSL') as select_option,
											get_ecb_av_addon_varchar(id,'APFO') as grid_detail,
											get_ecb_av_addon_varchar(id,'ADXQ') as col_func

								FROM
											entity_child_base
								WHERE
											entity_code='$lv[entity_code]' $lv[token_filter]
                      									AND is_active = 1 
								ORDER BY 
											line_order";

							
				$lv['t_query_result']      = $param['rdsql']->exec_query("$lv[t_query]","Error t_addon child");
				$lv['t_row_count']		   = 0;
				
				// each field
				while($lv['t_query_info']  = $param['rdsql']->data_fetch_assoc($lv['t_query_result'])){
					
						$col = [];						
						$lv['token'] = $lv['t_query_info']['token'];						
						$collate_col = $lv['t_query_info'];
						$lv['t_row_count']++;

						$lv['t_row_odd_even'] = (($lv['t_row_count']%2)==0)?'even':'odd';
 
						if($collate_col['input_type'] && $collate_col['token']){
							
							if(@$lv['input_type'][$collate_col['input_type']]['table']){
							
								$col['field']="get_exav_addon_".$lv['input_type'][$collate_col['input_type']]['table'].
																"(id,'".$lv['t_query_info']['token']."')";
							}else{
								$col['field']= "'0'";	
							}
							
							if(@$T_ADDON_ACTION[$collate_col['input_type']]){
								$col=$T_ADDON_ACTION[$collate_col['input_type']]($col,$lv['t_query_info']);
							}																						

							$lv['data'][$lv['token']."_label"]=['field'=>"'".$lv['t_query_info']['sn']."'"];
							
							if(@$col['template_content_text']){

								$lv['col_template']="<table class=\"table fbn-tbl-inner\" cellpadding=\"5px\">".
								                            "$col[template_heading_text]".   
															"<TMPL_IF $lv[token]><TMPL_LOOP $lv[token]>$col[template_content_text]</TMPL_LOOP></TMPL_IF>".
													"</table>";
								
								unset($col['template_heading_text']);
								unset($col['template_content_text']);
																
							}else if(@$col['check_box']){
								$lv['col_template'] = "<div id='element_area_$lv[token]'></div><input type='hidden' id='X$lv[token]_multistate' name='X$lv[token]_multistate' value='1'>
															<input type='hidden' id='X$lv[token]_maxstate' name='X$lv[token]_maxstate' value='3'>	
														<script>f_series.setCheckbox('$lv[token]');
															$(document).ready(function(){	
																f_series.setCheckboxRadioValue('$lv[token]','<TMPL_VAR $lv[token]>');
															});
														</script>";
								unset($col['check_box']);
							}else{
								$lv['col_template']="<TMPL_IF $lv[token]><TMPL_VAR $lv[token]><TMPL_ELSE><span class=\"na\">NA</span></TMPL_IF>";
							}
							
							$lv['data'][$lv['token']]=$col;

																 
					  $lv['template_col_content'] = (@$col['is_heading'])?"<tr class=\"$lv[token]\">\n".
													 "<!---<div class=\"template\">$lv[col_template]</div>--->".
													 "<th  colspan=\"2\"><TMPL_VAR $lv[token]_label></th></tr>\n":
													 "<tr class=\"$lv[token] $lv[t_row_odd_even]\">\n".
														"\t<td class=\"l\"><TMPL_VAR $lv[token]_label></td>\n".
														"\t<td class=\"v\">$lv[col_template]</td>\n".
													 "</tr>\n";
							array_push($lv['template_cols'],$lv['template_col_content']);
							$lv['counter']['row']++;
							
						} // end of valid input
					
				} // end of each field

							
				$lv['template_cols_text'] = implode('',$lv['template_cols']);	
				
				$lv['template_content']   = ((@$lv['template_content'])?(@$lv['template_content'].$lv['template_cols_text']):
																		$lv['template_cols_text']);

				$lv['template_content']		= "<table class=\"table col-md-12  fbn-table-to-div table-striped\" border=\"0\" cellpadding=\"5px\" data-id=''>".								"$lv[template_content]</table>";																			
							
				return ['data'      =>$lv['data'],				
						'template_content'=>$lv['template_content']
						];

        } // end
	
	
		$T_ADDON_ACTION = [];
		
		$T_ADDON_ACTION['ITHD'] = function($col,$attr){
			$col['is_heading'] = 1;			
			$col['field']	   ="'0'";				
			return $col;
		}; // end
		
		$T_ADDON_ACTION['ITTG'] = function($col,$attr){
			
			$col['filter_out']= function($in){
													$lv=[];
													$lv['on_label'] = 'Yes';
													$lv['off_label'] = 'No';
													
													$lv['status'] = ($in==1)?$lv['on_label']:$lv['off_label'];		
													
													return "<div class=\"$lv[status]\">$lv[status]</div>"; 
								}; // end
								
			return $col;				
			
		}; // end		
		
		$T_ADDON_ACTION['ITSL'] = function($col,$attr){
		
			$lv = [];
			
			$lv['field'] = $col['field'];
			
			$lv['select_option'] = json_decode($attr['select_option'],true);
			
			$lv['select_option_table'] = $lv['select_option'][0][0];
			
			$lv['select_option_table_lc'] = strtolower($lv['select_option'][0][0]);
			
			
			if($lv['select_option_table_lc']=='entity_child_base'){
				$col['field']="get_ecb_sn_by_token($col[field])";
			}else if($lv['select_option_table_lc']=='entity_child'){
				
				if(@$attr['col_func']){
								
								
								// get_exav_addon_varchar([[this]],'FTTX') ->  get_exav_addon_varchar(<current_result>,'FTTX')			
									$col['field']=str_replace('[[this]]',$col['field'],$attr['col_func']);									
								
							}																										

				//$col['field']="get_ecb_sn_by_token($col[field])";
				
			}
			
			return $col;				
			
		}; // end
		
		$T_ADDON_ACTION['ITML'] = function($col,$attr){
						
			$lv = [];
			
			$lv['field'] = $col['field'];
			
			$lv['select_option'] = json_decode($attr['select_option'],true);
			
			$lv['select_option_table'] = $lv['select_option'][0][0];
			
			$lv['select_option_table_lc'] = strtolower($lv['select_option'][0][0]);
			
			//SELECT GROUP_CONCAT(sn) FROM entity_child_base WHERE  token IN('TKBDGEN','TKBDHDU')
			
			if($lv['select_option_table_lc']=='entity_child_base'){
				
				$lv['tokens'] = explode(',',$col['field']);	
				$lv['tokens_quoted'] = array_map(function($a){ return "'$a'";},$lv['tokens']);				
				$lv['tokens_neutralized'] = implode(',',$lv['tokens_quoted']);	
				
				$col['filter_out'] = function($in){
					
					$lv= [];
					
					global $G;
					
					$lv['tokens'] = explode(',',$in);	
					$lv['tokens_quoted'] = array_map(function($a){ return "'$a'";},$lv['tokens']);				
				    $lv['tokens_neutralized'] = implode(',',$lv['tokens_quoted']);	
					
					return $G->get_one_column(['table'=>'entity_child_base',
												   'field'=>'group_concat(sn)',
												   'manipulation'=>" WHERE token IN($lv[tokens_neutralized])"]);
					
				};
			
			} // end
			
			return $col;				
			
		}; // end
		
		
		$T_ADDON_ACTION['ITDT'] = function($col,$attr){		
		
			$col['field']="date_format($col[field],'%d-%b-%Y')";			
			return $col;				
			
		}; // end
		
		
		$T_ADDON_ACTION['ITFT'] = function($col,$attr){		
		
			$lv= ['grid_columns'    =>[],
				  'grid_row_counter'=>1,
				  'heading'			=>[],
				  'template_content'=>[]
				 ];
		
			$attr['grid_detail'] = json_decode($attr['grid_detail'],true);			
			
			array_push($lv['heading'],'<tr>');
			array_push($lv['template_content'],"<TMPL_IF C_$lv[grid_row_counter]><tr>");

			
			// parse grid detail
			foreach($attr['grid_detail'] as $grid_index=>$grid_row){
				
				list($lv['label'],$lv['width'],$lv['input_type']) = $grid_row;
				
				if($lv['label'] && $lv['width'] && $lv['input_type']){
					
					$lv['col_key'] = "C_".$lv['grid_row_counter'];
					
					// field
					$lv['grid_columns'][$lv['grid_row_counter']] = array('key'=>$lv['col_key']); 
		
					// column
					array_push($lv['heading'],"<th>$lv[label]</th>");

					// template construction					
					array_push($lv['template_content'],"<td><TMPL_VAR $lv[col_key]></td>");
					
					$lv['grid_row_counter']++;					
				}
				
			} // end of grid 
			

			array_push($lv['template_content'],'</tr></TMPL_IF>');
			array_push($lv['heading'],"</tr>");			
			
			$col['data'] = $lv['grid_columns'];
			$col['template_heading_text'] = implode('',$lv['heading']);
			$col['template_content_text'] = implode('',$lv['template_content']);
			
			return $col;				
			
		}; // end
	

		$T_ADDON_ACTION['ITCB'] = function($col,$attr){		
		
			$col['check_box']=1;
			return $col;				
			
		}; // end

?>	