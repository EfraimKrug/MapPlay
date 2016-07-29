-- sql for children's Hospital
--
--
DROP TABLE area_reports;
DROP TABLE areas;
DROP TABLE reports;
DROP TABLE reporters;

CREATE TABLE areas (
    id int(5) auto_increment primary key,
    area_name varchar(35) not null,
    lat decimal(6,3) signed,
    lng decimal(6,3) signed
);

CREATE TABLE reporters (
    id int(5) auto_increment primary key,
    name varchar(25)
);

CREATE TABLE reports (
    id int(5) auto_increment primary key,
    reporter_id int(5) not null,
    constraint fk_reporter_id foreign key (reporter_id) references reporters(id),
    symptom_1 tinyint(1) default 0,
    symptom_2 tinyint(1) default 0,
    symptom_3 tinyint(1) default 0,
    symptom_4 tinyint(1) default 0,
    symptom_5 tinyint(1) default 0
);

CREATE TABLE area_reports (
    area_id int(5) not null,
    constraint fk_area_id foreign key (area_id) references areas (id),
    report_id int(5) not null,
    constraint fk_report_id foreign key (report_id) references reports (id)
);

-- parsons

insert into areas values (1, 'parsons', 42.337, -71.115);
insert into reporters values (1, 'george');
insert into reporters values (2, 'sally');
insert into reporters values (3, 'william');
insert into reporters values (4, 'bartholomew');

insert into reports values (1, 1, true, false, true, false, false);
insert into reports values (2, 2, true, true, true, true, true);
insert into reports values (3, 3, true, true, true, true, true);
insert into reports values (4, 4, true, false, true, false, true);

insert into area_reports values (1,1);
insert into area_reports values (1,2);
insert into area_reports values (1,3);
insert into area_reports values (1,4);

-- childrens

insert into areas values (2, 'childrens', 42.337, -71.105);

insert into reporters values (5, 'monica');
insert into reporters values (6, 'sudhir');

insert into reports values (5, 5, true, false, true, false, false);
insert into reports values (6, 6, true, true, true, true, true);

insert into area_reports values (2,1);
insert into area_reports values (2,2);
