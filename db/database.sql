CREATE DATABASE user_list_app;
USE user_list_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    age INT,
    gender VARCHAR(10)
);
