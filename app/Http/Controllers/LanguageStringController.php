<?php

namespace App\Http\Controllers;

use App\Config\Config;
use App\Models\Language;
use App\Models\LanguageString;
use App\Http\Requests\StoreLanguageStringRequest;
use App\Http\Requests\UpdateLanguageStringRequest;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LanguageStringController extends Controller
{

    protected $perPage, $parentPath;

    public function __construct()
    {
        $this->perPage = Config::perPage;
        $this->parentPath = "Entry/LanguageString/";
    }

    public function index($languageId)
    {
        $languageStrings = LanguageString::with(['language'])->where("language_id",$languageId)->paginate($this->perPage);
        $dataArr = [
            "languageStrings" => $languageStrings,
            "languageId" => $languageId
        ];
        return renderView($this->parentPath."Index", $dataArr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($languageId)
    {
        $language = Language::findOrFail($languageId);
        $dataArr = [
            "language" => $language
        ];
        return renderView($this->parentPath."Create", $dataArr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLanguageStringRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguageStringRequest $request)
    {
        $languages = Language::all();

        foreach ($languages as $language){
            $languageString = new LanguageString();
            $languageString->key = $request->key;
            $languageString->value = GoogleTranslate::trans($request->string, $language->symbol, null);
            $languageString->language_id = $language->id;
            $languageString->added_user_id = Auth::id();
            $languageString->save();

            generateLangJson($language->id, $language->symbol);
        }

        // generate lang json file

        return redirect()->back()->with("status",["flag" => "success", "msg" => "lang_string_saved"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LanguageString  $languageString
     * @return \Illuminate\Http\Response
     */
    public function show(LanguageString $languageString)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LanguageString  $languageString
     * @return \Illuminate\Http\Response
     */
    public function edit(LanguageString $languageString)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLanguageStringRequest  $request
     * @param  \App\Models\LanguageString  $languageString
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanguageStringRequest $request, LanguageString $languageString)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LanguageString  $languageString
     * @return \Illuminate\Http\Response
     */
    public function destroy(LanguageString $languageString)
    {
        //
    }
}
