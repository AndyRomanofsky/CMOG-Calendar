<?php
/**
* @package CMOGCAL
* @subpackage Pentecost Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 17, 2013 - 9:12:41 AM
* @filename default_body.php
* @folder \cmogcal\site\views\pentecostreadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
$state= $this->get('state');
 
 $weekday[0]= "Sunday";
$weekday[1]= "Monday";
$weekday[2]= "Tuesday";
$weekday[3]= "Wednesday";
$weekday[4]= "Thursday";
$weekday[5]= "Friday";
$weekday[6]= "Saturday";
$weekday[7]= "Sunday";

echo('<h3> Pentecost Reading cycle</h3>');


// Build  the report
 $this->items = $this->get('Items');
foreach($this->items as $i => $row): 

      $eventclass=$row->Class;
      $eventLink=$row->Link;
      $eventIcon=$row->icon;
      $eventHymn=$row->hymn;
      $eventText=$row->EventText;
      $eventDay=$row->wday;
      $eventWeek=$row->week;
      $eventPopup=$row->popup;
		if ($eventWeek <> $lastEventWeek	) {
		  $lastEventWeek =  $eventWeek;
		  $lastEventDay =  $eventDay;
		    switch ($eventWeek){
			 case "18":
				echo ("</ul><hr /> See <A HREF='/church-calendar/readings/luke-readings.html', > Luke Readings also</a><br><ul>");
   			 break;
			 case "34": 
				echo ("</ul><hr /> See <A HREF='/church-calendar/readings/triodion.html', > Tridion Readings also</a><br><ul>");
    			 break;
			 default: 
				echo ("</ul><hr /><ul>");
			}
		  }elseif ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
			echo ("<br />");
		  }
	  echo( "<li>" .number_suffix($eventWeek). " ". $weekday[$eventDay] . " after Pentecost  - ");
    if ($eventLink <> "") {
	   if ($eventPopup == "locp") {
	  echo("<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>");
	   } else {
          echo(" <A HREF='$eventLink' target=_blank> $eventText</A>");
		   }
	 } else {
          echo($eventText);
           }
    if ($eventHymn <> "") {
		   echo( " - <A HREF='$eventHymn' target=_blank>(hymn)</A> ");
        		 } 
	  if ($eventIcon <> "") {
		   echo( " - <A HREF='$eventIcon' target=_blank>(icon)</A>");
          		   //echo( " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ");
			 }
	echo(	"</li> ");	 
   
endforeach; 
 echo( "</ul><hr>"); 