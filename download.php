<?php

require_once('../../config.php');
require_login();
$context = context_system::instance();
require_capability('local/inscripciones:view', $context);

$filename = required_param('file', PARAM_FILE);
$filepath = $CFG->dirroot . '/exports/informe_quizzes.xlsx';

if (!file_exists($filepath)) {
  print_error('filenotfound', 'error');
}


header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
readfile($filepath);
exit;
