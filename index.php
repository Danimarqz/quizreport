<?php
// local/quizreport/index.php

require_once(__DIR__ . '/../../config.php');
require_login();
$context = context_system::instance();
require_capability('local/quizreport:generate', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/quizreport/index.php'));
$PAGE->set_title('Exportar informe de quizzes');
$PAGE->set_heading('Exportar informe de quizzes');
$exportpath = $CFG->dirroot . '/exports/informe_quizzes.xlsx';
echo $OUTPUT->header();

// Si el formulario se ha enviado, ejecutamos el script y mostramos mensaje.
if (optional_param('generate', false, PARAM_BOOL)) {
    $cmd = '/opt/quizreport-venv/bin/python ' . escapeshellarg($CFG->dataroot . '/exports/genera_informe.py') . ' 2>&1';
    $output = shell_exec($cmd);

    if (file_exists($exportpath)) {
        echo $OUTPUT->notification('Informe generado correctamente.', 'notifysuccess');
    } else {
    echo $OUTPUT->notification('Error generando el informe:<br>' . s($output), 'notifyproblem');
    }
}

echo html_writer::start_tag('div', ['class'=>'buttons']);
echo html_writer::tag('a', 'Generar y descargar informe',
    [
        'href' => new moodle_url('/local/quizreport/index.php', ['generate'=>1]),
        'class'=> 'btn btn-primary'
    ]
);
echo html_writer::end_tag('div');

// Si existe el fichero, mostramos el enlace de descarga
if (file_exists($exportpath)) {
    date_default_timezone_set('Europe/Madrid');
    $meses = [
        1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
    ];

    $timestamp = filemtime($exportpath);

    $dia = date('j', $timestamp);
    $mes = $meses[(int)date('n', $timestamp)];
    $hora = date('H:i', $timestamp);
    // Obtener fecha y hora de modificación del archivo
    $downloadurl = new moodle_url('/exports/informe_quizzes.xlsx');
    echo html_writer::tag('p',
        html_writer::link($downloadurl, 'Descargar informe de quizzes. Generado el ' . $dia . ' de ' . $mes . ' a las ' . $hora)
    );
}

echo $OUTPUT->footer();