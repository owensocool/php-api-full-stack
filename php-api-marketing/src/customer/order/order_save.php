<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/view/signIn.html");
    exit();
}

$user_id = $_SESSION['user_id'];
include_once '../../../config/db/connection.php';
require_once('../order/order_operator.php');

//get order more
$shipping_cost = 50;
$vat = 0.07;
$message = '';

$totalAmount = 0;
$totalPrice = 0;
$order_status = 'Order'; //default

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //get customer data
    $customer_id = $_POST['customer_id'];
    $name_order = $_POST['name_order'];
    $name_receive = $_POST['name_receive'];
    $email= $_POST['email'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $name_bill = $_POST['name_bill'];
    $tax_no=isset($_POST['tax_no']) ? $_POST['tax_no'] : null;

    #get date
    $order_date = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS
    $shipping_date = date('Y-m-d H:i:s', strtotime('+7 days'));
    $receive_date = date('Y-m-d H:i:s', strtotime('+10 days'));
    
    //gen order_id
    $order_id = 'ORD'.uniqid();
    $order_id_validate = getOrder_id($order_id);
    while ($order_id == $order_id_validate){
            $order_id = 'ORD'.uniqid();
            $order_id_validate = getOrder_id($order_id);
            if($order_id != $order_id_validate){
                break;
            }
    }

    //Prepare to save on Order
    $insertOrderQuery = "INSERT INTO orders (order_id, customer_id, name_order, name_receive, name_bill, tax_no, address, tel, order_date, shipping_date, receive_date, amount, shipping_cost, vat, total_price, order_status, last_update) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, CURRENT_TIMESTAMP)";
    $stmtInsertOrder = $conn->prepare($insertOrderQuery);
    
    // Check if products are selected
        if (isset($_POST['cart_items'])) {
            $cartItems = json_decode($_POST['cart_items'], true);

           foreach ($cartItems as $cartItem) {
                $productId = $cartItem['product_id'];

                //find stock in product Id
                $row = findStock($productId);

                $product_stock_found = $row[0]['product_stock'];
                $product_status = $row[0]['product_status'];

                $totalAmount += $cartItem['quantity'];
                $totalPrice += $cartItem['product_price'] * $cartItem['quantity'];

                $quantity = $cartItem['quantity'];
                $totalPrice1 = $cartItem['product_price'] * $cartItem['quantity'];

                $stock = $product_stock_found - $cartItem['quantity'];

                if($stock == 0){
                    $product_status = "out_stock";
                }

                //update product
                $stmt = $conn->prepare("UPDATE products SET product_stock=?,product_status=?, last_update=CURRENT_TIMESTAMP WHERE product_id = ?");
                $stmt->bind_param("iss",$stock,$product_status,$productId);
                if ($stmt->execute()) {
                    echo "Update data for product ID = <span style='color:red;'> '$productId' </span> is Successful.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();


                // Insert into detail table
                    $insertDetailQuery = "INSERT INTO detail (order_id, product_id, amount, total_price, last_update) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
                    $stmtInsertDetail = $conn->prepare($insertDetailQuery);
                    $stmtInsertDetail->bind_param("ssds", $order_id, $productId, $quantity, $totalPrice1);
                    $stmtInsertDetail->execute();
                    $stmtInsertDetail->close();



                    // Delete item from cart
                    $deleteCartItemQuery = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
                    $stmtDeleteCartItem = $conn->prepare($deleteCartItemQuery);
                    $stmtDeleteCartItem->bind_param("ss", $user_id, $productId);
                    $stmtDeleteCartItem->execute();
                    $stmtDeleteCartItem->close();
            }
            
        }

    $totalPriceWithShipping = $totalPrice + $shipping_cost;

    //Save customer and detail in Orders
    //order_id, customer_id, name_order, name_receive, name_bill, tax_no, address, tel, order_date, shipping_date, receive_date, amount, shipping_cost, vat, total_price, order_status
    $stmtInsertOrder->bind_param("sssssssssssdddds", $order_id, $customer_id, $name_order, $name_receive, $name_bill,$tax_no,$address,$tel,$order_date,$shipping_date,$receive_date, $totalAmount, $shipping_cost,$vat, $totalPriceWithShipping,$order_status);
    $stmtInsertOrder->execute();
    $stmtInsertOrder->close();
    $message = 'success';
    $conn->close();

    if ($message == 'success'){
        // Redirect or display a success message as needed
        header("Location: order_list.php");
        exit();
    }

}

?>
