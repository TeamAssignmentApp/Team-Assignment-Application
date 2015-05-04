Use TeamAssignmentApp;

INSERT INTO Major (majorName) VALUES ("CSE");
INSERT INTO Major (majorName) VALUES ("ME");
INSERT INTO Major (majorName) VALUES ("EE");

INSERT INTO Class (className, projectPreferences, teammatePreferences, startTime, endTime) VALUES ("Freshman Design", 3, 3, now(),  DATE_ADD(now(), INTERVAL 7 DAY));
INSERT INTO Class (className, projectPreferences, teammatePreferences, startTime, endTime) VALUES ("Senior Design", 3, 0, now(),  DATE_ADD(now(), INTERVAL 7 DAY));
INSERT INTO Class (className, projectPreferences, teammatePreferences, startTime, endTime) VALUES ("GUI-Databases Collaborative Project", 2, 0, now(),  DATE_ADD(now(), INTERVAL 7 DAY));

INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Senior Project 1", "This is an amazing project description ", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Senior Project 2", "No more amazement.", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Senior Project 3", "Third senior design project", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Senior Project 4", "fourth senior design project", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Senior Project 5", "fifth senior design project!", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("Senior Project 6", "Sixth senior design project", "n/a");

INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("GUI Databases 1", "This is the first of only two projects in the GUI Databases Class.", "n/a");
INSERT INTO Project (projectName, projectDesc, fileLink) VALUES ("GUI Databases 2", "This is the second of only two projects in the GUI Databases Class.", "n/a");

INSERT INTO Skill (skillName) VALUES ("Brave");
INSERT INTO Skill (skillName) VALUES ("Condescending");
INSERT INTO Skill (skillName) VALUES ("Patient");
INSERT INTO Skill (skillName) VALUES ("Ridiculous");
INSERT INTO Skill (skillName) VALUES ("Hearty");
INSERT INTO Skill (skillName) VALUES ("Foolish");
INSERT INTO Skill (skillName) VALUES ("Responsible");
INSERT INTO Skill (skillName) VALUES ("Bold");
INSERT INTO Skill (skillName) VALUES ("Clairvoyant");
INSERT INTO Skill (skillName) VALUES ("Timid");
INSERT INTO Skill (skillName) VALUES ("Special");
INSERT INTO Skill (skillName) VALUES ("Tall");
INSERT INTO Skill (skillName) VALUES ("Short");
INSERT INTO Skill (skillName) VALUES ("Helpful");

INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,1);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,2);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,3);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,4);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,5);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (1,6);

INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,8);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,9);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,10);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,11);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,12);
INSERT INTO ClassHasSkill (classID, skillID) VALUES (2,12);

INSERT INTO HasProject (classID, projectID) VALUES (1,1);
INSERT INTO HasProject (classID, projectID) VALUES (1,2);
INSERT INTO HasProject (classID, projectID) VALUES (1,3);
INSERT INTO HasProject (classID, projectID) VALUES (1,4);
INSERT INTO HasProject (classID, projectID) VALUES (1,5);
INSERT INTO HasProject (classID, projectID) VALUES (1,6);

INSERT INTO HasProject (classID, projectID) VALUES (3,7);
INSERT INTO HasProject (classID, projectID) VALUES (3,8);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (1,1,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (1,2,2);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (2,1,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (2,2,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (2,3,2);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,1,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,2,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (3,3,2);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (4,1,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (4,3,3);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (5,1,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (5,2,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (5,3,3);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (6,1,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (6,2,2);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (6,3,3);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (7,1,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (7,3,1);

INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (8,2,3);
INSERT INTO RequiresMajor( projectID, majorID, number) VALUES (8,3,3);

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
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (4, 4);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (5, 2);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (5, 3);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (5, 6);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (6, 1);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (6, 5);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (6, 6);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (7, 8);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (7, 9);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (7, 10);

INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (8, 11);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (8, 12);
INSERT INTO ProjectRequiresSkill (projectID, skillID) VALUES (8, 13);