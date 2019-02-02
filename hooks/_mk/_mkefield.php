<?php

//----------------------------------------------------------
//..........................................................
/*

  The mkfield() function adds a field to the detail view of
  a record. If tabs are being used, the field can be placed
  either above or inside the tabs.
  
  Currently, only 'text' type fields have been tested. In
  the future, support will include checkbox, textarea and
  hidden fields. Other field types may or may not be added
  to that list.

  The syntax for mkfield() is:

  function mkfield($after, $type, $id, $name, $label, $placeholder, $value) {
	<text> = mkfield(
		existing_field_id,	// new field is inserted AFTER this
		new_field_type,		// text, hidden, checkbox, etc
		new_field_id,
		new_field_name,		// id and name, typically the same
		new_field_label,
		new_field_placeholder,
		new_field_value
		)

  So, for example, assume the page is being built in a var
  named $html, and we want to insert a new field "Company"
  after an existing field "Contact Name", and want to show
  a placeholder of "Enter the company name".

  To use, in tablename.php, in function tablename_dv():

      require('hooks/_mkfield.php');

      $html .= mkfield(
			'contact_name',
			'text',
			'company',
			'company',
			'Company Name',
			'Enter the company name',
			''
		);

  If the field is to appear inside a tab, define the tabs
  first, before calling mkfield(). However, if the field is
  to reside outside (ie, above) any tabs, then position the
  call to mkfield before the call to mktabbed.

  Note that mkfield cannot (yet) insert fields before other
  fields. That's a future upgrade.

*/
//..........................................................
//----------------------------------------------------------


function mkfield($after, $type, $id, $name, $label, $placeholder, $value) {

	$after=htmlentities($after);
	$type=htmlentities($type);
	$id=htmlentities($id);
	$name=htmlentities($name);
	$label=htmlentities($label);
	$placeholder=htmlentities($placeholder);
	$value=htmlentities($value);

	return ""
	. "<script>\n"
	. "  \$j(function(){\n"
	. "    \$j(\"#{$after}\").parents('.form-group').after(\""
	.       "<div class='form-group'>"
	.         "<label for='{$id}' class='control-label col-lg-3'>{$label}</label>"
	.           "<div class='col-lg-9'>"
	.             "<input type='{$type}' class='form-control' id='{$id}' name='{$name}' placeholder='{$placeholder}' value='{$value}'>"
	.           "</div>"
	.       "</div>"
	.     "\");\n"
	. "  });\n"
	. "</script>\n";

}
?>