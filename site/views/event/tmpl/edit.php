<?php
/**
* @package CMOGCAL
* @subpackage Event
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 24, 2013 
* @filename edit.php
* @folder \cmogcal\site\views\event\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'event.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
<form action="<?php echo JRoute::_('index.php?option=com_cmogcal&a_id='. $this->item->ID .'&ID='. $this->item->ID); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

        	<fieldset>
		<legend><?php echo JText::_('JEDITOR'); ?></legend>

			<div class="formelm">
			<?php echo $this->form->getLabel('title'); ?>
			<?php echo $this->form->getInput('title'); ?>
			</div>

		<?php if (is_null($this->item->ID)):?>
			<div class="formelm">
			<?php echo $this->form->getLabel('alias'); ?>
			<?php echo $this->form->getInput('alias'); ?>
			</div>
		<?php endif; ?>

			<div class="formelm-buttons">

			<button type="button" onclick="Joomla.submitbutton('event.save')">
				<?php echo JText::_('JSAVE') ?>
			</button>
			<button type="button" onclick="Joomla.submitbutton('event.save2copy')">
				<?php echo JText::_('Save copy') ?>
			</button>
			<button type="button" onclick="Joomla.submitbutton('event.cancel')">
				<?php echo JText::_('JCANCEL') ?>
			</button>
			</div>

	</fieldset>
                <fieldset class="adminform">
                        <legend><?php echo JText::_( 'COM_CMOGCAL_EVENT_DETAILS' ); ?></legend>
                        <ul class="adminformlist">
<?php                      foreach($this->form->getFieldset('details') as $field): ?>
                                <li><?php echo $field->label;echo $field->input;?></li>
<?php                      endforeach; ?>
                        </ul>
                </fieldset>
        </div>
 
        <div >
<?php        echo JHtml::_('sliders.start', 'event-slider');
             foreach ($params as $name => $fieldset):
                echo JHtml::_('sliders.panel', JText::_($fieldset->label), $name.'-params');
                if (isset($fieldset->description) && trim($fieldset->description)): ?>
                        <p class="tip"><?php echo $this->escape(JText::_($fieldset->description));?></p>
<?php           endif;?>
                <fieldset class="panelform" >
                        <ul class="adminformlist">
<?php                        foreach ($this->form->getFieldset($name) as $field) : ?>
                                <li><?php echo $field->label; ?><?php echo $field->input; ?></li>
<?php                        endforeach; ?>
                        </ul>
                </fieldset>
<?php        endforeach; ?>
 
                <?php echo JHtml::_('sliders.end'); ?>
        </div>
    
	
        <div>
                <input type="hidden" name="task" value="event.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>