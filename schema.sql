CREATE DATABASE socialbot;
USE socialbot;

DROP TABLE IF EXISTS persons;
CREATE TABLE
    persons
    (
        id bigint NOT NULL AUTO_INCREMENT,
        name VARCHAR(255),
        facebook_token TEXT,
        facebook_secret VARCHAR(255),
        twitter_token VARCHAR(255),
        twitter_secret VARCHAR(255),
        status VARCHAR(10) DEFAULT 'A' NOT NULL,
        created_on DATETIME,
        updated_on DATETIME,
        email VARCHAR(255),
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS actions;
CREATE TABLE
    actions
    (
        id bigint NOT NULL AUTO_INCREMENT,
        type VARCHAR(25),
        social_network VARCHAR(20),
        source_path VARCHAR(255),
        person_id BIGINT,
        execute_on DATETIME,
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS images;
CREATE TABLE
    images
    (
        id bigint NOT NULL AUTO_INCREMENT,
        filename VARCHAR(255),
        details DATETIME,
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS person_images;
CREATE TABLE
    person_images
    (
        person_id BIGINT NOT NULL,
        image_id  BIGINT NOT NULL,
        updated_on DATETIME
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1;
