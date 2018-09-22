CREATE OR REPLACE VIEW DDT_printResume AS 
SELECT
    multyCompany.idCompany,
    multyCompany.id AS 'multyCompanyId',
    customers.companyName,
    customers.CustomerID,
    orders.multiOrder,
    orders.OrderDate,
    products.UM,
    order_details.Quantity,
    order_details.boolSelect,
    products.UnitPrice,
    products.ProductName,
    taxCategories.descrizioneAliquota,
    taxCategories.percentuale,
    order_details.LineTotal,
    MONTH(orders.OrderDate) AS MONTH,
    YEAR(orders.OrderDate) AS YEAR
FROM
    orders AS orders
LEFT OUTER JOIN multyCompany AS multyCompany
ON
    orders.idCompany = multyCompany.id
LEFT OUTER JOIN order_details AS order_details
ON
    orders.OrderID = order_details.OrderID
LEFT OUTER JOIN products AS products
ON
    order_details.productCode = products.ProductID
LEFT OUTER JOIN taxCategories AS taxCategories
ON
    products.tax = taxCategories.id
LEFT OUTER JOIN customers AS customers
ON
    orders.CustomerID = customers.CustomerID
LEFT OUTER JOIN docCategories AS docCategories
ON
    orders.outTypeDoc = docCategories.id