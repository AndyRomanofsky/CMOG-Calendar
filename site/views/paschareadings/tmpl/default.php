<?php
/**
* @package CMOGCAL
* @subpackage Pascha Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 4:00:05 PM
* @filename default.php
* @folder \cmogcal\site\views\paschareadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

                <div><?php echo $this->loadTemplate('head');?></div>
                <div><?php echo $this->loadTemplate('body');?></div>
<br><small>CMOG-Calendar</small>