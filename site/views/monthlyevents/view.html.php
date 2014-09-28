<?php
/**
* @package CMOGCAL
* @subpackage Mounthly Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, May 13, 2013 - 11:28:35 AM
* @filename view.html.php
* @folder \cmogcal\site\views\monthlyevents
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * MonthlyEvents View
 */
class CmogCalViewMonthlyEvents extends JViewLegacy
{
        protected $items;
        protected $pagination;
        protected $canDo;
        /**
         * DailyEvents view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $this->items = $this->get('Items');
                $this->pagination = $this->get('Pagination');
                           $state = $this->get('State');
                // get stot info           
                $this->sortDirection = $state->get('filter_order_Dir');
                $this->sortColumn = $state->get('filter_order');
				
                // What Access Permissions does this user have? What can (s)he do?
                $this->canDo = CmogCalHelper::getActions();
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
 
                // Display the template
                parent::display($tpl);
 
                // Set the document
                $this->setDocument();
        }
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $document = JFactory::getDocument();
                $document->setTitle(JText::_('COM_CMOGCAL_MONTHLYEVENTS'));
        }
}