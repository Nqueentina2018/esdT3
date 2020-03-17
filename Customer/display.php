<?php

require_once 'CustDAO.php';
$dao = new CustDAO();

// if (isset($_POST['Status'])){
//     $cats=$dao->getCatsByStatus($_POST['Status']);
//     }
// else{
//     $cats = $dao->getCatsByStatus('A');
// }
// var_dump($_POST);

$customers = $dao->getCust();
?>
<html>
<body>

    <h1>Our Customers</h1>

    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Ewallet</th>
        </tr>

        <?php
        foreach($customers as $customer) {
            // YOUR CODE GOES HERE
            echo "<tr>
            <td>{$customer->getId()}</td>
            <td>{$customer->getName()}</td>
            <td>{$customer->getPhone()}</td>
            <td>{$customer->getEwallet()}</td>";
            echo "</tr>";
        }
        ?>

    </table>

</body>
</html>