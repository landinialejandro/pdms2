var FiltersEnabled = 0; // if your not going to use transitions or filters in any of the tips set this to 0
var spacer="&nbsp; &nbsp; &nbsp; ";

// email notifications to admin
notifyAdminNewMembers0Tip=["", spacer+"No email notifications to admin."];
notifyAdminNewMembers1Tip=["", spacer+"Notify admin only when a new member is waiting for approval."];
notifyAdminNewMembers2Tip=["", spacer+"Notify admin for all new sign-ups."];

// visitorSignup
visitorSignup0Tip=["", spacer+"If this option is selected, visitors will not be able to join this group unless the admin manually moves them to this group from the admin area."];
visitorSignup1Tip=["", spacer+"If this option is selected, visitors can join this group but will not be able to sign in unless the admin approves them from the admin area."];
visitorSignup2Tip=["", spacer+"If this option is selected, visitors can join this group and will be able to sign in instantly with no need for admin approval."];

// orders table
orders_addTip=["",spacer+"This option allows all members of the group to add records to the 'Ordini' table. A member who adds a record to the table becomes the 'owner' of that record."];

orders_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Ordini' table."];
orders_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Ordini' table."];
orders_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Ordini' table."];
orders_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Ordini' table."];

orders_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Ordini' table."];
orders_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Ordini' table."];
orders_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Ordini' table."];
orders_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Ordini' table, regardless of their owner."];

orders_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Ordini' table."];
orders_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Ordini' table."];
orders_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Ordini' table."];
orders_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Ordini' table."];

// ordersDetails table
ordersDetails_addTip=["",spacer+"This option allows all members of the group to add records to the 'Dettaglio Ordini vendita' table. A member who adds a record to the table becomes the 'owner' of that record."];

ordersDetails_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Dettaglio Ordini vendita' table."];
ordersDetails_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Dettaglio Ordini vendita' table."];
ordersDetails_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Dettaglio Ordini vendita' table."];
ordersDetails_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Dettaglio Ordini vendita' table."];

ordersDetails_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Dettaglio Ordini vendita' table."];
ordersDetails_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Dettaglio Ordini vendita' table."];
ordersDetails_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Dettaglio Ordini vendita' table."];
ordersDetails_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Dettaglio Ordini vendita' table, regardless of their owner."];

ordersDetails_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Dettaglio Ordini vendita' table."];
ordersDetails_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Dettaglio Ordini vendita' table."];
ordersDetails_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Dettaglio Ordini vendita' table."];
ordersDetails_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Dettaglio Ordini vendita' table."];

// _ordersSummary table
_ordersSummary_addTip=["",spacer+"This option allows all members of the group to add records to the 'order summary' table. A member who adds a record to the table becomes the 'owner' of that record."];

_ordersSummary_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'order summary' table."];
_ordersSummary_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'order summary' table."];
_ordersSummary_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'order summary' table."];
_ordersSummary_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'order summary' table."];

_ordersSummary_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'order summary' table."];
_ordersSummary_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'order summary' table."];
_ordersSummary_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'order summary' table."];
_ordersSummary_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'order summary' table, regardless of their owner."];

_ordersSummary_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'order summary' table."];
_ordersSummary_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'order summary' table."];
_ordersSummary_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'order summary' table."];
_ordersSummary_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'order summary' table."];

// products table
products_addTip=["",spacer+"This option allows all members of the group to add records to the 'Articoli Magazzino' table. A member who adds a record to the table becomes the 'owner' of that record."];

products_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Articoli Magazzino' table."];
products_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Articoli Magazzino' table."];
products_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Articoli Magazzino' table."];
products_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Articoli Magazzino' table."];

products_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Articoli Magazzino' table."];
products_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Articoli Magazzino' table."];
products_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Articoli Magazzino' table."];
products_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Articoli Magazzino' table, regardless of their owner."];

products_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Articoli Magazzino' table."];
products_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Articoli Magazzino' table."];
products_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Articoli Magazzino' table."];
products_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Articoli Magazzino' table."];

// firstCashNote table
firstCashNote_addTip=["",spacer+"This option allows all members of the group to add records to the 'Prima Nota' table. A member who adds a record to the table becomes the 'owner' of that record."];

firstCashNote_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Prima Nota' table."];
firstCashNote_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Prima Nota' table."];
firstCashNote_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Prima Nota' table."];
firstCashNote_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Prima Nota' table."];

firstCashNote_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Prima Nota' table."];
firstCashNote_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Prima Nota' table."];
firstCashNote_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Prima Nota' table."];
firstCashNote_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Prima Nota' table, regardless of their owner."];

firstCashNote_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Prima Nota' table."];
firstCashNote_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Prima Nota' table."];
firstCashNote_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Prima Nota' table."];
firstCashNote_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Prima Nota' table."];

// companies table
companies_addTip=["",spacer+"This option allows all members of the group to add records to the 'Aziende' table. A member who adds a record to the table becomes the 'owner' of that record."];

companies_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Aziende' table."];
companies_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Aziende' table."];
companies_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Aziende' table."];
companies_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Aziende' table."];

companies_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Aziende' table."];
companies_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Aziende' table."];
companies_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Aziende' table."];
companies_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Aziende' table, regardless of their owner."];

companies_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Aziende' table."];
companies_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Aziende' table."];
companies_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Aziende' table."];
companies_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Aziende' table."];

// vatRegister table
vatRegister_addTip=["",spacer+"This option allows all members of the group to add records to the 'Registro Corrispettivi' table. A member who adds a record to the table becomes the 'owner' of that record."];

vatRegister_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Registro Corrispettivi' table."];
vatRegister_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Registro Corrispettivi' table."];
vatRegister_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Registro Corrispettivi' table."];
vatRegister_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Registro Corrispettivi' table."];

vatRegister_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Registro Corrispettivi' table."];
vatRegister_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Registro Corrispettivi' table."];
vatRegister_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Registro Corrispettivi' table."];
vatRegister_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Registro Corrispettivi' table, regardless of their owner."];

vatRegister_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Registro Corrispettivi' table."];
vatRegister_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Registro Corrispettivi' table."];
vatRegister_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Registro Corrispettivi' table."];
vatRegister_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Registro Corrispettivi' table."];

// contacts table
contacts_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contacts' table. A member who adds a record to the table becomes the 'owner' of that record."];

contacts_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contacts' table."];
contacts_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contacts' table."];
contacts_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contacts' table."];
contacts_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contacts' table."];

contacts_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contacts' table."];
contacts_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contacts' table."];
contacts_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contacts' table."];
contacts_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contacts' table, regardless of their owner."];

contacts_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contacts' table."];
contacts_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contacts' table."];
contacts_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contacts' table."];
contacts_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contacts' table."];

// creditDocument table
creditDocument_addTip=["",spacer+"This option allows all members of the group to add records to the 'Nota Credito' table. A member who adds a record to the table becomes the 'owner' of that record."];

creditDocument_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Nota Credito' table."];
creditDocument_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Nota Credito' table."];
creditDocument_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Nota Credito' table."];
creditDocument_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Nota Credito' table."];

creditDocument_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Nota Credito' table."];
creditDocument_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Nota Credito' table."];
creditDocument_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Nota Credito' table."];
creditDocument_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Nota Credito' table, regardless of their owner."];

creditDocument_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Nota Credito' table."];
creditDocument_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Nota Credito' table."];
creditDocument_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Nota Credito' table."];
creditDocument_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Nota Credito' table."];

// electronicInvoice table
electronicInvoice_addTip=["",spacer+"This option allows all members of the group to add records to the 'ElectronicInvoice' table. A member who adds a record to the table becomes the 'owner' of that record."];

electronicInvoice_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'ElectronicInvoice' table."];
electronicInvoice_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'ElectronicInvoice' table."];
electronicInvoice_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'ElectronicInvoice' table."];
electronicInvoice_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'ElectronicInvoice' table."];

electronicInvoice_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'ElectronicInvoice' table."];
electronicInvoice_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'ElectronicInvoice' table."];
electronicInvoice_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'ElectronicInvoice' table."];
electronicInvoice_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'ElectronicInvoice' table, regardless of their owner."];

electronicInvoice_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'ElectronicInvoice' table."];
electronicInvoice_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'ElectronicInvoice' table."];
electronicInvoice_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'ElectronicInvoice' table."];
electronicInvoice_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'ElectronicInvoice' table."];

// countries table
countries_addTip=["",spacer+"This option allows all members of the group to add records to the 'Countries' table. A member who adds a record to the table becomes the 'owner' of that record."];

countries_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Countries' table."];
countries_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Countries' table."];
countries_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Countries' table."];
countries_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Countries' table."];

countries_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Countries' table."];
countries_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Countries' table."];
countries_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Countries' table."];
countries_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Countries' table, regardless of their owner."];

countries_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Countries' table."];
countries_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Countries' table."];
countries_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Countries' table."];
countries_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Countries' table."];

// town table
town_addTip=["",spacer+"This option allows all members of the group to add records to the 'Comuni italiani' table. A member who adds a record to the table becomes the 'owner' of that record."];

town_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Comuni italiani' table."];
town_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Comuni italiani' table."];
town_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Comuni italiani' table."];
town_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Comuni italiani' table."];

town_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Comuni italiani' table."];
town_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Comuni italiani' table."];
town_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Comuni italiani' table."];
town_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Comuni italiani' table, regardless of their owner."];

town_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Comuni italiani' table."];
town_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Comuni italiani' table."];
town_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Comuni italiani' table."];
town_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Comuni italiani' table."];

// GPSTrackingSystem table
GPSTrackingSystem_addTip=["",spacer+"This option allows all members of the group to add records to the 'GPS Tracking System' table. A member who adds a record to the table becomes the 'owner' of that record."];

GPSTrackingSystem_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'GPS Tracking System' table."];
GPSTrackingSystem_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'GPS Tracking System' table."];
GPSTrackingSystem_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'GPS Tracking System' table."];
GPSTrackingSystem_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'GPS Tracking System' table."];

GPSTrackingSystem_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'GPS Tracking System' table."];
GPSTrackingSystem_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'GPS Tracking System' table."];
GPSTrackingSystem_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'GPS Tracking System' table."];
GPSTrackingSystem_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'GPS Tracking System' table, regardless of their owner."];

GPSTrackingSystem_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'GPS Tracking System' table."];
GPSTrackingSystem_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'GPS Tracking System' table."];
GPSTrackingSystem_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'GPS Tracking System' table."];
GPSTrackingSystem_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'GPS Tracking System' table."];

// kinds table
kinds_addTip=["",spacer+"This option allows all members of the group to add records to the 'Entities Kinds' table. A member who adds a record to the table becomes the 'owner' of that record."];

kinds_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Entities Kinds' table."];
kinds_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Entities Kinds' table."];
kinds_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Entities Kinds' table."];
kinds_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Entities Kinds' table."];

kinds_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Entities Kinds' table."];
kinds_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Entities Kinds' table."];
kinds_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Entities Kinds' table."];
kinds_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Entities Kinds' table, regardless of their owner."];

kinds_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Entities Kinds' table."];
kinds_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Entities Kinds' table."];
kinds_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Entities Kinds' table."];
kinds_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Entities Kinds' table."];

// Logs table
Logs_addTip=["",spacer+"This option allows all members of the group to add records to the 'Logs' table. A member who adds a record to the table becomes the 'owner' of that record."];

Logs_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Logs' table."];
Logs_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Logs' table."];
Logs_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Logs' table."];
Logs_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Logs' table."];

Logs_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Logs' table."];
Logs_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Logs' table."];
Logs_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Logs' table."];
Logs_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Logs' table, regardless of their owner."];

Logs_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Logs' table."];
Logs_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Logs' table."];
Logs_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Logs' table."];
Logs_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Logs' table."];

// attributes table
attributes_addTip=["",spacer+"This option allows all members of the group to add records to the 'Attributes' table. A member who adds a record to the table becomes the 'owner' of that record."];

attributes_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Attributes' table."];
attributes_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Attributes' table."];
attributes_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Attributes' table."];
attributes_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Attributes' table."];

attributes_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Attributes' table."];
attributes_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Attributes' table."];
attributes_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Attributes' table."];
attributes_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Attributes' table, regardless of their owner."];

attributes_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Attributes' table."];
attributes_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Attributes' table."];
attributes_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Attributes' table."];
attributes_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Attributes' table."];

// addresses table
addresses_addTip=["",spacer+"This option allows all members of the group to add records to the 'Addresses' table. A member who adds a record to the table becomes the 'owner' of that record."];

addresses_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Addresses' table."];
addresses_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Addresses' table."];
addresses_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Addresses' table."];
addresses_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Addresses' table."];

addresses_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Addresses' table."];
addresses_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Addresses' table."];
addresses_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Addresses' table."];
addresses_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Addresses' table, regardless of their owner."];

addresses_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Addresses' table."];
addresses_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Addresses' table."];
addresses_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Addresses' table."];
addresses_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Addresses' table."];

// phones table
phones_addTip=["",spacer+"This option allows all members of the group to add records to the 'Phones' table. A member who adds a record to the table becomes the 'owner' of that record."];

phones_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Phones' table."];
phones_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Phones' table."];
phones_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Phones' table."];
phones_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Phones' table."];

phones_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Phones' table."];
phones_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Phones' table."];
phones_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Phones' table."];
phones_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Phones' table, regardless of their owner."];

phones_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Phones' table."];
phones_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Phones' table."];
phones_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Phones' table."];
phones_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Phones' table."];

// mails table
mails_addTip=["",spacer+"This option allows all members of the group to add records to the 'Mails' table. A member who adds a record to the table becomes the 'owner' of that record."];

mails_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Mails' table."];
mails_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Mails' table."];
mails_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Mails' table."];
mails_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Mails' table."];

mails_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Mails' table."];
mails_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Mails' table."];
mails_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Mails' table."];
mails_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Mails' table, regardless of their owner."];

mails_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Mails' table."];
mails_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Mails' table."];
mails_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Mails' table."];
mails_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Mails' table."];

// contacts_companies table
contacts_companies_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contacts companies' table. A member who adds a record to the table becomes the 'owner' of that record."];

contacts_companies_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contacts companies' table."];
contacts_companies_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contacts companies' table."];
contacts_companies_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contacts companies' table."];
contacts_companies_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contacts companies' table."];

contacts_companies_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contacts companies' table."];
contacts_companies_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contacts companies' table."];
contacts_companies_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contacts companies' table."];
contacts_companies_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contacts companies' table, regardless of their owner."];

contacts_companies_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contacts companies' table."];
contacts_companies_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contacts companies' table."];
contacts_companies_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contacts companies' table."];
contacts_companies_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contacts companies' table."];

// attachments table
attachments_addTip=["",spacer+"This option allows all members of the group to add records to the 'Attaches' table. A member who adds a record to the table becomes the 'owner' of that record."];

attachments_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Attaches' table."];
attachments_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Attaches' table."];
attachments_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Attaches' table."];
attachments_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Attaches' table."];

attachments_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Attaches' table."];
attachments_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Attaches' table."];
attachments_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Attaches' table."];
attachments_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Attaches' table, regardless of their owner."];

attachments_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Attaches' table."];
attachments_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Attaches' table."];
attachments_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Attaches' table."];
attachments_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Attaches' table."];

/*
	Style syntax:
	-------------
	[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,
	TextTextAlign,TitleFontFace,TextFontFace, TipPosition, StickyStyle, TitleFontSize,
	TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY,
	TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]

*/

toolTipStyle=["white","#00008B","#000099","#E6E6FA","","images/helpBg.gif","","","","\"Trebuchet MS\", sans-serif","","","","3",400,"",1,2,10,10,51,1,0,"",""];

applyCssFilter();
