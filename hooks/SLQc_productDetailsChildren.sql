SELECT 
`ordersDetails`.`id` as 'id', 
IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'order', 
if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%d/%m/%Y'),'') as 'manufactureDate', 
if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%d/%m/%Y'),'') as 'sellDate', 
if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%d/%m/%Y'),'') as 'expiryDate', 
`ordersDetails`.`daysToExpiry` as 'daysToExpiry', 
IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') as 'codebar', 
IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') as 'UM', 
IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') as 'productCode', 
IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') as 'batch', 
`ordersDetails`.`packages` as 'packages', 
`ordersDetails`.`noSell` as 'noSell', 
`ordersDetails`.`Quantity` as 'Quantity', 
`ordersDetails`.`QuantityReal` as 'QuantityReal', 
CONCAT('&euro;', FORMAT(`ordersDetails`.`UnitPrice`, 2)) as 'UnitPrice', 
CONCAT('&euro;', FORMAT(`ordersDetails`.`Subtotal`, 2)) as 'Subtotal', 
CONCAT('&euro;', FORMAT(`ordersDetails`.`taxes`, 2)) as 'taxes', 
`ordersDetails`.`Discount` as 
'Discount', CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2)) as 'LineTotal', 
IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') as 'section', 
`kinds2`.`name` as 'transaction_type', 
`ordersDetails`.`skBatches` as 'skBatches', 
`ordersDetails`.`averagePrice` as 'averagePrice', 
`ordersDetails`.`averageWeight` as 'averageWeight', 
`ordersDetails`.`commission` as 'commission', 
concat('<i class=\"glyphicon glyphicon-', if(`ordersDetails`.`return`, 'check', 'unchecked'), '\"></i>') as 'return', 
`ordersDetails`.`supplierCode` as 'supplierCode' 
FROM 
`ordersDetails` 
LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`ordersDetails`.`order` 
LEFT JOIN `products` as products1 ON `products1`.`id`=`ordersDetails`.`productCode` 
LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`ordersDetails`.`section` 
LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders1`.`kind` 