<?PHP

	//setStatusFor(<id>)->getKey('BKCNST')->setValue('BKCNSTGVER')->setNote('note')->whereCurrentStatusAs('BKCNSTCONF')->run();
		// run/go

class TemplateX extends General{

	protected $template; 

	protected $engine;

	protected $isDebug=0;

	
	function __construct(){								
		
			$this->template =  (object)	[	    'content'			=> '',
												'output'		    => ''

										]; // end of template
	
	} // end


	function debugOn(){	$this->isDebug=1;}  // will prevent to run the query
	function debugOff(){ $this->isDebug=0;}


	function getTemplate($token){

			$lv = (object) ['template'=>''];

			// clean to token syntax
			$token = $this->getCleanAlphaNum($token);

			// invalid token
			if(strlen($token)==0){
			
				throw new Exception("There is no valid token given");	
			
			}else{ // valid token

				$lv->template = $this->get_one_column(['table'		  => 'exav_addon_vc128uniq',
													   'field'		  => "get_exav_addon_text(parent_id,'TMPLCONT')",
													   'manipulation' => " WHERE exa_token='TMPLCODE' AND UPPER(exa_value)=UPPER('$token') "
				]);

				if($lv->template){
					$this->template->content = $lv->template;
					$this->engine = new Template(['template_content'=>$this->template->content]);	
				}else{
					throw new Exception("No template available for the token <b>$token</b>");	
				}

			} // end of check token

			return $this;
 
	} // end of template

	// add param
	function addParam($key,$value){
		
		if($key){
			$this->engine->AddParam($key,$value);
		}
		
		return $this;
	}

	// rendering
	function render(array $param=null){

		if(gettype($param)=='array'){
			$this->engine->AddParam($param);
		}

		$this->template->output = $this->engine->Output();
		return $this;

	} // end 

	// return processed
	function getOutput(){
			return $this->template->output;
	} // end 
	

} // end of class

$X=new TemplateX();
