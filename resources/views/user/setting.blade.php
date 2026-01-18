@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col col-lg-4 col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="profil"
                  class="profile-user-img img-responsive img-circle">
              @else
                <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil"
                  class="profile-user-img img-responsive img-circle">
              @endif
            </div>
            <form action="{{ route('user.uploadfoto') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <input type="file" name="foto" id="foto">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </div>
              </div>
            </form>
            <hr>
            <form action="{{ route('user.updateprofil') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
              </div>
              <div class="form-group">
                <label for="phone">No Tlp</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone }}">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection