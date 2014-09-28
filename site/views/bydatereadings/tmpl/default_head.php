<?php
/**
* @package CMOGCAL
* @subpackage By Date Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 17, 2013 - 9:43:46 AM
* @filename default_head.php
* @folder \cmogcal\site\views\bydatereadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 


$state= $this->get('state');
$filter_month = $state->get('filter.month'); 

$filter_year = $state->get('filter.year'); 


         $date = getDate();
 if (!isset($filter_day)) $filter_day = $date["mday"];
 if (!isset($filter_month)) $filter_month = $date["mon"];
 if (!isset($filter_year)) $filter_year = $date["year"];
$Print= JRequest::getCmd('print'); 
?>
 <table class="contentpaneopen">

<tr>
		<td class="contentheading" width="100%">
Readings for <?php echo( "$filter_month/$filter_year");?></td>
				<td align="right" width="100%" class="buttonheading">
<?php if ($Print==1){ ?>
	<a href="#" title="Print" onclick="window.print();return false;"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		
<?php	} else {   ?>
	<a href="<?php 
	echo JRoute::_('index.php?option=com_cmogcal&view=bydatereadings');
	?>&amp;Month=<?php 
	echo($filter_month);?>&amp;Year=<?php 
	echo($filter_year);?>&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=" title="Print preview" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no'); return false;" rel="nofollow"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		</td>
		</tr>
<?php } ?>
</table>  
<?php if (!$Print==1){ ?>
<blockquote>
<h3>Readings</h3>

<ul>
    <li> Select <b>"<A HREF='/church-calendar/readings/fixed-readings.html'>Just all fixed Readings"</a></b> for Fixed Feasts (or Immovable Feasts ),&nbsp; which  occur  every year on the same calendar date.</li>
    <li>Select <b>"<A HREF='/church-calendar/readings/triodion.html'>Triodion Readings"</a></b> for movable date readings before Pascha.</li>
    <li>Select <b>"<A HREF='/church-calendar/readings/pascha.html'>Pascha to Pentecost Readings"</a></b> for movable date readings from Pascha to Pentecost.</li>
    <li>Select <b>"<A HREF='/church-calendar/readings/after-pentecost.html'>After Pentecost Readings"</a></b> for movable date readings after Pentecost .&nbsp; </li>
    <li>Select <b>"<A HREF='/church-calendar/readings/luke-readings.html'>Luke Readings"</a></b> for movable date readings after the <i>Lukan Jump </i>(middle of September).</li>
    <li><font color="red">Use the month links in the box below to choose all readings for a mouth this year. </font> </li>
</ul></blockquote><hr  /><blockquote>
<center><table border="2" cellpadding="2" cellspacing="0" summary="Fixed Feasts">

<tr><td>


<form action="/church-calendar/readings/bydate.html" method="get">
<INPUT type='hidden' name='task' VALUE='byDate' >
<center>
<select  name="filter_month">
<?php
$MonthName[1] = "January";
$MonthName[2] = "February";
$MonthName[3] = "March";
$MonthName[4] = "April";
$MonthName[5] = "May";
$MonthName[6]= "June";
$MonthName[7] = "July";
$MonthName[8] = "August";
$MonthName[9] = "September";
$MonthName[10] = "October";
$MonthName[11] = "November";
$MonthName[12] = "December";
$i = 1;
while ($i <= 12):
    echo ("<option value='$i'");
    if ($i == $filter_month)  echo(" selected");
    echo (">$MonthName[$i]</option>") ;
    $i++;
endwhile;
?>
</select>
<select  name="filter_year" title="Will default to this year">
<option value="2009"<?php if ($filter_year == 2009) echo(" selected");?>> 2009</option>
<option value="2010"<?php if ($filter_year == 2010) echo(" selected");?>> 2010</option>
<option value="2011"<?php if ($filter_year == 2011) echo(" selected");?>> 2011</option>
<option value="2012"<?php if ($filter_year == 2012) echo(" selected");?>><?php if ($filter_year == 2012) echo(" selected");?> 2012</option>
<option value="2013"<?php if (($filter_year > 2012) or ($filter_year < 2009)) echo(" selected");?>> 2013</option>
</select></center>
<button title="Readings entered into our list of readings for given month and year" style="width:200" "hight:32" type="submit">Readings by Month and Year</button>
</form></td></tr>

</table></center></blockquote><br>
<?php }