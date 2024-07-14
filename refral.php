<?php
include 'includ/header.php';
?>
<?php
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
include 'admin-menu.php';
?>

<div class="flex flex-col flex-1 w-full">
    <?php
    include 'includ/top-header.php';
    ?>
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto ">

            <a style="font-size: 20px" class="text-xs font-semibold tracking-wide text-left text-gray-500 0 dark:text-gray-400 inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" fill="gray" data-name="Layer 1" viewBox="0 0 24 24" width="21" height="21">
                    <path d="M12,9C17.934,8.844,17.933,.155,12,0c-5.934,.156-5.933,8.845,0,9Zm0-7c3.286,.059,3.285,4.942,0,5-3.285-.059-3.285-4.942,0-5Zm10.204,9.162c-1.143-.953-2.64-1.347-4.099-1.081l-3.821,.695c-.913,.166-1.707,.634-2.284,1.289-.578-.655-1.371-1.123-2.285-1.289l-3.821-.695c-1.461-.264-2.956,.128-4.098,1.081-1.142,.953-1.796,2.352-1.796,3.839v2.793c0,2.417,1.727,4.486,4.106,4.919l6.284,1.143c1.068,.194,2.151,.194,3.219,0l6.285-1.143c2.379-.433,4.105-2.502,4.105-4.919v-2.793c0-1.487-.654-2.886-1.796-3.838Zm-11.204,10.767c-.084-.012-.168-.026-.252-.041l-6.284-1.143c-1.428-.26-2.464-1.501-2.464-2.952v-2.793c0-.892,.393-1.731,1.078-2.303,.685-.573,1.59-.808,2.459-.648l3.821,.695c.952,.173,1.642,1,1.642,1.968v7.217Zm11-4.135c0,1.451-1.036,2.692-2.463,2.952l-6.285,1.143c-.084,.015-.168,.029-.252,.041v-7.217c0-.967,.69-1.795,1.642-1.968l3.821-.695c.875-.16,1.774,.077,2.46,.648,.685,.572,1.077,1.411,1.077,2.303v2.793Z" />
                </svg>
                <span class="ml-4"><?php echo $_LANG['Pays'] ?></span>
                <?php session_notif_wizwiz() ?>
            </a>

            <?php
            $sql1 = "SELECT * FROM pays ORDER BY id DESC LIMIT 10";
            $stmt = $conn->prepare($sql1);
            $stmt->execute();
            $result1 = $stmt->get_result();
            $stmt->close();
            echo '
                <div style="margin-top:40px" class="shadow-lg min-w-0 p-4 bg-white rounded-lg dark:bg-gray-800 text-xs font-semibold tracking-wide text-left text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap" >
                <thead>
                <tr class="text-center text-xs font-semibold tracking-wide text-left text-gray-500 dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3"></th>
                    <th class="px-4 py-3">' . $_LANG['hash'] . '</th>
                    <th class="px-4 py-3">' . $_LANG['plan'] . '</th>
                    <th class="px-4 py-3">' . $_LANG['price'] . '</th>
                    <th class="px-4 py-3">' . $_LANG['date'] . '</th>
                    <th class="px-4 py-3">' . $_LANG['status'] . '</th>
                </tr>
                </thead>
                                ';
            echo '<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center" >';
            while ($row1 = $result1->fetch_assoc()) {
                $id_server_d = $row1["id"];
                $plan_id_d = $row1["plan_id"];
                $timestamp = $row1["request_date"];
                $date = jdate('Y-m-d H:i:s', $timestamp);
                $number_order = number_format($row1["price"]);

                $sql_plans = "SELECT * FROM server_plans where id=? limit 10";
                $stmt = $conn->prepare($sql_plans);
                $stmt->bind_param('i', $plan_id_d);
                $stmt->execute();
                $result_plans = $stmt->get_result();
                $stmt->close();

                while ($row_plans = $result_plans->fetch_assoc()) {
                    $id_plans = $row_plans["title"];
                }
                echo '<tr class="text-gray-700 dark:text-gray-400">';
                echo '<td class="px-4 py-3">';
                echo '<div class="flex items-center text-sm ">';
                echo '<div class="relative hidden w-8 h-8 mr-3 mt-2 rounded-full md:block" >';
                echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="gray" version="1.1" id="Outline" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="20" height="20">
<path d="M354.773,61.867c-16.789-14.229-34.389-29.184-52.309-45.483C288.717,3.882,270.151-1.912,251.733,0.555  c-17.848,2.358-33.728,12.517-43.349,27.733c-25.43,42.496-43.41,89.025-53.163,137.579c-3.827-5.526-7.222-11.338-10.155-17.387  c-10.104-21.288-35.552-30.355-56.84-20.251c-5.154,2.446-9.765,5.901-13.56,10.16c-35.783,36.566-55.62,85.821-55.168,136.981  c-1.017,107.532,71.314,201.943,175.403,228.95c19.367,4.873,39.251,7.394,59.221,7.509c0.64,0,7.445-0.064,10.197-0.256  c127.36-4.125,228.426-108.648,228.267-236.075C492.501,178.859,428.672,124.672,354.773,61.867z M253.589,469.013  c-15.877-1.208-31.567-7.639-43.413-17.195c-18.55-13.126-30.825-32.374-33.749-54.549c-3.627-34.603,17.707-79.851,61.291-130.965  l0,0c4.57-5.338,11.256-8.397,18.283-8.363l0,0c6.936-0.05,13.532,3.001,17.984,8.32c39.936,47.403,61.867,91.136,61.867,123.157  c-0.123,42.07-33.006,75.35-74.88,79.403C259.133,468.999,256,469.269,253.589,469.013z M374.955,428.437  c-1.259,0.981-2.645,1.771-3.925,2.709c4.922-13.378,7.457-27.516,7.488-41.771c0-53.909-39.147-111.68-71.957-150.656  c-12.553-14.867-31.017-23.451-50.475-23.467H256c-19.497-0.035-38.028,8.49-50.688,23.317l0,0  c-52.16,61.099-76.117,115.989-71.211,163.157c1.165,10.95,3.962,21.664,8.299,31.787c-50.658-36.706-80.507-95.587-80.171-158.144  c-0.412-40.639,15.614-79.721,44.437-108.373c4.921,10.23,10.83,19.954,17.643,29.035c9.357,12.65,25.342,18.52,40.661,14.933  c15.619-3.455,27.746-15.774,30.955-31.445c8.571-45.304,24.95-88.774,48.405-128.469c2.886-4.538,7.653-7.544,12.992-8.192  c5.967-0.803,11.982,1.08,16.427,5.141c18.304,16.64,36.267,32,53.333,46.443c71.211,60.48,122.688,104.171,122.688,181.056  c0.184,59.833-27.436,116.358-74.752,152.981L374.955,428.437z"/>
</svg>
';
                echo '</div>';
                echo '<div>';
                echo '<p class="text-xs text-gray-600 dark:text-gray-400">' . $row1["user_id"] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '<td class="px-4 py-3 text-sm" style="font-size: 13px !important;">' . $row1["hash_id"] . '</td>';
                if (isset($id_plans)) {
                    echo '<td class="px-4 py-3 text-sm" style="font-size: 13px !important;">' . $id_plans . '</td>';
                } else {
                    echo '<td class="px-4 py-3 text-sm" style="font-size: 13px !important;"> ' . $_LANG['notplan'] . ' </td>';
                }
                echo '<td class="px-4 py-3 text-sm" style="font-size: 13px !important;">' . $number_order . '</td>';
                echo '<td class="px-4 py-3 text-sm" style="font-size: 13px !important;">' . $date . '</td>';


                if ($row1["state"] == "canceled") {
                    echo '<td class="px-4 py-3 text-xs">';
                    echo '<a><span class="px-3 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">' . $_LANG['canceled'] . '</span></a>';
                    echo '</td>';
                } elseif ($row1["state"] == 'paid') {
                    echo '<td class="px-4 py-3 text-xs">';
                    echo '<a><span class="px-3 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">' . $_LANG['paid'] . '</span></a>';
                    echo '</td>';
                } elseif ($row1["state"] == 'pending') {
                    echo '<td class="px-4 py-3 text-xs">';
                    echo '<a><span class="px-3 py-1 font-semibold leading-tight text-purple-700 bg-purple-100 rounded-full dark:bg-purple-700 dark:text-purple-100">' . $_LANG['pending'] . '</span></a>';
                    echo '</td>';
                } else {
                    echo '<td class="px-4 py-3 text-xs">';
                    echo '<a><span class="px-3 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">' . $_LANG['approved'] . '</span></a>';
                    echo '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';


            ?>


        </div>
    </main>
</div>
</div>


<?php
include 'includ/footer.php';
?>