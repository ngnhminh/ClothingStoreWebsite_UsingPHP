<?php
include(__DIR__ . "/../../config/db.php");

header("Content-Type: application/json");

/**
 * Lấy danh sách khách hàng
 */
function getCustomers() {
    global $conn;
    $sql = "SELECT khachhang.*, tk.diemtichluy 
    FROM khachhang 
    LEFT JOIN taikhoan tk ON khachhang.makh = tk.makh
    ORDER BY khachhang.makh ASC;
    ";
    $result = $conn->query($sql);

    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $customers]);
}

function getInvoicesByCustomer($params) {
    global $conn;
    $makh = $params['makh'];
    $sql = "SELECT *
            FROM hoadon
            WHERE hoadon.makh = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $makh);
    $stmt->execute();

    $result = $stmt->get_result();
    $hoadons = [];

    while ($row = $result->fetch_assoc()) {
        $hoadons[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $hoadons]);
}

function getInvoiceDetail($params) {
    global $conn;
    $mahd = $params['mahd'];
    $sql = " SELECT sanpham.tensp, chitiethoadon.gia, chitiethoadon.soluong, chitiethoadon.size, chitiethoadon.mau
            FROM chitiethoadon INNER JOIN sanpham
            ON chitiethoadon.masp = sanpham.id
            WHERE chitiethoadon.mahoadon = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mahd);
    $stmt->execute();

    $result = $stmt->get_result();
    $chitiethoadons = [];

    while ($row = $result->fetch_assoc()) {
        $chitiethoadons[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $chitiethoadons]);
}

function getCustomerById($params) {
    global $conn;
    $makh = $params['makh'];

    $sql = "SELECT *
            FROM khachhang 
            LEFT JOIN taikhoan tk ON khachhang.makh = tk.makh
            WHERE khachhang.makh = ?
            ORDER BY khachhang.makh ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $makh);
    $stmt->execute();

    $result = $stmt->get_result();
    $customers = [];

    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $customers[0] ?? null]);
}

function getCustomerByName($params) {
    global $conn;
    $tenkhachhang = $params['tenkhachhang'];

    // Thêm dấu '%' vào từ khóa để tìm kiếm gần đúng
    $searchTerm = '%' . $tenkhachhang . '%';

    $sql = "SELECT *
            FROM khachhang 
            LEFT JOIN taikhoan tk ON khachhang.makh = tk.makh
            WHERE khachhang.hoten LIKE ?
            ORDER BY khachhang.makh ASC";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchTerm);  // Truyền tham số với kiểu "s" cho chuỗi
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();
    $customers = [];

    // Duyệt qua kết quả và thêm vào mảng
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    // Trả về dữ liệu dưới dạng JSON
    echo json_encode(["status" => "success", "data" => $customers ?: null]);
}

function getUserByUsername($param) {
    global $conn;
    $tentaikhoan = $param['tennguoidung'];
    $sql = "SELECT * FROM taikhoan WHERE tentaikhoan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param( "s", $tentaikhoan);
    $stmt->execute();
    // Lấy kết quả
    $result = $stmt->get_result();
    $usernames = [];

    // Duyệt qua kết quả và thêm vào mảng
    while ($row = $result->fetch_assoc()) {
        $usernames[] = $row;
    }

    // Trả về dữ liệu dưới dạng JSON
    echo json_encode(["status" => "success", "data" => $usernames[0] ?: null]);
}

function getUserByEmail($param) {
    global $conn;
    $email = $param['email'];
    $sql = "SELECT * from khachhang where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param( "s", $email);
    $stmt->execute();
    // Lấy kết quả
    $result = $stmt->get_result();
    $usernames = [];

    // Duyệt qua kết quả và thêm vào mảng
    while ($row = $result->fetch_assoc()) {
        $usernames[] = $row;
    }

    // Trả về dữ liệu dưới dạng JSON
    echo json_encode(["status" => "success", "data" => $usernames[0] ?: null]);
}

/**
 * Thêm khách hàng mới
 */

function createUserAndCustomer($data) {
    global $conn;
    
    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";
    $hoten = $data["hoten"] ?? "";
    $sdt = $data["sdt"] ?? "";
    $email = $data["email"] ?? "";

    // Bước 1: Thêm khách hàng vào bảng khachhang
    $sql_kh = "INSERT INTO khachhang (hoten, sdt, email) VALUES (?, ?, ?)";
    $stmt_kh = mysqli_prepare($conn, $sql_kh);
    if (!$stmt_kh) return false;

    mysqli_stmt_bind_param($stmt_kh, "sss",  $hoten, $sdt, $email);
    $success_kh = mysqli_stmt_execute($stmt_kh);
    if (!$success_kh) return false;

    $makh = mysqli_insert_id($conn); // Lấy mã khách hàng vừa tạo
    mysqli_stmt_close($stmt_kh);

    // Bước 2: Thêm tài khoản vào bảng taikhoan
    $sql_tk = "INSERT INTO taikhoan (tentaikhoan, matkhau, diemtichluy, makh) VALUES (?, ?, 0, ?)";
    $stmt_tk = mysqli_prepare($conn, $sql_tk);
    if (!$stmt_tk) return false;

    mysqli_stmt_bind_param($stmt_tk, "ssi", $username, $password, $makh);
    $success_tk = mysqli_stmt_execute($stmt_tk);
    mysqli_stmt_close($stmt_tk);

    return $success_tk;
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
        $allowedFunctions = ["createCustomer", "updateCustomer", "deleteCustomer", "getCustomers", "getCustomerById", "getInvoicesByCustomer", "getInvoiceDetail", "getCustomerByName", "createUserAndCustomer", "getUserByUsername", "getUserByEmail"];

        if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
            call_user_func($functionName, $params);
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
