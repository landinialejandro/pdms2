CREATE OR REPLACE VIEW SQL_productsStock AS 
SELECT
    ordersDetails.productCode as 'prodId',
    products.productCode as 'code',
    products.productName as 'name',
    sum(IF(orders.kind = 'IN',ordersDetails.Quantity,0)) as 'IN',
    sum(IF(orders.kind = 'OUT',ordersDetails.Quantity,0)) as 'OUT',
    sum(IF(orders.kind = 'OUT',ordersDetails.Quantity * -1,ordersDetails.Quantity)) as 'stock'
FROM
    orders
LEFT JOIN ordersDetails ON ordersDetails.`order` = orders.id
LEFT JOIN products on products.id = ordersDetails.productCode
GROUP BY
ordersDetails.productCode