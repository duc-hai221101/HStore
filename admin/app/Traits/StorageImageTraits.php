<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait StorageImageTraits
{
    public function storageTraitUpload($request, $fieldName, $folderName, $oldImagePath = null)
    {
        if ($request->hasFile($fieldName)) {
            // Xóa ảnh cũ nếu tồn tại
            if ($oldImagePath) {
                $this->deleteOldImage($oldImagePath);
            }

            $file = $request->file($fieldName);
            $fileName = $file->getClientOriginalName();
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file_path = $request->file($fieldName)->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);
            $dataUpTrait = [
                'file_name' => $fileName,
                'file_path' => Storage::url($file_path)
            ];
            return $dataUpTrait;
        }
        return null;
    }

    public function storageTraitUploadMutiple($file, $folderName)
    {
        $fileName = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file_path = $file->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);
        $dataUpTrait = [
            'file_name' => $fileName,
            'file_path' => Storage::url($file_path)
        ];
        return $dataUpTrait;
    }

    private function deleteOldImage($imagePath)
    {
        $path = str_replace('/storage/', '/public/', $imagePath);
        Storage::delete($path);
    }

}