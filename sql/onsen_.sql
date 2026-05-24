CREATE TABLE onsen_hotel_site_table (
    id INT(11) NOT NULL AUTO_INCREMENT,
    comment TEXT NOT NULL,
    title VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    image_name VARCHAR(255) DEFAULT NULL,
    category VARCHAR(20) NOT NULL DEFAULT "info",
    PRIMARY KEY (id)
);