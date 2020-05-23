@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header"><strong>Posts</strong>
        <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm float-right"><strong>Add Post</strong></a>
    </div>

    <div class="card-body">
        @if($posts->count() > 0)
        <table class="table">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th></th>
                <th></th>
            </thead>

            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td><img src="/storage/{{ $post->image }}" width="120px" height="60px" alt=""></td>
                    <td>{{ $post->title }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $post->category->id) }}">
                            {{ $post->category->name }}
                        </a>
                    </td>
                    <td>
                        @if($post->trashed())
                            <form action="{{ route('restore-posts', $post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-info btn-sm">Restore</button>
                            </form>
                        @else
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                {{ $post->trashed() ? 'Delete' : 'Trash' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <h3 class="text-center">No Posts Yet</h3>
        @endif
    </div>


</div>

@endsection
