<?php
	/*
	 * You can add custom links in the home page by appending them here ...
	 * The format for each link is:
		$homeLinks[] = array(
			'url' => 'path/to/link', 
			'title' => 'Link title', 
			'description' => 'Link text',
			'groups' => array('group1', 'group2'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => '', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => '', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => '', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'path/to/icon', // optional icon to use with the link
			'table_group' => '' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
		);
	 */

		$homeLinks[] = array(
			'url' => 'orders_view.php?SortField=&SortDirection=&FilterAnd%5B1%5D=and&FilterAnd%5B2%5D=and&FilterField%5B2%5D=2&FilterOperator%5B2%5D=equal-to&FilterValue%5B2%5D=Output&FilterAnd%5B5%5D=and',//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in this case 
			'title' => 'Ordini Output', 
			'description' => 'Ordini fatti dai clienti, con i nuovi ordini elencati per primi.
                                            La cronologia degli ordini puo essere specificata utilizzando
                                            un filtro con numerose opzioni di scelta.',
			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => 'btn btn-block btn-lg btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'resources/table_icons/cart_remove.png', // optional icon to use with the link
			'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
		);
		$homeLinks[] = array(
			'url' => 'orders_view.php?SortField=&SortDirection=&FilterAnd%5B1%5D=and&FilterAnd%5B2%5D=and&FilterField%5B2%5D=2&FilterOperator%5B2%5D=equal-to&FilterValue%5B2%5D=Input&FilterAnd%5B5%5D=and',//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in this case 
			'title' => 'Ordini Input', 
			'description' => 'Ordini Input',
			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => 'btn btn-block btn-lg btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'resources/table_icons/cart_put.png', // optional icon to use with the link
			'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
		);
		//get cdefault compnay A
                $def_a = sqlValue("SELECT id FROM `SQL_defaultsCompanies` WHERE `attribute` = 'DEF_A' AND `value` = 1");
                
                if ($def_a >0){
                    $name = sqlValue("SELECT companyName FROM `SQL_defaultsCompanies` WHERE `attribute` = 'DEF_A' AND `value` = 1");
                    $homeLinks[] = array(
                            'url' => 'orders_view.php?addNew_x=1&mc='. $def_a .'&ok=OUT&dk=DDT', 
                            'title' => 'Azienda '. $name .' Add DDT Order', 
                            'description' => 'Add ddt order to my Azienda A (MyOneCompany). '
                        . 'You can change this Company from companies attributes',
                            'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
                            'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
                            'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
                            'link_classes' => 'btn btn-block btn-lg btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
                            'icon' => 'resources/table_icons/lightning.png', // optional icon to use with the link
                            'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
                    );
                }
		
                $def_b = sqlValue("SELECT id FROM `SQL_defaultsCompanies` WHERE `attribute` = 'DEF_B' AND `value` = 1");
                if ($def_b >0){
                    $name = sqlValue("SELECT companyName FROM `SQL_defaultsCompanies` WHERE `attribute` = 'DEF_B    ' AND `value` = 1");
                    $homeLinks[] = array(
                            'url' => 'orders_view.php?addNew_x=1&mc='. $def_b .'&ok=OUT&dk=DDT',//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in this case 
                            'title' => 'Azienda '. $name .' Add DDT Order', 
                            'description' => 'Add ddt order to my Azienda B (MyTwoCompany). '
                        . 'You can change this Company from companies attributes',
                            'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
                            'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
                            'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
                            'link_classes' => 'btn btn-block btn-lg btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
                            'icon' => 'resources/table_icons/lightning.png', // optional icon to use with the link
                            'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
                    );
                }

                ?>
<script>
  $j(document).ready(function(){
      $j('#orders-tile').hide();    
  });
</script>