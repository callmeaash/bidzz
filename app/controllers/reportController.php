<?php
require_once __DIR__ . '/../models/Report.php';

class ReportController {

    public function handle($target_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            $reason = isset($input['reason']) ? trim($input['reason']) : null;
            $details = isset($input['details']) ? trim($input['details']) : null;
            
            if (!$reason) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Reason is required']);
                return;
            }

            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'You must be logged in']);
                return;
            }

            $reporter_id = $_SESSION['user_id'];

            $report_id = Report::add($reporter_id, $target_id, $reason, $details);

            if ($report_id) {
                echo json_encode(['success' => true, 'report_id' => $report_id]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to submit report']);
            }
        }
    }
}