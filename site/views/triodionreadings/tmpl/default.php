<?php
/**
* @package CMOGCAL
* @subpackage Tridion Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 3:33:29 PM
* @filename default.php
* @folder \cmogcal\site\views\triodionreadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

                <div><?php echo $this->loadTemplate('head');?></div>
                <div><?php echo $this->loadTemplate('body');?></div>
<br><small>CMOG-Calendar</small>