<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class TestController extends Controller
{
    public function index()
    {
        dd('Hello from TestController!');
    }
    
    // Sample Method to Export PDF file
    public function export_pdf()
    {
        // Create an instance of the class:
        $mpdf = new Mpdf();

        // Write some HTML code:
        $mpdf->WriteHTML('Hello World! This is exported from TestController@export_pdf');

        // Output a PDF file directly to the browser
        $mpdf->Output();
    }

    // Sample Method to Export Excel file (XLS, XLSX, CSV)
    public function export_excel()
    {
        // Create an instance of the class:
        $spreadsheet = new Spreadsheet();

        // Get Active Sheet:
        $sheet = $spreadsheet->getActiveSheet();
        
        // Write some value into Cell:
        $sheet->setCellValue('A1', 'Hello World! from TestController@export_excel');

        // Create an instance of IOFactory class for export:
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx'); // Set Output + File Type (Xls, Xlsx, Csv)

        // Set Filename:
        $filename = 'hello_world' .'_'. time() . '.xlsx'; // Assign filename | Please change the file extension (.xlsx / .xls / .csv) according to your choosen file type
        
        // Save file into Server Public folder: (Will Not Download)
        // $excel = $writer->save($filename);

        // Download Excel File (Without saving to Server):

        // --- Let server know the File Type
        // header("Content-Type: application/vnd.ms-excel"); // for XLS
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); // for XLSX
        // header("Content-Type: application/csv"); // for CSV

        header('Content-Disposition: attachment; filename="'.$filename.'"'); // Tell server the filename
        header('Cache-Control: max-age=0'); // Set no cache
        $writer->save("php://output"); // Download File
        exit; // Stop process (MUST)
    }

    // Sample Method to Send Email
    public function send_email()
    {
        // Laravel using Mailable to templating Email Output
        // 1. Setup SMTP in .env file
        // Refer: https://github.com/CyberSharky94/laravel_6_estudms#how-to-install @ point number 6 -> # Sample of Mail Configuration:
        // 2. Create Mailable using PHP Artisan: php artisan make:mail TestEmail (will be stored in Mail folder)
        // 3. Set public variable, __construct and view inside TestEmail class
        // 4. Create custom Blade file for the email. Prepare the output.
        // 5. Setup controller method as below.
        // 6. Define route to send email.

        $data['controller_method_name'] = 'TestController@send_email';
        Mail::to('testemail@anymail.com')->send(new TestEmail($data));

        return 'Email sent!';
    }
}
