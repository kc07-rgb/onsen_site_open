CREATE TABLE reservation (
    id INT(11) NOT NULL AUTO_INCREMENT,
    checkin DATE NOT NULL,
    checkout DATE NOT NULL,
    adult INT NOT NULL,
    children INT NOT NULL,
    plan VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)