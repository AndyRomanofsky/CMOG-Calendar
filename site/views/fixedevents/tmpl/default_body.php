<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$date = getDate();
$SDay = JRequest::getCmd('SDay');
 if ($SDay == "") $SDay = $date["mday"];
$SMonth = JRequest::getCmd('SMonth');
 if ($SMonth == "") $SMonth = $date["mon"];
$SYear = JRequest::getCmd('SYear');
 if ($SYear == "") $SYear = $date["year"];
$date = getDate(mktime(0, 0, 0, $SMonth, $SDay, $SYear));
$Week_day_n = $date["wday"];

$Print= JRequest::getCmd('print'); 
          if (($user->guest <> 1) and ($Print <> 1)) {
   function ae($id){
//   return(" - <img src='/images/M_images/edit.png' alt='edit' title='click to edit' />");
   return(" - <a href=/test/new-event.html?ID=".$id . "><img src='/images/M_images/edit.png' alt='edit' title='click to edit' /></a>");
   }
  }else{
   function ae($id){
   return;
   }
 }
// Build  the report
 $this->items = $this->get('Items');
foreach($this->items as $i => $row): 
 $event=$row->ID;	
      $eventclass=$row->Class;
      $eventLink=$row->Link;
      $eventPopup=$row->Popup;
      $eventIcon=$row->icon;
      $eventHymn=$row->hymn;
      $eventText=$row->EventText;
      $eventDay=$row->Day;
		if ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
			echo ("</ul><hr /><ul>");
		  }
	  echo( "<li class=".$eventclass."> " . $eventDay . " - ");
//    if ($eventLink <> "") {
//        echo( " <A HREF='$eventLink' target=_blank>$eventText</A>");
//           } else {
//        echo( $eventText );
//           }
          if ($eventLink <> "") {
	     if (substr($eventLink,0,12) == "http://ocafs") {
		echo( "<A HREF='$eventLink' target='oca'> $eventText</A>");
	       } else {
	         if ($eventPopup == "locp") {
	         echo( "<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>");
	        } else {
                   echo( "<A HREF='$eventLink' target=_blank> $eventText</A>");
		   }
	       }
              } else {
                echo(  $eventText) ;
              }
    if ($eventHymn <> "") {
		   echo( " - <A HREF='$eventHymn' target=_blank>(hymn)</A> ");
           } else {
       // echo( " - no hymn " );
         echo( "  " );
			 } 
	  if ($eventIcon <> "") {
		   echo( " - <A HREF='$eventIcon' target=_blank>(icon)</A>");
           } else {
       // echo( " - no icon " );
       echo( " " );
		   //echo( " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ");
			 }
	echo(	"</li> ");	 
endforeach; // while
 echo( "</ul></small>");
?>