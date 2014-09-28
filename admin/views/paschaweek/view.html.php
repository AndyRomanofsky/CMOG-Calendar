<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * PaschaWeek View
 */
class CmogCalViewPaschaWeek extends JViewLegacy
{
        protected $form;
        protected $item;
        protected $script;
        protected $canDo;
        /**
         * display method of LukeWeek view
         * @return void
         */
        public function display($tpl = null) 
        {
                // get the Data
                $this->form = $this->get('Form');
                $this->item = $this->get('Item');
                $this->script = $this->get('Script');
 
                // What Access Permissions does this user have? What can (s)he do?
                $this->canDo = CmogCalHelper::getActions($this->item->ID,"paschaweek" );
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
 
                // Set the toolbar
                $this->addToolBar();
 
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
                $input = JFactory::getApplication()->input;
                $input->set('hidemainmenu', true);
                $user = JFactory::getUser();
                $userId = $user->id;
                $isNew = ($this->item->ID == 0);
                JToolBarHelper::title($isNew ? JText::_('COM_CMOGCAL_MANAGER_PASCHA_NEW')
                                             : JText::_('COM_CMOGCAL_MANAGER_PASCHA_EDIT'), 'paschaweek');
                // Build the actions for new and existing records.
                if ($isNew) 
                {
                        
                                JToolBarHelper::apply('paschaweek.apply', 'JTOOLBAR_APPLY');
                                JToolBarHelper::save('paschaweek.save', 'JTOOLBAR_SAVE');
                                JToolBarHelper::custom('paschaweek.save2new', 'save-new.png', 'save-new_f2.png',
                                                       'JTOOLBAR_SAVE_AND_NEW', false);

						JToolBarHelper::cancel('paschaweek.cancel', 'JTOOLBAR_CANCEL');
                }
                else
                {                                
                               
                                JToolBarHelper::apply('paschaweek.apply', 'JTOOLBAR_APPLY');
                                JToolBarHelper::save('paschaweek.save', 'JTOOLBAR_SAVE');
 
                                //
                                              
						 		  JToolBarHelper::custom('paschaweek.save2new', 'save-new.png', 'save-new_f2.png',
                                                               'JTOOLBAR_SAVE_AND_NEW', false);
                                      
								                                 
								JToolBarHelper::custom('paschaweek.save2copy', 'save-copy.png', 'save-copy_f2.png',
                                                       'JTOOLBAR_SAVE_AS_COPY', false);
                                
						        JToolBarHelper::cancel('paschaweek.cancel', 'JTOOLBAR_CLOSE');
                }

        }
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $isNew = ($this->item->id == 0);
                $document = JFactory::getDocument();
                $document->setTitle($isNew ? JText::_('COM_CMOGCAL_CMOGCAL_CREATING')
                                           : JText::_('COM_CMOGCAL_CMOGCAL_EDITING'));
                $document->addScript(JURI::root() . $this->script);
                $document->addScript(JURI::root() . "/administrator/components/com_cmogcal"
                                                  . "/views/cmogcal/submitbutton.js");
                JText::script('COM_CMOGCAL_CMOGCAL_ERROR_UNACCEPTABLE');
        }
}