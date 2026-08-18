@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 select-none">
    
    <!-- CENTRAL ADMINISTRATIVE ID CARD WORKSPACE PANEL -->
    <div id="pvc_print_workspace_panel" class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden no-print">
        
        <!-- Header Corporate Badge -->
        <div class="text-center bg-brandDarkGray text-white p-6 border-b-4 border-brandOrange">
            <span class="text-4xl block mb-1 drop-shadow">💳</span>
            <h1 class="text-xl md:text-2xl font-black tracking-wider uppercase text-brandOrange">ABVHPS PVC IDENTITY CARD DESK</h1>
            <p class="text-gray-300 mt-1 font-medium text-xs tracking-wide">Official Central Printing and Anti-Fraud Verification Terminal</p>
        </div>

        <div class="p-6 md:p-8 space-y-8">
            
            <!-- SECTION 1: MEMBERSHIP MATRIX SEARCH GATEWAY -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 space-y-4">
                <div class="border-b border-gray-200 pb-1">
                    <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Section 1: Locate Active Roster Member</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Enter 12-Digit Membership ID *</label>
                        <input type="text" id="target_pvc_membership_id" maxlength="12" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 font-mono text-base tracking-widest focus:ring-2 focus:ring-brandOrange outline-none bg-white shadow-inner" placeholder="915XXXXXXXXX">
                    </div>
                    <div>
                        <button type="button" id="btn_trigger_pvc_compile" onclick="triggerPvcPayloadCompilation()" class="w-full bg-brandOrange hover:bg-opacity-95 text-white font-black py-3 px-4 rounded-lg text-xs transition shadow-sm uppercase tracking-wider h-[46px] cursor-pointer">
                            Compile ID Card
                        </button>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DYNAMIC IDENTITY BADGE PREVIEW GRID VIEWPORTS -->
            <div id="pvc_cards_master_render_zone" class="hidden space-y-6 animate-fadeIn">
                <div class="border-b border-gray-200 pb-1">
                    <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Section 2: Digital PVC Card Preview (CR80 Dimension Standard)</h3>
                </div>
                <!-- THE INTERACTIVE CARD DECK FLEX MATRIX FOR LIVE PREVIEW -->
                <div class="flex flex-col lg:flex-row justify-center items-center gap-8 py-4 bg-gray-50/50 border border-gray-100 rounded-xl">
                    
                    <!-- A. THE IDENTITY FRONT BADGE DECK LAYER -->
                    <div class="pvc-card-container relative overflow-hidden bg-white rounded-[12px] shadow-md border border-gray-200 select-none pointer-events-none" id="pvc_front_printable_node">
                        <div class="p-3 h-full flex flex-col justify-between relative z-10">
                            <!-- Header branding -->
                            <div class="text-center border-b border-orange-500/20 pb-1 flex items-center justify-center gap-1.5">
                                <span class="text-xl">🔱</span>
                                <div class="text-left">
                                    <h2 class="text-[8px] font-black tracking-tighter text-gray-800 leading-none">AKHANDA BHARATHA VISWA HINDU</h2>
                                    <h2 class="text-[8px] font-black tracking-tighter text-gray-800 leading-none mt-0.5">PARIRAKSHANA SAMITI</h2>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-12 gap-2 items-center my-auto">
                                <div class="col-span-4 text-center">
                                    <img id="pvc_front_display_photo" src="https://placeholder.com" class="w-[65px] h-[75px] object-cover rounded-md border-2 border-brandOrange shadow-sm mx-auto">
                                </div>
                                <div class="col-span-5 text-left text-[9px] font-bold text-gray-700 space-y-0.5 leading-tight">
                                    <div>Name: <span id="pvc_front_display_name" class="font-black text-gray-900 uppercase">NAME</span></div>
                                    <div>ID: <span id="pvc_front_display_id" class="font-mono font-black text-brandOrange tracking-wide">915XXXXXXXXX</span></div>
                                    <div>Blood: <span id="pvc_front_display_blood" class="font-black text-red-600">O+</span></div>
                                    <div>Mobile: <span id="pvc_front_display_mobile" class="font-black text-gray-900">XXXX</span></div>
                                </div>
                                <!-- Anti-Fraud Dynamic QR Injection Matrix -->
                                <div class="col-span-3 flex justify-center items-center">
                                    <div id="pvc_front_display_qr_box" class="p-1 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center w-[54px] h-[54px]">
                                        <!-- QR graphics gets compiled dynamically via library scripts inside Part 3 -->
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center bg-brandDarkGray text-white py-1 rounded border-t-2 border-brandOrange">
                                <span id="pvc_front_display_wing_badge" class="text-[8px] font-black tracking-widest uppercase text-brandOrange block">GENERAL MEMBER</span>
                            </div>
                        </div>
                        <!-- Watermark background texture vector -->
                        <div class="absolute inset-0 flex items-center justify-center text-gray-100/30 text-7xl font-black select-none pointer-events-none z-0">🔱</div>
                    </div>

                    <!-- B. THE IDENTITY BACK BADGE DECK LAYER -->
                    <div class="pvc-card-container relative overflow-hidden bg-white rounded-[12px] shadow-md border border-gray-200 select-none pointer-events-none" id="pvc_back_printable_node">
                        <div class="p-3 h-full flex flex-col justify-between relative z-10 text-[7px] text-gray-600 font-semibold leading-normal">
                            <!-- Terms & Instructions List -->
                            <div class="space-y-1 border-b border-gray-100 pb-1.5">
                                <h4 class="font-black text-gray-800 text-[8px] uppercase tracking-wide">Instructions & Rules:</h4>
                                <p>1. This card is official property of ABVHPS and is non-transferable.</p>
                                <p>2. Fraudulent fabrication or illegal duplication is strictly prohibited under central penal codes.</p>
                                <p>3. Scan the frontend dynamic QR code anytime to verify absolute active identity credentials instantly.</p>
                            </div>
                            <!-- Corporate Office Bounds Registry Meta Data -->
                            <div class="grid grid-cols-12 gap-1 items-center pt-1.5">
                                <div class="col-span-4 flex justify-center">
                                    <!-- Official Red Stamp Verification Seal Graphic -->
                                    <div class="w-12 h-12 border-2 border-dashed border-red-600 rounded-full flex flex-col items-center justify-center transform -rotate-12 p-0.5 bg-white shadow-inner">
                                        <span class="text-[3px] font-black text-red-600 uppercase tracking-tighter">ABVHPS HQ</span>
                                        <span class="text-[5px] font-black text-red-600 uppercase border-y border-red-600/60 my-0.5 px-0.5">VERIFIED</span>
                                        <span class="text-[3px] font-bold text-red-600 uppercase tracking-tighter">OFFICIAL SEAL</span>
                                    </div>
                                </div>
                                <div class="col-span-8 text-right space-y-0.5">
                                    <p class="font-black text-gray-800 uppercase text-[6px]">Central Executive Office Board</p>
                                    <p>Email: admin@abvhps.org | Portal: abvhps.org</p>
                                    <div class="pt-1 select-none pointer-events-none">
                                        <div class="font-serif italic font-black text-gray-800 text-[8px] border-b border-gray-300 pb-0.5 inline-block pr-2">Swami Ji Signature</div>
                                        <span class="text-[5px] font-black text-gray-400 block uppercase tracking-wider">Authorized Signatory</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center text-gray-50/40 text-7xl font-black select-none pointer-events-none z-0">🔱</div>
                    </div>

                </div>

                <!-- Instant Layout Print Control Trigger Desk -->
                <div class="text-center pt-2">
                    <button type="button" onclick="executePvcCardPrintTrigger()" class="bg-brandDarkGray hover:bg-opacity-95 text-white font-black text-sm py-3 px-12 rounded-lg shadow uppercase tracking-wider w-full sm:w-auto cursor-pointer transition">
                        Print Identity Card (CR80 Standard)
                    </button>
                </div>
            </div> <!-- END CARDS MASTER RENDER ZONE -->

        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- ⚙️ MASTER HIGH-PRECISION PVC CR80 PRINTING MEDIA QUERY STYLING ENGINE -->
<!-- ====================================================================== -->
<style>
    /* CR80 Precision Aspect Dimensions Ratio Vector Bounds Configuration */
    .pvc-card-container {
        width: 323.5px;   /* Mapped proportional proxy values for 85.6mm */
        height: 204px;    /* Mapped proportional proxy values for 54mm */
        background-image: linear-gradient(135deg, #fff 70%, #fff7ed 100%);
    }

    /* CR80 Absolute High-Utility Print Mode Layout Override Profiles */
    @media print {
        body * {
            visibility: hidden !important;
        }
        .no-print {
            display: none !important;
            visibility: hidden !important;
        }
        #pvc_front_printable_node, #pvc_front_printable_node *,
        #pvc_back_printable_node, #pvc_back_printable_node * {
            visibility: visible !important;
        }
        /* Lock physical layout parameters strictly onto printer hardware profiles */
        @page {
            size: 86mm 54mm;
            margin: 0 !important;
        }
        html, body {
            width: 85.6mm;
            height: 54mm;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        #pvc_front_printable_node {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 85.6mm !important;
            height: 54mm !important;
            page-break-after: always !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        #pvc_back_printable_node {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 85.6mm !important;
            height: 54mm !important;
            page-break-before: always !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
    }
</style>
<!-- ====================================================================== -->
<!-- ⚙️ CORE PVC IDENTITY ENGINE JAVASCRIPT PIPELINES & QR LIBRARIES -->
<!-- ====================================================================== -->
<!-- Pure Client-Side JavaScript QR Code Generator Library Node (Self-Contained) -->
<script src="https://cloudflare.com" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    const ajaxHeaders = {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    // Keep global tracker for client-side compiled qr object to clean memory references on re-triggers
    let activeClientSideQrInstance = null;

    /**
     * SECURE AJAX PIPELINE TO EXTRACT CORE ACTIVE ROSTER MEMBER DETAILS
     */
    async function triggerPvcPayloadCompilation() {
        const inputField = document.getElementById('target_pvc_membership_id');
        const compileBtn = document.getElementById('btn_trigger_pvc_compile');
        const renderZone = document.getElementById('pvc_cards_master_render_zone');
        const targetId = inputField.value;

        if (!targetId || targetId.length !== 12) {
            alert('Validation Refused: Please enter a valid 12-digit core membership ID.');
            return;
        }

        compileBtn.disabled = true;
        compileBtn.innerText = "Compiling Badge Assets...";

        try {
            let response = await fetch("{{ route('admin.idcards.generate') }}", {
                method: 'POST',
                headers: ajaxHeaders,
                body: JSON.stringify({ membership_id: targetId })
            });
            let result = await response.json();
            compileBtn.disabled = false;
            compileBtn.innerText = "Compile ID Card";

            if (result.success) {
                // Smoothly map received payload vectors inside the front card DOM nodes
                document.getElementById('pvc_front_display_photo').src = result.payload.photo_url;
                document.getElementById('pvc_front_display_name').innerText = result.payload.full_name;
                document.getElementById('pvc_front_display_id').innerText = result.payload.membership_id;
                document.getElementById('pvc_front_display_blood').innerText = result.payload.blood_group;
                document.getElementById('pvc_front_display_mobile').innerText = result.payload.mobile;
                document.getElementById('pvc_front_display_wing_badge').innerText = result.payload.wing_badge;

                // --- DYNAMIC ANTI-FRAUD SECURE QR GENERATOR ENGINE ---
                const qrBox = document.getElementById('pvc_front_display_qr_box');
                qrBox.innerHTML = ''; // Fresh initialization layer clean up

                // Inject secure encryption routing path directly inside client block memory
                activeClientSideQrInstance = new QRCode(qrBox, {
                    text: result.payload.qr_data_string,
                    width: 50,
                    height: 50,
                    colorDark: "#111827",
                    colorLight: "#FFFFFF",
                    correctLevel: QRCode.CorrectLevel.M // Medium resilient block tolerance bits configuration
                });

                // Unroll cards display desk workspace smoothly
                renderZone.classList.remove('hidden');
                window.scrollTo({ top: renderZone.offsetTop - 40, behavior: 'smooth' });

            } else {
                alert('System Alert: ' + result.message);
                renderZone.classList.add('hidden');
            }
        } catch (error) {
            compileBtn.disabled = false;
            compileBtn.innerText = "Compile ID Card";
            alert('Central administrative routing matrix network connection error.');
        }
    }

    /**
     * HIGH-PRECISION CR80 PRINTING COMMAND DISPATCH ACTION
     */
    function executePvcCardPrintTrigger() {
        // Enforces strict delay validation bounds checking layer
        if (!document.getElementById('pvc_front_display_id').innerText || document.getElementById('pvc_front_display_id').innerText.includes('X')) {
            alert('Operation Aborted: No valid compiled member credentials active in viewport.');
            return;
        }
        
        // Dispatches native layout signals directly to physical print hardware configurations
        window.print();
    }
</script>
@endsection
