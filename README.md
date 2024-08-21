mysql

CREATE DATABASE aptech_midterm_tuthinh;

USE aptech_midterm_tuthinh;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(255) NOT NULL,
    book_numbers INT DEFAULT 0
);

CREATE TABLE categories (
    category_name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT,
    category_name VARCHAR(255),
    publisher VARCHAR(255),
    publish_year YEAR,
    quantity INT,
    FOREIGN KEY (author_id) REFERENCES authors(id)
);
