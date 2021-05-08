<?php

/**
 * Lorem ipsum generator for Alfred
 *
 * PHP version 7
 *
 * @package  AlfredLipsumWorkflow
 * @author   Marc Hollander <marchollander@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/MGHollander/alfred-lipsum-workflow
 */

require_once 'lib/LoremIpsum.php';

$lipsum = new joshtronic\LoremIpsum();

$type = $argv[1];
$length = !empty($argv[2]) ? intval($argv[2]) : 1;
$tags = !empty($argv[3]) ? explode(',', $argv[3]) : false;
$array = !empty($argv[4]) ? boolval($argv[4]) : false;

/**
 * Characters
 *
 * Generates characters of lorem ipsum.
 *
 * @param integer $count how many characters to generate
 * @param mixed   $tags  string or array of HTML tags to wrap output with
 * @param boolean $array whether an array or a string should be returned
 *
 * @return string generated lorem ipsum characters
 */
function characters($count, $tags, $array)
{
    global $lipsum;

    $character_count = 0;
    $words_count = 0;
    $words_array = array();

    while ($character_count < $count) {
        $word = $lipsum->word();
        $word_length = strlen($word);

        if ($words_count === 0 || $word !== $words_array[$words_count - 1]) {
            $character_count += $word_length + count($words_array);

            array_push($words_array, $word);

            $words_count = count($words_array);
        }
    }

    $words = implode(' ', $words_array);
    $words = substr($words, 0, $count);

    $last_character = substr($words, -1);

    if ($last_character === ' ') {
        $words = substr($words, 0, -1) . substr($lipsum->word(), 0, 1);
    }

    return $lipsum->output([$words], $tags, $array);
}

switch ($type) {
    case 'characters':
            $output = characters($length, $tags, $array);
        break;
    case 'words':
            $output = $lipsum->words($length, $tags, $array);
        break;
    case 'sentences':
            $output = $lipsum->sentences($length, $tags, $array);
        break;
    case 'paragraphs':
            $output = $lipsum->paragraphs($length, $tags, $array);
        break;
}

echo ucfirst($output);
