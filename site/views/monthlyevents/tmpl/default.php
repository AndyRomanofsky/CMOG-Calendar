<?php
/**
* @package CMOGCAL
* @subpackage Monthly Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, May 13, 2013 - 11:18:35 AM
* @filename default.php
* @folder \cmogcal\site\views\monthlyevents\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// load tooltip behavior
JHtml::_('behavior.tooltip');


$document =& JFactory::getDocument();
$document->addStyleSheet("calendar.css");


$document->setMetaData( 'keywords', 'when is easter, movable feasts, Orthodox church' );

$PHP_SELF=$_SERVER['PHP_SELF'] ;
$HTTP_HOST=$_SERVER['HTTP_HOST'] ;
?>
<form action="<?php echo JRoute::_('index.php?option=com_cmogcal'); ?>" method="post" name="adminForm">
        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
		
		<?php echo $this->loadTemplate('filter');?>
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="view" value="monthlyevents" /> 
                <input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
                <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form><small>CMOG-Calendar</small>