<?php

namespace App\Traits;

use Illuminate\Support\Str;


trait HasDefaultTranslatable
{
//    public static function bootHasDefaultTranslatable(): void
//    {
//        static::creating(function ($model) {
//
//            if (isset($model->translatedAttributes)) {
//                $default_lang = app()->getLocale();
//                foreach ($model->translatedAttributes as $translatedAttribute) {
//                    if (request()->has($default_lang) && isset(request($default_lang)[$translatedAttribute])) {
//                        $translatedAttributeValue = request($default_lang)[$translatedAttribute];
//                        $model->$translatedAttribute = $translatedAttributeValue;
////                        dd($translatedAttribute,$model->$translatedAttribute,$translatedAttributeValue);
//                    }
//                }
//            }
////            $model->name = "Ahmed Ali";
//
////            dd($model);
//
//        });
//    }
}
