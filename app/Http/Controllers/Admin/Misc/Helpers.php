<?php

namespace App\Http\Controllers\Admin\Misc;

use Illuminate\Http\Request;

class Helpers {

    public function generateFileName($originalFileName)
    {
        $arrFileNameData = explode('.', $originalFileName);
        $arrFileNameData = array_reverse($arrFileNameData);
        $fileExtension = $arrFileNameData[0];

        $newFileName = md5(microtime() . rand(0, 9999));
        $newFileName = $newFileName . '.' . $fileExtension;

        return $newFileName;
    }

    public function uploadNewFile($request, $fieldName, $type)
    {
        $fileEntity = $request->file($fieldName);
        $originalFileName = $fileEntity->getClientOriginalName();
        $newFileName = $this->generateFileName($originalFileName);
        $fileEntity->move(public_path() . '/uploads/' . $type, $newFileName);

        return $newFileName;
    }

    public function checkFileExist($fileName, $type)
    {
        $fileLocation = 'uploads/' . $type . '/' . $fileName;
        if (file_exists($fileLocation)) {
            return true;
        }

        return false;
    }

    public function deleteOldFile($oldFile, $type)
    {
        if ($oldFile != '' && $oldFile != null) {
            $oldFileLocation = 'uploads/' . $type . '/' . $oldFile;
            if (file_exists($oldFileLocation)) {
                unlink($oldFileLocation);
            }
        }
    }

//---------------------- Ajax Functions --------------------------------------------------------------------------------

    public function ajaxDeleteImages(Request $request)
    {
        if ($request->ajax()) {
            $fileName = $request->name;
            $type = $request->type;

            $fileLocation = 'uploads/' . $type . '/' . $fileName;

            if (file_exists($fileLocation)) {
                unlink($fileLocation);
            }

            return response()->json(['success' => true]);
        }
    }
}
