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
  title_id int(11),
  primary_name varchar(250),
  first_name varchar(50),
  middle_name varchar(50),
  degree_id int(11),
  nickname varchar(50),
  birth_date date,
  gender enum('Male','Female'),
  username varchar(255),
  password varchar(255)
) engine innodb;  

/* Hold_address, phone, and email tables will have
     -- action, plus
     -- all fields for add
     -- changed fields for change
     -- contact_id and, phone_, or email_ id for delete
   Address_id will have the existing address_id only for
     delete and change - not yet defined for add
   New_id is necessary to allow undoing add
   */
create table hold_address (
  hold_id int(11) primary key auto_increment,
  action enum('D','C','A'),
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
  action enum('D','C','A'),
  contact_id int(11),
  phone_id int(11),
  phone_type_id int(11),
  number char(50),
  formatted tinyint(4)
) engine innodb;

create table hold_email (
  hold_id int(11) primary key auto_increment,
  action enum('D','C','A'), -- delete, change, add
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
   non-null send_date indicates message has been sent
*/
create table hold_invite (
  message_type enum('I','S'),
  sender_id int(11)
    foreign key references contacts(contact_id),
  target_id int(11)
    foreign key references contacts(contact_id),
  sender_email varchar(250),
  target_email varchar(250),
  subject varchar(250),
  message blob,
  send_date date default null
) engine innodb;

/* scanhold queries */
/* For the add recs (action=A), where there isn't an address_id
   yet, the address_id is set to the negative of the
   auto-increment hold_id */
select h.action,-h.hold_id,
       h.address_type_id,at.address_type,
       h.street_address_1,h.street_address_2,
       h.city,h.state,h.country,h.postal_code
      from hold_address h
      left join address_types at
      on at.address_type_id=h.address_type_id
      where contact_id=?
