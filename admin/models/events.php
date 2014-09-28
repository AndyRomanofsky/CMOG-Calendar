<?php
/**
* @package CMOGCAL
* @subpackage events
* @copyright Copyright Andrew W Romanofsky - 
*                      Church Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Wednesday, April 17, 2013 - 11:01:32 AM
* @filename events.php
* @folder \cmogcal\admin\models
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * EventsList Model
 */
class CmogCalModelEvents extends JModelList
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
                $this->_order[] = JRequest::getVar('filter_order', 'Month', 'POST', 'cmd');
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

        $date = getDate();
		$day = $this->getUserStateFromRequest($this->context.'.filter.day', 'filter_day', $date["mday"], 'int');
		$this->setState('filter.day', $day);
		
		$month = $this->getUserStateFromRequest($this->context.'.filter.month', 'filter_month', $date["mon"], 'int');
		$this->setState('filter.month', $month);

		$year = $this->getUserStateFromRequest($this->context.'.filter.year', 'filter_year', $date["year"], 'int');
		$this->setState('filter.year', $year);
		
		$template = $this->getUserStateFromRequest($this->context.'.filter.template', 'filter_template', 0, 'int');
		$this->setState('filter.template', $template);

		$access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);
		
		$showlinks = $this->getUserStateFromRequest($this->context.'.filter.showlinks', 'filter_showlinks', 'No');
		$this->setState('filter.showlinks', $showlinks);				 

		// List state information.
		parent::populateState('a.title', 'asc');
	}
	
        
              
        protected function getListQuery()
  {
		$user	= JFactory::getUser();
 		$direction = $this->_order[1];
                // Check the order           
		if(empty($this->_order[0])) {
			 $orderby = "`Month` $direction , `Day` , `Year` , `ordering` DESC";
			 }			
		else	 
		         {
			/* also, day and week go together */
			if ($this->_order[0] == 'Month') {
          		  $orderby = "`Month` $direction , `Day`, `Year`";
      		        } elseif ($this->_order[0] == 'Day') {
     		          $orderby = "`Day` $direction , `Month`, `Year`";
      		        } elseif ($this->_order[0] == '') {
     		          $orderby = "`Year` $direction , `Day`, `Month`";
     		        } elseif ($this->_order[0] == 'gmd') {
     		          $orderby = "`gmd` $direction , `tmplt_id`";
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
                $query->select('a.ID,a.EventText,a.Month,a.Day,a.Year,a.catid,a.gmd,a.tmplt_id,a.published,a.access,a.ordering');
                $query->select('a.checked_out,a.checked_out_time');
                // From the  Events table
                $query->from('#__CMOG_Events as a');
				
				
						// Join over the asset groups.
						$query->select('ag.title AS access_level');
						$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
						
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');			
				
                // Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
                $query->order($orderby);
				
		
				//show links?
				$showlinks = $this->getState('filter.showlinks');	
				if 	($showlinks === "Yes"){		
					 $query->select ('a.Link,a.hymn,a.icon');
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
			if (!empty($search))  {
				if (stripos($search, 'id:') === 0) {
					$query->where('a.ID = '.(int) substr($search, 3));
				}
				elseif  (stripos($search, 'tid:') === 0) {
				$query->where('a.tmplt_id = '.(int) substr($search, 4));
				}
				else  {
					$search = $db->Quote('%'.$db->escape($search, true).'%');
					$query->where('(a.EventText LIKE '.$search.')');
				}
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
															   
		 // Filter by day of day
			$day = $this->getState('filter.day');
			if ($day > 0) {
				$query->where('a.Day = ' . (int) $day);
			}  							   
											   
		 // Filter by month 
			$month = $this->getState('filter.month');
			if ($month > 0 )   {
				$query->where('a.Month = ' . (int) $month);
			}   
		 // Filter by year
			$year = $this->getState('filter.year');
			if ($year > 0) {
				$query->where('((a.Year = -1) or (a.Year = ' . (int) $year .'))' );
			}  	
			if ($year == -1 ) {
				$query->where('a.Year = -1');
			}  		  
		 // Filter by template
			$template = $this->getState('filter.template');
			if ($template < 0) {
				$query->where('a.gmd = ' . (int) $template);
			} elseif ($template == 1) {
				$query->where('a.gmd = ""' );
			} elseif ($template == 2) {
				$query->where('a.Year = -1' );
			}   
						
                return $query;
        }
}