<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
echo("<center><h4><b>");
// this Function echos the Pentecost offset and returns it also.
//  Input: $filter_year    - four digit year from 1906 to 2036)  
//         $filter_month   - month  1 to 12
//         $filter_day     - day of month
//  returns: $ChurchDates[day]  - 8 is Sunday , 1 is Mon, 2 is Tues, ect.
//          $ChurchDates[week]  - week number from last Pentecost
//          $ChurchDates[lukew] - week number of reading form Luke 
//          $ChurchDates[lent] - week number of reading form Lent
//          $ChurchDates[holyweek] - 1 if holly week 
//          $ChurchDates[week_of_Pascha] - week between Pascha and Pentecaos
//
 $date = getDate();
$SDay = JRequest::getCmd('SDay');
 if ($SDay == "") $SDay = $date["mday"];
$SMonth = JRequest::getCmd('SMonth');
 if ($SMonth == "") $SMonth = $date["mon"];
$SYear = JRequest::getCmd('SYear');
 if ($SYear == "") $SYear = $date["year"];
 $date = getDate(mktime(0, 0, 0, $SMonth, $SDay, $SYear));
$Print= JRequest::getCmd('print'); 
?>
 <table class="contentpaneopen">

<tr>
		<td class="contentheading" width="100%">
Daily Calendar for <?php echo( $date["weekday"] . ", " . $date["month"] . " " . $SDay .", " . $SYear . "</h3>");?></td>
				<td align="right" width="100%" class="buttonheading">
<?php if ($Print==1){ ?>
	<a href="#" title="Print" onclick="window.print();return false;"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		
<?php	} else {   ?>
	<a href="<?php 
	echo JRoute::_('index.php?option=com_cmogcal&view=dailyevents');
	?>&amp;SDay=<?php 
	echo($SDay);?>&amp;SMonth=<?php 
	echo($SMonth);?>&amp;SYear=<?php 
	echo($SYear);?>&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=" title="Print preview" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no'); return false;" rel="nofollow"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		</td>
		</tr>
<?php } ?>
</table>  
<?php
$this->ChurchDates = Echo_Pentecost_offset($SYear,$SMonth,$SDay); 


echo("</b></h4></center>");
?>