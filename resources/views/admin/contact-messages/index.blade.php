@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Contact Messages</h1>
    <div class="flex items-center gap-2 text-sm text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <span>{{ $messages->count() }} messages</span>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
        <div class="flex">
            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
        <div class="flex">
            <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

@if($messages->isEmpty())
    <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="mt-4 text-xl text-gray-700 font-semibold">No Messages Found</h3>
        <p class="text-gray-600 mt-2">No contact messages have been received yet.</p>
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Date & Time</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Contact Info</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Message Preview</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold" width="120">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-900">{{ $message->created_at->format('d M Y') }}</span>
                                <span class="text-gray-500 text-xs">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col space-y-1">
                                <div class="font-semibold text-gray-900">{{ $message->name }}</div>
                                <div class="text-blue-600 hover:text-blue-800">
                                    <a href="mailto:{{ $message->email }}" class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $message->email }}
                                    </a>
                                </div>
                                @if($message->phone)
                                <div class="text-green-600">
                                    <a href="tel:{{ $message->phone }}" class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $message->phone }}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="max-w-xs">
                                <p class="text-gray-700 line-clamp-2 leading-relaxed">{{ Str::limit($message->message, 100) }}</p>
                                @if(strlen($message->message) > 100)
                                    <button onclick="openModal('viewModal{{ $message->id }}')" class="text-blue-600 hover:text-blue-800 text-xs mt-1 font-medium">
                                        Read more...
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2 flex items-center">
                            <button onclick="openModal('viewModal{{ $message->id }}')" class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition-colors" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button onclick="openModal('deleteModal{{ $message->id }}')" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition-colors" title="Delete Message">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>

                    <!-- View Modal -->
                    <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" id="viewModal{{ $message->id }}" role="dialog">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Message Details</h3>
                                    <button onclick="closeModal('viewModal{{ $message->id }}')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 py-6 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Date & Time</label>
                                        <p class="text-gray-900">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                                        <p class="text-gray-900">{{ $message->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                        <p class="text-blue-600">
                                            <a href="mailto:{{ $message->email }}" class="hover:text-blue-800">{{ $message->email }}</a>
                                        </p>
                                    </div>
                                    @if($message->phone)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                                        <p class="text-green-600">
                                            <a href="tel:{{ $message->phone }}" class="hover:text-green-800">{{ $message->phone }}</a>
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <p class="text-gray-900 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                                <a href="mailto:{{ $message->email }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                    Reply via Email
                                </a>
                                <button onclick="closeModal('viewModal{{ $message->id }}')" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" id="deleteModal{{ $message->id }}" role="dialog">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Delete Message</h3>
                                    <button onclick="closeModal('deleteModal{{ $message->id }}')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 py-6">
                                <div class="flex items-center mb-4">
                                    <svg class="w-12 h-12 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-gray-900 font-medium">Are you sure you want to delete this message?</p>
                                        <p class="text-gray-600 text-sm mt-1">From: <strong>{{ $message->name }}</strong></p>
                                        <p class="text-gray-500 text-xs mt-1">This action cannot be undone.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                                <button onclick="closeModal('deleteModal{{ $message->id }}')" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                                    Cancel
                                </button>
                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                        Delete Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
// Modal helper functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking on the overlay
document.addEventListener('click', function(event) {
    if (event.target.id && (event.target.id.startsWith('viewModal') || event.target.id.startsWith('deleteModal'))) {
        closeModal(event.target.id);
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                closeModal(modal.id);
            }
        });
    }
});
</script>
@endsection
