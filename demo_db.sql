-- first you need to create a database called 'demo'. 
-- then run this script on the 'demo' database:

create user demo_user with password 'test123';

drop table if exists users cascade;
create table users (
	id serial primary key,
	name varchar(50) not null,
	login varchar(10) unique not null,
	password char(32) not null	
);
insert into users(name, login, password) values('Demo God', 'test', md5('test'));

drop table if exists pictures cascade;
create table pictures (
	id serial primary key ,	
	filename varchar(1000) not null,	
	label varchar(100) not null
);

drop table if exists locations cascade;
create table locations(
	id serial primary key,
	title varchar(100) not null,
	pretty boolean default false
);

drop table if exists buildings cascade;
create table buildings(
	id serial primary key,
	name varchar(50) not null,
	nr int check (nr > 0),
	picture_id int references pictures(id),
	location_id int not null references locations(id)
);

drop table if exists user_buildings_visited cascade;
create table user_buildings_visited(
	user_id int references users(id),
	building_id int references buildings(id),
	primary key(user_id, building_id)
);

drop table if exists user_location_reviews cascade;
create table user_location_reviews(
	user_id int references users(id),
	location_id int references locations(id),
	rating int not null check(rating between 1 and 10),
	review varchar(1000),
	primary key(user_id, location_id)
);

grant select, insert, update, delete on all tables in schema public to demo_user;
grant usage on all sequences in schema public to demo_user;