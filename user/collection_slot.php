<?php
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    $day = $_POST['date'];
    $time = $_POST['time'];
    $cart_id = $_SESSION['cart_id'];
    
    // Validate the input
    if (empty($day) || empty($time)) {
        echo"<script>alert('Please select a valid day and time slot.');</script>)";
        exit;
    }
    else
    {
        echo"<script>alert('Slot selected.');</script>)";
    }

    $datetime = new DateTime($day);
    $dayOfWeek = $datetime->format('l');
    $daytime_format = $datetime -> format("y-m-d");
    
    $selectedDay = new DateTime($day);
    $currentDay = new DateTime();
    $currentDay->setTime(0, 0, 0);
    
    $diff = $selectedDay->diff($currentDay)->format('%a');
    if ($diff < 1) {
        echo"<script>alert('Please select a day at least 24 hours from now.');</script>)";
        exit;
    }
    
    $_SESSION['date'] = $day;
    $_SESSION['day'] = $dayOfWeek;
    $_SESSION['time'] = $time;

    // Fetch or insert the collection slot
    $query = "SELECT COLL_SLOT_ID FROM COLLECTION_SLOT WHERE SLOT_DATE = TO_DATE(:day, 'YYYY-MM-DD') AND TIME_DETAILS = :time";
    $statement = oci_parse($conn, $query);
    oci_bind_by_name($statement, ':day', $daytime_format);
    oci_bind_by_name($statement, ':time', $time);
    oci_execute($statement);

    $collection_slot = oci_fetch_assoc($statement);
    if (!$collection_slot) {
        $insertQuery = "INSERT INTO COLLECTION_SLOT (SLOT_DATE, DAY_DETAILS, TIME_DETAILS,CART_ID) VALUES (TO_DATE(:day, 'RRRR-MM-DD'), :dayOfWeek, :time, :cart_id) RETURNING COLL_SLOT_ID INTO :collection_slot_id";
        $insertStatement = oci_parse($conn, $insertQuery);
        oci_bind_by_name($insertStatement, ':day',  $daytime_format);
        oci_bind_by_name($insertStatement, ':dayOfWeek', $dayOfWeek);
        oci_bind_by_name($insertStatement, ':time', $time);
        oci_bind_by_name($insertStatement, ':cart_id',  $cart_id);
        oci_bind_by_name($insertStatement, ':collection_slot_id', $collection_slot_id, -1, SQLT_INT);
        oci_execute($insertStatement);
    } else {
        $collection_slot_id = $collection_slot['COLL_SLOT_ID'];
    }

    // Check for the maximum number of orders
    $query = "SELECT COUNT(*) AS ORDER_COUNT FROM ORDERDETAIL WHERE COLL_SLOT_ID = :collection_slot_id";
    $statement = oci_parse($conn, $query);
    oci_bind_by_name($statement, ':collection_slot_id', $collection_slot_id);
    oci_execute($statement);
    
    $orderCount = 0;
    if ($row = oci_fetch_assoc($statement)) {
        $orderCount = $row['ORDER_COUNT'];
    }
    
    if ($orderCount >= 20) {
        die('This time slot is fully booked. Please select another slot.');
        exit;
    }
    
    // At this point, you would typically update the ORDERDETAIL table to assign this slot to the user's order
    // For example:
    // $updateOrderQuery = "UPDATE ORDERDETAIL SET COLLECTION_SLOT_ID = :collection_slot_id WHERE CART_ID = :cart_id";
    // $updateOrderStatement = oci_parse($conn, $updateOrderQuery);
    // oci_bind_by_name($updateOrderStatement, ':collection_slot_id', $collection_slot_id);
    // oci_bind_by_name($updateOrderStatement, ':cart_id', $cart_id);
    // oci_execute($updateOrderStatement);

    oci_close($conn);

    header('Location: checkout.php');
    exit;
} else {
    die('Invalid request method.');
}
?>
