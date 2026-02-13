@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Contact Messages</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($messages->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                <p class="mt-3">No messages yet</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->phone }}</td>
                            <td>
                                <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $message->message }}
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $message->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $message->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $message->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Message Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Date:</strong> {{ $message->created_at->format('d M Y H:i') }}</p>
                                        <p><strong>Name:</strong> {{ $message->name }}</p>
                                        <p><strong>Email:</strong> {{ $message->email }}</p>
                                        <p><strong>Phone:</strong> {{ $message->phone }}</p>
                                        <p><strong>Message:</strong></p>
                                        <p class="border p-3 rounded bg-light">{{ $message->message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $message->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Message</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this message from <strong>{{ $message->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
