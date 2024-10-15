<?php	
		
		$FILTER = array();
				
		function filter_circle($data_in,$style){
		
		return 		"<span class='fa-stack fa-lg'>
					<i class='fa fa-circle $style fa-stack-2x'></i>
					<i class='fa fa-stack-1x fa-inverse'>$data_in</i>
			        </span>";
		}
		
		
		
		function filter_square($data_in,$style){
		
		return 		"<span class='fa-stack fa-lg'>
					<i class='fa fa-square $style fa-stack-2x'></i>
					<i class='fa fa-stack-1x fa-inverse'>$data_in</i>
			        </span>";
		}
		
		$FILTER['range'] = function($data_in){				
				$temp = json_decode($data_in);				
				return (($temp[0]) && ($temp[1]))?$temp[0].' - '.$temp[1]:$temp[0].$temp[1];				
		};
		
		
		$FILTER['twin_box'] = function($data_in){				
				$temp = json_decode($data_in);				
				return $temp[0].' '.$temp[1];				
		};	
		
		$FILTER['circle_red'] = function($data_in){				
				return filter_circle($data_in,'clr_red b'); 
		};
		
		$FILTER['circle_green'] = function($data_in){				
				return filter_circle($data_in,'clr_green b'); 
		};
		
		$FILTER['circle_primary'] = function($data_in){				
				return filter_circle($data_in,'clr_pri b'); 
		};
		
		$FILTER['circle_secondary'] = function($data_in){				
				return filter_circle($data_in,'clr_sec b'); 
		};
		
		$FILTER['square_red'] = function($data_in){				
				return filter_square($data_in,'clr_red b'); 
		};
		
		$FILTER['square_green'] = function($data_in){				
				return filter_square($data_in,'clr_green b'); 
		};
		
		$FILTER['square_primary'] = function($data_in){				
				return filter_square($data_in,'clr_pri b'); 
		};
		
		$FILTER['square_secondary'] = function($data_in){				
				return filter_square($data_in,'clr_sec b '); 
		};
		
		$FILTER['avoid_empty_zero'] = function($data_in){
				
				$data_in = preg_replace('/\s/','',$data_in);       				
				return ((strlen($data_in)>0)?1:0);
		};
		
		$FILTER['code_editor_neutral'] = function($data_in){				
				return preg_replace('/\//','\/',$data_in);		
		};
		$FILTER['img_to_base64']=function($data_in){
			
			if(($data_in!=null) && ($data_in!='')){
				
				    $lv=[];
			
					 $lv['file_path'] = $data_in;
					 $lv['file_type'] = pathinfo($lv['file_path'], PATHINFO_EXTENSION);
					 
				if(is_file($lv['file_path'])){
					 $lv['file_data'] = file_get_contents($lv['file_path']);
					 $lv['base_64_data']=base64_encode($lv['file_data']);
					 $lv['img_src_base_64'] = 'data:image/' .$lv['file_type']. ';base64,'.$lv['base_64_data'];

					 return $lv['img_src_base_64'];
				}
				else
					return null;
            }
			else
				return null;
		};
		$FILTER['secure_doc'] = function($data_in){
				
				if(($data_in!=null)&&($data_in!='')){
				
						global $G,$PASS_ID,$USER_ID;
				
						$lv = [];
				
						$lv['trans_key']=time().rand().$PASS_ID;
						
						$lv['data'] = $G->encrypt($data_in,$lv['trans_key']);
						
						
						$lv['temp_req'] = json_encode([ 'user_id'     	=>      $USER_ID,
										'pass_id'	=>	$PASS_ID,
										'trans_key'	=>	$lv['trans_key'],
										'data'           =>      $lv['data']]);
				    
						
				    
						$lv['req']=$G->encrypt($lv['temp_req'],$lv['trans_key']);
						
						
						$lv['data_in'] = 'router.php?series=a&action=entity_child&token=SEUR&req='.$lv['req'].
								 '&trans_key='.$lv['trans_key'];
								
							
						return $lv['data_in'];
				}else{
				
						return null;		
				}
						
		};

		$FILTER['timestamp_to_dbyt'] = function($data_in){
			return date_format(date_create($data_in),'d-M-y H:i:s');
		};

		$FILTER['iso_ymd_to_dMy'] = function($data_in){
			return date_format(date_create($data_in),'d-M-y');
		};

		$FILTER['nospace'] = function($din){
			return preg_replace("/\s/i",'',$din);
		};

		$FILTER['digit_in'] = function($din){
			return preg_replace("/\D/i",'',$din);
		};

		$FILTER['alpha_in'] = function($din){
			return preg_replace("/[^a-zA-Z]/i",'',$din);
		};

		$FILTER['csv_to_qcsv'] = function($din){ 
										
			if($din!=null && strlen($din)>0){

				return implode(',',
							   array_map(function($item){ return "'$item'";  },
							  			 explode(',',$din))
						);  
			}else{
				return '';
			}     
		};
		
		
		
?>
