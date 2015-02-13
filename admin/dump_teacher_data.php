<?php

/**
 * 以教师为单位导出数据
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
require '../include/conn.php';
require 'PHPExcel.php';
require 'PHPExcel/Writer/Excel5.php';

//编辑专业班级字符串，若已在字符串里存在则直接加班级，不加专业，若不存在，则加专业班级；参数1代表专业，参数2代表班级，参数3代表要处理的字符串
function major_class($major, $class, $return)
{
        $len = strpos($return, $major);
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


//返回节数
function jie($j)
{
        if($j == "1")
                return "1-2节";
        if($j == "2")
                return "3-4节";
        if($j == "3")
                return "5-6节";
        if($j == "4")
                return "7-8节";
        if($j == "5")
                return "9-10节";
}
//返回周
function zhou($z)
{
        if($z == "1")
                return "周一";
        if($z == "2")
                return "周二";
        if($z == "3")
                return "周三";
        if($z == "4")
                return "周四";
        if($z == "5")
                return "周五";
        if($z == "6")
                return "周六";
        if($z == "7")
                return "周日";
}

//获得时间列
function GetTimeCol($time_add){
    $time = array();
    $time['week']  = substr($time_add, 10, 2);
    $time['jie'] = substr($time_add, 12, 1);
    $time['zhou'] = substr($time_add, 13, 1);
    return $time;
}

//获得地点列
function GetSiteCol($conn, $time_add){
    $address = substr($time_add, 5, 2);
    $sql_address = "SELECT * FROM school where school_id = '$address'";
    $result_address = $conn->query($sql_address);
    $info_address = $result_address->fetch_array();
    return $info_address;
}

//获得课程列
function GetCourseCol($conn, $course_id){
    $sql_course = "SELECT course_name,teacher_id FROM `course` WHERE course_id = '" . $course_id . "'";
    $result_course = $conn->query($sql_course);
    $info_course = $result_course->fetch_array();
    return $info_course;
}

//获得班级列
function GetClassCol($conn, $course_class){
    $class_array = explode('@', $course_class);//班级信息分割成数组
    //编辑专业班级字符串
    $class = "";
    $class_array_length = count($class_array);
    for($n = 0; $n < $class_array_length; $n++)
    {
        $sql3 = "select student_major from student_information where student_number = substr($class_array[$n], 1, 6)";//获取专业班级
        $result3 = $conn->query($sql3);
        if($result3)
        {
            $info3 = $result3->fetch_array();
            $class = major_class($info3['student_major'], substr($class_array[$n], 0, 2) . '0' . substr($class_array[$n], 6, 1), $class);
                                    //$class = $info3['student_major'].substr($class_array[0],0,2).'0'.substr($class_array[0],6,1);
        }	
    }
    return $class;
}
//是否导出所有教师数据并打包
$global = 1;
    
//指定导出的教师名
$teacher = '';


if (!$global){
//    $teacher = DB::CheckInput($_POST['teacher']);
    $teacher = '张胜男';
            
    //填充课程表
    $lesson_sheet = array();
    
    //准备文件名
    $date = str_split($db_year, 4);    
    $file_name = $teacher . '-' . $date[0] . '年度第' . $date[1] . '学期实验室安排表.xls';
    
    $objPHPExcel = new PHPExcel();
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    
    $objPHPExcel->getProperties()->setCreator("SUTACM-*Chen");
    
    //填充
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '姓名');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('B1', $teacher);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
    
    $objPHPExcel->getActiveSheet()->setCellValue('C1', $date[0] . '年度第' . $date[1] . '学期');
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objPHPExcel->getActiveSheet()->setCellValue('A2', '时间');
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue('B2', '地点');
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
    
    
    
    $sql = "SELECT `time_add`,`course_id`,`course_class`,`tips` FROM `teacher_sj_schedule` WHERE time_add like '$db_year%' AND course_class!='' AND course_id  in (SELECT course_id FROM `course` WHERE teacher_id in (select teacher_id from teacher where teacher_name like'%" . $teacher . "%')) ORDER BY time_add";    
    $result = $conn->query($sql);
    
    $i = 3;
    while ($row = $result->fetch_assoc()){
        //第一列
        $col_a = GetTimeCol($row['time_add']);
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '第' . $col_a['week'] . '周 ' . zhou($col_a['zhou']) . ' ' . jie($col_a['jie']));
        
        
        //第二列
        $info_address = GetSiteCol($conn, $row['time_add']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $info_address['school_name'] . substr($row['time_add'],7,3));
        
        //第三列
        $info_course = GetCourseCol($conn, $row['course_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $info_course['course_name']);
        
        //第四列
        $class = GetClassCol($conn, $row['course_class']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $class);
        
        //第五列
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $row['tips']);
        
        $lesson_sheet[] = array(
            'week' => $col_a['week'],
            'zhou' => $col_a['zhou'],
            'jie' => $col_a['jie'],
            'address' => $info_address['school_name'] . substr($row['time_add'],7,3),
            'course' => $info_course['course_name']
        );
        
        //居中
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        ++$i;
    }
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    
    $i += 2;
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
    $lesson_sheet_base_row = $i;
    
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
    
    foreach ($lesson_sheet as $lesson_sheet_item){
        $current_cell = chr(ord('A') + $lesson_sheet_item['zhou']) . ($lesson_sheet_base_row + $lesson_sheet_item['jie'] - 1);
        $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setWrapText(TRUE);
        $string = $objPHPExcel->getActiveSheet()->getCell($current_cell)->getValue() . ('第' . $lesson_sheet_item['week'] . '周-' . $lesson_sheet_item['address']) . "\n";
        $objPHPExcel->getActiveSheet()->setCellValue($current_cell, $string);
    }
    
} else {
    
    //准备文件名
    $date = str_split($db_year, 4);
    $file_name = $date[0] . '年度第' . $date[1] . '学期实验室安排表.xls';
    
    $objPHPExcel = new PHPExcel();
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    
    $objPHPExcel->getProperties()->setCreator("SUTACM-*Chen");
    
    //获取所有教师
    $sql = "SELECT teacher_id, teacher_name FROM teacher WHERE teacher_id >= '10000'";
    $teacher_query_result = $conn->query($sql);     
    
    $sheet_index = 0;
    while ($teacher_row = $teacher_query_result->fetch_assoc()){
        //填充课程表
        $lesson_sheet = array();
        
        //设置sheet
        $objPHPExcel->createSheet($sheet_index);
        $objPHPExcel->setActiveSheetIndex($sheet_index);
        $objPHPExcel->getActiveSheet()->setTitle($teacher_row['teacher_name']);
        
        //填充
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '姓名');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->setCellValue('B1', $teacher_row['teacher_name']);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');

        $objPHPExcel->getActiveSheet()->setCellValue('C1', $date[0] . '年度第' . $date[1] . '学期');
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', '时间');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->setCellValue('B2', '地点');
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


        $sql = "SELECT `time_add`,`course_id`,`course_class`,`tips` FROM `teacher_sj_schedule` WHERE time_add like '$db_year%' AND course_class!='' AND course_id  in (SELECT course_id FROM `course` WHERE teacher_id = " . $teacher_row['teacher_id'] . ")ORDER BY time_add";    
        $result = $conn->query($sql);

        $i = 3;
        while ($row = $result->fetch_assoc()){
            //第一列
            $col_a = GetTimeCol($row['time_add']);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '第' . $col_a['week'] . '周 ' . zhou($col_a['zhou']) . ' ' . jie($col_a['jie']));

            //第二列
            $info_address = GetSiteCol($conn, $row['time_add']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $info_address['school_name'] . substr($row['time_add'],7,3));

            //第三列
            $info_course = GetCourseCol($conn, $row['course_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $info_course['course_name']);

            //第四列
            $class = GetClassCol($conn, $row['course_class']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $class);

            //第五列
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $row['tips']);
            
            $lesson_sheet[] = array(
                'week' => $col_a['week'],
                'zhou' => $col_a['zhou'],
                'jie' => $col_a['jie'],
                'address' => $info_address['school_name'] . substr($row['time_add'],7,3),
                'course' => $info_course['course_name']
            );

            //居中
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            ++$i;
        }


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $i += 2;
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
        $lesson_sheet_base_row = $i;

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

        foreach ($lesson_sheet as $lesson_sheet_item){
            $current_cell = chr(ord('A') + $lesson_sheet_item['zhou']) . ($lesson_sheet_base_row + $lesson_sheet_item['jie'] - 1);
            $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setWrapText(TRUE);
            $string = $objPHPExcel->getActiveSheet()->getCell($current_cell)->getValue() . ('第' . $lesson_sheet_item['week'] . '周-' . $lesson_sheet_item['address']) . "\n";
            $objPHPExcel->getActiveSheet()->setCellValue($current_cell, $string);
        }

        ++$sheet_index;
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