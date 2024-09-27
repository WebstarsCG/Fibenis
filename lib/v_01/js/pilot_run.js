//////////////////////////////////////////////////////////////////////////////////////////////////////
// Desc:
//
//
//
//
//////////////////////////////////////////////////////////////////////////////////////////////////////
function PilotRun(param){		      
    
    this.route        = '';
    this.checkAreas   = [];
    this.checkPoints  = [];
    this.__temp       = {'e':'','token':[]};

    this.counter      = {'total':0,'totalValidate':0,
                         'item' :0,'itemValidate' :0 };

    this.matchOperations= [];
    this.matchOperations['ne']=(a,b)=>{ return (a!=b)?true:false;  };
    this.matchOperations['eq']=(a,b)=>{ return (a==b)?true:false;  };
    this.matchOperations['gt']=(a,b)=>{ return (a>b)?true:false;  };
    this.matchOperations['lt']=(a,b)=>{ return (a<b)?true:false;  };
    this.matchOperations['vlgt']=(a,b)=>{ return (a.length>b)?true:false;  };
    this.matchOperations['vllt']=(a,b)=>{ return (a.length<b)?true:false;  };

    //plural value check
    // any ofthe
    this.matchOperations['ao']=(a,b)=>{    this.g.log(`A:${a} | B:${b} `);
                                            for(const c of b){
                                                if(a==c){ return true;}
                                            } // each val
                                            return false;
                                    }; 
    
    // operations will be performed against clearence of check. Incase of unclearnace, block actions performed    
    this.operations    = [];

    this.operations['call']  = (a)=>{ this.g.log(`Call:${a}`);
                                         a();
                                    };

    this.operations['enable']  = (a)=>{ a.removeAttribute('disabled'); 
                                        a.classList.add('fbn-status-enable');
                                        a.classList.remove('fbn-status-disable');  
                                    };

    this.operations['disable'] = (a)=>{ a.setAttribute('disabled',true);
                                        a.classList.remove('fbn-status-enable');
                                        a.classList.add('fbn-status-disable');  
                                    };

    this.operations['show']  = (a)=>{ a.classList.remove('hide');};
    this.operations['hide']  = (a)=>{ a.classList.add('hide');   };

    this.operations['show_group']  = (a)=>{ 
                                        this.g.log(`Show Token:${this.__temp.token[a.id]}`); 
                                         element_show_hide_by_token([this.__temp.token[a.id]],{'status':true,'is_ro':0}); 
                                      };
    this.operations['show_panel']   = this.operations['show_group'];
    this.operations['show_g']       = this.operations['show_group'];                                 

    this.operations['hide_group']  = (a)=>{ 
                                        this.g.log(`Token:${this.__temp.token[a.id]}`); 
                                        element_show_hide_by_token([this.__temp.token[a.id]],{'status':false,'is_ro':1});   
                                    };
    this.operations['hide_panel']   = this.operations['hide_group'];
    this.operations['hide_g']       = this.operations['hide_group'];    

    this.operations['setval']  = (a,b)=>{ this.g.log(`A:${a.id} | B:${b} `); a.value=b; };     
    this.operations['setv']  = this.operations['setval'];

    // set, multiple elements, multiple attributes
    // 'set' :[{'<element_id>':{'<attr>':<value>}}]
    // 'set' :[{'<element_id>':{'<attr1>':<value1>,'<attr2>':<value2>,'<attr3>':<value3>}},
    //         {'<element_id_b>':{'<attr1>':<value1>,'<attr2>':<value2>,'<attr3>':<value3>}}]
    this.operations['set']  = (a,b)=>{ 
                                        this.g.log(`A:${a.id} | B:${b}`); 
                                        for(const c of Object.keys(b)){a.setAttribute(c,b[c]);} 
                                };
    
    // unset
    // 'unset' :[{'<element_id>':['attr']}]
    // 'unset' :[{'<element_id>':['attr_a','attr_b'] }],
    // 'unset' :[{'<element_id_a>':['attr_a','attr_b'] },{'<element_id_b>':['attr_a','attr_b'] }],
    this.operations['unset']  = (a,b)=>{ 
                                        this.g.log(`A:${a.id} | B:${b}`); 
                                        for(const c of b){a.removeAttribute(c);}    
                                };     

    if(param.f_series){
        this.f_series=param.f_series;
    }

    //exsitng 
    this.g = new General();

    this.checkPointAction = [];

    this.setRoute=function(route){
        if(route){
            this.route=route;
        }
    } // set router

    this.getE=function(token){

        this.g.log(`Token->${token}:${document.getElementById(token)}`);

        if((document.getElementById(token)!=null) && (document.getElementById(token)!=undefined)){
           
            this.__temp.e=this.g.$(token); 
        }else{
            this.__temp.e=this.getFE(token);  
            this.__temp.token[this.__temp.e.id] = token; 
        }
       
        return this.__temp.e;

    } // end

    this.getEV=function(token){
        return this.getE(token).value;
    }
    

    this.getFE=function(token){
        return this.f_series.getElementByToken(token);
    }

    this.getFEV=function(token){
        return this.f_series.getElementByToken(token).value;
    }
    

    // check list
    this.checkList = function(checkOperation,checkListItems){

        this.g.log(`${checkOperation}:${JSON.stringify(checkListItems)}`);

        // reset counters
        this.resetItemCounters();

        // each item
        for(const checkListItem of Object.keys(checkListItems)){

            this.g.log(`Each Item:${checkListItem}:${checkListItems[checkListItem]}`);

            // increase counter
            this.increaseCounter('item');
            
            if(this.matchOperations[checkOperation]){      
                
                this.g.log(`${this.getEV(checkListItem)}:${checkListItems[checkListItem]}`);
                
                if(this.matchOperations[checkOperation](this.getEV(checkListItem),checkListItems[checkListItem])==true){
                    this.increaseCounter('itemValidate');
                };

            } // end of match
        
        } // end of each item

        this.g.log(`Item Score:${this.getCounter('itemValidate')}/${this.getCounter('item')}`);

        //check result
        if(this.getCounter('itemValidate')==this.getCounter('item')){
            this.increaseCounter('totalValidate');
        }

    } // end of checklist

    // action
    this.action = function(actionItems){

         this.g.log(`Action Items:${JSON.stringify(actionItems)}`);

        // action 
        for(const actionItem of Object.keys(actionItems)){

            this.g.log(`Action Item:${actionItem}`);

            if(this.operations[actionItem]){

                for(const actionItemChild of actionItems[actionItem]){

                    this.g.log(`Action Item Child:${typeof actionItemChild}`);
                    
                    if(typeof actionItemChild == "object"){

                        this.g.log(`Action Item Child:${JSON.stringify(actionItemChild)}`);

                        for(const actionItemChildName of Object.keys(actionItemChild)){

                            this.g.log(`Action Item Child Name:${actionItemChildName}-->${actionItemChild[actionItemChildName]}`);
                            this.operations[actionItem](this.getE(actionItemChildName),actionItemChild[actionItemChildName]);
                        }

                    }else if(typeof actionItemChild == "string"){
                        this.operations[actionItem](this.getE(actionItemChild));
                    }
                    else if(typeof actionItemChild == "function"){
                        this.operations[actionItem](actionItemChild);
                    }
                }

            } // valid action

        } // traverse action

    } // end of action

       
} // PilotRun


PilotRun.prototype.run=function(){
  
    this.checkIn=this.getcheckAreas();

    this.g.log(`0.CheckIn:${JSON.stringify(this.checkIn)}`);

    

   
        this.checkAreas =(Array.isArray(this.checkIn)==false)?[this.checkIn]:this.checkIn;
   

    // for each area
    for(const checkArea of this.checkAreas){

        this.g.log(`1.CheckArea:${JSON.stringify(checkArea)}`);

        // rest
        this.resetCounters();
        
        // get points form area
        this.checkPoints = Object.keys(checkArea.check);

        // action case
        for(const checkPoint of this.checkPoints){

            // each item
            this.g.log(`2.Each Checkpoint:${checkPoint}`);

            // set counter
            this.increaseCounter('total');

            // get item
            this.checkList(checkPoint,checkArea.check[checkPoint]);
            
        } // case   

        // end
        this.g.log(`Final Score:${this.getCounter('totalValidate')}/${this.getCounter('total')}`);

        // check status
        if(this.isClear()){
            this.g.log(`Clear`);
            this.action(checkArea.clear);
        }else{
            this.action(checkArea.block);
        }

    } // each area

} // end


PilotRun.prototype.getcheckAreas=function(){
    return this.route;
}

// PilotRun.prototype.getcheckPointCheckList=function(checkPoint){
//     return this.route.check[checkPoint];
// }

PilotRun.prototype.increaseCounter=function(token){
    this.counter[token]++;
    return  this.counter[token];
}

PilotRun.prototype.getCounter=function(token){
    return  this.counter[token]++;
}

PilotRun.prototype.resetItemCounters=function(){    
    for(const item of ['item','itemValidate']){
        this.counter[item]=0;  
    }
} // end

PilotRun.prototype.resetCounters=function(){    
    for(const item of Object.keys(this.counter)){
        this.counter[item]=0;  
    }
} // end


PilotRun.prototype.isClear=function(){    
    return (this.getCounter('total')==this.getCounter('totalValidate'))?true:false;
} // end