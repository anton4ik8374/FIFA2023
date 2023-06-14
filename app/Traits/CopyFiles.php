<?php
namespace App\Traits;



use Illuminate\Support\Facades\Storage;
/**
 * Копируем файлы в локальную папку
 *
 */
trait CopyFiles
{
    private function runCopy($serverPath, $pathToSave, $dirTosave)
    {
        try {
            $allFiles = Storage::allFiles($serverPath);

            foreach ($allFiles as $file) {

                $nameArr = explode('/', $file);
                Storage::copy($file , $pathToSave . $dirTosave . '/' . $nameArr[2]);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('No directory specified! ' . json_encode($e->getMessage(), true));
        }
    }
}
