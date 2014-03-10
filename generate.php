<?php
$ilp_systems = array("progol", "toplog");
//Generator of the ILP learning problems for different ILP systems from a universal script.
//Takes as input arguments a universal learning problem.

$learning_problem_file=$argv[1];
$learning_problem_name=basename($learning_problem_file,".pl");
$learning_problem=file_get_contents($learning_problem_file);

foreach($ilp_systems as $ilp_system) {
    create_conversion($learning_problem, $learning_problem_name, $ilp_system);
}

function create_conversion($learning_problem, $learning_problem_name, $ilp_system) {
    $lines=split("\n",$learning_problem);
    //A learning problem should be divided into parts: system, types declarations, background knowledge, positive examples, negative examples
    $system="";$type="";$background="";$positive="";$negative="";
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
            case "system": $system.=convert_system($ilp_system,$lines[$i]);break;
            case "type": $type.=convert_type($ilp_system,$lines[$i]);break;
            case "background": $background.=convert_background($ilp_system,$lines[$i]);break;
            case "positive": $positive.=convert_positive($ilp_system,$lines[$i]);break;
            case "negative": $negative.=convert_negative($ilp_system,$lines[$i]);break;
        }
    }

    output_learning_problem($learning_problem_name, $ilp_system, $system, $type, $background, $positive, $negative);
}

function output_learning_problem($learning_problem_name, $ilp_system, $system, $type, $background, $positive, $negative) {
    switch($ilp_system) {
        case "progol":break;
    }        
    
    //canonical output
    $data="%$ilp_system, $learning_problem_name\n";    
    $data.=$system.$type;
    $data.=$background;
    $data.=$positive;
    $data.=$negative;
    //echo $data;
    $file_name=$ilp_system."_".$learning_problem_name.".pl";
    echo $file_name."\n";
    file_put_contents($file_name, $data);
}



function init_script($ilp_system) {
    switch($ilp_system) {
        case "progol":
            return ":- set(i,2), set(h,20), set(c,2)?\n";
        break;
    }
}

function convert_system($ilp_system, $line) {
    switch($ilp_system) {
        case "progol":
            $line=preg_replace("/[.]/","?",$line);            
            $line=preg_replace("/modeh\(/", ":-modeh(*,",$line);
            $line=preg_replace("/modeb\(/", ":-modeb(*,",$line);
            $line=preg_replace("/determination\(/", ":-determination(",$line);
            return $line."\n";
        break;
        
        case "toplog":
            $line=preg_replace("/modeh\(/", ":-modeh(",$line);
            $line=preg_replace("/modeb\(/", ":-modeb(",$line);
            if(preg_match("/determination\(/",$line)) {
                return "";
            }            
            return $line."\n";
        break;
    }
    return $line."\n";
}

function convert_type($ilp_system, $line) {
    //all ILP systems specify the type information in the same way.  
    return $line."\n";
}

function convert_background($ilp_system, $line) {
    //all ILP systems have the background knowledge specified in the same way.
    return $line."\n";
}

function convert_positive($ilp_system, $line) {
    switch($ilp_system) {
        case "progol":break;
        case "toplog":
            if(contains_example($line)) {
                return toplog_positive($line);
            }
        break;            
    }
    return $line."\n";
}

function convert_negative($ilp_system, $line) {
    switch($ilp_system) {
        case "progol":
            return progol_negative($line);
        break;
        case "toplog":
            if(contains_example($line)) {
                return toplog_negative($line);
            }
        break;
    }
    return $line."\n";
}

function progol_negative($line) {
    if(contains_example($line)) {
        $line=":-".$line;
    }                   
    return $line."\n"; 
}

function toplog_positive($example) {
    return toplog_example($example,1);
}

function toplog_negative($example) {
    return toplog_example($example,-1);
}

function toplog_example($example,$weight) {
    $example=preg_replace("/[.]/","",$example);  
    return "example($example,$weight).\n";
}

function contains_example($line) {
    return preg_match("/^[a-zA-Z]/",$line);
}

?>
