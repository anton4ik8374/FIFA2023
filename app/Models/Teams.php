<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;

class Teams extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'name',
        'name_ru',
        'alter_name',
        'description',
        'logo',
    ];

    public function matcheHome(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Matches::class, 'team_home_id', 'id');
    }

    public function matcheAway(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Matches::class, 'team_away_id', 'id');
    }

    public static function doAdd(array $data) : array {

        $team_home = self::where('name', $data['team_home'])->orWhere('name_ru', $data['team_home'])->orWhere('alter_name', $data['team_home'])->first();
        $team_away = self::where('name', $data['team_away'])->orWhere('name_ru', $data['team_away'])->orWhere('alter_name', $data['team_away'])->first();

        $result_home = ['name' => $data['team_home']];
        $result_away = ['name' => $data['team_away']];

        if(!$team_home){
            $team_home = self::add($result_home);
            if(isset($data['img_home'])){
                $team_home->uploadImagesToUrl($data['img_home']);
            }
        }
        if(!$team_away){
            $team_away = self::add($result_away);
            if(isset($data['img_away'])){
                $team_away->uploadImagesToUrl($data['img_away']);
            }
        }

        return [$team_home->id, $team_away->id];

    }

    /**
     * @param string $str
     * @return bool
     */
    public static function isContainsRussianLetters(string $str) : bool
    {
        return (bool) preg_match('/[\p{Cyrillic}]/u', $str);
    }

    /**
     * Удаляем оригинал
     * @param $name
     * @return void
     */
    public function deleteImages($name): void
    {
        $arrImages = [];
        $pattern = env('APP_URL', '') . '/storage';
        if($this->logo){
            $arrImages[] = str_replace($pattern, "", $this->logo);
        }

        if(count($arrImages)) {
            Storage::disk('public')->delete($arrImages);
        }
    }


    /**
     * Загружаем новое изоюражение
     * @param $images
     * @return string|void
     */
    public function uploadImagesToUrl($images, $dir = '/logos/')
    {
        $status = false;
        if($images && file_get_contents($images)) {
            $file = file_get_contents($images);
            $fileSystem = Storage::disk('public');

            if (!!$this->logo) {
                $fileSystem->delete($this->logo);
            }
            $fileType = explode('.', $images);
            $fileName = $dir . Str::random(20) . '.' . $fileType[count($fileType) - 1];
            $status = Storage::disk('public')->put($fileName, $file);
            $this->logo = $fileName;
            $this->save();
        }
        return $status;

    }

    public function uploadImages($images)
    {
        $fileSystem = Storage::disk('public');
        if ($images == null) { return;}

        if(!!$this->logo) {
            $fileSystem->delete($this->logo);
        }

        $fileName = Storage::disk('public')->put('logos', $images);

        $this->logo = $fileName;
        $this->save();

        $arrayImage = explode('/', $fileName);
        return $arrayImage[1];

    }

    public static function getDrawn(){

        return self::whereNameEn('Drawn')->first();
    }
}
