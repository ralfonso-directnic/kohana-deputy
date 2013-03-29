<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Deputy ACL
 * 
 * By default, all resources are denied permission. When access is checked for a given resource, 
 * ACL iterates through each role checking for both allow and deny. Ambiguity is handled by 
 * returning the result of a role with the most explicit definition. Checking for allowed across 
 * the roles will continue if a role returns false. If allow at anytime returns true, the result 
 * will stop with true. If deny at anytime returns true, the result of the check will stop with 
 * false.
 * 
 * @package		Sheriff
 * @category	Base
 * @author		Micheal Morgan <micheal@morgan.ly>
 * @copyright	(c) 2011-2012 Micheal Morgan
 * @license		MIT
 */
	Abstract class Kohana_Sheriff extends Kohana_Deputy
	{
		
	   /*Acts as a wrapper to set_role
	    * 
	    * $account_id 
	    * 
	    * */		
		public static function instance(array $config = array()){
			static $instance;
			
			if ($instance === NULL)
			{
				$instance = new Sheriff($config);
			}
			
			return $instance;
		}	 
		   
	  public function allowed_route(){
	  	//this needs more support for added params etc.
			$route = strtolower("/".Request::current()->controller()."/".Request::current()->action());
			return $this->allowed($route);
			
	  }		 
			 
	  public function access($account_id){
	   	       	
			$build = DB_SQL::select("default")->from("Desktop.UserGroups");
			$build->join(INNER,"Desktop.Groups");
			$build->using("group_id");
			$build->join(INNER,"Desktop.Resources");
			$build->using("group_id");
			$build->where("account_id","=",$account_id);
			$build->group_by("route");
			$results = $build->query();
		
			if ($results->is_loaded()) {
			   foreach ($results as $record) {
			  
					 $record= (object)$record;
			     $arr[$record->route]=$record->route;
			   }
			}
			
			
			if(count($arr)>0){
				$routes = array_values($arr);//reduce to numeric keys
				$this->set_role("",$routes);	
			}
	
		
		}
	
	}
