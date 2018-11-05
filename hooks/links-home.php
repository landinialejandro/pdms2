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
//                $homeLinks[] = array(
//			'url' => '#', 
//			'title' => 'Testing', 
//			'description' => 'Link text',
//			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
//			'grid_column_classes' => '', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
//			'panel_classes' => '', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
//			'link_classes' => '', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
//			'icon' => '', // optional icon to use with the link
//			'table_group' => '*' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
//		);
//                $homeLinks[] = array(
//			'url' => '#', 
//			'title' => 'Testing2', 
//			'description' => 'Link text',
//			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
//			'grid_column_classes' => '', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
//			'panel_classes' => '', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
//			'link_classes' => '', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
//			'icon' => '', // optional icon to use with the link
//			'table_group' => '' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
//		);
                
                $okName = makeSafe(sqlValue("SELECT name from kinds where code = 'OUT'"));
                
		$homeLinks[] = array(
			'url' => 'orders_view.php?ok='.$okName,//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in case 
			'title' => 'Ordini Output', 
			'description' => 'Ordini fatti dai clienti, con i nuovi ordini elencati per primi.
                                            La cronologia degli ordini puo essere specificata utilizzando
                                            un filtro con numerose opzioni di scelta.',
			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => 'btn btn-block  btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'resources/table_icons/cart_remove.png', // optional icon to use with the link
			'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
		);
                $okName = makeSafe(sqlValue("SELECT name from kinds where code = 'IN'"));
		$homeLinks[] = array(
			'url' => 'orders_view.php?ok='.$okName,//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in case 
			'title' => 'Ordini Input', 
			'description' => 'Ordini Input',
			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => 'btn btn-block  btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'resources/table_icons/cart_put.png', // optional icon to use with the link
			'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
		);
		//get cdefault compnay A
                $res = sql("SELECT id, companyName FROM `SQL_defaultsCompanies` WHERE `attribute` = 'DEF_A' AND `value` = 1 LIMIT 1;",$eo);
                if (($def_a = db_fetch_assoc($res))) {
                    $homeLinks[] = array(
                            'url' => 'orders_view.php?addNew_x=1&mc='. $def_a['id'] .'&ok=OUT&dk=DDT', 
                            'title' => 'Azienda ' . $def_a['companyName'] . ' Add DDT Order', 
                            'description' => 'Add ddt order to my Azienda A (MyOneCompany). '
                        . 'You can change this Company from companies attributes',
                            'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
                            'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
                            'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
                            'link_classes' => 'btn btn-block  btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
                            'icon' => 'resources/table_icons/lightning.png', // optional icon to use with the link
                            'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
                    );
                }
                
                $res = sql("SELECT id, companyName FROM `SQL_defaultsCompanies` WHERE `attribute` = 'DEF_B' AND `value` = 1 LIMIT 1;",$eo);
                if (($def_b = db_fetch_assoc($res))) {
                    $homeLinks[] = array(
                            'url' => 'orders_view.php?addNew_x=1&mc='. $def_b['id'] .'&ok=OUT&dk=DDT',//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in this case 
                            'title' => ''. $def_b['companyName'] .' Add DDT Order', 
                            'description' => 'Add ddt order to my Azienda B (MyTwoCompany). '
                        . 'You can change this Company from companies attributes',
                            'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
                            'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
                            'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
                            'link_classes' => 'btn btn-block  btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
                            'icon' => 'resources/table_icons/lightning.png', // optional icon to use with the link
                            'table_group' => 'Documenti' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
                    );
                }

                getEntitiesKind("Companies", $homeLinks,"companies");
                getEntitiesKind("Contacts",$homeLinks,"contacts");
                
                
                        
function getEntitiesKind($entity, &$homeLinks, $tn){
    //get entities company kinds
    $kEntities = sql("select code, name from kinds where `kinds`.`entity` LIKE '%{$entity}%'",$eo);

    foreach($kEntities as $i => $kEntity){
        $kValues=sqlValue("select value from kinds where code = '{$kEntity['code']}' ");
        $json = json_decode($kValues,true);
        $ico="lightning.png";
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON is valid
            $ico = $json['ico'];
        }
        $homeLinks[] = array(
                'url' => "{$tn}_view.php?ck={$kEntity['name']}",//Add a new order to mc(multicompany)1,ok order kind output, dk= document kind DDT in this case 
                'title' => ''. $kEntity['name'], 
                'description' => "Add a {$kEntity['name']} companie",
                'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
                'grid_column_classes' => 'col-lg-6', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
                'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
                'link_classes' => 'btn btn-block  btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
                'icon' => 'resources/table_icons/'.$ico, // optional icon to use with the link
                'subGroup' => "{$entity}", // optional icon to use with the link
                'table_group' => 'Anagrafiche' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
        );
     }
    return $homeLinks;
}
