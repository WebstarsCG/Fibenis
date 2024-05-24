/* FUNCTION LIST FOR CG */

		//
		
		var D=document;
		
		var TEMP=new Array();		

	       // Getting a elements selected index
		
		function select_index(element){

				 return element.selectedIndex;
		}
		
	 	
		// Selecting a Text Against a List Box - option text 
		
		function select_match(text,element){
			
			   for(var ei=0;ei<element.length;ei++){
		
						if(element.options[ei].text==text){
							
							   element.selectedIndex=ei;
							   return ei;
							   ei=ele_len+1;
							}				 
					 }	
		} 
		
		
		  // for numbering the rows
	   
	   function Page_Number(obj){
		      
		      this.current_page   = obj.current_page,
		      
		      this.items_per_page = obj.items_per_page,
		     
		      this.set_item_number = function(current_index){
			 
				 return  (current_index+(this.items_per_page *(this.current_page-1)));  
		      } // end
		      
		      this.write_item_number = function(current_index){
			 
				 return this.set_item_number(current_index);
		      } // end
		      
	   } // page number
		
		
		
		
		//Selecting a Text Against a List Box - option value
		function select_match_value(value,element)
		{	
     		   
			   for(var ei=0;ei<element.length;ei++)
    			  {
					  
				//	alert(  element.length+'....'+element.options[ei].value+'...'+value);
					  
						if(element.options[ei].value==value)
					        {
							   //element.selectedIndex=ei;
							   element.options[ei].selected=true;
							   return ei;
							   ei=ele_len+1;	  	   
					        }				 
				 }	
		}





		//Selecting a Text Against a List Box - option label
		function select_match_value_or_text(value,text,element)
		{
   				   var value_flag=0;
      
				   for(var ei=0;ei<element.length;ei++)
				     {
							if(element.options[ei].value==value)
								{
                					value_flag=1;              
					 			    element.selectedIndex=ei;
								    return ei;
								    ei=ele_len+1;
								}				 
     				}
     
				   if(value_flag==0){ select_match(text,element); }
		}
		
		      // return element
		      
		      function get_select_match_value_element(value,element){	
     		   
				 for(var ei=0;ei<element.length;ei++){
					    
					    if(element.options[ei].value==value){
						       
						       element.options[ei].selected=true;
						       return element.options[ei];
					    }				 
				 }
				 
				 return null;
		      
		      } // end
		
		      // option transfer
		      function select_option_transfer_by_value(parent,child,opt_values) {
				 
				 var lv = {};
				 
				 lv.opt_values = opt_values.split(',');
				 lv.matches      = [];
				 
				 for(var val_idx in lv.opt_values) {
					    
					    lv.match_option = get_select_match_value_element(lv.opt_values[val_idx],parent);    
					    
					    if (lv.match_option!=null) {
						       lv.temp_opt       = document.createElement('OPTION');
						       lv.temp_opt.value = lv.match_option.value;
						       lv.temp_opt.text  = lv.match_option.text;
						       
						       child.appendChild(lv.temp_opt);
						       parent.removeChild(lv.match_option);
					    
					    } // if options exist
					    
				 } // each value
				 
		      } // end
		

        //Selecting a Text Against a series of list box. except the current 
		// 1 -> value to be matched
		// 2 -> element prefix
		// 3 -> Number of element
		// 4 -> Expect cuurent elememnt
		function select_match_value_series(value,element_id_prefix,element_count,current_element)
		{	
                
				for(var i=1;i<=element_count;i++)
				{
					  if(document.getElementById(element_id_prefix+i).id!=current_element.id)
					  {
						  		  select_match_value(value,document.getElementById(element_id_prefix+i));
					  }
				}

		}
		
		
		function select_all_match_value_series(value,element_id_prefix,element_count,current_element)
		{	
                
				for(var i=1;i<=element_count;i++)
				{
					  if(document.getElementById(element_id_prefix+i).id)
					  {
						  		  select_match_value(value,document.getElementById(element_id_prefix+i));
					  }
				}

		}

        
		//Cheking a text against a select box
		function check_select_match(text,element)
		{
			
			   for(var ei=0;ei<element.length;ei++)
        			 {
		      
						if(element.options[ei].text==text)
							{
							   return 1;
							   
							}				 
					 }
			  
			  return 0;	 
		}
	
		//Getting a list box's selected index value
		function select_index_value(element)
		{
		     return element.options[element.selectedIndex].value;
		}
		
		
		

        //Getting a list box's selected index title
		function select_index_text(element)
		{
		   return element.options[element.selectedIndex].text;
		} 
		 

        //Getting a list box's selected index label	
		function select_index_label(element)
		{
		   return element.options[element.selectedIndex].label;
		}
		
		//Getting a list box's selected index title
		function select_index_title(element)
		{
		   return element.options[element.selectedIndex].title;
		}
				
			
	   // Assigning a list box's selected index value to an element
		function select_index_value_pass(element,target)
		{
		   target.value=select_index_value(element);
		}

		
		// Getting select option label title & pass it to another element
		function select_index_text_pass(element,target)
		{
		   target.value=element.options[element.selectedIndex].text;
		}


		// Assigning a list box's selected index label to an element
		function select_index_label_pass(element,target)
		{		
		   target.value=select_index_label(element);
 		}
		
		// Getting select option label title & pass it to another element
		function select_index_title_pass(element,target)
		{
		   target.value=select_index_title(element);
		}


		//Function removing all
		function remove_all(element)
		{
		    // Element Length
		    var e_len=element.length;
			
			/* before - for(var ei=1;ei=<e_len;ei++) --- Change by param on 24-1-2012 */
			
			if(document.all){
				
				for(var ei=1;ei<=e_len;ei++)  {	   element.options.remove(1);    }		
				
			}else{
				
				for(var ei=0;ei<e_len;ei++)  {	   element.options.remove(1);    }		
				
			}
			
	    }
   
   
		// Function for removing options from a select box expect from it's first value   
		function remove_e_first(element)
	    {
		 	//Element Length
		    var e_len=element.length;
			
			for(var ei=1;ei<=e_len;ei++) {	   element.options.remove(1);    }
		}


		// Function for removing all the options in a select box   
		function remove_full(element)
		{
     	 	//Element Length
		    var e_len=element.length;
			
			 for(var ei=0;ei<=e_len;ei++) {	   element.options.remove(0);  }
			   
		}


		///////////////////////////////////////////////CLEAR_FOCUS ELEMENT ./////

           function clear_focus(element)
                      {
                                   element.value='';
                                   element.focus();
                      }

		  //ELEMENT BASED           
          
          function label_pass(sender,reciever)
          {
             document.getElementById(reciever).value=sender.label;
             
          }
          





////////////////////////////////////////////////Delete Check

function d_check(c_count,element_prefix)
{
        var total_elements=Number(c_count);
		
		var del_items='';
		var d_flag=0;
		

		
	 	for(var index=1;index<=total_elements;index++)
		{   
        			 
			 if(D.getElementById('c'+index).status==true)
			 	{
					del_items+='\n\t  '+D.getElementById(element_prefix+index).innerHTML;
					d_flag=1;
				}	 
			
		  
		}
	 
		if(d_flag==0)
		 {
			 window.alert("Please Check the element to delete ");
			 return false;
		 }
		 
		 
          var conform=window.confirm('Are Sure want to delete the following items \n' +del_items);
          
          if(conform==true)
          {
                      var conform=window.confirm('Are Sure very sure to delete the following items \n' +del_items);
          }
          
          return conform;
          


return true;

}
////////////////////////////////////////////////////////////////END OF DELETE JOB ///////////////////////////////////////////


        /////////////////    RADIO BOX   ////////////////////////////

         
		// Radio Apply 
		function radio_apply(element_id,effect)
		{
        		D.getElementById(element_id).checked=effect;
	           } 
        

		//Prefilling a Radio Box( Named in a series manner(1..2)) against a given value
		function radio_fill(count,element_prefix,fill_value)
		{
        		
				for(var ri=1;ri<=count;ri++)
		           {
	                    D.getElementById(element_prefix+ri).checked=(D.getElementById(element_prefix+ri).value==fill_value)?true:false;
                    
						//alert(D.getElementById(element_prefix+ri).checked);
					
    	                if(D.getElementById(element_prefix+ri).checked==true)
        	            { ri=count+1;}
        		   }
		}


        //Clearing a Radio Box/Check Box Selection's ( Named in a series manner(1..2)) 
		function clear_check(count,element_prefix)
		{	
        
				for(var ri=1;ri<=count;ri++)
		           {
        	            D.getElementById(element_prefix+ri).checked=false;
		           }	
		}

    


		//Prefilling a Check Box Group ( Named in a series manner(1..2)) against a given value set (value terminated by comma(,) )
		function check_fill(count,element_prefix,fill_value)
		{
        	    // Getting Into Array 
				
						var check_values=fill_value.split(',');

				// Getting Length
						
						var cv_length=check_values.length;
						
						
						
				
				
		        for(var ci=1;ci<=count;ci++)
         		  {
                				
					  var elem=D.getElementById(element_prefix+ci);
				  
					  for(var vi=0;vi<check_values.length;vi++)
                  		{
		                      		
									elem.checked=(elem.value==check_values[vi])?true:false;
        		              
							  if(elem.checked==true)
                		      { 
							  		vi=cv_length+1;
							  } 
							  
                        }
           		  }
				  
				  
       	}
		
		// get check box selections
		
		function get_checkbox_count_selected(element_prefix,count){
				
				 var l_v 		= new Array();
				 
				 l_v['element_count']   = count;
				 
				  l_v['selected_count'] = 0;
				 
				 for(var check_index=1; check_index <= l_v['element_count']; check_index++){
					 
					  if(document.getElementById(element_prefix+check_index).checked==true){

							l_v['selected_count']++;
					  }
				 }
				 
				 return l_v['selected_count'];
				 
		} // check box
		
		
		// get checkbox decimal
		function get_checkbox_status_int(ele){
			 
			return (ele.checked==true)?1:0;
		}

         
		// MULTIPLE SELECT  
		 

		//Applying a effect(true,false) to a multiple select box
	    function select_all_effect(element,effect,taker_id)
		{
				
	    		for(i=0;i<element.options.length;i++)
					{
						element.options[i].selected=effect;
					}
  			
		}
		
		
		//Applying a effect(true,false) to a multiple select box and getting the HTML values into ana HTML element concanted by ","
		
		function select_all_effect_get_element_text(element,effect,taker)
		{
			   
			  
			   var taker_string='';
			   
	    		for(var i=0;i<element.options.length;i++)
					{
						element.options[i].selected=effect;
						
						if(element.options[i].id)
						{
							taker.value+=document.getElementById(element.options[i].id).innerHTML+',';
						}
					}
		}



		// Selecting options in a multiple select box against a value set ( terminated by comma(,) )
		   // * Options named in a element_id + suffix of unique id
		function select_multiple_index(element_id,values)
		{
	    		  //window.alert(element_id+'....'+document.getElementById(element_id).id);
				  var element=document.getElementById(element_id);
				  select_all_effect(element,false);
		
		          var selected_values=values.split(',');
                  
				  for(var smi=0;smi<selected_values.length;smi++)
					{
			     			 
							   document.getElementById(element_id+'_'+selected_values[smi]).selected=true;
			  		}
	    }

		// select multiple index by text
		
		function select_multiple_index_value(element_id,values)
		{
	    		  //window.alert(element_id+'....'+document.getElementById(element_id).id);
				  var element=document.getElementById(element_id);
				  select_all_effect(element,false);
		
		          var selected_values=values.split(',');
                  
				  for(var smi=0;smi<selected_values.length;smi++)
					{
			     			 
							
							select_match_value(selected_values[smi],element);
			  		}
	    }


	// JavaScript Document


	// In this function performed the text  is going UP while press the up_button

			// parameter- pass the select_box ID  
  

	function select_up(txt) {   				 // function start 
					
		var element=document.getElementById(txt);
		var current_index=element.selectedIndex;

		if(current_index==-1) {
			 window.alert('Please Select...')
           }

		if(current_index==0) {        				 // if statement start 
			 window.alert('No More....');
           } 										// if statement end

           else {                    				// else start
			
				 var temp_value=element.options[current_index-1].value;
				  
				 var temp_text=element.options[current_index-1].text;
 
				 element.options[current_index-1].value=element.options[current_index].value;
				 element.options[current_index-1].text=element.options[current_index].text;
				 element.options[current_index].value=temp_value;
				 element.options[current_index].text=temp_text;
				 
				 element.options[current_index-1].selected=true;
				 element.options[current_index].selected=false;
				 
				} 									//else end 
	
     }												// function end
				



	// In this function performed the text  is going DOWN while press the down_button  

		// parameter- pass the select_box ID 

	function select_down(txt) {		//function start

		var s_len = document.getElementById(txt);

		var element=document.getElementById(txt);

		var current_index=element.selectedIndex;

		if(current_index==-1)  {
											
			window.alert('Please Select...')

		}

		if(current_index == s_len.length-1){ 		// if start			
														
			window.alert('No More....');
		}											// if end 

			else {

				var temp_value=element.options[current_index+1].value;
				var temp_text=element.options[current_index+1].text;

				element.options[current_index+1].value=element.options[current_index].value;
				element.options[current_index+1].text=element.options[current_index].text;

				element.options[current_index].value=temp_value;
				element.options[current_index].text=temp_text;
				
				element.options[current_index+1].selected=true;
				 element.options[current_index].selected=false;

   				}					           	 //else end 
	}											// function end
         



	
	




		 
		//Applying selection to multiple select box from a "DATASET" value
			//  * DATASET Row terminator [R]
			//	* DATASET Column terminator [C]
			//	* First column represents the  ELEMENT ID " SELCT MULTIPLE BOX -> ID"
			//	* Second column represents the " Values to be selected "
        
	
		
		
		function comm_extra_preset(value_set)
		{
			
		   var row_count=0;   	   
				   
		   
		//  window.alert(" Please Press Enter to Continue ");
		   	
			 var data_row=value_set.split("[R]");
			 
			 
			 data_row.pop();
           			 
			 
			 for(var di=0;di<data_row.length;di++)
			  {
			 	
				 row_count++;
					
				 var data_column=data_row[di].split("[C]");	                			
				 
				 
				 if(data_column[1]!='')
					 {
					 
						 if(data_column[1].indexOf(',')<0)
							 {
						//	     window.alert('....'+E_TYPE(data_column[0])+'..'+data_column[0]);
								 
								 if(E_TYPE(data_column[0])=="select-one")
								 {
								    select_match_value(data_column[1],document.getElementById(data_column[0]));
								 }
								 else if(E_TYPE(data_column[0])=="text")
								 {
									 E_V_PASS(data_column[0],data_column[1]);
								 }
								 else if( (E_TYPE(data_column[0])=="hidden") && (data_column[1].indexOf('[D]')!=-1) )
								 {
									
									var date_info=data_column[1].split('[D]');									
									/*window.alert(date_info[0]);
									window.alert(date_info[0].substring(0,4));
									window.alert(date_info[0].substring(4,6));
									window.alert(date_info[0].substring(6,8));*/	
									
									// Filling Year
									var year_element=data_column[0].replace(/row_/g,'year_');
									var year=new Number(date_info[0].substring(0,4));

									//select_match_value(year,document.getElementById(year_element));

									E_V_PASS(year_element,year);
																			   
								   // Filling Month
									var month_element=data_column[0].replace(/row_/g,'month_');
									var month=new Number(date_info[0].substring(4,6));
									select_match_value(month,document.getElementById(month_element));										   
									 
									// Filling Date
									var date_element=data_column[0].replace(/row_/g,'date_');
									var date=new Number(date_info[0].substring(6,8));
									select_match_value(date,document.getElementById(date_element));	
									
									E_V_PASS('row_'+row_count,data_column[1]);
									 
								 }
								 
								 
				
							 }
						 else
							 {
							 	        // repalcing usual row_digt to sel_mul_digit for internal engine
									 	var sel_mul=data_column[0].replace(/row_/g,'sel_mul_')
										select_multiple_index(sel_mul,data_column[1]);
										
										E_V_PASS('row_'+row_count,data_column[1]);
							 }
					 } // End avail of data checking
			  } // End of For
		} // End of Function
 

		
		//Applying selection to multiple select box from a "DATASET" value
			//  * DATASET Row terminator [R]
			//	* DATASET Column terminator [C]
			//	* First column represents the  ELEMENT ID " SELCT MULTIPLE BOX -> ID"
			//	* Second column represents the " Values to be selected "


		function dataset_from_select(element)
		{
       		 var data_row=element.options[element.selectedIndex].value.split("[R]");
			 
	   		 data_row.pop();

			 for(var di=0;di<data_row.length;di++)
			  {
			 	 var data_column=data_row[di].split("[C]");		
                 
				 if(data_column[1]!='')
					 {
					 
						 if(data_column[1].indexOf(',')<0)
							 {
							    
								 
								 if( (E_TYPE(data_column[0])=="select-one") || (E_TYPE(data_column[0])=="select-multiple"))
								 {
									 select_match_value(data_column[1],document.getElementById(data_column[0]));
									 fireEvent(document.getElementById(data_column[0]),'change');
								 }
								 
								 else if(E_TYPE(data_column[0])=="radio")
								 {
									 
									  radio_apply(data_column[0],true);
									  fireEvent(document.getElementById(data_column[0]),'click');
									 
								 }
								 
								 else if (E_TYPE(data_column[0])=="text")
								 {
									// select_match_value(data_column[1],document.getElementById(data_column[0]));
									 E_V_PASS(data_column[0],data_column[1]);
									 
									
									 
									 if(data_column[0].indexOf('range')!=-1)
									 {
										range_field_builder(); 
									 }
									 else
									 {
										 date_field_builder(); 
									 }
									 
								 }
								 
								 
							 }
						 else
							 {
							 		//Enable element
									select_multiple_index(data_column[0],data_column[1]);
									fireEvent(document.getElementById(data_column[0]),'change');
															
									
							 }
					 } // End avail of data checking
			  } // End of For
		} // End of Function

        
		
		//Firing A event
		function fireEvent(element,event)
		{
				
			    if (document.createEventObject)
				{
			        // dispatch for IE
				       var evt = document.createEventObject();
				       return element.fireEvent('on'+event,evt)
    			}
			    else
				{
			        // dispatch for firefox + others
			        var evt = document.createEvent("HTMLEvents");
			        evt.initEvent(event, true, true ); // event type,bubbling,cancelable
			        return !element.dispatchEvent(evt);
    			}
			}


		//////////////////////////////////////////Page heading
		
		// Drawing a page heading with a defined page style  
		function page_heading(heading)
		{
		    return '<table width="100%" class="page_h1" cellpadding="0" cellspacing="0" border="0"><tr><td>'+heading+'</td></tr></table><br>';
		}

		// Drawing a page heading with a defined page style  AND  with a Back link to a URL
		function page_heading_menu(heading,url)
		{
		    return '<table width="100%" class="page_h1" cellpadding="1" cellspacing="0" border="0"><tr><td width="80%">'+heading+'</td><td width="20%" align="right"> <a href="file:///C|/xampp/cgi-bin/media/%27%2Burl%2B%27">[ Back ]</a>&nbsp;&nbsp;&nbsp; </td></tr></table><br>';
		}

		// Drawing a page heading with a defined page style  AND  with a Close the window AND Refresh the parent window
		function page_heading_close(heading)
		{
		    document.write('<table width="100%" class="page_h1" cellpadding="1" cellspacing="0" border="0"><tr>'+
						   '<td width="80%">'+heading+'</td>'+
						   '<td width="20%" align="right" style="padding-top:15px;">'+
						   '<a   onmousemove="JavaScript:show_tip(\'Close Window\',event);"'+
						   '     onmouseout="JavaScript:hide_tip();"'+ 
						   '	  href="JavaScript:close_win()"  class="close_icon" ></a>'+
						   '&nbsp;&nbsp;&nbsp; </td></tr></table>');
		}


		//Drawing a page heading with a defined page style  AND  with a Close the child window
		function child_window_close(heading,url)
		{
		    return '<table width="100%" class="page_h1" cellpadding="1" cellspacing="0" border="0"><tr><td width="100%">'+heading+'</td><td width="20%" align="right"> <a href="JavaScript:close_win(;">[ Close ]</a>&nbsp;&nbsp;&nbsp; </td></tr></table><br>';
		}

		//Drawing a page heading with a defined page style  AND  with a Close the child window
		function close_current_refresh_parent(heading,url)
		{
		    return '<table width="100%" class="page_h1" cellpadding="1" cellspacing="0" border="0"><tr><td width="100%">'+heading+'</td><td width="20%" align="right"> <a href="JavaScript:close_win(;">[ Close ]</a>&nbsp;&nbsp;&nbsp; </td></tr></table><br>';
		}

		//Drawing a page heading with a defined page style  AND  with a Close the child window
		function close_current(heading,url)
		{
		    return '<table width="100%" class="page_h1" cellpadding="1" cellspacing="0" border="0"><tr><td width="100%">'+heading+'</td><td width="20%" align="right"> <a href="JavaScript:close_child(;">[ Close ]</a>&nbsp;&nbsp;&nbsp; </td></tr></table><br>';
		}

		//Drawing a page heading with a defined page style  AND  with a History Back Option
		function page_heading_history(heading)
		{
			    return '<table width="100%" class="page_h1" cellpadding="1" cellspacing="0" border="0"><tr><td width="80%">'+heading+'</td><td width="20%" align="right"> <a href="JavaScript:page_go(-1)">[ Back ]</a>&nbsp;&nbsp;&nbsp; </td></tr></table><br>';
		}


		// History back link
		function page_go(mile)
		{
			history.go(mile);
		}


		// Assigning a URL to a current window
		function web_go(url)
		{
			document.location.href=url;
		}


		// Assigning a URL to additon of existing address 
		function self_go(url)
		{
			document.URL=document.location.href+url;
		}
		
		
		// Assigning a URL to additon of existing address 
		function block_go(block_id)
		{
			document.location.href="#"+block_id;
		}


		// Writing a HTML Content
		function html(content)
		{
			return content;
		}


		/*
		//function return value statement
		function html_get(content)
		{
			return content;
		}
		*/


		// Opening a window with give URL AND in a default name AND given feature list
		function WS_open(theURL,winName,features) 
		{ 
			  window.moveTo(0,0); 
			  
			  var window_attributes=(features)?features:'width=1000,height=350,scrollbars=yes,left=0,top=0';
			  
			  window.open(theURL,'winmax',window_attributes);
		}

		// Opening a window in agiven URL AND given name and features
		function WS_show(theURL,winName,features) 
		{ 
  			  window.moveTo(0,0); 
			  
			  if(!winName){ winName='name';} 
			  var window_attributes=(features)?features:'width=1000,height=350,scrollbars=yes,left=0,top=0';
			  
			  window.open(theURL,winName,window_attributes);
		}
		
		// Opening a window in a given URL and Window Name and Features
		function WS_print(theURL,winName,features) 
		{ 
		//     alert(theURL+'.........'+winName+'....'+features);
		
  			  window.moveTo(0,0); 
			  
			  var window_attributes=(features)?features:'width=700,height=842,scrollbars=yes,left=0,top=0,menubar=yes';
			  
			  window.open(theURL,winName,window_attributes);
  		}


		// Closing the window AND refrishing the parent window
		function close_win()
		{
	 		   var cur_win=window.opener.location.href;	
			   window.opener.location.href=cur_win;
   	   		   self.close(); 
		}

		// Closing the window
		function close_child()
		{
				//  var cur_win=window.opener.location.href;	
			   //	window.opener.location.href=cur_win;
   	   		   self.close(); 
		}


		// Applying Hidding function for the elements passed
		function hide()
		{
			   for(var hi=0;hi<hide.arguments.length;hi++)
				   {
					      document.getElementById(hide.arguments[0]).style.visibility="hidden";
				   }  
  		}






// Modal window

				function modal_window(page,width,height,scroll){

						var pass_id=document.getElementById('PASS_ID').value;
						
						var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+pass_id:page+'&WIN=off&PASS_ID='+pass_id; 
		
						var w_width=(width)?width:1000;    // Window Width
						var w_height=(height)?height:600; // Window height 
		
						var cl=Math.floor(Math.random()*(10+1));
						
						var newWindow=window.open(url,cl,"scrollbars=yes,width="+w_width+",Height="+w_height+"");

						newWindow.moveTo(0,0);

				 }

				
				// Modal print window -> optimizaton needed

				function modal_window_print(page,width,height){

						var pass_id=document.getElementById('PASS_ID').value;
						
						var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+pass_id:page+'&WIN=off&PASS_ID='+pass_id; 
		
						var w_width=(width)?width:1000;    // Window Width
						var w_height=(height)?height:600; // Window height 
		
						var cl=Math.floor(Math.random()*(10+1));
						
						var newWindow=window.open(url,cl,"scrollbars=yes,menubar=yes,width="+w_width+",Height="+w_height+"");

						newWindow.moveTo(0,0);

				 }
				 
				 
				////////////////////// MODAL WINDOW ////////////////////////
				function Modal_Open(page,width,height,scroll){
				
							   
								
								var sess_id=document.getElementById('PASS_ID').value;
											 
								var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+sess_id:page+'&WIN=off&PASS_ID='+sess_id; 
				
								var w_width=(width)?width:1000;    // Window Width
								var w_height=(height)?height:600; // Window height 
				
								var cl=Math.floor(Math.random()*(10+1));
								
								var newWindow=window.open(url,cl,"width="+w_width+",Height="+w_height+",scrollbars=yes");
								newWindow.moveTo(0,0);
				 }


				////////////////////// MODAL WINDOW ////////////////////////
				function Modal_Full(page,width,height,scroll){
				
							   
								
								var sess_id=document.getElementById('PASS_ID').value;
											 
								var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+sess_id:page+'&WIN=off&PASS_ID='+sess_id; 
				
								var w_width=(width)?width:1000;    // Window Width
								var w_height=(height)?height:600; // Window height 
				
								var cl=Math.floor(Math.random()*(10+1));
								
								var newWindow=window.open(url,cl,"width="+w_width+",Height="+w_height+",scrollbars=yes,menubar=yes");
								newWindow.moveTo(0,0);
				 }
				 

				////////////////////// MODAL WINDOW ////////////////////////
				function Modal_Print(page,width,height,scroll){
				
							   
								
								var sess_id=document.getElementById('PASS_ID').value;
											 
								var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+sess_id:page+'&WIN=off&PASS_ID='+sess_id; 
				
								var w_width=(width)?width:1000;    // Window Width
								var w_height=(height)?height:600; // Window height 
				
								var cl=Math.floor(Math.random()*(10+1));
								
								var newWindow=window.open(url,cl,"menubar=yes,width="+w_width+",Height="+w_height+"");
								newWindow.moveTo(0,0);
				 }
				
				
				//////////////// MODleess ////////////////////////
				function MODAL_WIN(page,width,height){
				
								var sess_id=document.getElementById('PASS_ID').value;
								var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+sess_id:page+'&WIN=off&PASS_ID='+sess_id; 
				
								var w_width=(width)?width:1000;    // Window Width
								var w_height=(height)?height:600; // Window height 
				
								var cl=Math.floor(Math.random()*(5+1));
								
								var newWindow= window.showModalDialog(url,cl,"dialogWidth="+w_width+",dialogHeight="+w_height+"");
								newWindow.moveTo(0,0);
				 }
 
///////////////////////MAIN CLOSE //////////////////////////////////
function Main_Close(WIN)
{
     self.close();       
}

		//Child Window Close 
			// Closing the child window	
			
			function CHILD_CLOSE()
				{
					self.close();
				}


//////////////////// ADDING ELEMENT INTO PARENT PAGE ////////////////////////


//////////////// MODleess ////////////////////////
function MODAL_WIN(page,width,height){

                var sess_id=document.getElementById('PASS_ID').value;
                var url=(page.indexOf('?')==-1)?page+'?WIN=off&PASS_ID='+sess_id:page+'&WIN=off&PASS_ID='+sess_id; 

                var w_width=(width)?width:1000;    // Window Width
                var w_height=(height)?height:600; // Window height 

				var cl=Math.floor(Math.random()*(5+1));
				
				var newWindow= window.showModalDialog(url,cl,"dialogWidth="+w_width+",dialogHeight="+w_height+"");
				newWindow.moveTo(0,0);
 }
 
///////////////////////MAIN CLOSE //////////////////////////////////
function Main_Close(WIN)
{
     self.close();       
}

		//Child Window Close 
			// Closing the child window	
			
			function CHILD_CLOSE()
				{
					self.close();
				}


//////////////////// ADDING ELEMENT INTO PARENT PAGE ////////////////////////
//Function for addding a varaible into a select box froma child form that added nto database

function add_into_parent_sel(parent_area,parent,child_var)
{
   
  //Getting the element value
  var new_element=child_var.split(",");
  
  //Creating the value in openenr structure
  window.opener.document.getElementById(parent_area).innerHTML='<select id='+parent+' name='+parent+'>'+window.opener.document.getElementById(parent).innerHTML+'<option value='+new_element[0]+'>'+new_element[1]+'</option></select>';

}


function AIP_MUL_SEL_APPEND(parent_area,parent,child_var,element_function)
{
 		//Getting the element value
		var new_element=child_var.split(",");
   		
		//Element Function
    	element_function=(element_function)?element_function:'';
	
		//Creating the value in openenr structure
	    window.opener.document.getElementById(parent_area).innerHTML='<select id='+parent+' name='+parent+'   '+element_function+'>'+window.opener.document.getElementById(parent).innerHTML+'<option value='+new_element[0]+'>'+new_element[1]+'</option></select>';
  
}



function AIP_MUL_SEL_NEW(parent_area,parent,child_var,element_function)
{
    //Removing old  		
	remove_all(window.opener.document.getElementById(parent));

	//Select Type
//	select_type=(select_type)?select_type:'';
  		
	//Element Function
    element_function=(element_function)?element_function:'';
  
  	var element=child_var.split("#"); //Spliting Content
  
	var length=element.length-1; // Getting Length
  
    var option_list=''
  
    for(var i=0;i<length;i++)
    {
       var child_element=element[i].split('::');
       option_list+='<option value='+child_element[0]+' selected=true>'+child_element[1]+'</option>';     
    }
 
    //Creating the value in openenr structure
    window.opener.document.getElementById(parent_area).innerHTML='<select id='+parent+' name='+parent+' '+element_function+' class="FI_200" >'+window.opener.document.getElementById(parent).innerHTML+option_list+'</select>';
 
}


///////////////////////////////////////// AIP TEXT BOX ////////////////////////////////

function AIP_MUL_TEXT_NEW(parent_area,parent,child_var){
    
    //Getting the element value
    var new_element=child_var.split(",");
  
    //Creating the value in openenr structure
    window.opener.document.getElementById(parent_area).innerHTML='<input type="text" id="'+parent+'" name="'+parent+'" class="formInputMiniMedium" value="'+child_var+'" >';

} // end


//// AIP HTML


function AIP_HTML(parent,child){
	
	window.alert('...');

	window.opener.document.getElementById(parent).innerHTML=child;

}




/////////////////// ADDING ELEMENT INTO PARENT PAGE ////////////////////////





/////////////////////////////////////////////////////////////////   CHECK ERROR ///////////////////////////////////////////////////


var CHECK_ERROR_MESSAGE='';
var CHECK_ERROR_FLAG=new Array();

/// 0-> select text  1 -> text   2 -> Chekc box  3-> selectbox _fill   4-> radio box

check_reset();

//Default Variables
function check_reset()
{
	 CHECK_ERROR_MESSAGE='';
	 
	 
	 CHECK_ERROR_FLAG[0]=1;
	 
	 CHECK_ERROR_FLAG[1]=1;
	 
	 CHECK_ERROR_FLAG[2]=1;
	 
	 CHECK_ERROR_FLAG[3]=1;
	 
	 CHECK_ERROR_FLAG[4]=1;
} 



	// Select Test
	function selectTest()
	{
	   var argLength=selectTest.arguments.length;
	  
	   var select_error='';
	   
		  for(ai=0;ai<argLength;ai++)
		  {
			 
			 if(selectTest.arguments[ai].length==0)
			 {
				  select_error+='\n '+selectTest.arguments[ai].title;
			 }
			 
			 if( ((selectTest.arguments[ai].selectedIndex==0)&&(selectTest.arguments[ai].type!="select-multiple")) || (selectTest.arguments[ai].selectedIndex==-1))
			 {
				  //window.alert(selectTest.arguments[ai].selectedIndex+selectTest.arguments[ai].type);
				  select_error+='\n '+selectTest.arguments[ai].title;
			 }
		  }
	 
		  if(select_error!='')
			{
			   CHECK_ERROR_MESSAGE+='\n\nPlease Select the following elements :\n'+select_error;
			   CHECK_ERROR_FLAG[0]=0;
			   return false;
			}	   
	 
	 	return true;
	 
	}



	// Select Fill Test
	function selectFillTest()
	{
			var argLength=selectFillTest.arguments.length;
			var select_error='';
	   
	  		for(var ai=0;ai<argLength;ai++)
			{
				 if(selectFillTest.arguments[ai].length==0)
				 {
					  select_error+='\n '+selectFillTest.arguments[ai].label;
					 
					
				 }
			}
	
		    if(select_error!='')
			{
				 CHECK_ERROR_MESSAGE+='\nPlease Fill the following elements :'+select_error;
				 CHECK_ERROR_FLAG[3]=0;
				 return false;
			}
			 
			return true;
	}


	  // Text Test V2
	   function textTestV2(){
	     
		      var argLength=textTestV2.arguments.length;
		      
		      var select_error = '';
		      
		      var lv   	       = new Object({'param':''});
	      
		      lv.param         = textTestV2.arguments[0];
			  
		      lv.check_elements = lv.param.data;
		      
		      lv.refill_elements  = [];
		      lv.refill_headings  = {};
		     	
		      // for json method		       
		      if(lv.param.is_json==1){
				 
				 
				  
				 for(var x in lv.check_elements){					    
					  
					     // validation as true
					    
					    if(lv.check_elements[x].is_active==true){
						       
							  
						      
						       if (document.getElementById(x)!=undefined) {
								   
								  //code
								  lv.current_element = document.getElementById(x);								  
								  lv.ft              = G.isUndefined(lv.current_element.form_type,'FS');
						       
						       if(lv.current_element.tagName!="DIV") {
								  
								  lv.is_error = 0;
								  								  
								  lv.temp_last_divider_id=G.isUndefined(lv.current_element.dataset.lastDividerId,0);
								  
								  lv.temp_heading={"obj":lv.refill_headings,
								                   "key":lv.temp_last_divider_id};
								                   
								  
								  lv.refill_headings=G.isObjKey(lv.temp_heading);
								  
								  if(lv.current_element.dataset.inputType=='FT'){
									     
									     f_series.setInputMessage[lv.ft]({"element":lv.current_element,
										 "message":'',
										 "color"  :"clear"});
									     
									     if(alphanum_clean(lv.current_element.value).length==0){
											
											
											lv.refill_elements.push(lv.current_element);
											lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
											
											f_series.setInputMessage[lv.ft]({"element":lv.current_element,
																  "message":get_style({"style":"block txt_size_13 clr_red","content":"Kindly Fill it."}),
																  "color"  :"error"});
											
									     }else{
											//console.log('CV'+lv.current_element.value);
																						
											lv.fiben_table_data = JSON.parse(lv.current_element.value);
											
											lv.table_rows       = lv.fiben_table_data.length;
											
											lv.table_cols       = lv.fiben_table_data[0].length;
											
											//console.log('R'+lv.table_rows+'C'+lv.table_cols);
											
											lv.empty_rows       = 0;
											
											lv.filled_rows      = 0;
											
											lv.partial_filled_rows      = 0;
											
											lv.min_rows_to_fill = G.isUndefined(lv.current_element.dataset.minRowsToFill,lv.table_rows);
														
											lv.fiben_check_data = '';
											
											for (var ft_row in lv.fiben_table_data) {
												   
												   lv.has_column   = 0;
												   lv.is_no_column = 0;
												  												   
												   //each column
												   for (var ft_col in lv.fiben_table_data[ft_row]) {
													      
													      //alert(lv.fiben_table_data[ft_row][ft_col]);
													      
													      if(lv.fiben_table_data[ft_row][ft_col].replace(/\s+/g,'').length==0){													                
															lv.is_no_column++;
													      }else{
															lv.has_column++; 
													      }													      
													      
												   } // each column
												   
												   //console.log('R'+ft_row+'NC'+lv.is_no_column+'HC'+lv.has_column);
												   
												   if( (lv.is_no_column>0) && (lv.has_column>0)) {
													      
													      lv.partial_filled_rows++;
													      													      
												   }else if(lv.is_no_column==lv.table_cols) {
													      
													      lv.empty_rows++;
													      
												   }else if(lv.has_column==lv.table_cols) {
													      
													      lv.filled_rows++;
												   }
											
											}// each row
											
											
											// partial rows
											if (lv.partial_filled_rows>0){												
												  
												   lv.fiben_check_data+='<b>'+lv.partial_filled_rows+ '</b> rows seems filled partially. Kindly fill it fully<br>';   //code
												   lv.refill_elements.push(lv.current_element);													      
												   lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   
											}else if ((lv.min_rows_to_fill==lv.table_rows) &&
											          (lv.filled_rows<lv.min_rows_to_fill)
											          ){												   
												   
												   lv.fiben_check_data+='Kindly fill all the rows<br>';   //code
												   lv.refill_elements.push(lv.current_element);
												   lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   
											}else if( (lv.filled_rows>0) &&
											          (lv.filled_rows<lv.min_rows_to_fill) &&
											          (lv.min_rows_to_fill!=lv.table_rows) ) {
												   
												   lv.fiben_check_data+='Kinldy fill atleast '+lv.min_rows_to_fill+' rows<br>';   //code
												   lv.refill_elements.push(lv.current_element);
												   lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
											}
											
											//f_series.getElementMessageArea(lv.current_element).innerHTML=lv.fiben_check_data;
											if (lv.fiben_check_data.length>0) {
												   f_series.setInputMessage[lv.ft]({"element":lv.current_element,
																    "message":get_style({"style":"block txt_size_13 clr_red","content":lv.fiben_check_data}),
																    "color"  :"error"});
											}else{
												    elementFocusOut(lv.current_element);
												   
											}
										
											
											} // val
									     
									     }else if(lv.current_element.dataset.inputType=='DT'){ // date
											 
											 lv.current_show_element = G.$(x+'_SHOW');
											
											 if(lv.current_element.value.length==0){
												 
												  lv.refill_elements.push(lv.current_element);
												  lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   								  														 
												  f_series.setInputMessage[lv.ft]({"element":lv.current_show_element,
															 "message":"",
															 "color"  :"error"});
											 }else{ // check value
												f_series.setInputMessage[lv.ft]({"element":lv.current_show_element,
															 "message":'',
															 "color"  :"clear"});
											 }
											 
										 }else if(lv.current_element.type=='file'){ // file document
											
											//console.log('hidden_'+x+'--'+document.getElementById(('hidden_'+x)).value);
										   
											if( (lv.current_element.value.length==0) &&
											    (G.$('hidden_'+x).value.length==0)
											){
												   lv.refill_elements.push(lv.current_element);
												   lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   
												   f_series.setInputMessage[lv.ft]({"element":lv.current_element,
															 "message":"",
															 "color"  :"error"});
											}
											
									     }
									     else if( (((lv.current_element.tagName=="SELECT")) &&
										       (lv.current_element.value.length < 1 ||
											Number(lv.current_element.value)==0 ||
											lv.current_element.value=='NANA') &&
										        (lv.current_element.dataset.isFormat==undefined)
										       )
									     ){
																				
											lv.refill_elements.push(lv.current_element);
											lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
											
											f_series.setInputMessage[lv.ft]({"element":lv.current_element,
															 "message":get_style({"style":"block txt_size_13 clr_red","content":"Kindly select any available option."}),
															 "color"  :"error"});
									     }else if(lv.current_element.dataset.inputType=='CB'){ // checkbox
										 
											if(lv.current_element.value.length==0){
												   lv.refill_elements.push(lv.current_element);
												   lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   
												   f_series.setInputMessage[lv.ft]({"element":lv.current_element,
															 "message":get_style({"style":"block txt_size_13 clr_red","content":"Kindly select any option."}),
															 "color"  :"error"});
											}
										 
										 }else if(lv.current_element.tagName!="SELECT"){
																							   
											if(lv.current_element.dataset.isFormat!=undefined){												   
												   if(checkIsFormat(lv.current_element)==0){
													      
													     lv.refill_elements.push(lv.current_element);
													     lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   }
											}else{
												   if(checkIsMust(lv.current_element)==0){
													      
													      lv.refill_elements.push(lv.current_element);
													      lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
												   }
											}
									     }else{
											
											f_series.setInputMessage[lv.ft]({"element":lv.current_element,
															 "message":'',
															 "color"  :"clear"});
									     }
									    
								  } // end of element
						       
						       } // undefined loop
						       
					    } // if
					    
					    
				 } // each validate
				 
		      }else{
				 for(ai=0;ai<argLength;ai++){
					    
					    lv.is_error = 0;
					    
					    lv.current_element = textTestV2.arguments[ai];
					    
					    lv.temp_last_divider_id=lv.current_element.dataset.lastDividerId;
								  
					    lv.temp_heading={"obj":lv.refill_headings,
							     "key":lv.temp_last_divider_id};
							     
					     console.log('AI'+lv.current_element.id);
					     
					    lv.refill_headings=G.isObjKey(lv.temp_heading);
					    
					    if( ( ((textTestV2.arguments[ai]!=null) &&  (textTestV2.arguments[ai]!=undefined) && (textTestV2.arguments[ai].tagName!="SELECT")) && (textTestV2.arguments[ai].value.length < 1))  ||
						( ((textTestV2.arguments[ai]!=null) &&
						   (textTestV2.arguments[ai]!=undefined) &&
						   (textTestV2.arguments[ai].tagName=="SELECT")) &&
						   (textTestV2.arguments[ai].value.length < 1 ||
						    Number(textTestV2.arguments[ai].value)==0 ||
						    textTestV2.arguments[ai].value=='NANA')
						    )
					    ){
						       
						       lv.refill_elements.push(lv.current_element);
						       lv.refill_headings=G.isObjKeyCount(lv.temp_heading);
					    
					  
					    }
				 }   
			    
		      } // end
		      
		     
		     lv.heading_keys = Object.keys(lv.refill_headings);
			 lv.success_message = '<span class="clr_green txt_size_18 ">&nbsp;&#10004;&nbsp;</span>';
		     
		      
		      for (var hx in lv.heading_keys) {
				 
				 lv.temp_element = ELEMENT('X'+lv.heading_keys[hx]);
				 
				 console.log('X'+lv.heading_keys[hx]);
				 				 
				 if(lv.temp_element!=false) {
				
					    //code
					    lv.temp_message=(Number(lv.refill_headings[lv.heading_keys[hx]])==0)?'':'&nbsp;&nbsp;&nbsp;(&nbsp;<b class="txt_size_15">'+lv.refill_headings[lv.heading_keys[hx]]+'</b> inputs seems not filled fully. Kindly fill it.)';
					    
					    lv.ft = G.isUndefined(lv.temp_element.form_type,'FS');
						
    lv.display_message  = (lv.temp_message.length==0)?lv.success_message:((lv.temp_element.dataset.headingType=='TB')?get_style({"style":"txt_size_12 normal clr_red","content":'&nbsp;&#9888;&nbsp;'}):get_style({"style":"txt_size_11 normal clr_red","content":lv.temp_message}));
					    
					    f_series.setInputMessage[lv.ft]({"element":lv.temp_element,
									     //"message":get_style({"style":"txt_size_11 normal clr_red","content":lv.temp_message}),
									     "message":lv.display_message,
									     "color"  :((lv.temp_message.length>0)?'error':'clear')});
				 }
		      }
		      
		      return lv.refill_elements;
	      
	   } // function   


	// Text Test
	function textTest()
	{
	  
	  var argLength=textTest.arguments.length; 
	  
	
	 //alert('....'+textTest.arguments[0].value+'...'+textTest.arguments[1].value);
	
	   var select_error='';
	   
	   for(ai=0;ai<argLength;ai++)
		  {
		  		
					
			 if(textTest.arguments[ai].value.length<1)
			 {
				 //alert(textTest.arguments[ai].length+'..'+textTest.arguments[ai].selectedIndex);
				  select_error+='\n '+textTest.arguments[ai].title;
				   //alert(select_error);
			 }
		  }
	   if(select_error!='')
		 {
			 
		   CHECK_ERROR_MESSAGE+='\n\nPlease enter information for the following elements :\n'+select_error;
		   CHECK_ERROR_FLAG[1]=0;
		 }	   
		 
		 
	}


   // Check Box text
   function optionTest()
   {	
	   var argLength=optionTest.arguments.length;
	   
	   
	   var select_error='';
	   for(ai=0;ai<argLength;ai++)
		  {
			 if(optionTest.arguments[ai].length<1)
			 {
				  select_error+='\n '+optionTest.arguments[ai].label;
			 }
		  }
	  if(select_error!='')
		{
		   CHECK_ERROR_MESSAGE+='\n\nPlease add information for the following elements :'+select_error;
		   CHECK_ERROR_FLAG[2]=0;	
		   return false;
		}	   
	 return true;
	 
   }


	// Radio Check
	
	function radioTest(element)
	{
	        var radio_error='';
			
			var argLength=radioTest.arguments.length;
	   	    
			for(ai=0;ai<argLength;ai++)
	 		  {
				 if(arguments[ai].checked==false)
				 {
					 radio_error+='\n '+radioTest.arguments[ai].label;
				 }
			  }
				
			if(radio_error!='')
			{
				    CHECK_ERROR_MESSAGE+='\n\nPlease select the following radio elements :'+radio_error;
		   			CHECK_ERROR_FLAG[4]=0;	
				    return false;
			}
			
			return true;
	}


function CHECK_UNFILL()
{
     
	  var check_flag=CHECK_ERROR_FLAG[0]+CHECK_ERROR_FLAG[1]+CHECK_ERROR_FLAG[2];

	  if(check_flag<3)
		  {
		     window.alert(CHECK_ERROR_MESSAGE);
			 check_reset();		
			 return false;
		  }
	  	  
  	  
}


	function ask_once(message)
	{

		var answer=window.confirm(message);

		if(answer==true){
			return true;
		}
		else{
			return false;
		}
	
	}


	   // get validate response

	   function get_validate_response(){
	
		if(CHECK_ERROR_FLAG[1]<1){
	 
			 CHECK_ERROR_MESSAGE = '';				 
			 
			 CHECK_ERROR_FLAG[1] = 1;
				 
			 return false;
		}else{ 												
			return true;
		}
		
	} // end


////////////////////////////////////////////////////////////////// END OF CHECK ERROR /////////////////////////////////////////////////////

/////////////////FILTER ACT //////////////////////////////////////////////////////////
//1- > URL 2 -> filter elements
function show_filter_act()
{
    //spliting url part
	
	//Short namin function
	var FUNC=show_filter_act; 
	
	//var URL CUSTOM STRING
	var url_string='?';
	
	//Connecting param
	var connect='&';
	
	//Getting main link
	var url_root=FUNC.arguments[0].split("?");
		
	//Getting Fragment
	var url_id=FUNC.arguments[1].split(","); 
		
	//url id length
	var url_id_len=url_id.length;
	
	//Building parameter list
	for(ui=0;ui<url_id_len;ui++)
	{
        var elem=FUNC.arguments[ui+2];	

		//console.log(elem+'--');
		
		if(elem!=null && elem!=undefined){

			var elem_value=(elem.tagName=="SELECT")?((elem.options[elem.selectedIndex]!=undefined)?elem.options[elem.selectedIndex].value:''):
											((elem.type=='checkbox')?get_checkbox_status_int(elem):elem.value);
						
		
			//console.log('ScrollSortAction---'+d_series.getDeskScrollSortAction());
		
			if(d_series.getDeskScrollSortAction()==true){
						
				console.log(elem.id+'=='+G.$('pager_loaded_rows').dataset.pager);		
						
				if(elem.id=='page'){
					elem_value=G.$('pager_loaded_rows').dataset.pager;
				}else if(elem.id=='start_page'){
					elem_value=0;
				}	
				
				console.log(elem.id+'=='+elem_value);	
			}			
			
			if(ui==0)
			url_string+=url_id[ui]+'='+elem_value;
			else
			url_string+=connect+url_id[ui]+'='+elem_value;
	
		}
	
	
	}

    //Passing for CGI Session
    crypt_url(url_root[0]+url_string);
		
} // end

////////////////////////////////////////////////////////////////////////////////////////////////  FILE UPLOAD CHECK //////////////
// JavaScript Document
var PERMITTED_FILES=new String('|jpg|gif|png|pdf|doc|ppt|xls|mdb|zip|txt|html|');

//Check for filename	
function check_file(element)
{
   
   
	if(element.value.length>3)
	{
	 		 var fileName=element.value;
			 var fileSplit=fileName.split("\\");
			 var fileFormat=fileSplit[fileSplit.length-1].split('.');
			
			 if(fileSplit[fileSplit.length-1].indexOf('.')<0)
				{
				   window.alert('Please select your filename');
				   return false;
				}
			 else if( PERMITTED_FILES.indexOf('|'+fileFormat[1]+'|')<0 )
			    {
				  window.alert('Please check your file format. It is not a prescribed file format.\n\nCG accepts only in MS-Office File Formats,Adobe PDF,Windows Text File, HTML & Image Formats(jpg,png,gif)');
				  return false;
			  	}		
				   
			 document.getElementById('FILE_FORMAT').value=fileFormat[1];
  }	
  else
  {
        element.value='';
        return false;
  }
    
  return true;
  
  
}


///////////////////////////////////////////////////// STORED FILE OPENING //////////////////////////////////////////////////////////

//function image open
//iid->imageid

function file_sys_open(file_name)
		{
			 window.moveTo(0,0);						  
             window.open('../uploads/'+file_name,'','width=700,height=500,toolbar=0,scrollbars=1,menubar=1,status=0');
		}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////// FUNCTION REPEAT ////////////////////////////////
function repeat(symbol,count)
{
	var sym_content='';
	
	for(si=1;si<=count;si++)  //Counting the symbol for root
	{
	   sym_content+=symbol;	
	}
	
	return sym_content;
	
}


function get_repeat(symbol,count)
{
	var sym_content='';
	
	for(si=1;si<=count;si++)  //Counting the symbol for root
	{
	   sym_content+=symbol;	
	}
	
	return sym_content;
	
}



//////////////////////////////////////////////// SORT ICON /////////////////////////////
var SORT_ICON=new Array('&#9650;','&#9660;');


//////////////////////////////////////////////////  SESSION ID /////////////////////////
function crypt_url(url){	

	var lv ={};
	
	var q_index=url.indexOf("?");
	
	var sess_id=document.getElementById('PASS_ID').value;      

	lv.ss_axn = (d_series.getDeskScrollSortAction()==true)?'&ss_axn=1':'';

	G.showLoader('Fetching Info..');
 
    fetch((q_index==-1)?`${url}?PASS_ID=${sess_id}`:`${url}&PASS_ID=${sess_id}&page_axn=1${lv.ss_axn}`,
	{
		method: 'GET', // or 'PUT'
		headers: {
			'Content-Type': 'text/html',
		},
	})
	.then((response) => response.text())
	.then((html) => {
		
		//console.log('isScroll...'+document.getElementById('d_series_config').dataset.isLoadByScroll);
		
		if(d_series.getDeskScrollAction()==true){	
			
			// remove repeating variables
			document.getElementById('D_COUNTER').remove();
			document.getElementById('COUNTER').remove();
			document.getElementById('pager_records').remove();
									
			document.getElementById('desk_data').innerHTML+=html;	
			
			G.$('pager_loaded_rows').dataset.pager=Number(G.$('pager_loaded_rows').dataset.pager)+Number(G.$('COUNTER').value);
			
		}else{		
			document.getElementById('desk_data').innerHTML=html;
			if(G.$('COUNTER')){
				G.$('pager_loaded_rows').dataset.pager=Number(G.$('COUNTER').value);
			}
		}
		
		// bulk action area
		d_series.setBulkActionArea({'rows':Number(G.$('pager_records').dataset.pager)});
				
		if(Number(G.$('pager_records').dataset.pager)==0){
			
			if(d_series.getDeskConfig('hide-pager')!=1 && d_series.getDeskConfig('show-all-rows')!=1){
				d_series.setPagerStatus(0,
										G.$('page').value,
										G.$('pager_action').dataset.pager);
			}

			// update summary
			if(Number(d_series.getDeskConfig('has-summary'))==1){
				//wl.summary.updateStatus({'No':'0'});
				if(Number(d_series.getDeskConfig('has-summary'))==1){
					wl.summary.getResponse({'url':'?'+G.$('PAGE_ID').value+'='+G.$('app_key').value+'&sum_axn=1'}) 
				}
			}
							
			
		}else{
				
			if(d_series.getDeskConfig('hide-pager')!=1 && d_series.getDeskConfig('show-all-rows')!=1){	
				d_series.setPagerStatus(Number(G.$('pager_records').dataset.pager),
										G.$('page').value,
										G.$('pager_action').dataset.pager);
			}
			
			// sort direction
			lv.sort_direction = Number(G.$('sort_direction').value);
			lv.order_direction=(lv.sort_direction)?((lv.sort_direction==1)?2:1):1;	
			
			// set sort fields
			if(G.$('sort_field').value){	
				
				lv.last_sort_col = G.get_global('last_sort_col');
				if((lv.last_sort_col) && (lv.last_sort_col!=G.$('sort_field').value)){
					
					E_V_PASS("sort_col_"+lv.last_sort_col,'');
					E_H_PASS("sort_icon_"+lv.last_sort_col,'');
				}
			
				E_V_PASS("sort_col_"+G.$('sort_field').value,lv.order_direction);
				E_H_PASS("sort_icon_"+G.$('sort_field').value,SORT_ICON[lv.order_direction-1]);	
				G.set_global('last_sort_col',G.$('sort_field').value);
			}
			
			// js calls		
			try{
				d_series.runJsCalls();
				d_series.runJsCallOuts();
			}catch(e){
				console.error(e);
			}
			
			
			// prepare
			wl.desk.prepare();
			
			if(Number(d_series.getDeskConfig('has-summary'))==1){
				wl.summary.getResponse({'url':'?'+G.$('PAGE_ID').value+'='+G.$('app_key').value+'&sum_axn=1'}) 
			}
			
		
			
			//console.log('config'+d_series.getDeskConfig('hide-sno'));
			
		} // end of content setup
		
		G.hideLoader();
	})
	.catch((error) => {
		console.error('Error:', error);
	}); 
	
} // end


/////////////////////////////////////// PARENT TO CHILD //////////////////////////////
//Transfering element from one select box to another ///////////////////////////f(/////
function parent_to_child(parent,child){
	   
           var length=parent.options.length;
           
           for(pi=0;pi<parent.options.length;pi++){
                  		  
		      if(parent.options[pi].selected==true){
				 
				 if(check_select_match(parent.options[pi].text,child)==0)
				 {
				      var newD=document.createElement("OPTION");
				      newD.text=parent.options[pi].text;
				      newD.value=parent.options[pi].value;
				      newD.selected=true;
				      child.options.add(newD);
				      //parent.options.remove(pi);
				      parent.removeChild(parent.options[pi]);				      
				      pi--;   
				 }
				 else
				 {
				       window.alert('Already the value '+parent.options[pi].text+' added');  
				       return false;
				 }		  
                      }       
           }
}


/////////////////////////// SORT DEFAULT /////////////////////////////////////

function sort_order(column_sort,sort_order,column_value)
{
           
           if(column_sort.value==column_value)
           {
		   if(sort_order.value==0)
		   sort_order.value=1;
		   else if(sort_order.value==1)
		   sort_order.value=0;
           }
           else
	   { sort_order.value=0; }

           column_sort.value=column_value;           
}


/////////////////////////// RETRIEVE OPTION /////////////////////////////////////

function selectbox_capture(ele,taker,connector)
{
     
      connector=(connector)?connector:'#';
      
      var ele_length=ele.length;
      var ele_option='';

      for(ei=0;ei<ele_length;ei++)
	     {
			ele_option+=ele.options[ei].value+'::'+ele.options[ei].text+connector;
         }

      taker.value=ele_option;
	  
 
}


function selectbox_capture_selected(ele,taker,connector)
{
     
      connector=(connector)?connector:'#';
      
      var ele_length=ele.length;
      var ele_option='';

      for(ei=0;ei<ele_length;ei++)
	     {
				if(ele.options[ei].selected==true)
					{
						ele_option+=ele.options[ei].value+'::'+ele.options[ei].text+connector;
					}
         }

      taker.value=ele_option;
      
}

	   function selectbox_capture_selected_length(ele){
	     
		 var ele_length=ele.length;
		 var ele_option=new Array();
	   
		      for(ei=0;ei<ele_length;ei++){
				 
				 if(ele.options[ei].selected==true){
					    ele_option.push(ei);
				 }
		      }
	   
		      return ele_option.length;
		      
	   } // end


function selectbox_capture_value(ele,taker,connector){
	   
	   
     
	   connector=(connector)?connector:'#';
      
	   var ele_length=ele.length;
	   var ele_option='';

	   for(ei=0;ei<ele_length;ei++){
					
		      ele_option+=ele.options[ei].value+''+connector;		
           } // end

	   taker.value=ele_option.substring(0,ele_option.length-1);
	   
	
	   
      
}


function selectbox_capture_selected_value(ele,taker,connector)
{
     //alert(ele+"====="+taker+'-------------'+connector);
      connector=(connector)?connector:'#';
      
      var ele_length=ele.length;
      var ele_option='';

      for(ei=0;ei<ele_length;ei++)
	     {
				if(ele.options[ei].selected==true)
					{
						ele_option+=ele.options[ei].value+''+connector;
					}
         }

      taker.value=ele_option.substring(0,ele_option.length-1);  
	  
	 //console.log(taker.value);
      
}


//Delete from select box
function del_sel_box(ele)
{
    if((ele.options.length>0)&&(ele.options.selectedIndex!=-1))
	{
		 ele.options.remove(ele.options.selectedIndex)
	}
}	        


// Capture select box text values
function selectbox_capture_text(ele,taker,connector)
{
      
      connector=(connector)?connector:'#';
      
      
      
      var ele_length=ele.length;
      var ele_option='';
     
	   for(ei=0;ei<ele_length;ei++)
	   {
                                 ele_option+=ele.options[ei].text+connector;
                            
           }
			 
		 
	   taker.value=ele_option.slice(0,(ele_option.length-1));  // For removing last extra ,
}



			
	// Capture Select Box Values
					
				// ele -> element
				// taker -> value taker
				// connector				
		

			function selectbox_capture_value_all(ele,taker,connector)
			{

			      connector=(connector)?connector:'#';
           
				 var ele_length=ele.length;
				 var ele_option='';
     
				 for(var ei=0;ei<ele_length;ei++)
				     {
							
                    	             ele_option+=ele.options[ei].value+connector;
                        		        
				 }

		      	  taker.value=ele_option.slice(0,(ele_option.length-1));  // For removing last extra ,

			}

	// Trimming the content * make extra a  mouse over option

		// 0 -> Content
		// 1 -> Length

	   function CONTENT_TRIM(content,trim_length,width,height){
	      
			       // Checking for width & height
		   
			       if( (width) && (height) )
			       {
			       return '<a  onMouseMove="JavaScript:show_tip(\''+content+'\',event,'+width+','+height+';" onMouseOut="hide_tip()">'+content.substr(0,trim_length)+'...</a>';	
			       }
			       else
			       {
				       return '<a  onMouseMove="JavaScript:show_tip(\''+content+'\',event;" onMouseOut="hide_tip()">'+content.substr(0,trim_length)+'...</a>';	
			       }
	   }
	 
	   function trim_and_tip(content,trim_length){
	      
				 // Checking for width & height
				 if(content.length>trim_length){
		   
					    return '<a  data-hint="'+content+'"  class="hint--bottom ">'+content.substr(0,trim_length)+'..</a>';
				 }else{
				 	    return content;
				 }
		
	   } // trim
	   
	   function get_trim(content,trim_length){
	      
				 // Checking for width & height
				 if(content.length>trim_length){
		   
					    return '<span  title="'+content+'">'+content.substr(0,trim_length)+'..</span>';
				 }else{
				 	    return content;
				 }
		
	   } // trim
	 
           //27 apr 2015:
	   
	    // capitalize 
	   
	   function capitalize_each_word(str) {
		      return str.replace(/\w\S*/g, function(txt) {
			  return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
		      });
	   }
	   
	   function alphanum_clean(str) {
		      return str.replace(/\W+/g,'');
	   }
	   
	   // string match
	   
	   function check_string(str,pat) {
		      
		      var temp;		      
		      temp = str.match(pat);
		      return (temp!=null)?1:0;
		      
	   }


	   function fade_in(element_id,message){
		$(element_id).html(message);					
		$(element_id).fadeIn(100);
	   }
		
	   function fade_out(element_id){
		$(element_id).fadeOut(100);
	   }
	
	   function fade_in_out(element_id,show_time,message){
		
		$(element_id).html(message);
		$(element_id).fadeIn(10).delay(show_time).fadeOut(500);
	   }


/////////////////////////////////////////////   Element Action /////////////////////////////////////
// passing value to a action //////////////////
// E- >Element
// V-> value , H-> HTML

function ELEMENT(element_id){
	   
	   //alert(element_id);

     	 	if(document.getElementById(element_id))
			{
				return document.getElementById(element_id); 
			}
			else
			{
				//window.alert('Not an Element : '+element_id);
				return false;
			}
			
}


function E_V_PASS(element_id,value)
{
		
	   if( (document.getElementById(element_id)!=null) ||
	       (document.getElementById(element_id)!=undefined)){
		      
		      if (document.getElementById(element_id).type!="file"){
				 
				  document.getElementById(element_id).value=value;      //code
		      }
	   }
	        
		
}

function E_H_PASS(element_id,value)
{
           if(document.getElementById(element_id)){
				   document.getElementById(element_id).innerHTML=value;
		   }
            
}


function E_V_TEMP(element_id)
{
            
            TEMP[element_id]=document.getElementById(element_id).value;
            
}

function E_H_TEMP(element_id)
{
            TEMP[element_id]=document.getElementById(element_id).innerHTML;
			
            
}



function V_F_TEMP(element_id)
{
            if(TEMP[element_id])
            document.getElementById(element_id).value=TEMP[element_id];
}


function H_F_TEMP(element_id)
{
            if(TEMP[element_id])
            document.getElementById(element_id).innerHTML=TEMP[element_id];
}



// Simple Element Forms

function GET_E_VALUE(element_id)
{
      	return document.getElementById(element_id).value;
}

// Get HTML Value
function GET_E_HTML(element_id)
{
         	return document.getElementById(element_id).innerHTML;
}



function E_STATE(element_id,state)
{
     	 	if(document.getElementById(element_id))
				{
					document.getElementById(element_id).disabled=state;
				} 
}


function E_VISIBLE(element_id,state)
{
     	 	if( (document.getElementById(element_id)) && (state) )
				{
					document.getElementById(element_id).style.visibility=state;
				} 
			
			if(!state)
			{
				return document.getElementById(element_id).style.visibility;
			}
		   		
}

function E_READONLY(element_id,state)
{
     	 	if(document.getElementById(element_id))
				{
					document.getElementById(element_id).readOnly=state;
				} 
}


function E_FOCUS(element_id)
{
     	 	if(document.getElementById(element_id))
				{
					document.getElementById(element_id).focus();
				} 
}

function E_TYPE(element_id)
{
     	 	return (document.getElementById(element_id))?document.getElementById(element_id).type:'-1'; 
}


function E_TOP(element_id)
{
		window.alert(element_id+'..'+document.getElementById(element_id).style.pixelLeft);	
		return (document.getElementById(element_id))?document.getElementById(element_id).style.top:'0'; 

}


///////////////////////////////////////////// ///////////////////////////// END  Element Action ////////



//////   Element Focus  ////////////////////////////////////////////////////////////////////////////


function E_ROW_FOCUS(element)
{
           element.style.backgroundColor="#B9D300";
}

//ELEMEN ACTION
function E_ROW_FOCUS_OUT(element)
{
           element.style.backgroundColor="";
}



function E_FOCUS_HEIGHT(element)
{
           element.style.rows=10;
}



	


///////////////////////////////////////////////////////////////////////  Element Focus   //////////

///////////////////////////////////// SIMPLE CALCULATION /////////////////////////////////////

function E_MULTIPLY()
{
           var length=E_MULTIPLY.arguments.length;
           var result=1
           
           for(i=0;i<length;i++)
           {
               result=result*document.getElementById(arguments[i]).value;
                      
           }
           
           return result;
}

function E_ADD()
{
           var length=E_ADD.arguments.length;
           var result=1
           
           for(i=0;i<length;i++)
           {
               result=result+document.getElementById(arguments[i]).value;
                      
           }
           
           return result;
}

//Addition series
//1-> "element'
//2- > nuber of rows

function E_ADD_SERIES()
{
           var length=arguments[1];
           
           var result=new Number(0);
           
           for(i=1;i<=length;i++)
           {
               var num=new Number(document.getElementById(arguments[0]+i).value);
               result=result+num;
                      
           }
           
           return result;
}


function E_SUB()
{
           var length=E_SUB.arguments.length;
           var result=1
           
           for(i=0;i<length;i++)
           {
               result=result-document.getElementById(arguments[i]).value;
                      
           }
           
           return result;
}

//////////////////////////////////////////  String concatination //////////////////////////////

function E_CONCAT_SERIES()
{
           var length=arguments.length;
           
           var result='';
           
       
           
           for(i=0;i<length;i++)
           {
               result=result+document.getElementById(arguments[i]).value;
               
                      
           }
           
           return result;
}

///////////////////////////////////////////  STRING CONCATIONATION //////////////////////



///////////////////////  FORM GENERAL VALUS ////////////////////////////////////////////


	// function  for checking all elements	
	function check_all(element_count,element_prefix){

		var lv={};
		lv.element_prefix=(element_prefix)?element_prefix:'c';		      
  
		for(var i=1;i<=element_count;i++){
			 
			lv.element_key = (lv.element_prefix+i);
			lv.ele		   = D.getElementById(lv.element_key);
			
			// valid element 
			if( (lv.ele!=null) || 
				(lv.ele!=undefined)){
			 
				 if(lv.ele.disabled==false){										;
						lv.ele.checked=true;
				 } // d
			} // ele		      
		} // for		      
	} // end



	function clear_all(element_count,element_prefix){ 
	
		var lv={};
		lv.element_prefix=(element_prefix)?element_prefix:'c';		      
  
		for(var i=1;i<=element_count;i++){
			 
			lv.element_key = (lv.element_prefix+i);
			lv.ele		   = D.getElementById(lv.element_key);
			
			// valid element 
			if( (lv.ele!=null) || 
				(lv.ele!=undefined)){										;
						lv.ele.checked=false;				
			} // ele		      
		} // for	
	} // end
	
	function check_box_action(element,c_count){
	 
		  if(	  element.checked==true){   check_all(c_count);  }
		  else{   clear_all(c_count);   }	       
        } // end



///////////////////////  FORM GENERAL VALUS ////////////////////////////////////////////



////////////////////////  WINDOW PRINT ////////////////////////////////////////////////

// Printing a element content area
	
	// 0 -> Element Id


 // code form  http://www.microsector.net/javascript2.html
 
 
 function E_PRINT(element_id)
	{
			if(document.getElementById('REPORT_HEADER_INFO'))
                        {
                          E_H_PASS('REPORT_HEADER_INFO','');  
                        }

			var prtContent = document.getElementById(element_id);
			var WinPrint = window.open('','','letf=10,top=10,width="700",height="500",toolbar=0,scrollbars=1,menubar=1,status=0');

			WinPrint.document.write("<html><head><LINK rel=\"stylesheet\" type\"text/css\" href=\"../css/strategion.css.css\" media=\"print\"><LINK rel=\"stylesheet\" type\"text/css\" href=\"../css/strategion.css.css\" media=\"screen\"></head><body>");

			WinPrint.document.write("<textarea id=\"REPORT_USER_TITLE\"  name=\"REPORT_USER_TITLE\" class=\"REPORT_USER_TITLE\" rows=1>Report Title</textarea>");
                        
			WinPrint.document.write(prtContent.innerHTML);
			WinPrint.document.write("</body></html>");
			WinPrint.document.close();
			WinPrint.focus();
			WinPrint.print();
			
 }

//////////////////////// //////////////////////// //////////////////////// Window print /////////



////////////////////// POP UP CONTENT ///////////////////////////////////////

 function WIN_SHOW_CONTENT()
	{
			
			var WinPrint = window.open('','Part','width="800",height="500",toolbar=0,scrollbars=0,menubar=1,status=0');
           	     
			WinPrint.document.write("<html><head><title>Part Image</title><LINK rel=\"stylesheet\" type\"text/css\" href=\"../css/strategion.css.css\" media=\"print\"><LINK rel=\"stylesheet\" type\"text/css\" href=\"../css/strategion.css.css\" media=\"screen\"></head><body>");

			WinPrint.document.write('<img src="../tmp/part.jpg"></img>');
			WinPrint.document.write("</body></html>");
			

			
 }
 
 
 ////////////////////////////////////////////////////////////////////// Pop up content



//////////////////// Report Controls ////////////////////////////////




function dummy_act()
{
}
	
	
	
	/*10-12-2010*/
	


        // wheter check is selected while create invoice
	
	function check_with_ajax(c_count,ro_id) {
			
	
		var total_elements=Number(c_count);			
		var del_items='';		
		var d_flag=1;		
	
			
		for(var index=1;index<=total_elements;index++)
		{   
		  
			 if(D.getElementById('c'+index).status==true){
					
					d_flag=1;	
			 }	 
			
		  
		}
		
			
		if(d_flag==1) {
		
			var conform=window.confirm('Are you sure want to create');
		
		//alert(conform);
	  
				if(conform==true){
						
						if( (c_count) && (ro_id)){
						
							 invoice(c_count,ro_id);				// this function there in ro_desk.html
											
						}			
						
				//	send_pay_status('purchase_id','from_id','to_id',2,'purchase_id','pay_mode','pay_details','pay_amount','pay_date','CURRENT_TIMESTAMP','chq_value',0,'',1,1,'balance_amount','update_table'); pay_status_info.create_invisible();			
				
				}
		}
	
		 
		if(d_flag==0) {
			
			 window.alert("Please Check Atleast 1 Row");
			 return false;
		}
			 
			 
		return conform;	 					  
	
		return true;	 
	
	}
	
	
	   // relaod
	
	   function page_reload(){
		
		      var cur_win=document.location.href;				    
		      document.location.href=cur_win;	
	   }
	
	function page_refresh(){
		
		      document.location.reload();
	}
	
	
			
/*--------- by dharam -----------------------------------------------------------------------------------------------------------*/	
		
		
		function check_box_validation(no_row,ele_id){
			
					//alert(ele_id);
					var total_elements=Number(no_row);
		
					var del_items='';
					
					var del_flag=0;
					
					for(var index=1;index<=total_elements;index++){
						
						var  temp = document.getElementById(ele_id+'_'+index).checked;	
						
						if(temp == true){
							del_flag = 1;
						}
						
					} 
					
					if(del_flag == 1){
					
						var conform=window.confirm('Are you sure want to create');
						
						if(conform==true){
							
							//alert('...........');
							//return conform;
		
							return true;
						}
						
						else{
								return false;
							
							}
						
					}
					
					
					
					if(del_flag==0) {
						
						 window.alert("Please Check Atleast 0ne Row");
						 return false;
					 }
					
		} // end
		
		
		
	   // trigger event
      // i/p	: event,trigger_key,action function
      // call function, if function no give error
      
      function trigger_event_by_key(evt,key,action){
	 
	       if(evt.keyCode==key){
		  action();  
	       }
      } // end
      
      
      function is_element_exists(element_id){
	 
	    if(document.getElementById(element_id)==null){
	       
		    //this.error_str+='Invalid ID : '+element_array;	
		    return false;
		  
	    }else{				
		    //this.elements.push(element_array);				
		    return true;
		  
	    } // end
	    
      } // end
      
      // adding focus style on/off to given series of events
      
      function add_focus_style(param){
	 
	       var temp = Object({});

	       for(var idx in param.elements){
		   
		   // check the element is exists
		   
		   if(is_element_exists(param.elements[idx])==true){
		     
			temp.current_element = document.getElementById(param.elements[idx]);
			
			temp.current_element.onfocus = function(){ this.style.cssText	= param.on;   };
			temp.current_element.onblur  = function(){ this.style.cssText   = param.off;  };
		   }
		   
	       } // for each argument
	       
      } // end
      
      
       function add_focus_style_object(param){
	 
	       var temp = Object({});

	       for(var idx in param.elements){
		   
		   // check the element is exists
		   
		   if(is_element_exists(param.elements[idx])==true){
		     
			temp.current_element = document.getElementById(param.elements[idx]);
			
			temp.current_element.onfocus = function(){
			
				 temp.current_style = Object.keys(param.on);
				 
				 for(var idx in temp.current_style){
					  
					  temp.current_key = temp.current_style[idx];				 
					  this.style[temp.current_key]=param.on[temp.current_key];
				 }
		        };
			
			
			temp.current_element.onblur  = function(){
					    
				 temp.current_style = Object.keys(param.off);
				 
				 for(var idx in temp.current_style){
					  
					  temp.current_key = temp.current_style[idx];
					  
					  //alert(this.id+'--'+temp.current_key+'--'+param.off[temp.current_key]);
					  
					  this.style[temp.current_key]=param.off[temp.current_key];
				 }	    
		        };
		      
		   }
		   
	       } // for each argument
	       
      } // end
      
      
	   // set style
	   
	   function set_style_attribute(element,attribute,value){	 
	      element['style'][attribute]=value; 
	   }
	   
	   // On before deactiate
	   
	      // Internet Explorer
	     function CancelDeActivation (event) {
		 
		 // prevent the propagation of the current event
		 if (event.stopPropagation) {
		     event.stopPropagation();
		 }
		 else {
		     event.cancelBubble = true;
		 }
		     // cancel the current event
		 return false;
	     }
	     
	     function KeepFocus (elem) {
		 if (elem.onbeforedeactivate) {  // Internet Explorer
		     return false;
		 }
		 
		     // elem.focus () does not work in Firefox, a timer is needed
		 setTimeout (SetFocus, 0, elem);
	     }
     
	     function SetFocus (elem) {
		 elem.focus ();
	     }

			
			
			
		function Option_Builder(obj){

			for (option in obj.options){
					 
				if (obj.options[option].group){
					
					// code					
					var select_option_group = document.createElement("OPTGROUP");										
					select_option_group.label=obj.options[option].group;
					obj.select_box.options.add(select_option_group);

				}else{
					 
					var select_option = document.createElement("OPTION");								  
					select_option.text=obj.options[option].name;
							
				  	if(obj.is_name_as_css==1){
						select_option.className=obj.options[option].name;
					} 
										
					select_option.value=obj.options[option].id;							
					obj.select_box.options.add(select_option);

				} // end					 
			} // end
		} // end
	   

	   function Option_Builder_Csv(obj){
		      
		      var temp = obj.options_csv.split('|');

		      for (option in temp){				 		
				 
				  var select_option = document.createElement("OPTION");
						
				  select_option.text=Number(temp[option]);
						
				  select_option.value=Number(temp[option]);
				  
				  obj.select_box.options.add(select_option); 
		      }
	 
	   } //end
	   
	   function Option_Builder_Series(obj){
		      
		      obj.step = (obj.step!=undefined)?obj.step:1;
		      
		      if(obj.step>0){
			
				 for (var opt_index=obj.start;opt_index<=obj.end;(opt_index=(opt_index+obj.step))){				 		
					  
					  var select_option = document.createElement("OPTION");
							
					  select_option.text=(opt_index<10)?'0'+opt_index:opt_index;
							
					  select_option.value=(opt_index<10)?'0'+opt_index:opt_index;
					  
					  obj.select_box.options.add(select_option); 
		         	 }
		      //code
		      }else{
				 for (var opt_index=obj.start;opt_index>=obj.end;(opt_index=(opt_index+obj.step))){				 		
					  
					  var select_option = document.createElement("OPTION");
							
					  select_option.text=(opt_index<10)?'0'+opt_index:opt_index;
							
					  select_option.value=(opt_index<10)?'0'+opt_index:opt_index;
					  
					  obj.select_box.options.add(select_option); 
		         	 }
				 
		      } // less than 6
	 
	   } //end
	
	   function Option_Builder_Packet(obj){
		      
		      var temp = obj.options_csv.split(',');

		      for (option in temp){				 		
				 
				  var select_option = document.createElement("OPTION");
				  
				  var temp_value =  temp[option].split(':');
						
				  select_option.text=temp_value[1];
						
				  select_option.value=temp_value[0];
				  
				  obj.select_box.options.add(select_option); 
		      }
	 
	   } //end
	   
	   
	   	
	   function Option_Builder_Key_Value(obj){
		      
		

		      for (var key in obj.data){				 		
				 
				  var select_option = document.createElement("OPTION");
				  		
				  select_option.text=obj.data[key];
						
				  select_option.value=key;
				  
				  
				  
				  obj.select_box.options.add(select_option); 
		      }
	 
	   } //end
	   

	
	   // Dynamic Placing
				
	   function dynamic_placing(message_text,message_arguments){
			
						//alert(message_text+'..'+arguments);
					
					// param
					
						var l_v 						= new Array();
					
						l_v['message_param']			= message_arguments.split(',');
					
						l_v['message_param_length']		= l_v['message_param'].length; 
					
					
					// rx
					
						l_v['pattern']					= /\%\w+/i;
						
						l_v['line_pattern']				= /\\n/i;
					
						l_v['message_text']				= new String(message_text);						
					
					
						// for each  message
					
						for(var message_index=0; message_index < l_v['message_param_length']; message_index++){
								
									// check for the patterned message \%\w
								
										l_v['search_flag']			=	l_v['message_text'].search(l_v['pattern']);
																			
									// replace by message param
									
										if(l_v['search_flag']>-1){
									
											l_v['replaced_text']		=	l_v['message_text'].replace(l_v['pattern'],'<b>'+l_v['message_param'][message_index]+'</b>');							
											
											l_v['message_text']		= 	l_v['replaced_text'];
											
										} // end	
					
						}
						
						
						// line replacment	
					
							l_v['replaced_text']			=   l_v['message_text'].replace(l_v['line_pattern'],'');
									
							l_v['message_text']			=   l_v['replaced_text'];						
						
						// write message
							
							return l_v['message_text'];												
			
	   }	// dynamic placing	
		      
	    //////////////////////////////////////////////////////////////////////////////////////////////////////////
		///	Name		: matchSelectOptionsByAx
		///	Short Brief	: based on parent select element value, filter the child select element option attribute
		///               data-ax  
		///	i/p			: (parent_element,child_element)
		///	o/p			: returns true and filter the child element
		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		function matchSelectOptionsByAx(parentElem,childElem){

			var lv = {'selectedValueText':'','selectedValues':[],'matchedOption':{},'unmatchedOptions':[]};
			
			lv.selectedValueText = parentElem.value;
			lv.selectedValues  = lv.selectedValueText.split(',');
		
			// get options with inst. type token
			for(const valueMatch of lv.selectedValues){
				lv.matchedOption[valueMatch] = document.querySelectorAll("select.selectpicker [data-ax~='"+valueMatch+"']");
			}

			lv.unmatchedOptions = document.querySelectorAll("select.selectpicker :not([data-ax~='"+lv.selectedValueText+"'])");
				
			for(const unmatchedOption of lv.unmatchedOptions){
				unmatchedOption.style.display="none";
			}

			for(const matchedOptionKey of Object.keys(lv.matchedOption)){
				for(const matchedOption of lv.matchedOption[matchedOptionKey]){
					matchedOption.style.display="list-item";
				}
			}
			
			//refresh picker
			$(`#${childElem.id}`).selectpicker('refresh');

			return true;

		} // end

	   // Genral Object
	   // General Class
	   function General(){
		      
		   this.attribute				= new Array();
		   
		   this.global					= new Object({});
		   
		   this.confirm_action_track 			= {};
		   
		   this._last				        = {'bs_action':''};				   
		   
		   this._config					= {'isDebug':0};
		   
		   this.format					= {
		      
		      0:function(temp){ return temp;},
		      1:function(temp){ return Math.floor(temp);},
		      2:function(temp){ return Math.ceil(temp);},
		      3:function(temp){ return temp.toFixed(1);},
		      4:function(temp){ return temp.toFixed(2);},
		      5:function(temp){ return temp.toFixed(3);},
		      6:function(temp){ return temp.toFixed(4);},
		      7:function(temp){ return temp.toFixed(5);}
		   }
		   
		   		   
	   } // end
	   
	   
	   
	General.prototype.$=function(element_id,element_family){
	   
		var ele = {'status':'','box':''};
				  
		if(element_family=='parent'){  		      
			ele.status= this.isParentElementThere(element_id);  
			if(ele.status==true){
				ele.box = window.parent.document.getElementById(element_id);
			}
		}else{		      
			ele.status = this.isElementThere(element_id);
			if(ele.status==true){
				ele.box = document.getElementById(element_id);
			}
		}			
		
		if(ele.status==false){
			console.error(`Sorry, there is no element with the id [${element_id}]. Kindly check the given name`);
			return false;
		}else{
			return ele.box;
		}
   
	} // end
	  
	   	   

	   // Function Set Global
	   
	   General.prototype.set_global = function(key,value){
		  
		 this.global[key] = value; 	  
		  
	   } // set attribute	   

	    // Function Get Global	   
		General.prototype.get_global = function(key){
		  
		 return this.global[key]; 	  
		} // set attribute	 
		
		// Function Unset Global	   
		General.prototype.unset_global = function(key){
		  
			return delete this.global[key]; 	  
		  
	   } // set attribute	 

	   
	       // content trim
       
	   General.prototype.set_css = function(content){
			   
	       //document.write('<link rel="stylesheet" type="text/css" href="../../css/altius.css" media="all" />');
	   }
       
	   // content trim
       
	   General.prototype.content_trim = function(content,length){
		 
		   if(content.length<length){
		   
		       return content;
		   
		   }else{
		       
		      return '<a  title="'+content+'">'+content.substr(0,length)+'..</a>'; 
		   }
		   
	   } // end
       
	  	 	   
	   // set number fixed
	   
	   General.prototype.set_decimal = function(price){
	       
		   return Number(price).toFixed(2);     
	   }
	   
	    // set number fixed
	   
	   General.prototype.set_integer = function(param){
	       
		   return Number(param).toFixed(0);     
	   }
	   
	   
	   // write decimal
	   
	   General.prototype.write_decimal = function(price){
	       
		   return this.price_symbol+this.set_decimal(price);    
	   }
	   
	   
	   // Padding
	   
	   General.prototype.padding = function(value,padding_max,padding_digit){		      
		      		      
		      return (value<padding_max)?padding_digit+''+value:value;		      
	   }
	   
	   // Padding 2
	   
	   General.prototype.padding_2d = function(value){
		      
		      return this.padding(value,10,'0');
	   }
	   
	   General.prototype.chop	    = function(str){
		      
		      return str.substring(0,str.length-1);		      
	   }
	   
	   
	   General.prototype.set_max_length = function(evt,obj,max_len)
	   {
	       return (obj.value.length <= max_len)||(evt.keyCode == 8 ||evt.keyCode==46||(evt.keyCode>=35&& evt.keyCode<=40));
	   }
	   
	   
	   General.prototype.bs_alert = function(message,alert_style,action,message_title){
		     
			$('#my-message-box').modal('show');
			$('#my-message-box-alert').css('display','block');
			$('#message-box-content').html(' <div class="alert '+alert_style+'" role="alert">'+
						     message+
						     '</div>');
			$('#message-box-title').html(message_title);
			this._last.bs_action=(action==undefined)?0:action;
		      
	   } // end of alert
	   
	   General.prototype.bs_confirm = function(message,action){
		      
		      this.confirm_action_track=action;
		     
	              $('#my-message-box').modal('show');
		      $('#my-message-box-alert').css('display','none');
		      $('#my-message-box-confirm').css('display','block');
		      
		      $('#message-box-content').html(' <div class="alert" role="alert">'+
						     message+
						     '</div>');
		      
	   } // end of alert
	   
	   General.prototype.bs_alert_warning = function(message,action,message_title){		     
		      this.bs_alert(message,'alert-warning',action,message_title);	             
	   } // end of alert
	   
	   General.prototype.bs_alert_error = function(message,action,message_title){		     
		      this.bs_alert(message,'alert-danger',action,message_title);	             
	   } // end of alert
	   
	   General.prototype.bs_alert_success = function(message,action,message_title){		     
		      this.bs_alert(message,'alert-success',action,message_title);	             
	   } // end of alert
		
	   General.prototype.bs_confirm_action = function(){
		      this.confirm_action_track();
	   } // end
	   
	   General.prototype.showLoader = function(progress_message){   		
			  this.$('loader').classList.add('loader_on');
		      $('#loader').modal({'show':true});
		      $('#progress_message').html(this.isUndefined(progress_message,'Loading..'));
	   } // end
	   
	   General.prototype.hideLoader = function(){                   		     
		     setTimeout(function(){
				 $('#loader').modal('hide');
				 document.getElementById('loader').classList.remove('loader_on');
			  },100);
	   } // end
	   
	   General.prototype.showTopLoader = function(progress_message){
		      
		      var lv={};
		      
		      lv.top_window=window.top;
		      
		      lv.top_loader       = lv.top_window.document.getElementById('loader');
		      lv.progress_message = lv.top_window.document.getElementById('progress_message');
		      
		      $(lv.top_loader).modal({'show':true});
		      $(lv.progress_message).html(this.isUndefined(progress_message,'Loading..'));
	   } // end
	   
	   General.prototype.hideTopLoader = function(){
		   
			  var lv={}
				
			  lv.top_window=window.top;
			  
			  lv.top_loader       = lv.top_window.document.getElementById('loader');		      
			  
			  setTimeout(function(){
				 $(lv.top_loader).modal('hide')
			       },1000);
	   } // end
	   
		
		// validate	   
		General.prototype.reverse=function(s){
		      return s.split("").reverse().join("");
		}
	   
		General.prototype.isElementThere=function(element_id){
		      return (document.getElementById(element_id)==null)?false:true;
		}
		
		General.prototype.isParentElementThere=function(element_id){
		      return (window.parent.document.getElementById(element_id)==null)?false:true;
		}
	   
		General.prototype.isUndefined = function(value,substitue){                                            
		      substitue = (substitue==undefined)?0:substitue;		      
		      return (value==undefined)?substitue:value;                                        
		}
	   
		General.prototype.isZero = function(value,substitue){		       
		      substitue = (substitue==undefined)?'':substitue;		       
		      return (value==0)?substitue:value;                                        
		}
	   
		General.prototype.isNull = function(value,substitue){		       
		       substitue = (substitue==undefined)?0:substitue;		       
		       return (value==null)?substitue:value;                                        
		}
	   
	   General.prototype.isEmpty = function(value,substitue){
		       
		       substitue = (substitue==undefined)?0:substitue;		       
		       return (value.length==0)?substitue:value;                                        
	   }
	   
	   
	   General.prototype.isUNE = function(value,substitue){
		                        
		      var error=0;
		      
		      substitue = (substitue==undefined)?0:substitue;
		    
		      try {
			  
			  var temp = new String(value);
			  value    = temp.replace(/\s/ig,'');
			  
			  
			  if(value==null) throw "NULL";
			  else if(value==undefined) throw "UNDEFINED";
			  else if(value.length==0) throw "ZERO";
			  else if(isNaN(value)==true) throw "NAN";
			     
		      }catch(err){
			  
			  error=1;
			  
		      }finally {
			  return (error==1)?substitue:value;
		      }
                    
           
	   }

	    General.prototype.isObjKey = function(p){
		      
		      if(p.obj[p.key]!=undefined){
				return p.obj;
		      }else{
				 p.obj[p.key]=0;
				 return p.obj;
		      }
	   
	   }	   
	   
	   
	   General.prototype.isObjKeyCount = function(p){
		       
		      if (p.obj[p.key]!=undefined){				 
				p.obj[p.key]=(p.obj[p.key]+1);
				return p.obj;
		      }else{
				 p.obj[p.key]=1;
				 return p.obj;
		      }                                      
	   }
	   
	   General.prototype.isTextOrTextarea = function(element){		   
		   if(element.id!=undefined){				
				return ((element.type=='text') || (element.tagName.toUpperCase()=='TEXTAREA'))?true:false;				
		   }else{		   
				return false;
		   }		   
	   } // end
	   
	   General.prototype.getSingularPlural = function(given_value,object){
		      
		      console.log((Number(given_value)==1)?given_value+' '+object:given_value+' '+object+'s');
		      
		      return (Number(given_value)==1)?given_value+' '+object:given_value+' '+object+'s';		      
	   }
	   
	   // Remove dot extra :
                
	   General.prototype.initial_format=function(str){
      
      
		      var lv = new Object({});
	    
		      // lv.str_1 = str.replace(/\W+$/g,function(txt) {
		      //	    return '';
		      //	   });
		      //    
		      //lv.str_2 = lv.str_1.replace(/\W+/g,function(txt) {
		      //	   return txt.charAt(0);
		      //	   });     
		      //    
		      //lv.str_3 = lv.str_2.replace(/^\W+/g,function(txt) {	      
		      //	   return '';
		      //	   });
		
		      lv.str_4 = str.replace(/\.\w{1}/g,function(txt) {	      
				 return txt.charAt(0)+txt.charAt(1).toUpperCase();
				 });   
	     
		    
	     
	     return lv.str_4;
	    
	   }
	   
	   //Debug On
	   General.prototype.onDebug =function(){this._config.isDebug =1; return true;}
	   General.prototype.offDebug=function(){this._config.isDebug =0; return true;}
	   General.prototype.setDebug=function(debug_flag){ if((debug_flag==0) || (debug_flag==1)){this._config.isDebug =status;} return true;}
	   General.prototype.log=function(message){ if(this._config.isDebug==1){ console.log(message); }; return true; }
	   
		// set tip/qtip inheritance
		General.prototype.parseTip=function(){
		
			// tip left by default
		
		  $('a.tip,input.tip').each(function() {
							
			  $(this).qtip({                                                                
			  content: {
				  text: $(this).next('.tooltiptext')
			  },
			  position: {                                    
				  my    : 'middle left',    
				  at    : 'right'
			  },
			  });                       
		  });
		   
		  
		  // tip right 		   
		  $('a.tip_right,input.tip_right').each(function() {
	  
		      $(this).qtip({                                                                
			  content: {
			      text: $(this).next('.tooltiptext')
			  },
			  position: {                                    
			      my    : 'middle right',    
			      at    : 'left'
			  },
		      });                       
		  });
		  
		  
		  // tip bottom		   
		  $('a.tip_bottom,input.tip_bottom').each(function() {
	  
		      $(this).qtip({                                                                
			  content: {
			      text: $(this).next('.tooltiptext')
			  },
			  position: {                                    
			      my    : 'top center',    
			      at    : 'bottom center'
			  },
		      });                       
		  });
		  
		  
		  // tip bottom		   
		  $('a.tip_top,input.tip_top').each(function() {
	  
		      $(this).qtip({                                                                
			  content: {
			      text: $(this).next('.tooltiptext')
			  },
			  position: {                                    
			      my    : 'bottom center',    
			      at    : 'top center'
			  },
		      });                       
		  });	
		   
		   
		} // end of parse tip
			
	   
	   
	   
	   // call object
	   var G = new General();
/** bootstrap control *********************/

	   function show_datetime_picker(param){$('#'+param).datetimepicker('show');}
	   
/*******************************************************************************************************************************************************************************/	   
	   
	   //number to words:

		var one  	= "";
		
		var ones 	= new Array (' ','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen','fifteen',
								'sixteen','seventeen','eighteen','nineteen');

		var tens 	= new Array ('','','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety');

		var value_zero 	= new Array ( 'only');

		var hundred 	= new Array ('hundred');


    function number_to_word(num){
	
		
			var result;	
			
			var input_value		=	Math.ceil(num) // Geting input 
			
			var input_text		=	new String(input_value);
	
			var input_length	=	input_text.length; // to find input length.

			if(input_length<=2){                
	
				result=upto_100(input_value);   // If input length is == 2 means this function Working.
			}
			
			else if(input_length==3){
	
				result=from_100_to_999(input_value); // If length is == 3 menas this function working.
			}
	
			else if(input_length==4) {
				
				result=from_1000_to_9999(input_value); // If length os == 4 means this function working.
	
			}
	
			else if(input_length==5) {
	
				result=from_10000_to_99999(input_value); // if Length is == 5 means this function working. 
			}
	
			else if(input_length==6) {
	
				result=from_100000_to_999999(input_value); // If length is ==6 means this functtion wroking
	
			}
	
			else if(input_length==7) {
				
				result=from_1000000_to_9999999(input_value);  // If length is == 7 menans this function working.
			}
	
	
			else if(input_length==8) {
	
				result = from_10000000_to_99999999(input_value);  // If length == 8 means this funtion working.
	
			}
	    return result
			
    }
	
	function upto_100 (digit){
			
				if(digit<20){
					
					return upto_19(digit);  	// If confidtion < then  digit means UPTO_19 funcction working.
				}
				
				else
				{
					return from_20_to_99(digit); // if condition ELSE FROM_20_to_99 function working.
				}
		
		
	}//end upto 100
			
		
	function upto_19(digit){            // This function performed upto 19.
		
		
		return ones[digit];
		  
		
	}//end upto 19
		
	function from_20_to_99(digit){		// This function performed 20 to till 99.
		
			var mod		=	Math.floor(new Number(digit/10));  // digit divied by 10.
		
			var rem		=	new Number(digit%10);			   // digit MOD by 10.
		
		return tens[mod]+' '+ones[rem];			  //  Concat MOD and REM.
		
	}//end from 20 t0 99
		
			
	function from_100_to_999 (digit){			// This function performed 100 to till 999
			
		if( digit > 0 ){							// if condtion > 0 inside the condtion. 
				
		    if( (digit>99) && (digit<120) ){	// if condition > 99 and < 120 means its going to function upto_19.
					
			    return "One Hundred "+upto_19(digit-100);
					
		    }
		    
		    else if (digit < 100) {				// if condition ELSE IF and its < 100 means its going to function upto_100.
		
			return upto_100(digit);
		    
		    }
						
		    else{
			
			return from_120_to_999(digit);  // if conditio ELSE its going to function from_120_to_999.
		    
		    }
		
		}//end if
		else{
					
		    return '';
		
		}
		
				
	}//end from 100 to 999
		
	function from_120_to_999(digit){			// this fnction performed 120 to till 999.
		
			var mod		=	Math.floor(new Number(digit/100)); // digit divided by 100.
			
			var rem		=	new Number(digit%100);			  // digit MOD by 100.
					
		
		return ones[mod] +" Hundred "+ upto_100(rem);  // concat both MOD and REM.
		
	}//end from 120 to 999
		
		
	// thousands 
		
	function from_1000_to_9999(digit){			// this function performed 1000 to till 9999.
		
		    var mod		=	Math.floor(new Number(digit/1000));	// digit divided by 1000.
		
			
		    var rem		=	new Number(digit%1000);			   // digit MOD by 1000.
					
		
		return ones[mod] +" Thousand "+ upto_1000(rem);	// concat MOD and REM.
		
	}
		
	// Ten Thousands 
		
	function from_10000_to_99999(digit) {			// this fucntion perfromed 10000 to till 99999.
		
		if(digit > 0 ) { 
		
		    var mod 		= 	Math.floor(new Number(digit/1000));  // digit divided by 1000.
		
		    var rem 		= 	new Number(digit % 1000);			  // digit MOD by 1000.
		
		    return upto_100(mod) + " Thousand " + from_100_to_999(rem);  //  concat MOD and REM.
		
		}//end if
		
		else {
		
		    return ' '; 
		}
				
	}//end from 10000_to_99999
		
	// 1 lakh to 9 lakh
		
        function from_100000_to_999999(digit) {			// this function performed 100000 to till 999999.
		
							
		var mod 		= 	Math.floor(new Number(digit/100000));  // digit divided by 100000.
		    
		var rem 		= 	new Number(digit % 100000);			// digit MOD by 100000
		    
	    return ones[mod] + " Lakh " + upto_1_lakh(rem) ;	// concat both MOD and REM.
		    
	}	
		
	// 10 Lakhs to 99 lakh
		
	function from_1000000_to_9999999(digit) {				// this function performed 1000000 to till 9999999
		
		var mod = Math.floor(new Number(digit/100000));		// digit divided by 100000.
						
		var rem = new Number(digit % 100000);				// digit MOD by 100000.
		
	    return upto_100(mod)+ " Lakh " + temp_10lakh(rem);  //concat both MOD and REM.
	}
		
		
	// 1 crore to 9 crore 
		
	function from_10000000_to_99999999(digit) {				// This function perfrormed 10000000 to 99999999.
		
	        var mod = Math.floor(new Number(digit / 10000000)); // digit divied by 1 crore.
				
		var rem = new Number(digit % 10000000)				// digit  MOD by 1 crore.
		
	    return ones [mod]+"  Crore  " +temp (rem);
		
	}
		
		
	function upto_1000(digit) {     						// this function peformed till 1000.
		
		if(digit < 100) {									// if condition < 100 means function upto_100 working.
		    
		    return upto_100(digit);
		
		}
	         
		else {
		
		    return from_100_to_999(digit);						// if condition ELSE means from_1000 funcion working.
		}
	}
		
			
	function upto_1_lakh(digit) {							// this function performed till 1 lakh.
		
		
	    if ((digit > 100) && (digit <= 999)) {           // if conditio > 100 and <= 999 its going to function from_100_to_999.
		
		return from_100_to_999(digit);
	
	    }
				
	    else if ((digit >= 1000) && (digit <= 9999 )) { 	// if conditon > 1000 and <= 9999 means upto_1000 function working.
		
		    return from_1000_to_9999(digit);			
	    }
		
	    else if((digit >= 10000) && (digit <=99999 )){	   // if condition > 10000 and <= 99999 means from_10000 to 999999 function working.
		
		    return from_10000_to_99999(digit);			   //  
	    }
		
	    else {											   // if condition ELSE means uoto_1000 function working.
					
		    return upto_1000(digit);
	    }
				
		
	}
		
			
	// temp
		
	function temp_10lakh (digit){			// This function performed 100 to till 999
		
	    if( digit > 0 ){							// if condtion > 0 inside the condtion. 
				
		    if( (digit>99) && (digit<=120) ){	// if condition > 99 and <= 120 means its going to function upto_19.
						
			    return "One Hundred "+upto_19(digit-100);
		    }
		    else  if (digit < 100) {				// if condition ELSE IF and its < 100 means its going to function upto_100.
			
			    return upto_100(digit);
		    }
							
		    else if (( digit > 120 ) && (digit <=999)) {  // if condition ELSE IF  >120 and <=999 its going to function from_120_to_999.
			
			    return from_120_to_999(digit);  
		    }
		    else if ((digit >=1000) && (digit <=9999)) { // if condition ELSE IF >= 1000 and <= 9999 its going to function from_1000_to_9999
			
			    return from_1000_to_9999(digit);	
		    }
			
		    else if ((digit >= 10000) && (digit <=99999)) { // if condition ELSE IF >=10000 and <=99999  its going to function from_10000_to_99999.
					
			    return from_10000_to_99999(digit);
			
		    }
		    else {
			    return '' ;
		    }
		
	    }
	    else {
		
		return '' ;
	    
	    }
	}
		
				
				
	function temp (digit) { 
				
		if ( (digit >0 ) && (digit <= 99999 ) ) {
		
			return temp_10lakh(digit); 
					
		}
		
		else if (( digit >= 100000) && (digit <=999999)) {
		
			return from_100000_to_999999(digit);
		
		}
		
		else if (( digit >= 1000000) && (digit <=9999999)) {
		
			return from_1000000_to_9999999(digit);
		
		}
		
		else {
		
		    return '' ;
		}
		
		
	}//end number to words
	
	

/*************************************************************************************************************************************/
	 
	 
////////////////////////////////////////////////////////////////////////////////////////////////////
// 21-09-2015 selectbox_capture_selected_length
//
////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
