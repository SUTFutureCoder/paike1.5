<?php

/**
 * 以实验室为单位导出数据
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      
*/

require '../include/conn.php';
require 'PHPExcel.php';
require 'PHPExcel/Writer/Excel5.php';

//编辑专业班级字符串，若已在字符串里存在则直接加班级，不加专业，若不存在，则加专业班级；参数1代表专业，参数2代表班级，参数3代表要处理的字符串
function major_class($major,$class,$return)
{
        $len = strpos($return,$major);
        //echo "len = ".$len;
        if(!$len)
        {
                $return = $return.' '.$major.'['.$class.']';
        }
        else
        {
                $cnt = strlen($major);
                $left = substr($return,0,$len+$cnt+6);
                $right = substr($return,$len+$cnt+6);
                //echo "left = ".$left."<br>right = ".$right;
                $return = $left.'['.$class.']'.$right;
        }
        //echo "<br>".$return;
        return $return ;
}

//处理时间
//返回：
//array(
//  '周次', '星期', '节'
//);

function get_time($time_add){
    return array(
        substr($time_add, 10, 2),
        substr($time_add, -1, 1),
        substr($time_add, -2, 1)
    );
}

//是否全局
$global = DB::CheckInput($_GET['global']);

$objPHPExcel = new PHPExcel();
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

$objPHPExcel->getProperties()->setCreator('SUTACM-Paike System');

//$db_year;
if (!$global){
    //指定实验室号
    $address = DB::CheckInput($_GET['address']);
    
    $sql_confirm = sprintf('SELECT address FROM ini_address WHERE address = "%s"', $address);
    $confirm_result = $conn->query($sql_confirm);
    if (!$confirm_result->num_rows){
        echo '<script>alert("抱歉，数据库中没有查到该实验室编号")</script>';
        exit();
    }
    
    $sql = sprintf('SELECT time_add, course_id, course_class, `lock`, tips FROM teacher_sj_schedule WHERE time_add LIKE "%s" AND `lock` != 1 AND time_add LIKE "%s"', $db_year . '%' , '_______' . $address . '____');
    $result = $conn->query($sql);
    if (!$result){
        echo 0;
        return 0;
    }
    
    
    //填充课程表
    $lesson_sheet = array();
    
    //准备文件名
    $date = str_split($db_year, 4);
    $file_name = $address . '-' . $date[0] . '年度第' . $date[1] . '学期实验室安排表.xls';
    
    while ($row = $result->fetch_assoc()){
        $sql_course = sprintf('SELECT * FROM course WHERE course_id = "%s"', $row['course_id']);
        $result_course = $conn->query($sql_course);
        if ($result_course && $info_course = $result_course->fetch_assoc()){
            
            $sql_teacher = sprintf('SELECT * FROM teacher WHERE teacher_id = "%s"', $info_course['teacher_id']);
            $result_teacher = $conn->query($sql_teacher);
            if ($result_teacher && $info_teacher = $result_teacher->fetch_assoc()){
                //班级信息分割成数组
                $class_array = explode('@', $row['course_class']);
                
                //编辑专业班级字符串
                $class = '';
                $class_array_length = count($class_array) - 1;
                for ($i = 0; $i < $class_array_length; ++$i){
                    $sql_major = sprintf('SELECT student_major FROM student_information WHERE student_number LIKE "%s"', substr($class_array[$i], 0, 6));
                    $result_major = $conn->query($sql_major);
                    if ($result_major){
                        $info_major = $result_major->fetch_assoc();
                        $class = major_class($info_major['student_major'], substr($class_array[$i], 0, 2) . '0' . substr($class_array[$i], 6, 1), $class);
                    }
                }
                          
                //处理时间
                
                $lesson_sheet[] = array(
                    'time' => get_time($row['time_add']),
                    'teacher' => $info_teacher['teacher_name'],
                    'course' => $info_course['course_name'],
                    'class' => $class,
                    'tips' => $row['tips'],
                    'lock' => $row['lock']
                );
            }
        }
    }
    
    //填充
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '实验室');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('B1', $address);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
    
    $objPHPExcel->getActiveSheet()->setCellValue('C1', $date[0] . '年度第' . $date[1] . '学期');
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objPHPExcel->getActiveSheet()->setCellValue('A2', '时间');
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('B2', '教师');
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('C2', '课程');
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('D2', '班级');
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('E2', '备注');
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
        
//    var_dump($lesson_sheet);    
    $i = 3;
    foreach ($lesson_sheet as $lesson_sheet_row){
        //第一列
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '第' . $lesson_sheet_row['time'][0] . '周-周' . $lesson_sheet_row['time'][1] . '-第' . $lesson_sheet_row['time'][2] . '节');
        
        //第二列
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $lesson_sheet_row['teacher']);
        
        //第三、四、五列
        if ($lesson_sheet_row['lock'] != 0){
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $lesson_sheet_row['course']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $lesson_sheet_row['class']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $lesson_sheet_row['tips']);
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $i . ':E' . $i);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $lesson_sheet_row['tips']);
        }
        
        //居中
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        ++$i;
    }
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    
    $i += 2;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $address);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '星期一');
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '星期二');
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '星期三');
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '星期四');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '星期五');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '星期六');
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '星期日');
    
    
    $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getFont()->setBold(true);
    
    ++$i;
    $address_sheet_base_row = $i;
    
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '1-2节');
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 1), '3-4节');
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), '5-6节');
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3), '7-8节');
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 4), '9-10节');
    
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 2))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4))->getFont()->setBold(true);
    
    foreach ($lesson_sheet as $lesson_sheet_row){
        $current_cell = chr(ord('A') + $lesson_sheet_row['time'][1]) . ($address_sheet_base_row + $lesson_sheet_row['time'][2] - 1);
        $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setWrapText(TRUE);
        if ($lesson_sheet_row['lock'] != 0){
            $string = $objPHPExcel->getActiveSheet()->getCell($current_cell)->getValue() . ('第' . $lesson_sheet_row['time'][0] . '周-' . $lesson_sheet_row['teacher'] . '-' . mb_substr($lesson_sheet_row['course'], 0, 5)) . "\n";
        } else {
            $string = $objPHPExcel->getActiveSheet()->getCell($current_cell)->getValue() . ('第' . $lesson_sheet_row['time'][0] . '周-锁定-' . mb_substr($lesson_sheet_row['tips'], 0, 5)) . "\n";
        }
        $objPHPExcel->getActiveSheet()->setCellValue($current_cell, $string);
    }
    
    
} else {
    //获得实验室列表
    $sql_address = 'SELECT * FROM ini_address';
    $result_address = $conn->query($sql_address);
    if ($result_address){
        //准备文件名
        $date = str_split($db_year, 4);
        $file_name = $date[0] . '年度第' . $date[1] . '学期实验室安排表[教室].xls';
        
        $sheet_index = 0;
        while ($address_row = $result_address->fetch_assoc()){
            $sql = sprintf('SELECT time_add, course_id, course_class, `lock`, tips FROM teacher_sj_schedule WHERE time_add LIKE "%s" AND `lock` != 1 AND time_add LIKE "%s"', $db_year . '%' , '_______' . $address_row['address'] . '____');
            $result = $conn->query($sql);
            if (!$result){
                echo 0;
                return 0;
            }

            
            //填充课程表
            $lesson_sheet = array();
            
            while ($row = $result->fetch_assoc()){
                $sql_course = sprintf('SELECT * FROM course WHERE course_id = "%s"', $row['course_id']);
                $result_course = $conn->query($sql_course);
                if ($result_course && $info_course = $result_course->fetch_assoc()){

                    $sql_teacher = sprintf('SELECT * FROM teacher WHERE teacher_id = "%s"', $info_course['teacher_id']);
                    $result_teacher = $conn->query($sql_teacher);
                    if ($result_teacher && $info_teacher = $result_teacher->fetch_assoc()){
                        //班级信息分割成数组
                        $class_array = explode('@', $row['course_class']);

                        //编辑专业班级字符串
                        $class = '';
                        $class_array_length = count($class_array) - 1;
                        for ($i = 0; $i < $class_array_length; ++$i){
                            $sql_major = sprintf('SELECT student_major FROM student_information WHERE student_number LIKE "%s"', substr($class_array[$i], 0, 6));
                            $result_major = $conn->query($sql_major);
                            if ($result_major){
                                $info_major = $result_major->fetch_assoc();
                                $class = major_class($info_major['student_major'], substr($class_array[$i], 0, 2) . '0' . substr($class_array[$i], 6, 1), $class);
                            }
                        }

                        //处理时间

                        $lesson_sheet[] = array(
                            'time' => get_time($row['time_add']),
                            'teacher' => $info_teacher['teacher_name'],
                            'course' => $info_course['course_name'],
                            'class' => $class,
                            'tips' => $row['tips'],
                            'lock' => $row['lock']
                        );
                    }
                }
            }
            
            //设置sheet
            $objPHPExcel->createSheet($sheet_index);
            $objPHPExcel->setActiveSheetIndex($sheet_index);
            $objPHPExcel->getActiveSheet()->setTitle($address_row['address']);
            
             //填充
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '实验室');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setCellValue('B1', $address_row['address']);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');

            $objPHPExcel->getActiveSheet()->setCellValue('C1', $date[0] . '年度第' . $date[1] . '学期');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->setCellValue('A2', '时间');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setCellValue('B2', '教师');
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setCellValue('C2', '课程');
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setCellValue('D2', '班级');
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setCellValue('E2', '备注');
            $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);

        //    var_dump($lesson_sheet);    
            $i = 3;
            foreach ($lesson_sheet as $lesson_sheet_row){
                //第一列
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '第' . $lesson_sheet_row['time'][0] . '周-周' . $lesson_sheet_row['time'][1] . '-第' . $lesson_sheet_row['time'][2] . '节');

                //第二列
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $lesson_sheet_row['teacher']);

                //第三、四、五列
                if ($lesson_sheet_row['lock'] != 0){
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $lesson_sheet_row['course']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $lesson_sheet_row['class']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $lesson_sheet_row['tips']);
                } else {
                    $objPHPExcel->getActiveSheet()->mergeCells('B' . $i . ':E' . $i);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $lesson_sheet_row['tips']);
                }

                //居中
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                ++$i;
            }

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);

            $i += 2;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $address_row['address']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '星期一');
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '星期二');
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '星期三');
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '星期四');
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '星期五');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '星期六');
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '星期日');


            $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getFont()->setBold(true);

            ++$i;
            $address_sheet_base_row = $i;

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '1-2节');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 1), '3-4节');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), '5-6节');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3), '7-8节');
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 4), '9-10节');

            $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 2))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4))->getFont()->setBold(true);

            foreach ($lesson_sheet as $lesson_sheet_row){
                $current_cell = chr(ord('A') + $lesson_sheet_row['time'][1]) . ($address_sheet_base_row + $lesson_sheet_row['time'][2] - 1);
                $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setWrapText(TRUE);
                if ($lesson_sheet_row['lock'] != 0){
                    $string = $objPHPExcel->getActiveSheet()->getCell($current_cell)->getValue() . ('第' . $lesson_sheet_row['time'][0] . '周-' . $lesson_sheet_row['teacher'] . '-' . mb_substr($lesson_sheet_row['course'], 0, 5)) . "\n";
                } else {
                    $string = $objPHPExcel->getActiveSheet()->getCell($current_cell)->getValue() . ('第' . $lesson_sheet_row['time'][0] . '周-锁定-' . mb_substr($lesson_sheet_row['tips'], 0, 5)) . "\n";
                }
                $objPHPExcel->getActiveSheet()->setCellValue($current_cell, $string);
            }
            ++$sheet_index;
        }
    } else {
        echo 0;
        return 0;
    }
    
    
}

    
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header('Content-Disposition:inline;filename="' . $file_name . '"');  
header("Content-Transfer-Encoding: binary");  
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Pragma: no-cache");  
$objWriter->save('php://output');