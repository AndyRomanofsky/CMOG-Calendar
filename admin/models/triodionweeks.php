<?php
/**
* @package CMOGCAL
* @subpackage Triodion Weeks
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Thursday, May 09, 2013 - 8:34:52 AM
* @filename triodionweeks.php
* @folder \cmogcal\admin\models
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * TriodionWeeksList Model
 */
class CmogCalModelTriodionWeeks extends JModelList
{
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
         var $_order  = array();
		 var $_filter_search ="";
         var $_total = null;
         var $_data;
		 
        function __construct() 
        {
                $this->_order[] = JRequest::getVar('filter_order', 'week', 'POST', 'cmd');
                $this->_order[] = JRequest::getVar('filter_order_Dir', 'asc', 'POST', 'word');
                $this->_filter_search = JRequest::getVar('filter_order', '', 'POST', 'word');
                parent::__construct();
        }
			protected function populateState($ordering = null, $direction = null)
		{
			// Initialise variables.
			$app = JFactory::getApplication();
			$session = JFactory::getSession();
	
			// Adjust the context to support modal layouts.
			if ($layout = JRequest::getVar('layout')) {
				$this->context .= '.'.$layout;
			}
	
			$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
			$this->setState('filter.search', $search);
	
			$access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
			$this->setState('filter.access', $access);
	
			$authorId = $app->getUserStateFromRequest($this->context.'.filter.author_id', 'filter_author_id');
			$this->setState('filter.author_id', $authorId);
	
			$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
			$this->setState('filter.published', $published);
	
			$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id');
			$this->setState('filter.category_id', $categoryId);
	
			$level = $this->getUserStateFromRequest($this->context.'.filter.level', 'filter_level', 0, 'int');
			$this->setState('filter.level', $level);
	
			$week = $this->getUserStateFromRequest($this->context.'.filter.week', 'filter_week', 0, 'int');
			$this->setState('filter.week', $week);
	
			$weekday = $this->getUserStateFromRequest($this->context.'.filter.weekday', 'filter_weekday', 0, 'int');
			$this->setState('filter.weekday', $weekday);
	
			$access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
			$this->setState('filter.access', $access);
			
					$showlinks = $this->getUserStateFromRequest($this->context.'.filter.showlinks', 'filter_showlinks', 'No');
					$this->setState('filter.showlinks', $showlinks);
 
		$findentries = $this->getUserStateFromRequest($this->context.'.filter.findentries', 'filter_findentries', 'No');
		$this->setState('filter.findentries', $findentries);
	
		if 	($findentries === "Yes"){			
		   $date = getDate();
		   
		$year = $this->getUserStateFromRequest($this->context.'.filter.year', 'filter_year', $date["year"], 'int');
		$this->setState('filter.year', $year);
		}
	
			// List state information.
			parent::populateState('a.title', 'asc');
		}
			
              
        protected function getListQuery()
        {
		$user	= JFactory::getUser();
 		$direction = $this->_order[1];
                // Check the order           
		if(empty($this->_order[0])) {
			 $orderby = "`week` $direction , `wday`";
			 }			
		else	 
		         {
			/* also, day and week go together */
			if ($this->_order[0] == 'week') {
          		  $orderby = "`week` $direction , `wday`";
      		        } elseif ($this->_order[0] == 'wday') {
     		          $orderby = "`wday` $direction , `week`";
     		        } else  {
     		          $orderby = $this->_order[0];
     		          $orderby .= " $direction" ;
     		        }
            	  }
            	$this->setState('filter_order', $this->_order[0]);
          	$this->setState('filter_order_Dir', $this->_order[1]);
          	$this->setState('filter_search', $this->_filter_search);

                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
				$query->select ('a.ID,a.EventText,a.week,a.wday,a.catid,a.gmd,a.published,a.access');
				$query->where('a.gmd = -4');
                // From the LukeWeeks table
                $query->from('#__cmog_templates as a');
				
				
						// Join over the asset groups.
						$query->select('ag.title AS access_level');
						$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
						
                // Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
                $query->order($orderby);

	
			//show links?
			$showlinks = $this->getState('filter.showlinks');	
			if 	($showlinks === "Yes"){		
				 $query->select ('a.Link,a.hymn,a.icon');
			}			
				
						$findentries = $this->getState('filter.findentries');	
						if 	($findentries === "Yes"){	
						// Join over the loaded entries.
						$query->select('e.ID AS entry_id, e.Month AS entry_month, e.Day AS entry_day, e.Year AS entry_year');
							$year = $this->getState('filter.year');
							if ($year > 0){
						 $query->where('((e.Year IS NULL) OR (e.Year = ' . (int) $year .'))');
						 $query->join('LEFT', '#__CMOG_Events AS e ON (a.ID = e.tmplt_id  AND a.gmd = e.gmd AND e.Year = ' . (int) $year .' )');
								} else {
						 $query->join('LEFT', '#__CMOG_Events AS e ON (a.ID = e.tmplt_id and a.gmd = e.gmd )');
						  }     
						 }       
					// Filter by a single or group of categories.
						$baselevel = 1;
						$categoryId = $this->getState('filter.category_id');
						if (is_numeric($categoryId)) {
							$cat_tbl = JTable::getInstance('Category', 'JTable');
							$cat_tbl->load($categoryId);
							$rgt = $cat_tbl->rgt;
							$lft = $cat_tbl->lft;
							$baselevel = (int) $cat_tbl->level;
							$query->where('c.lft >= '.(int) $lft);
							$query->where('c.rgt <= '.(int) $rgt);
						}
						elseif (is_array($categoryId)) {
							JArrayHelper::toInteger($categoryId);
							$categoryId = implode(',', $categoryId);
							$query->where('a.catid IN ('.$categoryId.')');
						}	
				
				
						// Filter by search in EventText.
						$search = $this->getState('filter.search');
						if (!empty($search)) {
								$search = $db->Quote('%'.$db->escape($search, true).'%');
								$query->where('(a.EventText LIKE '.$search.')');
							}
								
														   
					 // Filter by published state
						$published = $this->getState('filter.published');
						if (is_numeric($published)) {
							$query->where('a.published = ' . (int) $published);
						}
						elseif ($published === '') {
							$query->where('(a.published = 0 OR a.published = 1)');
						}       						   
							      
									// Filter by access level.
									if ($access = $this->getState('filter.access')) {
										$query->where('a.access = ' . (int) $access);
									}
							
									// Implement View Level Access
									if (!$user->authorise('core.admin'))
									{
										$groups	= implode(',', $user->getAuthorisedViewLevels());
										$query->where('a.access IN ('.$groups.')');
									}
																		   
					 // Filter by week
						$week = $this->getState('filter.week');
						if ($week > 0) {
							$query->where('a.week = ' . (int) $week);
						}  							   
														   
					 // Filter by weekday 
					 // (sunday is 0 or 7) 
						$weekday = $this->getState('filter.weekday');
						if (($weekday > 0 ) and ($weekday < 7))   {
							$query->where('a.wday = ' . (int) $weekday);
						}     
						elseif ($weekday == 7) {
			$query->where('(a.wday = 0 OR a.wday = 7)');
						}
                return $query;
        }
}