<?php
/**
* @package CMOGCAL
* @subpackage  By date Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 21, 2013 - 2:55:43 PM
* @filename bydatereadings.php
* @folder \cmogcal\site\models
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class CmogcalModelBydateReadings extends JModelList
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
                parent::__construct();
        }
		/**
         * Populate State
         */
		protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();

		// Adjust the context to support modal layouts.
		if ($layout = JRequest::getVar('layout')) {
			$this->context .= '.'.$layout;
		}
        $date = getDate();
		
		$month = $this->getUserStateFromRequest($this->context.'.filter.month', 'filter_month', $date["mon"], 'int');
		$this->setState('filter.month', $month);

		$year = $this->getUserStateFromRequest($this->context.'.filter.year', 'filter_year', $date["year"], 'int');
		$this->setState('filter.year', $year);
		
		// List state information.
		parent::populateState('a.Month', 'asc');
	}
		         
		/**
         * Get the List Query
         */
        protected function getListQuery()
        {
		$user	= JFactory::getUser();
		
		

$state= $this->get('state');


			$filter_month = $this->getState('filter.month');
			$filter_year = $this->getState('filter.year');

         $date = getDate();
 if (!isset($filter_month)) $filter_month = $date["mon"];
 if (!isset($filter_year)) $filter_year = $date["year"];

                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('*');
                // From the Events table
                $query->from('#__CMOG_Events as a');
					$query->where("((a.Year = -1) or (a.Year = $filter_year))" ) ;
			        $query->where("a.Month = $filter_month" ) ;
					$query->where("a.Class = 'read'  and a.published = 1" ) ;
			        $query->order("`Month`, `Day` , `ordering` ");
				 

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
		$items = $this->_getList($query, 0, 450);

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
		