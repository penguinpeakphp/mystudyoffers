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

insert into country(countryname) values
('United Kingdom'),
('Canada'),
('USA'),
('Australia'),
('Europe'),
('Other'),
('New Zealand'),
('Asia');

drop table if exists state;
create table state
(
	stateid int not null primary key auto_increment,
    statename varchar(100) not null,
    statestatus boolean not null default true,
    countryid int not null,
    foreign key (countryid) references country(countryid) on delete cascade
);

INSERT INTO state (stateid, countryid, statename) VALUES
(6, 1, 'New York'),
(7, 2, 'London'),
(8, 3, 'Ontario');