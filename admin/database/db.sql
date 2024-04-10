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

drop table if exists institutetype;
create table institutetype
(
	instituteid int not null primary key auto_increment,
    institutename varchar(200) not null,
    institutestatus boolean not null default true
);

INSERT INTO institutetype (institutename) VALUES
('School'),
('University'),
('College/Polytechnic'),
('Professional Education Institute'),
('Private Tuition Provider');

drop table if exists businessnature;
create table businessnature
(
	businessid int not null primary key auto_increment,
    businessname varchar(200) not null,
    businessstatus boolean not null default true
);

INSERT INTO businessnature (businessname) VALUES
('Govt Funded'),
('Not for Profit'),
('Govt and Not For Profit'),
('Privately Funded'),
('Govt and Privately Funded'),
('Govt and Not For Profit and Private');

drop table if exists qualification;
create table qualification
(
	qualificationid int not null primary key auto_increment,
    qualificationname varchar(100) not null,
    qualificationstatus boolean not null default true
);

INSERT INTO qualification (qualificationname) VALUES
('Foundation year, Diploma, Adv Dip.'),
('Bachelor Degree'),
('PG Cert/Diploma'),
('Masters Degree - Course Work'),
('Masters Degree - Research Work'),
('PHd'),
('Professional Certification');

drop table if exists qualificationsub;
create table qualificationsub
(
	qualificationsubid int not null primary key auto_increment,
    qualificationsubname varchar(100) not null,
    qualificationsubstatus boolean not null default true
);

INSERT INTO qualificationsub (qualificationsubname) VALUES
('Business, HR, Marketing, Supply Chain'),
('Accounting, Finance, Statestics'),
('Hotel, Hospitality, Event Mgt.'),
('Computer, Data, Engineering & Sciences'),
('Computer, Data, Engineering & Sciences'),
('Mechanical Engineering'),
('Civil and Architecture'),
('Electronics & Electrical'),
('Nursing'),
('Medicine'),
('Paramedical'),
('Heath Sciences'),
('Pharmacy'),
('Pure Sciences - Chemistry, Biology, Physics, Math'),
('Fashion Design'),
('Creative Arts'),
('Music, Drama, Theater'),
('Liberal Arts, Literature'),
('Law, International studies'),
('Jorunalism, Mass communication'),
('Psycology');

drop table if exists workexperience;
create table workexperience
(
	workexperienceid int not null primary key auto_increment,
    workexperiencename varchar(100) not null,
    workexperiencestatus boolean not null default true
);

INSERT INTO workexperience (workexperiencename) VALUES
('No Work Experience'),
('1 to 3 Years Relevant to Studies'),
('4 Years or above Relevant to Studies'),
('1 to 3 Years Not Relevant to Studies'),
('4 Years or above Not Relevant to Studies');

drop table if exists academic;
create table academic
(
	academicid int not null primary key auto_increment,
    academicname varchar(100) not null,
    academicstatus boolean not null default true
);

INSERT INTO academic (academicname) VALUES
('Higher Schooling'),
('Diploma'),
('Bachelor Degree'),
('Masters Degree'),
('PHd');

drop table if exists majorsubject;
create table majorsubject
(
	majorsubjectid int not null primary key auto_increment,
    majorsubjectname varchar(200) not null,
    majorsubjectstatus boolean not null default true,
    academicid int not null,
    foreign key (academicid) references academic(academicid) 
);

insert into majorsubject(majorsubjectname , academicid) values
('PCM', 1),
('PCB', 1),
('PCBM', 1),
('Commerce/Business', 1),
('Humanities or Arts', 1),
('Vocational', 1),
('Sciences', 2),
('Engineering & CS', 2),
('Business & Commerce', 2),
('Art & Design', 2),
('Humanities & Law', 2),
('Medical, Health, Nursing', 2),
('Medical, Health, Nursing', 3),
('Engineering & CS', 3),
('Business & Commerce', 3),
('Art & Design', 3),
('Humanities & Law', 3),
('Medical and Health', 3),
('Sciences', 4),
('Engineering & CS', 4),
('Business & Commerce', 4),
('Art & Design', 4),
('Humanities & Law', 4),
('Medical and Health', 4),
('Sciences', 5),
('Engineering & CS', 5),
('Business & Commerce', 5),
('Art & Design', 5),
('Humanities & Law', 5),
('Medical and Health', 5);

drop table if exists student;
create table student
(
	studentid int not null primary key auto_increment,
	name varchar(100) not null,
    surname varchar(100) not null,
    phone varchar(20) not null unique,
    email varchar(200) not null unique,
    password varchar(500) not null,
    pincode varchar(8) not null
);