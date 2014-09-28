<?php
/**
* @package CMOGCAL
* @subpackage Luke Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 1:31:13 PM
* @filename lukereadings.php
* @folder \cmogcal\site\models
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

// import the Joomla modellist library
jimport('joomla.application.component.modellist');


class CmogCalModelLukeReadings extends JModelList
{
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
         
        
		 var $_filter_search ="";
         var $_total = null;
         var $_data;
		 
        function __construct() 
        {
                $this->_order[] = JRequest::getVar('filter_order', 'week', 'POST', 'cmd');
                $this->_order[] = JRequest::getVar('filter_order_Dir', 'asc', 'POST', 'word');
                $this->_filter_search = JRequest::getVar('filter_search', '', 'POST');
                parent::__construct();
        }
        public function getDisplayWeeks()
		{
		  // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('DISTINCT week');
				$query->where('gmd = -3');
                // From the templates table
                $query->from('#__cmog_templates');
		// Return the result
				RETURN $db->loadObjectList();
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
                $query->select ('a.Class,a.Link,a.hymn,a.icon,a.popup');
				$query->where('a.gmd = -3');
                // From the templates table
                $query->from('#__cmog_templates as a');
				
		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		
        // Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
                $query->order($orderby);  
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
				
										   
		// Implement View Level Access
		if (!$user->authorise('core.admin'))
		{
		    $groups	= implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN ('.$groups.')');
		}
                return $query;
     }
	 
		
		/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   11.1
	 */
	public function getItems()
	{
		// Get a storage key.
		$store = $this->getStoreId();

		// Try to load the data from internal storage.
		if (isset($this->cache[$store]))
		{
			return $this->cache[$store];
		}

		// Load the list items.
		$query = $this->_getListQuery();
		$items = $this->_getList($query, 0, 350);

		// Check for a database error.
		if ($this->_db->getErrorNum())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Add the items to the internal cache.
		$this->cache[$store] = $items;

		return $this->cache[$store];
	}
}