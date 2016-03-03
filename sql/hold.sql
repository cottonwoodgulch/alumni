/* if password_reset=0,  password is new or has been reset, and 
   the user needs to change it */
alter table contacts
  add password_reset tinyint default 0;

/* holding tables for changes made by general users
     waiting to be checked by sheriff */

/* hold_contacts will only have changed fields */
create table hold_contacts (
  tstamp datetime,
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
  password varchar(255) /*,
    foreign key references contacts(contact_id),
    foreign key references titles(title_id),
    foreign key references degrees(degree_id) */
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
  new_id int(11) primary key auto_increment,
  action enum('D','C','A'),
  tstamp datetime,
  contact_id int (11),
  address_id int(11),
  address_type_id int (11),
  street_address_1 varchar(250),
  street_address_2 varchar(250),
  city varchar(250),
  state varchar(250),
  country varchar(250),
  postal_code varchar(20),
  index (contact_id) /*,
  foreign key (contact_id) references contacts(contact_id)
  foreign key (address_id) references addresses(address_id),
  foreign key (address_type_id) references
    address_types(address_type_id)*/
)engine=innodb;

create table hold_phone (
  new_id int(11) primary key auto_increment,
  action enum('D','C','A'),
  tstamp datetime,
  contact_id int(11),
  phone_id int(11),
  phone_type_id int(11),
  phone_number char(50) /*,
    foreign key references contacts(contact_id),
    foreign key references phones(phone_id),
    foreign key references phone_types(phone_type_id) */
) engine innodb;

create table hold_email (
  new_id int(11) primary key auto_increment,
  action enum('D','C','A'), -- delete, change, add
  tstamp datetime,
  contact_id int (11),
  email_id int(11),
  email_type_id int(11),
  email varchar(250) /*,
    foreign key references contacts(contact_id),
    foreign key references emails(email_id),
    foreign key references emails(email_type_id) */
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
  tstamp datetime,
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
