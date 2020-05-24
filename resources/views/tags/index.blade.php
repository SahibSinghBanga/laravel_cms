@extends('layouts.app') @section('content')

<!-- <div class="d-flex justify-content-end mb-2">
    <a href="{{ route('tags.create') }}" class="btn btn-success">Add tag</a>
</div> -->

<div class="card card-default">
    <div class="card-header">
        <strong>Tags</strong>
        <a
            href="{{ route('tags.create') }}"
            class="btn btn-success btn-sm float-right"
            ><strong>Add tag</strong></a
        >
    </div>

    <div class="card-body">
        @if($tags->count() > 0)

        <table class="table">
            <thead>
                <th>Name</th>
                <th>Posts Count</th>
                <th>Action</th>
            </thead>

            <tbody>
                @foreach($tags as $tag)
                <tr>
                    <td>
                        {{ $tag->name }}
                    </td>
                    <td>
                        {{ $tag->posts->count() }}
                    </td>
                    <td>
                        <a
                            href="{{ route('tags.edit', $tag->id) }}"
                            class="btn btn-info btn-sm text-white"
                        >
                            Edit
                        </a>
                        <button
                            class="btn btn-danger btn-sm"
                            onclick="handleDelete({{ $tag->id }})"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div
            class="modal fade"
            id="deleteModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="deleteModallLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <form action="" method="POST" id="deletetagForm">
                    @csrf @method('DELETE')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal">
                                Delete tag
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center text-bold">
                                Are you sure want to delete this tag ?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                No, Go Back
                            </button>
                            <button type="submit" class="btn btn-danger">
                                Yes, Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <h3 class="text-center">No Tags Yet</h3>
    @endif
</div>

@endsection @section('scripts')

<script>
    function handleDelete(id) {
        var form = document.getElementById("deletetagForm");
        form.action = "/tags/" + id;
        $("#deleteModal").modal("show");
    }
</script>

@endsection
