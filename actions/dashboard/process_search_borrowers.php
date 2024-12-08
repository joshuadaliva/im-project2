    <?php
    require_once("../../database/config.php");
    session_start();
    if ($_SESSION["userType"] != "admin") {
        header("Location: /im/actions/addon/hecker.php");
        exit();
    }

    function sanitizerString($data)
    {
        $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }


    if (isset($_POST['search'])) {
        $searchTerm = sanitizerString($_POST['search']);
        $stmt = $conn->prepare("SELECT * FROM borrowers WHERE name LIKE ?");
        $searchTerm = "%" . $searchTerm . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $borrowers = [];
        while ($row = $result->fetch_assoc()) {
            $borrowers[] = $row; 
        }
    
        if (count($borrowers) > 0) {
            $res = [
                "success" => true,
                "message" => "borrowers found",
                "data" => $borrowers
            ];
        } else {
            $res = [
                "success" => false,
                "message" => "no borrowers found",
                "data" => null
            ];
        }
        echo json_encode($res);
        exit;
    }
    ?>
