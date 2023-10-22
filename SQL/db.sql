CREATE TABLE EMPLOYEE (
  id INT IDENTITY(1,1) PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  birthday DATE NOT NULL,
  access_level INT NOT NULL,
  authKey VARCHAR(255) NOT NULL,
  accessToken VARCHAR(255) NOT NULL
);

INSERT INTO EMPLOYEE (username, password, name, lastname, birthday, access_level, authKey, accessToken) VALUES ('johndoe', 'hashedpassword1', 'John', 'Doe', '1990-05-15', 1, 'authKey1', 'accessToken1');
INSERT INTO EMPLOYEE (username, password, name, lastname, birthday, access_level, authKey, accessToken) VALUES ('janesmith', 'hashedpassword2', 'Jane', 'Smith', '1985-12-10', 2, 'authKey2', 'accessToken2');
INSERT INTO EMPLOYEE (username, password, name, lastname, birthday, access_level, authKey, accessToken) VALUES ('alicejohnson', 'hashedpassword3', 'Alice', 'Johnson', '1995-07-22', 3, 'authKey3', 'accessToken3');

CREATE TABLE CONSTRUCTION_SITE (
  id INT IDENTITY(1,1) PRIMARY KEY,
  location VARCHAR(100) NOT NULL,
  sqsize DECIMAL(10, 2) NOT NULL,
  required_access_level INT NOT NULL
);

INSERT INTO CONSTRUCTION_SITE (location, sqsize, required_access_level) VALUES ('123 Main Street, CityA', 1000.00, 2);
INSERT INTO CONSTRUCTION_SITE (location, sqsize, required_access_level) VALUES ('456 Elm Avenue, CityB', 750.50, 1);
INSERT INTO CONSTRUCTION_SITE (location, sqsize, required_access_level) VALUES ('789 Oak Lane, CityC', 1500.25, 3);

CREATE TABLE WORK_ITEM (
  id INT IDENTITY(1,1) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  default_comment VARCHAR(255)
);

INSERT INTO WORK_ITEM (name, default_comment) VALUES ('Task 1', 'This is the first task.');
INSERT INTO WORK_ITEM (name, default_comment) VALUES ('Task 2', 'This is the second task with a longer default comment.');
INSERT INTO WORK_ITEM (name, default_comment) VALUES ('Task 3', 'This is the third task with a different comment.');


CREATE TABLE ACTIVE_JOBS (
  id INT IDENTITY(1,1) PRIMARY KEY,
  job_location_id INT NOT NULL,
  job_id INT NOT NULL,
  employee_id INT NOT NULL,
  comment VARCHAR(255),
);

CREATE TABLE ROLE (
  id INT IDENTITY(1,1) PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

INSERT INTO ROLE(name) VALUES ('admin');
INSERT INTO ROLE(name) VALUES ('manager');
INSERT INTO ROLE(name) VALUES ('employee');

CREATE TABLE auth_rule (
    name VARCHAR(64) NOT NULL,
    data VARCHAR(MAX),
    created_at INT,
    updated_at INT,
    PRIMARY KEY (name)
);

CREATE TABLE auth_item (
    name VARCHAR(64) NOT NULL,
    type INT NOT NULL,
    description VARCHAR(MAX),
    rule_name VARCHAR(64),
    data VARCHAR(MAX),
    created_at INT,
    updated_at INT,
    PRIMARY KEY (name),
    FOREIGN KEY (rule_name) REFERENCES auth_rule (name) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX type_index (type)
);

INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('admin', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('create-construction', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('create-employee', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('create-workitem', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('delete-construction', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('delete-employee', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('delete-workitem', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('employee', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('list-activejobs', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('manage-activejobs', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('manager', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('update-activejobs', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('update-construction', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('update-employee', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('update-workitem', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('view-construction', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('view-employee', '1');
INSERT INTO [dbo].[auth_item] ([name], [type]) VALUES ('view-workitem', '1');

CREATE TABLE auth_item_child (
    parent VARCHAR(64) NOT NULL,
    child VARCHAR(64) NOT NULL,
    PRIMARY KEY (parent, child)
);

INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'create-construction');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'create-employee');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'create-workitem');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'delete-construction');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'delete-employee');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'delete-workitem');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'list-activejobs');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'update-construction');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'update-employee');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'update-workitem');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'view-construction');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'view-employee');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('admin', 'view-workitem');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('employee', 'list-activejobs');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('manager', 'list-activejobs');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('manager', 'manage-activejobs');
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES ('manager', 'update-activejobs');

CREATE TABLE auth_assignment (
    item_name VARCHAR(64) NOT NULL,
    user_id VARCHAR(64) NOT NULL,
    created_at INT,
    PRIMARY KEY (item_name, user_id),
    FOREIGN KEY (item_name) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id]) VALUES ('employee', '1');
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id]) VALUES ('admin', '3');
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id]) VALUES ('manager', '2');