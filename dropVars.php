<?php

namespace DropVars;

/**
 * Drop vars into string
 * like so
 * Hi, {{ name }}
 * Hi, {{name}}
 *
 * To escape use like so
 * Hi, @{{name}}
 *
 * @param string        $string
 * @param array         $vars
 *
 * @param array         $enclosure
 * @param string        $escapeStr
 *
 * @param callable|null $dropCallback
 *
 * @return string
 */
function dropVars(
    string $string,
    array $vars,
    array $enclosure = ['{{', '}}'],
    string $escapeStr = '@',
    callable $dropCallback = null
): string
{

    /**
     * Escape escapeStr and enclosure
     */
    $escapeStr = preg_quote($escapeStr, '/');

    [$open, $close] = array_map(function ($item) {
        return preg_quote($item, '/');
    }, $enclosure);

    /**
     * Search vars and replace with value
     */
    $string =
        preg_replace_callback(
            "/(" . $escapeStr . "?)(" . $open . "\s*((?:(?!" . $open . "|" . $close . ").)*?)\s*" . $close . ")/s",
            function ($matches) use ($vars, $dropCallback) {

                [$original, $escape, $format, $var] = $matches;

                /**
                 * Check if we want to escape the expression
                 */
                if (!empty($escape)) {
                    return $format;
                }

                /** If we have a custom callback, call it */
                if (is_callable($dropCallback)) {
                    $result = $dropCallback($var, $vars);

                    /** If callback returns something use it */
                    if ($result !== false) {
                        return $result;
                    }
                }

                /**
                 * Check if the key exists in the given array
                 */
                if (array_key_exists($var, $vars)) {
                    return $vars[$var];
                }

                /**
                 * Return the format if key not found
                 */
                return $format;

            }, $string);

    return $string;
}
