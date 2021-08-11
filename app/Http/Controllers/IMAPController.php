<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IMAPController extends Controller
{
    public function index(){
        set_time_limit(3000); 

        /* connect to gmail with your credentials */
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'mahendralakum.ap@gmail.com'; 
        $password = 'osbrmrpyrmmqwcke';

        /* try to connect */
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

        $emails = imap_search($inbox,'FROM "mahendralakum.ap@gmail.com"');

        /* if any emails found, iterate through each email */
        if($emails) {

        $count = 1;

        /* put the newest emails on top */
        rsort($emails);

        /* for every email... */
        foreach($emails as $email_number) 
        {

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox,$email_number,0);

        $message = imap_fetchbody($inbox,2,2);

        /* get mail structure */
        $structure = imap_fetchstructure($inbox, $email_number);

        $attachments = array();

        /* if any attachments found... */
        if(isset($structure->parts) && count($structure->parts)) 
        {
        for($i = 0; $i < count($structure->parts); $i++) 
        {
        $attachments[$i] = array(
        'is_attachment' => false,
        'filename' => '',
        'name' => '',
        'attachment' => ''
        );

        if($structure->parts[$i]->ifdparameters) 
        {
        foreach($structure->parts[$i]->dparameters as $object) 
        {
        if(strtolower($object->attribute) == 'filename') 
        {
        $attachments[$i]['is_attachment'] = true;
        $attachments[$i]['filename'] = $object->value;
        }
        }
        }

        if($structure->parts[$i]->ifparameters) 
        {
        foreach($structure->parts[$i]->parameters as $object) 
        {
        if(strtolower($object->attribute) == 'name') 
        {
        $attachments[$i]['is_attachment'] = true;
        $attachments[$i]['name'] = $object->value;
        }
        }
        }

        if($attachments[$i]['is_attachment']) 
        {
        $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

        /* 3 = BASE64 encoding */
        if($structure->parts[$i]->encoding == 3) 
        { 
        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
        }
        /* 4 = QUOTED-PRINTABLE encoding */
        elseif($structure->parts[$i]->encoding == 4) 
        { 
        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
        }
        }
        }
        }

        /* iterate through each attachment and save it */
        foreach($attachments as $attachment)
        {
        if($attachment['is_attachment'] == 1)
        {
        $filename = $attachment['name'];
        if(empty($filename)) $filename = $attachment['filename'];

        if(empty($filename)) $filename = time() . ".dat";
        $folder = "attachment";
        if(!is_dir($folder))
        {
        mkdir($folder);
        }
        $fileInfo = pathinfo($filename);
        if($fileInfo['extension'] == 'xlsx'){
        $fp = fopen(public_path('attachment/'). $email_number . "-" . $filename, "w+");
        fwrite($fp, $attachment['attachment']);
        fclose($fp);
        }
        }
        }
        }
        } 

        /* close the connection */
        imap_close($inbox);

}

    public function view(){
        $mydir = public_path('attachment');
        $files = scandir($mydir);
        unset($files[0],$files[1]);
        return view('imap.view',compact('files'));
    }

    public function read(){
        //Follow Example https://phpspreadsheet.readthedocs.io/en/latest/topics/accessing-cells/#looping-through-cells-using-iterators
        $inputFileName = public_path('attachment/174-rosterSample.xlsx');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();
        // Get the highest row number and column letter referenced in the worksheet
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        // Increment the highest column letter
        $highestColumn++;
        
        echo '<table border="1">' . "\n";
        for ($row = 1; $row <= $highestRow; ++$row) {
            echo '<tr>' . PHP_EOL;
            for ($col = 'A'; $col != $highestColumn; ++$col) {
                echo '<td>';
                if($col == 'G'){
                    echo $worksheet->getCellByColumnAndRow($col,$row)->getFormattedValue(); 
                } else {
                    echo $worksheet->getCell($col . $row)
                    ->getValue();
                }
                echo '</td>';
                
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;
    }
}
