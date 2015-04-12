DROP Database IF Exists TeamAssignmentApp;
CREATE Database TeamAssignmentApp;
USE TeamAssignmentApp;

DROP TABLE IF EXISTS Skill;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS HasSkill;
DROP TABLE IF EXISTS Project;
DROP TABLE IF EXISTS Discipline;
DROP TABLE IF EXISTS Class;
DROP TABLE IF EXISTS Major;
DROP TABLE IF EXISTS AdminOf;
DROP TABLE IF EXISTS InDiscipline;
DROP TABLE IF EXISTS IsMajor;
DROP TABLE IF EXISTS InClass;
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
  password varchar(255),
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
CREATE TABLE Discipline(
  disciplineID int not null primary key auto_increment,
  disciplineName varchar(40)
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
);
CREATE TABLE InClass(
    disciplineID int,
    classID int,
    PRIMARY KEY (classID, disciplineID), 
    FOREIGN KEY (classID) REFERENCES Class(classID),
    FOREIGN KEY (disciplineID) REFERENCES Discipline(disciplineID) 
);
CREATE TABLE InDiscipline(
  disciplineID int,
  userID int,
  foreign key(disciplineID) references Discipline(disciplineID),
  foreign key(userID) references User(userID),
  primary key(disciplineID, userID)
);
CREATE TABLE IsMajor(
  majorID int,
  userID int,
  foreign key(majorID) references Major(majorID),
  foreign key(userID) references User(userID),
  primary key(majorID, userID)
);
CREATE TABLE HasSkill(
  skillID int,
  userID int,
  foreign key(skillID) references Skill(skillID),
  foreign key(userID) references User(userID),
  primary key(skillID, userID)
);
CREATE TABLE ProjectRequiresSkill(
  skillID int,
  projectID int,
  foreign key(skillID) references Skill(skillID),
  foreign key(projectID) references Project(projectID),
  primary key(skillID, projectID)
);
CREATE TABLE ClassHasSkill(
  skillID int,
  classID int,
  foreign key(skillID) references Skill(skillID),
  foreign key(classID) references Class(classID),
  primary key(skillID, classID)
);
CREATE TABLE HasProject(
  disciplineID int,
  projectID int,
  foreign key(disciplineID) references Discipline(disciplineID),
  foreign key(projectID) references Project(projectID),
  primary key(disciplineID, projectID)
);
CREATE TABLE InProject(
  userID int,
  projectID int,
  foreign key(userID) references User(userID),
  foreign key(projectID) references Project(projectID),
  primary key(userID, projectID)
);
CREATE TABLE RequiresMajor(
  majorID int,
  projectID int,
  number int,
  foreign key(majorID) references Major(majorID),
  foreign key(projectID) references Project(projectID),
  primary key(majorID, projectID)
);
CREATE TABLE WantsTeammate(
  userID int,
  teammateID int,
  rank int,
  foreign key(userID) references User(userID),
  foreign key(teammateID) references User(userID),
  primary key(userID, teammateID)
);
CREATE TABLE WantsProject(
  userID int,
  projectID int,
  rank int,
  foreign key(userID) references User(userID),
  foreign key(projectID) references Project(projectID),
  primary key(userID, projectID)
);