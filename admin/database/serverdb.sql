drop database if exists mystudyoffers;
create database mystudyoffers;

use mystudyoffers;

drop table if exists id_generator;
create table id_generator (
    prefix varchar(20) primary key,
    next_id int
);

insert into id_generator (prefix, next_id) values ('university', 1);
insert into id_generator (prefix, next_id) values ('admin', 1);

drop table if exists country;
create table country
(
	countryid int not null primary key auto_increment,
    countryname varchar(100) not null,
    status boolean not null default true
);

drop table if exists adminuser;
create table adminuser
(
	adminid varchar(50) not null primary key,
    adminname varchar(150) not null,
    adminemail varchar(250) not null unique,
    adminpassword varchar(500) not null,
    adminstatus boolean not null default true,
    admintype varchar(30) not null
);

drop table if exists adminforgotpassword;
create table adminforgotpassword
(
	adminemail VARCHAR(200) not null unique,
    token varchar(15) not null,
    foreign key (adminemail) references adminuser(adminemail) on delete cascade
);

delimiter //
drop trigger if exists adminuser_before_insert//
CREATE TRIGGER adminuser_before_insert
BEFORE INSERT ON adminuser
FOR EACH ROW
BEGIN
    DECLARE nextid INT;
    SELECT next_id INTO nextid FROM id_generator WHERE prefix = 'admin';
    SET NEW.adminid = CONCAT('admin-', nextid);
    UPDATE id_generator SET next_id = next_id + 1 WHERE prefix = 'admin';
END//

delimiter ;

drop table if exists state;
create table state
(
	stateid int not null primary key auto_increment,
    statename varchar(100) not null,
    statestatus boolean not null default true,
    countryid int not null,
    foreign key (countryid) references country(countryid) on delete cascade
);

drop table if exists city;
create table city
(
	cityid int not null primary key auto_increment,
    cityname varchar(100) not null,
    citystatus boolean not null default true,
    stateid int not null,
    countryid int not null,
    foreign key (stateid) references state(stateid) on delete cascade,
    foreign key (countryid) references country(countryid) on delete cascade
);

drop table if exists subjectinterest;
create table subjectinterest
(
	subjectinterestid int not null primary key auto_increment,
    subjectinterestname varchar(100) not null,
    subjectintereststatus boolean not null default true
);

drop table if exists levelofcourse;
create table levelofcourse
(
	levelofcourseid int not null primary key auto_increment,
    levelofcoursename varchar(100) not null,
    levelofcoursestatus boolean not null default true
);

drop table if exists planningyear;
create table planningyear
(
	planningyearid int not null primary key auto_increment,
    planningyear varchar(5) not null,
    planningyearstatus boolean not null default true
);

drop table if exists testtype;
create table testtype
(
	testid int not null primary key auto_increment,
    testname varchar(100) not null,
    teststatus boolean not null default true
);

drop table if exists testscore;
create table testscore
(
	testscoreid int not null primary key auto_increment,
    testscore varchar(50) not null,
    testscorestatus boolean not null default true
);

drop table if exists institutetype;
create table institutetype
(
	instituteid int not null primary key auto_increment,
    institutename varchar(200) not null,
    institutestatus boolean not null default true
);

drop table if exists businessnature;
create table businessnature
(
	businessid int not null primary key auto_increment,
    businessname varchar(200) not null,
    businessstatus boolean not null default true
);

drop table if exists qualification;
create table qualification
(
	qualificationid int not null primary key auto_increment,
    qualificationname varchar(100) not null,
    qualificationstatus boolean not null default true
);

drop table if exists qualificationsub;
create table qualificationsub
(
	qualificationsubid int not null primary key auto_increment,
    qualificationsubname varchar(100) not null,
    qualificationsubstatus boolean not null default true
);

drop table if exists workexperience;
create table workexperience
(
	workexperienceid int not null primary key auto_increment,
    workexperiencename varchar(100) not null,
    workexperiencestatus boolean not null default true
);

drop table if exists academic;
create table academic
(
	academicid int not null primary key auto_increment,
    academicname varchar(100) not null,
    academicstatus boolean not null default true
);

drop table if exists majorsubject;
create table majorsubject
(
	majorsubjectid int not null primary key auto_increment,
    majorsubjectname varchar(200) not null,
    majorsubjectstatus boolean not null default true,
    academicid int not null,
    foreign key (academicid) references academic(academicid) on delete cascade
);

drop table if exists awardingbody;
create table awardingbody
(
	awardingbodyid int not null primary key auto_increment,
    awardingbodyname varchar(100) not null,
    awardingbodystatus boolean not null default true,
    academicid int,
    foreign key (academicid) references academic(academicid) on delete cascade
);

drop table if exists passingyear;
create table passingyear
(
	passingyearid int not null primary key auto_increment,
    passingyear varchar(50) not null,
    passingyearstatus boolean not null default true
);

drop table if exists result;
create table result
(
	resultid int not null primary key auto_increment,
    resultname varchar(50) not null,
    resultstatus boolean not null default true
);

drop table if exists querytype;
create table querytype
(
	querytypeid int not null primary key auto_increment,
    querytypename varchar(100) not null,
    querytypestatus boolean not null default true
);

drop table if exists accreditation;
create table accreditation
(
	accreditationid int primary key auto_increment,
    accreditationname varchar(50) not null,
    accreditationstatus boolean not null default true
);

drop table if exists otherfee;
create table otherfee
(
	otherfeeid int not null primary key auto_increment,
    otherfeename varchar(150) not null,
    otherfeestatus boolean not null default true
);

drop table if exists financialaid;
create table financialaid
(
	financialaidid int not null primary key auto_increment,
    financialaidname varchar(150) not null,
    financialaidstatus boolean not null default true
);


drop table if exists student;
create table student
(
	studentid int not null primary key auto_increment,
	name varchar(100) not null,
    surname varchar(100) not null,
    phone varchar(20) not null unique,
    email varchar(200) not null unique,
    password varchar(500) not null,
    pincode varchar(8) not null,
    activationtoken varchar(15) not null,
    profilestatus varchar(50) not null default "academic",
    status boolean not null default false,
    registeredon date,
    studentOTP int,
    phoneverified boolean not null default false
);

drop table if exists studentforgotpassword;
create table studentforgotpassword
(
	email VARCHAR(200) not null unique,
    token varchar(15) not null,
    foreign key (email) references student(email) on delete cascade
);

drop table if exists studentprofiletrack;
create table studentprofiletrack
(
	studentid int not null,
    academic boolean not null default false,
    qualification boolean not null default false,
    testscore boolean not null default false,
    countryinterest boolean not null default false,
    foreign key (studentid) references student(studentid) on delete cascade
);

delimiter //
drop trigger if exists setdefaultstudentdate//
CREATE TRIGGER setdefaultstudentdate BEFORE INSERT ON student
FOR EACH ROW
BEGIN
    IF NEW.registeredon IS NULL THEN
        SET NEW.registeredon = CURRENT_DATE;
    END IF;
END;
//
delimiter ;

drop table if exists studenttelecaller;
create table studenttelecaller
(
	studentid int not null unique key,
    telecallerid varchar(50) not null,
    foreign key (studentid) references student(studentid) on delete cascade,
    foreign key (telecallerid) references adminuser(adminid) on delete cascade
);

drop table if exists studentacademics;
create table studentacademics
(
	studentid int not null,
    academicid int,
    majorsubjectid int,
    passingyearid int,
    awardingbodyid int,
    resultid int,
    foreign key (studentid) references student(studentid) on delete cascade,
    foreign key (academicid) references academic(academicid) on delete set null,
    foreign key (majorsubjectid) references majorsubject(majorsubjectid) on delete set null,
    foreign key (passingyearid) references passingyear(passingyearid) on delete set null,
    foreign key (awardingbodyid) references awardingbody(awardingbodyid) on delete set null,
    foreign key (resultid) references result(resultid) on delete set null,
    unique key(studentid , academicid)
);

drop table if exists studentfollowup;
create table studentfollowup
(
	followupid int not null primary key auto_increment,
    studentid int not null,
    followuptemplateid int,
    followuptemplatebody text,
    remarks text not null,
    noteaddedon datetime not null default current_timestamp(),
    nextfollowupdate date not null,
    foreign key (studentid) references student(studentid) on delete cascade
);

drop table if exists rankawardingbody;
create table rankawardingbody
(
	rankawardingbodyid int not null primary key auto_increment,
    rankawardingbodyname varchar(100) not null,
    rankawardingbodystatus boolean not null default true
);

delimiter //
drop trigger if exists assignstudent//
create trigger assignstudent after insert on student for each row
begin
	declare tlid varchar(50);
    declare counts int;
    
	select adminid , (select count(*) from studenttelecaller where telecallerid = adminid) as count into tlid , counts
    from adminuser where admintype = "telecaller" order by count, adminid limit 1;
    
    insert into studenttelecaller values(new.studentid , tlid);
    
    insert into studentprofiletrack(studentid) values(new.studentid);
end//
delimiter ;

drop table if exists followuptemplate;
create table followuptemplate
(
	followuptemplateid int not null primary key auto_increment,
    followuptemplatename varchar(200) not null,
    followuptemplatebody text not null,
    followuptemplatestatus boolean not null default true
);

drop table if exists studentqualification;
create table studentqualification
(
	studentid int not null,
    qualificationid int not null,
    foreign key(studentid) references student(studentid) on delete cascade,
    foreign key(qualificationid) references qualification(qualificationid) on delete cascade,
    primary key(studentid , qualificationid)
);

drop table if exists studentqualificationsub;
create table studentqualificationsub
(
	studentid int not null,
    qualificationsubid int not null,
    foreign key(studentid) references student(studentid) on delete cascade,
    foreign key(qualificationsubid) references qualificationsub(qualificationsubid) on delete cascade,
    primary key(studentid , qualificationsubid)
);

drop table if exists studentworkexperience;
create table studentworkexperience
(
	studentid int not null,
    workexperienceid int not null,
	foreign key(studentid) references student(studentid) on delete cascade,
    foreign key(workexperienceid) references workexperience(workexperienceid) on delete cascade,
    primary key (studentid , workexperienceid)
);

drop table if exists testtypetestscore;
create table testtypetestscore
(
	studentid int not null,
    testid int not null,
    testscoreid int not null,
    foreign key (studentid) references student(studentid) on delete cascade,
    primary key(studentid , testid , testscoreid)
);

drop table if exists studentcountry;
create table studentcountry
(
	studentid int not null,
	countryid int,
    foreign key(studentid) references student(studentid) on delete cascade,
    foreign key(countryid) references country(countryid) on delete cascade,
    primary key(studentid , countryid)
);

drop table if exists studentquery;
create table studentquery
(
	queryid int not null primary key auto_increment,
    studentid int not null,
    querytypeid int,
    querytopic text not null,
    createdate date,
    foreign key (studentid) references student(studentid) on delete cascade,
    foreign key (querytypeid) references querytype(querytypeid) on delete set null
);

delimiter //
drop trigger if exists setdefaultstudentquerydate//
CREATE TRIGGER setdefaultstudentquerydate BEFORE INSERT ON studentquery
FOR EACH ROW
BEGIN
    IF NEW.createdate IS NULL THEN
        SET NEW.createdate = CURRENT_DATE;
    END IF;
END;
//
delimiter ;


drop table if exists queryconversation;
create table queryconversation
(
	conversationid int not null primary key auto_increment,
    queryid int not null,
    studentid int,
    adminid varchar(50),
    message text,
    filename varchar(200),
    messagetime datetime default current_timestamp(),
    readbystudent boolean not null default false,
    readbyadmin boolean not null default false,
    foreign key (queryid) references studentquery (queryid) on delete cascade
);

delimiter //
drop trigger if exists initiateconversation//
create trigger initiateconverstation after insert on studentquery for each row
begin
	insert into queryconversation(queryid , studentid , message) values(new.queryid , new.studentid , new.querytopic);
end//
delimiter ;

drop table if exists university;
create table university
(
	universityid varchar(50) not null primary key,
	universityname varchar(1000),
    universitylicensenumber varchar(50) default "",
    keycontactname varchar(100),
    keycontactdesignation varchar(200),
    keycontactemail varchar(250),
    yearestablishment varchar(10),
    overview text,
    maincampuscityid int,
    maincampusstreetaddress varchar(500),
    maincampuspostcode varchar(20),
    universityimage varchar(150),
    universitystatus boolean not null default true
);

drop table if exists universityrankings;
create table universityrankings
(
	universityid varchar(50),
    rankingname varchar(150),
    rankawardingbodyid int,
    yearofranking varchar(10),
    description text,
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists universityaccreditations;
create table universityaccreditations
(
	universityid varchar(50),
    accreditationid int,
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists universitydatastatus;
create table universitydatastatus
(
	universityid varchar(50) not null,
    universityinformation boolean not null default false,
    universityrankings boolean not null default false,
    universitystatistics boolean not null default false,
    universitytuitionandfees boolean not null default false,
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists othercampusaddress;
create table othercampusaddress
(
	universityid varchar(50) not null,
    othercampuscityid int,
    othercampusstreetaddress varchar(500),
    othercampuspostcode varchar(20),
    foreign key(universityid) references university(universityid) on delete cascade,
    foreign key(othercampuscityid) references city(cityid) on delete set null
);

drop table if exists universityfees;
create table universityfees
(
	universityid varchar(50) not null unique key,
	applicationfee varchar(25) not null,
    tuitionfee varchar(25) not null,
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists universitylevelofcourse;
create table universitylevelofcourse
(
	universityid varchar(50) not null,
    levelofcourseid int not null,
    foreign key(universityid) references university(universityid) on delete cascade,
    foreign key(levelofcourseid) references levelofcourse(levelofcourseid) on delete cascade
);

drop table if exists universityotherfees;
create table universityotherfees
(
	universityid varchar(50) not null,
    otherfeeid int not null,
    foreign key (universityid) references university(universityid) on delete cascade,
    foreign key (otherfeeid) references otherfee(otherfeeid) on delete cascade
);

drop table if exists universityfinancialaid;
create table universityfinancialaid
(
	universityid varchar(50) not null,
    financialaidid int not null,
    foreign key (universityid) references university(universityid) on delete cascade,
    foreign key (financialaidid) references financialaid(financialaidid) on delete cascade
);

drop table if exists universitystatistics;
create table universitystatistics
(
	universityid varchar(50) not null unique key,
	totalstudents int,
    totalinternationalstudents int,
    acceptancerate decimal(10 , 2),
    graduateemploymentrate decimal(10 , 2),
    foreign key(universityid) references university(universityid) on delete cascade
);

drop table if exists universityassets;
create table universityassets
(
	universityid varchar(50) not null unique key,
	logoimage varchar(500),
    mascotimage varchar(500),
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists universityclubsandteams;
create table universityclubsandteams
(
	universityid varchar(50) not null,
    clubsandteams varchar(150) not null,
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists universityfacilityimages;
create table universityfacilityimages
(
	universityid varchar(50) not null,
    image varchar(150) not null,
    foreign key (universityid) references university(universityid) on delete cascade
);

delimiter //
drop trigger if exists university_before_insert//
CREATE TRIGGER university_before_insert
BEFORE INSERT ON university
FOR EACH ROW
BEGIN
    DECLARE nextid INT;
    SELECT next_id INTO nextid FROM id_generator WHERE prefix = 'university';
    SET NEW.universityid = CONCAT('university-', nextid);
    UPDATE id_generator SET next_id = next_id + 1 WHERE prefix = 'university';
END//

delimiter ;


INSERT INTO `academic` (`academicid`, `academicname`, `academicstatus`) VALUES
(1, 'Higher Schooling', 1),
(2, 'Diploma', 1),
(3, 'Bachelor Degree', 1),
(4, 'Masters Degree', 1),
(5, 'PHd', 1);

--
-- Dumping data for table `adminuser`
--

INSERT INTO `adminuser` (`adminid`, `adminname`, `adminemail`, `adminpassword`, `adminstatus`, `admintype`) VALUES
('admin-1', 'Admin', 'admin@mystudyoffers.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 1, 'admin'),
('admin-2', 'Counsellor 1', 'cs1@mystudyoffers.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 1, 'telecaller'),
('admin-3', 'Counsellor 2', 'cs2@mystudyoffers.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 1, 'telecaller'),
('admin-4', 'Counsellor 3', 'cs3@mystudyoffers.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 1, 'telecaller');

--
-- Dumping data for table `awardingbody`
--

INSERT INTO `awardingbody` (`awardingbodyid`, `awardingbodyname`, `awardingbodystatus`, `academicid`) VALUES
(1, 'CBSE', 1, 1),
(2, 'ICSE', 1, 1),
(3, 'IB or Cambridge', 1, 1),
(4, 'Open Board - Eg. NIOS', 1, 1),
(5, 'State Board/Other', 1, 1),
(6, 'Polytechnics', 1, 2),
(7, 'State University', 1, 2),
(8, 'Private University', 1, 2),
(9, 'National University', 1, 2),
(10, 'Open University', 1, 2),
(11, 'Public Institutes', 1, 2),
(12, 'Professional Body', 1, 2),
(13, 'Private Institute', 1, 2),
(14, 'Online/Blended Programs', 0, 2),
(15, 'Polytechnics', 1, 3),
(16, 'State University', 1, 3),
(17, 'Private University', 1, 3),
(18, 'National University', 1, 3),
(19, 'Open University', 1, 3),
(20, 'Public Institutes', 1, 3),
(21, 'Professional Body', 1, 3),
(22, 'Private Institute', 1, 3),
(23, 'Online/Blended Programs', 0, 3),
(24, 'Polytechnics, Technical Institutes', 1, 4),
(25, 'State University', 1, 4),
(26, 'Private University', 1, 4),
(27, 'National University', 1, 4),
(28, 'Open University', 1, 4),
(29, 'Public Institutes', 1, 4),
(30, 'Professional Body', 1, 4),
(31, 'Private Institute', 1, 4),
(32, 'Online/Blended Programs', 0, 4),
(33, 'State University', 1, 5),
(34, 'Private University', 1, 5),
(35, 'National University', 1, 5),
(36, 'Open University', 1, 5),
(37, 'Public Institutes', 1, 5),
(38, 'Online/Blended Programs', 0, 5);

--
-- Dumping data for table `businessnature`
--

INSERT INTO `businessnature` (`businessid`, `businessname`, `businessstatus`) VALUES
(1, 'Govt Funded', 1),
(2, 'Not for Profit', 1),
(3, 'Govt and Not For Profit', 1),
(4, 'Privately Funded', 1),
(5, 'Govt and Privately Funded', 1),
(6, 'Govt and Not For Profit and Private', 1);

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`countryid`, `countryname`, `status`) VALUES
(1, 'United Kingdom', 1),
(2, 'Canada', 1),
(3, 'USA', 1),
(4, 'Australia', 1),
(5, 'Europe', 1),
(6, 'Other', 1),
(7, 'New Zealand', 1),
(8, 'Asia', 1);

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`stateid`, `statename`, `statestatus`, `countryid`) VALUES
(1, 'New York', 1, 1),
(2, 'London', 1, 5),
(3, 'Ontario', 1, 7);

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`cityid`, `cityname`, `citystatus`, `stateid`, `countryid`) VALUES
(1, 'London', 1, 1, 6),
(2, 'New York', 1, 2, 3);

--
-- Dumping data for table `followuptemplate`
--

INSERT INTO `followuptemplate` (`followuptemplateid`, `followuptemplatename`, `followuptemplatebody`, `followuptemplatestatus`) VALUES
(1, 'Template One', 'Thank your for your interested in MySto.', 1),
(2, 'Template Two', 'Discuss about Course interest and Country Interest.', 1);

--
-- Dumping data for table `institutetype`
--

INSERT INTO `institutetype` (`instituteid`, `institutename`, `institutestatus`) VALUES
(1, 'School', 1),
(2, 'University', 1),
(3, 'College/Polytechnic', 1),
(4, 'Professional Education Institute', 1),
(5, 'Private Tuition Provider', 1);

--
-- Dumping data for table `levelofcourse`
--

INSERT INTO `levelofcourse` (`levelofcourseid`, `levelofcoursename`, `levelofcoursestatus`) VALUES
(1, 'School Certificates', 1),
(2, 'Post Schooling Certificates', 1),
(3, 'Vocational ', 1),
(4, 'Diploma', 1),
(5, 'UG Degrees', 1),
(6, 'Post Graduate Diploma', 1),
(7, 'Post Graduate Degree/Masters', 1),
(8, 'Doctrate', 1),
(9, 'Post Doctorate', 1);

--
-- Dumping data for table `majorsubject`
--

INSERT INTO `majorsubject` (`majorsubjectid`, `majorsubjectname`, `majorsubjectstatus`, `academicid`) VALUES
(1, 'PCM', 1, 1),
(2, 'PCB', 1, 1),
(3, 'PCBM', 1, 1),
(4, 'Commerce/Business', 1, 1),
(5, 'Humanities or Arts', 1, 1),
(6, 'Vocational', 1, 1),
(7, 'Sciences', 1, 2),
(8, 'Engineering & CS', 1, 2),
(9, 'Business & Commerce', 1, 2),
(10, 'Art & Design', 1, 2),
(11, 'Humanities & Law', 1, 2),
(12, 'Medical, Health, Nursing', 1, 2),
(13, 'Medical, Health, Nursing', 1, 3),
(14, 'Engineering & CS', 1, 3),
(15, 'Business & Commerce', 1, 3),
(16, 'Art & Design', 1, 3),
(17, 'Humanities & Law', 1, 3),
(18, 'Medical and Health', 1, 3),
(19, 'Sciences', 1, 4),
(20, 'Engineering & CS', 1, 4),
(21, 'Business & Commerce', 1, 4),
(22, 'Art & Design', 1, 4),
(23, 'Humanities & Law', 1, 4),
(24, 'Medical and Health', 1, 4),
(25, 'Sciences', 1, 5),
(26, 'Engineering & CS', 1, 5),
(27, 'Business & Commerce', 1, 5),
(28, 'Art & Design', 1, 5),
(29, 'Humanities & Law', 1, 5),
(30, 'Medical and Health', 1, 5);

--
-- Dumping data for table `passingyear`
--

INSERT INTO `passingyear` (`passingyearid`, `passingyear`, `passingyearstatus`) VALUES
(1, '2019 or before', 1),
(2, '2020', 1),
(3, '2021', 1),
(4, '2022', 1),
(5, '2023', 1),
(6, '2024', 1),
(7, '2025 or later', 1);

--
-- Dumping data for table `planningyear`
--

INSERT INTO `planningyear` (`planningyearid`, `planningyear`, `planningyearstatus`) VALUES
(1, '2023', 1),
(2, '2024', 1),
(3, '2025', 1);

--
-- Dumping data for table `qualification`
--

INSERT INTO `qualification` (`qualificationid`, `qualificationname`, `qualificationstatus`) VALUES
(1, 'Foundation year, Diploma, Adv Dip.', 1),
(2, 'Bachelor Degree', 1),
(3, 'PG Cert/Diploma', 1),
(4, 'Masters Degree - Course Work', 1),
(5, 'Masters Degree - Research Work', 1),
(6, 'PHd', 1),
(7, 'Professional Certification', 1);

--
-- Dumping data for table `qualificationsub`
--

INSERT INTO `qualificationsub` (`qualificationsubid`, `qualificationsubname`, `qualificationsubstatus`) VALUES
(1, 'Business, HR, Marketing, Supply Chain', 1),
(2, 'Accounting, Finance, Statestics', 1),
(3, 'Hotel, Hospitality, Event Mgt.', 1),
(4, 'Computer, Data, Engineering & Sciences', 1),
(5, 'Computer, Data, Engineering & Sciences', 1),
(6, 'Mechanical Engineering', 1),
(7, 'Civil and Architecture', 1),
(8, 'Electronics & Electrical', 1),
(9, 'Nursing', 1),
(10, 'Medicine', 1),
(11, 'Paramedical', 1),
(12, 'Heath Sciences', 1),
(13, 'Pharmacy', 1),
(14, 'Pure Sciences - Chemistry, Biology, Physics, Math', 1),
(15, 'Fashion Design', 1),
(16, 'Creative Arts', 1),
(17, 'Music, Drama, Theater', 1),
(18, 'Liberal Arts, Literature', 1),
(19, 'Law, International studies', 1),
(20, 'Jorunalism, Mass communication', 1),
(21, 'Psycology', 1);

--
-- Dumping data for table `querytype`
--

INSERT INTO `querytype` (`querytypeid`, `querytypename`, `querytypestatus`) VALUES
(1, 'General Question', 1),
(2, 'Loan Inquiry', 1),
(3, 'Admission Inquiry', 1);

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`resultid`, `resultname`, `resultstatus`) VALUES
(1, '49% or below', 1),
(2, '50% to 59%', 1),
(3, '60% to 69%', 1),
(4, '70% to 79%', 1),
(5, '80% to 89%', 1),
(6, '90% to 94%', 1),
(7, '95% to 100%', 1);

--
-- Dumping data for table `subjectinterest`
--

INSERT INTO `subjectinterest` (`subjectinterestid`, `subjectinterestname`, `subjectintereststatus`) VALUES
(1, 'Engineering', 1),
(2, 'Medical', 1);

--
-- Dumping data for table `testscore`
--

INSERT INTO `testscore` (`testscoreid`, `testscore`, `testscorestatus`) VALUES
(1, 'Preparing to Appear', 1),
(2, '8.0 overall or above', 1),
(3, '7.5 overall', 1),
(4, '7.0 overall', 1),
(5, '6.5 overall', 1),
(6, '6.0 overall', 1),
(7, '5.5 overall or below', 1);

--
-- Dumping data for table `testtype`
--

INSERT INTO `testtype` (`testid`, `testname`, `teststatus`) VALUES
(1, 'IELTS', 1),
(2, 'PTE', 1),
(3, 'GRE', 1),
(4, 'TOEFL', 1),
(5, 'GMAT', 1),
(6, 'DuoLingo', 1),
(7, 'LanguageCert', 1),
(8, 'SAT', 1);

--
-- Dumping data for table `workexperience`
--

INSERT INTO `workexperience` (`workexperienceid`, `workexperiencename`, `workexperiencestatus`) VALUES
(1, 'No Work Experience', 1),
(2, '1 to 3 Years Relevant to Studies', 1),
(3, '4 Years or above Relevant to Studies', 1),
(4, '1 to 3 Years Not Relevant to Studies', 1),
(5, '4 Years or above Not Relevant to Studies', 1);

INSERT INTO `student` (`studentid`, `name`, `surname`, `phone`, `email`, `password`, `pincode`, `activationtoken`, `profilestatus`, `status`, `registeredon`) VALUES
(18, 'Rahil', 'Khatri', '121355', 'rahilkhatri4@gmail.com', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '1111', '66473c1eed7c8', 'academic', 1, '2024-05-17'),
(19, 'Sapan', 'Sidhwani', '6353713153', 'sapansidhwani40@gmail.com', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', '1234', '66473c3f13386', 'academic', 1, '2024-05-17'),
(20, 'Rahil', 'Khatri', '6666', 'php@penguinpeak.com', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '1111', '66473dea2e5f5', 'academic', 1, '2024-05-17'),
(21, 't', 'p', '0000000000', 'tarang@getwayimmigration.com', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', '380009', '6647439a76b31', 'academic', 1, '2024-05-17'),
(22, 'Nilesh', 'Soni', '09925181484', 'nileshsoni@gmail.com', '62670d1e1eea06b6c975e12bc8a16131b278f6d7bcbe017b65f854c58476baba86c2082b259fd0c1310935b365dc40f609971b6810b065e528b0b60119e69f61', '380015', '664861d4b5080', 'academic', 1, '2024-05-18');