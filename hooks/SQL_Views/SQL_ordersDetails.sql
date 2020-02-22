CREATE OR REPLACE VIEW SQL_ordersDetails AS 
SELECT
    ordersDetails.id,
    ordersDetails.`order`,
    ordersDetails.manufactureDate,
    ordersDetails.sellDate,
    ordersDetails.expiryDate,
    ordersDetails.daysToExpiry,
    ordersDetails.codebar,
    ordersDetails.UM,
    ordersDetails.productCode,
    ordersDetails.batch,
    ordersDetails.packages,
    ordersDetails.noSell,
    ordersDetails.Quantity,
    ordersDetails.QuantityReal,
    ordersDetails.UnitPrice,
    ordersDetails.Subtotal,
    ordersDetails.taxes,
    ordersDetails.Discount,
    ordersDetails.LineTotal,
    ordersDetails.`section`,
    ordersDetails.transaction_type,
    ordersDetails.skBatches,
    ordersDetails.averagePrice,
    ordersDetails.averageWeight,
    ordersDetails.commission,
    ordersDetails.`return`,
    ordersDetails.supplierCode,
    ordersDetails.related as 'rel-DDT',
    orders.kind,
    orders.company,
    orders.typeDoc,
    orders.customer,
    orders.related,
    MONTH(orders.date) AS MONTH,
    YEAR(orders.date) AS YEAR
FROM
    ordersDetails
LEFT OUTER JOIN orders AS orders
ON
    orders.id = ordersDetails.order
WHERE 
1=1
AND orders.related IS NULL
AND orders.typeDoc = "DDT"