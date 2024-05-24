/////////////////////////////////// Fibenis Grid ////////////////////////////////////////////////////////////

// load default data to grid
function loadFtdata (default_data, field_id){
			
	var lv = new Object();
	
	if(default_data.length!=0){
		
		lv['default_data'] = JSON.parse(default_data);
	
		for(var default_i = 0; default_i<lv['default_data'].length; default_i++){
			
			var row_i = default_i+1;
			
			for( var default_j = 0 ; default_j<lv['default_data'][default_i].length; default_j++){
			
					var col_i  = default_j+1;
					if(lv['default_data'][default_i][default_j].ms_name){
						
						lv['m_selecte_id'] =  lv['default_data'][default_i][default_j].id;
						lv['split_selecte_id'] = lv['m_selecte_id'].split(',');
						
						var select_array =[] ;
						for ( var data_i = 0; data_i <lv['split_selecte_id'].length; data_i++ ){
								if(lv['split_selecte_id'][data_i]){
									select_array.push(lv['split_selecte_id'][data_i]);
								}
						}	 
												
						$("#"+row_i+'_ft_'+col_i+'_'+field_id).val(select_array).prop("selected", true);							
						E_V_PASS(row_i+'_ft_'+col_i+'_'+field_id+'_hidden',lv['m_selecte_id']);	
						
					}
					else if(lv['default_data'][default_i][default_j].id){
						E_V_PASS(row_i+'_ft_'+col_i+'_'+field_id,lv['default_data'][default_i][default_j].name);
						E_V_PASS(row_i+'_ft_'+col_i+'_'+field_id+'_hidden',lv['default_data'][default_i][default_j].id);
					}
					else{
						E_V_PASS(row_i+'_ft_'+col_i+'_'+field_id,lv['default_data'][default_i][default_j]);
					}
					
			} // each column
		} // each row
	} // has length	
} // end of load


// get fiben grid data and set into fibenis form element id
function getfibenisTableDataById(field_id) {


	var temp = get_fibenis_table_data_engine(field_id);											
	E_V_PASS('X'+field_id,JSON.stringify(temp));											
} // end

// core function for extract fibenis grid value to array
function get_fibenis_table_data_engine(field_id){
	
	var table= document.getElementById("fibenis_table"+field_id);
	
	var tbody = table.getElementsByTagName("tbody")[0];				
	
	var row_count = tbody.rows.length;
	var eid ='';
	var eid_hidden ='';
	
	var get_data = [];
	
	for(row_count_i=0;row_count_i<row_count; row_count_i++){
		
		var colCount = tbody.rows[row_count_i].cells.length;
		
		//alert(colCount);
		var data = [];
	
		var temp_data = '';
		for(var col_i =0; col_i<colCount; col_i++) {
				
				var temp_cell = tbody.rows[row_count_i].cells[col_i];
				
				eid		   = temp_cell.dataset.eid;
				eid_hidden = eid+'_hidden';
				
				//ftautocomplete & ftMultipledropdown
				if((temp_cell.dataset.ftType == 'ftautocomplete') ||
				   (temp_cell.dataset.ftType == 'ftMultipledropdown')){
					data.push(GET_E_VALUE(eid_hidden)); 
				} //dropdown,text,date													
				else if(temp_cell.dataset.ftType != 'ftindex'){
					data.push(GET_E_VALUE(eid));
				}	
		}	
		
		//alert(data.length);
		if(data.length>0){
			get_data.push(data);
		} 
		
	} // end of row

	return get_data;	

} // end

// to capture multiple value selectbox into a realtive hidden value
function ft_selectbox_capture_selected_value(ele){
      
		var connector=',';
		var ele_length=ele.id.length;
		var ele_option='';
		var option_length = document.getElementById(ele.id).options.length;
		
		for(ei=0;ei<option_length;ei++){
			if(ele.options[ei].selected==true){
				ele_option+=ele.options[ei].value+''+connector;
			}
		}
		
		E_V_PASS(ele.id+'_hidden',ele_option);
		
} // end

// set value to multiple value selectbox
function M_E_V_PASS(ele_id,ele_data){
	
	   var split_ele_data  = ele_data.split(',');
		
		var temp_select = document.getElementById(ele_id);
		
		var option_length = document.getElementById(ele_id).options.length;
		
		var ele_length=option_length;
	
		var select_array =[] ;
		for ( var data_i = 0; data_i <split_ele_data.length; data_i++ ){
				if(split_ele_data[data_i]){
					select_array.push(split_ele_data[data_i]);
				}
			}	 
			
			$("#"+ele_id).val(select_array).prop("selected", true);
			
		     E_V_PASS(ele_id+'_hidden',ele_data);
} // end

// get fibenis data		 
function getfibenisTableData(ele,field_id,is_route_point,route_url) {
			
	var get_data = get_fibenis_table_data_engine(field_id);	
	E_V_PASS('X'+field_id,JSON.stringify(get_data));
	
	if(is_route_point){
	
		var ajxrqst = new ajax();		
		var req = '&field=detail&data='+JSON.stringify(get_data);

		//alert(req);
		ajxrqst.set_request(route_url,req);		
		var new_data = ajxrqst.send_get(function update_response(respopnse){return true;});
	}
				
} // end 

// new row addition
function ftNextrows(ele,field_id,max_no_row){
			
	var max_row = max_no_row ;
	
	//alert(max_row);

	var table = document.getElementById('fibenis_table'+field_id);
	
	var tbody = table.getElementsByTagName("tbody")[0];				
	
	var rowCount = tbody.rows.length;
	
	//if(max_row && rowCount )
	
	var rowIndex = rowCount+1;
	
	var ele_id = ele.id;

	var split_cuurent_row = ele_id.split('_');
	
	if((split_cuurent_row[0] == rowCount &&  rowCount < max_row)){			
		ftNextRowEngine(tbody,ele,field_id,rowCount,rowIndex );	
	} 
	else if(split_cuurent_row[0] == rowCount && max_row==0 ){	
		ftNextRowEngine(tbody,ele,field_id,rowCount,rowIndex );	
	} 				
					
} // end

// fibenis nextrow manipulation
function ftNextRowEngine(tbody,ele,field_id,rowCount,rowIndex ){

	

	var lv = {};
	var row = tbody.insertRow(rowCount);				
	var colCount = tbody.rows[0].cells.length;
	
	for(var col_i =0; col_i<colCount; col_i++) {
		
		var temp_cell = tbody.rows[0].cells[col_i];
		
		//alert(temp_cell.id);
		 
		var newcell	= row.insertCell(col_i);
		 
		//newcell.id  = temp_cell.id ;
		newcell.dataset.ftType = temp_cell.dataset.ftType;
		
		lv.next_row_count = (rowCount+1);
		
		if(temp_cell.dataset.ftType== 'ftindex'){
			newcell.innerHTML = rowIndex;
		}else{
			
			// eid
			lv.temp_eid 		   = temp_cell.dataset.eid;
			newcell.dataset.eid	   = lv.temp_eid.replace(/(1\_ft)/g,(lv.next_row_count)+'_ft');
			newcell.width  		   = temp_cell.width;
			
			// innerhtml						
			lv.temp_html		   = tbody.rows[0].cells[col_i].innerHTML;	

			lv.parent_id 		   = '1_ft_'+(col_i)+'_'+field_id;		
			lv.temp_id 			   = (lv.next_row_count)+'_ft_'+(col_i)+'_'+field_id;	
			lv.newcell_id		   = newcell.dataset.eid;
			
			// special case
			if(temp_cell.dataset.ftType=='ftMultipledropdown'){
			
				// dropdown with multiple value creation
				lv.dropdown 			= document.createElement('SELECT');
				lv.dropdown.id		    = lv.temp_id;
				lv.dropdown.name	    = lv.temp_id;
				lv.dropdown.dataset.parentId=field_id;
				lv.dropdown.multiple    = true;
				lv.dropdown.innerHTML 	= G.$(lv.parent_id).innerHTML;
				lv.dropdown.className	= 'selectpicker'; // for bootstarp-select

				// append to cell
				newcell.appendChild(lv.dropdown);
				
				lv.dropdown_element = document.getElementById(lv.temp_id);
				lv.dropdown_element.addEventListener('change', (event) => {
											console.log(JSON.stringify(event.target.id));								ft_selectbox_capture_selected_value(event.target);
											getfibenisTableData(event.target,event.target.dataset.parentId);
									});

				// hidden element creation
				lv.hidden 			= document.createElement('INPUT');
				lv.hidden.type		= 'hidden';
				lv.hidden.id		= lv.temp_id+'_hidden';
				lv.hidden.name		= lv.temp_id+'_hidden';
				lv.hidden.value		= '';
				newcell.appendChild(lv.hidden);
				
				$('#'+lv.temp_id).selectpicker('render');
				
			}else{
				newcell.innerHTML 	   = lv.temp_html.replace(/(1\_ft)/g,(lv.next_row_count)+'_ft');
				E_V_PASS(lv.temp_id,'');
				E_V_PASS(lv.temp_id+'_hidden','');
			}
		}
	} //for each row 	
	
	E_V_PASS('ft_last_row_no'+field_id, rowCount+1);
			
} // end

// fibenis grid prefill and new row creation 
function pre_fill_fiben_grid_form_data(param){

	var element = param.element;
	var lv	= {};
	
	E_V_PASS(element.id,decodeURI(encodeURI(element.value)));			
	var key_id = param.plugin_key;
													
	if(element.value){
	
		var fibenistableData= JSON.parse(decodeURI(encodeURI(element.value)));
		
		// cell creation			
		lv.table	= document.getElementById(`fibenis_table${key_id}`);			
		lv.tbody 	= lv.table.getElementsByTagName("tbody")[0];
		lv.rowCount = lv.tbody.rows.length;
		 
		lv.tempinsRow  =Number(lv.rowCount)-1;
		
		//index_
		for(var row_i =(lv.rowCount+1); row_i<=fibenistableData.length;row_i++){
				
			lv.tempinsRow = lv.tempinsRow+1;						 
			lv.row = lv.tbody.insertRow(lv.tempinsRow);
			
			
			lv.row
			lv.colCount = lv.tbody.rows[0].cells.length;
			
			// col count	
			for(var col_i =0; col_i<lv.colCount; col_i++){
			
			   // alert(col_i);
				lv.cell = lv.tbody.rows[0].cells[col_i];				
				lv.newCell	= lv.row.insertCell(col_i);	
				lv.newCell.dataset.ftType  = lv.cell.dataset.ftType;
				
				if(lv.cell.dataset.ftType == 'ftindex'){
					lv.newCell.innerHTML = row_i;
				}else{
					lv.temp_cell_id = lv.cell.dataset.eid;
					
					console.log('--CellID'+lv.temp_cell_id);
					
					lv.newCell.dataset.eid  = lv.temp_cell_id.replace(/(1\_ft)/g,(row_i)+'_ft');
					
					lv.tempRow =  	 lv.tbody.rows[0].cells[col_i].innerHTML;
					lv.newCell.innerHTML = lv.tempRow.replace(/(1\_ft)/g,(row_i)+'_ft')
				}  
			} // each column
				
			E_V_PASS('ft_last_row_no', row_i);
						   
		} // row traverse
		
		// data fill			
		var fibenTableRequest = [];
		var fibenTableColLen  = fibenistableData[0].length;
		var cell ={};
		
		for(row_i = 0; row_i<fibenistableData.length;  row_i++){
				
				cell.row_id=row_i+1;
				
				for(col_idx=0;col_idx<fibenTableColLen;col_idx++){
					
						cell.col_id=col_idx+1;
						cell.value= fibenistableData[row_i][col_idx];
						
						cell.col_ele = G.$(`ft_col_${cell.col_id}_${key_id}`);
						
						//console.log(`ft_col_${cell.col_id}_${key_id}`+'--'+G.$(`ft_col_${cell.col_id}_${key_id}`));
						
						var temp_key = `${cell.row_id}_ft_${cell.col_id}_${key_id}`;
						
						if(cell.col_ele.dataset.ftType=='ftautocomplete'){
						
							  if(cell.value){
									
									f_series.ajax.set_request(cell.col_ele.dataset.url,
															  `&prime=${cell.value}&service=fetch`);
															  
									f_series.ajax.send_get_addon(function(res,ele_id){
																	var lv = JSON.parse(res).pop();
																	E_V_PASS(ele_id,lv.name); 
																	E_V_PASS(ele_id+'_hidden',lv.id); 
																},temp_key);
								}
								else{
									  E_V_PASS(temp_key,''); 
									  E_V_PASS(temp_key+'_hidden',''); 
								
								}
						
						}else if(cell.col_ele.dataset.ftType=='ftMultipledropdown'){  
							M_E_V_PASS(temp_key,`${cell.value}`); 
						}else{
							E_V_PASS(temp_key,`${cell.value}`); 
						}
						
				} // end of col					   
		} // end of row
	} // value
} // end 
