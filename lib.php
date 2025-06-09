<?php
// local/quizexport/lib.php
defined('MOODLE_INTERNAL') || die();

/**
 * Sirve archivos estáticos (nuestro Excel).
 */
function local_quizexport_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG;

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    if ($filearea !== 'export') {
        send_file_not_found();
    }
    // Sólo usuarios con la capacidad
    require_capability('local/quizreport:generate', $context);

    // El archivo siempre se llamará informe_quizzes.xlsx
    $filepath = $CFG->dataroot . '/quizreport/informe_quizzes.xlsx';
    if (!is_readable($filepath)) {
        send_file_not_found();
    }

    // Envía el archivo
    send_stored_file([
        'contextid'   => $context->id,
        'component'   => 'local_quizreport',
        'filearea'    => 'export',
        'filepath'    => '/',
        'filename'    => 'informe_quizzes.xlsx'
    ], $options, $forcedownload);
}
