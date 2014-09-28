<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * MoveableEvents Controller
 */
class CmogCalControllerMoveableEvents extends JControllerAdmin
{
        /**
         * Proxy for getModel. (note that name is singular)
         * @since       2.5
         */
        public function getModel($name = 'MoveableEvent', $prefix = 'CmogCalModel') 
        {
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }
}