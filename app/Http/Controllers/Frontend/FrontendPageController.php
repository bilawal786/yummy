<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\Page;

class FrontendPageController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = setting('site_name');

    }

    public function index($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if (blank($page)) {
            abort(404);
        }
        $this->data['user'] = auth()->user();

        $this->data['page'] = $page;

        $this->data['namepage']  = $page->title;

        $pageName = 'default';

        $pageName = 'frontend.page.' . $pageName;

        return view($pageName, $this->data);
    }
}
