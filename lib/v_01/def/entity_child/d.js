

    
   
    
    function get_checked_items(element_length,prefix){
        
        var lv = new Object({});
        
        lv.checked_items=[];
        
        for(ele_index=1;ele_index<=element_length;ele_index++){
            
            lv.element = document.getElementById(prefix+''+ele_index);   
            
            if(lv.element.checked==true) {
             
                lv.checked_items.push(lv.element.value);
            }
        }
        
        return lv.checked_items.join(',');
    }

    // set active
    function set_active(elem){
        set_active_inactive(elem,1);
    }

    // set inactive
    function set_inactive(elem){
        set_active_inactive(elem,0);
    }

    function set_active_inactive(elem,status){
        
        var lv = new Object({});
        
        lv.check_item_text = get_checked_items(GET_E_VALUE('COUNTER'),'c');
        
        if(lv.check_item_text.length>0){
            
            lv.param_data={'id':lv.check_item_text,'fv':status};

            if(elem.dataset.attr){

                lv.attr = JSON.parse(elem.dataset.attr);

                for(const key in lv.attr) {
                    lv.param_data[key] = lv.attr[key];
                }

            } // end
            
            G.showLoader('Checking Action...');

            d_series.ajax.set_request('router.php','&series=a&action=entity_child&token=ECAIBL&param='+JSON.stringify(lv.param_data));
            
            d_series.ajax.send_get(active_response_action);
            
        }else{
                
            bootbox.alert('Kindly select an item');            
        }
        
    } // end
    
       
    function active_response_action(response){        
        
        G.hideLoader('Checking Action...');

        if (Number(response)==0){
            bootbox.alert('Unable to process');
        }else{
            bootbox.alert("Successfully Updated, Can we reload the page?",function(){ page_reload(); });  
        }
    
    } // end
   