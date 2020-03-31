DROP SCHEMA IF EXISTS bubble_tea_data;
CREATE SCHEMA bubble_tea_data;

-- DROP TABLE IF EXISTS customer;
CREATE TABLE customer
(	userid varchar(300) NOT NULL PRIMARY KEY,
	password varchar(300) NOT NULL,
    name varchar(300) NOT NULL,
    edollar varchar(300) NOT NULL
);

-- DROP TABLE IF EXISTS outlet;
CREATE TABLE outletid
(	outletid varchar(300) NOT NULL PRIMARY KEY,
	password varchar(300) NOT NULL,
    name varchar(300) NOT NULL
);


