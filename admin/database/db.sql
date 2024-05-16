drop database if exists mystudyoffers;
create database mystudyoffers;

use mystudyoffers;

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

insert into country(countryname) values
('United Kingdom'),
('Canada'),
('USA'),
('Australia'),
('Europe'),
('Other'),
('New Zealand'),
('Asia');

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

delimiter //

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

insert into adminuser(adminname , adminemail , adminpassword , admintype) values
('Rahil Khatri' , 'admin@mystudyoffers.com' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec' , "admin"),
('Admin 1' , 'admin1@mystudyoffers.com' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec' , "telecaller"),
('Admin 2' , 'admin2@mystudyoffers.com' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec' , "telecaller"),
('Admin 3' , 'admin3@mystudyoffers.com' , 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec' , "telecaller");

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

insert into levelofcourse(levelofcoursename) values
("Schooling"), 
("Undergraduate Certificate"), 
("Undergraduate Diploma"), 
("Undergraduate Degree"), 
("Postgraduate Certificate"), 
("Postgraduate Diploma"), 
("Postgraduate Degree"), 
("Doctorate"), 
("Professional Qualification"), 
("Licensing Qualification"), 
("Other");

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

drop table if exists testscore;
create table testscore
(
	testscoreid int not null primary key auto_increment,
    testscore varchar(50) not null,
    testscorestatus boolean not null default true
);

insert into testscore(testscore) values
('Preparing to Appear'),
('8.0 overall or above'),
('7.5 overall'),
('7.0 overall'),
('6.5 overall'),
('6.0 overall'),
('5.5 overall or below');

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

drop table if exists awardingbody;
create table awardingbody
(
	awardingbodyid int not null primary key auto_increment,
    awardingbodyname varchar(100) not null,
    awardingbodystatus boolean not null default true,
    academicid int,
    foreign key (academicid) references academic(academicid)
);

insert into awardingbody(awardingbodyname , academicid) values
('CBSE', 1),
('ICSE', 1),
('IB or Cambridge', 1),
('Open Board - Eg. NIOS', 1),
('Other', 1),
('Polytechnics, Technical Institutes', 2),
('State University', 2),
('Private University (Including deemed)', 2),
('National University', 2),
('Open University (Including distance learning)', 2),
('Public Institutes', 2),
('Professional Body', 2),
('Private Institute/Academy', 2),
('Online/Blended Programs with Overseas bodies', 2),
('Polytechnics, Technical Institutes', 3),
('State University', 3),
('Private University (Including deemed)', 3),
('National University', 3),
('Open University (Including distance learning)', 3),
('Public Institutes', 3),
('Professional Body', 3),
('Private Institute/Academy', 3),
('Online/Blended Programs with Overseas bodies', 3),
('Polytechnics, Technical Institutes', 4),
('State University', 4),
('Private University (Including deemed)', 4),
('National University', 4),
('Open University (Including distance learning)', 4),
('Public Institutes', 4),
('Professional Body', 4),
('Private Institute/Academy', 4),
('Online/Blended Programs with Overseas bodies', 4),
('State University', 5),
('Private University (Including deemed)', 5),
('National University', 5),
('Open University (Including distance learning)', 5),
('Public Institutes', 5),
('Online/Blended Programs with Overseas bodies', 5);

drop table if exists passingyear;
create table passingyear
(
	passingyearid int not null primary key auto_increment,
    passingyear varchar(50) not null,
    passingyearstatus boolean not null default true
);

insert into passingyear(passingyear) values
('2009 or before'),
('2020'),
('2021'),
('2022'),
('2023'),
('2024'),
('2025 or later');

drop table if exists result;
create table result
(
	resultid int not null primary key auto_increment,
    resultname varchar(50) not null,
    resultstatus boolean not null default true
);

insert into result(resultname) values
('49% or below'),
('50% to 59%'),
('60% to 69%'),
('70% to 79%'),
('80% to 89%'),
('90% to 94%'),
('95% to 100%');

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

insert into accreditation(accreditationname) values
("Govt"), 
("Regulatory"), 
("Licensing"), 
("Industry"), 
("International"), 
("Others Applicable");

drop table if exists otherfee;
create table otherfee
(
	otherfeeid int not null primary key auto_increment,
    otherfeename varchar(150) not null,
    otherfeestatus boolean not null default true
);

insert into otherfee(otherfeename) values
("Registration Fee"), 
("Technology Fee"), 
("Security Deposit"), 
("Library Fee"), 
("Lab Fee"), 
("Dresscode Fee"), 
("Awarding Fee"), 
("Transport Fee"), 
("If Residential Program - Accommodation And Food");

drop table if exists financialaid;
create table financialaid
(
	financialaidid int not null primary key auto_increment,
    financialaidname varchar(150) not null,
    financialaidstatus boolean not null default true
);

insert into financialaid(financialaidname) values
("Scholarship"), 
("Discounts"), 
("Bursary"), 
("Financial Aid"), 
("Student Loans"), 
("Discounts");


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
	studentid int not null unique key,
    telecallerid varchar(50) not null
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

drop table if exists rankawardingbody;
create table rankawardingbody
(
	rankawardingbodyid int not null primary key auto_increment,
    rankawardingbodyname varchar(100) not null,
    rankawardingbodystatus boolean not null default true
);

insert into rankawardingbody(rankawardingbodyname) values('Rank Awarding Body 1') , ('Rank Awarding Body 2');

delimiter //
drop trigger if exists assignstudent//
create trigger assignstudent after insert on student for each row
begin
	declare tlid varchar(50);
    declare counts int;
    
	select adminid , (select count(*) from studenttelecaller where telecallerid = adminid) as count into tlid , counts
    from adminuser where admintype = "telecaller" order by count, adminid limit 1;
    
    insert into studenttelecaller values(new.studentid , tlid);
end//
delimiter ;

insert into student(name , surname , phone , email , password , pincode , activationtoken , status)
values("Rahil" , "Khatri" , "123" , "php@penguinpeak.com" , "33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e" , "380015" , "" , true);

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

insert into studentworkexperience values(1 , 4);

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

insert into studentcountry values(1 , 2),(1 , 5),(1,8);

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

insert into querytype(querytypename) values
("General Question"),("Loan Inquiry"),("Admission Inquiry");

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
    foreign key (queryid) references studentquery (queryid)
);

delimiter //
drop trigger if exists initiateconversation//
create trigger initiateconverstation after insert on studentquery for each row
begin
	insert into queryconversation(queryid , studentid , message) values(new.queryid , new.studentid , new.querytopic);
end//
delimiter ;

insert into studentquery(studentid , querytopic , querytypeid) values
(1 , "How to learn react?" , 1),
(1 , "How to start doing programming?" , 2);

insert into queryconversation(queryid , studentid , adminid , message) values
(1 , NULL , "admin-1" , "Watch online tutorials"),
(1 , 1 , NULL , "Send the link"),
(1 , NULL , "admin-1" , "I will send tomorrow"),
(2 , NULL , "admin-1" , "Start practicing"),
(2 , 1 , NULL , "Send the book for it"),
(2 , NULL , "admin-1" , "I will share the link");

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
    universityimage varchar(150)
);

drop table if exists universitydatastatus;
create table universitydatastatus
(
	universityid varchar(50) not null,
    universityinformation boolean not null default false,
    universityrankings boolean not null default false,
    universitystatistics boolean not null default false,
    universitytuitionandfees boolean not null default false,
    foreign key (universityid) references university(universityid)
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
	applicationfee decimal(10 , 2) not null,
    tuitionfee decimal(10 , 2) not null,
    foreign key (universityid) references university(universityid) on delete cascade
);

drop table if exists universitylevelofcourse;
create table universitylevelofcourse
(
	universityid varchar(50) not null,
    levelofcourseid int,
    foreign key(universityid) references university(universityid) on delete cascade,
    foreign key(levelofcourseid) references levelofcourse(levelofcourseid) on delete set null
);

drop table if exists universityotherfees;
create table universityotherfees
(
	universityid varchar(50) not null,
    otherfeeid int,
    foreign key (universityid) references university(universityid) on delete cascade,
    foreign key (otherfeeid) references otherfee(otherfeeid) on delete set null
);

drop table if exists universityfinancialaid;
create table universityfinancialaid
(
	universityid varchar(50) not null,
    financialaidid int,
    foreign key (universityid) references university(universityid) on delete cascade,
    foreign key (financialaidid) references financialaid(financialaidid) on delete set null
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
