<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');


$document =& JFactory::getDocument();
$document->addStyleSheet("calendar.css");
?>
<form action="<?php echo JRoute::_('index.php?option=com_cmogcal'); ?>" method="post" name="adminForm">
                <div><?php echo $this->loadTemplate('head');?></div>
                <div><?php echo $this->loadTemplate('body');?></div>
                <div><?php echo $this->loadTemplate('foot');?></div>
				
		<?php echo $this->loadTemplate('filter');?>
      
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="view" value="dailyevents" /> 
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form><small>CMOG-Calendar</small>