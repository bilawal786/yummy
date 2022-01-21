@extends('frontend.layouts.mobile')
@section('footer-js')
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}</script>
@endsection
@section('main-content')
<div class="page-content-wrapper">
      <div class="container">
        <!-- Profile Wrapper-->
        <div class="profile-wrapper-area py-3">
          <form action="{{ route('account.profile.update', $user) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
          <!-- User Information-->
          <div class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-profile me-3"><img src="{{ $user->images }}" id="previewImage"
                   src="{{ $user->images }}"
                   alt="{{ $user->name }} profile image">
                <div class="change-user-thumb">
                    <input name="image" type="file"
                           class="form-control-file @error('image') is-invalid @enderror"
                           id="customFile" onchange="readURL(this);">
                    <button><i class="lni lni-pencil"></i></button>
                </div>
              </div>
              <div class="user-info">
                <h5 class="mb-0">{{$user->first_name.' '.$user->last_name}}</h5>
              </div>
            </div>
          </div>
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-user"></i><span>Prénom</span></div>
                  <input type="text" name="first_name"
                         class="form-control @error('first_name') is-invalid @enderror"
                         value="{{ old('first_name', $user->first_name) }}">
                  @error('first_name')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-user"></i><span>Nom</span></div>
                  <input type="text" name="last_name"
                         class="form-control @error('last_name') is-invalid @enderror"
                         value="{{ old('last_name', $user->last_name) }}">
                  @error('last_name')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-phone"></i><span>Téléphone</span></div>
                  <input type="text" name="phone"
                         class="form-control @error('phone') is-invalid @enderror"
                         value="{{ old('phone', $user->phone) }}">
                  @error('phone')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-envelope"></i><span>Adresse E-mail</span></div>
                  <input readonly type="text" name="email"
                         class="form-control @error('email') is-invalid @enderror"
                         value="{{ old('email', $user->email) }}">
                  @error('email')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-envelope"></i><span>Région</span></div>
                    <select class="form-control" name="address" id="">
                        @foreach($location as $loc)
                        <option {{$user->address == $loc->id ? 'selected' : ''}} value="{{$loc->id}}">{{$loc->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success w-100" type="submit">Sauvegarder</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
