#
# Table structure for table 'tx_bssshop_domain_model_product'
#
CREATE TABLE tx_bssshop_domain_model_product (

	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	builds int(11) unsigned DEFAULT '0' NOT NULL,
	category int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_bssshop_domain_model_cart'
#
CREATE TABLE tx_bssshop_domain_model_cart (

	total double(11,2) DEFAULT '0.00' NOT NULL,
	cartitems int(11) unsigned DEFAULT '0' NOT NULL,
	client int(11) unsigned DEFAULT '0',
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_bssshop_domain_model_cartitem'
#
CREATE TABLE tx_bssshop_domain_model_cartitem (

	cart int(11) unsigned DEFAULT '0' NOT NULL,

	amount int(11) DEFAULT '0' NOT NULL,
	total double(11,2) DEFAULT '0.00' NOT NULL,
	product int(11) unsigned DEFAULT '0',
	build int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_bssshop_domain_model_orderitem'
#
CREATE TABLE tx_bssshop_domain_model_orderitem (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

	product_name varchar(255) DEFAULT '' NOT NULL,
	build_name varchar(255) DEFAULT '' NOT NULL,
	code varchar(255) DEFAULT '' NOT NULL,
	amount int(11) DEFAULT '0' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	total double(11,2) DEFAULT '0.00' NOT NULL,
	product int(11) unsigned DEFAULT '0',
	build int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_bssshop_domain_model_order'
#
CREATE TABLE tx_bssshop_domain_model_order (

	number varchar(255) DEFAULT '' NOT NULL,
	message text,
	total double(11,2) DEFAULT '0.00' NOT NULL,
	merchant_address text,
	client_address text,
	client int(11) unsigned DEFAULT '0',
	orderitems int(11) unsigned DEFAULT '0' NOT NULL,
	order_status int(11) unsigned DEFAULT '0' NOT NULL,
	status varchar(50) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_bssshop_domain_model_client'
#
CREATE TABLE tx_bssshop_domain_model_client (

	name varchar(255) DEFAULT '' NOT NULL,
	street text,
	email text,
	zip varchar(255) DEFAULT '' NOT NULL,
	city text,
	country varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_bssshop_domain_model_build'
#
CREATE TABLE tx_bssshop_domain_model_build (

	product int(11) unsigned DEFAULT '0' NOT NULL,
	main smallint(5) unsigned DEFAULT '0' NOT NULL,
	code varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	image int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_bssshop_domain_model_build'
#
CREATE TABLE tx_bssshop_domain_model_build (

	product int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_bssshop_domain_model_orderstatus'
#
CREATE TABLE tx_bssshop_domain_model_orderstatus (

	status varchar(55) DEFAULT '' NOT NULL,

);



#
# Table structure for table 'tx_bssshop_domain_model_cartitem'
#
CREATE TABLE tx_bssshop_domain_model_cartitem (

	cart int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_bssshop_domain_model_orderitem'
#
CREATE TABLE tx_bssshop_domain_model_orderitem (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

);

