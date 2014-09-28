<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
        <th width="5">
                <?php echo JText::_('COM_CMOGCAL_CMOGCAL_HEADING_ID'); ?>
        </th>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>                   
        <th>
                <?php echo JText::_('COM_CMOGCAL_CMOGCAL_HEADING_EVENT'); ?>
        </th>                 
        <th>
                <?php echo JText::_('COM_CMOGCAL_CMOGCAL_HEADING_MONTH'); ?>
        </th>                 
        <th>
                <?php echo JText::_('COM_CMOGCAL_CMOGCAL_HEADING_DAY'); ?>
        </th>                 
        <th>
                <?php echo JText::_('COM_CMOGCAL_CMOGCAL_HEADING_YEAR'); ?>
        </th>