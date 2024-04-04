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

INSERT INTO state (countryid, statename) VALUES
(1, 'New York'),
(5, 'London'),
(7, 'Ontario');

drop table if exists city;
create table city
(
	cityid int not null primary key auto_increment,
    cityname varchar(100) not null,
    citystatus boolean not null default true,
    stateid int not null,
    countryid int not null,
    foreign key (stateid) references state(stateid),
    foreign key (countryid) references country(countryid)
);

INSERT INTO city (stateid, countryid, cityname) VALUES
(1, 6, 'London'),
(2, 3, 'New York');

drop table if exists subjectinterest;
create table subjectinterest
(
	subjectinterestid int not null primary key auto_increment,
    subjectinterestname varchar(100) not null,
    subjectintereststatus boolean not null default true
);

INSERT INTO subjectinterest (subjectinterestname) VALUES
('Engineering'),
('Medical');

drop table if exists levelofcourse;
create table levelofcourse
(
	levelofcourseid int not null primary key auto_increment,
    levelofcoursename varchar(100) not null,
    levelofcoursestatus boolean not null default true
);

INSERT INTO levelofcourse (levelofcoursename) VALUES
('School Certificates'),
('Post Schooling Certificates'),
('Vocational '),
('Diploma'),
('UG Degrees'),
('Post Graduate Diploma'),
('Post Graduate Degree/Masters'),
('Doctrate'),
('Post Doctorate');

drop table if exists planningyear;
create table planningyear
(
	planningyearid int not null primary key auto_increment,
    planningyear varchar(5) not null,
    planningyearstatus boolean not null default true
);

INSERT INTO planningyear (planningyear) VALUES
('2023'),
('2024'),
('2025');

drop table if exists testtype;
create table testtype
(
	testid int not null primary key auto_increment,
    testname varchar(100) not null,
    teststatus boolean not null default true
);

INSERT INTO testtype (testname) VALUES
('IELTS'),
('PTE'),
('GRE'),
('TOEFL'),
('GMAT'),
('DuoLingo'),
('LanguageCert'),
('SAT');