<?php
/**
* @package CMOGCAL
* @subpackage Luke readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 1:37:29 PM
* @filename view.html.php
* @folder C:\Documents and Settings\andy ctr romanofsky\My Documents\joomla\com_cmogcal.0.2.x\cmogcal\site\views\lukereadings
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * LukeReadings View
 */
class CmogCalViewLukeReadings extends JViewLegacy
{
        protected $items;
        protected $DisplayWeeks;
        protected $pagination;
        protected $canDo;
		
        /**
         * LukeWeeks view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $this->items = $this->get('Items');
                $this->DisplayWeeks = $this->get('DisplayWeeks');
                $this->pagination = $this->get('Pagination');
                           $state = $this->get('State');
                // get sort info           
                $this->sortDirection = $state->get('filter_order_Dir');
                $this->sortColumn = $state->get('filter_order');
                $this->filter_search = $state->get('filter_search');
				
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
                $document->setTitle(JText::_('Luke Readings'));
        }
}