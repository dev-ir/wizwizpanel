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


            <a style="font-size: 20px;" class="text-xs font-semibold tracking-wide text-left text-gray-500 0 dark:text-gray-400 inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="ml-4"> <?php echo $_LANG['Dashboards'] ?> </span>
                <?php session_notif_wizwiz() ?>
            </a>



            <div style='margin-top:40px' class="shadow-sm min-w-0 p-4 bg-white rounded-xl dark:bg-gray-800 tracking-wide border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">


                <div class="mt-5 flex justify-center items-center container grid gap-6 xl:grid-cols-4 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-2 grid-cols-2	">
                    <div class="m-1" id="cpuDiv">
                        <div class="pie_progress_cpu" role="progressbar" data-goal="33">
                            <div class="pie_progress__number dark:text-gray-100">0%</div>
                            <div class="pie_progress__label dark:text-gray-100"><?php echo $_LANG['CPU'] ?></div>
                        </div>
                    </div>
                    <div class="m-1" id="memDiv">
                        <div class="pie_progress_mem" role="progressbar" data-goal="33">
                            <div class="pie_progress__number dark:text-gray-100">0%</div>
                            <div class="pie_progress__label dark:text-gray-100"><?php echo $_LANG['Memory'] ?></div>
                        </div>
                    </div>
                    <div class="m-1" id="diskDiv">
                        <div class="pie_progress_disk" role="progressbar" data-goal="33">
                            <div class="pie_progress__number dark:text-gray-100">0%</div>
                            <div class="pie_progress__label dark:text-gray-100"><?php echo $_LANG['Disk'] ?></div>
                        </div>
                    </div>

                    <div class="m-1" id="temperatureDiv">
                        <div class="pie_progress_temperature" role="progressbar" data-goal="0">
                            <div class="pie_progress__number dark:text-gray-100">0°</div>
                            <div class="pie_progress__label dark:text-gray-100">Swap</div>
                        </div>
                    </div>

                </div>
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <div class="flex items-center justify-center rounded-xl p-4 text-red-500 bg-red-100 dark:text-gray-200 dark:bg-gray-700">
                        <div>
                            <p class="">
                            <div class="" id="cpuDiv">
                                <div class='title dark:text-gray-500 font-semibold' style="font-size: 12px;text-align: center"></div>
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center rounded-xl p-4 text-red-500 bg-red-100 dark:text-gray-200 dark:bg-gray-700">
                        <div>
                            <p class="">
                            <div class="" id="memDiv">
                                <div class='title dark:text-gray-500 font-semibold' style="font-size: 12px;text-align: center"></div>
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center rounded-xl p-4 text-red-500 bg-red-100 dark:text-gray-200 dark:bg-gray-700">
                        <div>
                            <p class=" ">
                            <div class="" id="diskDiv">
                                <div class='title dark:text-gray-500 font-semibold' style="font-size: 12px;text-align: center"></div>
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center rounded-xl p-4 text-red-500 bg-red-100 dark:text-gray-200 dark:bg-gray-700">
                        <div>
                            <p class=" ">
                            <div class="" id="">
                                <div class='title dark:text-gray-500 font-semibold' style="font-size: 12px;text-align: center"><?php echo $_LANG['coming'] ?></div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Cards -->
            <div style='margin-top:50px' class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-gray-200 dark:bg-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo $_LANG['users'] ?>
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <?php
                            $user_count = users_count($conn);
                            echo $user_count;
                            ?>

                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-gray-200 dark:bg-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo $_LANG['Total'] ?>
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <?php
                            $number_order = number_order($conn);
                            echo $number_order;
                            ?>
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-gray-200 dark:bg-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo $_LANG['Orders'] ?>
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 ">
                            <?php
                            $number_order = show_product($conn);
                            echo $number_order;
                            ?>
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-gray-200 dark:bg-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo $_LANG['tickets'] ?>
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <?php
                            $show_chats_info = show_chats_info($conn);
                            echo $show_chats_info;
                            ?>
                        </p>
                    </div>
                </div>
            </div>



            <?php
            users_on_off($conn);
            users_ban($conn);
            ?>
            <!-- New Table -->
            <br>
            <div class="shadow-lg min-w-0 p-4 bg-white font-semibold rounded-lg dark:bg-gray-800 text-xs  tracking-wide text-left text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wra">
                        <thead class="">
                            <tr style="font-size: 13px" class="text-center tracking-wide text-left text-gray-500  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-700">

                                <th class="px-4 py-3 "></th>
                                <th class="px-4 py-3"><?php echo $_LANG['username'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['wallet'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['Buy'] ?></th>
                                <th class="px-5 py-5"><?php echo $_LANG['register'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['phone'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['free'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['ban'] ?></th>
                                <th class="px-4 py-3"><?php echo $_LANG['start'] ?></th>

                            </tr>
                        </thead>

                        <?php

                        $users_select = users_select($conn);
                        if (is_array($users_select) || is_object($users_select)) {
                            foreach ($users_select
                                as $value) :
                                $timestamp = $value["date"];
                                $date = jdate('Y-m-d H:i:s', $timestamp);

                                $amount_order_sum1 = "SELECT SUM(amount) FROM orders_list where userid=?";

                                $stmt = $conn->prepare($amount_order_sum1);
                                $stmt->bind_param('i', $value['userid']);
                                $stmt->execute();
                                $result_amount_order1 = $stmt->get_result();
                                $stmt->close();

                                $row_amount_order1 = $result_amount_order1->fetch_assoc();
                                $show_amount_order1 = implode($row_amount_order1);
                                echo '<tbody style="font-size: 13px;" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center border-b dark:border-gray-600">';
                                echo '<tr class="text-gray-700 dark:text-gray-400">';
                                echo '<td class="px-4 py-3">';
                                echo '<div class="flex items-center text-sm">';
                                echo '<div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">';
                                echo '<img class="object-cover w-full h-full rounded-full" src="icons/wizwiz.jpg" alt="" loading="lazy">';
                                echo '<div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>';
                                echo '</div>';
                                echo '<div>';
                                echo '<p class="font-semibold text-left">' . $value["name"] . '</p>';
                                echo '<p class="text-xs mt-1 text-gray-600 dark:text-gray-400 text-left">' . $value["userid"] . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</td>';
                                echo '<td class="px-4 py-3">' . $value["username"] . '</td>';
                                echo '<td class="px-4 py-3">' . number_format($value["wallet"]) . '</td>';
                                if ($show_amount_order1 >= 1000) {
                                    // Format $num1 with thousands separator
                                    $number_order1 = number_format($show_amount_order1);
                                    echo '<td class="px-4 py-3 ">' . $number_order1 . '</td>';
                                } else {
                                    echo '<td class="px-4 py-3">' . $show_amount_order1 . '</td>';
                                }
                                echo '<td class="px-4 py-3">' . $date . '</td>';
                                if ($value["phone"]) {
                                    echo '<td class="px-4 py-3 ">' . $value["phone"] . '</td>';
                                } else {
                                    echo '<td class="px-4 py-3 ">none</td>';
                                }
                                if ($value["freetrial"] == 'used') {
                                    echo '<td class="px-4 py-3">' . $_LANG['yes'] . '</td>';
                                } else {
                                    echo '<td class="px-4 py-3 ">' . $_LANG['no'] . '</td>';
                                }
                                if ($value["step"] == "none") {
                                    echo '<td class="px-4 py-3 "><div class="flex items-center space-x-4 text-sm justify-center">';
                                    echo '<a href="index.php?stepoff=' . $value["id"] . '"><img src="icons/lacheln.svg" width="20"></a>';
                                    echo '</div></td>';
                                } elseif ($value["step"] == "banned") {
                                    echo '<td class="px-4 py-3 "><div class="flex items-center space-x-4 text-sm justify-center">';
                                    echo '<a href="index.php?stepon=' . $value["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" fill="#e71d36" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="20" height="20"><path d="M24,12c0,6.617-5.383,12-12,12-3.076,0-6.001-1.162-8.236-3.272-.401-.38-.42-1.013-.041-1.414,.38-.401,1.012-.418,1.414-.041,1.862,1.759,4.3,2.728,6.863,2.728,5.514,0,10-4.486,10-10S17.514,2,12,2c-3.776,0-7.19,2.09-8.91,5.455-.251,.491-.854,.686-1.346,.436-.492-.252-.687-.854-.436-1.346C3.373,2.508,7.469,0,12,0c6.617,0,12,5.383,12,12Zm-6.274-3.038c.092,.025,.184,.038,.275,.038,.435,0,.835-.286,.961-.726,.152-.531-.156-1.084-.687-1.236-.965-.275-1.977-.941-2.46-1.619-.32-.448-.945-.555-1.395-.232-.449,.32-.554,.945-.233,1.395,.746,1.045,2.135,1.979,3.54,2.381Zm-9.54-3.543c-.484,.678-1.496,1.344-2.46,1.619-.531,.152-.839,.705-.687,1.236,.125,.439,.526,.726,.961,.726,.091,0,.183-.013,.275-.038,1.404-.401,2.793-1.336,3.54-2.381,.321-.449,.216-1.074-.233-1.395-.45-.321-1.074-.217-1.395,.232Zm.314,5.581c-.828,0-1.5,.672-1.5,1.5s.672,1.5,1.5,1.5,1.5-.672,1.5-1.5-.672-1.5-1.5-1.5Zm7,3c.828,0,1.5-.672,1.5-1.5s-.672-1.5-1.5-1.5-1.5,.672-1.5,1.5,.672,1.5,1.5,1.5Zm-7.463,3.96c-.178,.51,.224,1.04,.765,1.04,1.544,0,4.85,0,6.384,0,.538,0,.941-.524,.768-1.033-.487-1.432-2.04-2.966-3.954-2.966s-3.463,1.531-3.963,2.96Zm-3.037-3.46c0-1.403-1.184-3.372-1.922-4.235-.303-.355-.849-.353-1.151,.004-.738,.874-1.927,2.861-1.927,4.231,0,1.381,1.119,2.5,2.5,2.5s2.5-1.119,2.5-2.5Z"/></svg></a>';
                                    echo '</div></td>';
                                } else {
                                    echo '<td class="px-4 py-3 "><div class="flex items-center space-x-4 text-sm justify-center">';
                                    echo '<a href="index.php?stepoff=' . $value["id"] . '"><img src="icons/lacheln.svg" width="20"></a>';
                                    echo '</div></td>';
                                }
                                if ($value["first_start"]) {
                                    echo '<td class="px-4 py-3 ">' . $value["first_start"] . '</td>';
                                } else {
                                    echo '<td class="px-4 py-3 ">none</td>';
                                }
                                echo '</tr>';

                                echo '</tbody>';
                            endforeach;
                        }
                        ?>
                    </table>
                </div>
            </div>

        </div>
        <br>
        <br>
        <br>
    </main>

</div>
</div>
<script type="text/javascript" src="monitor/gauge/jquery-asPieProgress.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Example with grater loading time - loads longer
        $('.pie_progress_temperature,.pie_progress_cpu, .pie_progress_mem, .pie_progress_disk').asPieProgress({});
        getTemp();
        getCpu();
        getMem();
        getDisk();
    });

    function getTemp() {
        $.ajax({
            url: 'monitor/temperature.json.php',
            success: function(response) {
                update('temperature', response);
                setTimeout(function() {
                    getTemp();
                }, 1000);
            }
        });
    }


    function getCpu() {
        $.ajax({
            url: 'monitor/cpu.json.php',
            success: function(response) {
                update('cpu', response);
                setTimeout(function() {
                    getCpu();
                }, 1000);
            }
        });
    }

    function getMem() {
        $.ajax({
            url: 'monitor/memory.json.php',
            success: function(response) {
                update('mem', response);

                setTimeout(function() {
                    getMem();
                }, 1000);
            }
        });
    }

    function getDisk() {
        $.ajax({
            url: 'monitor/disk.json.php',
            success: function(response) {
                update('disk', response);
                setTimeout(function() {
                    getDisk();
                }, 1000);
            }
        });
    }

    function update(name, response) {
        $('.pie_progress_' + name).asPieProgress('go', response.percent);
        $("#" + name + "Div div.title").text(response.title);
        $("#" + name + "Div pre").text(response.output.join('\n'));
    }
</script>
<?php
include 'includ/footer.php';
?>