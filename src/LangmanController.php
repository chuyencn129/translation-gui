<?php

namespace Meesudzu\Translation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class LangmanController
{
    /**
     * Return view for index screen.
     *
     * @return Response
     */
    public function index()
    {
        return view('translation::index', [
            'translations' => app(Manager::class)->getTranslations(),
            'languages' => array_keys(app(Manager::class)->getTranslations())
        ]);
    }

    /**
     * Save the translations
     *
     * @return void
     */
    public function save()
    {
        app(Manager::class)->saveTranslations(request()->translations);
    }

    /**
     * Save the translations
     *
     * @return void
     */
    public function add()
    {
        app(Manager::class)->addLanguage(request()->language);
    }
}
