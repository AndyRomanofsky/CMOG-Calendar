<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * CmogCal Form Field class for the CmogCal component
 */
class JFormFieldCmogCal extends JFormFieldList
{
        /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'CmogCal';
 
        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions() 
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);

                $query->select('#__cmogcal.id as id,info,#__categories.title as category,catid');
                $query->from('#__cmogcal');
                $query->leftJoin('#__categories on catid=#__categories.id');
                $db->setQuery((string)$query);
                $messages = $db->loadObjectList();
                $options = array();
                if ($messages)
                {
                        foreach($messages as $message) 
                        {
                                $options[] = JHtml::_('select.option', $message->id, $message->info .
                                                      ($message->catid ? ' (' . $message->category . ')' : ''));
                        }
                }
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }
}