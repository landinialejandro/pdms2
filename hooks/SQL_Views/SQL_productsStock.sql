/*
Select stock for DDT document
*/
CREATE OR REPLACE VIEW SQL_productsStock AS 
SELECT
    ordersDetails.productCode as 'prodId',
    products.productCode as 'code',
    products.productName as 'name',
    sum(IF(orders.kind = 'IN' ,ordersDetails.QuantityReal,0)) as 'PesoIN',
    sum(IF(orders.kind = 'OUT',ordersDetails.QuantityReal,0)) as 'PesoOUT',
    sum(IF(orders.kind = 'OUT',ordersDetails.QuantityReal * -1,ordersDetails.QuantityReal)) as 'PesoStock',
    sum(IF(orders.kind = 'IN' ,ordersDetails.QuantityReal,0)) - sum(IF(orders.kind = 'IN' ,ordersDetails.packages * products.tare,0)) as 'NetoIN',
    sum(IF(orders.kind = 'OUT',ordersDetails.QuantityReal,0)) - sum(IF(orders.kind = 'OUT',ordersDetails.packages * products.tare,0)) as 'NetoOUT',
    sum(IF(orders.kind = 'IN' ,ordersDetails.packages,0)) as 'IN',
    sum(IF(orders.kind = 'OUT',ordersDetails.packages,0)) as 'OUT',
    sum(IF(orders.kind = 'OUT',ordersDetails.packages * -1,ordersDetails.packages)) as 'Stock'
FROM
    orders
LEFT JOIN ordersDetails ON ordersDetails.`order` = orders.id
LEFT JOIN products on products.id = ordersDetails.productCode
WHERE orders.typeDoc = 'DDT' or orders.typeDoc = 'FTIM'
GROUP BY
ordersDetails.productCode