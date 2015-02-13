<?php
header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
$year =  $_POST['year'];
$number = $_POST['number'];
$add_major = $_POST['add_major'];
$school_id = $_POST['school_id'];

error_reporting(0);
$year = substr($year, -2);

if (file_exists('../include/js/school_major_class.js')){
	copy('../include/js/school_major_class.js', '../include/js/school_major_class_' . time() . '.js');
    $file = file('../include/js/school_major_class.js');
    $length = count($file);
    
    //处理完成置1，加速后续处理
    $flag_majorcat = 0;
    $flag_gradecat = 0;
    $flag_classcat = 0;
    for ($i = 0; $i < $length; $i++){
        //只要还有一个就继续
        if (!$flag_majorcat || !$flag_classcat || !$flag_gradecat){
            if (!$flag_majorcat){
                if (FALSE !== strpos($file[$i], 'majorcat')){
                    //发现目标
                    //跳过声明
                    for ($i++; $i < $length; $i++){
                        //必须连续  
                        preg_match_all('/\d{1,3}/', $file[$i], $school);
                        
                        if ($school[0][1] == $school_id){                                                          
                            
                            $max_major_id = "";
                            while (1){                                
                                preg_match_all('/\d{1,3}/', $file[$i], $major);
                                if ($major[0][1] == $school_id){
                                    $max_major_id = $major[0][2];
                                    if (FALSE !== strpos($file[$i], $add_major)){
                                        $flag_majorcat = 1;
                                        $major_id = $max_major_id;
//                                        echo $major_id;
                                        break;
                                    }
                                    $i++;
                                } else { 
                                    //专业id GET！
                                    $major_id = str_pad(++$max_major_id, 2, '0', STR_PAD_LEFT);
                                    break;
                                } 
                            }                                                                     
                        }   
                        
                        //如果专业已存在
                        if ($flag_majorcat == 1){
                            break;
                        }
                        
                        //如果未在下一个发现，则停止
                        if (FALSE === strpos($file[$i], 'majorcat')){
                            $flag_majorcat = 1;
                            ++$array_id;
                            $i--;
                            $file[$i] .= "majorcat[$array_id] = new Array(\"$add_major\", \"$school_id\", \"$major_id\");\r\n";
                            break;
                        } else {
                            //获取数组key
                            $array_id = $school[0][0];
                        }
                    }
                }
            }
            
            
            $array_id = 0;
            if (!$flag_gradecat){
                if (FALSE !== strpos($file[$i], 'gradecat')){
                    //跳过声明
                    for ($i++; $i < $length; $i++){
                        //必须连续  
                        preg_match_all('/\d{1,3}/', $file[$i], $grade);                       
                        
                        //如果未在下一个发现，则停止
                        if (FALSE === strpos($file[$i], 'gradecat')){                            
                            $flag_gradecat = 1;
                            ++$array_id;
                            $i--;
                            $file[$i] .= "gradecat[$array_id] = Array(\"20{$year}级\", \"$year\");\r\n";
//                            echo $file[$i];
                            break;
                        } else {                            
                            //获取数组key                            
                            $array_id = $grade[0][0];  
                            if ($grade[0][3] == $year){
                                $flag_gradecat = 1;
                                break;
                            }
                        }
                    }
                }
            }
            
            
            $array_id = 0;
            if (!$flag_classcat){
                if (FALSE !== strpos($file[$i], 'classcat')){
                    //跳过声明
                    for ($i++; $i < $length; $i++){
                        //必须连续  
                        preg_match_all('/\d{1,4}/', $file[$i], $class);                       
                        
                        //如果未在下一个发现，则停止
                        if (FALSE === strpos($file[$i], 'classcat')){                            
                            $flag_classcat = 1;
                            ++$array_id;
                            for ($j = 1, --$i; $j <= $number; $j++){                    
                                $class_id = str_pad($j, 2, '0', STR_PAD_LEFT);
                                $file[$i] .= "classcat[$array_id] = new Array(\"{$add_major}{$year}{$class_id}\", \"{$school_id}\", \"{$major_id}\", \"{$j}\", \"{$year}\");\r\n";
                                $array_id++;
                                    
                            }
                            
//                            echo $file[$i];
                            break;
                        } else {                            
                            //获取数组key                            
                            $array_id = $class[0][0]; 
                        }
                    }
                }
            }
        }
    }
    
    //添加bom头，避免保存成ASCII   
    $file[0] = chr(0xEF) . chr(0xBB) . chr(0xBF) . $file[0];
    file_put_contents('../include/js/school_major_class.js',$file);
    echo '1';
} else {
    echo '0';
}