

CREATE DATABASE utang_system;

use utang_system;

CREATE TABLE IF NOT EXISTS borrowers(
    borrower_id int primary key auto_increment,
    name varchar(250) not null,
    sex enum("male", "female") not null,
    mobile_number varchar(20) not null,
    email varchar(250) not null unique,
    password varchar(250) not null
);


CREATE TABLE IF NOT EXISTS admins(
    admin_id int primary key auto_increment,
    name varchar(250) not null,
    sex enum("male", "female") not null,
    mobile_number varchar(20) not null,
    email varchar(250) not null unique,
    password varchar(250) not null
);


CREATE TABLE Loans (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    borrower_id INT NOT NULL,
    admin_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    start_date DATE NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('paid', 'unpaid', 'overdue') NOT NULL,
    FOREIGN KEY (borrower_id) REFERENCES borrowers(borrower_id),
    FOREIGN KEY (admin_id) REFERENCES admins(admin_id) ON DELETE CASCADE
);


CREATE TABLE sessions_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(admin_id)
);

-- this is the process
-- 1. mag signup si user , papiliin sya kung anong user type
-- 2. if admin granted sya to access the dashboard if borrower maacces nya lang is yung user page
-- containing yung information about the the loan refer to the db loan

-- 3. sa manage-borrower.php , display lahat ng borrower (loop to all borrower table)
-- and every borrower merong add loan button when click pwedeng mag show modal or direct to another page to
-- add loan, sa form (modal, or another page) dito na hihingin yung amount, start_date, due_date, status, yung borrower_id pati admin_id kukunin na yun automatically.
-- loan added!!!!

-- 4. sa manage-loans.php - display all loans (loop to all loans table) and every loan merong update and delete,
-- when clicked same pwedeng show modal using js or next page nalang, then dun na mag poprocess nang update and delete loan
-- (dito sa manageloans.php siguro dito na yung filter, search)
