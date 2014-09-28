<?php
/**
* @package CMOGCAL
* @subpackage All Fixed Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 4:15:24 PM
* @filename default_body.php
* @folder \cmogcal\site\views\allfixedreadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
$state= $this->get('state');

 echo('<h3>Fixed Readings for the year </h3>');
 

// Build  the report
 $this->items = $this->get('Items');
foreach($this->items as $i => $row): 

      $eventclass=$row->Class;
      $eventLink=$row->Link;
      $eventIcon=$row->icon;
      $eventHymn=$row->hymn;
      $eventText=$row->EventText;
      $eventDay=$row->Day;
      $eventMonth=$row->Month;
      $eventYear=$row->Year;
      $eventPopup=$row->popup;
		if ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
			echo ("</ul><hr /><ul>");
		  }
	  echo( "<li class=".$eventclass."> " .$eventMonth. "/" . $eventDay . " - ");
    if ($eventLink <> "") {
	   if ($eventPopup == "test") {
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
           }
	echo(	"</li> ");	 
   
endforeach; 
 echo( "</ul><hr>"); 