create database if not exists school_db;

use school_db;

create table if not exists students (
    id int auto_increment primary key,
    full_name varchar(100),
    dob date,
    gender enum('Male','Female','Other'),
    course varchar(50),
    year_level int,
    contact_number varchar(15),
    email varchar(100),
    profile_picture longblob,
    created_at timestamp default CURRENT_TIMESTAMP
);
