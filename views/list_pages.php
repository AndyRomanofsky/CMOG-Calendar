<?php
/** **************** function cmog_render_list_page ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items();
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>CMOG Templates</h2> 
		<a href="/wp-admin?page=cmog_list_test&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is All CMOG Templates </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Luke list page ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function  cmog_render_luke_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();  
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-3);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Luke Templates</h2> 
		<a href="/wp-admin?page=cmog_list_test&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Luke Templates </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Pentecost list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_pentecost_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-2);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Pentecost Templates</h2> 
		<a href="/wp-admin?page=cmog_list_test&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Pentecost Templates  </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Pascha list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_pascha_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-5);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Pascha Templates</h2> 
		<a href="/wp-admin?page=cmog_list_test&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Pascha Templates  </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Triodion list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_triodion_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-4);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Triodion Templates</h2> 
		<a href="/wp-admin?page=cmog_list_test&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Triodion Templates  </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Movable list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_movable_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $TemplateMovableListTable = new CMOG_Movable_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateMovableListTable->prepare_items();
	if( 'edit' === $TemplateMovableListTable->current_action() | 'add' === $TemplateMovableListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Movable Templates</h2> 
		<a href="/wp-admin/admin.php?page=cmog_list_movable&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is the Movable Templates </p>
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateMovableListTable->display() ?>
        </form>
    </div>
    <?php
}
//cmog_render_events_list_page
/** *************************** RENDER Events list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_events_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $Events_List = new CMOG_Events_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $Events_List->prepare_items(); 
	//var_dump($Events_List);
	if( 'edit' === $Events_List->current_action() | 'add' === $Events_List->current_action()) RETURN;
	if( 'Calendar' === $Events_List->current_action()) {
		cmog_render_events_calendar_page();
		RETURN;
	}
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Events</h2> 
		<a href="/wp-admin/admin.php?page=cmog_list_events&action=add&event=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(some text) </p>
			<p> Events </p>
        </div>
		<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <br />
		  Year: <input type="text" name='f_year' <?php if ( !empty($_REQUEST['f_year'] ))     echo "Value='" . $_REQUEST['f_year'] . "'";?> >
		  Month: 
  <select name='f_month' >	
<option value= "" <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == null  )  echo " selected ";?>></option>;	  
<option value= 1 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 1  )  echo " selected ";?>>January</option>;
<option value= 2 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 2  )  echo " selected ";?>>February</option>;
<option value= 3 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 3  )  echo " selected ";?>>March</option>;
<option value= 4 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 4  )  echo " selected ";?>>April</option>;
<option value= 5 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 5  )  echo " selected ";?>>May</option>;
<option value= 6 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 6  )  echo " selected ";?>>June</option>;
<option value= 7 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 7  )  echo " selected ";?>>July</option>;
<option value= 8 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 8  )  echo " selected ";?>>August</option>;
<option value= 9 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 9  )  echo " selected ";?>>September</option>;
<option value= 10 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 10  )  echo " selected ";?>>October</option>;
<option value= 11 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 11  )  echo " selected ";?>>November</option>;
<option value= 12 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 12  )  echo " selected ";?>>December</option>;
	</select>		
			
		  
		  Day: <input type="text" name='f_day' <?php if ( !empty($_REQUEST['f_day'] ))     echo "Value='" . $_REQUEST['f_day'] . "'";?>> 
		  <input type="submit" value='Filter'>
		  <br />
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
        
            <?php $Events_List->display() ?>
        </form>
    </div>
    <?php
}
//cmog_render_events_list_page
/** *************************** RENDER Events list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_events_calendar_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    //Create an instance of our package class...
    $Events_Calendar = new CMOG_Events_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $Events_Calendar->prepare_items(); 
	//var_dump($Events_Calendar);
	if( 'edit' === $Events_Calendar->current_action() | 'add' === $Events_Calendar->current_action()| 'Calender' === $Events_Calendar->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Events</h2> 
		<a href="/wp-admin/admin.php?page=cmog_list_events&action=add&event=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(some text) </p>
			<p> Events </p>
        </div>
		<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <br />
		  Year: <input type="text" name='f_year' <?php if ( !empty($_REQUEST['f_year'] ))     echo "Value='" . $_REQUEST['f_year'] . "'";?> >
		  Month: 
  <select name='f_month' >	
<option value= "" <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == null  )  echo " selected ";?>></option>;	  
<option value= 1 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 1  )  echo " selected ";?>>January</option>;
<option value= 2 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 2  )  echo " selected ";?>>February</option>;
<option value= 3 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 3  )  echo " selected ";?>>March</option>;
<option value= 4 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 4  )  echo " selected ";?>>April</option>;
<option value= 5 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 5  )  echo " selected ";?>>May</option>;
<option value= 6 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 6  )  echo " selected ";?>>June</option>;
<option value= 7 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 7  )  echo " selected ";?>>July</option>;
<option value= 8 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 8  )  echo " selected ";?>>August</option>;
<option value= 9 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 9  )  echo " selected ";?>>September</option>;
<option value= 10 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 10  )  echo " selected ";?>>October</option>;
<option value= 11 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 11  )  echo " selected ";?>>November</option>;
<option value= 12 <?php if ( !empty($_REQUEST['f_month']) and $_REQUEST['f_month'] == 12  )  echo " selected ";?>>December</option>;
	</select>		
			
		  
		  Day: <input type="text" name='f_day' <?php if ( !empty($_REQUEST['f_day'] ))     echo "Value='" . $_REQUEST['f_day'] . "'";?>> 
		  <input type="submit" value='Filter'>
		  <br />
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
        
            <?php echo " <br /> calenmar <br />"?>
        </form>
    </div>
    <?php
}