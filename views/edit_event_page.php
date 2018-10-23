<?php

/** cmog_render_edit_Event_page
This is for the Events only
*/
function cmog_render_edit_event_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	global $wpdb; //This is used only if making any database queries
	//var_dump($_REQUEST);
	
	/** event update **/
		if ($id) {
		 	if ((isset($_REQUEST['action'])) and ($_REQUEST['action'] == 'update'   )){
					echo "<div class='notice notice-success is-dismissible'>";
					check_admin_referer( 'cmog-event-update');
					$data	 = array(  
					'EventText' => $_REQUEST['EventText'],
					'Class' => $_REQUEST['Class'],
					'Year' => $_REQUEST['Year'],
					'Month' => $_REQUEST['Month'],
					'Day' => $_REQUEST['Day'],
					'Link' => $_REQUEST['Link'],
					'icon' => $_REQUEST['icon'],
					'hymn' => $_REQUEST['hymn'],
					'published' => $_REQUEST['published'],
					'access' => $_REQUEST['access'],
					'language' => $_REQUEST['language'],
					'ID' => $_REQUEST['ID'],
					//'AddDate' => $_REQUEST['AddDate'],
					'listorder' => $_REQUEST['listorder'],
					'popup' => $_REQUEST['popup'],
					'asset_id' => $_REQUEST['asset_id'],
					'catid' => $_REQUEST['catid'],
					'created_by' => $_REQUEST['created_by'],
					'gmd' =>  $_REQUEST['gmd'],
					'tmplt_id' => $_REQUEST['tmplt_id']
					);
					$table = $wpdb->prefix . "cmog_events";
					$format =  array( 
							'%s', // EventText
							'%s', // Class
							'%d', // Year
							'%d', // Month
							'%d', // Day
							'%s', // Link
							'%s', // icon
							'%s', // hymn
							'%d', // published
							'%d', // access
							'%s', // language
							'%d', // ID
					//		'%d', // AddDate
							'%d', // listorder
							'%s', // popup
							'%d', // asset_id
							'%d', // catid
							'%d', // created_by
							'%d', // gmd
							'%d'  // tmplt_id
					);
					$rownumber = $wpdb->replace( $table, $data, $format ); 
					if ($rownumber) { 
						echo "<br /> row " . $rownumber . " updated.";
					echo  '<br />Updated '. $_REQUEST['EventText'] . '</div>' ;
					} else {
						echo "<br />No rows updated.";
					//$sendback = remove_query_arg( array('trashed', 'untrashed', 'deleted', 'locked', 'ids'), wp_get_referer() );
					//$sendback = remove_query_arg( array('action' ), wp_get_referer() );
					}
				}		 	
		}
	if ($id == 'update' ) {
		$id = $wpdb->insert_id;
	}
/** read from database/   ***/	
	if ($id) { // id  = 0 is add not edit
		$row = $wpdb->get_row( "SELECT * FROM `cmog66_cmog_events` where ID = $id  ", 'ARRAY_A' ); 
		if ($row == null)    echo "No data (" . $id . ")"; 
	} else {
		$row['ID'] = $row['EventText'] = $row['Year'] = $row['Month'] = $row['Day'] = $row['Link'] = $row['Class'] = $row['icon'] = $row['hymn'] = $row['tmplt_id'] =  "";
		$row['listorder'] = $row['popup'] = $row['asset_id'] =$row['catid'] = $row['created_by'] = $row['gmd'] = $row['published'] = $row['access'] = $row['language'] = "";
		$row['AddDate'] = "?"; 
	} 
	$cmog_template_type =  (int)(!empty($row['gmd'])) ? $row['gmd'] : ''; //If no sort, default to null
	?>
	
	</div>
	<div class="wrap">
		<?php if ($id) { ?>
		<h2>Update Event</h2>
		<?php } else {  ?>
		<h2>Add new Event</h2>
		<?php }   ?>
		<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
			<p>(Update/Add template info here) new</p>
			<p> Event </p><?php if ($id) { 
				if (-1 == $row['Year']){
				echo  $row['Month'] . "/" . $row['Day'] . "/(every year)<br />";
				} else{
				echo  $row['Month'] . "/" . $row['Day'] . "/" . $row['Year'] . "<br />";
				}
				if ($row['Link']) {
					echo "<a href='" . $row['Link']  .  "' target='_blank'><p class='" . $row['Class'] ."'>" . $row['EventText'] ." </p></a>";
				}else{
				echo "<p class='" . $row['Class'] ."'>" . $row['EventText'] ." </p>";
				}
				if ($row['icon']) {
				echo "<img src='" . $row['icon'] . "' alt='icon'   height='60'>";
				}
			}?>
		</div>
		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get">
			<input type="submit" value="Update">
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_events&published=<?php echo $row['published']?>" >Close</a>
		  <br /> * required field<br />
			<input type="hidden" name='page'   value="cmog_list_events">
			<input type="hidden" name='action'   value="update">
		 
			<br />
			<?php cmog_input_text_r('EventText', $row,'Event'); ?>
			Class: *<br />
			<select name='Class' required>			
				<option></option>
				<option value="evt" <?php if  ( "evt" == $row['Class']) echo " selected ";?>>Event</option>
				<option value="gf" <?php if  ( "gf" == $row['Class']) echo " selected ";?>>Great Feast</option>
				<option value="lf" <?php if  ( "lf" == $row['Class']) echo " selected ";?>>Lesser Feast</option>
				<option value="saint" <?php if  ( "saint" == $row['Class']) echo " selected ";?>>Feast such a Saint day (not on month view)</option>
				<option value="ser" <?php if  ( "ser" == $row['Class']) echo " selected ";?>>Service</option>
				<option value="read" <?php if  ( "read" == $row['Class']) echo " selected ";?>>Reading</option>
				<option value="fast" <?php if  ( "fast" == $row['Class']) echo " selected ";?>>Fast day</option>
				<option value="fastfree" <?php if  ( "fastfree" == $row['Class']) echo " selected ";?>>Fast Free day</option>
				<option value="memory" <?php if  ( "memory" == $row['Class']) echo " selected ";?>>Parish Bulletin Memory (not on month view)</option>
				<option value="health" <?php if  ( "health" == $row['Class']) echo " selected ";?>>Parish Bulletin Health (not on month view)</option>
			</select>	
			<br />
			Year: *<br />
			<input type="text" name='Year'  required value="<?php echo $row['Year'];?>">
			<br />
			Month: *<br />
			<select name='Month' required>			
				<option></option>
				<option value= 1 <?php if  ( 1 == $row['Month']) echo " selected ";?>>January</option>
				<option value= 2 <?php if  ( 2 == $row['Month']) echo " selected ";?>>February</option>
				<option value= 3 <?php if  ( 3 == $row['Month']) echo " selected ";?>>March</option>
				<option value= 4 <?php if  ( 4 == $row['Month']) echo " selected ";?>>April</option>
				<option value= 5 <?php if  ( 5 == $row['Month']) echo " selected ";?>>May</option>
				<option value= 6 <?php if  ( 6 == $row['Month']) echo " selected ";?>>June</option>
				<option value= 7 <?php if  ( 7 == $row['Month']) echo " selected ";?>>July</option>
				<option value= 8 <?php if  ( 8 == $row['Month']) echo " selected ";?>>August</option>
				<option value= 9 <?php if  ( 9 == $row['Month']) echo " selected ";?>>September</option>
				<option value= 10 <?php if  ( 10 == $row['Month']) echo " selected ";?>>October</option>
				<option value= 11 <?php if  ( 11 == $row['Month']) echo " selected ";?>>November</option>
				<option value= 12 <?php if  ( 12 == $row['Month']) echo " selected ";?>>December</option>
			</select>	
			<br />
			Day: *<br />
			<input type="number" name='Day'  required min="1" max="31" value="<?php echo $row['Day'];?>">
			<br />
			Link:<br />
			<input type="text" name='Link'  value="<?php echo $row['Link'];?>">
			<br />
			<?php cmog_input_text('icon', $row,'Icon to use'); ?>
			<?php cmog_input_text('hymn', $row,'Hymn to use'); ?>
			Status:<br />
			<select name='published' >
				<option value= -2 <?php if  ( -2 == $row['published']) echo " selected ";?>> Trashed</option>
				<option value= -1 <?php if  ( -1 == $row['published']) echo " selected ";?>> Archived</option>
				<option value= 0 <?php if  ( 0 == $row['published']) echo " selected ";?>> Draft</option>
				<option value= 1 <?php if  ( 1 == $row['published']) echo " selected ";?>> Published</option>
			</select>	
			<br />
			<?php cmog_input_text('access', $row,'Access'); ?>
			<?php cmog_input_text('language', $row,'Language'); ?>
			<hr />
			ID:<br />
			<input type="text" name='ID'  readonly  value="<?php echo $row['ID']; ?>">
			<br />
			<?php cmog_input_text('AddDate', $row,'Date Added'); ?>
			<?php cmog_input_text('listorder', $row,'Order'); ?>
			<?php cmog_input_text('popup', $row,'Display code'); ?>
			<?php cmog_input_text('asset_id', $row); ?>
			<?php cmog_input_text('catid', $row); ?>
			<?php cmog_input_text('created_by', $row,'Created by'); ?>  
			From Template type:<br />
			<select name='gmd' >
				<option value="0" ></option>
				<option value="-5" <?php if  ( -5 == $row['gmd']) echo " selected ";?>>Pascha</option>
				<option value="-4" <?php if  ( -4 == $row['gmd']) echo " selected ";?>>Triodion</option>
				<option value="-3" <?php if  ( -3 == $row['gmd']) echo " selected ";?>>Luke</option>
				<option value="-2" <?php if  ( -2 == $row['gmd']) echo " selected ";?>>Pentecost</option>
				<option value="-1" <?php if  ( -1 == $row['gmd']) echo " selected ";?>>Movable</option>
			</select>	
			<br />
			Template id:<br />
			<input type="text" name='tmplt_id'  readonly  value="<?php echo $row['tmplt_id']; ?>">
			<?php wp_nonce_field('cmog-event-update'); ?>
			<br />
			<hr />

			</form>
		</div>	 
	</div>
<?php
}