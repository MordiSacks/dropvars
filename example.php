<?php

use function DropVars\dropVars;

require __DIR__ . '/vendor/autoload.php';

$str = <<<STR
Hi, My name is {{first_name}} 
and my family name is {{last_name}},
To sum it up, my name is {{full_name}}.
I am a {{job_title}}.
To use my function just write your vars like this @{{code}}
STR;

$vars = [
    'first_name' => 'John',
    'last_name'  => 'Doe',
    'full_name'  => 'John Doe',
    'job_title'  => 'Space Cowboy',
];

$a = dropVars($str, $vars);

echo $a;


$str = <<<STR
Hi, My name is {ppfirst_name%} 
and my family name is {pplast_name%},
To sum it up, my name is {ppfull_name%}.
I am a {ppjob_title%}.
To use my function just write your vars like this @{ppcode%}
STR;

$vars = [
    'first_name' => 'John',
    'last_name'  => 'Doe',
    'full_name'  => 'John Doe',
    'job_title'  => 'Space Cowboy',
];

$b = dropVars($str, $vars, ['{pp', '%}']);

echo $b;

