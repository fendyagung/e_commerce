@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Slideshow Manager</h3>
                        <div class="card-tools">
                            <a href="{{ route('slideshow.create') }}" class="btn btn-sm btn-primary">
                                Tambah Slideshow
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-warning">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50px">No</th>
                                        <th>Gambar</th>
                                        <th>Caption Title</th>
                                        <th>Caption Content</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($itemslideshow as $slideshow)
                                        <tr>
                                            <td>{{ ($itemslideshow->currentPage() - 1) * $itemslideshow->perPage() + $loop->iteration }}
                                            </td>
                                            <td>
                                                @if($slideshow->foto)
                                                    <img src="{{ \Storage::url($slideshow->foto) }}" alt="slideshow" width="150px"
                                                        class="img-thumbnail">
                                                @else
                                                    <span class="badge badge-secondary">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $slideshow->caption_title }}</td>
                                            <td>{{ Str::limit($slideshow->caption_content, 50) }}</td>
                                            <td>
                                                <a href="{{ route('slideshow.edit', $slideshow->id) }}"
                                                    class="btn btn-sm btn-primary mr-2">
                                                    Edit
                                                </a>
                                                <form action="{{ route('slideshow.destroy', $slideshow->id) }}" method="post"
                                                    style="display:inline;">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus slideshow ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data Slideshow Belum Ada</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $itemslideshow->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection