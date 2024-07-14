<?php
include 'includ/header.php';
$sql_admins = "SELECT * FROM admins";

$stmt = $conn->prepare($sql_admins);
$stmt->execute();
$result_admins = $stmt->get_result();
$stmt->close();

$row_admins = $result_admins->fetch_assoc();
$lang_file = 'langs/lang_' . $row_admins['lang'] . '.php';
if (file_exists($lang_file)) {
    include($lang_file);
}
$wizwiz_db = new wizwiz_db;
include 'admin-menu.php';
?>
<div class="flex flex-col flex-1 w-full">
    <?php include 'includ/top-header.php'; ?>
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto ">
            <a style="font-size: 20px;" class="text-xs font-semibold tracking-wide text-left text-gray-500 0 dark:text-gray-400 inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="ml-4"><?php echo $_LANG['Orders'] ?></span>
                <?php session_notif_wizwiz(); ?>
            </a>
            <div class="grid gap-6 mb-8 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2">
                <?php order_on($conn);order_off($conn);order_delete($conn); ?></div>
            <div>
                <nav aria-label="Page navigation example"><?php echo $wizwiz_db->generatePagination('orders_list');?></nav>
            </div>

            <div class="shadow-xl min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 text-xs font-semibold tracking-wide text-left text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <div class="w-full overflow-x-auto  text-center">
                    <table class="w-full whitespace-no-wrap  text-center">
                        <thead class="">
                            <tr class="text-xs text-center font-semibold tracking-wide text-left text-gray-500 dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-700">
                                <th class="px-4 py-3"><?php echo $_LANG['id'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['user'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['remark'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['protocol'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['Date'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['price'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['status'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['delete'] ?></th>
                            </tr>
                        </thead>
                        <tbody class='bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center'>
                            <?php
                            $orders_list_select = $wizwiz_db->loop("orders_list" );
                            if (is_array($orders_list_select) || is_object($orders_list_select)) {
                                foreach ($orders_list_select as $value ) :
                                    $timestamp = $value["expire_date"];
                                    $date = jdate('Y-m-d H:i:s', $timestamp);
                                    echo '<tr class="text-gray-700 dark:text-gray-400">';
                                    echo '<td class="" style="font-size: 12px;color: #de2038;">' . $value["id"] . '</td>';
                                    echo '<td class="px-4 py-3 text-sm">' . $value["userid"] . '</td>';
                                    echo '<td class="px-4 py-3 text-sm">' . $value["remark"] . '</td>';
                                    echo '<td class="px-4 py-3 text-sm">' . $value["protocol"] . '</td>';
                                    echo '<td class="px-4 py-3 text-sm">' . $date . '</td>';
                                    echo '<td class="px-4 py-3 text-sm">' . number_format($value["amount"]) . '</td>';
                                    if ($value['status'] == '1') {
                                        echo '<td class="px-4 py-3 text-sm"><a href="orders.php?off=' . $value['id'] . '">
<div class="flex items-center justify-center space-x-4 text-sm ">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="m-2" width="27" fill="#a1c181"><path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z"/><circle cx="12" cy="12" r="4"/></svg>
                    </a>
                    </div>
                    </td>';
                                    } else {
                                        echo '<td class="px-4 py-3 text-sm "><a href="orders.php?on=' . $value['id'] . '">
<div class="flex items-center justify-center space-x-4 text-sm ">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="m-2" width="27" fill="#6c757d"><path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z"/><circle cx="12" cy="12" r="4"/></svg>
                    </a>
                    </div>
                    </td>';
                                    }
                                    echo '<td class="px-4 py-3">';
                                    echo '<div class="flex items-center justify-center space-x-4 text-sm ">';
                                    echo '<button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">';
                                    echo '<a href="orders.php?delete=' . $value["id"] . '" >';
                                    echo '<svg fill="gray" xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>';
                                    echo '</a>';
                                    echo '</button>';
                                    echo '</div>';
                                    echo '</td>';
                            ?>
                            <?php
                                    echo '</tr>';
                                endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
            <nav aria-label="Page navigation example"><?php echo $wizwiz_db->generatePagination('orders_list');?></nav>
            </div>
        </div>
    </main>
</div>
</div>
<?php
include 'includ/footer.php';
?>