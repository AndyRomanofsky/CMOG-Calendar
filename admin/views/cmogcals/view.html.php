<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * CmogCals View
 */
class CmogCalViewCmogCals extends JViewLegacy
{
        protected $items;
        protected $pagination;
        protected $canDo;
        /**
         * CmogCals view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $this->items = $this->get('Items');
                $this->pagination = $this->get('Pagination');
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
                JToolBarHelper::title(JText::_('COM_CMOGCAL_MANAGER_CMOGCALS').
                        //Reflect number of items in title!
                        ($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
                        , 'cmogcal');
                if ($this->canDo->get('core.delete'))                
				{
                    JToolBarHelper::deleteList('', 'cmogcals.delete', 'JTOOLBAR_DELETE');
				}
                if ($this->canDo->get('core.edit'))    
				{
                JToolBarHelper::editList('cmogcal.edit', 'JTOOLBAR_EDIT');
				}
                if ($this->canDo->get('core.create'))       
				{
                JToolBarHelper::addNew('cmogcal.add', 'JTOOLBAR_NEW');
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
                $document->setTitle(JText::_('COM_CMOGCAL_ADMINISTRATION'));
        }
}