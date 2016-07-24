/* if password_reset=0,  password is new or has been reset, and 
   the user needs to change it */
alter table contacts
  add password_reset tinyint default 0;

/* holding tables for changes made by general users
     waiting to be checked by sheriff */

/* hold_contacts will only have one record for each
     contact_id. Additional changes overwrite the previous
     record */
create table hold_contact (
  contact_id int (11),
  user_id int(11),
  title_id int(11),
  primary_name varchar(250),
  first_name varchar(50),
  middle_name varchar(50),
  degree_id int(11),
  nickname varchar(50),
  birth_date date,
  gender enum('Male','Female')
) engine innodb;  

create table hold_address (
  hold_id int(11) primary key auto_increment,
  user_id int(11),  -- who proposed the change
  action enum('D','C','A'), -- delete, change, add
  contact_id int (11),
  address_id int(11),
  address_type_id int (11),
  street_address_1 varchar(250),
  street_address_2 varchar(250),
  city varchar(250),
  state varchar(250),
  country varchar(250),
  postal_code varchar(20)
)engine=innodb;

create table hold_phone (
  hold_id int(11) primary key auto_increment,
  user_id int(11),
  action enum('D','C','A'),
  contact_id int(11),
  phone_id int(11),
  phone_type_id int(11),
  number char(50),
  formatted tinyint(4)
) engine innodb;

create table hold_email (
  hold_id int(11) primary key auto_increment,
  user_id int(11),
  action enum('D','C','A'),
  contact_id int (11),
  email_id int(11),
  email_type_id int(11),
  email varchar(250)
) engine innodb;

/* hold_invite and hold_send tables will hold e-mails
   while database is off-line
   For Invite
     -- system compares sender_email to database, and
        creates a hold_email rec if different
     -- user provides e-mail address
   For Send
     -- system compares sender_email to database, and
        creates a hold_email rec if different
     -- system creates records for each target address
        in the database
   e-mail type 3, and user id 0 are for hold recs created when
     a user provides an e-mail address for self or a target
*/
create table hold_msg (
  hold_msg_id int(11) primary key auto_increment,
  msg_type enum('invite','send'),
  user_id int(11),
  target_id int(11),
  user_email varchar(250),
  subject varchar(250),
  message text
) engine innodb;

create table hold_target (
  hold_target_id int(11) primary key auto_increment,
  hold_msg_id int(11),
  target_email varchar(250)
) engine innodb;

insert into email_types values (3,'Alumni',3);
