<?php
/** Helper functions for edit fields. **/
/** Render a for text fields. **/
function cmog_input_text($field, $row, $label=null, $id=null  ){
	if ( empty($label)) $label = $field; 
	if ( empty($id))	$id = $field; 
	$value = $row[$field];
    echo "<label for=$id>$label:</label><br />";
    echo "<input type='text' name='$field' id='$id'   value=$value  ><br />";
}
/** cmog_render_edit_page
This is for the all templates except Movable
*/
function cmog_render_edit_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	if ($id) { // id  = 0 is add not edit
        global $wpdb; //This is used only if making any database queries
				 $row = $wpdb->get_row( "SELECT * FROM `cmog66_cmog_templates` where ID = $id  ", 'ARRAY_A' ); 
				 echo $row['gmd'] ; 
    } else {
		$row['ID'] = $row['EventText'] = $row['week'] =$row['wday'] = $row['Link'] = $row['Class'] = $row['icon'] = $row['hymn'] = "";
		$row['listorder'] = $row['popup'] = $row['asset_id'] =$row['catid'] = $row['created_by'] = $row['gmd'] = $row['published'] = $row['access'] = $row['language'] = "";
		$row['AddDate'] = "?"; 
	} 
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
	<?php if ($id) { ?>
		<h2>Update CMOG Template</h2>
	<?php } else {  ?>
		<h2>Add new CMOG Template</h2>
	<?php }   ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(Update/Add template info here) </p>
			<p> Template type is <?php echo $cmog_template_type; ?>  </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get"	action="/wp-admin?page=cmog_list_test">
       <fieldset>
          <legend>Selecting elements</legend>
		   <input type="hidden" id="page" name="page" value="cmog_list_test">
		   <input type="hidden" id="action" name="action" value="update">
  <br />
  ID:<br />
  <input type="text" name='ID'  readonly  value="<?php echo $row['ID']; ?>">
  <br />
  <?php cmog_input_text('EventText', $row,'Event'); ?>
  week:<br />
  <input type="number" name='week'   value="<?php echo $row['week']; ?>" min="1" max="52" >
  <br />
  wday:<br />
  <select name='wday'>
 				 <option value="0" <?php if  ( 0 == $row['wday']) echo " selected ";?>>Sunday (1st day)</option>
  				 <option value="1" <?php if  ( 1 == $row['wday']) echo " selected ";?>>Monday</option>
				 <option value="2" <?php if  ( 2 == $row['wday']) echo " selected ";?>>Tuesday</option>
				 <option value="3" <?php if  ( 3 == $row['wday']) echo " selected ";?>>Wednesday</option>
				 <option value="4" <?php if  ( 4 == $row['wday']) echo " selected ";?>>Thursday</option>
				 <option value="5" <?php if  ( 5 == $row['wday']) echo " selected ";?>>Friday</option>
				 <option value="6" <?php if  ( 6 == $row['wday']) echo " selected ";?>>Saturday</option>
				 <option value="7" <?php if  ( 7 == $row['wday']) echo " selected ";?>>Sunday (Last day)</option>
  </select>				 
  <br />
  <?php cmog_input_text('Link', $row,'Link to use'); ?>
  Class:<br />
    <select name='Class' >
                          <option value="gf" <?php if  ( "gf" == $row['Class']) echo " selected ";?>>Great Feast</option>
                        <option value="lf" <?php if  ( "lf" == $row['Class']) echo " selected ";?>>Lesser Feast</option>
                        <option value="saint" <?php if  ( "saint" == $row['Class']) echo " selected ";?>>Feast such a Saint day (not on month view)</option>
                        <option value="evt" <?php if  ( "evt" == $row['Class']) echo " selected ";?>>Event</option>
                        <option value="ser" <?php if  ( "ser" == $row['Class']) echo " selected ";?>>Service</option>
                        <option value="read" <?php if  ( "read" == $row['Class']) echo " selected ";?>>Reading</option>
                        <option value="fast" <?php if  ( "fast" == $row['Class']) echo " selected ";?>>Fast day</option>
                        <option value="fastfree" <?php if  ( "fastfree" == $row['Class']) echo " selected ";?>>Fast Free day</option>
                        <option value="memory" <?php if  ( "memory" == $row['Class']) echo " selected ";?>>Parish Bulletin Memory (not on month view)</option>
                        <option value="health" <?php if  ( "health" == $row['Class']) echo " selected ";?>>Parish Bulletin Health (not on month view)</option>
    </select>	
  <br />
  <?php cmog_input_text('AddDate', $row,'Date Added'); ?>
    <?php cmog_input_text('icon', $row,'Icon to use'); ?>
    <?php cmog_input_text('hymn', $row,'Hymn to use'); ?>
    <?php cmog_input_text('listorder', $row,'Order'); ?>
    <?php cmog_input_text('popup', $row,'Display code'); ?>
    <?php cmog_input_text('asset_id', $row); ?>
    <?php cmog_input_text('catid', $row); ?>
    <?php cmog_input_text('created_by', $row,'Created by'); ?>  
	gmd:<br />
  <select name='gmd' >
				 <option value="-5" <?php if  ( -5 == $row['gmd']) echo " selected ";?>>Pascha</option>
  				 <option value="-4" <?php if  ( -4 == $row['gmd']) echo " selected ";?>>Triodion</option>
				 <option value="-3" <?php if  ( -3 == $row['gmd']) echo " selected ";?>>Luke</option>
				 <option value="-2" <?php if  ( -2 == $row['gmd']) echo " selected ";?>>Pentecost</option>
				 <option value="-1" <?php if  ( -1 == $row['gmd']) echo " selected ";?>>Movable</option>
  </select>	
  <br />
    <?php cmog_input_text('published', $row,'Status'); ?>
    <?php cmog_input_text('access', $row,'Access'); ?>
    <?php cmog_input_text('language', $row,'Language'); ?>
    <input type="submit" value="Submit">
  <br />	
  </fieldset>
			</form>
	</div>	 
    </div>
    <?php
}
/** cmog_render_edit_Movable_page
This is for the Movable template only
*/
function cmog_render_edit_Movable_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	if ($id) { // id  = 0 is add not edit
        global $wpdb; //This is used only if making any database queries
				 $row = $wpdb->get_row( "SELECT * FROM `cmog66_cmog_moveableevent` where ID = $id  ", 'ARRAY_A' ); 
				if ($row == null)    echo "No data"; 
    } else {
		$row['ID'] = $row['EventText'] = $row['week'] =$row['wday'] = $row['Link'] = $row['Class'] = $row['icon'] = $row['hymn'] = "";
		$row['listorder'] = $row['popup'] = $row['asset_id'] =$row['catid'] = $row['created_by'] = $row['gmd'] = $row['published'] = $row['access'] = $row['language'] = "";
		$row['AddDate'] = "?"; 
	} 
    $cmog_template_type =  (int)(!empty($row['gmd'])) ? $row['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
	<?php if ($id) { ?>
		<h2>Update Movable Template</h2>
	<?php } else {  ?>
		<h2>Add new Movable Template</h2>
	<?php }   ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(Update/Add template info here) </p>
			<p> Template type is <?php echo $cmog_template_type; ?>  </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get">
  <br />
  ID:<br />
  <input type="text" name='ID'    value="<?php echo $row['ID'];?>">
  <br />
  <label for='id1'>Event Text:</label><br />
  <input type="text" name='EventText' id='id1'   value="<?php echo $row['EventText'];?>">
  <br />
  Offset:<br />
  <input type="text" name='Offset'   value="<?php echo $row['Offset'];?>">
  <br />
  Length:<br />
  <input type="text" name='Length'   value="<?php echo $row['Length'];?>">
  <br />
  Link:<br />
  <input type="text" name='Link'  value="<?php echo $row['Link'];?>">
  <br />
  Class:<br />
  <input type="text" name='Class'  value="<?php echo $row['Class'];?>">
  <br />
  AddDate:<br />
  <input type="text" name='AddDate'  value="<?php echo $row['AddDate'];?>">
  <br />
  icon:<br />
  <input type="text" name='icon'   value="<?php echo $row['icon'];?>">
  <br />
  hymn:<br />
  <input type="text" name='hymn'  value="<?php echo $row['hymn'];?>">
  <br />
  listorder:<br />
  <input type="text" name='listorder'   value="<?php echo $row['listorder'];?>">
  <br />
  popup:<br />
  <input type="text" name='popup'  value="<?php echo $row['popup'];?>">
  <br />
  asset_id:<br />
  <input type="text" name='asset_id'   value="<?php echo $row['asset_id'];?>">
  <br />
  catid:<br />
  <input type="text" name='catid' value="<?php echo $row['catid'];?>">
  <br />
  created_by:<br />
  <input type="text" name='created_by'  value="<?php echo $row['created_by'];?>">
  <br />
  gmd:<br />
  <input type="text" name='gmd'   value="<?php echo $row['gmd'];?>">
  <br />
  published:<br />
  <input type="text" name='published'  value="<?php echo $row['published'];?>">
  <br />
  access:<br />
  <input type="text" name='access'   value="<?php echo $row['access'];?>">
  <br />
  language:<br />
  <input type="text" name='language'  value="<?php echo $row['language'];?>">
  <br />	
			</form>
	</div>	 
    </div>
    <?php
}
