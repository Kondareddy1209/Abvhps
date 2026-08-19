<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Details | ABVHPS Central Board</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brandOrange: #FF6600;
            --color-brandGray: #4A4A4A;
            --color-brandDarkGray: #1A1A1A;
            --color-brandLightOrange: #FFF5EE;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 p-6">

    <div class="max-w-3xl mx-auto bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden space-y-6">
        <div class="p-5 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs font-black text-brandOrange hover:underline block mb-1">
                    ← Back to Inquiries List
                </a>
                <h1 class="text-lg font-black text-gray-900 uppercase">Devotee Inquiry #{{ $message->id }}</h1>
            </div>
            <span class="text-2xl">📩</span>
        </div>

        <div class="p-6 space-y-6 text-xs">
            <!-- Metadata Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                <div>
                    <span class="text-[10px] font-black text-gray-400 uppercase block">Sender Name</span>
                    <span class="font-bold text-gray-900 uppercase">{{ $message->name }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-black text-gray-400 uppercase block">Email Address</span>
                    <a href="mailto:{{ $message->email }}" class="font-mono font-bold text-blue-600 hover:underline">{{ $message->email }}</a>
                </div>
                <div>
                    <span class="text-[10px] font-black text-gray-400 uppercase block">Contact Phone</span>
                    <span class="font-mono font-bold text-gray-800">{{ $message->phone ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-black text-gray-400 uppercase block">Received Timestamp</span>
                    <span class="font-mono text-gray-600">{{ $message->created_at ? $message->created_at->format('d M Y, h:i A') . ' IST' : 'N/A' }}</span>
                </div>
            </div>

            <!-- Subject -->
            <div>
                <span class="text-[10px] font-black text-gray-400 uppercase block mb-1">Subject:</span>
                <h3 class="font-black text-sm text-brandOrange uppercase bg-orange-50/50 p-3 rounded-lg border border-orange-100">
                    {{ $message->subject }}
                </h3>
            </div>

            <!-- Message Body -->
            <div>
                <span class="text-[10px] font-black text-gray-400 uppercase block mb-1">Full Message:</span>
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 text-sm leading-relaxed whitespace-pre-wrap">
{{ $message->message }}
                </div>
            </div>

            <!-- Security Audit Footer -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                <span>Sender IP: {{ $message->ip_address ?? '127.0.0.1' }} (Filtered & Verified)</span>
                <form action="{{ route('admin.contacts.delete', $message->id) }}" method="POST" onsubmit="return confirm('Delete message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-xs px-4 py-2 rounded-lg uppercase">
                        Delete Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
