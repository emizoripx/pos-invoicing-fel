<?php

namespace EmizorIpx\PosInvoicingFel\Repository;

use EmizorIpx\PosInvoicingFel\Models\FelContingencyFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class FelContingencyFileRepository {

    protected $provider = FelContingencyFile::class;

    
    public function processRequest ($request, $id = null){

        $contingency_file = null;
        $input = [];
        $upload_new_file = false;
        $restorant_id = auth()->user()->restorant->id;
        $old_path = "";

        if( !is_null($id) ){
            $contingency_file = $this->provider::find($id);

            if( empty($contingency_file) ){
                throw new Exception("No se encontro registro");
            }

            if( $contingency_file->canBeProcessed() ){
                throw new Exception("El archivo se esta procesando");
            }

            $old_path = $contingency_file->file_path;

            if( $request->hasFile('file') ){
                $upload_new_file = true;
            } else {
                \Log::debug("NO SE ELIMINARA EL ARCHIVO");
            }

        } else {

            $upload_new_file = true;
        }

        if( $upload_new_file ){

            $file_object = $request->file;

            $base_file_path = "contingeny-files/$restorant_id/files";

            $input = [
                "restorant_id" => $restorant_id,
                "user_id" => auth()->user()->id,
                "cafc_id" => $request->cafc_id,
                "state" => FelContingencyFile::STATUS_PENDING,
                "file_name" => $file_object->getClientOriginalName(),
                "file_content_type" => $file_object->getClientMimeType(),
                // "file_size_kb" => $file_object->getClientSize(),
            ];

            $path = Storage::disk('s3')->put($base_file_path, $file_object);

            $input['file_path'] = $path;

            $this->provider::create($input);

        }

        if (! is_null($id)){

            if( $upload_new_file && Storage::disk('s3')->exists( $old_path ) ){
                Storage::disk('s3')->delete($old_path);

                \Log::debug("Archivo Eliminado: " . $old_path);
            }

        }


    }

}