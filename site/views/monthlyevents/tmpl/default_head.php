<?php
/**
* @package CMOGCAL
* @subpackage Mothly Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, May 13, 2013 - 11:33:09 AM
* @filename default_head.php
* @folder \cmogcal\site\views\monthlyevents\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

//Top of calendar day labels


 $date = getDate();
$SDay = JRequest::getCmd('SDay');
 if ($SDay == "") $SDay = $date["mday"];
$SMonth = JRequest::getCmd('SMonth');
 if ($SMonth == "") $SMonth = $date["mon"];
$SYear = JRequest::getCmd('SYear');
 if ($SYear == "") $SYear = $date["year"];
 $date = getDate(mktime(0, 0, 0, $SMonth, $SDay, $SYear));
 $month_name = $date['month'];
$Print= JRequest::getCmd('print'); 
?>
 <table class="contentpaneopen">

<tr>
		<td class="contentheading" width="100%">
Calendar - <?php echo( $date["month"] . ", " . $SYear);?></td>
				<td align="right" width="100%" class="buttonheading">
<?php if ($Print==1){ ?>
	<a href="#" title="Print" onclick="window.print();return false;"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		
<?php	} else {   ?>
	<a href="<?php 
	echo JRoute::_('index.php?option=com_cmogcal'); 
	?>?SDay=<?php 
	echo($SDay);?>&amp;SMonth=<?php 
	echo($SMonth);?>&amp;SYear=<?php 
	echo($SYear);?>&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=" title="Print preview" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no'); return false;" rel="nofollow"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		</td>
		</tr>
<?php } ?>
</table><br><table class='cal2'>  
<tr><td align="center" colspan=8 class='dayhead'> <small><?php echo ($month_name . " " . $SYear);?></small></td>
<tr>
<td align="center" width='2%' class='dayhead'><small></small></td>
<td align="center" width='14%' class='dayhead'><small>Sunday</small></td>
<td align="center" width='14%' class='dayhead'><small>Monday</small></td>
<td align="center" width='14%' class='dayhead'><small>Tuesday</small></td>
<td align="center" width='14%' class='dayhead'><small>Wednesday</small></td>
<td align="center" width='14%' class='dayhead'><small>Thursday</small></td>
<td align="center" width='14%' class='dayhead'><small>Friday</small></td>
<td align="center" width='14%' class='dayhead'><small>Saturday</small></td></tr>
