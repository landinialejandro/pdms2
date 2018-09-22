
CREATE OR REPLACE VIEW resume AS 
SELECT
    `idCompany`,
    `outTypeDoc`,
    `CustomerID`,
    SUM(`OrderTotal`) AS 'TOT',
    MONTH(`OrderDate`) AS 'MONTH',
    YEAR(`OrderDate`) AS 'YEAR',
    COUNT(`multiOrder`) AS 'DDTs',
    MIN(`OrderID`) as 'id'
FROM
    `orders`
GROUP BY
    `idCompany`,
    `outTypeDoc`,
    `CustomerID`