/**
 * Author:  ale
 * Created: 23/10/2018
 * restric only to custumer use: where companies.kind = 'CUST' and attributes.id is not null
 */
CREATE OR REPLACE VIEW SQL_customersLimits AS 
select 
    companies.id as 'cust_id', 
    `attr_kind`.`code` as 'attr_code',
    `attr_kind`.`name` as 'attr_name',
    attributes.`value` as 'val_limit',
    attributes.id as 'attr_id'
from companies 
    left outer join attributes on attributes.company = companies.id
    left outer join kinds as `attr_kind` on `attr_kind`.`code` = attributes.attribute
where attributes.id is not null