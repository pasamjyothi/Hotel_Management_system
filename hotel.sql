CREATE DATABASE hotel;
USE hotel;
CREATE TABLE user_queries (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(270) NOT NULL,
    message VARCHAR(500) NOT NULL,
    datentime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    seen TINYINT(4) DEFAULT 0 NOT NULL
);
CREATE TABLE user_details (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(150) NOT NULL
);
CREATE TABLE user_cred (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    phonenum VARCHAR(100) NOT NULL,
    pincode INT(11) NOT NULL,
    dob DATE NOT NULL,
    profile VARCHAR(100) NOT NULL,
    password VARCHAR(200) NOT NULL,
    is_verified INT(11) NOT NULL DEFAULT 0,
    token VARCHAR(200) DEFAULT NULL,
    t_expire DATE DEFAULT NULL,
    status INT(11) NOT NULL DEFAULT 1,
    datentime DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE booking_details (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    booking_id INT(11) NOT NULL,
    room_name VARCHAR(100) NOT NULL,
    price INT(11) NOT NULL,
    total_pay INT(11) NOT NULL,
    room_no VARCHAR(100) NULL,
    user_name VARCHAR(100) NOT NULL,
    phonenum VARCHAR(100) NOT NULL,
    address VARCHAR(150) NOT NULL,
    user_id INT(11) NOT NULL
);

CREATE TABLE booking_order (
    booking_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    room_id INT(11) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    arrival INT(11) NOT NULL DEFAULT 0,
    refund INT(11) NULL,
    booking_status VARCHAR(100) NOT NULL DEFAULT 'pending',
    order_id VARCHAR(150) NOT NULL,
    trans_id INT(200) NOT NULL,
    trans_amt INT(11) NOT NULL,
    trans_status VARCHAR(100) NOT NULL DEFAULT 'pending',
    trans_resp_msg VARCHAR(200) NULL,
    rate_review INT(11) NULL,
    datentime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE facilities (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100) NOT NULL,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(250) NOT NULL
);
CREATE TABLE features (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);
CREATE TABLE rating_review (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    booking_id INT(11) NOT NULL,
    room_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    rating INT(11) NOT NULL,
    review VARCHAR(200) NOT NULL,
    seen INT(11) NOT NULL DEFAULT 0,
    datentime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE TABLE rooms (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    area INT(11) NOT NULL,
    price INT(11) NOT NULL,
    quantity INT(11) NOT NULL,
    adult INT(11) NOT NULL,
    children INT(11) NOT NULL,
    description VARCHAR(250) NOT NULL,
    status TINYINT(4) NOT NULL DEFAULT 1,
    removed INT(11) NOT NULL DEFAULT 0
);
CREATE TABLE rooms_facilities (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    room_id INT(11) NOT NULL,
    facilities_id INT(11) NOT NULL
);

CREATE TABLE rooms_features (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    room_id INT(11) NOT NULL,
    features_id INT(11) NOT NULL
);
CREATE TABLE room_bookings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    room_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    status VARCHAR(200) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE room_images (
    sr_no INT(11) AUTO_INCREMENT PRIMARY KEY,
    room_id INT(11) NOT NULL,
    image VARCHAR(200) NOT NULL,
    thumb TINYINT(4) NOT NULL DEFAULT 0
);
CREATE TABLE contact_details (
    sr_no INT(11) NOT NULL AUTO_INCREMENT,
    address VARCHAR(50) NOT NULL,
    gmap VARCHAR(100) NOT NULL,
    pn1 BIGINT(20) NOT NULL,
    pn2 BIGINT(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    fb VARCHAR(100) NOT NULL,
    insta VARCHAR(100) NOT NULL,
    tw VARCHAR(100) NOT NULL,
    iframe VARCHAR(300) NOT NULL,
    PRIMARY KEY (sr_no)
);
CREATE TABLE admin_cred (
    sr_no INT(11) NOT NULL AUTO_INCREMENT,
    admin_name VARCHAR(150) NOT NULL,
    admin_pass VARCHAR(150) NOT NULL,
    PRIMARY KEY (sr_no)
);
CREATE TABLE settings (
    sr_no INT PRIMARY KEY AUTO_INCREMENT,
    site_title VARCHAR(50),
    site_about VARCHAR(250),
    shutdown BOOLEAN
);
CREATE TABLE team_details (
    sr_no INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    picture VARCHAR(200)
);
ALTER TABLE `rooms_facilities` ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `rooms_facilities` ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `rooms_features` ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `rooms_features` ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `room_bookings` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `room_bookings` ADD FOREIGN KEY (`user_id`) REFERENCES `user_cred`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `booking_details` ADD FOREIGN KEY (`booking_id`) REFERENCES `booking_order`(`booking_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `booking_order` ADD FOREIGN KEY (`user_id`) REFERENCES `user_cred`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `rating_review`
ADD CONSTRAINT `rating_review_ibfk_1`
FOREIGN KEY (`booking_id`) REFERENCES `booking_order`(`booking_id`)
ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `rating_review`
ADD CONSTRAINT `rating_review_ibfk_2`
FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`)
ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `rating_review`
ADD CONSTRAINT `rating_review_ibfk_3`
FOREIGN KEY (`user_id`) REFERENCES `user_cred`(`id`)
ON DELETE RESTRICT ON UPDATE RESTRICT;
 INSERT INTO contact_details 
(`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) 
VALUES 
(
  NULL,
  'Guntur',
  'https://maps.app.goo.gl/VLcta2Hfd5oEUJMb8',
  '9182135861',
  '9248564321',
  'hotel23@gmail.com',
  'https://www.facebook.com/',
  'https://www.instagram.com/',
  'https://x.com/?lang=en-in',
  'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2163.944271816219!2d80.4393428172145!3d16.3212222774093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a35f54c60ab7d1d%3A0x8c86e4f3469a336b!2sVasireddy%20Venkatadri%20International%20Technological%20University!5e0!3m2!1sen!2sin!4v1753881577029!5m2!1sen!2sin'
);
INSERT INTO admin_cred (admin_name, admin_pass)
VALUES ('pasamjyothi23@gmail.com', 'prudhvi25');
INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`)
VALUES (1, 'Green Park Resort', 'A luxury beach resort offering calm, peace, and premium service.', NULL);


