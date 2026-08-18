<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fundraising Campaign | ABVHPS Central Board</title>
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

    <div class="max-w-3xl mx-auto bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-5 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.fundraising.index') }}" class="text-xs font-black text-brandOrange hover:underline block mb-1">
                    ← Back to Fundraising Matrices
                </a>
                <h1 class="text-lg font-black text-gray-900 uppercase">Edit Campaign #{{ $campaign->id }}</h1>
            </div>
            <span class="text-2xl">✏️</span>
        </div>

        <form action="{{ route('admin.fundraising.update', $campaign->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Campaign Title *</label>
                <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
            </div>

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Campaign Purpose / Story *</label>
                <textarea name="description" rows="4" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">{{ old('description', $campaign->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Target Amount (₹) *</label>
                    <input type="number" step="0.01" name="target_amount" value="{{ old('target_amount', $campaign->target_amount) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Amount Raised (₹) *</label>
                    <input type="number" step="0.01" name="raised_amount" value="{{ old('raised_amount', $campaign->raised_amount) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">End Date *</label>
                    <input type="date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($campaign->end_date)->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Update Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Status *</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        <option value="active" {{ $campaign->status === 'active' ? 'selected' : '' }}>● Active</option>
                        <option value="expired" {{ $campaign->status === 'expired' ? 'selected' : '' }}>✓ Expired</option>
                    </select>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.fundraising.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-black rounded-lg uppercase">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-brandOrange hover:bg-orange-700 text-white font-black rounded-lg shadow uppercase">
                    Update Campaign
                </button>
            </div>
        </form>
    </div>

</body>
</html>
