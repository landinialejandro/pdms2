/**
 * Author:  ale
 * Created: 22/11/2018
 */
CREATE OR REPLACE VIEW SQL_averageWeightPrice AS 
SELECT
    orders.`date` as 'date',
    ordersDetails.productCode as 'prodId',
    products.productCode as 'code',
    products.productName as 'name',
    sum(IF(orders.kind = 'IN',ordersDetails.QuantityReal,0)) as 'PesoIN',
    sum(IF(orders.kind = 'OUT',ordersDetails.QuantityReal,0)) as 'PesoOUT',
    sum(IF(orders.kind = 'OUT',ordersDetails.QuantityReal * -1,ordersDetails.QuantityReal)) as 'PesoStock',
    avg(IF(orders.kind = 'IN',ordersDetails.QuantityReal,0)) as 'AVGWeightIN',
    avg(IF(orders.kind = 'OUT',ordersDetails.QuantityReal,0)) as 'AVGWeightOUT',
    avg(IF(orders.kind = 'IN',ordersDetails.LineTotal,0)) as 'AVGPriceIN',
    avg(IF(orders.kind = 'OUT',ordersDetails.LineTotal,0)) as 'AVGPriceOUT'
FROM
    orders
LEFT JOIN ordersDetails ON ordersDetails.`order` = orders.id
LEFT JOIN products on products.id = ordersDetails.productCode
WHERE orders.typeDoc = 'DDT' or orders.typeDoc = 'FTIM' 
GROUP BY
orders.`date`,
ordersDetails.productCode
