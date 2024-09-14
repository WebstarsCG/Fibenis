//////////////////////////////////////////////////////////////////////////////////////////////////////
// Desc:
//
//
//
//
//////////////////////////////////////////////////////////////////////////////////////////////////////
function PilotRun(param){		      
    
    this.route        = '';
    this.checkPoints  = [];

    this.counter      = {'total':0,'totalValidate':0,
                         'item' :0,'itemValidate' :0 };

    this.matchOperations= [];
    this.matchOperations['ne']=(a,b)=>{ return (a!=b)?true:false;  };
    this.matchOperations['eq']=(a,b)=>{ return (a==b)?true:false;  };
    this.matchOperations['gt']=(a,b)=>{ return (a>b)?true:false;  };
    this.matchOperations['lt']=(a,b)=>{ return (a<b)?true:false;  };
    this.matchOperations['vlgt']=(a,b)=>{ return (a.length>b)?true:false;  };
    this.matchOperations['vllt']=(a,b)=>{ return (a.length<b)?true:false;  };
    

    this.operations    = [];
    this.operations['enable']  = (a)=>{ a.removeAttribute('disabled'); 
                                        a.classList.add('fbn-status-enable');
                                        a.classList.remove('fbn-status-disable');  
                                    };

    this.operations['disable'] = (a)=>{ a.setAttribute('disabled',true);
                                        a.classList.remove('fbn-status-enable');
                                        a.classList.add('fbn-status-disable');  
                                    };

    this.operations['show']  = (a)=>{ a.classList.remove('hide');};
    this.operations['hide']  = (a)=>{ a.classList.add('hide');};

    this.operations['setval']  = (a,b)=>{ this.g.log(`A:${a.id} | B:${b} `); a.value=b; };

    this.operations['attr']  = (a,b,c)=>{ this.g.log(`A:${a.id} | B:${b} | C:${c}`); a.setAttribute(b,c); };
    this.operations['uattr']  = (a,b)=>{ this.g.log(`A:${a.id} | B:${b}`); a.removeAttribute(b);  };



    // set
    this.operations['set']  = (a)=>{    this.g.log(`List:${JSON.stringify(a)}`); 
                                        for(const b in a){        
                                            
                                            const c = a[b];

                                            this.g.log(`Key:${b} Child ${JSON.stringify(a[b])}`);
                                            for(const d of Object.keys(c)){

                                                this.g.log(`Grand Child ${JSON.stringify(d)}`); 
                                                this.g.log(`Elem ${b} ${this.f_series.getElementByToken(b)} Key ${d} | Value ${c[d]}`);  
                                                
                                                this.operations['attr'](this.getFE(b),d,c[d]);
                                               
                                            } // traverse item key
                                        } // traverse item
                                    };
    
    // setval
    this.operations['setv']  = (a)=>{    this.g.log(`List:${JSON.stringify(a)}`); 
                                         for(const b in a){ 
                                            const c = a[b];
                                            this.g.log(`Key:${b} | Val;${c}`);       
                                            this.operations['setval'](this.getFE(b),c);
                                        } // traverse item
                                    };

    // unset
    this.operations['unset']  = (a)=>{    this.g.log(`List:${JSON.stringify(a)}`); 
                                         for(const b in a){        
                                            
                                            const c = a[b];

                                            this.g.log(`Key:${b} Child ${JSON.stringify(a[b])}`);
                                            for(const d of c){

                                                this.g.log(`Grand Child ${JSON.stringify(d)}`); 
                                                this.g.log(`Elem ${b} ${this.f_series.getElementByToken(b)} Key ${d} `);  
                                                
                                                this.operations['uattr'](this.getFE(b),d);
                                               
                                            } // traverse item key
                                        } // traverse item
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
                
                this.g.log(`${this.getFEV(checkListItem)}:${checkListItems[checkListItem]}`);
                
                if(this.matchOperations[checkOperation](this.getFEV(checkListItem),checkListItems[checkListItem])==true){
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

                    this.g.log(`Action Item Child:${actionItemChild}`);
                    this.operations[actionItem](((typeof actionItemChild == "string")?this.g.$(actionItemChild):actionItemChild));
                }

            } // valid action

        } // traverse action

    } // end of action

       
} // PilotRun


PilotRun.prototype.run=function(){
  
    this.checkPoints=this.getcheckPoints();

    this.g.log(`1.Checkpoints:${JSON.stringify(this.checkPoints)}`);

    this.resetCounters();

    // // action case
    for(const checkPoint of this.checkPoints){

        // each item
        this.g.log(`2.Each Checkpoint:${checkPoint}`);

        // set counter
        this.increaseCounter('total');

        // get item
        this.checkList(checkPoint,this.getcheckPointCheckList(checkPoint));
        
    }    

    // end
    this.g.log(`Final Score:${this.getCounter('totalValidate')}/${this.getCounter('total')}`);

    // check status
    if(this.isClear()){
        this.g.log(`Clear`);
        this.action(this.route.clear);
        //this.checkList(this.route.,this.getcheckPointCheckList(checkPoint));
    }else{
        this.action(this.route.block);
    }

} // end


PilotRun.prototype.getcheckPoints=function(checkPoint){
    return Object.keys(this.route.check);
}

PilotRun.prototype.getcheckPointCheckList=function(checkPoint){
    return this.route.check[checkPoint];
}

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