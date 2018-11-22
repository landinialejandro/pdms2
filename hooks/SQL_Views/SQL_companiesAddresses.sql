/**
 * Author:  Alejandro Landini <landinialejandro@gmail.com>
 * Created: 20 sep. 2018
 */
CREATE OR REPLACE VIEW SQL_companiesAddresses AS 
SELECT
    companies.id,
    addresses.id AS addressId,
    addresses.kind,
    addresses.address,
    addresses.houseNumber,
    addresses.country,
    addresses.town,
    addresses.postalCode,
    addresses.district,
    addresses.default,
    addresses.ship
FROM
    companies
LEFT OUTER JOIN addresses ON addresses.company = companies.id
WHERE
    addresses.id IS NOT NULL