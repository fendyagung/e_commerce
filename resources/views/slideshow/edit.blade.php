@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('slideshow.index') }}" class="btn btn-sm btn-danger">
                                Tutup
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-warning">{{ $error }}</div>
                            @endforeach
                        @endif

                        @if ($message = Session::get('error'))
                            <div class="alert alert-warning">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <form action="{{ route('slideshow.update', $itemslideshow->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label for="image">Gambar Slideshow</label>
                                <input type="file" name="image" id="image" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                @if($itemslideshow->foto)
                                    <div class="mt-2">
                                        <img src="{{ \Storage::url($itemslideshow->foto) }}" width="150px" class="img-thumbnail"
                                            alt="Current Image">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="caption_title">Caption Title</label>
                                <input type="text" name="caption_title" id="caption_title" class="form-control"
                                    value="{{ old('caption_title', $itemslideshow->caption_title) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="caption_content">Caption Content</label>
                                <textarea name="caption_content" id="caption_content" cols="30" rows="3"
                                    class="form-control">{{ old('caption_content', $itemslideshow->caption_content) }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection