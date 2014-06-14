<?php
//Usage: php generate.php learning_problem.pl

//The program will automatically generate the corresponding translations for the supported ILP systems.
$ilp_systems = array("progol", "toplog", "tal","imparo","aleph");
//where the files for ILP systems should be copied
$default_location = array(
"progol" => "/home/david/Dropbox/Individual project/progol/examples",
"toplog" => "/home/david/Dropbox/Individual project/toplog/examples",
"tal" => "/home/david/Dropbox/Individual project/tal/examples",
"imparo" => "/home/david/Dropbox/Individual project/imparo/examples",
"aleph" => "/home/david/Dropbox/Individual project/aleph"
);
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
    $modeh_declarations=array();
    $modeb_declarations=array();
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
            case "system": $system.=convert_system($ilp_system,$lines[$i]);
                if(preg_match("/modeh\(/",$lines[$i])) {
                    $mode_dec = preg_replace("/modeh\(/","",$lines[$i]);
                    $mode_dec = preg_replace("/\)[.]/","",$mode_dec);
                    array_push($modeh_declarations,$mode_dec);
                }
                
                if(preg_match("/modeb\(/",$lines[$i])) {
                    $mode_dec = preg_replace("/modeb\(/","",$lines[$i]);
                    $mode_dec = preg_replace("/\)[.]/","",$mode_dec);
                    array_push($modeb_declarations,$mode_dec);
                }
            break;
            case "type": $type.=convert_type($ilp_system,$lines[$i]);break;
            case "background": $background.=convert_background($ilp_system,$lines[$i]);break;
            case "positive": $positive.=convert_positive($ilp_system,$lines[$i]);break;
            case "negative": $negative.=convert_negative($ilp_system,$lines[$i]);break;
        }
    }
    
    if($ilp_system=="imparo") {
        $system.="head_modes([".list_array($modeh_declarations)."]).\n";
        $system.="body_modes([".list_array($modeb_declarations)."]).\n";
        $background="%file%imb\n".$background;
        $positive="%file%imx\n".$positive;
    }
    if($ilp_system=="aleph") {
        $positive="%file%f\n".$positive;
        $negative="%file%n\n".$negative;
    }

    output_learning_problem($learning_problem_name, $ilp_system, $system, $type, $background, $positive, $negative);
}

function list_array($array) {
    if(count($array)>0) {
        $list=$array[0];
    } else {
        $list="";
    }
    for($i=1; $i<count($array); $i++) {
        $list.=",".$array[$i];
    }
    return $list;
}

function output_learning_problem($learning_problem_name, $ilp_system, $system, $type, $background, $positive, $negative) {
    global $default_location;
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
    switch($ilp_system) {
        case "imparo":$suffix=".im";break;
        default:$suffix=".pl";
    }
    $file_name=$ilp_system."_".$learning_problem_name.$suffix;
    echo $file_name."\n";
    file_put_contents($default_location[$ilp_system]."/".$file_name, $data);
}



function init_script($ilp_system) {
    switch($ilp_system) {
        case "aleph":break;
        case "progol":
            return ":- set(i,2), set(h,20), set(c,2)?\n";
        break;
        case "toplog":break;
        case "tal":
            return ":- multifile option/2.\n".
                    "option(max_body_literals, 2).\n".
                    "option(score_before_condition, false).\n".
                    "option(max_num_rules, 2).\n".
                    "option(single_seed, false).\n".
                    "option(strategy, full_breadth).\n".
                    "option(max_depth, 200).\n";
        break;
        case "imparo":
            return ":-set_max_clause_length(15).\n".
                    ":-set_max_clauses(5).\n".
                    ":-set_connected(1).\n".//boolean
                    ":-set_max_var_depth(5).\n";
        break;
    }
    return "";
}

function convert_system($ilp_system, $line) {
    switch($ilp_system) {
        case "aleph":
            $line=preg_replace("/modeh\(/", ":-modeh(*,",$line);
            $line=preg_replace("/modeb\(/", ":-modeb(*,",$line);
            $line=preg_replace("/determination\(/", ":-determination(",$line);
            if(preg_match("/dynamic/",$line)) {
                return "";
            }
            return $line."\n";
        break;
        case "progol":
            $line=preg_replace("/[.]/","?",$line);            
            $line=preg_replace("/modeh\(/", ":-modeh(*,",$line);
            $line=preg_replace("/modeb\(/", ":-modeb(*,",$line);
            $line=preg_replace("/determination\(/", ":-determination(",$line);
            if(preg_match("/dynamic/",$line)) {
                return "";
            }
            return $line."\n";
        break;
        
        case "toplog":
            $line=preg_replace("/modeh\(/", ":-modeh(",$line);
            $line=preg_replace("/modeb\(/", ":-modeb(",$line);
            if(preg_match("/determination\(/",$line)) {
                return "";
            }
            if(preg_match("/^dynamic/",$line)) {
                return "";
            }            
            return $line."\n";
        break;
        
        case "tal":
            $line=preg_replace("/dynamic/", ":-dynamic",$line);
            if(preg_match("/determination\(/",$line)) {
                return "";
            }
            return $line."\n";
        break;
        case "imparo":
            return "";
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
        case "aleph":break;
        case "progol":break;
        case "toplog":
        case "tal":
            if(contains_example($line)) {
                return toplog_positive($line);
            }
        break;            
    }
    return $line."\n";
}

function convert_negative($ilp_system, $line) {
    switch($ilp_system) {
        case "aleph":break;
        case "progol":
        case "imparo":
            return progol_negative($line);
        break;
        case "toplog":
        case "tal":
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
