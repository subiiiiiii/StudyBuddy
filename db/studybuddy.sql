
-- User Table
CREATE TABLE  IF NOT EXISTS `studybuddy`.`User` (
    `user_id` INT AUTO_INCREMENT,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `date_joined` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_of_birth` DATE NOT NULL,
    -- Specify if the user is admin.
    `is_admin` BOOLEAN NOT NULL DEFAULT 0,
    -- Admin blocked.
    `is_blocked` BOOLEAN NOT NULL DEFAULT 0,
    -- User voluntarily closed.
    `is_closed` BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (`user_id`),
    UNIQUE (`email`)
) ENGINE = InnoDB;

-- Category Table
CREATE TABLE  IF NOT EXISTS `studybuddy`.`Category` (
    `category_id` INT AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `icon` VARCHAR(1011) NOT NULL, -- File Path
    PRIMARY KEY (`category_id`),
    UNIQUE (`name`)
) ENGINE = InnoDB;

-- Populate some categories
INSERT INTO `studybuddy`.`Category` (`name`) VALUES ('Lecture Note');
INSERT INTO `studybuddy`.`Category` (`name`) VALUES ('Past Paper');
INSERT INTO `studybuddy`.`Category` (`name`) VALUES ('Text Book');
INSERT INTO `studybuddy`.`Category` (`name`) VALUES ('Syllabus');
INSERT INTO `studybuddy`.`Category` (`name`) VALUES ('Blog');

-- Author Table
CREATE TABLE  IF NOT EXISTS `studybuddy`.`Author` (
    `author_id` INT AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`author_id`)
) ENGINE = InnoDB;

-- Study Resource Table
CREATE TABLE  IF NOT EXISTS `studybuddy`.`Resource` (
    `resource_id` INT AUTO_INCREMENT,
    `category` INT NOT NULL, -- Foreign key
    `header_image` VARCHAR(1011) NOT NULL, --  File Path
    `title` VARCHAR(100) NOT NULL,
    -- Yeso garna le null value basdaina ra empty rakhna painchha
    `short_description` VARCHAR(500) NOT NULL DEFAULT '',
    `long_description` TEXT,
    `subject` VARCHAR(200) NOT NULL,
    -- Content laai chahi kina null gareko vane,
    -- long description ra short description ko le pani hamilai content pura huna sakcha
    -- So, we dont need to upload a separate content.

    `content` VARCHAR(1011),  -- File Path
    `content_extension` VARCHAR(10),  -- File extension
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `uploaded_by` INT NOT NULL, -- The user who uploads the resource.
    `upvote` INT NOT NULL DEFAULT 0,
    `downvote` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`resource_id`),
    FOREIGN KEY (`category`) REFERENCES Category(`category_id`),
    FOREIGN KEY (`uploaded_by`) REFERENCES User(`user_id`)
) ENGINE = InnoDB;

-- Resource Author Table
CREATE TABLE  IF NOT EXISTS `studybuddy`.`ResourceAuthor` (
    `resource_id` INT NOT NULL, -- Foreign key
    `author_id` INT NOT NULL, -- Foreign key
    PRIMARY KEY (`resource_id`, `author_id`),
    FOREIGN KEY (`resource_id`) REFERENCES Resource(`resource_id`),
    FOREIGN KEY (`author_id`) REFERENCES Author(`author_id`)
) ENGINE = InnoDB;


-- Report Table
CREATE TABLE  IF NOT EXISTS `studybuddy`.`Report` (
    `report_id` INT AUTO_INCREMENT,
    `resource_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `is_reviewed` BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (`report_id`),
    FOREIGN KEY (`user_id`) REFERENCES User(`user_id`),
    FOREIGN KEY (`resource_id`) REFERENCES Resource(`resource_id`)
) ENGINE = InnoDB;

-- Vote Table.
CREATE TABLE  IF NOT EXISTS `studybuddy`.`Vote` (
    `vote_id` INT AUTO_INCREMENT,
    `resource_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `vote` INT NOT NULL,
    PRIMARY KEY (`vote_id`),
    FOREIGN KEY (`user_id`) REFERENCES User(`user_id`),
    FOREIGN KEY (`resource_id`) REFERENCES Resource(`resource_id`)
) ENGINE = InnoDB;
