<?php

//----------------------------------------------------------
//..........................................................
/*

  The mktabbed() function creates the $tabs array to be
  passedon to mktabbed_html(), which generates the html.
  It can also change the tab names, and also exclude
  fields from being added to a tab.

  The structure of the $tabs array is:

      $tabs['tabid']['name'] = "name"
      $tabs['tabid']['fields'][n] = {fieldnames in tabid}

  mktabbed() uses fieldname prefixes to automatically
  create tabs. It automatically excludes fields named
  'id' and '*_id' from being placed in tabs. For example:

      id
      customer_name
      cust_last
      cust_birth
      cust_sex
      addr_street
      addr_city
      addr_state
      addr_zip
      unit_id

  The resulting detail view form will create tabs named:

      customer
      cust
      addr

  The 'id' and 'unit_id' fields are excluded. Instead of
  displaying in tab, they will display separately, above
  the tab area.

  To use, in tablename.php, in function tablename_dv():

      require('hooks/_mktabbed.php');

      $html .= mktabbed('tablename');

  Note that customer_name will result in a tab with just
  one field in it. Probably, what we really want is to show
  the customer_name above the tabs, like id and unit id.

  We probably also want the tab names to be 'Customer Info'
  and 'Address Info', instead of 'cust' and 'addr'. To do
  that, we call mktabbed() as follows:

      $html . = mktabbed(
                 'tablename',
	         'cust=Customer Info,addr=Address Info',
                 'id,customer_name,unit_id'
	       );

  Should you need to omit fields, but not change tab names,
  simply pass an empty string in the second parameter.

  Regarding radio buttons, include a 1 after the fieldname:

      fieldname1

*/
//..........................................................
//----------------------------------------------------------



function mktabbed($table, $names="", $omit="id,.*_id") {

 	// no tabs in print preview
	if(isset($_REQUEST['dvprint_x'])) return;

	// clean up return from get_sql_fields() to create
	// a list of field names as 'f1'f2'f3...'

	$search  = array ( "/,.*? as /"  ,  "/''/" );

	$replace = array ( ""            ,  "'"    );

	$fieldnames = preg_replace($search, $replace, ",".get_sql_fields($table));

	// drop any omitted fields (ie, omitted from tabs,
	// but still displayed at the top of the form - to
	// hide a field, use AppGini's field options)
	//
	// by default, the primary key (id) and foreign keys
	// (tablename_id) are omitted so they're not tabbed,
	// but the $omit parameter can be used to change this
	// (ie, drop other fields, or set to "" to drop none)

	foreach (explode(",", $omit) as $field) {
		$fieldnames = preg_replace("/'$field'/U", "'", $fieldnames);
	}

	// delete leading and trailing ' and explode into array

	$fieldnames = preg_replace("/^'|'$/", "", $fieldnames);

	$fields = explode("'", $fieldnames);

	// build an associative array that separates fields by
	// group (the first set of characters up to a _ char),
	// sets the tab name and the fields in the tab

	$tabs=array();
	$current="";

	foreach ($fields as $field) {
		// tab id is the chars up to the first _
		$tab = preg_replace("/_.*/", "", $field);
		if ($tab != $current) {
			// new tab id, set the name and #id
			// replace the tab name if found in $names
			$name = preg_replace("/.*,$tab=(.*?),.*/", "$1", ",$names,");
			// if name still has a , in it, then we don't have a
			// custom tab name so use the tab id
			if (strpos($name, ",") !== false) $name=ucfirst($tab);
			// set the tab name (title) and #id values
			$tabs[$tab]['name'] = $name;
		}
		// append the field name to the fields array for the tab id
		$tabs[$tab]['fields'][] = $field;
	}

	// now we have $tabs ready for mktabbed_html(), which
	// returns the html code, which we return to our caller

  return mktabbed_html($table, $tabs);

}



//----------------------------------------------------------
//..........................................................
/*

  What follows is basically what Ahmad provided in
  the Udemy course, but restructured a bit to allow
  it to be scripted a bit more cleanly.

  See file preamble for a infor on the array structure.

  Given a tablename, mktabbed() will build this array;
  however, it can be built manually, allowing unlimited
  control over tab/field placement, and then passed into
  this function.

  Note that the field order in the tab is defined by the
  order in the $tabs[tabid][fields] array. When using
  mktabbed(), this is the same as the field order in
  AppGini. When using mktabbed_html(), you have control
  over the order in the array. This is important to know
  since, when using mktabbed_html(), you may change the
  field order in AppGini and wonder why it does not
  change in the tabs. This isn't an issue with mktabbed().

  Using mktabbed() is quick and easy, but limited.

  Manually building $tabs and calling mktabbed_html() is
  a bit more difficult to set up, but much more versatile.
  Just be mindful of the field order in the array.

  So, how do you use mktabbed_html()?
  
  For example:

  TABLE     TAB            FIELDS
  customer  <no tab>       ID, FullName
            Personal Info  FirstName, LastName, Birthdate, Age
            Contact Info   Address, City, State, Zip, HomePhone, CellPhone
            Sales Info     ContractID, DiscountRate, FirstSale, LastSale

  In the customer.php file, customer_dv() function, add this code:

    require('hooks/_mktabbed.php');

    $tabs['pi']['name']   = 'Personal Info';
    $tabs['pi']['fields'] = explode(',' 'FirstName,LastName,Birthdate,Age');

    $tabs['ci']['name']   = 'Contact Info';
    $tabs['ci']['fields'] = explode(',' 'Address,City,State,Zip,HomePhone,CellPhone');

    $tabs['si']['name']   = 'Sales Info';
    $tabs['si']['fields'] = explode(',' 'ContractID,DiscountRate,FirstSale,LastSale');

    $html .= mktabbed_html('Customer', $tabs)

*/
//..........................................................
//----------------------------------------------------------



function mktabbed_html($table, &$tabs) {

 	// no tabs in print preview
	if(isset($_REQUEST['dvprint_x'])) return;

	// use output buffering to make code writing easier
        
        //Corrijo la clase del nav-tabs para que se parezca al original.
	ob_start(); ?>

	<div id="form-tabs" class="col-lg-11 col-lg-offset-1">

		<ul class="nav nav-tabs">
			<?php
			// we want to start with only the first tab active
			$first=true;
			foreach ($tabs as $tab => $tabinfo) {
				echo '<li '.(($first)?' class="active"':'')."><a href='#{$tab}-info' data-toggle='tab'>{$tabinfo[name]}</a></li>\n";
				$first=false;
			}
			?>
		</ul>

		<ul class="tab-content">

			<?php
			// again, start with only the first panel active
			$first=true;
			foreach ($tabs as $tab => $tabinfo) {
				echo '<div class="tab-pane form-horizontal '.(($first)?' active':'').'" id="'.$tab.'-info"></div>'."\n";
				$first=false;
			}
			?>
		</ul>

	</div>

  <?php /* this is the fix to keep all tabs visible */ ?>

	<style>
		#form-tabs .nav-tabs a{ display: block !important; }
                .select2-container  style{ width: 80%;}
	</style>

	<script>
		$j(function(){
			<?php
			// here is where we move fields, by name, into tabs
      			// (naturally, the more fields in the form, the slower
      			// this process will be to both gen and execute)
			echo "\$j('#form-tabs').appendTo('#{$table}_dv_form');\n";
			foreach ($tabs as $tab => $tabinfo) {
			  foreach ($tabinfo['fields'] as $tabfield) {
			    echo "\$j('#{$tabfield}').parents('.form-group').appendTo('#{$tab}-info');\n";
                            //echo "$j('#{$tabfield}').width('50%');\n";
                            
			  }
			}
                            echo "\$j('#s2id_Tipo-container').width('50%');\n";
                        ?>
                                
		})
	</script>

	<?php

	// flush buffer to var and cleanup

	$html = ob_get_contents();
	ob_end_clean();

	// pass our custom html back to our caller

	return $html;
}


//----------------------------------------------------------
// EOF(_mktabbed.php)
//-----------------------------------------------------------