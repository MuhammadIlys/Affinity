<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class PdfController extends Controller
{
    public function downloadPDF()
    {
        // Retrieve all users
        $users = User::where('role', '!=', 'admin')->get();

        // Create a temporary directory for the PDFs
        $tempDirectory = storage_path('app/temp_pdfs');
        if (!file_exists($tempDirectory)) {
            mkdir($tempDirectory, 0777, true);
        }

        // Generate PDF for each user
        foreach ($users as $user) {
            $pdf = Pdf::loadView('Admin.pdf.user_data_pdf', compact('user'));
            $pdf->save($tempDirectory . '/' . $user->first_name . '.pdf');
        }

        // Create a ZIP file  
        $zipFileName = 'users_data.zip';
        $zip = new ZipArchive;
        $zipFilePath = storage_path('app/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            // Add PDFs to the ZIP
            foreach ($users as $user) {
                $zip->addFile($tempDirectory . '/' . $user->first_name . '.pdf', $user->first_name . '.pdf');
            }
            $zip->close();
        }

        // Delete the temporary PDFs after zipping them
        $this->deleteDirectory($tempDirectory);

        // Return the ZIP file for download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    // public function downloadPDF()
    // {
    //     // Retrieve all users (excluding admins)
    //     $users = User::where('role', '!=', 'admin')->get();

    //     // Create a temporary directory for the PDFs
    //     $tempDirectory = storage_path('app/temp_pdfs');
    //     if (!file_exists($tempDirectory)) {
    //         mkdir($tempDirectory, 0777, true);
    //     }

    //     // Generate a single PDF with all user data and save it to the temporary directory
    //     $pdf = Pdf::loadView('Admin.pdf.user_data_pdf', compact('users'));
    //     $pdf->save($tempDirectory . '/users_data.pdf');

    //     // Create a ZIP file  
    //     $zipFileName = 'users_data.zip';
    //     $zip = new ZipArchive;
    //     $zipFilePath = storage_path('app/' . $zipFileName);

    //     if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
    //         // Add the generated PDF to the ZIP
    //         $zip->addFile($tempDirectory . '/users_data.pdf', 'users_data.pdf');
    //         $zip->close();
    //     }

    //     // Delete the temporary PDFs after zipping them
    //     $this->deleteDirectory($tempDirectory);

    //     // Return the ZIP file for download
    //     return response()->download($zipFilePath)->deleteFileAfterSend(true);
    // }

    private function deleteDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }


    public function downloadCheckedPDF(Request $request)
    {
        $selectedIds = collect($request->input('selected_ids', []))
            ->map(fn($id) => (int)$id)
            ->all();


        if (empty($selectedIds)) {
            return back()->with('error', 'No users selected.');
        }
        $users = DB::table('users')
            ->whereIn('id', $selectedIds)
            ->get();

        // return view('Admin.pdf.checked_referrers',compact('users'));
        
        // Increase memory and execution time
        ini_set('memory_limit', '256M'); // or 512M if needed
        set_time_limit(10);              // Wait up to 10 seconds if needed

        // Set DomPDF options for larger PDFs and longer render time
        $pdf = Pdf::loadView('Admin.pdf.checked_referrers', compact('users'));
        $pdf->setPaper('A4', 'portrait');

        // Optional: If you're using many images/fonts, increase DOMPDF limits
        $pdf->getDomPDF()->set_option("isPhpEnabled", true);
        $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
        $pdf->getDomPDF()->set_option("isRemoteEnabled", true);

        return $pdf->download('selected_users.pdf');
    }
}
