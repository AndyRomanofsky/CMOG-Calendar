<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of CmogCal component
 */
class CmogCalController extends JController
{
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false) 
        {
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->getCmd('view', 'calendars'));
 
                // call parent behavior
                parent::display($cachable);
 
                // Set the submenu
                CmogCalHelper::addSubmenu($input->getCmd('view'));
        }
}