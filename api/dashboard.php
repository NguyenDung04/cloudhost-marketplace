<?php
// website_cloudvps/api/dashboard.php

// Thiết lập header JSON
header('Content-Type: application/json; charset=utf-8');

// Xử lý CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Thiết lập timezone
date_default_timezone_set("Asia/Ho_Chi_Minh");

// Kết nối database trực tiếp
function connectDB() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'website_cloudvps';
    
    $conn = mysqli_connect($host, $username, $password, $database);
    
    if (!$conn) {
        return false;
    }
    
    mysqli_set_charset($conn, "utf8mb4");
    return $conn;
}

// Hàm thực hiện query
function dbQuery($sql) {
    $conn = connectDB();
    if (!$conn) {
        return ['error' => 'Database connection failed'];
    }
    
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $error = mysqli_error($conn);
        mysqli_close($conn);
        return ['error' => "Query failed: $error"];
    }
    
    // Nếu là SELECT query, lấy dữ liệu
    if (strpos(strtoupper($sql), 'SELECT') === 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result);
    } else {
        $data = mysqli_affected_rows($conn);
    }
    
    mysqli_close($conn);
    return $data;
}

// Hàm lấy một dòng dữ liệu
function dbFetch($sql) {
    $conn = connectDB();
    if (!$conn) {
        return false;
    }
    
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        mysqli_close($conn);
        return false;
    }
    
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
    
    return $row ?: false;
}

// Hàm đếm số lượng
function dbCount($sql) {
    $conn = connectDB();
    if (!$conn) {
        return 0;
    }
    
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        mysqli_close($conn);
        return 0;
    }
    
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    mysqli_close($conn);
    
    return $row ? (int)$row[0] : 0;
}

// Hàm tính tổng
function dbSum($sql) {
    $conn = connectDB();
    if (!$conn) {
        return 0;
    }
    
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        mysqli_close($conn);
        return 0;
    }
    
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    mysqli_close($conn);
    
    return $row ? (float)$row[0] : 0;
}

// Lấy thống kê doanh thu - TRUY VẤN BẢNG orders (total_money)
function getRevenueStats() {
    // Doanh thu hôm nay
    $todayStart = strtotime('today');
    $todayEnd = strtotime('today 23:59:59');
    $todayRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong' AND created_at >= '$todayStart' AND created_at <= '$todayEnd'");
    
    // Doanh thu hôm qua
    $yesterdayStart = strtotime('yesterday');
    $yesterdayEnd = strtotime('yesterday 23:59:59');
    $yesterdayRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong' AND created_at >= '$yesterdayStart' AND created_at <= '$yesterdayEnd'");
    $todayChange = calculateChange($todayRevenue, $yesterdayRevenue);
    
    // Doanh thu tháng này
    $monthStart = strtotime('first day of this month');
    $monthEnd = strtotime('last day of this month 23:59:59');
    $monthRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong' AND created_at >= '$monthStart' AND created_at <= '$monthEnd'");
    
    // Doanh thu tháng trước
    $lastMonthStart = strtotime('first day of last month');
    $lastMonthEnd = strtotime('last day of last month 23:59:59');
    $lastMonthRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong' AND created_at >= '$lastMonthStart' AND created_at <= '$lastMonthEnd'");
    $monthChange = calculateChange($monthRevenue, $lastMonthRevenue);
    
    // Doanh thu năm nay
    $yearStart = strtotime('first day of January this year');
    $yearEnd = strtotime('last day of December this year 23:59:59');
    $yearRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong' AND created_at >= '$yearStart' AND created_at <= '$yearEnd'");
    
    // Doanh thu năm trước
    $lastYearStart = strtotime('first day of January last year');
    $lastYearEnd = strtotime('last day of December last year 23:59:59');
    $lastYearRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong' AND created_at >= '$lastYearStart' AND created_at <= '$lastYearEnd'");
    $yearChange = calculateChange($yearRevenue, $lastYearRevenue);
    
    // Tổng doanh thu
    $totalRevenue = dbSum("SELECT COALESCE(SUM(total_money), 0) FROM orders WHERE status = 'thanhcong'");
    
    return [
        'id' => 'revenue',
        'title' => 'Doanh Thu',
        'iconSet' => [
            'day' => 'fas fa-coins text-success',
            'month' => 'fas fa-chart-line text-primary',
            'year' => 'fas fa-calendar-alt fs-4',
            'total' => 'fas fa-wallet text-dark'
        ],
        'data' => [
            'day' => [
                'value' => formatCurrency($todayRevenue),
                'change' => formatChange($todayChange, 'so với hôm qua'),
                'color' => 'success'
            ],
            'month' => [
                'value' => formatCurrency($monthRevenue),
                'change' => formatChange($monthChange, 'so với tháng trước'),
                'color' => 'primary'
            ],
            'year' => [
                'value' => formatCurrency($yearRevenue),
                'change' => formatChange($yearChange, 'so với năm trước'),
                'color' => 'info'
            ],
            'total' => [
                'value' => formatCurrency($totalRevenue),
                'change' => 'Tổng doanh thu hệ thống',
                'color' => 'dark'
            ]
        ]
    ];
}

// Lấy thống kê thành viên
function getMemberStats() {
    // Thành viên hôm nay
    $todayStart = strtotime('today');
    $todayEnd = strtotime('today 23:59:59');
    $todayMembers = dbCount("SELECT COUNT(*) FROM users WHERE createdate >= '$todayStart' AND createdate <= '$todayEnd'");
    
    // Thành viên hôm qua
    $yesterdayStart = strtotime('yesterday');
    $yesterdayEnd = strtotime('yesterday 23:59:59');
    $yesterdayMembers = dbCount("SELECT COUNT(*) FROM users WHERE createdate >= '$yesterdayStart' AND createdate <= '$yesterdayEnd'");
    $todayChange = calculateChange($todayMembers, $yesterdayMembers);
    
    // Thành viên tháng này
    $monthStart = strtotime('first day of this month');
    $monthEnd = strtotime('last day of this month 23:59:59');
    $monthMembers = dbCount("SELECT COUNT(*) FROM users WHERE createdate >= '$monthStart' AND createdate <= '$monthEnd'");
    
    // Thành viên tháng trước
    $lastMonthStart = strtotime('first day of last month');
    $lastMonthEnd = strtotime('last day of last month 23:59:59');
    $lastMonthMembers = dbCount("SELECT COUNT(*) FROM users WHERE createdate >= '$lastMonthStart' AND createdate <= '$lastMonthEnd'");
    $monthChange = calculateChange($monthMembers, $lastMonthMembers);
    
    // Thành viên năm nay
    $yearStart = strtotime('first day of January this year');
    $yearEnd = strtotime('last day of December this year 23:59:59');
    $yearMembers = dbCount("SELECT COUNT(*) FROM users WHERE createdate >= '$yearStart' AND createdate <= '$yearEnd'");
    
    // Thành viên năm trước
    $lastYearStart = strtotime('first day of January last year');
    $lastYearEnd = strtotime('last day of December last year 23:59:59');
    $lastYearMembers = dbCount("SELECT COUNT(*) FROM users WHERE createdate >= '$lastYearStart' AND createdate <= '$lastYearEnd'");
    $yearChange = calculateChange($yearMembers, $lastYearMembers);
    
    // Tổng thành viên
    $totalMembers = dbCount("SELECT COUNT(*) FROM users");
    
    return [
        'id' => 'members',
        'title' => 'Thành Viên',
        'iconSet' => [
            'day' => 'fas fa-user text-success',
            'month' => 'fas fa-user-friends text-primary',
            'year' => 'fas fa-users text-info',
            'total' => 'fas fa-user-check text-dark'
        ],
        'data' => [
            'day' => [
                'value' => $todayMembers,
                'change' => formatChange($todayChange, 'so với hôm qua'),
                'color' => 'success'
            ],
            'month' => [
                'value' => $monthMembers,
                'change' => formatChange($monthChange, 'so với tháng trước'),
                'color' => 'primary'
            ],
            'year' => [
                'value' => $yearMembers,
                'change' => formatChange($yearChange, 'so với năm trước'),
                'color' => 'info'
            ],
            'total' => [
                'value' => $totalMembers,
                'change' => 'Tổng thành viên hệ thống',
                'color' => 'dark'
            ]
        ]
    ];
}

// Lấy thống kê đơn hàng
function getOrderStats() {
    // Đơn hàng hôm nay
    $todayStart = strtotime('today');
    $todayEnd = strtotime('today 23:59:59');
    $todayOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong' AND created_at >= '$todayStart' AND created_at <= '$todayEnd'");
    
    // Đơn hàng hôm qua
    $yesterdayStart = strtotime('yesterday');
    $yesterdayEnd = strtotime('yesterday 23:59:59');
    $yesterdayOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong' AND created_at >= '$yesterdayStart' AND created_at <= '$yesterdayEnd'");
    $todayChange = calculateChange($todayOrders, $yesterdayOrders);
    
    // Đơn hàng tháng này
    $monthStart = strtotime('first day of this month');
    $monthEnd = strtotime('last day of this month 23:59:59');
    $monthOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong' AND created_at >= '$monthStart' AND created_at <= '$monthEnd'");
    
    // Đơn hàng tháng trước
    $lastMonthStart = strtotime('first day of last month');
    $lastMonthEnd = strtotime('last day of last month 23:59:59');
    $lastMonthOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong' AND created_at >= '$lastMonthStart' AND created_at <= '$lastMonthEnd'");
    $monthChange = calculateChange($monthOrders, $lastMonthOrders);
    
    // Đơn hàng năm nay
    $yearStart = strtotime('first day of January this year');
    $yearEnd = strtotime('last day of December this year 23:59:59');
    $yearOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong' AND created_at >= '$yearStart' AND created_at <= '$yearEnd'");
    
    // Đơn hàng năm trước
    $lastYearStart = strtotime('first day of January last year');
    $lastYearEnd = strtotime('last day of December last year 23:59:59');
    $lastYearOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong' AND created_at >= '$lastYearStart' AND created_at <= '$lastYearEnd'");
    $yearChange = calculateChange($yearOrders, $lastYearOrders);
    
    // Tổng đơn hàng
    $totalOrders = dbCount("SELECT COUNT(*) FROM orders WHERE status = 'thanhcong'");
    
    return [
        'id' => 'orders',
        'title' => 'Đơn Hàng',
        'iconSet' => [
            'day' => 'fas fa-shopping-cart text-success',
            'month' => 'fas fa-box-open text-primary',
            'year' => 'fas fa-shopping-bag text-info',
            'total' => 'fas fa-clipboard-list text-dark'
        ],
        'data' => [
            'day' => [
                'value' => $todayOrders,
                'change' => formatChange($todayChange, 'so với hôm qua'),
                'color' => 'success'
            ],
            'month' => [
                'value' => $monthOrders,
                'change' => formatChange($monthChange, 'so với tháng trước'),
                'color' => 'primary'
            ],
            'year' => [
                'value' => $yearOrders,
                'change' => formatChange($yearChange, 'so với năm trước'),
                'color' => 'info'
            ],
            'total' => [
                'value' => $totalOrders,
                'change' => 'Cộng dồn toàn hệ thống',
                'color' => 'dark'
            ]
        ]
    ];
}

// Lấy thống kê support tickets
function getTicketStats() {
    // Tickets hôm nay
    $todayStart = strtotime('today');
    $todayEnd = strtotime('today 23:59:59');
    $todayTickets = dbCount("SELECT COUNT(*) FROM chat_logs WHERE created_at >= '$todayStart' AND created_at <= '$todayEnd'");
    
    // Tickets hôm qua
    $yesterdayStart = strtotime('yesterday');
    $yesterdayEnd = strtotime('yesterday 23:59:59');
    $yesterdayTickets = dbCount("SELECT COUNT(*) FROM chat_logs WHERE created_at >= '$yesterdayStart' AND created_at <= '$yesterdayEnd'");
    $todayChange = calculateChange($todayTickets, $yesterdayTickets);
    
    // Tickets tháng này
    $monthStart = strtotime('first day of this month');
    $monthEnd = strtotime('last day of this month 23:59:59');
    $monthTickets = dbCount("SELECT COUNT(*) FROM chat_logs WHERE created_at >= '$monthStart' AND created_at <= '$monthEnd'");
    
    // Tickets tháng trước
    $lastMonthStart = strtotime('first day of last month');
    $lastMonthEnd = strtotime('last day of last month 23:59:59');
    $lastMonthTickets = dbCount("SELECT COUNT(*) FROM chat_logs WHERE created_at >= '$lastMonthStart' AND created_at <= '$lastMonthEnd'");
    $monthChange = calculateChange($monthTickets, $lastMonthTickets);
    
    // Tickets năm nay
    $yearStart = strtotime('first day of January this year');
    $yearEnd = strtotime('last day of December this year 23:59:59');
    $yearTickets = dbCount("SELECT COUNT(*) FROM chat_logs WHERE created_at >= '$yearStart' AND created_at <= '$yearEnd'");
    
    // Tickets năm trước
    $lastYearStart = strtotime('first day of January last year');
    $lastYearEnd = strtotime('last day of December last year 23:59:59');
    $lastYearTickets = dbCount("SELECT COUNT(*) FROM chat_logs WHERE created_at >= '$lastYearStart' AND created_at <= '$lastYearEnd'");
    $yearChange = calculateChange($yearTickets, $lastYearTickets);
    
    // Tổng tickets
    $totalTickets = dbCount("SELECT COUNT(*) FROM chat_logs");
    
    return [
        'id' => 'supportTickets',
        'title' => 'Ticket Hỗ Trợ',
        'iconSet' => [
            'day' => 'fas fa-ticket-alt text-danger',
            'month' => 'fas fa-headset text-warning',
            'year' => 'fas fa-life-ring text-info',
            'total' => 'fas fa-inbox text-dark'
        ],
        'data' => [
            'day' => [
                'value' => $todayTickets,
                'change' => formatChange($todayChange, 'so với hôm qua'),
                'color' => 'danger'
            ],
            'month' => [
                'value' => $monthTickets,
                'change' => formatChange($monthChange, 'so với tháng trước'),
                'color' => 'warning'
            ],
            'year' => [
                'value' => $yearTickets,
                'change' => formatChange($yearChange, 'so với năm trước'),
                'color' => 'success'
            ],
            'total' => [
                'value' => $totalTickets,
                'change' => 'Đang chờ xử lý / đã đóng',
                'color' => 'dark'
            ]
        ]
    ];
}

// Lấy thống kê Hosting bán được
function getHostingStats() {
    // Hosting hôm nay
    $todayStart = strtotime('today');
    $todayEnd = strtotime('today 23:59:59');
    $todayHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting WHERE time >= '$todayStart' AND time <= '$todayEnd'");
    
    // Hosting hôm qua
    $yesterdayStart = strtotime('yesterday');
    $yesterdayEnd = strtotime('yesterday 23:59:59');
    $yesterdayHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting WHERE time >= '$yesterdayStart' AND time <= '$yesterdayEnd'");
    $todayChange = calculateChange($todayHosting, $yesterdayHosting);
    
    // Hosting tháng này
    $monthStart = strtotime('first day of this month');
    $monthEnd = strtotime('last day of this month 23:59:59');
    $monthHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting WHERE time >= '$monthStart' AND time <= '$monthEnd'");
    
    // Hosting tháng trước
    $lastMonthStart = strtotime('first day of last month');
    $lastMonthEnd = strtotime('last day of last month 23:59:59');
    $lastMonthHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting WHERE time >= '$lastMonthStart' AND time <= '$lastMonthEnd'");
    $monthChange = calculateChange($monthHosting, $lastMonthHosting);
    
    // Hosting năm nay
    $yearStart = strtotime('first day of January this year');
    $yearEnd = strtotime('last day of December this year 23:59:59');
    $yearHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting WHERE time >= '$yearStart' AND time <= '$yearEnd'");
    
    // Hosting năm trước
    $lastYearStart = strtotime('first day of January last year');
    $lastYearEnd = strtotime('last day of December last year 23:59:59');
    $lastYearHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting WHERE time >= '$lastYearStart' AND time <= '$lastYearEnd'");
    $yearChange = calculateChange($yearHosting, $lastYearHosting);
    
    // Tổng Hosting
    $totalHosting = dbCount("SELECT COUNT(*) FROM history_buy_hosting");
    
    return [
        'id' => 'hostingSold',
        'title' => 'Hosting Bán Được',
        'iconSet' => [
            'day' => 'fas fa-hdd text-success',
            'month' => 'fas fa-database text-primary',
            'year' => 'fas fa-server text-info',
            'total' => 'fas fa-network-wired text-dark'
        ],
        'data' => [
            'day' => [
                'value' => $todayHosting,
                'change' => formatChange($todayChange, 'so với hôm qua'),
                'color' => 'success'
            ],
            'month' => [
                'value' => $monthHosting,
                'change' => formatChange($monthChange, 'so với tháng trước'),
                'color' => 'primary'
            ],
            'year' => [
                'value' => $yearHosting,
                'change' => formatChange($yearChange, 'so với năm trước'),
                'color' => 'info'
            ],
            'total' => [
                'value' => $totalHosting,
                'change' => 'Cộng dồn toàn hệ thống',
                'color' => 'dark'
            ]
        ]
    ];
}

// Lấy thống kê tổng số dư thành viên - TRUY VẤN BẢNG users (money)
function getUserBalanceStats() {
    // Tính tổng số dư từ cột money trong bảng users
    // Chỉ tính user không bị ban (band = 0) và đã xác thực email (veri_email = 'on')
    $totalBalance = dbSum("SELECT COALESCE(SUM(money), 0) FROM users WHERE band = 0 AND veri_email = 'on'");
    
    // Hoặc nếu muốn tính tất cả user (kể cả chưa xác thực email và bị ban):
    // $totalBalance = dbSum("SELECT COALESCE(SUM(money), 0) FROM users");
    
    return [
        'id' => 'userBalance',
        'title' => 'Tổng Số Dư Thành Viên',
        'iconSet' => [
            'total' => 'fas fa-wallet text-success'
        ],
        'data' => [
            'total' => [
                'value' => formatCurrency($totalBalance),
                'change' => 'Tổng tiền trong ví thành viên',
                'color' => 'success'
            ]
        ]
    ];
}

// Hàm tính phần trăm thay đổi
function calculateChange($current, $previous) {
    if ($previous == 0) {
        return $current > 0 ? 100 : 0;
    }
    return (($current - $previous) / $previous) * 100;
}

// Hàm định dạng phần trăm thay đổi
function formatChange($change, $text) {
    $prefix = $change >= 0 ? '+' : '';
    return sprintf('%s%.1f%% %s', $prefix, $change, $text);
}

// Hàm định dạng tiền tệ
function formatCurrency($amount) {
    if ($amount >= 1000000000) {
        return number_format($amount / 1000000000, 1) . 'B';
    } elseif ($amount >= 1000000) {
        return number_format($amount / 1000000, 1) . 'M';
    } elseif ($amount >= 1000) {
        return number_format($amount / 1000, 1) . 'K';
    }
    return number_format($amount, 0);
}

// ============ MAIN API HANDLER ============

try {
    // Kiểm tra phương thức request
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Chỉ hỗ trợ phương thức GET');
    }
    
    // Lấy tất cả thống kê (BỎ "VPS Bán Được")
    $stats = [
        'revenue' => getRevenueStats(),
        'members' => getMemberStats(),
        'orders' => getOrderStats(),
        'supportTickets' => getTicketStats(),
        'hostingSold' => getHostingStats(),
        'userBalance' => getUserBalanceStats()
    ];
    
    // Format response theo đúng yêu cầu
    $response = [
        'status' => 'success',
        'message' => 'Lấy dữ liệu Dashboard thành công',
        'data' => array_values($stats)
    ];
    
    // Trả về JSON response
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // Xử lý lỗi
    http_response_code(500);
    $errorResponse = [
        'status' => 'error',
        'message' => $e->getMessage(),
        'data' => []
    ];
    
    echo json_encode($errorResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}