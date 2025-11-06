<?php
// نام فایل دیتابیس ما
$data_file = 'data.txt';

// تعیین می‌کنیم که محتوا از نوع JSON است
header('Content-Type: application/json');

// بررسی می‌کنیم که درخواست از نوع GET است یا POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // --- حالت خواندن (Load) ---
    // اگر فایل وجود داشت، محتوای آن را بخوان و برای اپلیکیشن بفرست
    if (file_exists($data_file)) {
        echo file_get_contents($data_file);
    } else {
        // اگر فایل وجود نداشت (مثلاً اجرای بار اول)، دیتای خالی بفرست
        echo json_encode([
            'totalIncome' => 0,
            'totalExpense' => 0,
            'expenseLabels' => [],
            'expenseData' => []
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- حالت نوشتن (Save) ---
    // دیتای JSON که از اپلیکیشن فرستاده شده را می‌خوانیم
    $input = file_get_contents('php://input');
    
    // آن را در فایل data.txt ذخیره می‌کنیم
    if (file_put_contents($data_file, $input) !== false) {
        // اگر موفق بود، پیام موفقیت می‌فرستیم
        echo json_encode(['status' => 'success']);
    } else {
        // اگر ناموفق بود (مثلاً به خاطر دسترسی‌ها)، پیام خطا می‌فرستیم
        echo json_encode(['status' => 'error', 'message' => 'Cannot write to file. Check permissions.']);
    }
}
?>