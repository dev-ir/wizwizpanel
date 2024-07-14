<?php 
class wizwiz_option{

    var $conn;
    var $db;

    public function __construct()
    {     
        $this->db = new wizwiz_db();
    }

    public function get_option( $key ){
        if( isset($key) && !empty($key) ){
            $sql = "SELECT * FROM `setting` where `type` = '{$key}'";
            $result = $this->db->query($sql);
            if( isset($result['value']) && $result['value'] != null ){
                return $result['value'];
            }else{
                return '';
            }
        }
    }

    public function update_option( $key, $value ){
        if( isset($key) && !empty($key) ){
            $sql = "SELECT * FROM `setting` where `type` = $key";
            $result = $this->db->query($sql);
            if( isset($result['id']) && $result['id'] != null ){
                $this->db->query("UPDATE setting SET value='{$value}' WHERE id=".$result['id']);
            }else{
                $sql = "INSERT INTO `setting` (`id`, `type`, `value`) VALUES (NULL, $key, $value );";
                $this->db->query($sql);
            }
        }
    }

}

class wizwiz_db{

    
    var $conn;

    public function __construct()
    {
        // include db file
        ################################
        require 'includ/db.php';
        $this->conn = $conn;
        ################################        
    }

    public function query($sql){
        $stmt   = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if (strpos($sql, "SELECT") !== false) {
            $result = $result->fetch_assoc();
        }
        
        $stmt->close();    
        return $result;
    }

    public function loop( $db_name , $page = null ){
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 25;
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM $db_name LIMIT $perPage OFFSET $offset";
        $result = $this->conn->query($sql);
        $row = $result->fetch_all(MYSQLI_ASSOC);
        return $row;
    }

    public function generatePagination($tableName) {
        // Set default values
        $perPage = 25; // Number of records per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
      
        // Count total records
        $sql = "SELECT COUNT(*) FROM $tableName";
        $result = $this->conn->query($sql);
        $totalRecords = $result->fetch_row()[0];
        $result->close();
      
        // Calculate total pages
        $totalPages = ceil($totalRecords / $perPage);
      
        // Generate pagination HTML
        $paginationHTML = '<div class="mb-3 shadow-xl min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 text-xs font-semibold tracking-wide text-left text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">';
        $paginationHTML .= '<nav aria-label="Page navigation example">';
        $paginationHTML .= '<ul class="inline-flex -space-x-px text-base h-10">';
      
        // Previous button
        if ($currentPage > 1) {
          $paginationHTML .= '<li>';
          $paginationHTML .= '<a href="?page=' . ($currentPage - 1) . '" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>';
          $paginationHTML .= '</li>';
        }
      
        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $isActive = $i === $currentPage ? 'active' : '';
            $pageClass = $isActive ? 'flex items-center justify-center px-4 h-10 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white';
            $paginationHTML .= '<li class="' . $isActive . '">';
            $paginationHTML .= '<a href="?page=' . $i . '" class="' . $pageClass . '">' . $i . '</a>';
            $paginationHTML .= '</li>';
        }
      
        // Next button
        if ($currentPage < $totalPages) {
          $paginationHTML .= '<li>';
          $paginationHTML .= '<a href="?page=' . ($currentPage + 1) . '" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>';
          $paginationHTML .= '</li>';
        }
      
        $paginationHTML .= '</ul>';
        $paginationHTML .= '</nav>';
        $paginationHTML .= '</div>';
      
        return $paginationHTML;
      }
      

}
