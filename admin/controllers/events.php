<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Events Controller 
 */
class CmogCalControllerEvents extends JControllerAdmin
{
        /**
         * Proxy for getModel. (note singular name)
         * @since       2.5
         */
        public function getModel($name = 'Event', $prefix = 'CmogCalModel') 
        {
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }
}