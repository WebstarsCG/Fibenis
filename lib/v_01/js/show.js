
    // show user info
    
    var show_temp = new Object({});
    
    function boolean_display(content){
		
        var style = (Number(content)==1)?'clr_box_green':'clr_box_red';
        
        return put_style({ 'style':style+'  pad_7 round',
                    'content': ''
            });
        
    } // end
    
    
    // label grand father
    
    function label_grand_father(content){
        
         return put_style({ 'style':'label_grand_father',
                    'content': content
            });
        
    } // end
    
    // label father
       
    function label_father(content){
        
         return put_style({ 'style':'label_father',
                    'content': content
            });
        
    } // end
    
    
    // NA
    
    function na(content){
        
        if(Number(content)==0){
             return put_style({ 'style':'label_grand_child',
                        'content': 'NA'
            });
        }else{
            trim_and_tip(content,22);
        }
        
    } // end
    
    // show as icon 
    
    function put_icon(param){
        
        
        return '<div class="icon '+param+'"></div>' ;
        
    } // put simple
    
    // show as icon & hint
    
    function put_icon_title(param){
        
        show_temp['put_icon_hint'] = param.split(','); 
        
        return '<div class="icon '+show_temp['put_icon_hint'][0]+'"  title="'+show_temp['put_icon_hint'][1]+'"></div>' ;
        
    } // put simple
    
    // put style
    
    function put_style(param){
        
        var tag = (param.tag!=undefined)?param.tag:'font';
        
        return '<'+tag+' class="'+param.style+'"'+param.attr+'>'+param.content+'</'+tag+'>';
        
    } // put simple
    
    
     // put style
    
    function get_style(param){
        
        var tag = (param.tag!=undefined)?param.tag:'span';
        
        return '<'+tag+' class="'+param.style+'" '+param.attr+'>'+param.content+'</'+tag+'>' ;
        
    } // put simpl
    
    
        
    
    // show phone mobile email info
    
    function show_phone_mobile_email(param){
        
        show_temp = undefined;
        
        show_temp = param.split('[C]');
        
        document.write('<font class="telephone icon opacity_75">&nbsp;</font>'+show_temp[0]+'<br>'+
                       '<font class="phone icon opacity_75">&nbsp;</font>'+show_temp[1]+'<br>'+
                       '<font class="email icon opacity_75">&nbsp;</font>'+show_temp[2]
                       );
                
    } // end
    
    
    // show phone mobile email info
    
    function show_list(param){
        
        var lv=new Object({});
        
        var show_temp; 
        
        lv.temp ='';
        
        
        show_temp = param.split(',');
        
        lv.list_idx_length = show_temp.length-1;
        
        for(var idx in show_temp){
            
            lv.temp+=(lv.list_idx_length==idx)?show_temp[idx]:show_temp[idx]+'<font class="spliter"> | </font>';            
            
        } // end
                
        return '<font class="no_wrap">'+lv.temp+'</font>';
                
    } // end
    
    // Show base image
    
    function show_entity_child_image(img_id){
              
                  if(img_id!=0){
                    
                      put_style({'tag':'img',
                                 'attr':' width="50px" src="images/entity/child/'+img_id+'1.jpg"',
                                 'content':''
                      });
                      
                  } //if
              
          } // end
    
       // show phone mobile email info
    
    function show_by_lines(param){
        
        var lv=new Object({});
        
        var show_temp; 
        
        lv.temp ='';
        
        
        show_temp = param.split(',');
        
        lv.list_idx_length = show_temp.length-1;
        
        for(var idx in show_temp){
            
            lv.temp+=(lv.list_idx_length==idx)?show_temp[idx]:show_temp[idx]+'<br>';            
            
        } // end
                
        return '<font class="no_wrap">'+lv.temp+'</font>';
                
    } // end
    
    
    // show user info
    
    function show_user_info(param){
        
        show_temp = undefined;
        
        show_temp = param.split(',');
        
        return  show_temp[0]+'&nbsp;<font class="label_grand_child no_wrap">|&nbsp;'+show_temp[1]+'</font>';
                
    } // end
    
    // show user info
    
    function show_user_info_2l(param){
        
        show_temp = undefined;
        
        show_temp = param.split(',');
        
        return '<div>'+show_temp[0]+'</div><div><span class="label_grand_child no_wrap">'+show_temp[1]+'</span></div>';
                
    } // end
    
    
    // tip from list
    
    function tip_from_list(param){
        
        show_temp = undefined;
        
        show_temp = param.split(',');
        
        var show_formated = param.replace(/\,/g,'<br>');
        
        if(show_temp[1]!=undefined){        
            return '<a class="tip">'+show_temp[0]+'..</a>'+'<font class="tooltiptext">'+show_formated+'</font>';        
        }else{            
            return show_temp[0];            
        }
    } // end
    
    // tip from content
    
    function tip(hint,content,tip_style){
		
        if(hint.length>0){
            return `<a class="tip ${tip_style}">${hint}</a><font class="tooltiptext">${content}</font>`;            
        }else{
			return content;            
		}
        
    } // end
    
        
    // tip right
    function tip_right(hint,content,tip_style){    
		return tip(hint,content,'tip_right');        
    } // end
    
    // get tip    
    function get_tip(hint,content,tip_style){	
		return tip(hint,content,tip_style);
    } //end
	
	function grid_to_list_ol(content){
		return grid_to_list_tip({'content'   :content,
					  'list_type' :'ol',
					  'list_style':'decimal pad_10'
					 });
	} // end
	
	function grid_to_list_ul(content){
		return grid_to_list_tip({'content'   :content,
						  'list_type' :'ul',
						  'list_style':'bullet pad_10'
						 });
	} // end
	
	function grid_to_list_tip(param){
		
		var lv ={};
		
		lv.temp_content=JSON.parse(param.content);
		param.content  = lv.temp_content;
		lv.list = grid_to_list(param);	

		if(lv.list.items==1){
			lv.hint	   = '';
			lv.list.content = lv.temp_content[0].join(' ');
			
		}else if(lv.list.items>1){
			lv.hint	   = lv.temp_content[0].join(' ')+' (<b>'+(lv.list.items)+'</b>)';
		}
		
		// call tip func
		return tip(lv.hint,lv.list.content,'tip_bottom');		
		
	} // end
	
	// function 1 column grid
	function grid_to_list(param){
			
		var lv ={};
		lv.list	   = `<${param.list_type} class='${param.list_style}'>`;
		lv.list_counter =0;
		
		for(lv.rows of param.content){				
			if(lv.rows[0].length>0){
				lv.list_counter++;
				lv.list+= '<li>'+lv.rows.join(' ')+'</li>';
			}
		}
		
		lv.list+=`</${param.list_type}>`;
		
		return {'content':lv.list,'items':lv.list_counter};
		
	} // end
    
    // warranty
    
    function warranty(terms){
        
            var lv = new Object({});

            lv.temp='';
            
            for(var idx=0;idx<terms;idx++){
                
                lv.temp+='<i class="fa fa-star" aria-hidden="true">&nbsp;</i>';
            }

        
            return lv.temp +'&nbsp;&nbsp;<big>'+terms+'</big> Years Warranty';
    }
    
  
   function get_show_user_info(param){
        
        show_temp = undefined;
        
        show_temp = param.split(',');
        
        return show_temp[0]+'&nbsp;<font class="label_grand_child no_wrap">|&nbsp;'+show_temp[1]+'</font>';
                
   } // end
    
    // show header tag
	function heading_to_tag(tags,content_json){		
	
			show_temp.heading_content=[];	
			
			console.log(tags+'--'+typeof(tags)+'--'+content_json);

			for(let tag of tags){
				console.log('t'+tag);			
				show_temp.heading_content.push(`<${tag} >`+content_json[tag]+`</${tag}>`);
			}
			
			return show_temp.heading_content.join('');
	} // end
    
	// tag seperator
    function get_heading_tag(func_name){
		show_temp = {'tag':[],'func_text':[]};	
		
		show_temp.func_text = func_name.split('_');
		show_temp.tag 		= show_temp.func_text[1].match(/(h[1-6])/ig);
		
		return show_temp.tag;
	}

	const heading_to_tag_caller = (content_text,elem)=>{
		
		elem.innerHTML =  heading_to_tag(get_heading_tag(elem.dataset.jsOut),JSON.parse(content_text));
	};	
	
	// single call
	const heading_h1   = heading_to_tag_caller;
	const heading_h2   = heading_to_tag_caller;
	const heading_h3   = heading_to_tag_caller;
	const heading_h4   = heading_to_tag_caller;
	const heading_h5   = heading_to_tag_caller;
	const heading_h6   = heading_to_tag_caller;
	
	const heading_h1h2 = heading_to_tag_caller;
	const heading_h2h1 = heading_to_tag_caller;
	
	const heading_h3h4 = heading_to_tag_caller;
	const heading_h4h3 = heading_to_tag_caller;
	const heading_h3h5 = heading_to_tag_caller;
	const heading_h5h3 = heading_to_tag_caller;
	const heading_h3h6 = heading_to_tag_caller;
	const heading_h6h3 = heading_to_tag_caller;
	
	const heading_h4h5 = heading_to_tag_caller;
	const heading_h5h4 = heading_to_tag_caller;
	const heading_h4h6 = heading_to_tag_caller;
	const heading_h6h4 = heading_to_tag_caller;
	
	const heading_h5h6 = heading_to_tag_caller;
	const heading_h6h5 = heading_to_tag_caller;
    
	//triple
	const heading_h1h2h3 = heading_to_tag_caller;
	const heading_h3h2h1 = heading_to_tag_caller;
	const heading_h4h5h6 = heading_to_tag_caller;
	const heading_h6h5h4 = heading_to_tag_caller;
	
	
	//color processor
	function clr_to_tag(tags,content_json){		
	
			show_temp.clr_content=[];	
			show_temp.clr_code={'R':'clr_red',
								'G':'clr_green',
								'B':'clr_dark_blue',
								'O':'clr_orange'};
			
			for(let tag of tags){							
				show_temp.clr_content.push(`<h4 class="`+show_temp.clr_code[tag]+`" >`+content_json[tag]+`</h4>`);
			}
			
			return show_temp.clr_content.join('');
	} // end
    
	// tag seperator
    function get_clr_tag(func_name){
		
		show_temp = {'tag':[],'func_text':[]};	
		
		show_temp.func_text = func_name.split('_');
		show_temp.tag 		= show_temp.func_text[1].match(/([a-zA-Z])/ig);
		
		return show_temp.tag;
	}

	const clr_to_tag_caller = (content_text,elem)=>{
		
		elem.innerHTML =  clr_to_tag(get_clr_tag(elem.dataset.jsOut),JSON.parse(content_text));
	};
	
	const clr_RGB = clr_to_tag_caller;
	const clr_OGB = clr_to_tag_caller;
	const clr_BGO = clr_to_tag_caller;