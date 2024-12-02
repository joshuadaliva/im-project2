

CREATE DATABASE utang_system;

use utang_system;

CREATE TABLE IF NOT EXISTS users(
    id int primary key auto_increment,
    name varchar(250) not null,
    email varchar(250) not null unique,
    password varchar(250) not null,
    user_type enum("user", "admin") not null,
    created_at timestamp default current_timestamp
);