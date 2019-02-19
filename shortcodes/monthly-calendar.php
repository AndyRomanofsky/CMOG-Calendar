<?php
//cmog_monthly_calendar    
 
add_shortcode( 'cmog_calendar', 'cmog_monthly_calendar' );
function cmog_monthly_calendar(){

global $wpdb; //This is used for database queries
$SMonth = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$SYear = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
$EveryYear = (!empty ($_REQUEST['f_every_year'] )) ? $_REQUEST['f_every_year'] : '';
$SClass = (!empty ($_REQUEST['f_class'] )) ? $_REQUEST['f_class'] : '';



 $date = getDate();

 
 if ($SMonth == "") $SMonth = $date["mon"];

 if ($SYear == "") $SYear = $date["year"];
    $outputcal = '';
  
	$display_date =   getDate(mktime(0,0,0,$SMonth,1,$SYear));
    $outputcal = '';
    ?>
	<?php $outputcal .= "<h2>" .   $display_date["month"]     . ", " . $display_date["year"] . "</h2>\n";?>
 
      
        <?php $outputcal .= "<form id='templates-filter' method='get'>\n";?>
		  <?php $outputcal .= "<br />\n";?>
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
		 $outputcal .= "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>\n"; 
		} ?>
		<?php $outputcal .= "Show Every Year: <input type='checkbox' name='f_every_year' value='Yes'";?> <?php if ('Yes' == $EveryYear  ) $outputcal .= ' checked';?>  <?php $outputcal .= ">\n";?>
		<?php $outputcal .= "Year: \n";?> 
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<?php $outputcal .= "<select name='f_year' >\n";?>	
			<?php		
			foreach($years as  $y): 
			$outputcal .= "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $y['Year'] . "</option>\n";	
			endforeach; 
			?>
			<?php $outputcal .= "</select>\n";?>		
		  
		 <?php $outputcal .= " Month:\n";?> 
			<?php $outputcal .= "<select name='f_month' >\n";?>	
			<?php $outputcal .= "<option value= '' ";?><?php if (  $SMonth == null  )  $outputcal .= " selected ";?><?php $outputcal .= "></option>\n";?>
			<?php $outputcal .= "<option value= 1 ";?><?php if (   $SMonth == 1  )  $outputcal .= " selected ";?><?php $outputcal .= ">January</option>\n";?>
			<?php $outputcal .= "<option value= 2 ";?><?php if (   $SMonth == 2  )  $outputcal .= " selected ";?><?php $outputcal .= ">February</option>\n";?>
			<?php $outputcal .= "<option value= 3 ";?><?php if (   $SMonth == 3  )  $outputcal .= " selected ";?><?php $outputcal .= ">March</option>\n";?>
			<?php $outputcal .= "<option value= 4 ";?><?php if (   $SMonth == 4  )  $outputcal .= " selected ";?><?php $outputcal .= ">April</option>\n";?>
			<?php $outputcal .= "<option value= 5 ";?><?php if (  $SMonth == 5  )  $outputcal .= " selected ";?><?php $outputcal .= ">May</option>\n";?>
			<?php $outputcal .= "<option value= 6 ";?><?php if (  $SMonth == 6  )  $outputcal .= " selected ";?><?php $outputcal .= ">June</option>\n";?>
			<?php $outputcal .= "<option value= 7 ";?><?php if (  $SMonth == 7  )  $outputcal .= " selected ";?><?php $outputcal .= ">July</option>\n";?>
			<?php $outputcal .= "<option value= 8 ";?><?php if (  $SMonth == 8  )  $outputcal .= " selected ";?><?php $outputcal .= ">August</option>\n";?>
			<?php $outputcal .= "<option value= 9 ";?><?php if (  $SMonth == 9  )  $outputcal .= " selected ";?><?php $outputcal .= ">September</option>\n";?>
			<?php $outputcal .= "<option value= 10 ";?><?php if (  $SMonth == 10  )  $outputcal .= " selected ";?><?php $outputcal .= ">October</option>\n";?>
			<?php $outputcal .= "<option value= 11 ";?><?php if (  $SMonth == 11  )  $outputcal .= " selected ";?><?php $outputcal .= ">November</option>\n";?>
			<?php $outputcal .= "<option value= 12 ";?><?php if (  $SMonth == 12  )  $outputcal .= " selected ";?><?php $outputcal .= ">December</option>\n";?>
			<?php $outputcal .= "</select>		\n";?>
		<?php $outputcal .= "Class:\n";?>  
			<?php
			$classes = $wpdb->get_results( "SELECT DISTINCT `Class` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?> 
			<?php $outputcal .= "<select name='f_class' >";?>		
			<?php $outputcal .= " <option value=''></option>\n";?>
			<?php
			foreach($classes as  $c): 
			$outputcal .= "<option value=" . $c['Class'] ; 
			if (  $SClass == $c['Class']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $c['Class'] . "</option>\n";	
			endforeach; 
			?>
			<?php $outputcal .= "</select> ";?>
		  <?php $outputcal .= "<input type='submit' value='Filter'>\n";?>
		  <?php $outputcal .= "<br />\n";?>
            
			<?php //$outputcal .= " <input type='hidden' name='page' value=''";?><?php // $outputcal .= $_REQUEST['page'] ?><?php //$outputcal .= " />";?>
            
			<?php $outputcal .= "<table class='adminlist' style='border-collapse: collapse; border: 1px solid black;'>\n";?>
				<?php $outputcal .= "<thead><tr>\n";?>
					<?php $outputcal .= "<td  width='2%' class='dayhead'><small> </small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Sunday</small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Monday</small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Tuesday</small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Wednesday</small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Thursday</small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Friday</small></td>\n";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Saturday</small></td>\n";?>
				<?php $outputcal .= "</tr></thead>\n";?>
				<?php $outputcal .= "<tfoot><tr>\n";?>
					<?php $outputcal .= "<td colspan='8'>foot</td>\n";?>
				<?php $outputcal .= "</tr></tfoot>\n";?>
             <?php $outputcal .= "   <tbody>\n";?>
				
	<?php	

//get data

if (!empty($SClass) ) {
	$WhereClass = " and Class = '" . $SClass . "' ";
	} else {
	$WhereClass = "";
	}
if ("Yes" == $EveryYear){
				 $items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE (Year = $SYear or Year = -1 ) and Month = $SMonth $WhereClass ORDER  BY Day asc", 'ARRAY_A' ); 
} else {
				 $items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE Year = $SYear  and Month = $SMonth $WhereClass ORDER BY Day asc", 'ARRAY_A' ); 
}
//var_dump($items);
         $this_month = getDate(mktime(0, 0, 0, $SMonth, 1, $SYear));
         $next_month = getDate(mktime(0, 0, 0, $SMonth + 1, 1, $SYear));
   

         //Find out when this month starts and ends.
         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));
         
      $last_sunday = getDate(MKTIME(0, 0, 0, $SMonth,(1 - $first_week_day), $SYear)) ;        
         // Top of caendar



//Fill the first week of the month with the appropriate number of blanks if needed.
         if ($first_week_day <> 0) {
         $outputcal .=("<tr>\n");
		 
          $outputcal .=("<td class=weeklable><small>".Pentecost_offset($last_sunday["year"],$last_sunday["mon"], $last_sunday["mday"]) . "</small></td>\n");
     $top_skip = $first_week_day;
     $outputcal .=("<td  colspan=\"$top_skip\" class=\"blank\"> </td>\n");
         }
         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0){
               $outputcal .= "</tr>\n<tr border='0'>" ;
            $outputcal .= "<td class=weeklable><small>".Pentecost_offset($SYear,$SMonth,$day_counter) . "</small></td>\n" ;
                               }
               $outputcal .= "<td  valign='top' class='day' border='1' ><table hight='100%'class='daytable' ><tr border='1' valign='top'><td border='1' valign='top'>\n" ;
			$outputcal .= "<tr><td border='1' ><a href='/day?f_year=" . $SYear . "&f_month=" . $SMonth . "&f_day=" . $day_counter . "'>".$day_counter."</a></td><tr>\n";// need: to add every year flag (and class)
			 
			// data for this day
				 foreach($items as $i => $item): 
				// var_dump($item);
					if ( $item['Day'] == $day_counter) {
						$outputcal .= "<tr><td><span class='" . $item['Class'] . "'> " ;
						$outputcal .= "<a href=' " . $item['Link'] ."'>";
						$outputcal .= $item['EventText'] . "</a></span></td><tr>\n";
					}
				endforeach;  
             $outputcal .=( "</table></td>"); 
            $week_day++;
            }		
	?>			
				<?php $outputcal .= "</tbody>\n";?>
			<?php $outputcal .= "</table>\n";?>
       <?php $outputcal .= " </form>\n";?>
    <?php $outputcal .= "</div>\n";?>
	<?php return $outputcal;?>
    <?php
}