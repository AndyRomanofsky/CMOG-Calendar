<?php
/**
* @package CMOGCAL
* @subpackage ICal
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, May 06, 2013 - 4:09:14 PM
* @filename view.ical.php
* @folder C:\Documents and Settings\andy ctr romanofsky\My Documents\joomla\com_cmogcal.0.2.x\cmogcal\admin\views\calendars
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Calendars View
 */
class CmogCalViewCalendars extends JViewLegacy
{
        protected $items;
        protected $pagination;
        protected $canDo;
        /**
         * Calendars view display method
         * @return void
         */
        function display($tpl = "ical") 
        {
                // Get data from the model
                $this->items = $this->get('Items');
                $this->pagination = $this->get('Pagination');
                           $state = $this->get('State');
                // get sort info           
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
 
                // Set the toolbar and number of found items
                $this->addToolBar($this->pagination->total);
 
                // Display the template
                parent::display($tpl);
 
                // Set the document
                $this->setDocument();
        }
 
        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
                JToolBarHelper::title(JText::_('COM_CMOGCAL_MANAGER_CALENDARS').
                        //Reflect number of items in title!
                        ($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
                        , 'calendars');

                if ($this->canDo->get('core.create'))       
				{
                JToolBarHelper::addNew('event.add', 'JTOOLBAR_NEW');
				}
                if ($this->canDo->get('core.admin')) 
                {
                JToolBarHelper::divider();
                JToolBarHelper::preferences('com_cmogcal');
				}
        }
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $document = JFactory::getDocument();
                $document->setTitle(JText::_('COM_CMOGCAL_SUBMENU_CALENDARS'));
        }
}