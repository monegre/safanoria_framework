/**
 These tables are required for Safanòria's
 None of these shloud be modified nor removed
 
 All tables should follw this style:
 CREATE TABLE table (
 	id mediumint(6) NOT NULL auto_increment,
 	field VARCHAR(50) NULL,
 	field VARCHAR(25) NOT NULL DEFAULT 'X',
 	PRIMARY KEY  (id),
 	UNIQUE (field)
 )	ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 */

DROP TABLE IF EXISTS meta_content;
DROP TABLE IF EXISTS admin_users;
DROP TABLE IF EXISTS admin_users_levels;
DROP TABLE IF EXISTS langs;


# This table is the glue between all the different language versions of a single content. 
# A single content is a post, an article, a category or whatsoever.
# 
# Each of the id's listed in column post_id is a specific language version of the content.
# The group of all of the id's listed in column post_id represent the single content. 
CREATE TABLE meta_contents (
	id INT(5) NOT NULL auto_increment,
	nice_url VARCHAR(100) NOT NULL,
	in_table VARCHAR(50) NOT NULL,
	parent INT(5) NOT NULL DEFAULT '0',
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	UNIQUE (nice_url, in_table, parent)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE admin_users (
	admin_id MEDIUMINT(6) NOT NULL auto_increment,
	first_name VARCHAR(25) NOT NULL,
	last_name VARCHAR(75) NOT NULL,
	username VARCHAR(25) NOT NULL,
	email VARCHAR(50) NULL,
	salt VARCHAR(40) NOT NULL,
	password VARCHAR(40) NOT NULL,
	gender enum('M','F') NULL,
	lang VARCHAR(2) NOT NULL,
	level VARCHAR(15) NOT NULL DEFAULT '1',
	last_login VARCHAR(8) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY  (admin_id),
	UNIQUE (email, username)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE admin_users_levels (
	id int(2) NOT NULL auto_increment,
	level int(2) NOT NULL,
	level_name VARCHAR(30) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (level, level_name)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE langs (
	id TINYINT(2) NOT NULL auto_increment,
	name VARCHAR(30) NOT NULL,
	code VARCHAR(2) NOT NULL,
	regional VARCHAR(8) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	UNIQUE (name, code, regional)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Create User Levels   ! IMPORTANT
# ------------------------------------------------------------
INSERT INTO `admin_users_levels` (`id`, `level`, `level_name`)
VALUES
	(1,1,'Super Admin'),
	(2,2,'Admin'),
	(3,3,'Editor'),
	(4,4,'Contributor');

# Create a user for admin purposes
# ------------------------------------------------------------
INSERT INTO admin_users 
	(
	admin_id, 
	first_name, 
	last_name,
	username,  
	email, 
	salt, 
	password, 
	gender, 
	lang, 
	level,
	last_login
	)
VALUES
	(
	'', 
	'Carles', 
	'Jove i Buxeda', 
	'carlesjove',
	'carlusjove@yahoo.es',
	'72a1907ea98b63089850c086cd29d0fce6a33db4',
	'caa24a2fd29e6c8d5ff24f62b82c7481456308b6',
	'M',
	'ca',
	'1',
	''
	);

# Create some langs for testing purposes
# ------------------------------------------------------------
INSERT INTO `langs` (`id`, `name`, `code`, `regional`, `created_at`, `updated_at`)
VALUES
	(1,'Català','ca','es_ca','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'English','en','en_us','0000-00-00 00:00:00','0000-00-00 00:00:00');
