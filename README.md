# paike1.5 - 沈阳工业大学排课系统1.5

###STAR原则
> **S** 每学期进行实验室排课安排需要学院集中开会研讨，传统记录和安排方式效率低、灵活性差。  
> **T** 跟踪传统排课流程，收集负责教师需求，并首次尝试使用设计模式。允许各个教师在实验室空闲时间自行安排课程并导出Excel文档以便打印。  
> **A** 根据现实情况添加排课、教师、课程、班级管理等功能并使用PHP EXCEL类支持一键导出指定/所有实验室或教师课程安排及对应课程表。  
> **R** 已成功完成本学院实验室2014及2015年度全校排课任务。 节约每教师每学期4小时及实验中心人力一人。 

---

数据库连接在**paike1.5/include/conn.php**第32行。部署方法请往下拉，因为是早期作品，所以没有使用MVC。 
非常感谢关注这个项目！   

---
###DEMO 示例

####主界面
![主界面](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_01.png?raw=true)

####机房课程表
![机房课程表](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_02.png?raw=true)

####后台主界面
![后台主界面](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_03.png?raw=true)

####进行排课操作
![进行排课操作](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_07.png?raw=true)


####导出数据
![导出数据](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_04.png?raw=true)

####导出机房记录
![导出机房记录](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_05.png?raw=true)

####导出教师记录
![导出教师记录](https://github.com/SUTFutureCoder/paike1.5/blob/master/example-img/paike_06.png?raw=true)

##部署方法  
###STEP1  
将项目clone到服务器中能访问到的目录（相关技术：安装lamp或lnmp），授予777权限(sudo chmod 777 -R /var/www/html/paike1.5)  
###STEP2  
修改php.ini(/etc/php5/apache2/php.ini)中控制最大上传量的参数为128M 初始化完可以改回来
###STEP3
导入SQL文件,修改配置文件 include/conn.php第32行    
###STEP4  
管理员测试账户：00001 密码 123456  
教师测试账户：11204 密码 123456  
###STEP5  
使用管理员登录，点击左侧学期初始化，对实验室进行初始化。点击校历校准，对学期时间进行校准  

ENJOY (`8`)

##架构介绍  
本排课系统没有使用MVC框架，而是使用最简单的前后端杂糅方法。后期维护的确是个问题，但因为目前已经毕业，并且秉承不去动能够正常运行代码原则，所以暂时不用框架。    
前端大量使用jquery框架，并使用ajax向后端异步传值。*.ajax.php 就是传值目标。  
数据库连接使用单例模式并且做防注入处理。
使用PHPEXCEL库对课程表进行导出。   

