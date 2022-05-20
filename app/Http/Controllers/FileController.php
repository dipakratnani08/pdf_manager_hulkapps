<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    //

    public function index()
    {
        $filedata = File::get();

        return view('fileUpload', ['filedata' => $filedata]);
    }


    public function store(Request $request)
    {
        $request->validate(['file'=>'required|mimes:pdf']);

        $fileModel = new File;
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            //$filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $filePath = $request->file->move(public_path('uploads'), $fileName);
            $fileModel->name = $fileName;
            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
    }
}
