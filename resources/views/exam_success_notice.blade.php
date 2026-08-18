<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABVHPS - Exam Registration Success</title>
    <!-- Tailwind CSS Matrix Grid -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    <style>
        @media print {
            body * { visibility: hidden; }
            #digital_hall_ticket_card, #digital_hall_ticket_card * { visibility: visible; }
            #digital_hall_ticket_card { position: absolute; left: 0; top: 0; width: 100%; border: none; shadow: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-yellow-50 min-h-screen font-sans antialiased text-gray-900">

    <div class="max-w-2xl mx-auto py-10 px-4">
        
        <!-- Top Success Banner (No Print Channel) -->
        <div class="no-print bg-green-100 border-l-4 border-green-500 p-4 rounded-lg shadow-sm mb-6 text-center">
            <span class="text-3xl">🎉</span>
            <h1 class="text-xl font-bold text-green-800 mt-2">Application Secured & Verified!</h1>
            <p class="text-sm text-green-700 mt-1">Your 11-Digit Hall Ticket has been successfully generated and dispatched to your email register.</p>
        </div>

        <!-- STAGE 1: THE CENTRAL DIGITAL HALL TICKET CARD (PVC CARD LAYOUT) -->
        <div id="digital_hall_ticket_card" class="bg-white border-2 border-orange-500 rounded-xl shadow-2xl overflow-hidden bg-opacity-95 relative">
            <!-- Backdrop Watermark effect or header structure -->
            <div class="bg-orange-600 p-4 text-white text-center border-b-4 border-yellow-400">
                <h2 class="text-lg md:text-xl font-extrabold uppercase tracking-wider">AKHANDA BHARATA VISWA HINDU PARIRAKSHANA SAMITI</h2>
                <p class="text-xs text-yellow-200 uppercase tracking-widest mt-0.5">Sanathana Dharma Examination Hall Ticket</p>
            </div>

            <!-- Profile Matrix Core Grid -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                
                <!-- 100x100 Stamp View Photo Target Frame -->
                <div class="md:col-span-1 flex flex-col items-center justify-center">
                    @if($application->photo_path)
                        <img src="{{ asset('storage/' . $application->photo_path) }}" class="w-28 h-28 object-cover rounded-md border-2 border-gray-300 shadow-md bg-white" alt="Student Photo">
                    @else
                        <div class="w-28 h-28 bg-gray-200 rounded-md border-2 border-dashed border-gray-400 flex items-center justify-center text-gray-400 text-xs text-center p-2">No Photo Found</div>
                    @endif
                    <span class="text-xxs text-gray-400 font-bold uppercase mt-2 tracking-widest">Stamp View</span>
                </div>

                
                <div class="md:col-span-3 space-y-2">
                    <div>
                        <span class="text-xxs uppercase font-bold text-gray-400 tracking-wider">Hall Ticket Number</span>
                        <div class="text-2xl font-black text-orange-600 font-mono tracking-wider">{{ $application->hall_ticket_number }}</div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="text-xxs uppercase font-bold text-gray-400 block">Candidate Name</span>
                            <span class="font-bold text-gray-800">{{ $application->full_name }}</span>
                        </div>
                        <div>
                            <span class="text-xxs uppercase font-bold text-gray-400 block">Date of Birth</span>
                            <span class="font-semibold text-gray-700">{{ date('d-M-Y', strtotime($application->dob)) }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-sm pt-1 border-t border-gray-100">
                        <div>
                            <span class="text-xxs uppercase font-bold text-gray-400 block">Institution</span>
                            <span class="font-medium text-gray-700 truncate block">{{ $application->school_college_name }}</span>
                        </div>
                        <div>
                            <span class="text-xxs uppercase font-bold text-gray-400 block">Class & Sec</span>
                            <span class="font-semibold text-gray-700">{{ $application->class_section ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Center, Date & Verification Authority Footer Matrix -->
            <div class="bg-gray-50 p-4 border-t border-gray-200 text-xs md:text-sm font-semibold text-gray-700 grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>📍 <span class="text-gray-400 font-bold uppercase text-xxs block">Exam Center Location</span>
                    <span class="font-bold text-orange-950">{{ $examSettings->exam_center_location ?? 'Main Center, Porumamilla' }}</span>
                </div>
                <div class="md:text-right">📅 <span class="text-gray-400 font-bold uppercase text-xxs block">Exam Date & Time</span>
                    <span class="font-bold text-orange-950">{{ isset($examSettings->exam_date_time) ? date('d-M-Y h:i A', strtotime($examSettings->exam_date_time)) : '12-Oct-2026' }}</span>
                </div>
            </div>

            <!-- Mandatory Security Instructions Footer Desk -->
            <div class="bg-orange-50 p-3 text-center border-t border-orange-200 text-xxs text-orange-900 font-medium tracking-wide">
                Please bring this printed copy along with your School ID Card to the exam center.
            </div>
        </div>

        <!-- STAGE 2: ACTION BUTTONS PANEL (NO-PRINT MATRIX) -->
        <div class="no-print mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <!-- Print/Download Hall Ticket Trigger -->
            <button onclick="window.print()" class="bg-orange-600 hover:bg-orange-700 text-white font-extrabold px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-2">
                🖨️ Print / Download Hall Ticket
            </button>
            
            <!-- Syllabus Book PDF Download Anchor -->
            <a href="{{ route('exam.download_syllabus', ['id' => $application->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-2 text-center">
                📚 Download Exam Syllabus PDF
            </a>
        </div>

        <!-- Back to Home Return Desk -->
        <div class="no-print text-center mt-6">
            <a href="/" class="text-sm font-bold text-orange-600 hover:underline">← Return to ABVHPS Central Portal</a>
        </div>

    </div>

</body>
</html>
