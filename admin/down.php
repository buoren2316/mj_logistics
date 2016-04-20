<?php
/*
 * func: submit user info
 * auth: buoren
 * date: 2016/4/19
 */

	include('../src/config/global.php');
	header('Content-Type: text/html; charset=utf-8');

	if (!$_POST) die ('no post');

	session_start();

	foreach($_POST as $key => $value) {
		if($value) {
			$post[$key] = $_SESSION[$key] = $value;
		} else {
			print('<script>alert("error '.$key.' empty");</script>');
			print('<script>history.back(-1);</script>');
		}
	}

	if ($_SESSION['uname'] <> $sign['admin'] || md5($_SESSION['passwd']) <> $sign['passwd']) {
		print('<script>alert("error username or password");</script>');
		print('<script>history.back(-1);</script>');
	}

	$today = date("Y-m-d");
	if ($post['date']) $today = $post['date'];

	
	if ($post['submit'] == '导出') {
		//判断日期格式
		if (!is_date($post['date'])) print('<script>alert("日期格式错误 YYYY-mm-dd");history.back(-1);</script>');

		$conn = new DBSQL();
		$sql  = 'select * from user where date(addtime) = "'.$today.'"';
		$data = $conn->select($sql);

		require_once '../lib/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        // 设置excel 列title
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue( 'A1','username')
            ->setCellValue( 'B1','company')
            ->setCellValue( 'C1','department')
            ->setCellValue( 'D1','title')
            ->setCellValue( 'E1','email')
            ->setCellValue( 'F1','topics')
            ->setCellValue( 'G1','channel')
            ->setCellValue( 'H1','event')
            ->setCellValue( 'I1','other_event')
            ->setCellValue( 'J1','remark')
            ->setCellValue( 'K1','other_remark')
            ->setCellValue( 'L1','addtime');



        // 设置单元格宽度
		/*
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
		*/
        $objPHPExcel->getActiveSheet()->getStyle('H')->getFill()->getStartColor()->setARGB('FF808080');

		$num = 1;
		foreach ($data as $key=>$value) {
		$num++;
		  $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A'.$num,$value['username'])
                ->setCellValue('B'.$num,$value['company'])
                ->setCellValue('C'.$num,$value['department'])
                ->setCellValue('D'.$num,$value['title'])
                ->setCellValue('E'.$num,$value['email'])
                ->setCellValue('F'.$num,$value['topics'])
                ->setCellValue('G'.$num,$value['channel'])
                ->setCellValue('H'.$num,$value['event'])
                ->setCellValue('I'.$num,$value['other_event'])
                ->setCellValue('J'.$num,$value['remark'])
                ->setCellValue('K'.$num,$value['other_remark'])
                ->setCellValue('L'.$num,$value['addtime']);
		}

        

        $objPHPExcel->getActiveSheet()->setTitle('output Form');

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$today.'-form.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        //header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}

	print '
		<!DOCTYPE html>
		<html>
		<body>
		<form method="post">
			  <fieldset>
				<legend>导出记录</legend>
				请输入日期： <input type="text" name="date" value="'.$today.'"/>
				<input type="submit" name="submit" value="导出" style="width:70px"/>
			  </fieldset>
		</form>
		</body>
		</html>
	';
