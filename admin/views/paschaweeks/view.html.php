<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * PaschaWeeks View
 */
class CmogCalViewPaschaWeeks extends JViewLegacy
{
        protected $items;
        protected $pagination;
        protected $canDo;
        /**
         * PaschaWeeks view display method
         * @return void
         */
        function display($tpl = null) 
        {
                $state = $this->get('state');
                // Get data from the model
                $this->items = $this->get('Items');
                $this->pagination = $this->get('Pagination');
                           $state = $this->get('State');
                // get stot info           
                $this->sortDirection = $state->get('filter_order_Dir');
                $this->sortColumn = $state->get('filter_order');
                $this->filter_search = $state->get('filter_search');
                $this->filter_year = $state->get('filter.year'); 
				$this->findentries = $state->get('filter.findentries');
				
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
                JToolBarHelper::title(JText::_('COM_CMOGCAL_MANAGER_PASCHAWEEKS').
                        //Reflect number of items in title!
                        ($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
                        , 'paschaweeks');
                
                if ($this->canDo->get('core.create'))       
				{
                JToolBarHelper::addNew('paschaweek.add', 'JTOOLBAR_NEW');
				}
                if ($this->canDo->get('core.edit'))    
				{
                JToolBarHelper::editList('paschaweek.edit', 'JTOOLBAR_EDIT');
				}
								if (($this->filter_year > 1900)  and  ($this->findentries == "Yes")){ 
								JToolBarHelper::custom('paschaweek.loadlist', 'copy','copy','Load list',1,0);
								}
                        

		if ($this->canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish('paschaweeks.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('paschaweeks.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('paschaweeks.archive');
		}

		if ($state->get('filter.published') == -2 && $this->canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'paschaweeks.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($this->canDo->get('core.edit.state')) {
			JToolBarHelper::trash('paschaweeks.trash');
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
                $document->setTitle(JText::_('COM_CMOGCAL_SUBMENU_PASCHAS'));
        }
}