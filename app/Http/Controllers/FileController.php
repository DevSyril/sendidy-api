<?php

namespace App\Http\Controllers;

use App\Http\Requests\Files\UploadFileRequest;
use App\Interfaces\FileInterface;
use App\Models\File;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class FileController
{

    private FileInterface $fileInterface;

    public function __construct(FileInterface $fileInterface)
    {
        $this->fileInterface = $fileInterface;
    }


    /**
     * Display a listing of the resource.
     */
    public function groupFiles(string $id)
    {
        try {

            $file = File::where('group_id', $id)->get();

            return ApiResponse::sendResponse(true, $file, 'Fichier téléchargé avec succès.', 200);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadFileRequest $request)
    {
        
        $file = [
            'group_id' => $request->group_id,
            'name' => rand(1111, 9999) . str_replace(' ', '_', $request->file->getClientOriginalName()),
            'file_size' => $request->file->getSize(),
            'file_type' => $request->file->extension(),
        ];

        $destinationPath = 'db/groupDatas/files/';

        try {

            $myFile = $request->file('file');
            $myFile->storeAs('uploads', $file['name']);

            $myFile->move($destinationPath, $file['name']);

            $files = $this->fileInterface->store($file);

            return ApiResponse::sendResponse(true, $files, 'Fichier téléchargé avec succès.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(string $id) {

        $file = File::where('id', $id)->first();

        $filePath = storage_path("app/private/uploads/$file->name");

        if (file_exists($filePath)) {

            return response()->download($filePath, $file->name);

        } else {
            abort(404, 'Le fichier est introuvable');

            return ApiResponse::sendResponse(false, null, 'Fichier introuvable.', 404);
        }
    }
}
