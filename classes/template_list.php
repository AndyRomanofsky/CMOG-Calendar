<?php
/************************** CREATE A PACKAGE CLASS *****************************
 *******************************************************************************
 * Create a new list table package that extends the core WP_List_Table class.
 */
class CMOG_Template_List_Table extends WP_List_Table {
    /** ******************** function __construct *******************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct(){
        global $status, $page;
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'template',     //singular name of the listed records
            'plural'    => 'templates',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
    }
    /** ***********************function column_default************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For template, if the class needs to process a column
     * named 'EventText', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_EventText() method later on, this method doesn't
     * need to concern itself with any column with a name of 'EventText'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){ 
        switch($column_name){
            case 'week'   :
            case 'Link'  :
            case 'Class'  :
            case 'AddDate' :
            case 'icon' :
            case 'hymn' :
            case 'listorder'  :
            case 'popup'  :
            case 'asset_id'  :
            case 'catid'  :
            case 'created_by' : 
            case 'published' :
            case 'access' :
            case 'language' :
            case 'ID' :
            case 'Offset' :
            case 'Length' :
			     return $item[$column_name];
            default:
                return  "? - ". $column_name . "?";
        }
    }
    /** ****************** function column_EventText ************************
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'EventText'. Every time the class
     * needs to render a column, it first looks for a method named 
     * column_{$column_EventText} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     * 
     * This template also illustrates how to implement rollover actions. Actions
     * should be an associative array formatted as 'slug'=>'link html' - and you
     * will need to generate the URLs yourself. You could even ensure the links
     * 
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (Template title only)
     **************************************************************************/
    function column_EventText($item){
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&template=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&template=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
            'load'      => sprintf('<a href="?page=%s&action=%s&template=%s">Load</a>',$_REQUEST['page'],'load',$item['ID']),
        );
        //Return the title contents
        //return '<a href="?page=' . $_REQUEST['page'] . '&action=edit&template=' . $item['ID'] . '>' . $item['EventText'] . '</a> ' ;
        //return '<a href="?page=' . $_REQUEST['page'] . '&action=edit&template=' . $item['ID'] . '>' . $item['EventText'] . '</a> ' . $this->row_actions($actions);
         return $item['EventText'] . $this->row_actions($actions);
    }
    /** ************ function column_cb **********************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (EventText only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("template")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }
    function column_gmd($item){
		 switch($item['gmd']){
            case -5: return "Pascha";
            case -4  : return "Triodion";
            case  -3  : return "Luke";
            case  -2  : return "Pentecost";
            case  -1  : return "Movable";
            default:
                return print_r($item,true); //Show the item for troubleshooting purposes
        }
	}
    function column_wday($item){
		switch($item['wday']){
            case 0: return "Sunday";
            case 1  : return "Monday";
            case  2  : return "Tuesday";
            case  3  : return "Wednesday";
            case  4  : return "Thursday";
            case  5  : return "Friday";
            case  6  : return "Saturday";
            case  7  : return "Sunday";
            default:
                return print_r($item,true); //Show the item for troubleshooting purposes
        }
	}
    /** ***************** function get_columns ************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns(){ 
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'EventText'     => 'Event Text',
            'week'     => 'Week',
             'wday'      => 'Day',
             'Link'      => 'Link',
             'Class'     => 'Class',
             'icon'      => 'Icon',
             'hymn'     => 'Hymn',
             'listorder'      => 'List order',
             'popup'       => 'Popup',
             'asset_id'       => 'Asset id',
             'catid'      => 'Cat id',
             'created_by'     => 'Created by',
             'gmd'  =>    'Type',
             'published'      => 'Status',
             'access'  =>    'Access',
             'language'      => 'Language' ,
             'AddDate'     => 'Date added',
             'ID'     => 'ID',
        );
	  return $columns;
	}
    function get_hidden(){
        $hidden = array(
             'access' ,
             'language' ,
             'asset_id'  , 
             'catid' ,
             'popup'    ,
			 'Link',
             'icon' ,
             'hymn' ,
        );
        return $hidden;
    }
    /** ********* function get_sortable_columns *********************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     * you will need to register it here. This should return an array where the 
     * key is the column that needs to be sortable, and the value is db column to 
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     * 
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items() and sort
     * your data accordingly (usually by modifying your query).
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **************************************************************************/
    function get_sortable_columns(){
        $sortable_columns = array(
            'EventText'     => array('EventText',false),     //true means it's already sorted
            'week'    => array('week',false),
            'wday'  => array('wday',false),
            'ID'  => array('ID',false),
        );
        return $sortable_columns;
    }
    /** ***************** function get_bulk_actions *****************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete',
            'load'    => 'Load',
        );
        return $actions;
    }
    /** ********** function process_bulk_action *************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this template package, we will handle it in the class to keep things
     * clean and organized.
     * (For now all actions processed here)
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {
		parse_str($_SERVER['QUERY_STRING'], $query); var_dump($this->current_action());
	        if( 'delete'===$this->current_action() ) {
				if (!isset($query['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked for delete!</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
			echo "<div class='notice notice-success is-dismissible'>";
				// (code to delete many row)
				echo  	'<br /> (bulk) <br />';
				foreach ( $id as $value )
					{
					echo  "Deleted " . $value . "<br />";
					} 
				echo '</div>';
			} else {
			echo "<div class='notice notice-success is-dismissible'>";
				// (code to delete row)
				echo  '<br />deleting ' .  $id . ' (or it would be if we had items to delete)!</div>' ;
			} 
        }        
		if( 'edit'===$this->current_action() ) {
				if (!isset($query['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked for edit!</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
				// (code to delete many row)
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not bulk edit at this time) <br /></div>';
			} else {
				// (code to edit row)  
				cmog_render_edit_page($id);
			}
        }      
		if( 'add'===$this->current_action() ) {
				if (!isset($query['template'])) {
					echo "<div class='notice notice-success is-dismissible'>";
					echo  '<br />No rows are checked for add!</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
				// (code to add many row)
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not bulk add at this time) <br /></div>';
			} else {
				// (code to add row)  
				cmog_render_edit_page(0);
			}
        }    
		if( 'load'===$this->current_action() ) {
				if (!isset($query['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked for load!</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
				// (code to load many row)
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not bulk load at this time) <br /></div>';
			} else {
				// (code to load row)  
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not load at this time) <br /></div>';
			}
        }    
		if( 'update'===$this->current_action() ) {
				if (!isset($query['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />update</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
				// (code to load many row)
				echo "<div class='notice notice-success is-dismissible'>";
				echo  	'<br /> Updated <br /></div>';
			} else {
				// (code to load row)  
				echo "<div class='noticesuccess is-dismissible'>";
				echo  	'<br />Added <br /></div>';
			}
        }
    }
    /** ************* function prepare_items ********************* 
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items($cmog_template_type='ALL') {
        global $wpdb; //This is used only if making any database queries
        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 25;
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns($cmog_template_type);
        $hidden = $this->get_hidden($cmog_template_type);
        $sortable = $this->get_sortable_columns($cmog_template_type);
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
        /**
         * Fetch the template data
         * use sort and pagination data to build a custom query.
         */
		//$tquert = "SELECT * FROM cmog_templates";
		//$cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
        /**
         * This checks for sorting 
         */
		$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
		if ($cmog_template_type == 'Movable'){
			$orderby = " Offset $order " ;
		} else  { 
				if ( empty($_REQUEST['orderby'])) {
					  $orderby = " `gmd`  DESC , week  $order ,  wday $order" ;
				} elseif ($_REQUEST['orderby']  == 'week'){
					  $orderby = " `gmd`  DESC , week  $order ,  wday  $order" ; 
				} elseif ($_REQUEST['orderby']  == 'ID'){
					  $orderby = " ID  $order" ;       
				} elseif ($_REQUEST['orderby']  == 'wday'){
					  $orderby = " `gmd`  DESC , wday  $order ,  week  $order" ;    
				} elseif ($_REQUEST['orderby']  == 'EventText'){
					  $orderby = " EventText $order,`gmd`  DESC , wday  $order ,  week  $order" ;    
				} else {			
					$orderby = $_REQUEST['orderby'] . " " .$order ;
				}
		}
		if ($cmog_template_type == 'ALL'){
        $data = $wpdb->get_results( "SELECT * FROM `cmog66_cmog_templates` ORDER BY $orderby  ", 'ARRAY_A' ); 
        } elseif ($cmog_template_type == -5 ){ //Pascha
        $data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_templates WHERE gmd = -5 ORDER BY   $orderby  ", 'ARRAY_A' ); 
        } elseif ($cmog_template_type == -4){ //Triodion
        $data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_templates WHERE gmd = -4 ORDER BY   $orderby  ", 'ARRAY_A' ); 
        } elseif ($cmog_template_type == -3){ //Luke
        $data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_templates WHERE gmd = -3 ORDER BY   $orderby  ", 'ARRAY_A' ); 
        } elseif ($cmog_template_type == -2){ //Pentecost
        $data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_templates WHERE gmd = -2 ORDER BY   $orderby  ", 'ARRAY_A' ); 
        } elseif ($cmog_template_type == -1){ //Movable
        $data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_moveableevent WHERE gmd = -1 ORDER BY   $orderby  ", 'ARRAY_A' ); 
        } else {
        $data = $wpdb->get_results( "SELECT * FROM `cmog66_cmog_templates` ORDER BY $orderby  ", 'ARRAY_A' ); 
 		 }
        /***********************************************************************
         * http://codex.wordpress.org/Class_Reference/wpdb
         **********************************************************************/
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}