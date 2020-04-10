1. Run MySQL and load all sql files in the specific database
	sql files are in folder 'sql'
	database name - files to load 
	customer      - customer.sql
	order         - order.sql
	menu          - menu.sql
	eg . create database name 'customer' , load customer.sql into it

2. Before running payment ms : 
	payment microservice requires => pip install stripe

3. Run all microservices 
	ports
	5000 customer (ms) + db
	5001 menu + db
	5002 order (ms) + db
	5003 payment (ms)
	5672 notification (ms)

4. Start with UI/index.html 
	if you selected outlet :
	username : outlet 
	password : 123
	you are able to complete orders by inputting the order number!

	if you selected customer :
	can check your $$ with ewallet tab and top up from there!
	then feel free to add our BBEZ drinks and pay!	

5. Thank you for using BBEZ!