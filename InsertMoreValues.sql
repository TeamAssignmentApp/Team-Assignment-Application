Use TeamAssignmentApp;

INSERT INTO User (email, fname, lname, password, isMaster) VALUES ("jtigues@gmail.com", "Jeffrey", "Artigues", "password", 0);

INSERT INTO Class (className, projectPreferences, teammatePreferences, startTime, endTime) VALUES ("Freshman Design", 3, 3, now(), now());

INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 1", "I am a freshman design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 2", "I am also a freshman design project!", "n/a");

INSERT INTO Skill (skillName) VALUES ("Brave");
INSERT INTO Skill (skillName) VALUES ("Condescending");
INSERT INTO Skill (skillName) VALUES ("Patient");

INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,6);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,7);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,8);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,9);

INSERT INTO HasProject (classID, projectID) VALUES (2,3);
INSERT INTO HasProject (classID, projectID) VALUES (2,4);

INSERT INTO InClass (classID, userID) VALUES (1, 9);
INSERT INTO InClass (classID, userID) VALUES (2, 9);

INSERT INTO IsMajor (majorID, userID) VALUES (1, 9);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,1,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,2,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,3,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (4,1,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (4,3,3);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (3, 6);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (3, 7);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 7);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 8);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 9);