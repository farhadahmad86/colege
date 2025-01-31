<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaveImageController extends Controller
{
    public function SaveImage($request, $fieldName, $uniqueId, $filepath, $fileNameToStore)
    {
//        $fileNameToStore = 'Profile_Image';
        // Handle file upload

        if ($request->hasFile($fieldName)) {

            // Get file name with extension
            $fileNameWithExt = $request->file($fieldName)->getClientOriginalName();
            // Get Just file name

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = $request->file($fieldName)->getClientOriginalExtension();
            // File Name to store
//            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $fileNameToStore = $fileNameToStore . '.' . $extension;
            //upload image
            $path = $request->file($fieldName)->storeAs($filepath . '/' . $uniqueId . '/', $fileNameToStore);

        } else {
            $path = config('global_variables.default_image_path');
        }

        return $path;
    }

    public function SavePdf($request, $fieldName, $filepath, $fileNameToStore)
    {
        // Handle file upload
        if ($request->hasFile($fieldName)) {
            // Get file name with extension
            $fileNameWithExt = $request->file($fieldName)->getClientOriginalName();
            // Get Just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file($fieldName)->getClientOriginalExtension();
            $fileNameToStore = $fileNameToStore . '.' . $extension;

            $path = $request->file($fieldName)->storeAs($filepath . '/', $fileNameToStore);
        } else {
            $path = config('global_variables.default_image_path');
        }
        return $path;
    }

    public function BeforeSaveImage($fieldName, $filepath, $fileNameToStore)
    {
        // Handle file upload
        if (!empty ($fieldName)) {

            // Get file name with extension
            $fileNameWithExt = $fieldName->getClientOriginalName();
            // Get Just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = rand() . '.' . $fieldName->getClientOriginalExtension();
            // File Name to store
            $fileNameToStore = $fileNameToStore . '.' . $extension;
            //upload image
            $path = $fieldName->storeAs($filepath . '/', $fileNameToStore);
        } else {
            $path = config('global_variables.default_image_path');
        }

        return $path;
    }

    public function ExecutionSaveImage($fieldName, $filepath, $fileNameToStore)
    {

        // Handle file upload
        if (!empty ($fieldName)) {

            // Get file name with extension
            $fileNameWithExt = $fieldName->getClientOriginalName();

            // Get Just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = rand() . '.' . $fieldName->getClientOriginalExtension();
            // File Name to store
            $fileNameToStore = $fileNameToStore . '.' . $extension;
            //upload image
            $path = $fieldName->storeAs($filepath . '/', $fileNameToStore);
        } else {
            $path = config('global_variables.after_image_path');
        }

        return $path;
    }


}
