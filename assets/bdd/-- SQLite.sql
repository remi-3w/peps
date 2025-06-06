-- SQLite
PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `teams`;
DROP TABLE IF EXISTS `matchs`;
DROP TABLE IF EXISTS `matchs_teams`;
DROP TABLE IF EXISTS `matchs_users`;

-- *************** Users **************
-- ****Create Table users ****
    CREATE TABLE users(
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL ,
    email TEXT NOT NULL UNIQUE,
    score INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ****ALTER table users ****
    ALTER TABLE users ADD COLUMN score INTEGER NOT NULL DEFAULT 0;
    ALTER TABLE users ADD COLUMN flag TEXT DEFAULT null;
    ALTER TABLE users ADD COLUMN picture TEXT DEFAULT fixture;
    ALTER TABLE users ADD COLUMN is_admin INTEGER DEFAULT 0;

-- ****Update data ****
    UPDATE users SET username = "Guillaume" WHERE id = 10;
    UPDATE users SET score = 0 WHERE id = 2;
    UPDATE users SET score = 0 ;
    UPDATE Matchs SET real_score_team1 = NULL ;
    UPDATE Matchs SET real_score_team2 = NULL ;
    UPDATE matchs_users SET real_score_team2 = NULL ;

-- *************** Teams **************
-- ****Create Table teams****
    CREATE TABLE teams(
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        name TEXT NOT NULL UNIQUE,
        code TEXT NOT NULL UNIQUE        
    );
-- ****ALTER table****
    ALTER TABLE teams ADD COLUMN code text NOT NULL DEFAULT "???";


-- ****INSERT INTO****
    INSERT INTO teams (name, code) VALUES ('New Zealand', 'NZL');
    INSERT INTO teams (name, code) VALUES ('Norvège', 'NOR');
    INSERT INTO teams (name, code) VALUES ('Philippines', 'PHI');
    INSERT INTO teams (name, code) VALUES ('Suisse', 'SUI');
    INSERT INTO teams (name, code) VALUES ('Australie', 'AUS');
    INSERT INTO teams (name, code) VALUES ('Ireland', 'IRL');
    INSERT INTO teams (name, code) VALUES ('Nigeria', 'NGA');
    INSERT INTO teams (name, code) VALUES ('Canada', 'CAN');
    INSERT INTO teams (name, code) VALUES ('Espagne', 'ESP'); 
    INSERT INTO teams (name, code) VALUES ('Costa Rica', 'CRC');
    INSERT INTO teams (name, code) VALUES ('Zambie', 'ZAM');
    INSERT INTO teams (name, code) VALUES ('Japon', 'JPN');
    INSERT INTO teams (name, code) VALUES ('Angleterre', 'ENG');
    INSERT INTO teams (name, code) VALUES ('???', '???');
    INSERT INTO teams (name, code) VALUES ('Danemark', 'DEN');
    INSERT INTO teams (name, code) VALUES ('Chine', 'CHN');
    INSERT INTO teams (name, code) VALUES ('Etat Unis', 'USA');
    INSERT INTO teams (name, code) VALUES ('Vietnam', 'VIE');
    INSERT INTO teams (name, code) VALUES ('Pays-bas', 'NED'); 
    INSERT INTO teams (name, code) VALUES ('?', '?');
    INSERT INTO teams (name, code) VALUES ('France', 'FRA');    
    INSERT INTO teams (name, code) VALUES ('Jamaique', 'France');
    INSERT INTO teams (name, code) VALUES ('Brésil', 'BRA'); 
    INSERT INTO teams (name, code) VALUES ('??', '??');
    INSERT INTO teams (name, code) VALUES ('Suede', 'SWE');
    INSERT INTO teams (name, code) VALUES ('Afrique du Sud', 'RSA');
    INSERT INTO teams (name, code) VALUES ('Italie', 'ITA');
    INSERT INTO teams (name, code) VALUES ('Argentine', 'ARG');
    INSERT INTO teams (name, code) VALUES ('Allemagne', 'GER');
    INSERT INTO teams (name, code) VALUES ('Maroc', 'MAR');
    INSERT INTO teams (name, code) VALUES ('Colombie', 'COL');
    INSERT INTO teams (name, code) VALUES ('Corée du sud', 'KOR');
     
    -- INSERT INTO teams (name, code) VALUES ('Qatar', 'QAT');    
    -- INSERT INTO teams (name, code) VALUES ('Equateur', 'ECU'); 
    -- INSERT INTO teams (name, code) VALUES ('Uruguay', 'URU');
    -- INSERT INTO teams (name, code) VALUES ('Serbie', 'SRB');
    -- INSERT INTO teams (name, code) VALUES ('Arabie-Saoudite' , 'KSA');
    -- INSERT INTO teams (name, code) VALUES ('Iran', 'IRN'); 
    -- INSERT INTO teams (name, code) VALUES ('Corée du Sud', 'KOR');
    -- INSERT INTO teams (name, code) VALUES ('Portugal' , 'POR');
    -- INSERT INTO teams (name, code) VALUES ('Pologne', 'POL');
    -- INSERT INTO teams (name, code) VALUES ('Cameroun', 'CMR'); 
    -- INSERT INTO teams (name, code) VALUES ('Sénégal', 'SEN');
    -- INSERT INTO teams (name, code) VALUES ('Tunisie', 'TUN');
    -- INSERT INTO teams (name, code) VALUES ('Ghana', 'GHA');    
    -- INSERT INTO teams (name, code) VALUES ('Croatie' , 'CRO');
    -- INSERT INTO teams (name, code) VALUES ('Belgique', 'BEL');   
    -- INSERT INTO teams (name, code) VALUES ('Qatar', 'QAT'); 
    -- INSERT INTO teams (name, code) VALUES ('Mexique', 'MEX');
    -- INSERT INTO teams (name, code) VALUES ('Etats-Unis', 'USA');
    -- INSERT INTO teams (name, code) VALUES ('???', '???');
    -- INSERT INTO teams (name, code) VALUES ('????', '????'); 
    -- INSERT INTO teams (name, code) VALUES ('?????', '?????');

-- ****UPDATE TEAM ****
    UPDATE teams SET code = 'GER' WHERE id = 1;

-- *************** Matchs **************
-- ****Create Table matchs****
    CREATE TABLE matchs(
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        team1_id INTEGER NOT NULL ,
        team2_id INTEGER NOT NULL ,  
        date DATETIME NOT NULL,
        FOREIGN KEY (team1_id) REFERENCES teams(id),
        FOREIGN KEY (team2_id) REFERENCES teams(id)    
    );


    ALTER TABLE matchs DROP user_id;
    ALTER TABLE matchs ADD COLUMN real_score_team1;
    ALTER TABLE matchs ADD COLUMN real_score_team2; -- Added this line
    ALTER TABLE matchs_users ADD COLUMN score_udapte text null;
    ALTER TABLE matchs_users DROP score_udapte;

    -- Removed: ALTER TABLE matchs rename score_team1 to real_score_team1;

    UPDATE matchs SET real_score_team1 = NULL, real_score_team2= NULL;
    UPDATE matchs SET date = "2022-11-21"  WHERE id = 1;
    UPDATE matchs_users SET score_team1 = 0 , score_team2= 0;


-- **************** RELATIONS ****************

    CREATE TABLE matchs_teams(
        match_id INTEGER NOT NULL ,
        team_id INTER NOT NULL,
        FOREIGN KEY (team_id) REFERENCES teams(id),
        FOREIGN KEY (match_id) REFERENCES teams(id)
    );

CREATE TABLE matchs_users(
    match_id INTEGER NOT NULL ,
    user_id INTEGER NOT NULL,
    score_team1 INTEGER NOT NULL DEFAULT 0,
    score_team2 INTEGER NOT NULL DEFAULT 0,
    score_update DATETIME NULL, 
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (match_id) REFERENCES matchs(id)
);

DROP TABLE matchs_users;

DELETE FROM `matchs_users`;
INSERT INTO matchs (team1_id, team2_id, date) VALUES (1, 2, '2023-07-20');
INSERT Into matchs (team1_id, team2_id, date) VALUES (3, 4, '2023-07-21');
INSERT Into matchs (team1_id, team2_id, date) VALUES (2, 3, '2023-07-25');
INSERT Into matchs (team1_id, team2_id, date) VALUES (4, 1, '2023-07-25');
INSERT Into matchs (team1_id, team2_id, date) VALUES (2, 4, '2023-07-30');
INSERT Into matchs (team1_id, team2_id, date) VALUES (1, 3, '2023-07-30');
INSERT Into matchs (team1_id, team2_id, date) VALUES (5, 6, '2023-07-20');
INSERT Into matchs (team1_id, team2_id, date) VALUES (7, 8, '2023-07-21');
INSERT Into matchs (team1_id, team2_id, date) VALUES (6, 7, '2023-07-26');
INSERT Into matchs (team1_id, team2_id, date) VALUES (8, 5, '2023-07-27');
INSERT Into matchs (team1_id, team2_id, date) VALUES (6, 8, '2023-07-31');
INSERT Into matchs (team1_id, team2_id, date) VALUES (5, 7, '2023-07-31');
INSERT Into matchs (team1_id, team2_id, date) VALUES (9, 10, '2023-07-21');
INSERT Into matchs (team1_id, team2_id, date) VALUES (11, 12, '2023-07-22');
INSERT Into matchs (team1_id, team2_id, date) VALUES (10, 11, '2023-07-26');
INSERT Into matchs (team1_id, team2_id, date) VALUES (12, 9, '2023-07-26');
INSERT Into matchs (team1_id, team2_id, date) VALUES (9, 11, '2023-07-31');
INSERT Into matchs (team1_id, team2_id, date) VALUES (13, 14, '2023-07-31');
INSERT Into matchs (team1_id, team2_id, date) VALUES (15, 16, '2023-07-22');
INSERT Into matchs (team1_id, team2_id, date) VALUES (14, 15, '2023-07-22');
INSERT Into matchs (team1_id, team2_id, date) VALUES (16, 13, '2023-07-28');
INSERT Into matchs (team1_id, team2_id, date) VALUES (14, 16, '2023-07-28');
INSERT Into matchs (team1_id, team2_id, date) VALUES (13, 15, '2023-08-01');
INSERT Into matchs (team1_id, team2_id, date) VALUES (17, 18, '2023-08-01');
INSERT Into matchs (team1_id, team2_id, date) VALUES (19, 20, '2023-07-22');
INSERT Into matchs (team1_id, team2_id, date) VALUES (18, 19, '2023-07-23');
INSERT Into matchs (team1_id, team2_id, date) VALUES (20, 17, '2023-07-27');
INSERT Into matchs (team1_id, team2_id, date) VALUES (18, 20, '2023-07-27');
INSERT Into matchs (team1_id, team2_id, date) VALUES (17, 19, '2023-08-01');
INSERT Into matchs (team1_id, team2_id, date) VALUES (21, 22, '2023-08-01');
INSERT Into matchs (team1_id, team2_id, date) VALUES (23, 24, '2023-07-23');
INSERT Into matchs (team1_id, team2_id, date) VALUES (22, 23, '2023-07-24');
INSERT Into matchs (team1_id, team2_id, date) VALUES (24, 21, '2023-07-29');
INSERT Into matchs (team1_id, team2_id, date) VALUES (22, 24, '2023-07-29');
INSERT Into matchs (team1_id, team2_id, date) VALUES (21, 23, '2023-08-02');
INSERT Into matchs (team1_id, team2_id, date) VALUES (25, 26, '2023-08-02');
INSERT Into matchs (team1_id, team2_id, date) VALUES (27, 28, '2023-07-23');
INSERT Into matchs (team1_id, team2_id, date) VALUES (26, 27, '2023-07-24');
INSERT Into matchs (team1_id, team2_id, date) VALUES (28, 25, '2023-07-28');
INSERT Into matchs (team1_id, team2_id, date) VALUES (26, 28, '2023-07-29');
INSERT Into matchs (team1_id, team2_id, date) VALUES (25, 27, '2023-08-02');
INSERT Into matchs (team1_id, team2_id, date) VALUES (29, 30, '2023-08-02');
INSERT Into matchs (team1_id, team2_id, date) VALUES (31, 32, '2023-07-24');
INSERT Into matchs (team1_id, team2_id, date) VALUES (30, 31, '2023-07-25');
INSERT Into matchs (team1_id, team2_id, date) VALUES (32, 29, '2023-07-30');
INSERT Into matchs (team1_id, team2_id, date) VALUES (30, 32, '2023-08-03');
INSERT Into matchs (team1_id, team2_id, date) VALUES (29, 31, '2023-08-03');

-- UPDATE MATCHS --
UPDATE matchs SET DATE = '2023-07-25' WHERE id = 3;

-- SELECT name from teams;
SELECT m.id, m.team1_id, m.team2_id, t1.name AS team1 , t2.name AS Team2 FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id =  t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id;

SELECT mu.score_team1, mu.score_team2 FROM matchs_users AS mu WHERE mu.match_id = 1 AND mu.user_id = 2;

-- VUE --
SELECT  u.username, u.id, mu.match_id, mu.score_team1, mu.score_team2, GROUP_CONCAT(mu.match_id,', ')
FROM users AS u 
INNER JOIN matchs AS m 
INNER JOIN matchs_users AS mu ON u.id = mu.user_id AND  mu.match_id = m.id 
WHERE m.date = "2022-11-21"  ;

SELECT mu.user_id, ui.username, mu.score_team1, mu.score_team2 from matchs AS m
INNER JOIN teams AS t1 ON m.team1_id = t1.id
INNER JOIN teams AS t2 ON m.team2_id = t2.id
INNER JOIN matchs_users AS mu ON m.id = mu.match_id
INNER JOIN users as ui ON mu.user_id = ui.id WHERE m.date = "2022-11-21" 
;

SELECT mu.score_team1, mu.score_team2 
FROM matchs AS m                 
LEFT JOIN matchs_users AS mu ON m.id = mu.match_id
LEFT JOIN users as u ON mu.user_id = u.id
where m.date = "2022-11-21" 
ORDER BY u.id ASC

-- Set user with ID 1 as admin
UPDATE users SET is_admin = 1 WHERE id = 1;