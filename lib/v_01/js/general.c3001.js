
        /* c3001 */
    
        function c3001Create(param){            
        
                this.c3        = c3;                
                this.d_series = '';
                this.g        = G;                
                this.action   = {'gauge':this.gauge};
          
        } // class
		
		c3001Create.prototype.setDseries=function(param){
			this.d_series = param;			
		}
        
        // Donut
    
        c3001Create.prototype.graphDonut = function(param,ele){
                
                var lv         = new Object();
           
                lv.show_label  = param.show_label || false;
                lv.arc_width   = param.arc_width || 50;
                
                lv.title       = param.title || '';
                
                // cell count
				console.log("DS:"+JSON.stringify(this)+'---'+ele.id);		
				//this.d_series.custom_cell_count();
				
               // lv.element_id=this.d_series.get_defaut_cell_id({'cols':7,'skip':1,'incr':1});
                
                // data
                
                lv.data_a = param.replace(/\{/gi,"");
                lv.data_b = lv.data_a.replace(/\}/gi,"");
                lv.data_c = lv.data_b.replace(/\"\[/gi,"[");
                lv.data_d = lv.data_c.replace(/\]\"/gi,"]");
		
		//alert(lv.data_d);
                                                                                   
                lv.data   =  JSON.parse('['+lv.data_d+']');
		
				lv.data.shift();
                            
                // donut
            
                lv.addon     = {
                                        title:ele.getAttribute('data-title'),
                                        
                                        data:{
                                              
                                              
                                            columns: lv.data ,                                            
                                            type: 'donut',
                                                                                        
                                        },
                                       
                                        min:  lv.min, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
                                        max:  lv.max,
                                       
                                        label: {                                                      
                                                show: lv.show_label // to turn off the min/max labels.
                                        },
                                        
                                        size: {
                                           height: lv.height,
                                           width : lv.width
                                        },
                                         
                                        //units: '%',                                        
                                        width: lv.arc_width // for adjusting arc thickness
                                };
                                
                     
                                
                lv.canvas      ={
                                        'element_id'    : ele.id,                                        
                                        'ele'       : document.getElementById(ele.id),                        
                                        'is_row_data'   : 0                        
                                };
                    
                           
                
                return c3001.graph({'data': lv.data,
                            'addon':lv.addon,
                            'canvas':lv.canvas
                        });
                
        } // end
	
	
	// Time Series
        
        c3001Create.prototype.graphBase = function(param,ele){
                
                var lv         = new Object();
           
                lv.show_label  = param.show_label || false;
               
                
                lv.title       = param.title || '';
                
                
                
                // data
                
                lv.data_a = param.replace(/\{/gi,"");
                lv.data_b = lv.data_a.replace(/\}/gi,"");
                lv.data_c = lv.data_b.replace(/\"\[/gi,"[");
                lv.data_d = lv.data_c.replace(/\]\"/gi,"]");
                                                                                   
                lv.data   =  JSON.parse('['+lv.data_d+']');

				lv.cat = [];
				
				for(var x in lv.data){
					
					lv.cat.push(lv.data[x].shift());
					
				}
				
				lv.cat.shift();
			
            
                lv.addon     = {
                                        title:ele.getAttribute('data-title'),
                                        
                                        data: {
                                               // x    : lv.data[0][0],
                                               'type': G.isUndefined(ele.getAttribute('data-type'),'line'),                                                
                                                rows : lv.data,
                                                'axes':{}
										},
                                        
                                        bar: {
						
											width: G.isUndefined(ele.getAttribute('data-bar-width'),20) // this makes bar width 100px
                                        },
                                            
                                        axis: {
                                          x:{type: 'category',
										  categories:lv.cat
                                        },
                                          rotated:  G.isUndefined(ele.getAttribute('data-is-axis-rotated'),false)
                                        },
                                        grid: {
                                                x: {
                                                    show: G.isUndefined(ele.getAttribute('data-grid-x'),true)
                                                },
                                                y: {
                                                    show: G.isUndefined(ele.getAttribute('data-grid-y'),true)
                                                }
                                            },
					    
					 
                                };
                
                // dual exis case 'data-is-dual-axis'	=> true,                
                if(G.isUndefined(ele.getAttribute('data-is-dual-axis'),false)==true){

                    // set data index for y & y2
                    lv.addon.data.axes[lv.data[0][1]]='y';
                    lv.addon.data.axes[lv.data[0][1]]='y2'; 

                    // set yaxis
                    lv.addon.axis['y2'] = {show:true};

                } // dual axis

                if(G.isUndefined(ele.getAttribute('data-is-x-tick-rotate'),false)!=false){

                    lv.addon.axis.x['tick']= {
                                                rotate: ele.getAttribute('data-is-x-tick-rotate'),
                                                multiline: false,
                                                tooltip: true
                                            }

                }
                                
                                                     
                lv.canvas      ={
                                        'element_id'    : ele.id,                                        
                                        'elem'       : document.getElementById(ele.id),                        
                                        'is_row_data'   : 0                        
                                };
                                     
                
               return  c3001.graph({'data': lv.data,
                            'addon':lv.addon,
                            'canvas':lv.canvas
                        });
                
        } // end
	
    
        // Time Series
        
        c3001Create.prototype.timeSeries = function(param,ele){
                
                var lv         = new Object();
                
                // data
                
                lv.data_a = param.replace(/\{/gi,"");
                lv.data_b = lv.data_a.replace(/\}/gi,"");
                lv.data_c = lv.data_b.replace(/\"\[/gi,"[");
                lv.data_d = lv.data_c.replace(/\]\"/gi,"]");
                                                                                   
                lv.data   =  JSON.parse('['+lv.data_d+']');
                
                lv.addon     = {
                                        title:ele.getAttribute('data-title'),
                                        
                                        data: {
                                                x: 'x',
                                                'type':G.isUndefined(ele.getAttribute('data-type'),'line'),
                                                rows: lv.data
                                            },
                                        
										bar	: {  width: G.isUndefined(Number(ele.getAttribute('data-bar-width')),25) }, // width px
                                            
                                        axis: {
                                            x: {
                                                type: 'timeseries',
                                                tick: {
                                                    format	: G.isUndefined(ele.getAttribute('data-format'),'%d-%b-%y'),
													fit	  	: true,
													culling	: { max: G.isUndefined(ele.getAttribute('data-culling-max'),1) },                                                     
                                                }
                                            }
                                        },
										
                                        grid: {
                                                x: {
                                                    show: G.isUndefined(ele.getAttribute('data-grid-x'),false)
                                                },
                                                y: {
                                                    show: G.isUndefined(ele.getAttribute('data-grid-y'),false)
                                                }
                                            },
					    
										zoom	: { enabled: G.isUndefined(ele.getAttribute('data-zoom'),false)},
					    
										subchart: { show   :  G.isUndefined(ele.getAttribute('data-subchart'),false)}
                                };
                                
                     
                                
                lv.canvas      ={
                                        'element_id'    : ele.id,                                        
                                        'elem'       : document.getElementById(ele.id),                        
                                        'is_row_data'   : 0                        
                                };
                    
                           
                
                c3001.graph({'data': lv.data,
                            'addon':lv.addon,
                            'canvas':lv.canvas
                        });
                
        } // end
    
    
        c3001Create.prototype.graph = function(param){                
                        
                var lv = new Object({});
              
                lv.info=[];
                
                lv.param={};
                                
                var addon  = param.addon || {};
                
                var canvas  = param.canvas;
                
                var data    = param.data;
				
				canvas.elem = document.getElementById(canvas.element_id);
                
                // ha param
                
                if(data.length>0){
                        
                        // create head & cel content
                        lv.title                = canvas.elem.getAttribute('data-title');
						
						lv.node_area 			= document.createElement('DIV');
                        lv.node_area.id 		= `${canvas.element_id}_area`;
						lv.node_area.className = 'fbn-graph-area';
						
						
						
						lv.node_title 			= document.createElement('DIV');
                        lv.node_title.id 		= `${canvas.element_id}_head`;
						lv.node_title.className = 'fbn-graph-title';
						lv.node_title.innerHTML =  lv.title;
						
						lv.node_area.appendChild(lv.node_title);
						
						
						lv.node_graph 			= document.createElement('DIV');
                        lv.node_graph.id 		= `${canvas.element_id}_dash`;
						lv.node_graph.className = 'fbn-graph-plot';
						lv.node_area.appendChild(lv.node_graph); 
						
						canvas.elem.appendChild(lv.node_area);
						 
                        /* canvas.elem.innerHTML='<div id="'+canvas.element_id+'_head" class="title">'+lv.title+'</div>'+
                                                 '<div id="'+canvas.element_id+'_cont" ></div>'; */
                     
               
                        // lv param
                        
                        lv.param = {
                                
                                'bindto'      : canvas.element_id+'_dash',
								'root'		  : canvas.element_id,
                                'title'       : lv.title,                          
                                'addon'       : addon
                        };
                        
				
                        
                       return c3001.draw(lv.param);
					   
					   console.log(canvas.elem.innerHTML);
					   
					   
                    
                } // end
                
        } // end
                
        // dount/gauge/pie
        
        c3001Create.prototype.draw = function(param){
            
                var lv = new Object();
             
                // param
                console.log('2:'+JSON.stringify(param));
                lv.param       ={            
                                        bindto:'#'+param.bindto,    
                                          
                                        //tooltip: {
                                        //     show: false
                                        //}
                                };
                
                // addon
                
                if(param.addon!=undefined){
                
                        lv.addon_keys  = Object.keys(param.addon);
       
                        // each
                        
                        for(var idx in lv.addon_keys){
                           
                           lv.param[lv.addon_keys[idx]] = param.addon[lv.addon_keys[idx]];
                           
                        } // each addon param
                       
                } // end
				
			 	// lv.param['onrendered'] =function() {}; 
				
                                                                  
                ///////// Chart 
               bb.generate(lv.param);
			   return true;
			   
        } // end
            
            
        
        var c3001 = new c3001Create();              