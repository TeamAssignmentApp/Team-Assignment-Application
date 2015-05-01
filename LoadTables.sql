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
  email varchar(30) UNIQUE,
  fname varchar(30),
  lname varchar(30),
  password varchar(40),
  isMaster tinyint(1) DEFAULT 0,
  wantsToLead tinyint(1) DEFAULT 0,
  submissionTime DATETIME
);
CREATE TABLE Class(
  classID int not null primary key auto_increment,
  className varchar(40) UNIQUE,
  projectPreferences int DEFAULT 3,
  teammatePreferences int DEFAULT 3,
  startTime DATE,
  endTime DATE
);
CREATE TABLE Project(
  projectID int not null primary key auto_increment,
  projectName varchar(40),
  projectDesc varchar(1000),
  fileLink varchar(100)
);
CREATE TABLE Skill(
  skillID int not null primary key auto_increment,
  skillName varchar(40),
  userCreated tinyint(1) DEFAULT 0
);
CREATE TABLE Major(
  majorID int not null primary key auto_increment,
  majorName varchar(40) UNIQUE
);
CREATE TABLE AdminOf(
    userID int,
    classID int,
    PRIMARY KEY (classID, userID), 
    FOREIGN KEY (classID) REFERENCES Class(classID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (userID) REFERENCES User(userID) 
      ON DELETE CASCADE
      ON UPDATE CASCADE
)ENGINE = InnoDB;
CREATE TABLE InClass(
    userID int,
    classID int,
    PRIMARY KEY (classID, userID), 
    FOREIGN KEY (classID) REFERENCES Class(classID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (userID) REFERENCES User(userID) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE = InnoDB;
CREATE TABLE IsMajor(
  majorID int,
  userID int,
  foreign key(majorID) references Major(majorID)
      ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(userID) references User(userID)
      ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(majorID, userID)
)ENGINE = InnoDB;
CREATE TABLE HasSkill(
  skillID int,
  userID int,
  foreign key(skillID) references Skill(skillID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(userID) references User(userID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(skillID, userID)
) ENGINE = InnoDB;
CREATE TABLE ProjectRequiresSkill(
  skillID int,
  projectID int,
  foreign key(skillID) references Skill(skillID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(projectID) references Project(projectID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(skillID, projectID)
)ENGINE = InnoDB;
CREATE TABLE ClassHasSkill(
  skillID int,
  classID int,
  foreign key(skillID) references Skill(skillID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(classID) references Class(classID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(skillID, classID)

)ENGINE = InnoDB;
CREATE TABLE HasProject(
  classID int,
  projectID int,
  foreign key(classID) references Class(classID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(projectID) references Project(projectID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(classID, projectID)
)ENGINE = InnoDB;
CREATE TABLE InProject(
  userID int,
  projectID int,
  foreign key(userID) references User(userID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(projectID) references Project(projectID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(userID, projectID)
)ENGINE = InnoDB;
CREATE TABLE RequiresMajor(
  majorID int,
  projectID int,
  number int,
  foreign key(majorID) references Major(majorID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(projectID) references Project(projectID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(majorID, projectID)
)ENGINE = InnoDB;
CREATE TABLE WantsTeammate(
  userID int,
  teammateID int,
  rank int,
  foreign key(userID) references User(userID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(teammateID) references User(userID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(userID, teammateID)
)ENGINE = InnoDB;
CREATE TABLE WantsProject(
  userID int,
  projectID int,
  rank int,
  foreign key(userID) references User(userID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  foreign key(projectID) references Project(projectID)
  ON DELETE CASCADE
    ON UPDATE CASCADE,
  primary key(userID, projectID)
)ENGINE = InnoDB;