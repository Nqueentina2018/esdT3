Sorry, i know not great to commit buggy codes ... but

Needs fixing / errors

1. process_login.php validation for customer

2. wallet.php  supposed to link to customer id (name) to show that it’s logged in
	Supposed to link to payment to show ewallet balance  
	Topup button has some probs linking to payment (i'm not sure what href to use)

3. wallet is supposed to be password protected but that is currently commented out so it can be accessed and can see the errors


4. Created a class and database for outlet so that we can know which outlet and tie to an outlet id, 
the idea is that when the outlet logs in, we will know the outlet id. (e.g., username:/id outlet1, password: outlet, name: Changi outlet)

Currently, Outlet UI is not password protected, but can easily be using the same login.php for the customer

Min