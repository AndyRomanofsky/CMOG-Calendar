<?php
/**
* @package CMOGCAL
* @subpackage Daily Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 24, 2013 
* @filename default_body.php
* @folder \cmogcal\site\views\dailyevents\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

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
         
		 
   function ae($id){
         $Print= JRequest::getCmd('print'); 
          if ($Print <> 1) {
      return(" - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=event.edit&ID='.$id.'&a.id='.$id)."><img src='/images/M_images/edit.png' alt='edit' title='click to edit' /></a>");
	  } else {
    return;
   }
   }
// Build  the report
 $this->items = $this->get('Items');
foreach($this->items as $i => $row): 
 $event=$row->ID;
      $eventclass=$row->Class;
      $eventLink=$row->Link;
      $eventIcon=$row->icon;
      $eventHymn=$row->hymn;
      $eventText=$row->EventText;
      $eventPopup=$row->popup;
	  
      $this->canDo = CmogCalHelper::getActions($event,'event');
	  $canedit=$this->canDo->get('core.edit');
    if ($eventHymn <> "") {
		   $hymn_html .= "<li class='read'><A HREF='$eventHymn' target=_blank>$eventText</A>";
		   if ($canedit)  {
        	$hymn_html .=  ae($event) ."</li>";
		}else{
		   $hymn_html .=  "</li>";
		 }
		} 
	  if ($eventIcon <> "") {
		   $icon_html .= "<img class='icon'src='$eventIcon' alt='$eventText' title='$eventText' height='150' > ";
			 }

    switch ($eventclass) {
    case "ser":
        if ($service <> 1) $ser_html = "<h4>Service:</h4>";
        $service = 1;  
        $ser_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
        $ser_html .= " <A HREF='$eventLink' target=_blank>$eventText</A>";
           } else {
        $ser_html .=  $eventText ;
           }
		if ($canedit)  {
        $ser_html .=  ae($event) ."</li>";
		}else{
        $ser_html .=  "</li>";
		}
        break;  
    case "fast":
        $fast = 1;  
        $fast_html .= "<span class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$fast_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $fast_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $fast_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           }  else {
        $fast_html .=  $eventText ;
           }
        if ($canedit)  {
        $fast_html .=  ae($event) ."</li>";
		}else{
        $fast_html .=  "</li>";
		}
        break;      
    case "fastfree":
        $fastfree = 1;  
        $fast_html .= "<span class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$fast_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $fast_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $fast_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           }  else {
        $fast_html .=  $eventText ;
           }
		if ($canedit)  {
        $fast_html .=  ae($event) ."</li>";
		}else{
        $fast_html .=  "</li>";
		}
        break;      
    case "gf":
        $gf_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$gf_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $gf_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $gf_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           } else {
        $gf_html .=  $eventText ;
           }
        if ($canedit)  {
        $gf_html .=  ae($event) ."</li>";
		}else{
        $gf_html .=  "</li>";
		}
        break;  
    case "lf":
        $lf_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					 $lf_html .= " <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $lf_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $lf_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           } else {
        $lf_html .=  $eventText ;
           }
     if ($canedit)  {
        $lf_html .=  ae($event) ."</li>";
		}else{
        $lf_html .=  "</li>";
		}
        break;  
    case "evt":
          if (!isset($event_html)) $event_html = "<h4>Events:</h4>";
          $event_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $event_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $event_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
				     } else {
          $event_html .=  $eventText ;
           }
       if ($canedit)  {
        $event_html .=  ae($event) ."</li>";
		}else{
        $event_html .=  "</li>";
		}
        break;  
    case "read":
        $read = 1;
        $read_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $read_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $read_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 } else {
          $read_html .=  $eventText ;
           }
        if ($canedit)  {
        $read_html .=  ae($event) ."</li>";
		}else{
        $read_html .=  "</li>";
		}
        break;  
    default:
        $more_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$more_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $more_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '700', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $more_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           } else {
        $more_html .=  $eventText ;
           }
        if ($canedit)  {
        $more_html .=  ae($event) ."</li>";
		}else{
        $more_html .=  "</li>";
		}
        break;  
      }//	switch	
endforeach; 

    if ( $read == 1) {
         $read_html =  "<h4>Readings:</h4>$read_html";
         } 
		 
		if ($hymn_html <> "") {
				$hymn_html = "<h4>Hymns:</h4>$hymn_html";
				}

    if (( $service == 0) and ($Week_day_n == 0 ))  {
         $ser_html .=  "<h4>Sunday service:</h4><li class='ser'> 9:40 AM - Hours</li>";
         $ser_html .=  "<li class='ser'> 10:00 AM - Divine Liturgy</li>";
         } 
    if (($fastfree == 0 and $fast == 0) and (($Week_day_n == 3 ) or ($Week_day_n == 5)) ) {
         $fast_html  =  " <span class='fast'>fast day</span>";
         } 
// Print the output ---------------------------------------------------------------------------------------------------------
//
       echo("<center>" . $fast_html . "</center>" ); 
       
       echo("<ul>" . $ser_html ."</ul><ul>" . $event_html . "</ul>" );  
 // temp test code
 $ChurchDates = Pentecost_offset($SYear,$SMonth,$SDay,TRUE); 

   if (!isset($read_html)) $read_html = lookup_read($ChurchDates);
	      
       echo("<ul>" . $read_html. "</ul>"); 
 
 
//  This section will list the Kathisma that are read. (It now is fixed for Bright week) ------------------------------------------
//	 
    
     $psalter = "<a target='oca' href='http://churchmotherofgod.org/prayers-of-the-church/daily-readings-from-the-psalter/";
//	$popup = "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: 'Kathisma', wrapperClassName: 'titlebar' } )\" ";
		$popup = "'";
		 echo("<ul><h4>Psalter:</h4><li class='read'>");
		if ($this->ChurchDates[week_of_Pascha] == 1) : 
		    echo(" no Kathisma reading, <a target='oca' href='http://churchmotherofgod.org/text-of-prayers-of-the-church/1376-brightweek-prayers.html'>Brightweek Prayers</a>");

		elseif ($this->ChurchDates[holyweek] == 1): //Holyweek	
    switch ($Week_day_n) {
    case 1:   //Monday  Holyweek
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");
        break; 
    case 2: //Tuesday Holyweek
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a>, ");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");
        break; 
    case 3: //Wednesday Holyweek
         echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a>, ");
         echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a>, ");
         echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");
        break; 
    case 4: //Thursday Holyweek 
        echo(  "(no Kathisma reading)");
        break; 
    case 5: //Firday Holyweek 
        echo("(no Kathisma reading)");
        break; 
    case 6: //Saturday Holyweek 
        echo(  $psalter . "1044-kathisma-17.html".$popup.">Kathisma 17</a> (Matins)");
        break; 
    case 0: //Sunday Holyweek
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a>, ");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a>, Polyeleos (Matins)");
        break;    
		default:
        echo($Week_day_n . " - Holyweek?");
    }//	switch	 
 
	
		elseif ($this->ChurchDates[lent] == 0):  // not lent
     switch ($Week_day_n) {
    case 1:
        if ($this->ChurchDates[normal] == 1):  //Monday normal
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Vespers)</li>");

        else:           //Monday  
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");

        endif;
        break; 
    case 2:
        if ($this->ChurchDates[normal] == 1): //Tuesday normal
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (Vespers)</li>");

        else: //Tuesday  
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a>, ");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");


        endif;
        break; 
    case 3:
        if ($this->ChurchDates[normal] == 1): //Wednesday normal
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Vespers)");
				
        else: //Wednesday 
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a>, ");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");


        endif;
        break; 
    case 4:
        if ($this->ChurchDates[normal] == 1): //Thursday normal
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a>, ");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (Vespers)");

        else: //Thursday
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a>, ");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a>, ");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 5: //Friday normal
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a>, ");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");
        break; 
    case 6: //Saturday normal
        echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a>, ");
        echo(  $psalter . "1044-kathisma-17.html".$popup.">Kathisma 17</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Vespers)");
        break; 
    case 0://Sunday
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a>, ");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (Matins)");
        break; 
   default:
        echo($Week_day_n . " - not lent?");
    }//	switch	 
 
	 else: //Lent
    switch ($Week_day_n) {
    case 1: // Monday lent
        if ($this->ChurchDates[lent] == 5):  //week 5
				if ($this->ChurchDates[Annunciation] == 1 ):
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (1rd Hour)</li><li class='read'>");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (3th Hour)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (Vespers)");
        else: 
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (Vespers)");
				endif;
				
        else: 
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 2: //Tuesday lent
        if ($this->ChurchDates[lent] == 5):    //week 5
				if ($this->ChurchDates[Annunciation] == 1 ):
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (Vespers)");
        else:  
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a>, ");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a>, ");
         echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (1st Hour)</li><li class='read'>");
         echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a> (Vespers)");
				endif;
				
        else: //not week 5
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a>, ");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 3: //Wednesday lent
        if ($this->ChurchDates[lent] == 5):     //week 5
				if ($this->ChurchDates[Annunciation] == 1 ):
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a>, ");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a>, ");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (9th Hour)");
			 else:
         echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a>, ");
         echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a>, ");
         echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (1st Hour)</li><li class='read'>");
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (Vespers)");
				endif;
				
        else: //not week 5 
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a>, ");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a>, ");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 4: //Thursday lent
        if ($this->ChurchDates[lent] == 5):     //week 5
				if ($this->ChurchDates[Annunciation] == 1 ):
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a>, ");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (1st Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (9th Hour)");
        else:
	 echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Vespers)");

				endif;
				
        else: //not week 5
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a>, ");
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 5: //Friday Lent
 
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a>, ");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a>, ");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        break; 
    case 6:  //Saturday Lent (same as normal)
        echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a>, ");
        echo(  $psalter . "1044-kathisma-17.html".$popup.">Kathisma 17</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Vespers)");
        break; 
    case 0: //Sunday Lent (same as normal)
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a>, ");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (Matins)");
        break; 
   default:
        echo($Week_day_n . " - Lent?");
    }//	switch	 
	   endif;// not 1st week of Pascha
  echo("</li></ul>");
  
       //new row - new cell
   //    echo("</td></tr><tr><td align=\"center\" >"); 
       echo("<ul><h4>On this day the Church remembers:</h4>");
       echo($gf_html . $lf_html . $more_html . "</ul>" );
       //  - new cell
    //   echo("</td></tr><tr><td  align=\"center\" >");
       echo("<ul>" . $hymn_html . "</ul>" );
      
       //new row - new cell. (only 1 cell)
//	echo("</td></tr><tr><td  align=\"center\" >");
	echo("<center>". $icon_html . "</center>");
	
// Navigation links at bottom of box ------------------------------------------------------------------------------
//
   if ($ok_to_edit <> 0){
              $oparm = "?ote=$ok_to_edit&";
              }else{
              $oparm = "?";
              }
   
if($Print) echo("<hr>");
?>