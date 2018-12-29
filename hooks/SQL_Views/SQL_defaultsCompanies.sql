/**
 * Author:  Alejandro Landini <landinialejandro@gmail.com>
 * Created: 20 sep. 2018
 */
CREATE OR REPLACE VIEW SQL_defaultsCompanies AS 
SELECT
    companies.id,
    companies.kind,
    companies.companyCode,
    companies.companyName,
    attributes.attribute,
    attributes.value
    
FROM
    companies
LEFT OUTER JOIN attributes ON attributes.company = companies.id
WHERE
    companies.kind = 'MC' AND attributes.attribute LIKE 'DEF_%' AND attributes.value = '1'