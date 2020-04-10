<!-- <?php
    // require_once '../include/protect.php';
    // require_once '../include/common.php';
?> -->
<!DOCTYPE html>
<html>
    <head>
        <title>The Ultimate Bubble Tea | Store</title>
        <meta name="description" content="This is the description">
        <link rel="stylesheet" href="../include/styles.css" />
        <script src="store.js" async></script>

            <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
    </head>
    <body>
        <header class="main-header">
        <nav class="main-nav nav">
                <ul>
                    <li><a href="home.php">MENU</a></li>
                    <li><a href="locations.html">STORE OUTLETS</a></li>
                    <li><a href="wallet.html">WALLET</a></li>
                    <li><a href="notifications.php">NOTIFICATIONS</a></li>
                    <li><a href="../UI">EXIT</a></li>
                </ul>
            </nav>
            <h1 class="store-name store-name-large">The Ultimate Bubble Tea Store</h1>
        </header>
        <div id="main-container" class="container">
            <h1 class="display-4">Order History</h1>
            
            <table id="pendingTable" class='table table-striped' border='1'>

                <thead class='thead-dark'>
                    <tr>
                        <th>OrderID</th>
                        <th>Status</th>

                    </tr>
                </thead>
            </table>
        </div>


<script>

    function showError(message) {
        // Hide the table and button in the event of error

        // Display an error under the main container
        $('#main-container')
            .append("<label>" + message + "</label>");
    }

    // getting order details
    console.log("before fetch")
    $(async () => {
        // Change serviceURL to your own
        
        var serviceURL = "http://127.0.0.1:5002/orders";

        try {
            console.log('fetching');
            const response =
            await fetch(
                serviceURL, {
                method: 'POST',
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ cid : 1})
            });
            
            const data = await response.json();
            var orders = data.orders; //the arr is in data.books of the JSON data
            // array or array.length are falsy
            console.log(orders)
            if (!orders || !orders.length) {
                $('#pendingTable').hide();
                showErrorMain('No orders')

            } else {
                // for loop to setup all table rows with obtained book data
                var rows = "";
                for (const order of orders) {
                    eachRow =
                        "<td>" + order.orderid  + "</td>" +
                        "<td>" + order.status + "</td>" ;
                    rows = "<tbody><tr>" + eachRow + "</tr></tbody>" + rows;
                }
                // add all the rows to the table
                rows += "";
                $('#pendingTable').append(rows);
            }
        } catch (error) {
            // Errors when calling the service; such as network error, 
            // service offline, etc
            showErrorMain
                ('There is a problem retrieving order data, please try again later.<br />' + error);

        } // error
    });
</script>
            
    </body>
</html>