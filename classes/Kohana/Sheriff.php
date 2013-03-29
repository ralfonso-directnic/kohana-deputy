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
	class Kohana_Sheriff extends Kohana_Deputy
	{
		
	   /*Acts as a wrapper to set_role
	    * 
	    * $account_id 
	    * 
	    * */		
	   
	   
	  public function access($account_id){
	   	       	
			$build = DB_ORM::select("UserGroups");
			$build->join("Groups");
			$build->using("group_id");
			$build->join("Resources");
			$build->using("group_id");
			$build->where("account_id","=",$account_id);
			$builder->group_by("route");
			$results = $build->query();
		
			if ($results->is_loaded()) {
			   foreach ($results as $record) {
			       $arr[$record->route]=$record->route;
			   }
			}
			
			if(count($arr)>0){
				
				$this->set_role("",$arr);	
				
			}
	
		
		}
	
	}
