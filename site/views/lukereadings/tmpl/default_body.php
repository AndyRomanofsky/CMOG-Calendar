<?php
/**
* @package CMOGCAL
* @subpackage Luke Weeks
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, April 29, 2013 - 3:02:40 PM
* @filename default_body.php
* @folder \cmogcal\admin\views\lukeweeks\tmpl
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
 
 echo('<h3>Luke Reading cycle</h3>');
 

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
			echo ("</ul><hr /><ul>");

		 }elseif ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
		//	echo ("<br />");
		  }

	  echo( "<li>" . number_suffix($eventWeek). " ". $weekday[$eventDay] . " of Luke - ");

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