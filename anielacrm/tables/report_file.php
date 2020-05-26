<?php
	session_start();
	$typeDownload = (isset($_GET['td']) && $_GET['td'] !== '') ? $_GET['td'] : 'null';
	if($typeDownload != 'null'){
		if($typeDownload == 'json' || $typeDownload == 'xml'){
			$db = mysqli_connect("localhost:3308", "root", "", "project");
			$sql = "SELECT YEAR(DATE_OF_RECEIPT) AS YEAR	, SUM(COST) AS REVENUE  FROM contracts group by YEAR(DATE_OF_RECEIPT)";
			$result = mysqli_query($db, $sql);
			
			if($typeDownload == 'json'){
				
				header('Content-disposition: attachment; filename=jsonFile.json');
				header('Content-type: application/json');
				
				$dbdata = array();

				while ( $row = $result->fetch_assoc())  {
					$dbdata[]=$row;
				}
				echo json_encode($dbdata);
				
			}else if($typeDownload == 'xml'){
				header('Content-disposition: attachment; filename=xmlFile.xml');
				header('Content-type: text/xml');
				
				
				$xml .= '<?xml version="1.0" encoding="utf-8"?>';
				$xml .= "<rss version='2.0'>".PHP_EOL;
				$xml .= '<report>'.PHP_EOL;
				$item = 0;
				while ( $row = $result->fetch_assoc())  {
					$item++;
					$xml.= "\t<item id=" .$item. ">\n";
					$xml.= "\t\t<year>" .$row['YEAR']. "</year>\n";
					$xml.= "\t\t<revenue>" .$row['REVENUE']. "</revenue>\n";
					$xml.= "\t</item>\n";
				}
				$xml .= '</report>';
				echo $xml;
			}
		}else if($typeDownload == 'pdf'){
			// require_once "../koolreport/packages/cloudexport/vendor/autoload.php";
			require_once "../koolreport/core/autoload.php";

			require_once "report.php";
			$report = new Report;
			$report->run()
			->cloudExport("ReportPDF")
			->chromeHeadlessio('4747adfb0a53b1c0536986390cec2495ab3ebcaaa54191b23c86d7a172740807')
			->pdf([
				"scale"=>1,
				"format"=>"A4",
				"landscape"=>true
			])
			->toBrowser("myreport.pdf");
		}
	
	}
	
?>