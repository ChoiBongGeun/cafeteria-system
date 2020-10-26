<?php
    session_start();
    include("./db_connect.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
    $order_quantity = $_POST['menu'];
    $menu_name = $_POST['menu_name'];
    $menu_no = $_POST['menu_no'];
    $count = 0;
    for($i=0 ; $i < count($_POST['menu']) ; $i++)
    {
            if($order_quantity[$i] == '0') {
                $count = $count + 1;
            }
    }
    if($count == count($_POST['menu'])){
        echo "<script>alert('주문할 메뉴를 선택해주십시요.');</script>";
        echo "<script>history.back();</script>";
    } else {
        $today = date("Y/m/d");
        for($i=0 ; $i < count($_POST['menu']) ; $i++)
        {
            if($order_quantity[$i] > 0) {
                $order_number = mt_rand(1, 10000);
                $query = "insert into orderlist(order_number, menu_no, menu_name, member_id, order_quantity, order_date) 
                    values('".$order_number."', '".$menu_no[$i]."', '".$menu_name[$i]."', '".$_SESSION['id']."', '".$order_quantity[$i]."', '".$today."')";
                $parse = oci_parse($conn, $query);
                oci_execute($parse);
		        oci_commit($parse);
            }
        }
        echo "<script>alert('주문 완료.');</script>";
        echo "<script>location.href='./user_menu.php';</script>";
    }
?>