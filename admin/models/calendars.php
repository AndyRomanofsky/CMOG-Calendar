<?php
/**
* @package CMOGCAL
* @subpackage Calendars
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, May 13, 2013 - 12:13:43 PM
* @filename calendars.php
* @folder \cmogcal\admin\models
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * EventsList Model
 */
class CmogCalModelCalendars extends JModelList
{
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
         
		 
         var $_order  = array();
		 var $_filter_search ="Month";
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
   
		   $categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', $default_cats);
		   $this->setState('filter.category_id', $categoryId);
   
		   $level = $this->getUserStateFromRequest($this->context.'.filter.level', 'filter_level', 0, 'int');
		   $this->setState('filter.level', $level);
   
		   $date = getDate();
		   
		   $month = $this->getUserStateFromRequest($this->context.'.filter.month', 'filter_month', $date["mon"], 'int');
		   $this->setState('filter.month', $month);
   
		   $year = $this->getUserStateFromRequest($this->context.'.filter.year', 'filter_year', $date["year"], 'int');
		   $this->setState('filter.year', $year);
		   
		   $template = $this->getUserStateFromRequest($this->context.'.filter.template', 'filter_template', 0, 'int');
		   $this->setState('filter.template', $template);
   
   
		   // List state information.
		   parent::populateState('a.title', 'asc');
	   }
	   
              
        protected function getListQuery()
        {
                // Set the order           
 		$orderby = "`Month`, `Day`, `Year`, `lft`, `ordering`";
		
		
            	$this->setState('filter_order', $this->_order[0]);
          	$this->setState('filter_order_Dir', $this->_order[1]);
          	$this->setState('filter_search', $this->_filter_search);

                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('a.ID,a.EventText,a.Month,a.Day,a.Year,a.catid,a.Class, a.gmd,a.published');
                // From the  Events table
                $query->from('#__CMOG_Events as a');
                // Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
                $query->order($orderby);

				
						// Filter by a single or group of categories.
							$baselevel = 1;
							$categoryId = $this->getState('filter.category_id');
							
	
                $default_cats[] = 311; 	
                $default_cats[] = 319; 	
                $default_cats[] = 308; 	
                $default_cats[] = 315; 	
                $default_cats[] = 316; 	
                $default_cats[] = 312; 	
                $default_cats[] = 313;						
							if ($categoryId == NULL) {
							$categoryId = $default_cats;
							}
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
						 // Filter by year
							$template = $this->getState('filter.template');
							if ($template < 0) {
								$query->where('a.gmd = ' . (int) $template);
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