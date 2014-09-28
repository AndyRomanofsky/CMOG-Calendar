<?php
/**
* @package CMOGCAL
* @subpackage LukeWeeks
* @copyright Copyright Andrew W Romanofsky - 
*                      Church Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Wednesday, April 17, 2013 - 3:08:43 PM
* @filename default_batch.php
* @folder \cmogcal\admin\views\events\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

$state= $this->get('state');

$published = $state->get('filter.published');
?>
<fieldset class="batch">
	<legend><?php echo JText::_('COM_CMOGCAL_BATCH_OPTIONS');?></legend>
	<p><?php echo JText::_('COM_CMOGCAL_BATCH_TIP'); ?></p>
	<?php echo JHtml::_('batch.access');?>
	<?php echo JHtml::_('batch.language'); ?>

	<?php if ($published >= 0) : ?>
		<?php echo JHtml::_('batch.item', 'com_cmogcal');?>
	<?php endif; ?>

	<button type="submit" onclick="Joomla.submitbutton('event.batch');">
		<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
	</button>
	<button type="button" onclick="document.id('batch-category-id').value='';document.id('batch-access').value='';document.id('batch-language-id').value=''">
		<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
	</button>
</fieldset>