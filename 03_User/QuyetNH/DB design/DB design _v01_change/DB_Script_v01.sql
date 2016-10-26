create database TheEruditeGuider

-- Museum table
Create Table Museum
(
	museum_id int IDENTITY(1,1) NOT NULL,
	name nvarchar(150) NOT NULL,
	house_no nvarchar(30) NOT NULL,
	street nvarchar(30) NOT NULL,
	city nvarchar(30) NOT NULL,
	phone_no varchar(20) NOT NULL,
	website varchar(50) NOT NULL,
	CONSTRAINT PK_Museum PRIMARY KEY (museum_id)
)

-- Account table
CREATE TABLE Account
(
	account_id int IDENTITY(1,1) NOT NULL,
	email varchar(50) NOT NULL,
	password varchar(16) NOT NULL,
	museum_id int,
	permission int NOT NULL,
	status tinyint NOT NULL,
	created_date Datetime NOT NULL,
	CONSTRAINT PK_Account PRIMARY KEY (account_id),
	CONSTRAINT FK_Account_museum FOREIGN KEY (museum_id) REFERENCES Museum(museum_id)
)

 -- Target table
 CREATE TABLE Target
 (
	target_id int IDENTITY(1,1) NOT NULL,
	name varchar(30) NOT NULL,
	image varchar,
	object_scan varchar,
	metadata varchar,
	CONSTRAINT PK_Target PRIMARY KEY (target_id)
)

-- Displayed Object table
CREATE TABLE Displayed_object
(
	dob_id int IDENTITY(1,1) NOT NULL,
	museum_id int NOT NULL,
	target_id int NOT NULL,
	name nvarchar(150) NOT NULL,
	text_description nvarchar,
	image varchar,
	audio varchar,
	video varchar,
	model varchar,
	current_status tinyint NOT NULL,
	previous_status tinyint,
	CONSTRAINT PK_Displayed_object PRIMARY KEY (dob_id),
	CONSTRAINT FK_D_objects_museum FOREIGN KEY (museum_id) REFERENCES Museum(museum_id),
	CONSTRAINT FK_D_objects_target FOREIGN KEY (target_id) REFERENCES Target(target_id)
 )

  -- Guest request table
CREATE TABLE Guest_request
(
	g_request_id int IDENTITY(1,1) NOT NULL,
	email varchar(150) NOT NULL,
	password varchar(16) NOT NULL,
	museum_name nvarchar(150) NOT NULL,
	house_no nvarchar(30) NOT NULL,
	street nvarchar(30) NOT NULL,
	city nvarchar(30) NOT NULL,
	phone_no varchar(20) NOT NULL,
	website varchar(50) NOT NULL,
	status tinyint NOT NULL,
	CONSTRAINT PK_Guest_request PRIMARY KEY (g_request_id)
)

 -- Member reques table
CREATE TABLE Member_request
(
	m_request_id int IDENTITY(1,1) NOT NULL,
	account_id int NOT NULL,
	type tinyint NOT NULL,
	dob_id int NOT NULL,
	reason nvarchar,
	status tinyint NOT NULL,
	sent_time Datetime NOT NULL,
	CONSTRAINT PK_Member_request PRIMARY KEY (m_request_id),
	CONSTRAINT FK_Member_request_account FOREIGN KEY (account_id) REFERENCES Account(account_id),
	CONSTRAINT FK_Member_request_target FOREIGN KEY (dob_id) REFERENCES Displayed_object(dob_id)
)
