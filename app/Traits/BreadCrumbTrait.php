<?php

namespace App\Traits;

trait BreadCrumbTrait {

	/**
     * BreadCrumb
     * 
     * @param String $modelName
     * @param String $roteName
     * @param String $formType
     * @return string
     */
    public static function breadCrumb(string $modelName, string $roteName, string $formType = null): string
    {
        $modelRoute = $formType === null ? $modelName : '<a href="' . route($roteName) . '"  class="">' . $modelName . '</a>';
        $breadCrumb = '<li class="breadcrumb-item" aria-current="page">' . $modelRoute . '</li>';
        if($formType !== null){
            $breadCrumb .= '<li class="breadcrumb-item active" aria-current="page">' . $formType . '</li>';
        }
        return $breadCrumb;
    }
}