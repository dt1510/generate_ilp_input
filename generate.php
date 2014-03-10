<?php
//Generator of the ILP learning problems for different ILP systems from a universal script.
//Takes as input arguments a universal learning problem.

$learning_problem_file=$argv[1];
$learning_problem=file_get_contents($learning_problem_file);

$lines=split("\n",$learning_problem);
//A learning problem should be divided into parts: system, types declarations, background knowledge, positive examples, negative examples

$ilp_system="progol";
$system="";$type="";$background="";$positive="";$negative="";
$output="";
$system=init_script($ilp_system);
$part="system";
for($i=0; $i<count($lines); $i++) {
    if(preg_match('/%background/',$lines[$i])) {
        $part="background";
    } else if(preg_match('/%type/',$lines[$i])) {
        $part="type";
    } else if(preg_match('/%positive/',$lines[$i])) {
        $part="positive";
    } else if(preg_match('/%negative/',$lines[$i])) {
        $part="negative";
    }
    
    switch($part) {
        case "system": $system.=convert_system($lines[$i],$ilp_system);break;
        case "type": $type.=convert_type($lines[$i],$ilp_system);break;
        case "background": $background.=convert_background($lines[$i]);break;
        case "positive": $positive.=convert_positive($lines[$i]);break;
        case "negative": $negative.=convert_negative($lines[$i]);break;
    }
}



echo "positive $positive";
echo count($lines);
echo "\n";

function init_script($ilp_system) {
    switch($ilp_system) {
        case "progol":
            return ":- set(i,2), set(h,20), set(c,2)?\n";
        break;
    }
}

function convert_system($line, $ilp_system) {
    switch($ilp_system) {
        case "progol":
            $line=preg_replace("modeh(",":-modeh(",$line);
            $line=preg_replace("modeb(",":-modeb(",$line);
            return ":- set(i,2), set(h,20), set(c,2)?\n";
        break;
    }
    return $line;
}

function convert_type($line, $ilp_system) {
    switch($ilp_system) {
        case "progol":
            return "";
        break;
    }
    return $line;
}

function convert_background($line, $ilp_system) {
    return $line;
}

function convert_positive($line, $ilp_system) {
    return $line;
}

function convert_negative($line, $ilp_system) {
    return $line;
}


?>
