<?php
if($_SESSION[$valSiteManage."core_session_language"]=="Eng"){
	
}else if($_SESSION[$valSiteManage."core_session_language"]=="CN"){
		$langMod["txt:titleadd"] = "创建数据".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:titleedit"] = "编辑信息".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:titleview"] = "显示数据".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:sortpermis"] = "碎片整理".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:subject"] = "信息".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:subjectDe"] = "请输入代理编号信息";
		$langMod["txt:title"] = "ข้อมูลรายละเอียด".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:titleDe"] = "โปรดป้อนรายละเอียด เพื่อใช้ในการแสดงผลในหน้าเว็บไซต์ของคุณ";
		$langMod["txt:pic"] = "รูปภาพประกอบ";
		$langMod["txt:picDe"] = "ข้อมูลรูปภาพประกอบ เพื่อใช้ในการแสดงผลรูปภาพของเนื้อหานี้";

		$langMod["txt:seo"] = "กำหนดวันที่ในการแสดงผล";
		$langMod["txt:seoDe"] = "ข้อมูลนี้คือส่วนที่ใช้ในการกำหนดวันที่ในการแสดงผล เพื่อใช้ในการแสดงผลในหน้าเว็บไซต์ของคุณ";

		$langMod["inp:notedate"] ="หมายเหตุ : กรณีไม่ต้องการระบุวันเริ่มต้น และวันสิ้นสุดของเนื้อหานี้ กรุณาเว้นไว้ไม่ต้องกรอกข้อมูลใดๆ";
		$langMod["edit:linknote"] ="หมายเหตุ : กรุณา URL นำหน้าด้วย \"http://\" เช่น https://www.kubetthailand.com เป็นต้น<br />กรณีไม่มีชื่อ URL ให้ใส่เครื่องหมาย #";
		$langMod["inp:album"] ="เลือกรูปภาพ";
		$langMod["tit:subject"] ="หัวข้อ".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["tit:sdate"] ="วันเริ่มต้น";
		$langMod["tit:edate"] ="วันสิ้นสุด";
		$langMod["file:type"] ="ประเภท";
		$langMod["file:size"] ="ขนาด";
		$langMod["file:download"] ="ดาวน์โหลด";
		$langMod["tit:linkvdo"] ="ลิงค์";
		$langMod["home:detail"] ="อ่านรายละเอียด";
		$langMod["tit:typevdo"] ="การแสดงผล";
		$langMod["tit:position"] ="ตำแหน่งการจัดวาง";
		$langMod["inp:notepic"] ="หมายเหตุ : กรุณาอัพโหลดเฉพาะไฟล์ .jpg, .png และ .gif เท่านั้น, ขนาดของรูปภาพไม่เกิน 2 Mb และรูปภาพที่ให้ในการอัพโหลดควรมีสัดส่วนที่ ".$sizeWidthReal."x".$sizeHeightReal." พิกเซล";

		$langMod["tit:selectfb"] ="เลือกเฟสบุ๊คพนักงานขาย";
		$langMod["tit:selectfbn"] ="เฟสบุ๊คพนักงานขาย";

		$langMod["tit:selectsell"] ="选择互动员";
		$langMod["tit:selectselln"] ="พนักงานขาย";
		
		$langMod["tit:selectdv"] ="เลือกรหัสผู้แนะนำ";
		$langMod["tit:selectdvn"] ="รหัสผู้แนะนำ";

		$langMod["tit:selectstatus"] ="选择会员状态";
		$langMod["tit:selectstatusn"] ="สถานะ";

		$langMod["tit:inpSoc"] ="ชื่อ ไลน์-เฟสบุ๊ค ลูกค้า";
		$langMod["tit:inpcuid"] ="ไอดีสมาชิกลูกค้า";

		$langMod["tit:date"] ="วันที่";


		$langMod["tit:inpName"] = "ชื่อ".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["tit:countries"] = "Countries";
		$langMod["tit:selectcountries"] = "Select Countries";
		$langMod["tit:detail"] = "หมายเหตุ";

		$langMod["tit:sdate"] = "ค้นหาจากเดือน/ปี";

		$langMod["tit:month"] = "เดือน";
		$langMod["tit:stmonth"] = "สถิติเดือน";

		$langMod["tit:no"] = "序号";
		$langMod["tit:dv"] = "代理编号";
		$langMod["tit:sell"] = "人员";
		$langMod["tit:regis"] = "注册";
		$langMod["tit:deposit"] = "存";
		$langMod["tit:perfor"] = "效率";

		$langMod["tit:sSedate"]= "开始日期";
		$langMod["tit:eSedate"]= "结束日期";

		$langMod["tit:to"]= "ถึง";

		$langMod["tit:regis"] = "注册";
		$langMod["tit:deposit"] = "存";
		$langMod["tit:date-cn"] = "日期";
		$langMod["tit:total"] = "总结";
		$langMod["tit:month"] = "เดือน";
}else{
		$langMod["txt:titleadd"] = "สร้างข้อมูล".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:titleedit"] = "แก้ไขข้อมูล".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:titleview"] = "แสดงผลข้อมูล".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:sortpermis"] = "จัดเรียงข้อมูล".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:subject"] = "ข้อมูล".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:subjectDe"] = "โปรดป้อนหัวข้อ เพื่อใช้ในการแสดงผลในหน้าเว็บไซต์ของคุณ";
		$langMod["txt:title"] = "ข้อมูลรายละเอียด".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["txt:titleDe"] = "โปรดป้อนรายละเอียด เพื่อใช้ในการแสดงผลในหน้าเว็บไซต์ของคุณ";
		$langMod["txt:pic"] = "รูปภาพประกอบ";
		$langMod["txt:picDe"] = "ข้อมูลรูปภาพประกอบ เพื่อใช้ในการแสดงผลรูปภาพของเนื้อหานี้";

		$langMod["txt:seo"] = "กำหนดวันที่ในการแสดงผล";
		$langMod["txt:seoDe"] = "ข้อมูลนี้คือส่วนที่ใช้ในการกำหนดวันที่ในการแสดงผล เพื่อใช้ในการแสดงผลในหน้าเว็บไซต์ของคุณ";

		$langMod["inp:notedate"] ="หมายเหตุ : กรณีไม่ต้องการระบุวันเริ่มต้น และวันสิ้นสุดของเนื้อหานี้ กรุณาเว้นไว้ไม่ต้องกรอกข้อมูลใดๆ";
		$langMod["edit:linknote"] ="หมายเหตุ : กรุณา URL นำหน้าด้วย \"http://\" เช่น https://www.kubetthailand.com เป็นต้น<br />กรณีไม่มีชื่อ URL ให้ใส่เครื่องหมาย #";
		$langMod["inp:album"] ="เลือกรูปภาพ";
		$langMod["tit:subject"] ="หัวข้อ".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["tit:sdate"] ="วันเริ่มต้น";
		$langMod["tit:edate"] ="วันสิ้นสุด";
		$langMod["file:type"] ="ประเภท";
		$langMod["file:size"] ="ขนาด";
		$langMod["file:download"] ="ดาวน์โหลด";
		$langMod["tit:linkvdo"] ="ลิงค์";
		$langMod["home:detail"] ="อ่านรายละเอียด";
		$langMod["tit:typevdo"] ="การแสดงผล";
		$langMod["tit:position"] ="ตำแหน่งการจัดวาง";
		$langMod["inp:notepic"] ="หมายเหตุ : กรุณาอัพโหลดเฉพาะไฟล์ .jpg, .png และ .gif เท่านั้น, ขนาดของรูปภาพไม่เกิน 2 Mb และรูปภาพที่ให้ในการอัพโหลดควรมีสัดส่วนที่ ".$sizeWidthReal."x".$sizeHeightReal." พิกเซล";

		$langMod["tit:selectfb"] ="เลือกเฟสบุ๊คพนักงานขาย";
		$langMod["tit:selectfbn"] ="เฟสบุ๊คพนักงานขาย";

		$langMod["tit:selectsell"] ="เลือกพนักงานขาย";
		$langMod["tit:selectselln"] ="พนักงานขาย";
		
		$langMod["tit:selectdv"] ="เลือกรหัสผู้แนะนำ";
		$langMod["tit:selectdvn"] ="รหัสผู้แนะนำ";

		$langMod["tit:selectstatus"] ="เลือกสถานะ";
		$langMod["tit:selectstatusn"] ="สถานะ";

		$langMod["tit:inpSoc"] ="ชื่อ ไลน์-เฟสบุ๊ค ลูกค้า";
		$langMod["tit:inpcuid"] ="ไอดีสมาชิกลูกค้า";

		$langMod["tit:date"] ="วันที่";


		$langMod["tit:inpName"] = "ชื่อ".getNameMenu($_REQUEST["menukeyid"]);
		$langMod["tit:countries"] = "Countries";
		$langMod["tit:selectcountries"] = "Select Countries";
		$langMod["tit:detail"] = "หมายเหตุ";

		$langMod["tit:sdate"] = "ค้นหาจากเดือน/ปี";

		$langMod["tit:month"] = "เดือน";
		$langMod["tit:stmonth"] = "สถิติเดือน";

		$langMod["tit:no"] = "ลำดับ";
		$langMod["tit:dv"] = "รหัสผู้แนะนำ";
		$langMod["tit:sell"] = "พนักงาน";
		$langMod["tit:regis"] = "สมัคร";
		$langMod["tit:deposit"] = "ฝาก";
		$langMod["tit:perfor"] = "ประสิทธิภาพ";

		$langMod["tit:sSedate"]= "วันที่เริ่มต้น";
		$langMod["tit:eSedate"]= "วันที่สิ้นสุด";

		$langMod["tit:to"]= "ถึง";

		$langMod["tit:regis"] = "สมัคร";
		$langMod["tit:deposit"] = "ฝาก";
		$langMod["tit:date-cn"] = "วันที่";
		$langMod["tit:total"] = "ยอดรวม";
		$langMod["tit:month"] = "เดือน";
}
?>
