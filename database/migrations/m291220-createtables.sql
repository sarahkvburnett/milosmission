-- //TODO: sort this out :)

-- Animals table
CREATE TABLE animals (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type ENUM('Cat', 'Dog') NOT NULL,
    breed VARCHAR(255),
    colour VARCHAR(255),
    age INT,
    image VARCHAR(255) NOT NULL,
    status ENUM('New', 'Waiting', 'Rehomed') NOT NULL,
    room_id INT,
    friend_id INT,
    owner_id INT,
    rehoming_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    FOREIGN KEY (friend_id) REFERENCES animals(id),
    FOREIGN KEY (owner_id) REFERENCES owners(id),
    FOREIGN KEY (rehoming_id) REFERENCES rehomings(id)
);

-- Images table
CREATE TABLE images (
    id INT NOT NULL AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Animal Images join table
CREATE TABLE animal_images (
    id INT NOT NULL AUTO_INCREMENT,
    animal_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (image_id) REFERENCES images(id)
);

-- Owners table
CREATE TABLE owners (
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(155) NOT NULL,
    lastname VARCHAR(155) NOT NULL,
    address TEXT NOT NULL,
    postcode VARCHAR(8) NOT NULL,
    animal ENUM('Cat','Dog') NOT NULL,
    status ENUM('New','Waiting','Rehomed') NOT NULL,
    new BOOLEAN NOT NULL,
    PRIMARY KEY (id),
);

-- Users table
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(155),
    lastname VARCHAR(155),
    email VARCHAR(255),
    password VARCHAR(255),
    PRIMARY KEY (id),
    UNIQUE (email)
);

-- Room table
CREATE TABLE rooms (
    id INT NOT NULL AUTO_INCREMENT,
    type ENUM('Cat','Dog') NOT NULL,
    PRIMARY KEY (id)
);

-- Rehoming table
CREATE TABLE rehomings (
    id INT NOT NULL AUTO_INCREMENT,
    date DATE,
    status enum('Pending', 'Rehomed'),
    owner_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES owners(id),
)
