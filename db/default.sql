/**
 These tables are optional for Safanòria
 You will be asked to isntall them.
 You don't need to modify or remove this file.
 If you need other tables, create a new .sql file and load it INTo the installer
 
 All tables you write MUST follow this style:
 CREATE TABLE table (
 	id mediumINT(6) NOT NULL auto_increment,
 	field VARCHAR(50) NULL,
 	field VARCHAR(25) NOT NULL DEFAULT 'X',
 	lang VARCHAR(2) NOT NULL,
 	PRIMARY KEY  (id),
 	UNIQUE (field),
 	FOREIGN KEY (lang) REFERENCES langs(id),
 )	ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 */
 
DROP TABLE IF EXISTS sections;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS medias;

CREATE TABLE sections (
	id TINYINT(3) NOT NULL auto_increment,
	identifier INT(5) NOT NULL,
	title VARCHAR(250) DEFAULT NULL,
	description text DEFAULT NULL,
	nice_url VARCHAR(100) DEFAULT NULL,
	display_order TINYINT(2) NOT NULL DEFAULT '0',
	parent INT(5) NOT NULL,
	lang VARCHAR(2) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	FOREIGN KEY (identifier) REFERENCES meta_contents(id)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
	id INT(3) NOT NULL auto_increment,
	identifier INT(5) NOT NULL,
	title VARCHAR(250) DEFAULT NULL,
	description TEXT DEFAULT NULL,
	nice_url VARCHAR(100) DEFAULT NULL,
	display_order TINYINT(2) NOT NULL DEFAULT '0',
	lang VARCHAR(2) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	FOREIGN KEY (identifier) REFERENCES meta_contents(id)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE posts (
	id INT(9) NOT NULL auto_increment,
	identifier INT(5) NOT NULL,
	title VARCHAR(250) DEFAULT NULL,
	content LONGTEXT DEFAULT NULL,
	description TEXT DEFAULT NULL,
	related_img VARCHAR(60) DEFAULT NULL,
	nice_url VARCHAR(100) DEFAULT NULL,
	section TINYINT(3) DEFAULT NULL,
	tags VARCHAR(250) DEFAULT NULL,
	categories VARCHAR(255) DEFAULT NULL,
	status VARCHAR(25) NOT NULL DEFAULT 'draft',
	author VARCHAR(80) DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lang VARCHAR(2) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (identifier) REFERENCES meta_contents(id)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE medias (
	id BIGINT(20) NOT NULL auto_increment,
	identifier INT(5) NOT NULL,
	title VARCHAR(255) NULL,
	content LONGTEXT DEFAULT NULL,
	description VARCHAR(255) NULL,
	alt VARCHAR(75) NULL,
	file_name VARCHAR(50) NULL,
	file_type VARCHAR(25) NULL,
	nice_url VARCHAR(100) DEFAULT NULL,
	lang VARCHAR(2) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	FOREIGN KEY (identifier) REFERENCES meta_contents(id)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;