Use TeamAssignmentApp;

INSERT INTO Major (majorName) VALUES ("CSE");
INSERT INTO Major (majorName) VALUES ("ME");
INSERT INTO Major (majorName) VALUES ("EE");

INSERT INTO Class (className, projectPreferences, teammatePreferences, startTime, endTime) VALUES ("Freshman Design", 3, 3, now(),  DATE_ADD(now(), INTERVAL 7 DAY));

INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 1", "I am a freshman design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 2", "I am also a freshman design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 3", "I am a freshman design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 4", "I am also a freshman design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 5", "I am a freshman design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Freshman Design Project 6", "I am also a freshman design project!", "n/a");

INSERT INTO Skill (skillName) VALUES ("Brave");
INSERT INTO Skill (skillName) VALUES ("Condescending");
INSERT INTO Skill (skillName) VALUES ("Patient");
INSERT INTO Skill (skillName) VALUES ("Ridiculous");
INSERT INTO Skill (skillName) VALUES ("Hearty");
INSERT INTO Skill (skillName) VALUES ("Foolish");

INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,1);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,2);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,3);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,4);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,5);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,6);

INSERT INTO HasProject (classID, projectID) VALUES (1,1);
INSERT INTO HasProject (classID, projectID) VALUES (1,2);
INSERT INTO HasProject (classID, projectID) VALUES (1,3);
INSERT INTO HasProject (classID, projectID) VALUES (1,4);
INSERT INTO HasProject (classID, projectID) VALUES (1,5);
INSERT INTO HasProject (classID, projectID) VALUES (1,6);

INSERT INTO InClass (classID, userID) VALUES (1, 2);
INSERT INTO IsMajor (majorID, userID) VALUES (1, 2);
INSERT INTO InClass (classID, userID) VALUES (1, 3);
INSERT INTO IsMajor (majorID, userID) VALUES (1, 3);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (1,1,1);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (2,1,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,1,1);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (4,1,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (5,1,1);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (6,1,2);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (1, 1);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (1, 2);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (1, 3);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (2, 2);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (2, 3);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (2, 4);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (3, 4);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (3, 5);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (3, 6);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 1);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 2);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 3);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (5, 2);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (5, 3);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (5, 4);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (6, 4);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (6, 5);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (6, 6);

INSERT INTO WantsProject (projectID, userID, rank) VALUES (1, 2,1);
INSERT INTO WantsProject (projectID, userID, rank) VALUES (2, 2,3);
INSERT INTO WantsProject (projectID, userID, rank) VALUES (4, 2,2);

INSERT INTO WantsProject (projectID, userID, rank) VALUES (1, 3,1);
INSERT INTO WantsProject (projectID, userID, rank) VALUES (2, 3,3);
INSERT INTO WantsProject (projectID, userID, rank) VALUES (4, 3,2);

INSERT INTO HasSkill (userID, skillID) VALUES (2,1);
INSERT INTO HasSkill (userID, skillID) VALUES (2,2);
