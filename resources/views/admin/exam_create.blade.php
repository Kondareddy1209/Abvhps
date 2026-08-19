<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Exam Cycle | ABVHPS Central Board</title>
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
                <a href="{{ route('admin.exams.index') }}" class="text-xs font-black text-brandOrange hover:underline block mb-1">
                    ← Back to Exams Info Board
                </a>
                <h1 class="text-lg font-black text-gray-900 uppercase">Create New Exam Notice Cycle</h1>
            </div>
            <span class="text-2xl">📝</span>
        </div>

        <form action="{{ route('admin.exams.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Exam Title *</label>
                <input type="text" name="exam_title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="e.g. Sanathana Dharma Youth Examination - Cycle 2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Exam Type *</label>
                    <select name="exam_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        <option value="theory" {{ old('exam_type') === 'theory' ? 'selected' : '' }}>Theory</option>
                        <option value="mcq" {{ old('exam_type') === 'mcq' ? 'selected' : '' }}>MCQ</option>
                        <option value="both" {{ old('exam_type') === 'both' ? 'selected' : '' }}>Both (Theory + MCQ)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Exam Date & Time *</label>
                    <input type="datetime-local" name="exam_date_time" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Application Fee (₹) *</label>
                    <input type="number" step="0.01" name="application_fee" value="41.00" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                </div>
            </div>

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Exam Centers / Location *</label>
                <input type="text" name="exam_center_location" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="e.g. Porumamilla, Badvel, Kadapa Central">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Syllabus PDF File</label>
                    <input type="file" name="syllabus_pdf" accept="application/pdf" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                    <span class="text-[10px] text-gray-400">Upload PDF syllabus file (Max: 10MB)</span>
                </div>
                <div>
                    <label class="block font-black text-gray-700 uppercase mb-1">Banner Image (Optional)</label>
                    <input type="file" name="banner_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                    <span class="text-[10px] text-gray-400">Display banner image (Max: 4MB)</span>
                </div>
            </div>

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Prizes & Awards (One per line)</label>
                <textarea name="prize_details" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="1st Prize: Tablet + ₹5,000 Cash&#10;2nd Prize: LED TV + Certificate&#10;3rd Prize: Stainless Steel Dinner Set"></textarea>
            </div>

            <div>
                <label class="block font-black text-gray-700 uppercase mb-1">Status Loop *</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                    <option value="active">● Active (Open for Applications)</option>
                    <option value="upcoming">⏳ Upcoming (Announced)</option>
                    <option value="completed">✓ Completed (Archived)</option>
                </select>
            </div>

            <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.exams.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-black rounded-lg uppercase">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-brandOrange hover:bg-orange-700 text-white font-black rounded-lg shadow uppercase">
                    Deploy Exam Cycle
                </button>
            </div>
        </form>
    </div>

</body>
</html>
