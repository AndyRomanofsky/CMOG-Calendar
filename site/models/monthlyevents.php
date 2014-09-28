<?php
/**
* @package CMOGCAL
* @subpackage Monthly Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 1:20:34 PM
* @filename monthlyevents.php
* @folder \cmogcal\site\models
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * MonthlyEvents List Model
 */
class CmogCalModelMonthlyEvents extends JModelList
{        /**
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
   function _buildWhere()
    {
$search = JRequest::getCmd('search');
$searchDay = JRequest::getCmd('SDay');
$searchMonth = JRequest::getCmd('SMonth');
$searchYear = JRequest::getCmd('SYear');
$WFilter= JRequest::getCmd('Filter');
$WFClass= JRequest::getCmd('FClass');
$WYear= JRequest::getCmd('WYear');


 $date = getDate();


 if ($searchDay == "") $searchDay = $date["mday"];
 if ($searchMonth == "") $searchMonth = $date["mon"];
 if ($searchYear == "") $searchYear = $date["year"];
 if ($WFilter == "") $WFilter = "FMonth";
$WFilter = "FMonth";
 if ($WFClass == "") $WFClass = "CNone";
 $WFClass = "CNone";
 
 
 //-----------------------------------------------------//
 // build the where cluse //
 if ($WYear) { 
            $FYear = " (`Year` = " . $searchYear . ") ";
        }else{ 
         $FYear = " ((`Year` = " . $searchYear . ") or(`Year` = -1 )) ";
	}
  
 switch ($WFilter) {
    case "Fnone":
         $where1 = "";
          break; 
    case "FSearch":if(!empty($search)){
              $where1 = "(EventText like '%$search%') ";
            }
          break; 
    case "FDate":
        $where1 = "(`Month` = " . $searchMonth . ") and (`Day` = " . $searchDay . ") and " .$FYear;
        break;
    case "FMonth":
        $where1 = "(`Month` = " . $searchMonth . ") and " .$FYear;
        break;
    default:
         $$where1 = "(`Month` = " . $searchMonth . ") and " .$FYear;
	}
	
         
switch ($WFClass) {
    case "FNone":
       $where2 = " ((`Class` = 'gf' ) or (`Class` = 'lf' ) or (`Class` = 'evt' ) or (`Class` = 'ser' ) or (`Class` = 'fast' ) or (`Class` = 'fastfree') ) ";
          break; 
    case "CNoReadings":
           $where2 = " `Class` <> 'read' ";
          break; 	
    case "CJustReadings":
           $where2 = "  `Class` = 'read'  ";
          break; 	
	
    case "CNoFasts";
           $where2 = " (( `Class` <> 'fast') and (`Class` <> 'fastfree' ))  ";
          break; 	
    case "CJustFasts";
           $where2 = "  ((`Class` = 'fast' ) or (`Class` = 'fastfree' ))  ";
          break; 	
    case "CNoFeasts";
           $where2 = " ((`Class` <> 'saint' ) and (`Class` <> 'lf' ) and (`Class` <> 'gf' ))  ";
          break; 	
    case "CJustFeasts";
           $where2 = " ((`Class` = 'saint' ) or (`Class` = 'lf' ) or (`Class` = 'gf' ))  ";
          break; 	
    case "CNoEvents";
           $where2 = "  `Class` <> 'evt'  ";
          break; 	
    case "CJustEvents";
           $where2 = "  `Class`  = 'evt'  ";
          break; 	
    case "CNoServices";
           $where2 = "  `Class` <> 'ser'  ";
          break; 	
    case "CJustServices";
           $where2 = "  `Class` = 'ser'  ";
          break; 		
    case "CNoSaints";
           $where2 = "  `Class` <> 'saint'  ";
          break; 	
    case "CJustSaints";
           $where2 = "  `Class` = 'saint'  ";
          break; 		
    case "CNoGreat";
           $where2 = "  `Class` <> 'gf'  ";
          break; 	
    case "CJustGreat";
           $where2 = "  `Class` = 'gf'  ";
          break; 		
    case "CNoLesser";
           $where2 = "  `Class` <> 'lf'  ";
          break; 	
    case "CJustLesser";
           $where2 = "  `Class` = 'lf'  ";
          break; 	

    default:
       $where2 = " ((`Class` = 'gf' ) or (`Class` = 'lf' ) or (`Class` = 'evt' ) or (`Class` = 'ser' ) or (`Class` = 'fast' ) or (`Class` = 'fastfree') ) ";
         
 }      
         $where = "";
         if ($where1 <> "") {
         $where = $where1; 
           if ($where2 <> "") { 
             $where .= " and " . $where2;
             }
         } else {
             if ($where2 <> "") { 
             $where = $where2;
             }
         }
	return $where;	 
 }
        
              
        protected function getListQuery()
        {
                // Set the order           
 		$orderby = "`Month`, `Day`, `Year`,`Class`, `listorder` DESC";
		
		
            	$this->setState('filter_order', $this->_order[0]);
          	$this->setState('filter_order_Dir', $this->_order[1]);
          	$this->setState('filter_search', $this->_filter_search);

                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('ID,EventText,Month,Day,Year,Class,gmd,listorder');
                // From the Events table
                $query->from('#__CMOG_Events');
                $query->order($orderby);
				$where = $this->_buildWhere();
				if(!empty($where)) {
					$query->where($where);
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