<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
header("Content-Type: application/json; charset=utf-8");
$raw = json_decode(file_get_contents("php://input"), true);
$serviceData = "http://localhost/ajax/cloud/get-listvps.php";
$serviceJson = json_decode($serviceData, true);
$packages = $serviceJson["data"] ?? [];

$userMessage = antixss($raw["msg"] ?? "");
$payload = [
    "model" => "gpt-4o-mini",
    "messages" => [
        [
            "role" => "system",
            "content" => "
                Bạn là trợ lý AI kỹ thuật của hệ thống APIIT, nhiệm vụ là tư vấn Cloud VPS/Hosting dựa trên dữ liệu được cung cấp.
                Dưới đây là danh sách gói dịch vụ dưới dạng JSON:
                " . json_encode($packages, JSON_UNESCAPED_UNICODE) . "
                QUY TẮC:
                1. Không được nói bạn là AI, ChatGPT, hoặc mô hình ngôn ngữ.
                2. Nếu được hỏi danh tính → trả lời:
                'Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất.'
                3. Chỉ trả lời về các dịch vụ: Cloud, VPS, Hosting.
                4. Khi tư vấn:
                - Hỏi 2–3 câu để hiểu nhu cầu.
                - Phân tích CPU/RAM/Disk.
                - Chọn đúng 1 gói phù hợp.
                - Giải thích lý do rõ ràng.
                - Đưa link mua gói tương ứng từ JSON.
                - Khi xuất link mua gói, hãy trả về dạng HTML clickable, ví dụ:
                <a href='https://localhost/client/hosting-order/1' target='_blank'>Mua ngay</a>
            "
        ],
        [
            "role" => "user",
            "content" => $userMessage
        ]
    ]
];
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);
if (!isset($data["choices"][0]["message"]["content"])) {
    echo json_encode([
        "response" => "Hệ thống đang quá tải hoặc API lỗi. Vui lòng thử lại!"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
$content = $data["choices"][0]["message"]["content"];
echo json_encode([
    "response" => $content
], JSON_UNESCAPED_UNICODE);