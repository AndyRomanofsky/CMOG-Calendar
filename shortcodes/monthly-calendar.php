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
	<?php $outputcal .= "<h2>" .   $display_date["month"]     . ", " . $display_date["year"] . "</h2>" . PHP_EOL;?>
 
      
        <?php $outputcal .= "<form id='templates-filter' method='get'>" . PHP_EOL;?>
		  <?php $outputcal .= "<br />" . PHP_EOL;?>
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
		 $outputcal .= "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>" . PHP_EOL; 
		} ?>
		<?php $outputcal .= "Show Every Year: <input type='checkbox' name='f_every_year' value='Yes'";?> <?php if ('Yes' == $EveryYear  ) $outputcal .= ' checked';?>  <?php $outputcal .= ">" . PHP_EOL;?>
		<?php $outputcal .= "Year: " . PHP_EOL;?> 
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<?php $outputcal .= "<select name='f_year' >" . PHP_EOL;?>	
			<?php		
			foreach($years as  $y): 
			$outputcal .= "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $y['Year'] . "</option>" . PHP_EOL;	
			endforeach; 
			?>
			<?php $outputcal .= "</select>" . PHP_EOL;?>		
		  
		 <?php $outputcal .= " Month:" . PHP_EOL;?> 
			<?php $outputcal .= "<select name='f_month' >" . PHP_EOL;?>	
			<?php $outputcal .= "<option value= '' ";?><?php if (  $SMonth == null  )  $outputcal .= " selected ";?><?php $outputcal .= "></option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 1 ";?><?php if (   $SMonth == 1  )  $outputcal .= " selected ";?><?php $outputcal .= ">January</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 2 ";?><?php if (   $SMonth == 2  )  $outputcal .= " selected ";?><?php $outputcal .= ">February</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 3 ";?><?php if (   $SMonth == 3  )  $outputcal .= " selected ";?><?php $outputcal .= ">March</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 4 ";?><?php if (   $SMonth == 4  )  $outputcal .= " selected ";?><?php $outputcal .= ">April</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 5 ";?><?php if (  $SMonth == 5  )  $outputcal .= " selected ";?><?php $outputcal .= ">May</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 6 ";?><?php if (  $SMonth == 6  )  $outputcal .= " selected ";?><?php $outputcal .= ">June</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 7 ";?><?php if (  $SMonth == 7  )  $outputcal .= " selected ";?><?php $outputcal .= ">July</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 8 ";?><?php if (  $SMonth == 8  )  $outputcal .= " selected ";?><?php $outputcal .= ">August</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 9 ";?><?php if (  $SMonth == 9  )  $outputcal .= " selected ";?><?php $outputcal .= ">September</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 10 ";?><?php if (  $SMonth == 10  )  $outputcal .= " selected ";?><?php $outputcal .= ">October</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 11 ";?><?php if (  $SMonth == 11  )  $outputcal .= " selected ";?><?php $outputcal .= ">November</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 12 ";?><?php if (  $SMonth == 12  )  $outputcal .= " selected ";?><?php $outputcal .= ">December</option>" . PHP_EOL;?>
			<?php $outputcal .= "</select>		" . PHP_EOL;?>
		<?php $outputcal .= "Class:" . PHP_EOL;?>  
			<?php
			$classes = $wpdb->get_results( "SELECT DISTINCT `Class` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?> 
			<?php $outputcal .= "<select name='f_class' >";?>		
			<?php $outputcal .= " <option value=''></option>" . PHP_EOL;?>
			<?php
			foreach($classes as  $c): 
			$outputcal .= "<option value=" . $c['Class'] ; 
			if (  $SClass == $c['Class']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $c['Class'] . "</option>" . PHP_EOL;	
			endforeach; 
			?>
			<?php $outputcal .= "</select> ";?>
		  <?php $outputcal .= "<input type='submit' value='Filter'>" . PHP_EOL;?>
		  <?php $outputcal .= "<br />" . PHP_EOL;?>
            
			<?php //$outputcal .= " <input type='hidden' name='page' value=''";?><?php // $outputcal .= $_REQUEST['page'] ?><?php //$outputcal .= " />";?>
            
			<?php $outputcal .= "<table class='adminlist' style='border-collapse: collapse; border: 1px solid black;'>" . PHP_EOL;?>
				<?php $outputcal .= "<thead><tr>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='2%' class='dayhead'><small> </small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Sunday</small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Monday</small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Tuesday</small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Wednesday</small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Thursday</small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Friday</small></td>" . PHP_EOL;?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Saturday</small></td>" . PHP_EOL;?>
				<?php $outputcal .= "</tr></thead>" . PHP_EOL;?>
				<?php $outputcal .= "<tfoot><tr>" . PHP_EOL;?>
					<?php $outputcal .= "<td colspan='8'>foot</td>" . PHP_EOL;?>
				<?php $outputcal .= "</tr></tfoot>" . PHP_EOL;?>
             <?php $outputcal .= "   <tbody>" . PHP_EOL;?>
				
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
         $outputcal .=("<tr>" . PHP_EOL);
		 
          $outputcal .=("<td class=weeklable><small>".Pentecost_offset($last_sunday["year"],$last_sunday["mon"], $last_sunday["mday"]) . "</small></td>" . PHP_EOL);
     $top_skip = $first_week_day;
     $outputcal .=("<td  colspan=\"$top_skip\" class=\"blank\"> </td>" . PHP_EOL);
         }
         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0){
               $outputcal .= "</tr>\n<tr border='0'>" ;
            $outputcal .= "<td class=weeklable><small>".Pentecost_offset($SYear,$SMonth,$day_counter) . "</small></td>" . PHP_EOL ;
                               }
               $outputcal .= "<td  valign='top' class='day' border='1' ><table hight='100%'class='daytable' ><tr border='1' valign='top'><td border='1' valign='top'>" . PHP_EOL ;
			$outputcal .= "<tr><td border='1' ><a href='/day?f_year=" . $SYear . "&f_month=" . $SMonth . "&f_day=" . $day_counter . "'>".$day_counter."</a></td><tr>" . PHP_EOL;// need: to add every year flag (and class)
			 
			// data for this day
				 foreach($items as $i => $item): 
				// var_dump($item);
					if ( $item['Day'] == $day_counter) {
						$outputcal .= "<tr><td><span class='" . $item['Class'] . "'> " ;
						$outputcal .= "<a href=' " . $item['Link'] ."'>";
						$outputcal .= $item['EventText'] . "</a></span></td><tr>" . PHP_EOL;
					}
				endforeach;  
             $outputcal .=( "</table></td>"); 
            $week_day++;
            }		
	?>			
				<?php $outputcal .= "</tbody>" . PHP_EOL;?>
			<?php $outputcal .= "</table>" . PHP_EOL;?>
       <?php $outputcal .= " </form>" . PHP_EOL;?>
    <?php $outputcal .= "</div>" . PHP_EOL;?>
	<?php return $outputcal;?>
    <?php
}