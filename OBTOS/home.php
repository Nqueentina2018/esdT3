<!-- Note: the items here are not sent to payment -->

<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "files to load");
$total = 0;
if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="home.php"</script>';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
	<head>
        <title>The Ultimate Bubble Tea | Store</title>
        <meta name="description" content="This is the description">
        <link rel="stylesheet" href="../include/styles.css" />
        <script src="store.js" async></script>
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<br />
			<br />
			<br />

			<?php
				$query = "SELECT * FROM menu ORDER BY id ASC";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-4">
				<form method="post" action="home.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<h4 class="text-info"><?php echo $row["name"]; ?></h4>

						<h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

					</div>
				</form>
			</div>
			<?php
					}
				}
			?>
			<div style="clear:both"></div>
			<br />
			<h3>Order Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Item Name</th>
						<th width="10%">Quantity</th>
						<th width="20%">Price</th>
						<th width="15%">Total</th>
						<th width="5%">Action</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td>$ <?php echo $values["item_price"]; ?></td>
						<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="home.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">$ <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
					<?php
					}
					?>
						
				</table>
			</div>
		</div>
	</div>
    <br />

    </div>
    <style>
    .btn-purchase{
        margin-left: 80%;
        border-color: red;
        background-color: white;
        border-radius: 12px;
        padding: 12px 28px;
    }
    .btn-purchase:hover {
    background-color: red;
    color: white;
    }
    </style>
	<form id='payment' action='loader.html' method ="POST">
            <input name='totalAmt' type='hidden' id='totalAmt' value = <?php echo $total; ?>>
            <input name='cid' type='hidden' id='cid' value = 1>
            <input type='submit' value='Purchase' class='btn-purchase'>
            </form>
        </section></div>


        <script>
            // Helper function to display error message
            function showError(message) {
                // Hide the table and button in the event of error
                $('#drinksTable').hide();
                
    
                // Display an error under the main container
                $('#main-container')
                    .append("<label>" + message + "</label>");
            }
    
            
            // getting drinks
            $(async () => {
                // Change serviceURL to your own
                
                var serviceURL = "http://127.0.0.1:5001/menu/drink";
    
                try {
                    const response =
                        await fetch(
                            serviceURL, { method: 'GET' }
                        );
                    const data = await response.json();
                    var drinks = data.menu; //the arr is in data.books of the JSON data
    
                    // array or array.length are falsy
                    if (!drinks || !drinks.length) {
                        showError('drinks list empty or undefined.')

                    } else {
                        // for loop to setup all table rows with obtained book data
                        var rows = "";
                        for (const drink of drinks) {
                            eachRow =
                                "<td>" + drink.name  + "</td>" +
                                "<td>" + drink.price + "</td>"+
                                "<td><button class='btn btn-primary shop-item-button' type='button'>ADD TO CART</button></td>";
                            rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
                        }
                        // add all the rows to the table
                        $('#drinksTable').append(rows);
                    }
                } catch (error) {
                    // Errors when calling the service; such as network error, 
                    // service offline, etc
                    showError
                        ('There is a problem retrieving drinks data, please try again later.<br />' + error);
    
                } // error
            });

            // getting toppings
            $(async () => {
                // Change serviceURL to your own
                
                var serviceURL = "http://127.0.0.1:5001/menu/topping";
    
                try {
                    const response =
                        await fetch(
                            serviceURL, { method: 'GET' }
                        );
                    const data = await response.json();
                    var toppings = data.menu; 
    
                    // array or array.length are falsy
                    if (!toppings || !toppings.length) {
                        showError('drinks list empty or undefined.')

                    } else {
                        // for loop to setup all table rows with obtained book data
                        var rows = "";
                        for (const topping of toppings) {
                            eachRow =
                                "<td>" + topping.name  + "</td>" +
                                "<td>" + topping.price + "</td>"+
                                "<td><button id='add' type='button' value='"+topping.name+"'>ADD TO CART</button></td>";
                            rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
                        }
                        // add all the rows to the table
                        $('#toppingsTable').append(rows);
                    }
                } catch (error) {
                    // Errors when calling the service; such as network error, 
                    // service offline, etc
                    showError
                        ('There is a problem retrieving toppings data, please try again later.<br />' + error);
    
                } // error
            });


            $("#payment").submit(async (event) => {
            // event.preventDefault();
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
                            body: JSON.stringify({cid : cid ,totalAmt : totalAmt}),
                        });
                console.log(response)
                let data = await response.json();
                if (response.ok) {
                    console.log(data);
                    window.location.href = "loader.html";
                }

            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
                    ('There is a problem retrieving payment data, please try again later.<br />' + error);

            } // error
        });

        </script>
        

	</body>
</html>

<?php
//If you have use Older PHP Version, Please Uncomment this function for removing error 

/*function array_column($array, $column_name)
{
	$output = array();
	foreach($array as $keys => $values)
	{
		$output[] = $values[$column_name];
	}
	return $output;
}*/
?>