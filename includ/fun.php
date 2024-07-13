<?php
include 'class-options.php';
class VolumeInsertionHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleInsertion() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action']) || $_POST['action'] !== 'insert_volume_gb') {
            return;
        }

        $postVars = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $priceNames = $this->sanitizeInput($postVars["price_save"]);
        $volumeNames = $this->sanitizeInput($postVars["volume_save"]);

        $sqlSaveVolume = "INSERT INTO increase_plan (volume, price) VALUES (?, ?)";
		$stmt = $this->conn->prepare($sqlSaveVolume);
		$stmt->bind_param('ss', $volumeNames, $priceNames);
        $stmt->execute();
        if (!$stmt) {
            echo "Error updating tables: ". $stmt->error;
			$stmt->close();
        } else {
			$stmt->close();
            creatwizwiz();
            header("Location: add-volume.php");
            exit();
        }
    }

    private function sanitizeInput($input) {
        // Remove special characters that can be used for SQL injection attacks
        $sanitized_input = preg_replace("/[!@#\$%\^&\*\(\)_\+><\{\|\}\"':;]/", "", $input);

        // Prevent cross-site scripting (XSS) attacks by escaping HTML entities
        $sanitized_input = htmlspecialchars($sanitized_input);

        return $sanitized_input;
    }



    public function insertVolumeDay() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['action']) || $_POST['action'] !== 'insert_volume_day') {
            return; // requests that don't meet requirements are ignored.
        }

        $price_day_names = $this->sanitizeInput($_POST["price_day_save"]);
        $day_names = $this->sanitizeInput($_POST["days_save"]);

        $sql_save_day = "INSERT INTO increase_day (volume, price) VALUES (?, ?)";
		$stmt = $this->conn->prepare($sql_save_day);
		$stmt->bind_param('ss', $day_names, $price_day_names);
		$stmt->execute();
		
        if (!$stmt) {
            echo "Error updating tables: ". $stmt->error;
			$stmt->close();
        } else {
			$stmt->close();
            creatwizwiz();
            header("Location: add-volume.php");
            exit();
        }
    }


    public function handleDeletePlanRequest() {
        if (isset($_GET['deleteplan'])) {
            $id_delete_increase_plan = $_GET['deleteplan'];
			if(is_numeric($id_delete_increase_plan)){
				$sql_delete_increase_plan = "DELETE FROM increase_plan WHERE id=?";
				$stmt = $this->conn->prepare($sql_delete_increase_plan);
				$stmt->bind_param('i', $id_delete_increase_plan);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					die("database error" . $error);
				} else {
					$stmt->close();
					deletewizwiz();
					header("location: add-volume.php");
				}
			}else return;
        }
    }

    public function handleDeleteDayRequest() {
        if (isset($_GET['deleteday'])) {
            $id_delete_increase_day = $_GET['deleteday'];
			if(is_numeric($id_delete_increase_day)){
				$sql_delete_increase_day = "DELETE FROM increase_day WHERE id=?";
				$stmt = $this->conn->prepare($sql_delete_increase_day);
				$stmt->bind_param('i', $id_delete_increase_day);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					die("database error" . $error);
				} else {
					$stmt->close();
					deletewizwiz();
					header("location: add-volume.php");
				}
			}
        }
    }
}

function settingsave_state($conn) {
    if (isset($_POST['action']) && $_POST['action'] == 'save_state'){
        foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[^a-zA-Z0-9\s]/", "", $post_var);
            }
        }
        $requirePhones = $_POST["requirePhone"];
        $requireIranPhones = $_POST["requireIranPhone"];
        $sellStates = $_POST["sellState"];
        $botStates = $_POST["botState"];
        $searchStates = $_POST["searchState"];
        $rewaredTimes = $_POST["rewaredTime"];
        $cartToCartStates = $_POST["cartToCartState"];
        $nextpays = $_POST["nextpay"];
        $zarinpals = $_POST["zarinpal"];
        $nowPaymentWallets = $_POST["nowPaymentWallet"];
        $nowPaymentOthers = $_POST["nowPaymentOther"];
        $walletStates = $_POST["walletState"];
        $rewardChannels = $_POST["rewardChannel"];
        $lockChannels = $_POST["lockChannel"];
        $changeProtocolStates = $_POST["changeProtocolState"];
        $renewAccountStates = $_POST["renewAccountState"];
        $switchLocationStates = $_POST["switchLocationState"];
        $increaseTimeStates = $_POST["increaseTimeState"];
        $increaseVolumeStates = $_POST["increaseVolumeState"];
        $subLinkStates = $_POST["subLinkState"];
        $plandelkhahStates = $_POST["plandelkhahState"];
        $weSwapStates = $_POST["weSwapState"];
        $gbPriceStates = $_POST["gbPrice"];
        $dayPriceStates = $_POST["dayPrice"];
        $renewConfigLinkState = $_POST["renewConfigLinkState"];
        $updateConfigLinkState = $_POST["updateConfigLinkState"];
        $individualExistence = $_POST["individualExistence"];
        $sharedExistence = $_POST["sharedExistence"];
        $testAccount = $_POST["testAccount"];
        $agencyState = $_POST["agencyState"];
        $BOT_STATES_1 = 'BOT_STATES';
        $lockChannelschange = '@'.$lockChannels;
        $rewardChannelschange = '@'.$rewardChannels;
        $data2 = json_encode(array(
            "requirePhone" => $requirePhones,
            "requireIranPhone" => $requireIranPhones,
            "sellState" => $sellStates,
            "botState" => $botStates,
            "searchState" => $searchStates,
            "rewaredTime" => $rewaredTimes,
            "cartToCartState" => $cartToCartStates,
            "nextpay" => $nextpays,
            "zarinpal" => $zarinpals,
            "nowPaymentWallet" => $nowPaymentWallets,
            "nowPaymentOther" => $nowPaymentOthers,
            "walletState" => $walletStates,
            "rewardChannel" => $rewardChannelschange,
            "lockChannel" => $lockChannelschange,
            "changeProtocolState" => $changeProtocolStates,
            "renewAccountState" => $renewAccountStates,
            "switchLocationState" => $switchLocationStates,
            "increaseTimeState" => $increaseTimeStates,
            "increaseVolumeState" => $increaseVolumeStates,
            "gbPrice" => $gbPriceStates,
            "dayPrice" => $dayPriceStates,
            "subLinkState" => $subLinkStates,
            "plandelkhahState" => $plandelkhahStates,
            "renewConfigLinkState" => $renewConfigLinkState,
            "updateConfigLinkState" => $updateConfigLinkState,
            "individualExistence" => $individualExistence,
            "sharedExistence" => $sharedExistence,
            "testAccount" => $testAccount,
            "agencyState" => $agencyState,
            "weSwapState" => $weSwapStates
        ));
		
        $sqlserver_setting2 = "UPDATE setting SET value=? ,type=? WHERE id='5'";
		$stmt = $conn->prepare($sqlserver_setting2);
		$stmt->bind_param('ss', $data2, $BOT_STATES_1);
		$stmt->execute();
        if (!$stmt) {
            echo "Error updating tables: " . $stmt->error;
			$stmt->close();
        } else {
			$stmt->close();
            editwizwiz();
            header("location: settings.php");
        }
    }
}

function volume_select_gb($conn){
    $sql_increase_plan = "SELECT * FROM increase_plan ORDER BY id DESC";
	$stmt = $conn->prepare($sql_increase_plan);
	$stmt->execute();
	$result_increase_plan = $stmt->get_result();
	$stmt->close();
	
    while ($row_increase_plan = $result_increase_plan->fetch_assoc()) {
        $result[] = $row_increase_plan;
    }
    return @$result;
}
function volume_select_day($conn){
    $sql_increase_day = "SELECT * FROM increase_day ORDER BY id DESC";
	$stmt = $conn->prepare($sql_increase_day);
	$stmt->execute();
	$result_increase_day = $stmt->get_result();
	$stmt->close();
    
    while ($row_increase_day = $result_increase_day->fetch_assoc()) {
        $result[] = $row_increase_day;
    }
    return @$result;
}



function categories_delete($conn){
    if (isset($_GET['delete'])) {
        $id_delete_categories = $_GET['delete'];
		if(is_numeric($id_delete_categories)){
			$sql_delete_categories = "DELETE FROM server_categories WHERE id=?";
			$stmt = $conn->prepare($sql_delete_categories);
			$stmt->bind_param('i', $id_delete_categories);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				deletewizwiz();
				header("location: category.php");
			}
		}else return;
    }
}

function server_select($conn){
    $sql_categories = "SELECT * FROM server_categories ORDER BY id DESC";
	$stmt = $conn->prepare($sql_categories);
	$stmt->execute();
	$result_categories = $stmt->get_result();
	$stmt->close();
	
    while ($row_categories = $result_categories->fetch_assoc()) {
        $result[] = $row_categories;
    }
    return @$result;
}

function server_insert($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'insert_category') {
        foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[!@#\$%\^&\*\(\)_\+><\{\|\}\"':;]/", "", $post_var);
            }
        }
        $title_category = $_POST['title_category'];
        $server_ids = '0';
        $parents = '0';
        $steps = '4';
        $actives = '1';
        $insert_category_sql = "INSERT INTO server_categories (server_id,title,parent,step,active) VALUES (?,?,?,?,?)";
		$stmt = $conn->prepare($insert_category_sql);
		$stmt->bind_param('isiii', $server_ids, $title_category, $parents, $steps, $actives);
		$stmt->execute();
		
        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
            echo "خطا" . $error;
        } else {
			$stmt->close();
            creatwizwiz();
            header('Location: category.php');

        }
    }
}


function discounts_select($conn){
    $sql_categories = "SELECT * FROM discounts ORDER BY id DESC";
	$stmt = $conn->prepare($sql_categories);
	$stmt->execute();
    $result_categories = $stmt->get_result();
	$stmt->close();
    while ($row_categories = $result_categories->fetch_assoc()) {
        $result[] = $row_categories;
    }
    return @$result;
}
function discounts_delete($conn){
    if (isset($_GET['delete'])) {
        $id_delete_categories = $_GET['delete'];
		if(is_numeric($id_delete_categories)){
			$sql_delete_categories = "DELETE FROM discounts WHERE id=?";
			$stmt = $conn->prepare($sql_delete_categories);
			$stmt->bind_param('i', $id_delete_categories);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				deletewizwiz();
				header("location: discount.php");
			}
		}
    }
}
function discounts_insert($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'insert_discount') {
        foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[!@#\$%\^&\*\(\)_\+><\{\|\}\"':;]/", "", $post_var);
            }
        }
        $category_discountss = $_POST['category_discounts'];
        $percent_discounts = $_POST['percent_discounts'];
        $discounts_date = $_POST['discounts_date'];
        $discounts_count = $_POST['discounts_count'];
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ'; // string containing all letters of the alphabet
        $hash_ids = substr(str_shuffle($letters), 0, 10); // shuffle the string and take the first 10 characters
        if($discounts_date == '0'){
            $discounts_date = '0';
        }else {
            $discounts_date = time() + ($discounts_date * 24 * 60 * 60);
        }
        $can_use_discountss = $_POST['discounts_can_use'];
        $insert_category_sql = "INSERT INTO discounts (hash_id,type,amount,expire_date,expire_count,can_use) 
VALUES (?,?,?,?,?,?)";
		$stmt = $conn->prepare($insert_category_sql);
		$stmt->bind_param('ssiiii',$hash_ids, $category_discountss, $percent_discounts, $discounts_date, $discounts_count, $can_use_discountss);
		$stmt->execute();
        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
            echo "خطا" . $error;
        } else {
			$stmt->close();
            creatwizwiz();
            header('Location: discount.php');

        }
    }
}



function users_insert($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'insert_gift') {
        include '../wizwizxui-timebot/baseInfo.php';

        $chatId = $_POST["id_user"];
        $gifts = $_POST["gift"];
        $urls = $_POST["url"];
        $buttons = $_POST["button"];

        $sql_admins = "SELECT * FROM users where userid=?";
		$stmt = $conn->prepare($sql_admins);
		$stmt->bind_param('i', $chatId);
		$stmt->execute();
		$row_admins = $stmt->get_result();
		$stmt->close();
		
		if($row_admins->num_rows == 0) return;

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $message = '🎁 دوست عزیزم، مبلغ '. $gifts . ' به حساب شما واریز شد';
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => $buttons,
                            'url' => $urls
                        ]
                    ]
                ]
            ])
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

		
        $sqlserver_setting = "UPDATE users SET wallet= wallet + ? WHERE userid=?";
		$stmt = $conn->prepare($sqlserver_setting);
		$stmt->bind_param('ii', $gifts, $chatId);
		$stmt->execute();
		if (!$stmt) {
            echo "Error updating tables: " . $stmt->error;
			$stmt->close();

        } else {
			$stmt->close();
            creatwizwiz();
            header("location: gift.php");
        }

    }
}



//index.php
function users_on_off($conn){
    if (isset($_GET['on'])) {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE users SET isAdmin='1' WHERE id=?";
			$stmt = $conn->prepare($sql_on_select);
			$stmt->bind_param('i', $id_on_select);
			$stmt->execute();
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusonwizwiz();
				header("location: index.php");
			}
		}else return;
    }

    if (isset($_GET['off'])) {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE users SET isAdmin='0' WHERE id=?";
			$stmt = $conn->prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusoffwizwiz();
				header("location: index.php");
			}
		}else return;
    }
}

function users_ban($conn){
    if (isset($_GET['stepon'])) {
        $id_stepon_select = $_GET['stepon'];
		if(is_numeric($id_stepon_select)){
			$sql_stepon_select = "UPDATE users SET step='none' WHERE id=?";
			$stmt = $conn->prepare($sql_stepon_select);
			$stmt->bind_param('i', $id_stepon_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusonwizwiz();
				header("location: index.php");
			}
		} else return;
    }

    if (isset($_GET['stepoff'])) {
        $id_stepoff_select = $_GET['stepoff'];
		if(is_numeric($id_stepoff_select)){
			$sql_stepoff_select = "UPDATE users SET step='banned' WHERE id='$id_stepoff_select'";
			$stmt = $conn->prepare($sql_stepoff_select);
			$stmt->bind_param('i', $id_stepoff_select);
			$stmt->execute();
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusoffwizwiz();
				header("location: index.php");
			}
		}else return;
    }
}
function users_select($conn){
    $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 50";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$results = $stmt->get_result();
	$stmt->close();
    
    while ($row_users = $results->fetch_assoc()) {
        $result[] = $row_users;
    }
    return @$result;
}
function users_count($conn){
    $user_sum = "SELECT COUNT(*) FROM users";
	$stmt = $conn->prepare($user_sum);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
    $row_users = $result->fetch_assoc();
    $show_user = implode($row_users);
    return $show_user;
}
function number_order($conn){
    $amount_order_sum = "SELECT SUM(amount) FROM orders_list";
	$stmt = $conn->prepare($amount_order_sum);
	$stmt->execute();
	$row_amount_order = $stmt->get_result()->fetch_assoc();
	$stmt->close();

    $show_amount_order = implode($row_amount_order);
    $number_order = number_format($show_amount_order);
    return $number_order;
}
function show_product($conn){
    $product_sum = "SELECT COUNT(*) FROM orders_list";
	
	$stmt = $conn->prepare($product_sum);
	$stmt->execute();
	$row_product= $stmt->get_result()->fetch_assoc();
	$stmt->close();

    $show_product = implode($row_product);
    return $show_product;
}
function show_chats_info($conn){
    $chats_info_sum = "SELECT COUNT(*) FROM chats_info";
	
	$stmt = $conn->prepare($chats_info_sum);
	$stmt->execute();
	$row_chats_info = $stmt->get_result()->fetch_assoc();
	$stmt->close();

    $show_chats_info = implode($row_chats_info);
    return $show_chats_info;
}
function order_on($conn){
    if (isset($_GET['on'])) {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE orders_list SET status='1' WHERE id=?";
			$stmt = $conn->prepare($sql_on_select);
			$stmt->bind_param('i', $id_on_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusonwizwiz();
				header("location: orders.php");
			}
		}else return;
    }
}
function order_off($conn){
    if (isset($_GET['off'])) {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE orders_list SET status='0' WHERE id=?";
			$stmt = $conn->prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusoffwizwiz();
				header("location: orders.php");
			}
		}else return;
    }
}
function order_delete($conn){
    if (isset($_GET['delete'])) {
        $id_delete_orders = $_GET['delete'];
		if(is_numeric($id_delete_orders)){
			$sql_delete_orders = "DELETE FROM orders_list WHERE id=?";
			$stmt = $conn->prepare($sql_delete_orders);
			$stmt->bind_param('i', $id_delete_orders);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				deletewizwiz();
				header("location: orders.php");

			}
		}else return;
    }
}
function orders_list($conn){
    $sql = "SELECT * FROM orders_list ORDER BY id DESC LIMIT 100";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$results = $stmt->get_result();
	$stmt->close();
	
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $result[] = $row;
        }
    }
    return @$result;
}
//function orders_list_select($conn){
//        $id_wiw = $_GET['id'];
//        $sql1 = "SELECT * FROM orders_list WHERE server_id='$id_wiw' ORDER BY id DESC ";
//        $result1 = $conn->query($sql1);
//        while ($row1 = $result1->fetch_assoc()) {
//            $result[] = $row1;
//        }
//    return @$result;
//}
function plan_edit1($conn){
    if (isset($_GET['edit'])) {
        $id_edit_select = $_GET['edit'];
		if(is_numeric($id_edit_select)){
			$sql12123 = "SELECT * FROM server_plans WHERE id = ?";
			$stmt = $conn->prepare($sql12123);
			$stmt->bind_param('i', $id_edit_select);
			$stmt->execute();
			$result5454 = $stmt->get_result();
			$stmt->close();
			
			while ($row656 = $result5454->fetch_assoc()) {
				$result[] = $row656;
			}
			return @$result;
		}else return;
    }
}
function plan_insert1($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'insert_plans1') {
        foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[!@#\$%\^&\*\(\)_\+><\{\|\}\"':;]/", "", $post_var);
            }
        }
        $title_plans5 = $_POST['title_plan'];
        $protocol_plans5 = $_POST['protocol_plan'];
        $days_plans5 = $_POST['days_plan'];
        $volume_plans5 = $_POST['volume_plan'];
        $type_plans5 = $_POST['type_plan'];
        $price_plans5 = $_POST['price_plan'];
        $limitip_plans5 = $_POST['limitip_plan'];
        $name_category_plans5 = $_POST['name_category_wizwiz'];
        $name_servers_plans5 = $_POST['name_servers_wizwiz'];
        $descriptions5 = $_POST['description'];
        $fileid5 = '0';
        $pic5 = '0';
        $active5 = 1;
        $step5 = 10;
        $dates5 = time();
        $rahgozars5 = 0;
//        if ($_POST['inbound_plan']) {
//            $inbound_plans = $_POST['inbound_plan'];
//        } else {
        $inbound_plans5 = 0;
//        }
//        if ($_POST['count_plan']) {
//            $count_plans = $_POST['count_plan'];
//        } else {
        $count_plans5 = 0;
//        }
        $insert_plans_sql5 = "INSERT INTO server_plans (fileid,catid,server_id,inbound_id,acount,
                          limitip,title,protocol,days,volume,type,price,descr,pic,active,step,date,rahgozar)
                          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$stmt = $conn->prepare($insert_plans_sql5);
		$stmt->bind_param('iiiiiissiisissiiis', $fileid5, $name_category_plans5, $name_servers_plans5, $inbound_plans5, $count_plans5,
			$limitip_plans5, $title_plans5, $protocol_plans5, $days_plans5, $volume_plans5, $type_plans5, $price_plans5, $descriptions5, $pic5,
			$active5, $step5, $dates5, $rahgozars5);
		$stmt->execute();

        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
			
            echo "خطا" . die($error);
        } else {
			$stmt->close();
            creatwizwiz();
            header('Location: singleplans.php');

        }
    }
}
function plans1($conn) {
    if (isset($_GET['delete'])) {
        $id_delete_server_plans = $_GET['delete'];
		if(is_numeric($id_delete_server_plans)){
			$sql_delete_server_plans = "DELETE FROM server_plans WHERE id=?";
			$stmt = $conn->prepare($sql_delete_server_plans);
			$stmt->bind_param('i', $id_delete_server_plans);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				deletewizwiz();
				header("location: singleplans.php");
			}
		}else return;
    }

    if (isset($_GET['on'])) {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE server_plans SET active='1' WHERE id=?";
			$stmt = $conn->prepare($sql_on_select);
			$stmt->bind_param('i', $id_on_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusonwizwiz();
				header("location: singleplans.php");
			}
		}
    }

    if (isset($_GET['off'])) {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE server_plans SET active='0' WHERE id=?";
			$stmt = $conn->prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				
				statusoffwizwiz();
				header("location: singleplans.php");
			}
		}else return;
    }


    if (isset($_GET['copy'])) {
        $id_copy_server_plans = $_GET['copy'];
		if(is_numeric($id_copy_server_plans)){
			$sql_copy_server_plans = "SELECT * FROM server_plans WHERE id=?";
			$stmt = $conn->prepare($sql_copy_server_plans);
			$stmt->bind_param('i', $id_copy_server_plans);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				die("database error" . $error);
			} else {
				$row_data = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				// Perform copy operation here
				header("location: singleplans.php");
				$dates = time();
				$insert_plans_sql = "INSERT INTO server_plans (fileid,catid,server_id,inbound_id,acount,
							  limitip,title,protocol,days,volume,type,price,descr,pic,active,step,date,rahgozar,dest,serverNames,spiderX,flow)
							  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$stmt = $conn->prepare($insert_plans_sql);
				$stmt->bind_param('iiiiiissiiiissiiisssss',$row_data['fileid'],$row_data['catid'],$row_data['server_id'],$row_data['inbound_id'],$row_data['acount'],$row_data['limitip'],$row_data['title'],$row_data['protocol'],
									  $row_data['days'],$row_data['volume'],$row_data['type'],$row_data['price'],
									  $row_data['descr'],$row_data['pic'],$row_data['active'],$row_data['step'],
									  $dates,$row_data['rahgozar'],$row_data['dest'],$row_data['serverNames']
									  ,$row_data['spiderX'],$row_data['flow']);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					echo "خطا" . die($error);
				} else {
					$stmt->close();
					
					creatwizwiz();
					header('Location: singleplans.php');
				}

			}
		}else return;
    }


}


function plan_edit2($conn){
    if (isset($_GET['edit'])) {
        $id_edit_select = $_GET['edit'];
		if(is_numeric($id_edit_select)){
			$sql12123 = "SELECT * FROM server_plans WHERE id = ?";
			$stmt = $conn->prepare($sql12123);
			$stmt->bind_param('i', $id_edit_select);
			$stmt->execute();
			$result5454 = $stmt->get_result();
			$stmt->close();
			
			while ($row656 = $result5454->fetch_assoc()) {
				$result[] = $row656;
			}
			return @$result;
		}else return;
    }
}
function plan_insert2($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'insert_plans2') {
        foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[!@#\$%\^&\*\(\)_\+><\{\|\}\"':;]/", "", $post_var);
            }
        }
        $title_plans = $_POST['title_plan'];
        $protocol_plans = $_POST['protocol_plan'];
        $days_plans = $_POST['days_plan'];
        $volume_plans = $_POST['volume_plan'];
        $type_plans = $_POST['type_plan'];
        $price_plans = $_POST['price_plan'];
        $limitip_plans = $_POST['limitip_plan'];
        $name_category_plans = $_POST['name_category_wizwiz'];
        $name_servers_plans = $_POST['name_servers_wizwiz'];
        $descriptions = $_POST['description'];
        $count_plans = $_POST['count_plan'];
        $fileid = '0';
        $pic = '0';
        $active = 1;
        $step = 10;
        $dates = time();
        $rahgozars = 0;
        $inbound_plans = $_POST['inbound_plan'];
        $insert_plans_sql = "INSERT INTO server_plans (fileid,catid,server_id,inbound_id,acount,
                          limitip,title,protocol,days,volume,type,price,descr,pic,active,step,date,rahgozar) 
                          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($insert_plans_sql);
		$stmt->bind_param('iiiiiissiisissiiis', $fileid, $name_category_plans, $name_servers_plans, $inbound_plans, $count_plans,
				$limitip_plans, $title_plans, $protocol_plans, $days_plans, $volume_plans, $type_plans, $price_plans, $descriptions, $pic, $active,
				$step, $dates, $rahgozars);
		$stmt->execute();
		
        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
            echo "خطا" . die($error);
        } else {
			$stmt->close();
            creatwizwiz();
            header('Location: multipleplans.php');

        }
    }
}
function plans2($conn) {
    if (isset($_GET['delete'])) {
        $id_delete_server_plans = $_GET['delete'];
		if(is_numeric($id_delete_server_plans)){
			$sql_delete_server_plans = "DELETE FROM server_plans WHERE id=?";
			$stmt = $conn->prepare($sql_delete_server_plans);
			$stmt->bind_param('i', $id_delete_server_plans);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				
				deletewizwiz();
				header("location: multipleplans.php");
			}
		} return;
    }

    if (isset($_GET['on'])) {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE server_plans SET active='1' WHERE id=?";
			$stmt = $conn->prepare($sql_on_select);
			$stmt->bind_param('i', $id_on_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				
				statusonwizwiz();
				header("location: multipleplans.php");
			}
		}else return;
    }

    if (isset($_GET['off'])) {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE server_plans SET active='0' WHERE id=?";
			$stmt = $conn-prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				
				statusoffwizwiz();
				header("location: multipleplans.php");
			}
		}else return;
    }


    if (isset($_GET['copy'])) {
        $id_copy_server_plans = $_GET['copy'];
		if(is_numeric($id_copy_server_plans)){
			$sql_copy_server_plans = "SELECT * FROM server_plans WHERE id=?";
			$stmt = $conn->prepare($sql_copy_server_plans);
			$stmt->bind_param('i', $id_copy_server_plans);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				die("database error" . $error);
			} else {
				$row_data = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				// Perform copy operation here
				header("location: multipleplans.php");
				$dates = time();
				$insert_plans_sql = "INSERT INTO server_plans (fileid,catid,server_id,inbound_id,acount,
							  limitip,title,protocol,days,volume,type,price,descr,pic,active,step,date,rahgozar,dest,serverNames,spiderX,flow) 
							  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$stmt = $conn->prepare($insert_plans_sql);
				$stmt->bind_param('iiiiiissiisissiiisssss', $row_data['fileid'],$row_data['catid'],$row_data['server_id'],$row_data['inbound_id'],$row_data['acount'],$row_data['limitip'],$row_data['title'],$row_data['protocol'],
				$row_data['days'],$row_data['volume'],$row_data['type'],$row_data['price'],
				$row_data['descr'],$row_data['pic'],$row_data['active'],$row_data['step'],
				$dates,$row_data['rahgozar'],$row_data['dest'],$row_data['serverNames']
				,$row_data['spiderX'],$row_data['flow']);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					echo "خطا" . die($error);
				} else {
					$stmt->close();
					creatwizwiz();
					header('Location: multipleplans.php');
				}
			}
		}else return;
    }


}
function rahgozar($conn) {
    if (isset($_GET['delete'])) {
        $id_delete_server_plans = $_GET['delete'];
		if(is_numeric($id_delete_server_plans)){
			$sql_delete_server_plans = "DELETE FROM server_plans WHERE id=?";
			$stmt = $conn->prepare($sql_delete_server_plans);
			$stmt->bind_param('i', $id_delete_server_plans);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				deletewizwiz();
				header("location: rahgozar.php");
			}
		}else return;
    }

    if (isset($_GET['on'])) {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE server_plans SET active='1' WHERE id=?";
			$stmt = $conn->prepare($sql_on_select);
			$stmt->bind_param('i',$id_on_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusonwizwiz();
				header("location: rahgozar.php");
			}
		}else return;
    }

    if (isset($_GET['off'])) {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE server_plans SET active='0' WHERE id=?";
			$stmt = $conn->prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				statusoffwizwiz();
				header("location: rahgozar.php");
			}
		}else return;
    }
}
function plan_edit_rahgozar($conn){
    if (isset($_GET['edit'])) {
        $id_edit_select = $_GET['edit'];
		if(is_numeric($id_edit_select)){
			$sql12123 = "SELECT * FROM server_plans WHERE id = ?";
			$stmt = $conn->prepare($sql12123);
			$stmt->bind_param('i', $id_edit_select);
			$stmt->execute();
			$result5454 = $stmt->get_result();
			$stmt->close();
			
			while ($row656 = $result5454->fetch_assoc()) {
				$result[] = $row656;
			}
			return @$result;
		}else return;
    }
}
class rahgozar_insert {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function rahgozarRequest() {
        if(isset($_POST['action']) && $_POST['action'] == 'insert_rahgozar') {
            $this->sanitizeInput($_POST);

            $title_plans = $_POST['title_plan'];
            $type_plans = $_POST['type_plan'];
            $protocol_plans = $_POST['protocol_plan'];
            $days_plans = $_POST['days_plan'];
            $volume_plans = $_POST['volume_plan'];
            $price_plans = $_POST['price_plan'];
            $limitip_plans = $_POST['limitip_plan'];
            $name_category_plans = $_POST['name_category_wizwiz'];
            $name_servers_plans = $_POST['name_servers_wizwiz'];
            $descriptions = $_POST['description'];
            $fileid = '0';
            $pic = '0';
            $active = 1;
            $step = 10;
            $dates = time();
            $rahgozar_status = 1;
//            $custom_paths = 1;
//            $custom_ports = 0;
//            $custom_snis = null;

            if ($_POST['inbound_plan']) {
                $inbound_plans = $_POST['inbound_plan'];
            } else {
                $inbound_plans = '0';
            }

            if ($_POST['acount_plan']) {
                $acount_plans = $_POST['acount_plan'];
            } else {
                $acount_plans = '0';
            }



//            if ($_POST['custom_path_plan']) {
//                $custom_paths = $_POST['custom_path_plan'];
//            } else {
//                $custom_paths = '1';
//            }
//            if ($_POST['custom_port_plan']) {
//                $custom_ports = $_POST['custom_port_plan'];
//            } else {
//                $custom_ports = '0';
//            }
//            if ($_POST['custom_sni_plan']) {
//                $custom_snis = $_POST['custom_sni_plan'];
//            } else {
//                $custom_snis = NULL;
//            }

//            $custom_snis = isset($_POST['custom_sni_plan']) ? $_POST['custom_sni_plan'] : null;

            $insert_plans_sql = "INSERT INTO server_plans (fileid, catid, server_id, inbound_id, acount,
            limitip, title, protocol, days, volume, type, price, descr, pic, active, step, date, rahgozar)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?)";
//            '$price_plans', '$descriptions', '$pic', '$active', '$step', '$dates', '$rahgozar_status','$custom_paths','$custom_ports',DEFAULT)";
			
			$stmt = $this->conn->prepare($insert_plans_sql);
			$stmt->bind_param('iiiiiissiisissiiis', $fileid, $name_category_plans, $name_servers_plans, $inbound_plans, $acount_plans,
            $limitip_plans, $title_plans, $protocol_plans, $days_plans, $volume_plans, $type_plans,
            $price_plans, $descriptions, $pic, $active, $step, $dates, $rahgozar_status);
			$stmt->execute();
			
            if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
                echo "Error" . die($error);
            } else {
				$stmt->close();
                creatwizwiz();
                header('Location: rahgozar.php');
            }
        }
    }

    private function sanitizeInput(&$postVar) {
        foreach($postVar as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[!@#\$%\^&\*\(\)_\+><\{\|\}\"':;]/", "", $post_var);
            }
        }
    }

}

class ServerHandler
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleRequest()
    {
        if (isset($_GET['on'])) {
            $this->turnOnServer();
        } elseif (isset($_GET['off'])) {
            $this->turnOffServer();
        } elseif (isset($_GET['true'])) {
            $this->setRealityTrue();
        } elseif (isset($_GET['false'])) {
            $this->setRealityFalse();
        } elseif (isset($_GET['port_type_auto'])) {
            $this->setPortTypeRandom();
        } elseif (isset($_GET['port_type_random'])) {
            $this->setPortTypeAuto();
        } elseif (isset($_GET['delete'])) {
            $this->deleteServer();
        }
    }

    private function turnOnServer()
    {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE server_info SET state='1' WHERE id=?";
			$stmt = $this->conn->prepare($sql_on_select);
			$stmt->bind_param('i', $id_on_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "Error" . die($error);
			} else {
				$stmt->close();
				statusonwizwiz();
				header("location: servers.php");
			}
		}else return;
    }

    private function turnOffServer()
    {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE server_info SET state='0' WHERE id=?";
			$stmt = $this->conn->prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "Error" . die($error);
			} else {
				$stmt->close();
				statusoffwizwiz();
				header("location: servers.php");
			}
		}else return;
    }

    private function setRealityTrue()
    {
        $id_true_select = $_GET['true'];
		if(is_numeric($id_true_select)){
			$sql_true_select = "UPDATE server_config SET reality='true' WHERE id=?";
			$stmt = $this->conn->prepare($sql_true_select);
			$stmt->bind_param('i', $id_true_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "Error" . die($error);
			} else {
				$stmt->close();
				statustruewizwiz();
				header("location: servers.php");
			}
		}else return;
    }

    private function setRealityFalse()
    {
        $id_false_select = $_GET['false'];
		if(is_numeric($id_false_select)){
			$sql_false_select = "UPDATE server_config SET reality='false' WHERE id=?";
			$stmt = $this->conn->prepare($sql_false_select);
			$stmt->bind_param('i', $id_false_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "Error" . die($error);
			} else {
				$stmt->close();
				statusfalsewizwiz();
				header("location: servers.php");
			}
		}else return;
    }

    private function setPortTypeRandom()
    {
        $id_port_type_auto = $_GET['port_type_auto'];
		if(is_numeric($id_port_type_auto)){
			$sql_port_type_auto = "UPDATE server_config SET port_type='random' WHERE id=?";
			$stmt = $this->conn->prepare($sql_port_type_auto);
			$stmt->bind_param('i', $id_port_type_auto);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "Error" . die($error);
			} else {
				$stmt->close();
				statusportwizwiz();
				header("location: servers.php");
			}
		}else return;
    }

    private function setPortTypeAuto()
    {
        $id_port_type_random = $_GET['port_type_random'];
		if(is_numeric($id_port_type_random)){
			$sql_port_type_random = "UPDATE server_config SET port_type='auto' WHERE id=?";
			$stmt = $this->conn->prepare($sql_port_type_random);
			$stmt->bind_param('i', $id_port_type_random);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "Error" . die($error);
			} else {
				$stmt->close();
				statusportwizwiz();
				header("location: servers.php");
			}
		}else return;
    }



    private function deleteServer() {
        $id_delete_orders = $_GET['delete'];
		if(is_numeric($id_delete_orders)){
			$tables = array("server_info", "server_config");
			$error = "";
			foreach ($tables as $table) {
				$query = "DELETE FROM $table WHERE id=?";
				$stmt = $this->conn->prepare($query);
				$stmt->bind_param('i', $id_delete_orders);
				$stmt->execute();
				if(!$stmt){
					$error = $stmt->error;
					$stmt->close();
					break;
				}
				$stmt->close();
			}
			if (!empty($error)) {
				die("database error" . $error);
			} else {
				deletewizwiz();
				header("location: servers.php");
			}
		}else return;
    }

    function typesserver($conn) {
        if (isset($_GET['type_normal'])) {
            $id_type_normal = $_GET['type_normal'];
			if(is_numeric($id_type_normal)){
				$sql_type_normal = "UPDATE server_config SET type='alireza' WHERE id=?";
				$stmt = $this->conn->prepare($sql_type_normal);
				$stmt->bind_param('i', $id_type_normal);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					
					echo "خطا" . die($error);
				} else {
					$stmt->close();
					statustypetwizwiz();
					header("location: servers.php");
				}
			}else return;
        }

        if (isset($_GET['type_sanaei'])) {
            $id_type_sanaei = $_GET['type_sanaei'];
			if(is_numeric($id_type_sanaei)){
				$sql_type_sanaei = "UPDATE server_config SET type='normal' WHERE id=?";
				$stmt = $this->conn->prepare($sql_type_sanaei);
				$stmt->bind_param('i', $id_type_sanaei);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					
					echo "خطا" . die($error);
				} else {
					$stmt->close();
					statustypetwizwiz();
					header("location: servers.php");
				}
			}else return;
        }
        if (isset($_GET['type_alireza'])) {
            $id_type_alireza = $_GET['type_alireza'];
			if(is_numeric($id_type_alireza)){
				$sql_type_alireza = "UPDATE server_config SET type='sanaei' WHERE id=?";
				$stmt = $this->conn->prepare($sql_type_alireza);
				$stmt->bind_param('i', $id_type_alireza);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					
					echo "خطا" . die($error);
				} else {
					$stmt->close();
					statustypetwizwiz();
					header("location: servers.php");
				}
			}else return;
        }
		if (isset($_GET['type_marzban'])) {
            $id_type_alireza = $_GET['type_marzban'];
			if(is_numeric($id_type_alireza)){
				$sql_type_alireza = "UPDATE server_config SET type='marzban' WHERE id=?";
				$stmt = $this->conn->prepare($sql_type_alireza);
				$stmt->bind_param('i', $id_type_alireza);
				$stmt->execute();
				
				if (!$stmt) {
					$error = $stmt->error;
					$stmt->close();
					
					echo "خطا" . die($error);
				} else {
					$stmt->close();
					statustypetwizwiz();
					header("location: servers.php");
				}
			}else return;
        }
    }

}


function server_edit($conn){
    if (isset($_GET['edit'])) {
        $id_edit_select = $_GET['edit'];
		if(is_numeric($id_edit_select)){
			$sql12123 = "SELECT server_info.*, server_config.* FROM server_info INNER JOIN server_config ON server_info.id = server_config.id WHERE server_info.id = ?";
			$stmt = $conn->prepare($sql12123);
			$stmt->bind_param('i', $id_edit_select);
			$stmt->execute();
			$result5454 = $stmt->get_result();
			$stmt->close();
			
			while ($row656 = $result5454->fetch_assoc()) {
				$result[] = $row656;
			}
			return @$result;
		}else return;
    }
}


function settings_select_admin($conn){
    $idadmin = '1';
    $sql_admins = "SELECT * FROM admins where id=?";
	$stmt = $conn->prepare($sql_admins);
	$stmt->bind_param('i', $idadmin);
	$stmt->execute();
	$result_admins = $stmt->get_result();
	$stmt->close();
	
    while ($row_admins = $result_admins->fetch_assoc()){
        $result[] = $row_admins;
    }
    return @$result;


}
function settings_save_admin($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'save_admin') {
		foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[^a-zA-Z0-9\s]/", "", $post_var);
            }
        }

        $usernames = $_POST["username"];
        $passwords = $_POST["password"];
        $sqlserver_setting = "UPDATE admins SET username=?,password=? WHERE id='1'";
		
		$stmt = $conn->prepare($sqlserver_setting);
		$stmt->bind_param('ss', $usernames, $passwords);
		$stmt->execute();
		
        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
			
            echo "Error updating tables: " . $error;

        } else {
			$stmt->close();
			
            editwizwiz();
            header("location: settings.php");
        }

    }
}
function settings_backup_channel($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'save_backup') {
        foreach($_POST as &$post_var) {
            if(is_string($post_var)) {
                $post_var = preg_replace("/[^a-zA-Z0-9\s]/", "", $post_var);
            }
        }
        $backupchannels = $_POST["backupchannel"];


        $dsd = '-'.$backupchannels;
        $sqlserver_setting = "UPDATE admins SET backupchannel=? WHERE id='1'";
		$stmt = $conn->prepare($sqlserver_setting);
		$stmt->bind_param('s', $dsd);
		$stmt->execute();
		
        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
			
            echo "Error updating tables: ". $error;
        } else {
			$stmt->close();
            editwizwiz();
            header("location: settings.php");
        }
    }
}
function software($conn){
    if (isset($_GET['on'])) {
        $id_on_select = $_GET['on'];
		if(is_numeric($id_on_select)){
			$sql_on_select = "UPDATE needed_sofwares SET status='1' WHERE id=?";
			$stmt = $conn->prepare($sql_on_select);
			$stmt->bind_param('i', $id_on_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
				echo "خطا" . die($error);
			} else {
				$stmt->close();
				
				statusonwizwiz();
				header("location: software.php");
			}
		}else return;
    }

    if (isset($_GET['off'])) {
        $id_off_select = $_GET['off'];
		if(is_numeric($id_off_select)){
			$sql_off_select = "UPDATE needed_sofwares SET status='0' WHERE id=?";
			$stmt = $conn->prepare($sql_off_select);
			$stmt->bind_param('i', $id_off_select);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				echo "خطا" . die($error);
			} else{
				$stmt->close();
				statusoffwizwiz();
				header("location: software.php");
			}
		}else return;
    }


    if (isset($_GET['delete'])) {
        $id_delete_software = $_GET['delete'];
		if(is_numeric($id_delete_software)){
			$sql_delete_software = "DELETE FROM needed_sofwares WHERE id=?";
			$stmt = $conn->prepare($sql_delete_software);
			$stmt->bind_param('i', $id_delete_software);
			$stmt->execute();
			
			if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				die("خطای پایگاه داده" . $error);
			} else {
				$stmt->close();
				
				deletewizwiz();
				header("location: software.php?remove=1");
			}
		}else return;
    }

}
function software_select($conn){
    $sql_sofwares = "SELECT * FROM needed_sofwares ORDER BY id DESC";
	$stmt = $conn->prepare($sql_sofwares);
	$stmt->execute();
	$result_sofwares = $stmt->get_result();
	$stmt->close();
	
    while ($row_sofwares = $result_sofwares->fetch_assoc()) {
        $result[] = $row_sofwares;
    }
    return @$result;
}
function software_insert($conn){
    if(isset($_POST['action']) && $_POST['action'] == 'insert_software') {
        $title_software = $_POST['title_software'];
        $url_software = $_POST['url_software'];
        $status_s = 1;
        $insert_software_sql = "INSERT INTO needed_sofwares (title,link,status) VALUES (?,?,?)";
		$stmt = $conn->prepare($insert_software_sql);
		$stmt->bind_param('ssi', $title_software, $url_software, $status_s);
		$stmt->execute();
		
        if (!$stmt) {
			$error = $stmt->error;
			$stmt->close();
			
            echo "خطا" . die($error);
        } else {
			$stmt->close();

            header('Location: software.php');

        }
    }
}


function volumes_delete($conn){
    class DeleteCategory {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function delete($id) {
            $sql = "DELETE FROM increase_order WHERE id=?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
            if (!$stmt) {
				$error = $stmt->error;
				$stmt->close();
				
                die("database error" . $error);
            } else {
				$stmt->close();
                deletewizwiz();
                header("location: volume.php");
            }
        }
    }
    if (isset($_GET['delete'])) {
        $id_delete_categories = $_GET['delete'];
		if(is_numeric($id_delete_categories)){
			$delete_category = new DeleteCategory($conn);
			$delete_category->delete($id_delete_categories);
		}else return;
    }
}

