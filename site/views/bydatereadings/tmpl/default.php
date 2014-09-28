<?php
/**
* @package CMOGCAL
* @subpackage By Date Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 17, 2013 - 9:45:55 AM
* @filename default.php
* @folder \cmogcal\site\views\bydatereadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

                <div><?php echo $this->loadTemplate('head');?></div>
                <div><?php echo $this->loadTemplate('body');?></div>
<br><small>CMOG-Calendar</small>