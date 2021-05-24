<?php


        function d_addon($param){
            
			$lv = [ 'data' 								=> [],
										 'dkeys'								=> ['th','th_attr','td_attr','filter_out','js_call','is_sort'],
										 'input_type'   => [					'ITTX'=>['table'=>'varchar'],
																																																'ITNM'=>['table'=>'decimal'],
																																																'ITHD'=>['table'=>''],
																																																'ITLA'=>['table'=>''],
																																																'ITIG'=>['table'=>'num'],
																																																'ITTA'=>['table'=>'text'],
																																																'ITCE'=>['table'=>'text'],
																																																'ITTG'=>['table'=>'bool'],
																																																'ITTE'=>['table'=>'text'],
																																																'ITSL'=>['table'=>'varchar'],
																																																'ITFT'=>['table'=>'text'],
																																																'ITFD'=>['table'=>'varchar'],
																																																'ITFI'=>['table'=>'varchar'],
																																																'ITDT'=>['table'=>'date'],
																																																'ITRG'=>['table'=>'varchar'],
																																																'ITTB'=>['table'=>'varchar']],
																																								
																								'key_filter'				=> ''
																];
																
																$lv['counter'] = ['row'=>1];
																
																$lv['d_query'] = "SELECT
																																								token,
																																								get_ecb_av_addon_varchar(id,'APIT') as input_type,
																																								get_ecb_av_addon_varchar(id,'ADXN') as th,
																																								get_ecb_av_addon_varchar(id,'ADXH') as th_attr,
																																								get_ecb_av_addon_varchar(id,'ADXC') as td_attr,
																																								get_ecb_av_addon_varchar(id,'ADXF') as filter_out,
																																								get_ecb_av_addon_varchar(id,'ADXJ') as js_call,
																																								get_ecb_av_addon_varchar(id,'ADXQ') as col_func,
																																								get_ecb_av_addon_varchar(id,'ADXS') as is_sort
																																FROM
																																								entity_child_base
																																WHERE
																																								entity_code='$param[default_addon]' AND
																																								get_ecb_av_addon_varchar(id,'ADXI') = 1 ORDER BY get_ecb_av_addon_varchar(id,'ADLO')";
																			
																			
																$lv['d_query_result']      = $param['rdsql']->exec_query("$lv[d_query]","Error d_addon child");
																
																while($lv['d_query_info']  = $param['rdsql']->data_fetch_assoc($lv['d_query_result'])){
																	
																								$temp = [];
																								
																								
																								foreach($lv['dkeys'] as $dkey){
																									
																										if(@$lv['d_query_info'][$dkey]){
																																																																			$temp[$dkey]=$lv['d_query_info'][$dkey];	
																											}
																								}
																	
																								$desk_col = $lv['d_query_info'];
																	
																								if($desk_col['input_type'] && $desk_col['token']){
																									
											$temp['field']="get_exav_addon_".$lv['input_type'][$desk_col['input_type']]['table'].
																										"(id,'".$lv['d_query_info']['token']."')";
																										
																						if(@$desk_col['col_func']){
																							if(preg_match('/(this)/',$desk_col['col_func'])==0){
																							
																								$temp['field']=$desk_col['col_func'].'('.$temp['field'].')';
																							
																							}else{				
																				$temp['field']=str_replace('[[this]]',$temp['field'],$desk_col['col_func']);
																								//$temp['field']=$desk_col['col_func'].'('.$temp['field'].')';
																							}
																						}																										
										
																			$lv['data'][$lv['counter']['row']]=$temp;
																																
																										$lv['counter']['row']++;
																								}
																	
																} // end
																
																// filter
																if(@$param['default_addon']){																	
																	$lv['key_filter'] = " AND entity_code='$param[default_addon]'";			
																}
																
																
																return ['data'      =>$lv['data'],
																		'key_filter'=>$lv['key_filter']]; 
            
        } // end
	

?>	