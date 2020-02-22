
CREATE OR REPLACE VIEW SQL_ordersSummary AS 
SELECT
    `kind`,
    `company`,
    `typeDoc`,
    `customer`,
    SUM(`orderTotal`) AS 'TOT',
    MONTH(`date`) AS 'MONTH',
    YEAR(`date`) AS 'YEAR',
    COUNT(`multiOrder`) AS 'DOCs',
    `related`,
    MIN(`id`) AS 'id'
FROM
    `orders`
WHERE `typeDoc` = 'DDT'
    AND `kind` = 'OUT'
    AND `related` IS NULL
    AND `document` IS NOT NULL
    AND `orderTotal` > 0
GROUP BY
    `kind`,
    `company`,
    `typeDoc`,
    `customer`,
    `related`