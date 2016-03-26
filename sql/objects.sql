/* address */
select a.address_id,a.address_type_id,at.address_type,
       a.street_address_1,a.street_address_2,
       a.city,a.state,a.country,a.postal_code,' ' status
  from address_associations aa
  left join addresses a
    on a.address_id=aa.address_id
  left join address_types at
    on at.address_type_id=a.address_type_id
 where aa.contact_id=?
 order by at.rank

/* phone */
select p.phone_id,pt.p.phone_type_id,phone_type,
       p.number,p.formatted,' ' status
  from phone_associations pa
  left join phones p
    on p.phone_id=pa.phone_id
  left join phone_types pt
    on pt.phone_type_id=p.phone_type_id
 where pa.contact_id=?
 order by pt.rank

/* email */
select e.email_id,e.email_type_id,et.email_type,
       e.email,' ' status
  from email_associations ea
 inner join emails e
   on e.email_id=ea.email_id
  left join email_types et
    on et.email_type_id=e.email_type_id
 where ea.contact_id=?
 order by et.rank

/* user */
select c.contact_id,ifnull(c.title_id,0) title_id,
       t.title,c.first_name,c.middle_name,c.primary_name,c.nickname,
       ifnull(c.degree_id,0) degree_id,
       d.degree,c.birth_date,ifnull(c.gender,'') gender
  from contacts c
  left join titles t
    on t.title_id=c.title_id
  left join degrees d
    on d.degree_id=c.degree_id
 where contact_id=?
 
 /* address, phone, email */
   left join hold_address had
     on ha.
