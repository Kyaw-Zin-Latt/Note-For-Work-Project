<?php

namespace App\Http\Controllers;

use App\Config\Config;
use App\Http\Services\LanguageService;
use App\Models\CoreImage;
use App\Models\Language;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\LanguageString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Stidges\CountryFlags\CountryFlag;
use function Symfony\Component\Translation\t;

class LanguageController extends Controller
{

    protected $perPage, $languageService;
    public function __construct(LanguageService $languageService)
    {
        $this->perPage = Config::perPage;
        $this->languageService = $languageService;
    }

    public function index()
    {
        $languages = $this->languageService->getLanguages($this->perPage);
        return renderView("Entry/Language/Index", ["languages" => $languages]);
    }

    public function create()
    {
        return renderView("Entry/Language/Create");
    }

    public function store(StoreLanguageRequest $request)
    {
        $language = $this->languageService->store($request);
        return redirect()->back()->with("status",["flag" => "success", "msg" => "Language have been created successfully."]);

    }

    public function show(Language $language)
    {
        //
    }

    public function edit(Language $language)
    {
        $language = Language::where('id',$language->id)->with(['image'])->first();
        return renderView("Entry/Language/Edit", ["language" => $language]);
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $language = $this->languageService->update($language, $request);
        return $language;
        return redirect()->back();
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->back();
    }

    public function default(Language $language)
    {
        DB::table('languages')->update(['default' => 0]);

        $language->default = 1;
        $language->update();

        return redirect()->back();
    }

    public function status(Language $language)
    {
        if ($language->status){
            $language->status = 0;
        } else {
            $language->status = 1;
        }
        $language->update();

        return redirect()->back();
    }

    public function changeLanguage($lang){
        App::setLocale($lang);
        Session::put("locale", $lang);
        $value = Session::get('locale');
        return redirect()->back();
    }

}
