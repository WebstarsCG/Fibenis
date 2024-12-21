//////////////////////////////////////////////////////////////////////////////////////////////////////
// Desc: Waiting list is a system highly influnced by the waiting list system of indian railways.
//       The waiting list system continiously upate the current status until the cutoff time
//       In our application, there were few variables may need continiously update the status
//       like a simple machine status. Mostly in IoT case, the values will be continiously updated from sensor.
//       And more, the variables can be represented multiple times in the screen. 
//       So all the display variables have a same source, it should be reflected identically.
//       Conceptually it will be minimal version of React JS state update.  
//////////////////////////////////////////////////////////////////////////////////////////////////////
function WaitingList(train){		      
    
    this.train = train;
    this.seat  = {};
    //this.rx     ={'seat':/(\[\[)(wl\.)([\w\_\.\=\;]+)((\s+)((\w+)(\s*\=\s*)([\w\_\-\s]+)([a-zA-Z])))*?(\s*)(\]\])/ig};

    this.rx     ={'seat':/(\[\[)(wl\.)([\w\_\.\=\;]+)((\s+)((\w+)(\s*\=\s*)([\w\\_\-\s\<\>\/\"\'\&\;\=\$\.\:\(\)\%\{\}\,\?]+)([a-zA-Z0-9\<\>\/\"\'\&\;\=\$\.\:\(\)\%\{\}\,\?]*)))*?(\s*)(\]\])/ig};
     
    this.prepare = function(train){

            var lv = {};
            
			if(train){
				this.train = train;
			}		

			if(this.train){
			
				lv.plainContent = this.train.innerHTML;  
				
				lv.seat         = this.seat;

				// capture
				lv.taggedContent = lv.plainContent.replaceAll(this.rx.seat,function(match,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,offset,str){
					
					if(lv.seat[p3]){
						lv.seat[p3].count++
					}else{
						lv.seat[p3]={"count":1,'status':`${p9}${p10}`,'statusLog':[]};
					}
			
					return `<span data-wl='1' data-id='${p2}${p3}'>${p9}${p10}</span>`;
			
				});      
				
				if(Object.keys(this.seat).length>0){
					this.train.innerHTML = lv.taggedContent;
				} // len

				for(var seat_name of Object.keys(this.seat)){                
					this.seat[seat_name].elements = []; 
					this.seat[seat_name].elements = document.querySelectorAll("span[data-id='wl."+seat_name+"']");                
				}
			
				return true;
			}else{
				return false;
			}

    } // end
    
} // waiting list
    
// update status    
WaitingList.prototype.updateStatus=function(param){

    for(seat_name in param){

        if( this.seat[seat_name]){
            this.seat[seat_name].status = param[seat_name];

            for(const seat of this.seat[seat_name].elements){
                seat.innerHTML=param[seat_name];
            }

        }else{
            throw new Error(`Unlisted variable: ${seat_name}`);
        }
    }
} // end    

// get status
WaitingList.prototype.getStatus=function(seat_name){
    if(this.seat[seat_name]){
        return this.seat[seat_name].status;        
    }else{
        throw new Error(`Unlisted variable: ${seat_name}`);
    }
}

    
// update status    
WaitingList.prototype.updateStatusAPI=function(temp){
    setInterval((function(that,param){ 

                            var id = param.id;
                            that.updateStatus({'ns=1;i=2853':that.getResponse(param.url)});
                            console.log(param.id);
                    })(this,temp),
                    
                    1000);	
} // end    


WaitingList.prototype.getResponse=function(param){

    fetch(param.url, {
        method: 'GET', // or 'PUT'
        headers: {
			'Content-Type': 'application/json',
		}
    })
    .then((response) => response.json())
    .then((result) => {
        for(const kv of result.summary_fill){               
                var temp = {};
                temp[kv.token]=kv.value;
                this.updateStatus(temp);               
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });

}