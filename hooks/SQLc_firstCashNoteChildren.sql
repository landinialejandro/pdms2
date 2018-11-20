SELECT 
    `firstCashNote`.`id` as 'id', 
    IF(CHAR_LENGTH(`orders1`.`multiOrder`), CONCAT_WS('',   `orders1`.`multiOrder`), '') as 'Order', 
    IF(CHAR_LENGTH(`orders1`.`typeDoc`), CONCAT_WS('',   `orders1`.`typeDoc`), '') as 'Documento', 
    `companyMultycompany`.`companyName` as 'MultyCompany',
    CONCAT_WS('',`companyCustomer`.`companyName`,`companySupplier`.`companyName`) as 'Customer-Supplier',
    if(`firstCashNote`.`operationDate`,date_format(`firstCashNote`.`operationDate`,'%d/%m/%Y'),'') as 'operationDate', 
    `firstCashNote`.`causal` as 'causal', 
    `firstCashNote`.`revenue` as 'revenue', 
    `firstCashNote`.`outputs` as 'outputs', 
    `firstCashNote`.`balance` as 'balance', 
    IF(CHAR_LENGTH(`companyBank`.`companyName`), CONCAT_WS('',   `companyBank`.`companyName`), '') as 'Bank', 
    `firstCashNote`.`note` as 'note', 
    if(`firstCashNote`.`paymentDeadLine`,date_format(`firstCashNote`.`paymentDeadLine`,'%d/%m/%Y'),'') as 'paymentDeadLine', 
    if(CHAR_LENGTH(`firstCashNote`.`payed`)>50, concat(left(`firstCashNote`.`payed`,50),' ...'), 
    `firstCashNote`.`payed`) as 'payed' 
FROM 
    `firstCashNote` 
    LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`firstCashNote`.`order` 
    LEFT JOIN `companies` as companyBank ON `companyBank`.`id`=`firstCashNote`.`idBank` 
    LEFT JOIN `companies` as companyCustomer ON `companyCustomer`.`id`=`orders1`.`customer` 
    LEFT JOIN `companies` as companySupplier ON `companySupplier`.`id`=`orders1`.`supplier` 
    LEFT JOIN `companies` as companyMultycompany ON `companyMultycompany`.`id`=`orders1`.`company` 