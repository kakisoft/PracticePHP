create database kakidb02

//grant all on dotinstall_sns_php.* to dbuser@localhost identified by 'root';

use kakidb02

create table users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

desc users;