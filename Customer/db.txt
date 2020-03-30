create table customer
(id int not null primary key,
 name varchar(15) not null,
 phone varchar(10) not null,
 ewallet double not null);

 INSERT INTO `customer` (`id`, `name`, `phone` , `ewallet`) VALUES
(1, 'Tiffany TAN', '91234567', 1000),
(2, 'Bobo Lim', '81234567' , 5),
(3, 'Teeto Mo', '87654321' , 10);