<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');


$document =& JFactory::getDocument();
$document->addStyleSheet("calendar.css");
$document->addStyleSheet("/plugins/content/highslide/highslide.css");
$document->addStyleSheet("/plugins/content/highslide/config/css/highslide-sitestyles.css");

$document->addScript("/includes/js/joomla.javascript.js");
$document->addScript("/media/system/js/mootools.js");
$document->addScript("/media/system/js/caption.js");
$document->addScript("/plugins/content/highslide/highslide-full.js");
$document->addScript("/plugins/content/highslide/easing_equations.js");
$document->addScript("/plugins/content/highslide/swfobject.js");
$document->addScript("/plugins/content/highslide/language/en.js");
$document->addScript("/plugins/content/highslide/config/js/highslide-sitesettings.js");


$document->setMetaData( 'keywords', 'when is easter, movable feasts, Orthodox church' );

$PHP_SELF=$_SERVER['PHP_SELF'] ;
$HTTP_HOST=$_SERVER['HTTP_HOST'] ;


// -----------------------------------------------------------------------------------------------------
// Heading                
?><form action="index.php" method="post" id="adminForm" name="adminForm">
        <?php echo $this->getToolbar(); ?>
        <input type = "hidden" name = "task" value = "" />
        <input type = "hidden" name = "option" value = "com_yourcom" />
</form>
<div class="clr"></div>
<form action="<?php echo JRoute::_('index.php?option=com_cmogcal'); ?>" method="post" name="adminForm">
                <div><?php echo $this->loadTemplate('head');?></div>
                <div><?php echo $this->loadTemplate('body');?></div>
                <div><?php echo $this->loadTemplate('foot');?></div>
				
		<?php echo $this->loadTemplate('filter');?>
      
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="view" value="fixedevents" /> 
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form><small>CMOG-Calendar</small>