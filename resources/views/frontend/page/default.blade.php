@extends('frontend.layouts.mobile')
@section('main-content')
<div class="page-content-wrapper py-3">
      <div class="container">
        <div class="card">
          <div class="card-body">
            {!! $page->description !!}
          </div>
        </div>
      </div>
    </div>
@endsection
