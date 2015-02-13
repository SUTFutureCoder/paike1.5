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
schoolcat[12]= Array("继续教育学院","14");
schoolcat[13]= Array("新能源工程学院","15");
schoolcat[14]= Array("基础教育学院","16");


majorcat = new Array();
majorcat[0] = new Array("机械自动化","01","00");
majorcat[1] = new Array("机械自动化","01","01");
majorcat[2] = new Array("工业工程","01","02");
majorcat[3] = new Array("工业设计","01","03");
majorcat[4] = new Array("车辆工程","01","04");
majorcat[5] = new Array("物流工程","01","05");
majorcat[6] = new Array("体育装备","01","06");
majorcat[7] = new Array("材料","02","00");
majorcat[8] = new Array("材料","02","01");
majorcat[9] = new Array("金属材料","02","02");
majorcat[10] = new Array("无机材料","02","03");
majorcat[11] = new Array("焊接","02","04");
majorcat[12] = new Array("电气工程","03","01");
majorcat[13] = new Array("自动化","03","02");
majorcat[14] = new Array("生物医学","03","03");
majorcat[15] = new Array("测控技术","04","01");
majorcat[16] = new Array("电子信息","04","02");
majorcat[17] = new Array("电子科学","04","03");
majorcat[18] = new Array("通信工程","04","04");
majorcat[19] = new Array("计算机","04","05");
majorcat[20] = new Array("计算机（网络安全）","04","06");
majorcat[21] = new Array("智能科学","04","07");
majorcat[22] = new Array("工程管理","05","01");
majorcat[23] = new Array("工商管理","05","02");
majorcat[24] = new Array("市场营销","05","03");
majorcat[25] = new Array("会计学","05","04");
majorcat[26] = new Array("物流管理","05","05");
majorcat[27] = new Array("电子商务","05","06");
majorcat[28] = new Array("法学","06","01");
majorcat[29] = new Array("装潢艺术","06","02");
majorcat[30] = new Array("环境艺术","06","03");
majorcat[31] = new Array("广告学","06","04");
majorcat[32] = new Array("艺术设计","06","05");
majorcat[33] = new Array("视觉传达","06","06");
majorcat[34] = new Array("环境设计","06","07");
majorcat[35] = new Array("知识产权","06","08");
majorcat[36] = new Array("计算科学","07","01");
majorcat[37] = new Array("应用物理","07","02");
majorcat[38] = new Array("应用化学","07","03");
majorcat[39] = new Array("环境工程","07","04");
majorcat[40] = new Array("应用数学","07","05");
majorcat[41] = new Array("功能材料","07","06");
majorcat[42] = new Array("土木工程","08","01");
majorcat[43] = new Array("建筑学","08","02");
majorcat[44] = new Array("建筑设备","08","03");
majorcat[45] = new Array("建筑能源","08","04");
majorcat[46] = new Array("地下工程","08","05");
majorcat[47] = new Array("道桥工程","08","06");
majorcat[48] = new Array("英语","09","01");
majorcat[49] = new Array("日语","09","02");
majorcat[50] = new Array("国际贸易","10","01");
majorcat[51] = new Array("金融学","10","02");
majorcat[52] = new Array("经济学","10","03");
majorcat[53] = new Array("金融工程","10","04");
majorcat[54] = new Array("工业工程","10","20");
majorcat[55] = new Array("[国教]计算机","11","01");
majorcat[56] = new Array("[国教]会计学","11","02");
majorcat[57] = new Array("[国教]国际经贸","11","02");
majorcat[58] = new Array("[国教]国际经贸","11","03");
majorcat[59] = new Array("软件","12","01");
majorcat[60] = new Array("软件工程","12","03");
majorcat[61] = new Array("计算机科学与技术","12","02");
majorcat[62] = new Array("风能","13","01");
majorcat[63] = new Array("风能与动力工程","15","01");
majorcat[64] = new Array("能源科学","15","02");

gradecat = new Array();
gradecat[0] = Array("2010级","10");
gradecat[1] = Array("2011级","11");
gradecat[2] = Array("2012级","12");
gradecat[3] = Array("2013级","13");
gradecat[4] = Array("2014级","14");

//option,学院,专业,班级,年级
classcat = new Array();
classcat[0] = new Array("机自1001","01","01","1","10");
classcat[1] = new Array("机自1002","01","01","2","10");
classcat[2] = new Array("机自1003","01","01","3","10");
classcat[3] = new Array("机自1004","01","01","4","10");
classcat[4] = new Array("机自1005","01","01","5","10");
classcat[5] = new Array("机自1006","01","01","6","10");
classcat[6] = new Array("机自1007","01","01","7","10");
classcat[7] = new Array("机自1008","01","01","8","10");
classcat[8] = new Array("工业工程1001","01","02","1","10");
classcat[9] = new Array("工业工程1002","01","02","2","10");
classcat[10] = new Array("车辆工程1001","01","04","1","10");
classcat[11] = new Array("车辆工程1002","01","04","2","10");
classcat[12] = new Array("车辆工程1003","01","04","3","10");
classcat[13] = new Array("物流工程1001","01","05","1","10");
classcat[14] = new Array("体育装备1001","01","06","1","10");
classcat[15] = new Array("成型控制1001","02","01","1","10");
classcat[16] = new Array("成型控制1002","02","01","2","10");
classcat[17] = new Array("成型控制1003","02","01","3","10");
classcat[18] = new Array("成型控制1004","02","01","4","10");
classcat[19] = new Array("成型控制1005","02","01","5","10");
classcat[20] = new Array("金属材料1001","02","02","1","10");
classcat[21] = new Array("金属材料1002","02","02","2","10");
classcat[22] = new Array("无机1001","02","03","1","10");
classcat[23] = new Array("无机材料1002","02","03","2","10");
classcat[24] = new Array("焊接1001","02","04","1","10");
classcat[25] = new Array("电气工程1001","03","01","1","10");
classcat[26] = new Array("电气工程1002","03","01","2","10");
classcat[27] = new Array("电气工程1003","03","01","3","10");
classcat[28] = new Array("电气工程1004","03","01","4","10");
classcat[29] = new Array("电气工程1005","03","01","5","10");
classcat[30] = new Array("电气工程1006","03","01","6","10");
classcat[31] = new Array("电气工程1007","03","01","7","10");
classcat[32] = new Array("电气工程1008","03","01","8","10");
classcat[33] = new Array("自动化1001","03","02","1","10");
classcat[34] = new Array("自动化1002","03","02","2","10");
classcat[35] = new Array("自动化1003","03","02","3","10");
classcat[36] = new Array("自动化1004","03","02","4","10");
classcat[37] = new Array("自动化1005","03","02","5","10");
classcat[38] = new Array("自动化1006","03","02","6","10");
classcat[39] = new Array("生物医学1001","03","03","1","10");
classcat[40] = new Array("测控1001","04","01","1","10");
classcat[41] = new Array("测控1002","04","01","2","10");
classcat[42] = new Array("测控1003","04","01","3","10");
classcat[43] = new Array("测控1004","04","01","4","10");
classcat[44] = new Array("信息工程1001","04","02","1","10");
classcat[45] = new Array("信息工程1002","04","02","2","10");
classcat[46] = new Array("信息工程1003","04","02","3","10");
classcat[47] = new Array("电科1001","04","03","1","10");
classcat[48] = new Array("电科1002","04","03","2","10");
classcat[49] = new Array("通信工程1001","04","04","1","10");
classcat[50] = new Array("通信工程1002","04","04","2","10");
classcat[51] = new Array("通信工程1003","04","04","3","10");
classcat[52] = new Array("计算机1001","04","05","1","10");
classcat[53] = new Array("计算机1002","04","05","2","10");
classcat[54] = new Array("计算机1003","04","05","3","10");
classcat[55] = new Array("计算机1004","04","05","4","10");
classcat[56] = new Array("智能工程1001","04","07","1","10");
classcat[57] = new Array("计算科学1001","07","01","1","10");
classcat[58] = new Array("计算科学1002","07","01","2","10");
classcat[59] = new Array("应用物理1001","07","02","1","10");
classcat[60] = new Array("应用化学1001","07","03","1","10");
classcat[61] = new Array("应用化学1002","07","03","2","10");
classcat[62] = new Array("应用化学1003","07","03","3","10");
classcat[63] = new Array("环境工程1001","07","04","1","10");
classcat[64] = new Array("环境工程1002","07","04","2","10");
classcat[65] = new Array("应用数学1001","07","05","1","10");
classcat[66] = new Array("功能材料1001","07","06","1","10");
classcat[67] = new Array("土木工程1001","08","01","1","10");
classcat[68] = new Array("土木工程1002","08","01","2","10");
classcat[69] = new Array("土木工程1003","08","01","3","10");
classcat[70] = new Array("土木工程1004","08","01","4","10");
classcat[71] = new Array("土木工程1005","08","01","5","10");
classcat[72] = new Array("土木工程1006","08","01","6","10");
classcat[73] = new Array("建筑设备1001","08","03","1","10");
classcat[74] = new Array("建筑设备1002","08","03","2","10");
classcat[75] = new Array("风能1001","13","01","1","10");
classcat[76] = new Array("风能1002","13","01","2","10");
classcat[77] = new Array("机自1101","01","01","1","11");
classcat[78] = new Array("机自1102","01","01","2","11");
classcat[79] = new Array("机自1103","01","01","3","11");
classcat[80] = new Array("机自1104","01","01","4","11");
classcat[81] = new Array("机自1105","01","01","5","11");
classcat[82] = new Array("机自1106","01","01","6","11");
classcat[83] = new Array("机自1107","01","01","7","11");
classcat[84] = new Array("机自1108","01","01","8","11");
classcat[85] = new Array("工业工程1101","01","02","1","11");
classcat[86] = new Array("工业工程1102","01","02","2","11");
classcat[87] = new Array("车辆工程1101","01","04","1","11");
classcat[88] = new Array("车辆工程1102","01","04","2","11");
classcat[89] = new Array("车辆工程1103","01","04","3","11");
classcat[90] = new Array("物流工程1101","01","05","1","11");
classcat[91] = new Array("体育装备1101","01","06","1","11");
classcat[92] = new Array("成型控制1101","02","01","1","11");
classcat[93] = new Array("成型控制1102","02","01","2","11");
classcat[94] = new Array("成型控制1103","02","01","3","11");
classcat[95] = new Array("成型控制1104","02","01","4","11");
classcat[96] = new Array("成型控制1105","02","01","5","11");
classcat[97] = new Array("金属材料1101","02","02","1","11");
classcat[98] = new Array("金属材料1102","02","02","2","11");
classcat[99] = new Array("无机1101","02","03","1","11");
classcat[100] = new Array("无机材料1102","02","03","2","11");
classcat[101] = new Array("焊接1101","02","04","1","11");
classcat[102] = new Array("电气工程1101","03","01","1","11");
classcat[103] = new Array("电气工程1102","03","01","2","11");
classcat[104] = new Array("电气工程1103","03","01","3","11");
classcat[105] = new Array("电气工程1104","03","01","4","11");
classcat[106] = new Array("电气工程1105","03","01","5","11");
classcat[107] = new Array("电气工程1106","03","01","6","11");
classcat[108] = new Array("电气工程1107","03","01","7","11");
classcat[109] = new Array("电气工程1108","03","01","8","11");
classcat[110] = new Array("自动化1101","03","02","1","11");
classcat[111] = new Array("自动化1102","03","02","2","11");
classcat[112] = new Array("自动化1103","03","02","3","11");
classcat[113] = new Array("自动化1104","03","02","4","11");
classcat[114] = new Array("自动化1105","03","02","5","11");
classcat[115] = new Array("自动化1106","03","02","6","11");
classcat[116] = new Array("生物医学1101","03","03","1","11");
classcat[117] = new Array("测控1101","04","01","1","11");
classcat[118] = new Array("测控1102","04","01","2","11");
classcat[119] = new Array("测控1103","04","01","3","11");
classcat[120] = new Array("测控1104","04","01","4","11");
classcat[121] = new Array("信息工程1101","04","02","1","11");
classcat[122] = new Array("信息工程1102","04","02","2","11");
classcat[123] = new Array("信息工程1103","04","02","3","11");
classcat[124] = new Array("电科1101","04","03","1","11");
classcat[125] = new Array("电科1102","04","03","2","11");
classcat[126] = new Array("通信工程1101","04","04","1","11");
classcat[127] = new Array("通信工程1102","04","04","2","11");
classcat[128] = new Array("通信工程1103","04","04","3","11");
classcat[129] = new Array("计算机1101","04","05","1","11");
classcat[130] = new Array("计算机1102","04","05","2","11");
classcat[131] = new Array("计算机1103","04","05","3","11");
classcat[132] = new Array("计算机1104","04","05","4","11");
classcat[133] = new Array("智能工程1101","04","07","1","11");
classcat[134] = new Array("计算科学1101","07","01","1","11");
classcat[135] = new Array("计算科学1102","07","01","2","11");
classcat[136] = new Array("应用物理1101","07","02","1","11");
classcat[137] = new Array("应用化学1101","07","03","1","11");
classcat[138] = new Array("应用化学1102","07","03","2","11");
classcat[139] = new Array("应用化学1103","07","03","3","11");
classcat[140] = new Array("环境工程1101","07","04","1","11");
classcat[141] = new Array("环境工程1102","07","04","2","11");
classcat[142] = new Array("应用数学1101","07","05","1","11");
classcat[143] = new Array("功能材料1101","07","06","1","11");
classcat[144] = new Array("土木工程1101","08","01","1","11");
classcat[145] = new Array("土木工程1102","08","01","2","11");
classcat[146] = new Array("土木工程1103","08","01","3","11");
classcat[147] = new Array("土木工程1104","08","01","4","11");
classcat[148] = new Array("土木工程1105","08","01","5","11");
classcat[149] = new Array("土木工程1106","08","01","6","11");
classcat[150] = new Array("建筑设备1101","08","03","1","11");
classcat[151] = new Array("建筑设备1102","08","03","2","11");
classcat[152] = new Array("风能1101","13","01","1","11");
classcat[153] = new Array("风能1102","13","01","2","11");
classcat[154] = new Array("机自1201","01","01","1","12");
classcat[155] = new Array("机自1202","01","01","2","12");
classcat[156] = new Array("机自1203","01","01","3","12");
classcat[157] = new Array("机自1204","01","01","4","12");
classcat[158] = new Array("机自1205","01","01","5","12");
classcat[159] = new Array("机自1206","01","01","6","12");
classcat[160] = new Array("机自1207","01","01","7","12");
classcat[161] = new Array("机自1208","01","01","8","12");
classcat[162] = new Array("工业工程1201","01","02","1","12");
classcat[163] = new Array("工业工程1202","01","02","2","12");
classcat[164] = new Array("车辆工程1201","01","04","1","12");
classcat[165] = new Array("车辆工程1202","01","04","2","12");
classcat[166] = new Array("车辆工程1203","01","04","3","12");
classcat[167] = new Array("物流工程1201","01","05","1","12");
classcat[168] = new Array("体育装备1201","01","06","1","12");
classcat[169] = new Array("成型控制1201","02","01","1","12");
classcat[170] = new Array("成型控制1202","02","01","2","12");
classcat[171] = new Array("成型控制1203","02","01","3","12");
classcat[172] = new Array("成型控制1204","02","01","4","12");
classcat[173] = new Array("成型控制1205","02","01","5","12");
classcat[174] = new Array("金属材料1201","02","02","1","12");
classcat[175] = new Array("金属材料1202","02","02","2","12");
classcat[176] = new Array("无机1201","02","03","1","12");
classcat[177] = new Array("无机材料1202","02","03","2","12");
classcat[178] = new Array("焊接1201","02","04","1","12");
classcat[179] = new Array("电气工程1201","03","01","1","12");
classcat[180] = new Array("电气工程1202","03","01","2","12");
classcat[181] = new Array("电气工程1203","03","01","3","12");
classcat[182] = new Array("电气工程1204","03","01","4","12");
classcat[183] = new Array("电气工程1205","03","01","5","12");
classcat[184] = new Array("电气工程1206","03","01","6","12");
classcat[185] = new Array("电气工程1207","03","01","7","12");
classcat[186] = new Array("电气工程1208","03","01","8","12");
classcat[187] = new Array("自动化1201","03","02","1","12");
classcat[188] = new Array("自动化1202","03","02","2","12");
classcat[189] = new Array("自动化1203","03","02","3","12");
classcat[190] = new Array("自动化1204","03","02","4","12");
classcat[191] = new Array("自动化1205","03","02","5","12");
classcat[192] = new Array("自动化1206","03","02","6","12");
classcat[193] = new Array("生物医学1201","03","03","1","12");
classcat[194] = new Array("测控1201","04","01","1","12");
classcat[195] = new Array("测控1202","04","01","2","12");
classcat[196] = new Array("测控1203","04","01","3","12");
classcat[197] = new Array("测控1204","04","01","4","12");
classcat[198] = new Array("信息工程1201","04","02","1","12");
classcat[199] = new Array("信息工程1202","04","02","2","12");
classcat[200] = new Array("信息工程1203","04","02","3","12");
classcat[201] = new Array("电科1201","04","03","1","12");
classcat[202] = new Array("电科1202","04","03","2","12");
classcat[203] = new Array("通信工程1201","04","04","1","12");
classcat[204] = new Array("通信工程1202","04","04","2","12");
classcat[205] = new Array("通信工程1203","04","04","3","12");
classcat[206] = new Array("计算机1201","04","05","1","12");
classcat[207] = new Array("计算机1202","04","05","2","12");
classcat[208] = new Array("计算机1203","04","05","3","12");
classcat[209] = new Array("智能工程1201","04","07","1","12");
classcat[210] = new Array("工程管理1201","05","01","1","12");
classcat[211] = new Array("工程管理1202","05","01","2","12");
classcat[212] = new Array("工商管理1201","05","02","1","12");
classcat[213] = new Array("工商管理1202","05","02","2","12");
classcat[214] = new Array("市场营销1201","05","03","1","12");
classcat[215] = new Array("市场营销1202","05","03","2","12");
classcat[216] = new Array("会计学1201","05","04","1","12");
classcat[217] = new Array("会计学1202","05","04","2","12");
classcat[218] = new Array("物流管理1201","05","05","1","12");
classcat[219] = new Array("物流管理1202","05","05","2","12");
classcat[220] = new Array("电子商务1201","05","06","1","12");
classcat[221] = new Array("电子商务1202","05","06","2","12");
classcat[222] = new Array("法学1201","06","01","1","12");
classcat[223] = new Array("法学1202","06","01","2","12");
classcat[224] = new Array("广告学1201","06","04","1","12");
classcat[225] = new Array("广告学1202","06","04","2","12");
classcat[226] = new Array("艺术设计1201","06","05","1","12");
classcat[227] = new Array("艺术设计1202","06","05","2","12");
classcat[228] = new Array("艺术设计1203","06","05","3","12");
classcat[229] = new Array("计算科学1201","07","01","1","12");
classcat[230] = new Array("计算科学1202","07","01","2","12");
classcat[231] = new Array("应用物理1201","07","02","1","12");
classcat[232] = new Array("应用化学1201","07","03","1","12");
classcat[233] = new Array("应用化学1202","07","03","2","12");
classcat[234] = new Array("应用化学1203","07","03","3","12");
classcat[235] = new Array("环境工程1201","07","04","1","12");
classcat[236] = new Array("环境工程1202","07","04","2","12");
classcat[237] = new Array("应用数学1201","07","05","1","12");
classcat[238] = new Array("功能材料1201","07","06","1","12");
classcat[239] = new Array("土木工程1201","08","01","1","12");
classcat[240] = new Array("土木工程1202","08","01","2","12");
classcat[241] = new Array("土木工程1203","08","01","3","12");
classcat[242] = new Array("土木工程1204","08","01","4","12");
classcat[243] = new Array("土木工程1205","08","01","5","12");
classcat[244] = new Array("土木工程1206","08","01","6","12");
classcat[245] = new Array("建筑设备1201","08","03","1","12");
classcat[246] = new Array("建筑设备1202","08","03","2","12");
classcat[247] = new Array("英语1201","09","01","1","12");
classcat[248] = new Array("英语1202","09","01","2","12");
classcat[249] = new Array("日语1201","09","02","1","12");
classcat[250] = new Array("日语1202","09","02","2","12");
classcat[251] = new Array("国际贸易1201","10","01","1","12");
classcat[252] = new Array("国际贸易1202","10","01","2","12");
classcat[253] = new Array("金融学1201","10","02","1","12");
classcat[254] = new Array("金融学1202","10","02","2","12");
classcat[255] = new Array("金融学1203","10","02","3","12");
classcat[256] = new Array("经济学1201","10","03","1","12");
classcat[257] = new Array("经济学1202","10","03","2","12");
classcat[258] = new Array("会计(国教)1201","11","02","1","12");
classcat[259] = new Array("会计(国教)1202","11","02","2","12");
classcat[260] = new Array("国贸(国教)1201","11","03","1","12");
classcat[261] = new Array("国贸(国教)1202","11","03","2","12");
classcat[262] = new Array("软件1201","12","01","1","12");
classcat[263] = new Array("软件1202","12","01","2","12");
classcat[264] = new Array("软件1203","12","01","3","12");
classcat[265] = new Array("软件1204","12","01","4","12");
classcat[266] = new Array("软件工程1201","12","03","1","12");
classcat[267] = new Array("软件工程1202","12","03","2","12");
classcat[268] = new Array("软件工程1203","12","03","3","12");
classcat[269] = new Array("软件工程1204","12","03","4","12");
classcat[270] = new Array("风能与动力工程1201","15","01","1","12");
classcat[271] = new Array("风能与动力工程1202","15","01","2","12");
classcat[272] = new Array("机自1301","01","01","1","13");
classcat[273] = new Array("机自1302","01","01","2","13");
classcat[274] = new Array("机自1303","01","01","3","13");
classcat[275] = new Array("机自1304","01","01","4","13");
classcat[276] = new Array("机自1305","01","01","5","13");
classcat[277] = new Array("机自1306","01","01","6","13");
classcat[278] = new Array("机自1307","01","01","7","13");
classcat[279] = new Array("机自1308","01","01","8","13");
classcat[280] = new Array("机自1309","01","01","9","13");
classcat[281] = new Array("工业工程1301","01","02","1","13");
classcat[282] = new Array("工业工程1302","01","02","2","13");
classcat[283] = new Array("工业设计1301","01","03","1","13");
classcat[284] = new Array("车辆工程1301","01","04","1","13");
classcat[285] = new Array("车辆工程1302","01","04","2","13");
classcat[286] = new Array("车辆工程1303","01","04","3","13");
classcat[287] = new Array("物流工程1301","01","05","1","13");
classcat[288] = new Array("材料1301","02","00","1","13");
classcat[289] = new Array("材料1302","02","00","2","13");
classcat[290] = new Array("材料1303","02","00","3","13");
classcat[291] = new Array("材料1304","02","00","4","13");
classcat[292] = new Array("材料1305","02","00","5","13");
classcat[293] = new Array("材料1306","02","00","6","13");
classcat[294] = new Array("材料1307","02","00","7","13");
classcat[295] = new Array("材料1308","02","00","8","13");
classcat[296] = new Array("材料1309","02","00","9","13");
classcat[297] = new Array("材料1310","02","01","10","13");
classcat[298] = new Array("电气工程1301","03","01","1","13");
classcat[299] = new Array("电气工程1302","03","01","2","13");
classcat[300] = new Array("电气工程1303","03","01","3","13");
classcat[301] = new Array("电气工程1304","03","01","4","13");
classcat[302] = new Array("电气工程1305","03","01","5","13");
classcat[303] = new Array("电气工程1306","03","01","6","13");
classcat[304] = new Array("电气工程1307","03","01","7","13");
classcat[305] = new Array("电气工程1308","03","01","8","13");
classcat[306] = new Array("自动化1301","03","02","1","13");
classcat[307] = new Array("自动化1302","03","02","2","13");
classcat[308] = new Array("自动化1303","03","02","3","13");
classcat[309] = new Array("自动化1304","03","02","4","13");
classcat[310] = new Array("自动化1305","03","02","5","13");
classcat[311] = new Array("自动化1306","03","02","6","13");
classcat[312] = new Array("生物医学1301","03","03","1","13");
classcat[313] = new Array("生物医学1302","03","03","2","13");
classcat[314] = new Array("测控1301","04","01","1","13");
classcat[315] = new Array("测控1302","04","01","2","13");
classcat[316] = new Array("测控1303","04","01","3","13");
classcat[317] = new Array("测控1304","04","01","4","13");
classcat[318] = new Array("电子信息1301","04","02","1","13");
classcat[319] = new Array("电子信息1302","04","02","2","13");
classcat[320] = new Array("电子信息1303","04","02","3","13");
classcat[321] = new Array("电科1301","04","03","1","13");
classcat[322] = new Array("电科1302","04","03","2","13");
classcat[323] = new Array("通信工程1301","04","04","1","13");
classcat[324] = new Array("通信工程1302","04","04","2","13");
classcat[325] = new Array("通信工程1303","04","04","3","13");
classcat[326] = new Array("计算机1301","04","05","1","13");
classcat[327] = new Array("计算机1302","04","05","2","13");
classcat[328] = new Array("计算机1303","04","05","3","13");
classcat[329] = new Array("智能科学1301","04","07","1","13");
classcat[330] = new Array("工程管理1301","05","01","1","13");
classcat[331] = new Array("工程管理1302","05","01","2","13");
classcat[332] = new Array("工商管理1301","05","02","1","13");
classcat[333] = new Array("工商管理1302","05","02","2","13");
classcat[334] = new Array("市场营销1301","05","03","1","13");
classcat[335] = new Array("市场营销1302","05","03","2","13");
classcat[336] = new Array("会计学1301","05","04","1","13");
classcat[337] = new Array("会计学1302","05","04","2","13");
classcat[338] = new Array("物流管理1301","05","05","1","13");
classcat[339] = new Array("物流管理1302","05","05","2","13");
classcat[340] = new Array("电子商务1301","05","06","1","13");
classcat[341] = new Array("电子商务1302","05","06","2","13");
classcat[342] = new Array("法学1301","06","01","1","13");
classcat[343] = new Array("法学1302","06","01","2","13");
classcat[344] = new Array("广告学1301","06","04","1","13");
classcat[345] = new Array("广告学1302","06","04","2","13");
classcat[346] = new Array("视觉传达1301","06","06","1","13");
classcat[347] = new Array("视觉传达1302","06","06","2","13");
classcat[348] = new Array("环境设计1301","06","07","1","13");
classcat[349] = new Array("环境设计1302","06","07","2","13");
classcat[350] = new Array("计算科学1301","07","01","1","13");
classcat[351] = new Array("计算科学1302","07","01","2","13");
classcat[352] = new Array("应用物理1301","07","02","1","13");
classcat[353] = new Array("应用化学1301","07","03","1","13");
classcat[354] = new Array("应用化学1302","07","03","2","13");
classcat[355] = new Array("环境工程1301","07","04","1","13");
classcat[356] = new Array("环境工程1302","07","04","2","13");
classcat[357] = new Array("应用数学1301","07","05","1","13");
classcat[358] = new Array("功能材料1301","07","06","1","13");
classcat[359] = new Array("土木工程1301","08","01","1","13");
classcat[360] = new Array("土木工程1302","08","01","2","13");
classcat[361] = new Array("土木工程1303","08","01","3","13");
classcat[362] = new Array("土木工程1304","08","01","4","13");
classcat[363] = new Array("土木工程1305","08","01","5","13");
classcat[364] = new Array("土木工程1306","08","01","6","13");
classcat[365] = new Array("建筑学1301","08","02","1","13");
classcat[366] = new Array("建筑学1302","08","02","2","13");
classcat[367] = new Array("建筑能源1301","08","04","1","13");
classcat[368] = new Array("建筑能源1302","08","04","2","13");
classcat[369] = new Array("英语1301","09","01","1","13");
classcat[370] = new Array("英语1302","09","01","2","13");
classcat[371] = new Array("日语1301","09","02","1","13");
classcat[372] = new Array("日语1302","09","02","2","13");
classcat[373] = new Array("国际贸易1301","10","01","1","13");
classcat[374] = new Array("国际贸易1302","10","01","2","13");
classcat[375] = new Array("金融学1301","10","02","1","13");
classcat[376] = new Array("金融学1302","10","02","2","13");
classcat[377] = new Array("金融学1303","10","02","3","13");
classcat[378] = new Array("经济学1301","10","03","1","13");
classcat[379] = new Array("经济学1302","10","03","2","13");
classcat[380] = new Array("金融工程1301","10","04","1","13");
classcat[381] = new Array("会计(国教)1301","11","02","1","13");
classcat[382] = new Array("会计(国教)1302","11","02","2","13");
classcat[383] = new Array("国贸(国教)1301","11","03","1","13");
classcat[384] = new Array("国贸(国教)1302","11","03","2","13");
classcat[385] = new Array("软件1301","12","01","1","13");
classcat[386] = new Array("软件1302","12","01","2","13");
classcat[387] = new Array("软件1303","12","01","3","13");
classcat[388] = new Array("软件1304","12","01","4","13");
classcat[389] = new Array("软件工程1301","12","03","1","13");
classcat[390] = new Array("软件工程1302","12","03","2","13");
classcat[391] = new Array("软件工程1303","12","03","3","13");
classcat[392] = new Array("软件工程1304","12","03","4","13");
classcat[393] = new Array("能源科学1301","15","02","1","13");
classcat[394] = new Array("能源科学1302","15","02","2","13");
classcat[395] = new Array("机自1401","01","00","1","14");
classcat[396] = new Array("机自1402","01","00","2","14");
classcat[397] = new Array("机自1403","01","00","3","14");
classcat[398] = new Array("机自1404","01","00","4","14");
classcat[399] = new Array("机自1405","01","00","5","14");
classcat[400] = new Array("机自1406","01","00","6","14");
classcat[401] = new Array("机自1407","01","00","7","14");
classcat[402] = new Array("机自1408","01","00","8","14");
classcat[403] = new Array("机自1409","01","00","9","14");
classcat[404] = new Array("机自14010","01","01","10","14");
classcat[405] = new Array("机自14011","01","01","11","14");
classcat[406] = new Array("机自14012","01","01","12","14");
classcat[407] = new Array("工业工程1401","01","02","1","14");
classcat[408] = new Array("工业工程1402","01","02","2","14");
classcat[409] = new Array("工业设计1401","01","03","1","14");
classcat[410] = new Array("物流工程1401","01","05","1","14");
classcat[411] = new Array("材料1401","02","00","1","14");
classcat[412] = new Array("材料1402","02","00","2","14");
classcat[413] = new Array("材料1403","02","00","3","14");
classcat[414] = new Array("材料1404","02","00","4","14");
classcat[415] = new Array("材料1405","02","00","5","14");
classcat[416] = new Array("材料1406","02","00","6","14");
classcat[417] = new Array("材料1407","02","00","7","14");
classcat[418] = new Array("材料1408","02","00","8","14");
classcat[419] = new Array("材料1409","02","00","9","14");
classcat[420] = new Array("材料1410","02","01","10","14");
classcat[421] = new Array("电气工程1401","03","01","1","14");
classcat[422] = new Array("电气工程1402","03","01","2","14");
classcat[423] = new Array("电气工程1403","03","01","3","14");
classcat[424] = new Array("电气工程1404","03","01","4","14");
classcat[425] = new Array("电气工程1405","03","01","5","14");
classcat[426] = new Array("电气工程1406","03","01","6","14");
classcat[427] = new Array("电气工程1407","03","01","7","14");
classcat[428] = new Array("电气工程1408","03","01","8","14");
classcat[429] = new Array("自动化1401","03","02","1","14");
classcat[430] = new Array("自动化1402","03","02","2","14");
classcat[431] = new Array("自动化1403","03","02","3","14");
classcat[432] = new Array("自动化1404","03","02","4","14");
classcat[433] = new Array("自动化1405","03","02","5","14");
classcat[434] = new Array("自动化1406","03","02","6","14");
classcat[435] = new Array("生物医学1401","03","03","1","14");
classcat[436] = new Array("生物医学1402","03","03","2","14");
classcat[437] = new Array("测控1401","04","01","1","14");
classcat[438] = new Array("测控1402","04","01","2","14");
classcat[439] = new Array("测控1403","04","01","3","14");
classcat[440] = new Array("测控1404","04","01","4","14");
classcat[441] = new Array("电子信息1401","04","02","1","14");
classcat[442] = new Array("电子信息1402","04","02","2","14");
classcat[443] = new Array("电子信息1403","04","02","3","14");
classcat[444] = new Array("电科1401","04","03","1","14");
classcat[445] = new Array("电科1402","04","03","2","14");
classcat[446] = new Array("通信工程1401","04","04","1","14");
classcat[447] = new Array("通信工程1402","04","04","2","14");
classcat[448] = new Array("通信工程1403","04","04","3","14");
classcat[449] = new Array("计算机1401","04","05","1","14");
classcat[450] = new Array("计算机1402","04","05","2","14");
classcat[451] = new Array("计算机1403","04","05","3","14");
classcat[452] = new Array("智能科学1401","04","07","1","14");
classcat[453] = new Array("工程管理1401","05","01","1","14");
classcat[454] = new Array("工程管理1402","05","01","2","14");
classcat[455] = new Array("工商管理1401","05","02","1","14");
classcat[456] = new Array("工商管理1402","05","02","2","14");
classcat[457] = new Array("市场营销1401","05","03","1","14");
classcat[458] = new Array("市场营销1402","05","03","2","14");
classcat[459] = new Array("会计学1401","05","04","1","14");
classcat[460] = new Array("会计学1402","05","04","2","14");
classcat[461] = new Array("物流管理1401","05","05","1","14");
classcat[462] = new Array("物流管理1402","05","05","2","14");
classcat[463] = new Array("电子商务1401","05","06","1","14");
classcat[464] = new Array("电子商务1402","05","06","2","14");
classcat[465] = new Array("法学1401","06","01","1","14");
classcat[466] = new Array("法学1402","06","01","2","14");
classcat[467] = new Array("广告学1401","06","04","1","14");
classcat[468] = new Array("广告学1402","06","04","2","14");
classcat[469] = new Array("视觉传达1401","06","06","1","14");
classcat[470] = new Array("视觉传达1402","06","06","2","14");
classcat[471] = new Array("环境设计1401","06","07","1","14");
classcat[472] = new Array("环境设计1402","06","07","2","14");
classcat[473] = new Array("知识产权1401","06","08","1","14");
classcat[474] = new Array("计算科学1401","07","01","1","14");
classcat[475] = new Array("计算科学1402","07","01","2","14");
classcat[476] = new Array("应用物理1401","07","02","1","14");
classcat[477] = new Array("应用化学1401","07","03","1","14");
classcat[478] = new Array("应用化学1402","07","03","2","14");
classcat[479] = new Array("环境工程1401","07","04","1","14");
classcat[480] = new Array("环境工程1402","07","04","2","14");
classcat[481] = new Array("应用数学1401","07","05","1","14");
classcat[482] = new Array("功能材料1401","07","06","1","14");
classcat[483] = new Array("土木工程1401","08","01","1","14");
classcat[484] = new Array("土木工程1402","08","01","2","14");
classcat[485] = new Array("土木工程1403","08","01","3","14");
classcat[486] = new Array("土木工程1404","08","01","4","14");
classcat[487] = new Array("建筑学1401","08","02","1","14");
classcat[488] = new Array("建筑学1402","08","02","2","14");
classcat[489] = new Array("建筑能源1401","08","04","1","14");
classcat[490] = new Array("建筑能源1402","08","04","2","14");
classcat[491] = new Array("地下工程1401","08","05","1","14");
classcat[492] = new Array("道桥工程1401","08","06","1","14");
classcat[493] = new Array("英语1401","09","01","1","14");
classcat[494] = new Array("英语1402","09","01","2","14");
classcat[495] = new Array("日语1401","09","02","1","14");
classcat[496] = new Array("日语1402","09","02","2","14");
classcat[497] = new Array("国际贸易1401","10","01","1","14");
classcat[498] = new Array("国际贸易1402","10","01","2","14");
classcat[499] = new Array("金融学1401","10","02","1","14");
classcat[500] = new Array("金融学1402","10","02","2","14");
classcat[501] = new Array("金融学1403","10","02","3","14");
classcat[502] = new Array("经济学1401","10","03","1","14");
classcat[503] = new Array("经济学1402","10","03","2","14");
classcat[504] = new Array("金融工程1401","10","04","1","14");
classcat[505] = new Array("会计(国教)1401","11","02","1","14");
classcat[506] = new Array("会计(国教)1402","11","02","2","14");
classcat[507] = new Array("国贸(国教)1401","11","03","1","14");
classcat[508] = new Array("国贸(国教)1402","11","03","2","14");
classcat[509] = new Array("软件1401","12","01","1","14");
classcat[510] = new Array("软件1402","12","01","2","14");
classcat[511] = new Array("软件1403","12","01","3","14");
classcat[512] = new Array("软件1404","12","01","4","14");
classcat[513] = new Array("软件工程1401","12","03","1","14");
classcat[514] = new Array("软件工程1402","12","03","2","14");
classcat[515] = new Array("软件工程1403","12","03","3","14");
classcat[516] = new Array("软件工程1404","12","03","4","14");
classcat[517] = new Array("能源科学1401","15","02","1","14");
classcat[518] = new Array("能源科学1402","15","02","2","14");





/*document.form0.school1.length = 0;
document.form.0school1.options[0] = new Option("==请选择学院==","");

  
for(i=0;i<schoolcat.length;i++)
{

	document.form0.school1.options[document.form0.school1.length] = new Option(schoolcat[i][0],schoolcat[i][1]);
}*/
//自动生成学院下拉列表
document.form.school.length = 0;
document.form.school.options[0] = new Option("==请选择学院==","");

  
for(i=0;i<schoolcat.length;i++)
{

	document.form.school.options[document.form.school.length] = new Option(schoolcat[i][0],schoolcat[i][1]);
}

document.form.school.options[04].selected = true;
change_school('04');
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
		if((classcat[i][1]==document.form.school.options[document.form.school.selectedIndex].value)&&(classcat[i][2]==locationid) && (classcat[i][4] == document.form.grade.options[document.form.grade.selectedIndex].value))
		{
			document.form.w_class.options[document.form.w_class.length] = new Option(classcat[i][0],classcat[i][3]);
		}
	}
}
//option,学院,专业,班级,年级
function change_grade(locationid)
{
	document.form.w_class.length = 0; 
	document.form.w_class.options[0] = new Option("==请选择班级==","");
	//alert (locationid);
	for (i=0;i<classcat.length;i++)
	{
		if((classcat[i][1]==document.form.school.options[document.form.school.selectedIndex].value)&&classcat[i][4]==locationid&&classcat[i][2]==document.form.major.options[document.form.major.selectedIndex].value)
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
