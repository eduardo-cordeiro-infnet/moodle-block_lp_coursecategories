<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Página com todas as disciplinas e competências do usuário, organizadas por bloco.
 *
 * Exibe todos os blocos em que o usuário está inscrito, incluindo as disciplinas e suas competências.
 *
 * @package    block_lp_coursecategories
 * @copyright  2017 Instituto Infnet {@link http://infnet.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

require_once(__DIR__ . '/../../config.php');

$loggeduserid = $USER->id;
$params = array('userid' => optional_param('userid', $loggeduserid, PARAM_INT));

$url = new moodle_url('/blocks/lp_coursecategories/full_report.php', $params);
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);


$title = get_string('full_report', 'block_lp_coursecategories');
$PAGE->set_title($title);
$PAGE->set_pagelayout('frontpage');

require_login();
if ($params['userid'] !== $loggeduserid && !has_capability('moodle/competency:competencymanage', $context)) {
    $params['userid'] = $loggeduserid;
}

$output = $PAGE->get_renderer('block_lp_coursecategories');
$page = new block_lp_coursecategories\output\plan_list($params['userid']);

echo $output->header() . $OUTPUT->heading($title);
echo $output->render_full_report($page);
echo $output->footer();
