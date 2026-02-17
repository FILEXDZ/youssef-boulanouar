<?php
// ملف JSON لتخزين الزوار
$file = 'visitors.json';

// إذا كان الطلب POST، أضف زائر جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $visitorId = $data['visitorId'] ?? null;

    if ($visitorId) {
        // الحصول على البيانات الموجودة
        if (file_exists($file)) {
            $visitors = json_decode(file_get_contents($file), true);
        } else {
            $visitors = [
                'total' => 1476,
                'list' => []
            ];
        }

        // إذا كان الزائر جديد، أضفه وزد العداد
        if (!in_array($visitorId, $visitors['list'])) {
            $visitors['list'][] = $visitorId;
            $visitors['total']++;
            file_put_contents($file, json_encode($visitors, JSON_PRETTY_PRINT));
        }

        echo json_encode(['success' => true, 'total' => $visitors['total']]);
    }
    exit;
}

// إذا كان الطلب GET، أرجع عدد الزوار
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($file)) {
        $visitors = json_decode(file_get_contents($file), true);
        echo json_encode(['total' => $visitors['total']]);
    } else {
        echo json_encode(['total' => 14052]);
    }
    exit;
}
?>
