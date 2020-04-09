ports
5000 customer
5001 menu
5002 order
5003 payment
5672 notification

each microservice sql db is in their specific folders

database name - files to load 
customer      - customer.sql
order         - order.sql
menu          - menu.sql

payment microservice requires => pip install stripe