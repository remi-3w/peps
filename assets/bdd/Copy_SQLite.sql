-- SQLite

-- DROP TABLE IF EXISTS `user`;
-- DROP TABLE IF EXISTS `teams`;
DROP TABLE IF EXISTS `matchs`;


-- CREATE TABLE users(
--     id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
--     username TEXT NOT NULL UNIQUE,
--     password TEXT NOT NULL ,
--     email TEXT NOT NULL UNIQUE,
--     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

-- CREATE TABLE teams(
--     id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
--     name TEXT NOT NULL UNIQUE        
-- );

CREATE TABLE matchs_teams(
    match_id INTEGER NOT NULL ,
    team_id INTER NOT NULL,
    FOREIGN KEY (team_id) REFERENCES teams(id),
    FOREIGN KEY (match_id) REFERENCES teams(id),
);


CREATE TABLE matchs(
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    team1_id INTEGER NOT NULL ,
    team2_id INTEGER NOT NULL ,    
    score_team1 TEXT NOT NULL DEFAULT '0',
    score_team2 TEXT NOT NULL DEFAULT '0',
    date DATETIME NOT NULL,
    FOREIGN KEY (team1_id) REFERENCES teams(id),
    FOREIGN KEY (team2_id) REFERENCES teams(id)    
);


    -- INSERT INTO teams (name) VALUES ('Danemark');
    -- INSERT INTO teams (name) VALUES ('France');
    -- INSERT INTO teams (name) VALUES ('Tunisie'); 
    -- INSERT INTO teams (name) VALUES ('???');

INSERT Into matchs (team1_id, team2_id, date) VALUES (1, 2, '2022-11-22');
INSERT Into matchs (team1_id, team2_id, date) VALUES (3, 4, '2022-11-22');
INSERT Into matchs (team1_id, team2_id, date) VALUES (2, 3, '2022-11-26');
INSERT Into matchs (team1_id, team2_id, date) VALUES (4, 1, '2022-11-26');
INSERT Into matchs (team1_id, team2_id, date) VALUES (2, 4, '2022-11-30');
INSERT Into matchs (team1_id, team2_id, date) VALUES (1, 3, '2022-11-30');


SELECT * FROM matchs INNER JOIN teams as t1 ON t1.name = matchs.team1_id INNER JOIN teams AS t2 ON matchs.team2_id = t2.id
SELECT * FROM matchs_teams inner join matchs on matchs_teams.match_id = matchs.id inner join teams on matchs_teams.team_id = teams.id GROUP BY match_id
SELECT teams.name as tname , matchs_teams.match_id , matchs_teams.team_id, matchs.score_team1, matchs.score_team2, matchs.date, matchs.id FROM matchs_teams, teams, matchs WHERE matchs_teams.team_id = teams.id AND matchs_teams.match_id = matchs.id GROUP BY match_id


