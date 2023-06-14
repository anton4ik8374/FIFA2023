<?php
namespace App\Traits;



use Illuminate\Support\Facades\Storage;
/**
 * Скачиваем файлы в локальную папку
 *
 */
trait DownloadFTP
{
    private function downloadFiles($pathToSave, $dirTosave, $serverPath)
    {
        try {
            $host = env('MANUAL_HOST');
            $connection = ftp_connect($host);
            ftp_set_option($connection, FTP_TIMEOUT_SEC, 180);
            $login_result = ftp_login($connection, env('MANUAL_USER'), env('MANUAL_PASSWORD'));
            ftp_pasv($connection, true);
            $contents_on_server = ftp_nlist($connection, $serverPath);

            foreach ($contents_on_server as $remoteFile) {
                $fileNameArray = explode("/", $remoteFile);
                $fileName = end($fileNameArray);
                if (strrpos($fileName, $this->type)) {
                    $localFile = $pathToSave . $dirTosave . $fileName;
                    $handle = fopen(Storage::path($localFile), 'w');
                    ftp_fget($connection, $handle, $remoteFile, FTP_BINARY, 0);
                    fclose($handle);
                }
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('No directory specified! ' . json_encode($e->getMessage(), true));
        }
    }
}
