drop database if exists mystudyoffers;
create database mystudyoffers;

use mystudyoffers;

drop table if exists country;
create table country
(
	countryid int not null primary key auto_increment,
    countryname varchar(100) not null,
    status boolean not null default true
);