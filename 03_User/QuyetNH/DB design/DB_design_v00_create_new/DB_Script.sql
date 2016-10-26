create database TheEruditeGuider

-- Museum table
Create Table Museum
(
	museum_id int IDENTITY(1,1) NOT NULL,
	name nvarchar(150) NOT NULL,
	house_no nvarchar(30) NOT NULL,
	street nvarchar(30) NOT NULL,
	city nvarchar(30) NOT NULL,
	phone_no nvarchar(20) NOT NULL,
	website nvarchar(50) NOT NULL,
	CONSTRAINT PK_Museum PRIMARY KEY (museum_id)
)

-- Account table
CREATE TABLE Account
(
	account_id int IDENTITY(1,1) NOT NULL,
	email nvarchar(50) NOT NULL,
	password nvarchar(16) NOT NULL,
	museum_id int,
	permission int NOT NULL,
	status tinyint NOT NULL,
	created_date Double precision NOT NULL,
	CONSTRAINT PK_Account PRIMARY KEY (account_id),
	CONSTRAINT FK_Account_museum FOREIGN KEY (museum_id) REFERENCES Museum(museum_id)
)

 -- Target table

 CREATE TABLE Target
 (
	target_id int IDENTITY(1,1) NOT NULL,
	name nvarchar(30) NOT NULL,
	image nvarchar,
	object_scan nvarchar,
	metadata nvarchar,
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
	image nvarchar,
	audio nvarchar,
	video nvarchar,
	model nvarchar,
	current_status tinyint NOT NULL,
	last_status tinyint,
	CONSTRAINT PK_Displayed_object PRIMARY KEY (dob_id),
	CONSTRAINT FK_D_objects_museum FOREIGN KEY (museum_id) REFERENCES Museum(museum_id),
	CONSTRAINT FK_D_objects_target FOREIGN KEY (target_id) REFERENCES Target(target_id)
 )


 -- Guest request table
CREATE TABLE Guest_request
(
	g_request_id int IDENTITY(1,1) NOT NULL,
	email nvarchar(150) NOT NULL,
	password nvarchar(16) NOT NULL,
	museum_name nvarchar(150) NOT NULL,
	house_no nvarchar(30) NOT NULL,
	street nvarchar(30) NOT NULL,
	city nvarchar(30) NOT NULL,
	phone_no nvarchar(20) NOT NULL,
	website nvarchar(50) NOT NULL,
	status tinyint NOT NULL,
	CONSTRAINT PK_Guest_request PRIMARY KEY (g_request_id)
)

 -- Guest member table
CREATE TABLE Member_request
(
	m_request_id int IDENTITY(1,1) NOT NULL,
	account_id int NOT NULL,
	type tinyint NOT NULL,
	dob_id int NOT NULL,
	reason nvarchar,
	status tinyint NOT NULL,
	sent_time Double precision NOT NULL,
	CONSTRAINT PK_Member_request PRIMARY KEY (m_request_id),
	CONSTRAINT FK_Member_request_account FOREIGN KEY (account_id) REFERENCES Account(account_id),
	CONSTRAINT FK_Member_request_target FOREIGN KEY (dob_id) REFERENCES Displayed_object(dob_id)
)
 
-- Insert:
INSERT INTO Museum (name, house_no, street, city, phone_no, website)
VALUES (N'Bảo tàng 10 năm FE FPT', N'Thạch Hòa', N'Thạch Thất', N'Hà Nội','0473001866','daihoc.fpt.edu.vn');

select * from Museum

INSERT INTO Account (email, password, permission, status, created_date)
VALUES ('admin@gmail.com', '12345abcde', 0, 1, 1993);

INSERT INTO Account (email, password, museum_id, permission, status, created_date)
VALUES ('baotangfpt@gmail.com', '131313', 1, 1, 1, 1909);

select * from Account