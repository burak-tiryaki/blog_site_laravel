<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    public function index()
    {
        return view('back.config.index');
    }

    public function configPost(Request $request)
    {
        $request->validate([
            'logo' => 'nullable | mimes:png,jpg,jpeg,webp',
            'favicon' => 'nullable | mimes:ico',
        ]);
        $data = array();

        if($request->hasFile('logo')){

            if (File::exists(public_path($request->oldlogo)) && $request->oldlogo != null) 
            {
                // Eski dosyayı sil
                unlink(public_path($request->oldlogo));
                //Session::flash('status', 'Eski dosya başarıyla silindi.');
            }

            $logo = $request->file('logo');

            $logoName = 'mainLogo'.'.'.$request->logo->getClientOriginalExtension();
            
            $logoPath = public_path('/');
            
            
            $logo->move($logoPath,$logoName);
            
            $data["CUSTOM_SITE_LOGO"] = '/'.$logoName;
        }

        if($request->hasFile('favicon')){

            if (File::exists(public_path($request->oldfavicon))  && $request->oldfavicon != null) 
            {
                // Eski dosyayı sil
                unlink(public_path($request->oldfavicon));
                //Session::flash('status', 'Eski dosya başarıyla silindi.');
            }

            $favicon = $request->file('favicon');

            $faviconName = 'favicon'.'.'.$request->favicon->getClientOriginalExtension();
            
            $faviconPath = public_path('');
            
            $favicon->move($faviconPath,$faviconName);
            
            $data["CUSTOM_SITE_FAVICON"] = '/'.$faviconName;
        }

        
        $data +=[
            "CUSTOM_SITE_TITLE" => $request->title,
            "CUSTOM_SITE_ACTIVE" => $request->active,
            "CUSTOM_SITE_GITHUB_URL" => $request->github,
            "CUSTOM_SITE_LINKEDIN_URL" => $request->linkedin,
            "CUSTOM_SITE_TWITTER_URL" => $request->twitter,
            "CUSTOM_SITE_INSTAGRAM_URL" => $request->instagram,
        ];

        
        $this->updateEnvVariable($data);

        toastr('Configuration is set.','success','Success');
        return redirect()->back();
    }

    private function updateEnvVariable(array $values)
    {
        // .env dosyasının yolu
        $envFilePath = base_path('.env');

        // .env dosyasını oku
        $envContent = File::get($envFilePath);

        foreach($values as $key => $value){
            // Yeni değeri oluştur
            $newValue = "{$key}=\"{$value}\"";
    
            // Değiştirmek istediğimiz satırı bul ve değiştir
            $envContent = preg_replace("/^{$key}=.*/m", $newValue, $envContent);
        }

        // Değiştirilmiş içeriği .env dosyasına yaz
        File::put($envFilePath, $envContent);
    }
}
