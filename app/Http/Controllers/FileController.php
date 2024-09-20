<?php

namespace App\Http\Controllers;

use App\Http\Requests\Files\UploadFileRequest;
use App\Interfaces\FileInterface;
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
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadFileRequest $request)
    {
        $file = [
            'group_id' => $request->group_id,
            'name' => str_replace(' ', '_', $request->file->getClientOriginalName()),
            'file_size' => $request->file->getSize(),
        ];

        $destinationPath = 'db/groupDatas/files/';

        try {

            $myFile = $request->file('file');
            $myFile->move($destinationPath, $file['name']);

            $file = $this->fileInterface->store($file);

            return ApiResponse::sendResponse(true, $file, 'Fichier téléchargé avec succès.', 201);

        } catch (\Throwable $th) {

            /*return ApiResponse::rollback($th);*/ return $th;

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
}
