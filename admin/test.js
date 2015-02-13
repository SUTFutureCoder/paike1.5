// JavaScript Document该文档为封装好的js文档，实现了下拉列表的联动动态生成

schoolcat = new Array();
schoolcat[0]= Array("机械工程学院","01");
schoolcat[1]= Array("材料科学与工程学院","02");
schoolcat[2]= Array("电气工程学院","03");
schoolcat[3]= Array("信息科学与工程学院","04");
schoolcat[4]= Array("管理学院","05");
schoolcat[5]= Array("文法学院","06");
schoolcat[6]= Array("理学院","07");
schoolcat[7]= Array("建筑工程学院","08");
schoolcat[8]= Array("外语学院","09");
schoolcat[9]= Array("经济学院","10");
schoolcat[10]= Array("国际教育学院","11");
schoolcat[11]= Array("软件学院","12");
schoolcat[12]= Array("继续教育学院","13");
schoolcat[13]= Array("新能源工程学院","14");
schoolcat[14]= Array("基础教育学院","15");
schoolcat[15]= Array("研究生学院","16");

//信息学院专业
majorcat = new Array();
majorcat[0] = Array ("计算机科学与技术","04","05");
majorcat[1] = Array ("测控技术","04","01");
majorcat[2] = Array ("电子信息","04","02");
majorcat[3] = Array ("电子科技","04","03");
majorcat[4] = Array ("通信工程","04","04");
majorcat[5] = Array ("自动化","03","01");
majorcat[6] = Array ("生物医学","03","02");
majorcat[7] = Array ("电气自动化","03","03");


gradecat = new Array();
gradecat[0] = Array("2009级","09");
gradecat[1] = Array("2010级","10");
gradecat[2] = Array("2011级","11");
gradecat[3] = Array("2012级","12");

//专业 从左到右分别为专业班级，学院编号，年级编号，
classcat = new Array();
classcat[0] = Array ("计算机1001班","05","10","1");
classcat[1] = Array ("计算机1002班","05","10","2");
classcat[2] = Array ("计算机1003班","05","10","3");
classcat[3] = Array ("计算机1004班","05","10","4");
classcat[4] = Array ("测控技术1001班","01","10","1");
classcat[5] = Array ("测控技术1002班","01","10","2");
classcat[6] = Array ("测控技术1003班","01","10","3");
classcat[7] = Array ("测控技术1004班","01","10","4");
classcat[8] = Array ("计算机1101班","05","11","1");
classcat[9] = Array ("计算机1102班","05","11","2");
classcat[10] = Array ("计算机1103班","05","11","3");
classcat[11] = Array ("计算机1104班","05","11","4");
classcat[12] = Array ("测控技术1101班","01","11","1");
classcat[13] = Array ("测控技术1102班","01","11","2");
classcat[14] = Array ("测控技术1103班","01","11","3");
classcat[15] = Array ("测控技术1104班","01","11","4");
//自动生成学院下拉列表
document.form.school.length = 0;
document.form.school.options[0] = new Option("==请选择学院==","");

  
for(i=0;i<schoolcat.length;i++)
{

	document.form.school.options[document.form.school.length] = new Option(schoolcat[i][0],schoolcat[i][1]);
}
//自动生成年级下拉列表
document.form.grade.length = 0;
document.form.grade.options[0] = new Option("==请选择年级==","");

for(i=0;i<gradecat.length;i++)
{
	document.form.grade.options[document.form.grade.length] = new Option(gradecat[i][0],gradecat[i][1]);
}

function change_school(locationid)
{
	document.form.major.length = 0; 
	document.form.major.options[0] = new Option("==请选择专业==","");
	
	for (i=0;i<majorcat.length;i++)
	{
		if(majorcat[i][1]==locationid)
		{
			document.form.major.options[document.form.major.length] = new Option(majorcat[i][0],majorcat[i][2]);
		}
	}
}

function change_major(locationid)
{
	document.form.w_class.length = 0; 
	document.form.w_class.options[0] = new Option("==请选择班级==","");
	//alert (locationid);
	for (i=0;i<classcat.length;i++)
	{
		if((classcat[i][1]==locationid) && (classcat[i][2] == document.form.grade.options[document.form.grade.selectedIndex].value))
		{
			document.form.w_class.options[document.form.w_class.length] = new Option(classcat[i][0],classcat[i][3]);
		}
	}
}
function change_grade(locationid)
{
	document.form.w_class.length = 0; 
	document.form.w_class.options[0] = new Option("==请选择班级==","");
	//alert (locationid);
	for (i=0;i<classcat.length;i++)
	{
		if(classcat[i][2]==locationid&&classcat[i][1]==document.form.major.options[document.form.major.selectedIndex].value)
		{
			document.form.w_class.options[document.form.w_class.length] = new Option(classcat[i][0],classcat[i][3]);
		}
	}
}
/*function register()
{	
	school_x = document.form.school.options[document.form.school.selectedIndex].text;
	major_x = document.form.major.options[document.form.major.selectedIndex].text;
	class_x = document.form.w_class.options[document.form.w_class.selectedIndex].text;
	grade_x = document.form.grade.options[document.form.grade.selectedIndex].text;
	//alert (school_x+major_x+class_x+document.form.course.value);
	if(school_x=="==请选择学院==")
	{
		school_tips.innerHTML = "*请选择学院";
		course_tips.innerHTML = "";
		school_tips.focus();
		return false;	
	}
	if(major_x == "==请选择专业==")
	{
		major_tips.innerHTML = "*请选择专业";
		school_tips.innerHTML = "";
		major_tips.focus();
		return false;	
	}
	if(grade_x=="==请选择年级==")
	{
		grade_tips.innerHTML = "*请选择年级";
		major_tips.innerHTML = "";
		grade_tips.focus();
		return false;	
	}
	if(class_x=="==请选择班级==")
	{
		class_tips.innerHTML = "*请选择班级";
		grade_tips.innerHTML = "";
		class_tips.focus();
		return false;		
	}
}*/