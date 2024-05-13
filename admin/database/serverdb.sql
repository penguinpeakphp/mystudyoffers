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

drop table if exists adminuser;
create table adminuser
(
	adminid int not null primary key auto_increment,
    adminname varchar(150) not null,
    adminemail varchar(250) not null unique,
    adminpassword varchar(500) not null,
    adminstatus boolean not null default true,
    admintype varchar(30) not null
);

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
    foreign key (stateid) references state(stateid),
    foreign key (countryid) references country(countryid)
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
    foreign key (academicid) references academic(academicid) 
);

drop table if exists awardingbody;
create table awardingbody
(
	awardingbodyid int not null primary key auto_increment,
    awardingbodyname varchar(100) not null,
    awardingbodystatus boolean not null default true,
    academicid int,
    foreign key (academicid) references academic(academicid)
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
    registeredon date
);

delimiter //
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
	studentid int not null,
    telecallerid int not null
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
    foreign key (studentid) references student(studentid)
);

delimiter //
drop trigger if exists assignstudent//
create trigger assignstudent after insert on student for each row
begin
	declare tlid int;
    declare counts int;
    
	select adminid , (select count(*) from studenttelecaller where telecallerid = adminid) as count into tlid , counts
    from adminuser where admintype = "telecaller" order by count, adminid limit 1;
    
    insert into studenttelecaller values(new.studentid , tlid);
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
    foreign key(studentid) references student(studentid),
    foreign key(qualificationid) references qualification(qualificationid),
    primary key(studentid , qualificationid)
);

-- insert into studentqualification values(1 , 3),(1 , 7);

drop table if exists studentqualificationsub;
create table studentqualificationsub
(
	studentid int not null,
    qualificationsubid int not null,
    foreign key(studentid) references student(studentid),
    foreign key(qualificationsubid) references qualificationsub(qualificationsubid),
    primary key(studentid , qualificationsubid)
);

-- insert into studentqualificationsub values(1 , 15),(1 , 3),(1 , 6);

drop table if exists studentworkexperience;
create table studentworkexperience
(
	studentid int not null,
    workexperienceid int not null,
	foreign key(studentid) references student(studentid),
    foreign key(workexperienceid) references workexperience(workexperienceid),
    primary key (studentid , workexperienceid)
);

drop table if exists testtypetestscore;
create table testtypetestscore
(
	studentid int not null,
    testid int not null,
    testscoreid int not null,
    primary key(studentid , testid , testscoreid)
);

-- insert into testtypetestscore values
-- (1 , 1 , 1),
-- (1 , 2 , 1),
-- (1 , 3 , 1),
-- (1 , 4 , 1),
-- (1 , 5 , 1),
-- (1 , 6 , 1),
-- (1 , 7 , 1),
-- (1 , 8 , 1);

drop table if exists studentcountry;
create table studentcountry
(
	studentid int not null,
	countryid int not null,
    foreign key(studentid) references student(studentid),
    foreign key(countryid) references country(countryid),
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
    adminid int,
    message text,
    filename varchar(200),
    messagetime datetime default current_timestamp(),
    readbystudent boolean not null default false,
    readbyadmin boolean not null default false,
    foreign key (queryid) references studentquery (queryid)
);

delimiter //
drop trigger if exists initiateconversation//
create trigger initiateconverstation after insert on studentquery for each row
begin
	insert into queryconversation(queryid , studentid , message) values(new.queryid , new.studentid , new.querytopic);
end//
delimiter ;

-- drop table university;
-- create table university
-- (
-- 	universityid int not null primary key auto_increment,
-- 	universityname varchar(1000) not null,
--     universitylicensenumber varchar(50) default "",
--     keycontactname varchar(100) not null,
--     keycontactdesignation varchar(200) not null,
--     keycontactemail varchar(250) not null,
--     yearestablishment varchar(10) not null,
--     overview text,
--     maincampuscountryid int not null,
--     maincampuscityid int not null,
--     maincampusstreetaddress varchar(500) not null,
--     maincampuspostcode varchar(20) not null,
--     universityimage varchar(150) not null,
--     foreign key(maincampuscountryid) references country(countryid),
--     foreign key(maincampuscityid) references city(cityid)
-- );

-- drop table if exists othercampusaddress;
-- create table othercampusaddress
-- (
-- 	universityid int not null,
--     othercampuscityid int not null,
--     othercampusstreetaddress varchar(500) not null,
--     othercampusstreetaddress varchar(500) not null,
--     othercampuspostcode varchar(20) not null,
--     foreign key(universityid) references university(universityid),
--     foreign key(othercampuscityid) references university(universityid)
-- );

-- drop table if exists universitylevelofcourse;
-- create table universitylevelofcourse
-- (
-- 	universityid int not null,
--     levelofcourseid int not null,
--     foreign key(universityid) references university(universityid),
--     foreign key(levelofcourseid) references levelofcourse(levelofcourseid)
-- );

INSERT INTO `adminuser` (`adminid` , `adminemail`,  `adminname` , `adminpassword`, `admintype`) VALUES
(1, 'admin@mystudyoffers.com', 'Admin' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', "admin"),
(2, 'cs1@mystudyoffers.com', 'Counsellor 1' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', "telecaller"),
(3, 'cs2@mystudyoffers.com', 'Counsellor 2' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', "telecaller"),
(4, 'cs3@mystudyoffers.com', 'Counsellor 3' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', "telecaller");

INSERT INTO `academic` (`academicid`, `academicname`, `academicstatus`) VALUES
(1, 'Higher Schooling', 1),
(2, 'Diploma', 1),
(3, 'Bachelor Degree', 1),
(4, 'Masters Degree', 1),
(5, 'PHd', 1);

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

INSERT INTO `businessnature` (`businessid`, `businessname`, `businessstatus`) VALUES
(1, 'Govt Funded', 1),
(2, 'Not for Profit', 1),
(3, 'Govt and Not For Profit', 1),
(4, 'Privately Funded', 1),
(5, 'Govt and Privately Funded', 1),
(6, 'Govt and Not For Profit and Private', 1);

INSERT INTO `country` (`countryid`, `countryname`, `status`) VALUES
(1, 'United Kingdom', 1),
(2, 'Canada', 1),
(3, 'USA', 1),
(4, 'Australia', 1),
(5, 'Europe', 1),
(6, 'Other', 1),
(7, 'New Zealand', 1),
(8, 'Asia', 1);

INSERT INTO `state` (`stateid`, `statename`, `statestatus`, `countryid`) VALUES
(1, 'New York', 1, 1),
(2, 'London', 1, 5),
(3, 'Ontario', 1, 7);

INSERT INTO `city` (`cityid`, `cityname`, `citystatus`, `stateid`, `countryid`) VALUES
(1, 'London', 1, 1, 6),
(2, 'New York', 1, 2, 3);

INSERT INTO `institutetype` (`instituteid`, `institutename`, `institutestatus`) VALUES
(1, 'School', 1),
(2, 'University', 1),
(3, 'College/Polytechnic', 1),
(4, 'Professional Education Institute', 1),
(5, 'Private Tuition Provider', 1);

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

INSERT INTO `passingyear` (`passingyearid`, `passingyear`, `passingyearstatus`) VALUES
(1, '2019 or before', 1),
(2, '2020', 1),
(3, '2021', 1),
(4, '2022', 1),
(5, '2023', 1),
(6, '2024', 1),
(7, '2025 or later', 1);

INSERT INTO `planningyear` (`planningyearid`, `planningyear`, `planningyearstatus`) VALUES
(1, '2023', 1),
(2, '2024', 1),
(3, '2025', 1);


INSERT INTO `qualification` (`qualificationid`, `qualificationname`, `qualificationstatus`) VALUES
(1, 'Foundation year, Diploma, Adv Dip.', 1),
(2, 'Bachelor Degree', 1),
(3, 'PG Cert/Diploma', 1),
(4, 'Masters Degree - Course Work', 1),
(5, 'Masters Degree - Research Work', 1),
(6, 'PHd', 1),
(7, 'Professional Certification', 1);

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


INSERT INTO `querytype` (`querytypeid`, `querytypename`, `querytypestatus`) VALUES
(1, 'General Question', 1),
(2, 'Loan Inquiry', 1),
(3, 'Admission Inquiry', 1);

INSERT INTO `result` (`resultid`, `resultname`, `resultstatus`) VALUES
(1, '49% or below', 1),
(2, '50% to 59%', 1),
(3, '60% to 69%', 1),
(4, '70% to 79%', 1),
(5, '80% to 89%', 1),
(6, '90% to 94%', 1),
(7, '95% to 100%', 1);

INSERT INTO `subjectinterest` (`subjectinterestid`, `subjectinterestname`, `subjectintereststatus`) VALUES
(1, 'Engineering', 1),
(2, 'Medical', 1);

INSERT INTO `testscore` (`testscoreid`, `testscore`, `testscorestatus`) VALUES
(1, 'Preparing to Appear', 1),
(2, '8.0 overall or above', 1),
(3, '7.5 overall', 1),
(4, '7.0 overall', 1),
(5, '6.5 overall', 1),
(6, '6.0 overall', 1),
(7, '5.5 overall or below', 1);

INSERT INTO `testtype` (`testid`, `testname`, `teststatus`) VALUES
(1, 'IELTS', 1),
(2, 'PTE', 1),
(3, 'GRE', 1),
(4, 'TOEFL', 1),
(5, 'GMAT', 1),
(6, 'DuoLingo', 1),
(7, 'LanguageCert', 1),
(8, 'SAT', 1);

INSERT INTO `workexperience` (`workexperienceid`, `workexperiencename`, `workexperiencestatus`) VALUES
(1, 'No Work Experience', 1),
(2, '1 to 3 Years Relevant to Studies', 1),
(3, '4 Years or above Relevant to Studies', 1),
(4, '1 to 3 Years Not Relevant to Studies', 1),
(5, '4 Years or above Not Relevant to Studies', 1);

