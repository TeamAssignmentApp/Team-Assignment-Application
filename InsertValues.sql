USE TeamAssignmentApp;
TRUNCATE TABLE Skill;
TRUNCATE TABLE User;
TRUNCATE TABLE HasSkill;
TRUNCATE TABLE Project;
TRUNCATE TABLE Discipline;
TRUNCATE TABLE Class;
TRUNCATE TABLE Major;
TRUNCATE TABLE AdminOf;
TRUNCATE TABLE InDiscipline;
TRUNCATE TABLE IsMajor;
TRUNCATE TABLE InClass;
TRUNCATE TABLE ProjectRequiresSkill;
TRUNCATE TABLE ClassHasSkill;
TRUNCATE TABLE HasProject;
TRUNCATE TABLE InProject;
TRUNCATE TABLE RequiresMajor;
TRUNCATE TABLE WantsTeammate;
TRUNCATE TABLE WantsProject;

INSERT INTO USER (email, fname, lname, password, isMaster) VALUES ("totally@real.email", "Adam", "N", "password", 1);
INSERT INTO USER (email, fname, lname, password, isMaster) VALUES ("totally@real.email", "Joe", "Schmoe", "password", 0);
INSERT INTO USER (email, fname, lname, password, isMaster) VALUES ("totally@real.email", "Nick", "Morris", "password", 0);

INSERT INTO Class (className, projectPreferences, teammatePreferences, startTime, endTime) VALUES ("Senior Design", 3, 2, now(), now());

INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("TeamAssignmentApp", "Ipsum solom dolor et", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("ThatOtherProject", "Wow So cool Much Project", "n/a");

INSERT INTO Skill (skillName) VALUES ("Valiant");
INSERT INTO Skill (skillName) VALUES ("Trustworthy");
INSERT INTO Skill (skillName) VALUES ("Exciting");
INSERT INTO Skill (skillName) VALUES ("Cheerful");
INSERT INTO Skill (skillName) VALUES ("Leader");

INSERT INTO Major (majorName) VALUES ("CSE");
INSERT INTO Major (majorName) VALUES ("EE");
INSERT INTO Major (majorName) VALUES ("ME");