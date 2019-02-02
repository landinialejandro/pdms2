<?php

//----------------------------------------------------------
//..........................................................
/*

  The mkbuttons() function adds buttons to the detail view
  button panel. It is passed a $buttons array, which gives
  the button group, id, text, style and icon.

  The structure of the $buttons array is:

      $buttons['group']['button'] = group and button names
      $buttons['group']['button']['name'] = "button name"  (button text)
      $buttons['group']['button']['insert'] = true or false
      $buttons['group']['button']['update'] = true or false
      $buttons['group']['button']['style'] = "default|success|warning|danger"
      $buttons['group']['button']['icon'] = any glyphicon, such as ok or print // need to put glyphicon glyphicon-print, complete code, this permit to put other icon like fa
      $buttons['group']['button']['onclick'] = null, or action_type
      $buttons['group']['button']['confirm'] = null, or confirm message

  The insert and update options control if the button is
  displayed when adding a record (insert) or editing a
  record (update). Of course, true or false can be any
  expression that evaluates to true or false, not just
  the literal values.

  If the group name is new/changes, then a new button group
  is started. Visually, this introduces a space between the
  button groups. If the group name is the same/unchanged,
  then the button is placed in the same group. Visually,
  this leaves no gap between buttons.

  The default button action (onclick) is to open the
  following custom page URL:
  
      mkb_{$table}-{$group}-{$button}.php?id=$selectedID'

  The custom page must reside in the main app directory.

  Three addition onclick actions are supported.

      "alert|message"
      "alert-ok|message"
      "alert-cancel|message"
      Displays the message in an alert dialog. If the
      'alert-cancel' form is used, then 'false' is the
      result; otherwise, it is true.

      "script|javascript"
      Uses the supplied javascript as the onclick action.

      "location|url"
      "location-id|url"
      Opens the supplied URL. Note that the SelectedID
      is not aaded to the URL unless the 'location-id'
      form is used.

  The onclick actions are inserted via jQuery. Whatever
  text the user supplies is encapsulated as follows:

      $j('#btnid').on('click', function() { <user-supplied> })

  If the 'confirm' option is not null, then the value is
  used as the text for a confirm() dialog. This allows
  for confirmation of the onclick action.

  The assumption for the default onclick action, is that
  the custom page will want to deal with one record from
  one table, that being the one where the button resided.
  The table name and the button info can be parsed from the
  script name. The record ID is passed as a parameter. (Of
  course, all this can be ignored and the custom script can
  do whatever you can conceive of.)

  So, how do you use mkbuttons()?
  
  Assume a table 'orders', to which we want to add 3 buttons.
  
  A 'Print Invoice' button that does not display when
  inserting a new record, or if the Order Total is zero.
  
  A 'Print Ticket' button, same rules as Print Invoice, and
  in the same button group.
  
  An 'Email Receipt' button, same rules, but new button group.

  In the orders.php file, orders_dv() function, add this code:

      // NOTE: instead of loading _mkbuttons (or _mktabbed)
      //       in each hook file, load it once in __global.php
      //
      //       require_once(dirname(__FILE__).'/_mkbuttons.php');
      //
      // Do that, and the next line isn't needed.

      require('hooks/_mkbuttons.php');

      $buttons['print']['invoice']['name'] = 'Print Invoice';
      $buttons['print']['invoice']['insert'] = false;
      $buttons['print']['invoice']['update'] = true;
      $buttons['print']['invoice']['style'] = 'default';
      $buttons['print']['invoice']['icon'] = 'print';
      $buttons['print']['invoice']['onclick'] = '';
      $buttons['print']['invoice']['confirm'] = '';

      $buttons['print']['voucher']['name'] = 'Print Voucher';
      $buttons['print']['voucher']['insert'] = false;
      $buttons['print']['voucher']['update'] = true;
      $buttons['print']['voucher']['style'] = 'default';
      $buttons['print']['voucher']['icon'] = 'print';
      $buttons['print']['voucher']['onclick'] = '';
      $buttons['print']['voucher']['confirm'] = 'Are you sure you want to print a voucher?';

      $buttons['email']['invoice']['name'] = 'Email Invoice';
      $buttons['email']['invoice']['insert'] = false;
      $buttons['email']['invoice']['update'] = true;
      $buttons['email']['invoice']['style'] = 'success';
      $buttons['email']['invoice']['icon'] = 'envelope';
      $buttons['print']['invoice']['onclick'] = 'alert-cancel|Feature under development';
      $buttons['email']['invoice']['confirm'] = '';

      $html .= mkbuttons('orders', $selecteID, $buttons)

  For those of you who'd prefer to define that array in a
  single statement... have fun with that :-)

  Next, create the custom page(s) to match your button
  definitions. In this example, create these files:

      mkb_orders-print-invoice.php
      mkb_orders-print-voucher.php
      mkb_orders-email-invoice.php

  See the AppGini web site, Online Help, Advanced, Custom
  Pages, for information on how to setup a custom page.

*/
//..........................................................
//----------------------------------------------------------



function mkbuttons($table, $selectedID, &$buttons) {

	// most of this is pulled from Ahmad's online course,
	// but considerably restructered to make it programmable

 	// no buttons in print preview
	if(isset($_REQUEST['dvprint_x'])) return;

	// initialize the html buffers

	$html = "<p></p>";
	$onclick = '';

	foreach ($buttons as $group => $buttongroup) {

		// open the button group

		$html .= '<div id="mkb_'.$group.'" class="btn-group-vertical btn-group-lg" style="width: 100%;">';

		foreach ($buttongroup as $buttonid => $button) {

			// skip buttons as directed

			if ($selectedID) {
				if ($button['update'] === false) continue;
			} else {
				if ($button['insert'] === false) continue;
			}

			// use defaults where needed

			if ($button['name']) {
				$name = $button['name'];
			} else {
				$name = '[ UNKNOWN ]';
			}

			if ($button['style']) {
				$style = $button['style'];
			} else {
				$style = 'default';
			}

			if ($button['icon']) {
				$icon = '<i class="'.$button['icon'].'"></i> ';
			} else {
				$icon = '';
			}

			// conventions for button ID and default PHP

//			$btnid = "{$table}_{$group}_{$buttonid}";
                        // get only the name button like id
			$btnid = "{$buttonid}";
			$phpid = "{$table}-{$group}-{$buttonid}.php";

			// output the button code

			$html .= '<button type="button" '
			       . 'id="'.$btnid.'" '
			       . 'class="btn btn-'.$style.' btn-lg">'
			       . $icon
			       . $name
			       . '</button>';

			// generate the jquery code

			$onclick .= "  \$j('#{$btnid}').on('click', function(){\n    ";

			if ($button['confirm'])
			  $onclick .= "if (confirm(\"".$button['confirm']."\")) { ";

			$action = explode('|', $button['onclick']);

			switch ($action[0]) {
			case 'alert':
			case 'alert-ok':
				$onclick .= 'alert("'.$action[1].'"); return true; ';
				break;
			case 'alert-cancel':
				$onclick .= 'alert("'.$action[1].'"); return false; ';
				break;
			case 'script':
				$onclick .= $action[1].'; ';
				break;
			case 'location':
				$onclick .= 'window.location="'.$action[1].'"; ';
				break;
			case 'location-id':
				$phpid = $action[1];
			default:
                                
				$onclick .= 'window.location="'.$phpid.'?SelectedID='.urlencode($selectedID).'"; ';
			}

			if ($button['confirm']) $onclick .= "}";

			$onclick .= "\n  });\n";

		}
	
		// close the button group

		$html .= "</div><p></p>";

	}

        // now add the jquery code to insert the button html

	$html = "<script>\n"
	        . "\$j(function(){\n"
		. "  \$j('#{$table}_dv_action_buttons .btn-toolbar').append(\n"
		. "    '{$html}'\n"
		. "  );\n"
		. "\n"
		. $onclick
		. "\n"
		. "});\n"
	        . "</script>\n";

	// pass our custom html back to our caller

	return $html;
}


//----------------------------------------------------------
// EOF(_mkbuttons.php)
//-----------------------------------------------------------