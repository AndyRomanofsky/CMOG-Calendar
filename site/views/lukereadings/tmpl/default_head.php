<?php
/**
* @package CMOGCAL
* @subpackage Luke Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 3:14:25 PM
* @filename default_head.php
* @folder cmogcal\site\views\lukereadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
$state= $this->get('state');
$Print= JRequest::getCmd('print'); 
?>
 <table class="contentpaneopen">

<tr>
		<td class="contentheading" width="100%">
Luke Readings</td>
				<td align="right" width="100%" class="buttonheading">
<?php if ($Print==1){ ?>
	<a href="#" title="Print" onclick="window.print();return false;"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		
<?php	} else {   ?>
	<a href="<?php 
	echo JRoute::_('index.php?option=com_cmogcal&view=lukereadings');
	?>&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=" title="Print preview" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no'); return false;" rel="nofollow"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		</td>
		</tr>
<?php } ?>
</table>  
<?php if (!$Print==1){ ?>
<blockquote>
<h3>Readings</h3>

<ul>
    <li> Select <b>"<a HREF='/church-calendar/readings/fixed-readings.html'>Just all fixed Readings"</a></b> for Fixed Feasts (or Immovable Feasts ),&nbsp; which  occur  every year on the same calendar date.</li>
    <li>Select <b>"<a HREF='/church-calendar/readings/triodion.html'>Triodion Readings"</a></b> for movable date readings before Pascha.</li>
    <li>Select <b>"<a HREF='/church-calendar/readings/pascha.html'>Pascha to Pentecost Readings"</a></b> for movable date readings from Pascha to Pentecost.</li>
    <li>Select <b>"<a HREF='/church-calendar/readings/after-pentecost.html'>After Pentecost Readings"</a></b> for movable date readings after Pentecost .&nbsp; </li>
    <li>Select <b>"<font color="red">Luke Readings"</font></b> for movable date readings after the <i>Lukan Jump </i>(middle of September).</li>
	<li>Select <b><a HREF='/church-calendar/readings/bydate.html'>"Readings by date"</a></b> for movable date readings by month and year. (this is built using the above five reading lists and applied to a date.</li>
</ul></blockquote><hr  />
<?php }