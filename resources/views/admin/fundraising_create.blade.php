<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy New Fundraising Campaign | ABVHPS Central Board</title>
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
                <h1 class="text-lg font-black text-gray-900 uppercase">Deploy New Fundraising Campaign</h1>
            </div>
            <span class="text-2xl">📢</span>
        </div>

        <form action="{{ route('admin.fundraising.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Campaign Title *</label>
                <input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="e.g. TEMPLE RENOVATION & VEDA PATHASHALA SEVA">
            </div>

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Campaign Purpose / Story *</label>
                <textarea name="description" rows="4" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Detailed purpose of this fundraising initiative, how funds will be deployed, and spiritual significance..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Target Amount (₹) *</label>
                    <input type="number" step="0.01" name="target_amount" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="e.g. 500000">
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Initial Raised Amount (₹)</label>
                    <input type="number" step="0.01" name="raised_amount" value="0.00" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Campaign End Date *</label>
                    <input type="date" name="end_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
            </div>

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Cover Image (Main Banner) *</label>
                <input type="file" name="cover_image" accept="image/*" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
            </div>

            <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.fundraising.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-black rounded-lg uppercase">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-brandOrange hover:bg-orange-700 text-white font-black rounded-lg shadow uppercase">
                    Deploy Campaign
                </button>
            </div>
        </form>
    </div>

</body>
</html>
