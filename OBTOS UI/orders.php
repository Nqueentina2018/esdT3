<!DOCTYPE html>
<html>
    <head>
        <title>The Ultimate Bubble Tea | Store</title>
        <meta name="description" content="This is the description">
        <link rel="stylesheet" href="../include/styles.css" />
        <!-- <script src="store.js" async></script> -->

        
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
        <?php
        $_POST['']
        ?>

        <header class="main-header">
            <nav class="main-nav nav">
                <ul>
                    <li><a href="menu.html">MENU</a></li>
                    <li><a href="locations.html">STORE OUTLETS</a></li>
                    <li><a href="wallet.php">WALLET</a></li>
                    <li><a href="notifications.php">NOTIFICATIONS</a></li>
                </ul>
            </nav>
            <h1 class="store-name store-name-large">The Ultimate Bubble Tea Store</h1>
        </header>
        <div id="main-container" class="container">
            <h1 class="display-4">Orders Pending</h1>
            
            <table id="pendingTable" class='table table-striped' border='1'>

                <thead class='thead-dark'>
                    <form id='payment' action='orders.html' method="POST">
                    <input name='totalAmt' type='hidden' id='totalAmt' value = 5>
                    <input name='cid' type='hidden' id='cid' value = 1>
                    <input name='sid' type='hidden' id='sid' value = 1>
                    <input type='submit' value='Purchase'>
                    </form><Br><br>
                </thead>
            </table>
        </div>

        <script>
            // Helper function to display error message
            function showErrorMain(message) {
                // Hide the table and button in the event of error
                $('#pendingTable').hide();
                
    
                // Display an error under the main container
                $('#main-container')
                    .append("<label>" + message + "</label>");
            }
    
            // anonymous async function 
            // - using await requires the function that calls it to be async
            
            // getting confirmed orders

            $("#payment").submit(async (event) => {
            event.preventDefault();
            var cid = $('#cid').val();
            var sid = $('#sid').val();
            var totalAmt = $('#totalAmt').val();
            var serviceURL = "http://127.0.0.1:5003/payment" ;
            // console.log(serviceURL);

            try {
                console.log(JSON.stringify({cid : cid ,totalAmt : totalAmt}))
                
                let response =
                    await fetch(
                        serviceURL,
                        {
                            method: 'POST',
                            headers: { "Content-Type": "application/json"  }, 
                            body: JSON.stringify({cid : cid , sid : sid ,totalAmt : totalAmt}),
                        });
                console.log(response)
                let data = await response.json();
                if (response.ok) {
                    console.log(data);
                    window.location.href = "paymenttest.html";
                }

            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
                    ('There is a problem retrieving books data, please try again later.<br />' + error);

            } // error
        });


        </script>
        
    </body>
</html>