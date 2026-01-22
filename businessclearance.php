<?php
require_once('connection.php');
require_once'notifybusiness.php';
$query = "SELECT * FROM pending_documents";
$result = mysqli_query($connect, $query);
$selectedFilter = isset($_GET['filter']) ? $_GET['filter'] : null;

$filteredQuery = "SELECT * FROM pending_documents WHERE document_type = 'Business Clearance'";

if ($selectedFilter && $selectedFilter != 'all') {
    $filteredQuery .= " AND status = '$selectedFilter'";
}

$filteredResult = mysqli_query($connect, $filteredQuery);


if (isset($_POST['decline'])) {
    $pending_document_id = $_POST['pending_document_id'];

    // Update the status to 'Rejected'
    $update_query = "UPDATE pending_documents SET status = 'Rejected' WHERE pending_document_id = '$pending_document_id'";
    mysqli_query($connect, $update_query);

    // Reload the page to see the updated status
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['reacquire'])) {
    $pending_document_id = $_POST['pending_document_id'];

    // Update the status to 'Pending'
    $update_query = "UPDATE pending_documents SET status = 'Pending' WHERE pending_document_id = '$pending_document_id'";
    mysqli_query($connect, $update_query);

    // Reload the page to see the updated status
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



if (isset($_POST['print']) || isset($_POST['accept'])) {
    require_once('tcpdf/tcpdf.php');


    class MYPDF extends TCPDF {

        public function Header() {
            $this->SetLineWidth(0.5);
            $this->SetDrawColor(260, 0, 0);
            $this->Line(10, $this->GetY(), 200, $this->GetY());
            $this->SetFont('helvetica', '', 11);
            // Set text color 
            $this->SetTextColor(0, 0, 0); 

            $image_file1 = 'ilog.png'; 
            $this->Image($image_file1, 10, 6, 36, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            
            $image_file2 = 'pasig.png'; 
            $this->Image($image_file2, 170, 9, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    
            $this->Ln(8); 
    
            $this->SetX(16); 
            $this->Cell(0, 10, 'REPUBLIC OF THE PHILIPPINES', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5); 
    
            $this->SetX(16);
            $this->Cell(0, 10, 'NATIONAL CAPITAL REGION', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5); 
            
            $this->SetFont('helvetica', 'B', 10);
            $this->SetX(16);
            $this->Cell(0, 10, 'CITY OF PASIG', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);

            $this->SetFont('helvetica', 'B', 15);
            $this->SetX(16);
            $this->Cell(0, 10, 'BARANGAY BAGONG ILOG', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(10);
            
            $this->SetLineWidth(0.5);
            $this->SetDrawColor(0, 0, 0);
            $this->Line(10, $this->GetY(), 200, $this->GetY());
        }
            
        public function Body($business_name, $business_location) {
            $this->SetFont('helvetica', 'B', 14);
            $this->Ln(25);

            $this->SetX(58); 
            $this->Cell(0, 10, 'OFFICE OF THE BARANGAY CHAIRMAN', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(25);

            $this->SetFont('helvetica', 'B', 18);
            $this->SetY(60);
            $this->SetX(70); 

            $this->Cell(0, 10, 'BUSINESS CLEARANCE', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(3);
            $this->SetLineWidth(0.5);
            $this->Line(71.5, $this->GetY(), 145, $this->GetY());

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(60);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(75.5); 
            $this->Cell(0, 10, 'Brgy.Clearance Number:_________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(65);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(115); 
            $this->Cell(0, 10, 'Date: ' . date('Y-m-d') , 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 
           
            $this->Ln(5);
            $this->SetX(150); 
            $this->SetY(80);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(33); 
            $this->Cell(0, 10, 'TO WHOM IT MAY CONCERN:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7);   

            $this->SetX(40); 
            $this->Cell(0, 10, 'This is to certify that as per available records in our office,', 0, false, 'L', 0, '', 0, false, 'M', 'M');
           
            $this->Ln(7); 
            $this->SetX(33); 
            $this->Cell(0, 10, $business_name . ' localed at ' . $business_location . '.' , 0, false, 'L', 0, '', 0, false, 'M', 'M');


            $this->Ln(7); 
            $this->SetX(33); 
            $this->Cell(0, 10, 'has no derogatory record as of this date. ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            

            $this->SetFont('helvetica', '', 13);
            $this->Ln(10); 
            $this->SetX(40); 
            $this->Cell(0, 10, 'Further certify that said business establishment will not affect the', 0, false, 'L', 0, '', 0, false, 'M', 'M');

            $this->Ln(7); 
            $this->SetX(33); 
            $this->Cell(0, 10, 'environment and health - safety of our constituent', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->Ln(10); 
            $this->SetX(40); 
            $this->Cell(0, 10, 'Finally certify that this barangay has no objection in the operation', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->Ln(7); 
            $this->SetX(33); 
            $this->Cell(0, 10, 'of the above named business establishment.', 0, false, 'L', 0, '', 0, false, 'M', 'M');

            $this->Ln(10); 
            $this->SetX(40); 
            $this->Cell(0, 10, 'This clearance is being issued for securing the necessary BUSINESS', 0, false, 'L', 0, '', 0, false, 'M', 'M');

            $this->Ln(7); 
            $this->SetX(33); 
            $this->Cell(0, 10, 'BUILDING/EXCAVATION/DEMOLITION/PERMIT/LICENSE from the city', 0, false, 'L', 0, '', 0, false, 'M', 'M');

            $this->Ln(7); 
            $this->SetX(33); 
            $this->Cell(0, 10, 'Government of Pasig', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->Ln(40); 
            $this->SetX(140);
            $this->SetY(195);
            $this->SetFont('helvetica', 'B', 10);
            
            $this->SetX(126); 
            $this->Cell(0, 10, '______________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5); 
            $this->SetX(132); 
            $this->Cell(0, 10, 'FERDINAND A. AVIS', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->Ln(3.5); 
            $this->SetFont('helvetica', 'B', 9);
            $this->SetX(134); 
            $this->Cell(0, 10, 'Barangay Chairman', 0, false, 'L', 0, '', 0, false, 'M', 'M');

            $this->SetFont('helvetica', 'B', 10);


            $this->SetX(30); 
            $this->Cell(0, 10, '_______________________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5); 
            $this->SetX(35); 
            $this->Cell(0, 10, 'Signature Over Printed Name of Applicant', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(210);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, 'Res.Cert No:_________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 


            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(215);
            $this->SetFont('helvetica', '', 13);
            
            $this->Ln(15);
            $this->SetX(55); 
            $this->Cell(0, 10, 'Bagong Ilog Barangay Hall', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 


            $this->Ln(5);
            $this->SetY(220);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(60);
            $this->Cell(0, 10, date('m-d-Y'), 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7);



            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(215);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, 'Issued at:___________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(220);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, 'Issued on:___________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(225);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, 'TIN:________________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(230);
            $this->SetFont('helvetica', '', 13);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, 'Telephone No:________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(238);
            $this->SetFont('helvetica', '', 10);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, 'NOTE: VALID UNTIL___________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

            $this->Ln(5);
            $this->SetX(150);
            $this->SetY(243);
            $this->SetFont('helvetica', '', 10);
        
            $this->Ln(15);
            $this->SetX(30); 
            $this->Cell(0, 10, '*NOT VALID WITHOUT DRY SEAL*', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7); 

        }
        
        public function Footer() {
            $this->SetY(283);
            $this->SetLineWidth(10);
            $this->SetDrawColor(260, 0, 0);
            $this->Line(10, $this->GetY(), 200, $this->GetY());
            $this->SetY(-20);
            $this->SetTextColor(255,255,255);
            $this->SetFont('helvetica', 'B', 8);
            $this->Cell(0, 10, 'SGT L. PASCUA ST. BARANGAY BAGONG ILOG, CITY OF PASIG', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            

            $this->SetY(-22);
            $this->Cell(0, 20, 'TELEPHONE NUMBER:(02) 671-0681', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    if (isset($_POST['business_name']) && isset($_POST['business_location'])) {
        $business_name = $_POST['business_name'];
        $business_location = $_POST['business_location'];
    } else {
        $business_name = '';
        $business_location = '';
    }
    $pending_document_id = isset ($_POST['pending_document_id']) ? $_POST['pending_document_id'] : null;
    $update_query = "UPDATE pending_documents SET status = 'Accepted' WHERE pending_document_id = '$pending_document_id'";
    mysqli_query($connect, $update_query);


    // Create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetAuthor('');
    $pdf->SetTitle('Business Clearance');
    $pdf->SetSubject('Clearance');
    $pdf->SetKeywords('Business,Clearance');
    
    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    
    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
   
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    $pdf->AddPage();
    
    if (isset($_POST['business_name']) && isset($_POST['business_location'])) {
        $business_name = $_POST['business_name'];
        $business_location = $_POST['business_location'];
        $pdf->Body($business_name,$business_location);
    } else {
        // Handle the case where form data is not provided
        die("Form data not provided.");
    }

    $pdf->lastPage();
    
    $pdf->Output('BusinessClearance.pdf', 'I');
    exit;
}
?>

<?php
require_once('connection.php');
$query = "SELECT * FROM pending_documents WHERE document_type = 'Business Clearance'";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
                    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f0f2f5;
        }

        .header {
            position: fixed;
            width: 100%;
            height: 65px;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
            top: 0;
            left: 0;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .header .title {
            display: flex;
            align-items: center;
        }

        .header .title img {
            margin-right: 10px;
        }

        .header .heading {
            color: #EEEEEE;
            
        }

        .outer-a-container {
            position: relative;
        }

        .outer-a {
            text-decoration: none;
            color: white;
           
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
        }

        .dropdown .inner-a:hover {
            color:lightblue;

        }
        
        .outer-a-container:hover .dropdown {
            display: block;
        }

        .nav {
            position: fixed;
            left: 0;
            top: 65px;
            display: flex;
            flex-direction: column;
            align-items: left;
            padding-top: 30px;
            justify-content: space-between;
            height: calc(100vh - 50px);
            width: 237px;
            background-color: #0C0C0C;
            z-index: 1000;
            
        }

        .options {
            width: 92%;
            padding: 10px;
            text-align: center;
            font-size: 13px;
        }

        .options:last-child {
            margin-top: auto;
        }

        .outer-a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            text-align: left;


        }

        .outer-a:hover {
            color:lightblue;
        }
      

        .nav .dropdown {
            display: none;
            position: static;
            background: none;
            box-shadow: none;
        }

        .nav .dropdown a {
            color: white;
          
        }

        .nav .options:hover .dropdown {
            display: block;
        }

        #logout {
            margin-bottom: 50px;
        }

        .container-dashboard {
            width: 85%;
            height: 76vh;
            position: fixed;
            right: 0%;
            top: 9%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        h1 {
            color: #0F044C;
            grid-column: span 2;
            font-size: 2.5rem;
            margin: 25px 0px 30px 35px;
            text-align: center;
        }

        h3 {
            font-size: 6%;
            
        }

        h4 {
            font-size: 3rem;
            margin-top: 20px;
            text-align: center;
        }
        #logout {
            margin-bottom: 50px;
        }

        .records-div {
            width: 87%;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            place-items: center;
            column-gap: 130px;
            row-gap: 30px;
            margin-left: 216px;
            margin-top: 5px;
            color: white;
        }

        .records, .records1, .records2, .records3, .records4, .records5 {
            
            background-size: cover;
            background-position: center;
            width: 160%;
            height: 33vh;
            border-radius: 30px;
            color: white;
            position: relative;
        }
      

        .records::before, .records1::before, .records2::before, .records3::before, .records4::before, .records5::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
         
            border-radius: 30px;
            color: white;
        }
.records {background-color: #0f0f0f;
        }
.records1 { background-color: rgb(26, 18, 83); }
.records2 { background-color: rgb(13, 150, 165); }
.records3 { background-color: rgb(26, 112, 121); }
.records4 { background-color: rgb(16, 11, 53); }
.records5 { background-color: rgba(15, 15, 15, 0.67); }

.records h3, .records1 h3, .records2 h3, .records3 h3, .records4 h3, .records5 h3 {
    margin: 20px 20px 30px 30px;
    padding-top: 10px;
    color: white ; /* Ensure color is white */
    font-size: 18px;
  
}

.records:hover {background-color: #0f0f0f; transform: scale(1.1);}
.records1:hover { background-color: rgb(26, 18, 83); transform: scale(1.1);}
.records2:hover { background-color: rgb(13, 150, 165); transform: scale(1.1); }
.records3:hover { background-color: rgb(26, 112, 121); transform: scale(1.1); }
.records4:hover { background-color: rgb(16, 11, 53); transform: scale(1.1);}
.records5:hover { background-color: rgba(15, 15, 15, 0.67); transform: scale(1.1); }
        .headingg {
            background-color: #f0f2f5;
        }
        #printpres {
            width: 100px;
            margin-right: 55px;
        }
        .card-header {
            background-color: rgba(63, 69, 79, 0.5);
        }
        .container {
            width: 82%; 
            text-align: center;
            margin: 0 auto;
            margin-top: 5rem;
            position: absolute;
            right: 1%;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }
        .table_bordered {
            border-collapse: collapse;
        }
        .table_bordered td, th{  
            font-size: 20px;
            padding: 9.3px;
            border: 1px solid black;
            color: black;
            background-color:white;
        }

        .scrollable-table {
            height: 400px; 
            overflow-y: auto;
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none; 
            color: white;
            background-color:gray;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
            margin-left: 40px;
        }
        .btngrouped {
            height: 25px;
            width: 230px
        }
        .btn-group {
            display: flex;
            justify-content: center;
            margin-left: 40px;
           
        }
        .btn-group button {
            flex: 1;
            text-align: center;
            height: 25px;
            padding: 2px 8px;
            color: white;
            font-size: 18px;
            margin: 0;
        }

        td b {
            color: black;
        }

        th b {
            color: black;
        }

        #printres button {
            background-color: 	#011f4b; 
            color: white;
            border-radius: 50px;
            height: 40px; 
            margin-left: 62rem;
            margin-bottom: 5px;
        }

        label {
            color: black;
        }
        #headd {
            margin-left: auto;
            color: black;
            text-align: center;
            margin: 0 auto;
            font-size: 3rem;
            margin-bottom: 10px;
        }

        #al {
            background-color: 	#011f4b;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #fil {
            background-color: #005b96;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #acc {
            background-color: 	#6497b1;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #rej {
            background-color: #b3cde0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #acpt, #dcl, #reac {
            border-radius: 50px;
            font-size: 14px;
            background-color: 	#011f4b;
            color: white;
        }
        #printArea {
            display: none;
        }
        @media print {
            body {
                color: black;
            }

            .table_bordered td,
            .table_bordered th {
                color: black;
            }
            #printArea {
                display: block;
            }
            .print-header {
                display: block;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }
        }   
    </style>
</head>
<body>
    <div class="header">
        <div class="title">
            <img src="./assets/bgi logo.png" height="55" alt="Logo">
            <h2 class="heading">ADMIN</h2>
        </div>
    </div>

    <div class="nav">
        <div class="options">
            <a href="index.php" class="outer-a"><i class="fas fa-tachometer-alt" style="margin-right: 5px;"></i>Dashboard</a>
        </div>

        <div class="options">
            <a href="residents.php" class="outer-a"><i class="fas fa-users" style="margin-right: 5px;"></i> Residents</a>
        </div>
        
        <div class="options">
            <a href="household.php" class="outer-a"><i class="fas fa-users" style="margin-right: 5px;"></i> Households</a>
        </div>

        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-clock" style="margin-right: 5px;"></i> Pending</a>
            <ul class="dropdown">
                <li><a href="pendingAcc.php" class="inner-a">Pending Accounts</a></li>
                <li><a href="pendingRequest.php" class="inner-a">Pending Requests</a></li>
            </ul>
        </div>

        <div class="options">
            <a href="audit.php" class="outer-a"><i class="fas fa-search" style="margin-right: 5px;"></i> Check Activities</a>
        </div>
        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-edit" style="margin-right: 5px;"></i> Update Information</a>
            <ul class="dropdown">
                <li><a href="officials.php" class="inner-a">Barangay Officials</a></li>
                <li><a href="hotline.php" class="inner-a">Hotline Number</a></li>
                <li><a href="events.php" class="inner-a">Events</a></li>
                <li><a href="announce.php" class="inner-a">Announcements</a></li>
                <li><a href="statistics.php" class="inner-a">Statistics</a></li>
            </ul>
        </div>
        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-archive" style="margin-right: 5px;"></i> Archives</a>
            <ul class="dropdown">
                <li><a href="archivedofficials.php" class="inner-a">Barangay Officials</a></li>
                <li><a href="archivedevent.php" class="inner-a"> Events</a></li>
                <li><a href="archivedannounce.php" class="inner-a"> Announcements</a></li>
                <li><a href="archivedList.php" class="inner-a">Resident List</a></li>
            </ul>
        </div>

        <div class="options">
            <a href="homepage.php" class="outer-a" id="logout"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Log out</a>
        </div>
    </div>
    <div class="container">
                    <div class="card-header">
                        <form action="" method="post" style="display: flex; justify-content: flex-end;">
                        </form>
                        <form class="headingg" action="" method="GET">
                        <div id="headd">
                            <label for="title">Business Clearance</label>
                        </div>                    
                            <div class="btn-group">
                                <button type="submit"  id="al" name="filter" value="all"  <?php echo ($selectedFilter == 'all' || !$selectedFilter) ? 'custom-button' : ''; ?>">All</button>
                                <button type="submit" id="fil" name="filter" value="pending"  <?php echo ($selectedFilter == 'pending') ? 'custom-button' : ''; ?>">Pending</button>
                                <button type="submit"  id="acc" name="filter" value="accepted"  <?php echo ($selectedFilter == 'accepted') ? 'custom-button' : ''; ?>">Accepted</button>
                                <button type="submit"  id="rej" name="filter" value="rejected"  <?php echo ($selectedFilter == 'rejected') ? 'custom-button' : ''; ?>">Rejected</button>
                            </div>
                        </form>
                    </div>
                    <div class="scrollable-table">
                        <table class="table_bordered">
                            <tr>
                                <td><b>Resident ID</b></td>
                                <td><b>Full Name</b></td>
                                <td><b>Document Type</b></td>
                                <td><b>Business Address</b></td>
                                <td><b>Business Name</b></td>
                                <td><b>Status</b></td>
                                <td><b>Created At</b></td>
                                <th><b>Action</b></th>
                            </tr>
                            <tr>
                            <?php
                                $residentsData = $selectedFilter ? $filteredResult : $result;
                                while ($row = mysqli_fetch_assoc($residentsData)) {
                                  echo "<tr>";
                            ?>
                                <td><?php echo !is_null($row['pending_document_id']) ? $row['pending_document_id'] : 'N/A'; ?></td>
                                <td><?php echo !is_null($row['full_name']) ? $row['full_name'] : 'N/A'; ?></td>
                                <td><?php echo !is_null($row['document_type']) ? $row['document_type'] : 'N/A'; ?></td>
                                <td><?php echo !is_null($row['business_location']) ? $row['business_location'] : 'N/A'; ?></td>
                                <td><?php echo !is_null($row['business_name']) ? $row['business_name'] : 'N/A'; ?></td>
                                <td><?php echo !is_null($row['status']) ? $row['status'] : 'N/A'; ?></td>
                                <td><?php echo !is_null($row['created_at']) ? $row['created_at'] : 'N/A'; ?></td>
                                <td>
                                <form method="post" action="">
                                        <input type="hidden" name="pending_document_id" value="<?php echo $row['pending_document_id']; ?>">
                                        <input type="hidden" name="business_name" value="<?php echo $row['business_name']; ?>">
                                        <input type="hidden" name="business_location" value="<?php echo $row['business_location']; ?>">
                                        <input type="hidden" name="full_name" value="<?php echo $row['full_name']; ?>">
                                        <input type="hidden" name="address" value="<?php echo $row['address']; ?>">
                                        <input type="hidden" name="reason_for_application" value="<?php echo $row['reason_for_application']; ?>">
                                        <input type="hidden" name="email_pen_doc" value="<?php echo $row['email_user']; ?>">
                                        <input type="hidden" name="status" value="Accepted">
                                        <div class="btngrouped">
                                        <button id="acpt" type="submit" name="accept">Accept</button>
                                        <button id="dcl" type="submit" name="decline">Decline</button>
                                        <button id="reac" type="submit" name="reacquire">Reacquire</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }   
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printTable() {
            var printContents = document.getElementById('printArea').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
