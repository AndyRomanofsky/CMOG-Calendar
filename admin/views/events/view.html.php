<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Events View
 */
class CmogCalViewEvents extends JViewLegacy
{
        protected $items;
        protected $pagination;
        protected $canDo;
        /**
         * Events view display method
         * @return void
         */
        function display($tpl = null) 
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
                $state = $this->get('state');
                JToolBarHelper::title(JText::_('COM_CMOGCAL_MANAGER_EVENTS'));
                
                if ($this->canDo->get('core.create'))       
				{
                JToolBarHelper::addNew('event.add', 'JTOOLBAR_NEW');
				}
                if ($this->canDo->get('core.edit'))    
				{
                JToolBarHelper::editList('event.edit', 'JTOOLBAR_EDIT');
				}
                        

		if ($this->canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish('events.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('events.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('events.archive');
		}
		


		if ($state->get('filter.published') == -2 && $this->canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'events.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($this->canDo->get('core.edit.state')) {
			JToolBarHelper::trash('events.trash');
			JToolBarHelper::divider();
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
                $document->setTitle(JText::_('COM_CMOGCAL_SUBMENU_EVENTS'));
        }
}