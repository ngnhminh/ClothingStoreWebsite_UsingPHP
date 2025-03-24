<?php
include(__DIR__ . "/../../config/db.php");

header("Content-Type: application/json");

/**
 * Lấy danh sách khách hàng
 */
function getCustomers() {
    global $conn;
    $sql = "SELECT khachhang.*, tk.diemtichluy FROM khachhang 
            JOIN taikhoan tk ON khachhang.makh = tk.makh
            ORDER BY khachhang.makh ASC";
    $result = $conn->query($sql);

    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $customers]);
}

/**
 * Thêm khách hàng mới
 */
function createCustomer($data) {
    global $conn;
    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";
    $hoten = $data["hoten"] ?? "";
    $sdt = $data["sdt"] ?? "";
    $email = $data["email"] ?? "";
    $address = $data["address"] ?? "";

    if (empty($username) || empty($password) || empty($hoten) || empty($sdt)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin!"]);
        return;
    }

    $sql_khachhang = "INSERT INTO khachhang (hoten, sdt, email, diachi) VALUES (?, ?, ?, ?)";
    $stmt_khachhang = $conn->prepare($sql_khachhang);
    $stmt_khachhang->bind_param("ssss", $hoten, $sdt, $email, $address);

    if ($stmt_khachhang->execute()) {
        $khachhang_id = $conn->insert_id;

        $sql_taikhoan = "INSERT INTO taikhoan (makh, tentaikhoan, matkhau) VALUES (?, ?, ?)";
        $stmt_taikhoan = $conn->prepare($sql_taikhoan);
        $stmt_taikhoan->bind_param("iss", $khachhang_id, $username, $password);

        if ($stmt_taikhoan->execute()) {
            echo json_encode(["status" => "success", "message" => "Thêm khách hàng thành công!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi khi thêm tài khoản: " . $stmt_taikhoan->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi thêm khách hàng: " . $stmt_khachhang->error]);
    }
}

/**
 * Cập nhật thông tin khách hàng
 */
function updateCustomer($data) {
    global $conn;
    $makh = $data["makh"] ?? null;
    $hoten = $data["hoten"] ?? "";
    $sdt = $data["sdt"] ?? "";
    $email = $data["email"] ?? "";
    $address = $data["address"] ?? "";
    $password = $data["password"] ?? "";

    if (!$makh) {
        echo json_encode(["status" => "error", "message" => "Mã khách hàng không hợp lệ!"]);
        return;
    }

    $sql = "UPDATE khachhang 
            SET hoten = ?, sdt = ?, email = ?, diachi = ? 
            WHERE makh = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $hoten, $sdt, $email, $address, $makh);

    if ($stmt->execute()) {
        // Nếu có mật khẩu mới thì cập nhật
        if (!empty($password)) {
            $sql_pw = "UPDATE taikhoan SET matkhau = ? WHERE makh = ?";
            $stmt_pw = $conn->prepare($sql_pw);
            $stmt_pw->bind_param("si", $password, $makh);
            $stmt_pw->execute();
        }
        echo json_encode(["status" => "success", "message" => "Cập nhật thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi: " . $stmt->error]);
    }
}

/**
 * Xóa khách hàng
 */
function deleteCustomer($data) {
    global $conn;
    $makh = $data["makh"] ?? null;

    if (!$makh) {
        echo json_encode(["status" => "error", "message" => "Mã khách hàng không hợp lệ!"]);
        return;
    }

    $sql = "DELETE FROM khachhang WHERE makh = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $makh);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Xóa khách hàng thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi: " . $stmt->error]);
    }
}

// Xử lý request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['function']) && isset($data['params']) && is_array($data['params'])) {
        $functionName = $data['function'];
        $params = $data['params'];

        // Các hàm được phép gọi từ API
        $allowedFunctions = ["createCustomer", "updateCustomer", "deleteCustomer", "getCustomers"];

        if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
            $result = call_user_func($functionName, $params);
            echo json_encode($result);
        } else {
            echo json_encode(["status" => "error", "message" => "Hàm không tồn tại hoặc không được phép!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Thiếu function hoặc params không hợp lệ"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Xử lý GET request để lấy danh sách khách hàng
    getCustomers();
} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ!"]);
}

?>
