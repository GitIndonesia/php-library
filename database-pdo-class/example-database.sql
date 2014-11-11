CREATE TABLE users (
  id int(5) NOT NULL AUTO_INCREMENT,
  name varchar(20) DEFAULT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB;

INSERT INTO users VALUES
  (1,'Walter'),
  (2,'Sheldon');
