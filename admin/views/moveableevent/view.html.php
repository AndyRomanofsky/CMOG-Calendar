<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * MoveableEvent View
 */
class CmogCalViewMoveableEvent extends JViewLegacy
{
        protected $form;
        protected $item;
        protected $script;
        protected $canDo;
        /**
         * display method of MoveableEvent view
         * @return void
         */
        public function display($tpl = null) 
        {
                // get the Data
                $this->form = $this->get('Form');
                $this->item = $this->get('Item');
                $this->script = $this->get('Script');
 
                // What Access Permissions does this user have? What can (s)he do?
                $this->canDo = CmogCalHelper::getActions($this->item->ID,"moveableevent" );
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
                JToolBarHelper::title($isNew ? JText::_('COM_CMOGCAL_MANAGER_MOVEABLE_NEW')
                                             : JText::_('COM_CMOGCAL_MANAGER_MOVEABLE_EDIT'), 'moveableevent');
                // Build the actions for new and existing records.
                if ($isNew) 
                {
                        
                                JToolBarHelper::apply('moveableevent.apply', 'JTOOLBAR_APPLY');
                                JToolBarHelper::save('moveableevent.save', 'JTOOLBAR_SAVE');
                                JToolBarHelper::custom('moveableevent.save2new', 'save-new.png', 'save-new_f2.png',
                                                       'JTOOLBAR_SAVE_AND_NEW', false);

						JToolBarHelper::cancel('moveableevent.cancel', 'JTOOLBAR_CANCEL');
                }
                else
                {                                
                               
                                JToolBarHelper::apply('moveableevent.apply', 'JTOOLBAR_APPLY');
                                JToolBarHelper::save('moveableevent.save', 'JTOOLBAR_SAVE');
 
                                //
                                              
						 		  JToolBarHelper::custom('moveableevent.save2new', 'save-new.png', 'save-new_f2.png',
                                                               'JTOOLBAR_SAVE_AND_NEW', false);
                                      
								                                 
								JToolBarHelper::custom('moveableevent.save2copy', 'save-copy.png', 'save-copy_f2.png',
                                                       'JTOOLBAR_SAVE_AS_COPY', false);
                                
						        JToolBarHelper::cancel('moveableevent.cancel', 'JTOOLBAR_CLOSE');
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