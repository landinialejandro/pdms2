CREATE OR REPLACE VIEW SQL_ordersDetails AS 
SELECT
    ordersDetails.`id`,
    `order`,
    `manufactureDate`,
    `sellDate`,
    `expiryDate`,
    `daysToExpiry`,
    `codebar`,
    `UM`,
    `productCode`,
    `batch`,
    `packages`,
    `noSell`,
    `Quantity`,
    `QuantityReal`,
    `UnitPrice`,
    `Subtotal`,
    `taxes`,
    `Discount`,
    `LineTotal`,
    `section`,
    `transaction_type`,
    `skBatches`,
    `averagePrice`,
    `averageWeight`,
    `commission`,
    `return`,
    `supplierCode`,
    orders.kind,
    orders.company,
    orders.typeDoc,
    orders.customer,
    orders.related,
    MONTH(orders.date) AS MONTH,
    YEAR(orders.date) AS YEAR
FROM
    `ordersDetails`
LEFT OUTER JOIN orders AS orders
ON
    orders.id = ordersDetails.order
WHERE orders.related IS NULL