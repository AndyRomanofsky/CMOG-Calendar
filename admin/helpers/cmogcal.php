<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * CmogCal component helper.
 */
abstract class CmogCalHelper
{
        /**
         * Configure the Linkbar.
         */
        public static function addSubmenu($submenu) 
        {
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_CALENDARS'),
                                         'index.php?option=com_cmogcal&view=calendars', $submenu == 'calendars');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_EVENTS'),
                                         'index.php?option=com_cmogcal&view=events', $submenu == 'events');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_MOVEABLEEVENTS'),
                                         'index.php?option=com_cmogcal&view=moveableevents', $submenu == 'moveableevents');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_TRIODIONS'),
                                         'index.php?option=com_cmogcal&view=triodionweeks', $submenu == 'triodionweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_PENTECOSTS'),
                                         'index.php?option=com_cmogcal&view=pentecostweeks', $submenu == 'pentecostweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_PASCHAS'),
                                         'index.php?option=com_cmogcal&view=paschaweeks', $submenu == 'paschaweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_LUKES'),
                                         'index.php?option=com_cmogcal&view=lukeweeks', $submenu == 'lukeweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_CATEGORIES'),
                                         'index.php?option=com_categories&view=categories&extension=com_cmogcal',
                                         $submenu == 'categories');
				JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_MANAGER'),
                                         'index.php?option=com_cmogcal', $submenu == 'CmogCals');
                
                // set some global property
                $document = JFactory::getDocument();
                $document->addStyleDeclaration('.icon-48-cmogcal ' .
                                               '{background-image: url(../media/com_cmogcal/images/tux-48x48.png);}');
                if ($submenu == 'categories') 
                {
                        $document->setTitle(JText::_('COM_CMOGCAL_ADMINISTRATION_CATEGORIES'));
                }
        }
        /**
		* Get the actions
		*/        
		public static function getActions($rowId = 0,$table = "message")
        {
		jimport('joomla.access.access');
		$user   = JFactory::getUser();
		$result = new JObject;

		if (empty($rowId)) {
		$assetName = 'com_cmogcal';
		}
		else {
		$assetName = 'com_cmogcal.'. $table . '.' . (int) $rowId;
		}
		
		$actions = JAccess::getActions('com_cmogcal', 'component');

		foreach ($actions as $action) { 
		$result->set($action->name, $user->authorise($action->name, $assetName));
		}
		return $result;
        }

}