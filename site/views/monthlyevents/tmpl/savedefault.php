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
?> MonthlyEventss

