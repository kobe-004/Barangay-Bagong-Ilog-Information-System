<?php

if (isset($_POST['ann'])) {
    require_once('tcpdf/tcpdf.php');

    $host = 'localhost';
    $db = 'bagong_ilog';
    $user = 'root';
    $pass = '';
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `announcement`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        die("No records found.");
    }

    class MYPDF extends TCPDF {
        public function Header() {
             $this->Ln(10); 
             $this->SetFont('helvetica', '', 11);
             $this->SetTextColor(0, 0, 0); 
             $this->Ln(8); 
             $image_file1 = 'bgi logo.png'; 
             $this->Image($image_file1, 45, 5, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
             $this->Ln(10); 
             $image_file2 = 'pasig.png'; 
             $this->Image($image_file2, 138, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
             $this->Ln(5); 
             $this->SetX(15); 
             $this->Cell(0, 10, 'Republic of the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             $this->Ln(5); 
     
             $this->SetX(15);
             $this->Cell(0, 10, 'NATIONAL CAPITAL REGION', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             $this->Ln(5); 
     
             $this->SetX(15);
             $this->Cell(0, 10, 'CITY OF PASIG', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             $this->Ln(5);
 
     
             $this->SetX(15);
             $this->Cell(0, 10, 'BARANGAY BAGONG ILOG', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             $this->Ln(9);
             
     
             
             $this->SetLineWidth(0.5);
             $this->SetDrawColor(0, 0, 0); 
             $this->Line(10  , $this->GetY(), 200, $this->GetY());
        }

        public function Body($data, $conn) { 
            $this->Ln(18);
            
            $this->SetX(15); 
            $this->SetFont('helvetica', 'B', 17);

             $this->Cell(0, 10, 'ANNOUNCEMENTS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             $this->Ln(10); 
             $this->SetFont('helvetica', '', 11);
             $content = '<table border="1">';
             $content .= '<thead>'; 
             $content .= '<tr>
             <th style="font-weight: bold; text-align: center;">Title</th>
             <th style="font-weight: bold; text-align: center;">Description</th>
             <th style="font-weight: bold; text-align: center;">Date</th>
             <th style="font-weight: bold; text-align: center;">Status</th></tr>';
             $content .= '</thead>';
             
             $content .= '<tbody>';
             
             $sql = "SELECT * FROM `announcement` 
             ORDER BY CASE 
                 WHEN status = 'active' THEN 0  
                 WHEN status = 'inactive' THEN 1 
                 ELSE 2                          
             END";
     
             $stmt = $conn->prepare($sql);
             if ($stmt) { 
                 if ($stmt->execute()) {
                     $result = $stmt->get_result();
                     while ($data = $result->fetch_assoc()) {
                         $content .= "<tr>";
                         $content .= "<td style='text-align: center;'>{$data['announcement_title']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['announcement_description']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['date']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['status']}</td>";
                         $content .= "</tr>";
                     }
                 }
             }
             
             $content .= '</tbody>';
             $content .= '</table>';
             
             return $content;
             
        }
    }

    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetAuthor('SAGAD');
    $pdf->SetTitle('announcements');
    $pdf->SetSubject('announcements');
    $pdf->SetKeywords('off');

    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->AddPage();

    $content = $pdf->Body($data, $conn);

    $pdf->writeHTML($content, true, true, true, false, '');

    $pdf->Output('Announcements.pdf', 'I');
    exit;
}
?>

