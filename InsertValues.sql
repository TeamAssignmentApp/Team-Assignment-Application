USE TeamAssignmentApp;
TRUNCATE TABLE HasSkill;
TRUNCATE TABLE AdminOf;
TRUNCATE TABLE IsMajor;
TRUNCATE TABLE InClass;
TRUNCATE TABLE ProjectRequiresSkill;
TRUNCATE TABLE ClassHasSkill;
TRUNCATE TABLE HasProject;
TRUNCATE TABLE InProject;
TRUNCATE TABLE RequiresMajor;
TRUNCATE TABLE WantsTeammate;
TRUNCATE TABLE WantsProject;

INSERT INTO User (email, fname, lname, password, isMaster) VALUES ("totally2@real.email", "Adam", "N", "password", 1);
INSERT INTO User (email, fname, lname, password) VALUES ("totally3@real.email", "Joe", "Schmoe", "password");
INSERT INTO User (email, fname, lname, password) VALUES ("totally@real.email", "Nick", "Morris", "password");

INSERT INTO Class (className, teammatePreferences) VALUES ("Senior Design", 2);

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

INSERT INTO HasSkill(userID, skillID) VALUES (3, 1);
INSERT INTO HasSkill(userID, skillID) VALUES (3, 2);
INSERT INTO HasSkill(userID, skillID) VALUES (2, 3);
INSERT INTO HasSkill(userID, skillID) VALUES (2, 4);

INSERT INTO AdminOf(userID, classID) VALUES (3, 1);

INSERT INTO IsMajor(userID, majorID) VALUES (2, 1);

INSERT INTO InClass(userID, classID) VALUES (2, 1);

INSERT INTO ProjectRequiresSkill(projectID, skillID) VALUES (1, 1);
INSERT INTO ProjectRequiresSkill(projectID, skillID) VALUES (1, 2);
INSERT INTO ProjectRequiresSkill(projectID, skillID) VALUES (1, 3);
INSERT INTO ProjectRequiresSkill(projectID, skillID) VALUES (2, 3);
INSERT INTO ProjectRequiresSkill(projectID, skillID) VALUES (2, 4);

INSERT INTO ClassHasSkill(classID, skillID) VALUES (1, 1);
INSERT INTO ClassHasSkill(classID, skillID) VALUES (1, 2);
INSERT INTO ClassHasSkill(classID, skillID) VALUES (1, 3);
INSERT INTO ClassHasSkill(classID, skillID) VALUES (1, 4);
INSERT INTO ClassHasSkill(classID, skillID) VALUES (1, 5);

INSERT INTO HasProject(classID, projectID) VALUES (1, 1);

INSERT INTO RequiresMajor(projectID, majorID, number) VALUES (1, 1, 1);