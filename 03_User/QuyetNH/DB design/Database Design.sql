Create Database TheEruditeGuider

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
	email nvarchar(50) NOT NULL,
	CONSTRAINT PK_Museum PRIMARY KEY (museum_id)
)

-- Account table
CREATE TABLE Account
(
	account_id int IDENTITY(1,1) NOT NULL,
	username nvarchar(50) NOT NULL,
	password nvarchar(16) NOT NULL,
	museum_id int NOT NULL,
	permission bit NOT NULL,
	status [bit] NOT NULL,
	created_date [datetime] NOT NULL,
	CONSTRAINT PK_Account PRIMARY KEY (account_id),
	CONSTRAINT FK_Account_museum FOREIGN KEY (museum_id) REFERENCES Museum(museum_id)
)
ALTER TABLE Account ALTER COLUMN museum_id int null;

 -- Target table
 CREATE TABLE Target
 (
	target_id int IDENTITY(1,1) NOT NULL,
	name nvarchar(30) NOT NULL,
	image nvarchar(150) NOT NULL,
	object_scan nvarchar(150) NOT NULL,
	metadata nvarchar(150) NOT NULL,
	CONSTRAINT PK_Target PRIMARY KEY (target_id)
)

-- Displayed Object table
CREATE TABLE Displayed_object
(
	dob_id int IDENTITY(1,1) NOT NULL,
	name nvarchar(150) NOT NULL,
	museum_id int NOT NULL,
	target_id int NOT NULL,
	text_description nvarchar(500) NOT NULL,
	image nvarchar(150) NOT NULL,
	audio nvarchar(150) NOT NULL,
	video nvarchar(150) NOT NULL,
	model nvarchar(150) NOT NULL,
	status int NOT NULL,
	CONSTRAINT PK_Displayed_object PRIMARY KEY (dob_id),
	CONSTRAINT FK_D_objects_museum FOREIGN KEY (museum_id) REFERENCES Museum(museum_id),
	CONSTRAINT FK_D_objects_target FOREIGN KEY (target_id) REFERENCES Target(target_id)
 )

 -- Commentary table
 CREATE TABLE Commentary
 (
	comm_id int IDENTITY(1,1) NOT NULL,
	dob_id int NOT NULL,
	account_id int NOT NULL,
	message nvarchar(500) NOT NULL,
	sent_time datetime NOT NULL,
	CONSTRAINT PK_Commentary PRIMARY KEY (comm_id), 
	CONSTRAINT FK_Commentary_D_objects FOREIGN KEY (dob_id) REFERENCES Displayed_object(dob_id),
	CONSTRAINT FK_Commentary_account FOREIGN KEY (account_id) REFERENCES Account(account_id)
)

-- Insert:
INSERT INTO Museum (name, house_no, street, city, phone_no, website, email)
VALUES (N'Bảo tàng 10 năm FE FPT', N'Thạch Hòa', N'Thạch Thất', N'Hà Nội','0473001866','daihoc.fpt.edu.vn', 'baotangfpt@gmail.com');

select * from Museum

INSERT INTO Account (username, password, permission, status, created_date)
VALUES ('admin', '12345abcde', 0, 1, CONVERT(VARCHAR, GETDATE(), 100));

INSERT INTO Account (museum_id, username, password, permission, status, created_date)
VALUES (1, 'FPT.FEmuseum', '131313', 1, 1, convert(datetime,'12-10-16 10:34:09 PM',5));

select * from Account