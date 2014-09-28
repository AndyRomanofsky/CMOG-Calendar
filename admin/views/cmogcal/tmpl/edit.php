<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
?>
<form action="<?php echo JRoute::_('index.php?option=com_cmogcal&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="cmogcal-form" class="form-validate">
 
       <div class="width-60 fltlft">
        <fieldset class="adminform">
                <fieldset class="adminform">
                        <legend><?php echo JText::_( 'COM_CMOGCAL_CMOGCAL_DETAILS' ); ?></legend>
                        <ul class="adminformlist">
<?php                      foreach($this->form->getFieldset('details') as $field): ?>
                                <li><?php echo $field->label;echo $field->input;?></li>
<?php                      endforeach; ?>
                        </ul>
                </fieldset>
        </div>
 
        <div class="width-40 fltrt">
<?php        echo JHtml::_('sliders.start', 'cmogcal-slider');
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
    <!-- begin ACL definition-->

    <div class="clr"></div>

    <?php if ($this->canDo->get('core.admin')): ?> 
	<div class="width-100 fltlft"> 
	<?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel', JText::_('COM_CMOGCAL_FIELDSET_RULES'), 'access-rules'); ?>
	<fieldset class="panelform">
	<?php echo $this->form->getLabel('rules'); ?>
	<?php echo $this->form->getInput('rules'); ?>
	</fieldset> 

	<?php echo JHtml::_('sliders.end'); ?>
	</div>   <?php endif; ?>

    <!-- end ACL definition-->
	
        <div>
                <input type="hidden" name="task" value="cmogcal.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>