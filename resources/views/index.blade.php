@extends('voyager::master')

@section('page_title', 'Translation')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-file-text"></i> Translation
        </h1>
    </div>
@stop

@section('css')
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <style>
        #voyager-loader {
            display: none !important;
        }
    </style>
@stop
@section('content')
<body>
<div id="app" v-cloak>
    <div class="container-fluid">
        <div class="row" v-if="baseLanguage && _.toArray(currentLanguageTranslations).length">
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h3 class="panel-title panel-icon">
                        @{{ _.toArray(currentLanguageTranslations).length }} Keys
                        <span class="text-danger" v-if="_.toArray(currentLanguageUntranslatedKeys).length">@{{ _.toArray(currentLanguageUntranslatedKeys).length }} Un-translated</span>
                    </h3>
                    <div class="panel-actions">
                        <ul class="nav navbar-nav ">
                            <li class="dropdown profile">
                                <a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false" style="padding: 10px !important; margin-right: 10px">
                                    @{{ selectedLanguage }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-animated">
                                    <li v-for="lang in languages"
                                       v-on:click="selectedLanguage = lang"
                                       class="dropdown-item text-uppercase">
                                        <a href="#">@{{ lang }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <button class="btn btn-info btn-add-new"
                                v-on:click="promptToAddNewKey" v-if="languages.length"
                                type="button">Add
                        </button>
                        <button class="btn btn-success btn-add-new"
                                v-on:click="save" v-if="languages.length"
                                type="button">Save
                            <small v-if="this.hasChanges" class="text-danger">&#9679;</small>
                        </button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="input-group mainSearch">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input type="text" class="form-control" v-model="searchPhrase" placeholder="Search">
                        </div>
                        <br>
                        <div class="mt-4" style="overflow: scroll; height: 500px">
                            <div class="list-group">

                                <a href="#" role="button"
                                   v-for="line in filteredTranslations"
                                   v-on:click="selectedKey = line.key"
                                   :class="['list-group-item', 'list-group-item-action', {'list-group-item-danger': !line.value}]">
                                    <div class="d-flex w-100 justify-content-between">
                                        <strong class="mb-1" v-html="highlight(line.key)"></strong>
                                    </div>
                                    <small class="text-muted" v-html="highlight(line.value)"></small>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div v-if="selectedKey">
                            <p class="mb-4" style="font-weight: bold">Original: <span v-html="highlight(selectedKey)"></span></p>
                            <br>
                            <textarea name="" rows="10" class="form-control mb-4"
                                      v-model="translations[selectedLanguage][selectedKey]"
                                      placeholder="Translate..."></textarea>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-danger" v-on:click="removeKey(selectedKey)">Delete this key</button>
                            </div>
                        </div>

                        <h5 class="text-muted text-center" v-else>
                            Select a key from the list to the left
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <p class="lead text-center" v-if="!languages.length">
                There are no JSON language files in your project.<br>
                <button class="btn btn-outline-primary mt-3" v-on:click="addLanguage">Add Language</button>
            </p>

            <p class="lead text-center" v-if="languages.length">
                There are no Translation lines yet, start by adding new keys or <br>
                <a href="#" role="button" v-on:click="scanForKeys">scan</a> your project for lines to translate.
            </p>
        </div>
    </div>
</div>


@stop
@section('javascript')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
    <script>
        const langman = {
            csrf: "{{csrf_token()}}",
            baseLanguage: '{!! config('translation-gui.base_language') !!}',
            languages: {!! json_encode($languages) !!},
            translations: {!! json_encode($translations) !!}
        };
    </script>
    <script src="{{asset('vendor/translation/translation.js')}}"></script>
@stop
