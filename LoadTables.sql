DROP Database IF Exists TeamAssignmentApp;
CREATE Database TeamAssignmentApp;
USE TeamAssignmentApp;

DROP TABLE IF EXISTS Skill;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS HasSkill;
DROP TABLE IF EXISTS Project;
DROP TABLE IF EXISTS Class;
DROP TABLE IF EXISTS Major;
DROP TABLE IF EXISTS AdminOf;
DROP TABLE IF EXISTS IsMajor;
DROP TABLE IF EXISTS ProjectRequiresSkill;
DROP TABLE IF EXISTS ClassHasSkill;
DROP TABLE IF EXISTS HasProject;
DROP TABLE IF EXISTS InProject;
DROP TABLE IF EXISTS RequiresMajor;
DROP TABLE IF EXISTS WantsTeammate;
DROP TABLE IF EXISTS WantsProject;

CREATE TABLE User(
  userID int not null primary key auto_increment,
  email varchar(30),
  fname varchar(30),
  lname varchar(30),
  password varchar(40),
  isMaster tinyint(1)
);
CREATE TABLE Class(
  classID int not null primary key auto_increment,
  className varchar(40),
  projectPreferences int,
  teammatePreferences int,
  startTime DATETIME,
  endTime DATETIME
);
CREATE TABLE Project(
  projectID int not null primary key auto_increment,
  projectName varchar(40),
  projectDesc varchar(1000),
  fileLink varchar(100)
);
CREATE TABLE Skill(
  skillID int not null primary key auto_increment,
  skillName varchar(40)
);
CREATE TABLE Major(
  majorID int not null primary key auto_increment,
  majorName varchar(40)
);
CREATE TABLE AdminOf(
    userID int,
    classID int,
    PRIMARY KEY (classID, userID), 
    FOREIGN KEY (classID) REFERENCES Class(classID),
    FOREIGN KEY (userID) REFERENCES User(userID) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
CREATE TABLE IsMajor(
  majorID int,
  userID int,
  foreign key(majorID) references Major(majorID),
  foreign key(userID) references User(userID),
  primary key(majorID, userID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE HasSkill(
  skillID int,
  userID int,
  foreign key(skillID) references Skill(skillID),
  foreign key(userID) references User(userID),
  primary key(skillID, userID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE ProjectRequiresSkill(
  skillID int,
  projectID int,
  foreign key(skillID) references Skill(skillID),
  foreign key(projectID) references Project(projectID),
  primary key(skillID, projectID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE ClassHasSkill(
  skillID int,
  classID int,
  foreign key(skillID) references Skill(skillID),
  foreign key(classID) references Class(classID),
  primary key(skillID, classID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE HasProject(
  classID int,
  projectID int,
  foreign key(classID) references Class(classID),
  foreign key(projectID) references Project(projectID),
  primary key(classID, projectID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE InProject(
  userID int,
  projectID int,
  foreign key(userID) references User(userID),
  foreign key(projectID) references Project(projectID),
  primary key(userID, projectID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE RequiresMajor(
  majorID int,
  projectID int,
  number int,
  foreign key(majorID) references Major(majorID),
  foreign key(projectID) references Project(projectID),
  primary key(majorID, projectID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE WantsTeammate(
  userID int,
  teammateID int,
  rank int,
  foreign key(userID) references User(userID),
  foreign key(teammateID) references User(userID),
  primary key(userID, teammateID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
CREATE TABLE WantsProject(
  userID int,
  projectID int,
  rank int,
  foreign key(userID) references User(userID),
  foreign key(projectID) references Project(projectID),
  primary key(userID, projectID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);