<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Calendars Controller 
 */
class CmogCalControllerCalendars extends JControllerAdmin
{
        /**
         * Proxy for getModel. (note singular name)
         * @since       2.5
         */
        public function getModel($name = 'Calendar', $prefix = 'CmogCalModel') 
        {
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }
		
		function ical()
		  
        echo json_encode('Hello World');
		}
		
 
}