<?php
/**
* @package CMOGCAL
* @subpackage LukeWeek
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Thursday, April 18, 2013 - 2:15:12 PM
* @filename edit.php
* @folder \cmogcal\admin\views\lukeweek\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
?>
<form action="<?php echo JRoute::_('index.php?option=com_cmogcal&view=lukeweek&layout=edit&ID='.(int) $this->item->ID); ?>"
      method="post" name="adminForm" id="cmogcal-form" class="form-validate">
 
       <div class="width-60 fltlft">
        <fieldset class="adminform">
                <fieldset class="adminform">
                        <legend><?php echo JText::_( 'COM_CMOGCAL_LUKE_DETAILS' ); ?></legend>
                        <ul class="adminformlist">
<?php                      foreach($this->form->getFieldset('details') as $field): ?>
                                <li><?php echo $field->label;echo $field->input;?></li>
<?php                      endforeach; ?>
                        </ul>
                </fieldset>
        </div>

	   <!-- begin template management -->	
		<div class="width-40 fltrt">
<?php        echo ("test<br>");
             echo JHtml::_('sliders.start', 'event-slider');
			  echo ("test<br>");
             foreach ($event as $name => $fieldset):
			 echo ("$fieldset[month]/$fieldset[day]/$fieldset[year] <br>");
             endforeach; ?>
 
                <?php echo JHtml::_('sliders.end'); ?>
        </div>
		
		
    <!-- begin ACL definition-->

    <div class="clr"></div>

    <?php if ($this->canDo->get('core.admin')): ?> 
	<div class="width-100 fltlft"> 
	<?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->ID, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel', JText::_('COM_CMOGCAL_FIELDSET_RULES_TEMPLATE'), 'access-rules'); ?>
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