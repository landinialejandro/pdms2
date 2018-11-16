<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

/*
	ajax-callable script that returns code for either a combo drop-down or an auto-complete
	drop-down, based on number of items.

	REQUEST parameters:
	===============
	t: table name
	f: lookup field name
	id: selected id
	p: page number (default = 1)
	s: search term
	o: 0 (default) for text-only or 1 for full options list
	text: selected text
	filterer_[filterer]: name of filterer field to be used to filter the drop-down contents
				must be one of the filteres defined for the concerned field
*/

	$start_ts = microtime(true);

	// how many results to return per call, in case of json output
	$results_per_page = 50;

	$curr_dir = dirname(__FILE__);
	include("$curr_dir/defaultLang.php");
	include("$curr_dir/language.php");
	include("$curr_dir/lib.php");

	handle_maintenance();

	// drop-downs config
	$lookups = array(   
		'orders' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Orders%\' ORDER BY 2 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`companies`.`companyCode`) || CHAR_LENGTH(`companies`.`companyName`), CONCAT_WS(\'\', `companies`.`companyCode`, \' - \', `companies`.`companyName`), \'\')',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, IF(CHAR_LENGTH(`companies`.`companyCode`) || CHAR_LENGTH(`companies`.`companyName`), CONCAT_WS(\'\', `companies`.`companyCode`, \' - \', `companies`.`companyName`), \'\') FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%MC%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'typeDoc' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => 'IF(CHAR_LENGTH(`kinds`.`code`) || CHAR_LENGTH(`kinds`.`name`), CONCAT_WS(\'\', `kinds`.`code`, \' - \', `kinds`.`name`), \'\')',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, IF(CHAR_LENGTH(`kinds`.`code`) || CHAR_LENGTH(`kinds`.`name`), CONCAT_WS(\'\', `kinds`.`code`, \' - \', `kinds`.`name`), \'\') FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Documents%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'customer' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, `companies`.`companyName` FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%CUST%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'supplier' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, `companies`.`companyName` FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%PROV%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'employee' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`name`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'shipVia' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, `companies`.`companyName` FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%SHIP%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'ordersDetails' => array(   
			'order' => array(
				'parent_table' => 'orders',
				'parent_pk_field' => 'id',
				'parent_caption' => '`orders`.`id`',
				'parent_from' => '`orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'codebar' => array(
				'parent_table' => 'products',
				'parent_pk_field' => 'id',
				'parent_caption' => '`products`.`codebar`',
				'parent_from' => '`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'UM' => array(
				'parent_table' => 'products',
				'parent_pk_field' => 'id',
				'parent_caption' => '`products`.`UM`',
				'parent_from' => '`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'productCode' => array(
				'parent_table' => 'products',
				'parent_pk_field' => 'id',
				'parent_caption' => '`products`.`productCode`',
				'parent_from' => '`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'batch' => array(
				'parent_table' => 'products',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`products`.`productCode`) || CHAR_LENGTH(`products`.`id`), CONCAT_WS(\'\', `products`.`productCode`, \'-\', `products`.`id`), \'\')',
				'parent_from' => '`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'section' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`code`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
                        'IDproduct_lookup' => array(
                                'parent_table' => 'products',
                                'parent_pk_field' => 'id',
                                'parent_caption' => 'IF(CHAR_LENGTH(`products`.`codebar`) || CHAR_LENGTH(`products`.`productName`), CONCAT_WS(\'\', `products`.`codebar`, \' - \', `products`.`productName`), \'\')',
                                'parent_from' => '`products`',
                                'filterers' => array(),
                                'custom_query' => '',
                                'inherit_permissions' => true,
                                'list_type' => 0,
                                'not_null' => false
                        )
		),
		'_resumeOrders' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Orders%\' ORDER BY 2 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`companies`.`companyCode`) || CHAR_LENGTH(`companies`.`companyName`), CONCAT_WS(\'\', `companies`.`companyCode`, \' - \', `companies`.`companyName`), \'\')',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, IF(CHAR_LENGTH(`companies`.`companyCode`) || CHAR_LENGTH(`companies`.`companyName`), CONCAT_WS(\'\', `companies`.`companyCode`, \' - \', `companies`.`companyName`), \'\') FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%MC%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'typedoc' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => 'IF(CHAR_LENGTH(`kinds`.`code`) || CHAR_LENGTH(`kinds`.`name`), CONCAT_WS(\'\', `kinds`.`code`, \' - \', `kinds`.`name`), \'\')',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, IF(CHAR_LENGTH(`kinds`.`code`) || CHAR_LENGTH(`kinds`.`name`), CONCAT_WS(\'\', `kinds`.`code`, \' - \', `kinds`.`name`), \'\') FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Documents%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'customer' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, `companies`.`companyName` FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%CUST%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'related' => array(
				'parent_table' => 'orders',
				'parent_pk_field' => 'id',
				'parent_caption' => '`orders`.`id`',
				'parent_from' => '`orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'products' => array(   
			'tax' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Taxes%\' ORDER BY 2 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'CategoryID' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Products%\' ORDER BY 2 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'firstCashNote' => array(   
			'order' => array(
				'parent_table' => 'orders',
				'parent_pk_field' => 'id',
				'parent_caption' => '`orders`.`id`',
				'parent_from' => '`orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'idBank' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, `companies`.`companyName` FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%BANK%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'vatRegister' => array(   
			'idCompany' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyCode`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `companies`.`id`, IF(CHAR_LENGTH(`companies`.`companyCode`) || CHAR_LENGTH(`companies`.`companyName`), CONCAT_WS(\'\', `companies`.`companyCode`, \' - \', `companies`.`companyName`), \'\') FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`name`=`companies`.`kind` WHERE `companies`.`kind` like \'%MultyCompany%\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'companyName' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'companies' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Companies%\' ORDER BY 2 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			)
		),
		'contacts' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'name',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Contacts%\' ORDER BY 2 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'creditDocument' => array(  
		),
		'electronicInvoice' => array(  
		),
		'countries' => array(  
		),
		'town' => array(   
			'country' => array(
				'parent_table' => 'countries',
				'parent_pk_field' => 'id',
				'parent_caption' => '`countries`.`country`',
				'parent_from' => '`countries` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'GPSTrackingSystem' => array(  
		),
		'kinds' => array(  
		),
		'Logs' => array(  
		),
		'attributes' => array(   
			'attribute' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'code',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Attributes%\' ORDER BY 1 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'contact' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`id`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'companies' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`id`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'products' => array(
				'parent_table' => 'products',
				'parent_pk_field' => 'id',
				'parent_caption' => '`products`.`id`',
				'parent_from' => '`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'addresses' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'name',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Addresses%\' ORDER BY 1 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'country' => array(
				'parent_table' => 'countries',
				'parent_pk_field' => 'id',
				'parent_caption' => '`countries`.`country`',
				'parent_from' => '`countries` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'town' => array(
				'parent_table' => 'town',
				'parent_pk_field' => 'id',
				'parent_caption' => '`town`.`town`',
				'parent_from' => '`town` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`town`.`country` ',
				'filterers' => array('country' => 'country'),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'postalCode' => array(
				'parent_table' => 'town',
				'parent_pk_field' => 'id',
				'parent_caption' => '`town`.`shipCode`',
				'parent_from' => '`town` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`town`.`country` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'district' => array(
				'parent_table' => 'town',
				'parent_pk_field' => 'id',
				'parent_caption' => '`town`.`district`',
				'parent_from' => '`town` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`town`.`country` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'contact' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`id`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`id`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'phones' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'name',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Phones%\' ORDER BY 1 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'contact' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`id`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`id`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'mails' => array(   
			'kind' => array(
				'parent_table' => 'kinds',
				'parent_pk_field' => 'name',
				'parent_caption' => '`kinds`.`name`',
				'parent_from' => '`kinds` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `kinds`.`code`, `kinds`.`name` FROM `kinds` WHERE `kinds`.`entity` LIKE \'%Mails%\' ORDER BY 1 ',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'contact' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`id`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`id`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'contacts_companies' => array(   
			'contact' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`name`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`companyName`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'attachments' => array(   
			'contact' => array(
				'parent_table' => 'contacts',
				'parent_pk_field' => 'id',
				'parent_caption' => '`contacts`.`id`',
				'parent_from' => '`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'company' => array(
				'parent_table' => 'companies',
				'parent_pk_field' => 'id',
				'parent_caption' => '`companies`.`id`',
				'parent_from' => '`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		)
	);

	// XSS prevention
	$xss = new CI_Input();
	$xss->charset = datalist_db_encoding;

	// receive and verify user input
	$table_name = $_REQUEST['t'];
	$field_name = $_REQUEST['f'];
	$search_id = makeSafe(from_utf8($_REQUEST['id']));
	$selected_text = from_utf8($_REQUEST['text']);
	$returnOptions = ($_REQUEST['o'] == 1 ? true : false);
	$page = intval($_REQUEST['p']);
	if($page < 1)  $page = 1;
	$skip = $results_per_page * ($page - 1);
	$search_term = makeSafe(from_utf8($_REQUEST['s']));

	if(!isset($lookups[$table_name][$field_name])) die('{ "error": "Invalid table or field." }');

	// can user access the requested table?
	$perm = getTablePermissions($table_name);
	if(!$perm[0] && !$search_id) die('{ "error": "' . addslashes($Translation['tableAccessDenied']) . '" }');

	$field = $lookups[$table_name][$field_name];

	$wheres = array();

	// search term provided?
	if($search_term){
		$wheres[] = "{$field['parent_caption']} like '%{$search_term}%'";
	}

	// any filterers specified?
	if(is_array($field['filterers'])){
		foreach($field['filterers'] as $filterer => $filterer_parent){
			$get = (isset($_REQUEST["filterer_{$filterer}"]) ? $_REQUEST["filterer_{$filterer}"] : false);
			if($get){
				$wheres[] = "`{$field['parent_table']}`.`$filterer_parent`='" . makeSafe($get) . "'";
			}
		}
	}

	// inherit permissions?
	if($field['inherit_permissions']){
		$inherit = permissions_sql($field['parent_table']);
		if($inherit === false && !$search_id) die($Translation['tableAccessDenied']);

		if($inherit['where']) $wheres[] = $inherit['where'];
		if($inherit['from']) $field['parent_from'] .= ", {$inherit['from']}";
	}

	// single value?
	if($field['list_type'] != 2 && $search_id){
		$wheres[] = "`{$field['parent_table']}`.`{$field['parent_pk_field']}`='{$search_id}'";
	}

	if(count($wheres)){
		$where = 'WHERE ' . implode(' AND ', $wheres);
	}

	// define the combo and return the code
	$combo = new DataCombo;
	if($field['custom_query']){
		$qm = array(); $custom_where = ''; $custom_order_by = '2';
		$combo->Query = $field['custom_query'];

		if(preg_match('/ order by (.*)$/i', $combo->Query, $qm)){
			$custom_order_by = $qm[1];
			$combo->Query = preg_replace('/ order by .*$/i', '', $combo->Query);
		}

		if(preg_match('/ where (.*)$/i', $combo->Query, $qm)){
			$custom_where = $qm[1];
			$combo->Query = preg_replace('/ where .*$/i', '', $combo->Query);
		}

		if($where && $custom_where){
			$combo->Query .=  " {$where} AND ({$custom_where}) ORDER BY {$custom_order_by}";
		}elseif($custom_where){
			$combo->Query .=  " WHERE {$custom_where} ORDER BY {$custom_order_by}";
		}else{
			$combo->Query .=  " {$where} ORDER BY {$custom_order_by}";
		}

		$query_match = array();
		preg_match('/select (.*) from (.*)$/i', $combo->Query, $query_match);

		if(isset($query_match[2])){
			$count_query = "SELECT count(1) FROM {$query_match[2]}";
		}else{
			$count_query = '';
		}
	}else{
		$combo->Query = "SELECT " . ($field['inherit_permissions'] ? 'DISTINCT ' : '') . "`{$field['parent_table']}`.`{$field['parent_pk_field']}`, {$field['parent_caption']} FROM {$field['parent_from']} {$where} ORDER BY 2";
		$count_query = "SELECT count(1) FROM {$field['parent_from']} {$where}";
	}
	$combo->table = $table_name;
	$combo->parent_table = $field['parent_table'];
	$combo->SelectName = $field_name;
	$combo->ListType = $field['list_type'];
	if($search_id){
		$combo->SelectedData = $search_id;
	}elseif($selected_text){
		$combo->SelectedData = getValueGivenCaption($combo->Query, $selected_text);
	}

	if($field['list_type'] == 2){
		$combo->Render();
		$combo->HTML = str_replace('<select ', '<select onchange="' . $field_name . '_changed();" ', $combo->HTML);

		// return response
		if($returnOptions){
			?><span id="<?php echo $field_name; ?>-combo-list"><?php echo $combo->HTML; ?></span><?php
		}else{
			?>
				<span id="<?php echo $field_name; ?>-match-text"><?php echo $combo->MatchText; ?></span>
				<input type="hidden" id="<?php echo $field_name; ?>" value="<?php echo html_attr($combo->SelectedData); ?>" />
			<?php
		}
	}else{
		/* return json */
		header('Content-type: application/json');

		if(!preg_match('/ limit .+/i', $combo->Query)){
			if(!$search_id) $combo->Query .= " LIMIT {$skip}, {$results_per_page}";
			if($search_id) $combo->Query .= " LIMIT 1";
		}

		$prepared_data = array();

		// specific caption provided and list_type is not radio?
		if(!$search_id && $selected_text){
			$search_id = getValueGivenCaption($combo->Query, $selected_text);
			if($search_id) $prepared_data[] = array('id' => to_utf8($search_id), 'text' => to_utf8($xss->xss_clean($selected_text)));
		}else{
			$res = sql($combo->Query, $eo);
			while($row = db_fetch_row($res)){
				if(empty($prepared_data) && $page == 1 && !$search_id && !$field['not_null']){
					$prepared_data[] = array('id' => empty_lookup_value, 'text' => to_utf8("<{$Translation['none']}>"));
				}

				$prepared_data[] = array('id' => to_utf8($row[0]), 'text' => to_utf8($xss->xss_clean($row[1])));
			}
		}

		if(empty($prepared_data)){ $prepared_data[] = array('id' => '', 'text' => to_utf8($Translation['No matches found!'])); }

		echo json_encode(array(
			'results' => $prepared_data,
			'more' => (@db_num_rows($res) >= $results_per_page),
			'elapsed' => round(microtime(true) - $start_ts, 3)
		));
	}

