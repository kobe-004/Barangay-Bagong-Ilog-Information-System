<?php

if (isset($_POST['printresident'])) {
    require_once('tcpdf/tcpdf.php');

    $host = 'localhost';
    $db = 'bagong_ilog';
    $user = 'root';
    $pass = '';
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM resident WHERE status = 'active' ";
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
             $this->Image($image_file1, 115, 5, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
             $this->Ln(10); 
             $image_file2 = 'pasig.png'; 
             $this->Image($image_file2, 212, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
             $this->Line(10  , $this->GetY(), 345, $this->GetY());
        }

        public function Body($data, $conn) { 
            $this->Ln(18);
            
            $this->SetX(15); 
            $this->SetFont('helvetica', 'B', 17);

             $this->Cell(0, 10, 'RESIDENT LIST', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             $this->Ln(10); 
             $this->SetFont('helvetica', '', 11);
             $content = '<table border="1">';
             $content .= '<thead>'; 
             $content .= '<tr><th style="font-weight: bold; text-align: center;">Last Name</th>
             <th style="font-weight: bold; text-align: center;">First Name</th>
             <th style="font-weight: bold; text-align: center;">Middle Name</th>
             <th style="font-weight: bold; text-align: center;">Birthday</th>
             <th style="font-weight: bold; text-align: center;">Age</th>
             <th style="font-weight: bold; text-align: center;">Gender</th>
             <th style="font-weight: bold; text-align: center;">Civil Status</th>
             <th style="font-weight: bold; text-align: center;">Occupation</th>
             <th style="font-weight: bold; text-align: center;">House Number</th>
             <th style="font-weight: bold; text-align: center;">Street</th>
             <th style="font-weight: bold; text-align: center;">Educational Attainment</th>
             <th style="font-weight: bold; text-align: center;">Registered Voter</th>
             <th style="font-weight: bold; text-align: center;">Status</th>
             </tr>';
             $content .= '</thead>';
             
             $content .= '<tbody>';
             
             $sql = "SELECT * FROM resident WHERE status = 'active' ";
             $stmt = $conn->prepare($sql);
             if ($stmt) { 
                 if ($stmt->execute()) {
                     $result = $stmt->get_result();
                     while ($data = $result->fetch_assoc()) {
                         $content .= "<tr>";
                         $content .= "<td style='text-align: center;'>{$data['Last_name']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['First_name']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Middle_name']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Birthday']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Age']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Gender']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Civil_Status']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Occupation']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['house_number']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['street']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Educational_Attainment']}</td>";
                         $content .= "<td style='text-align: center;'>{$data['Registered_Voter']}</td>";
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

    $pdf = new MYPDF('L', PDF_UNIT, 'LEGAL', true, 'UTF-8', false);
    
    $pdf->SetAuthor('BAGONG ILOG');
    $pdf->SetTitle('Residents');
    $pdf->SetSubject('Residents');
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

    $pdf->Output('Residents.pdf', 'I');
    exit;
}
?>

