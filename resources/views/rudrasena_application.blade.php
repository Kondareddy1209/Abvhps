@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    
    <!-- Central Rudrasena Dal Header Badge Component -->
    <div class="text-center bg-brandDarkGray text-white p-6 rounded-t-xl shadow-md border-b-4 border-brandOrange">
        <span class="text-4xl block mb-1 drop-shadow">🔱</span>
        <h1 class="text-xl md:text-3xl font-black tracking-wider uppercase text-brandOrange">RUDRASENA DAL ADVANCED REGISTRATION WING</h1>
        <p class="text-gray-300 mt-1 font-medium text-xs md:text-sm tracking-wide">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</p>
    </div>

    <!-- Central Lookup Desk Workspace -->
    <div class="bg-white p-6 md:p-8 rounded-b-xl shadow-lg border-x border-b border-gray-200">
        
        <!-- STAGE 1: GATEWAY SECURITY FOR MEMBERSHIP STATUS CLEARENCE -->
        <div id="membership_gate_section" class="bg-orange-50/50 p-6 rounded-lg border-2 border-dashed border-brandOrange/40 mb-6">
            <h2 class="text-base font-black text-brandGray mb-1 uppercase tracking-wide flex items-center gap-1.5 text-brandOrange">
                <span>🛡️</span> Step 1: Core Membership Validation Gate
            </h2>
            <p class="text-xs text-gray-600 mb-4 font-medium">Only registered members of ABVHPS are eligible to request allocation into the Rudrasena Wing.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Enter 12-Digit Membership ID *</label>
                    <input type="text" id="lookup_membership_id" maxlength="12" class="w-full border border-gray-300 rounded px-3 py-2 font-mono text-base tracking-widest focus:ring-2 focus:ring-brandOrange outline-none shadow-inner" placeholder="915XXXXXXXXX">
                </div>
                <div>
                    <button type="button" id="btn_verify_member" onclick="triggerMembershipLookup()" class="w-full bg-brandOrange hover:bg-opacity-90 text-white font-black py-2 px-4 rounded text-xs transition shadow-sm uppercase tracking-wider h-[42px] cursor-pointer">
                        Verify Membership
                    </button>
                </div>
            </div>
            <div id="gate_response_msg" class="text-xs font-bold mt-3 hidden"></div>
        </div>

        <!-- MAIN ADVANCED REGISTRATION FORM MATRIX (HIDDEN BY DEFAULT UNTIL CLEARANCE) -->
        <form id="rudrasena_registration_form" onsubmit="executeRudrasenaSubmission(event)" enctype="multipart/form-data" class="hidden space-y-6 animate-fadeIn">
            @csrf
            <!-- Auto-Bound Hidden Input Parameters -->
            <input type="hidden" name="membership_id" id="bound_membership_id">
            <input type="hidden" name="dob" id="bound_dob">
            <input type="hidden" name="age" id="bound_age">

            <!-- SECTION A: PRIMARY PROFILE ATTRIBUTES -->
            <div class="border-b border-gray-200 pb-1">
                <h3 class="text-sm font-black text-brandGray uppercase tracking-wide">Section A: Identity Profile</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="full_name" id="display_full_name" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-700 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Active WhatsApp Mobile</label>
                    <input type="text" name="mobile" id="display_mobile" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-700 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email Address *</label>
                    <input type="email" name="email" id="display_email" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 outline-none focus:ring-2 focus:ring-brandOrange">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Blood Group</label>
                        <input type="text" name="blood_group" id="display_blood" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-700 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Gotram</label>
                        <input type="text" name="gotram" id="display_gotram" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-700 outline-none">
                    </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Volunteer Type *</label>
                    <select name="volunteer_type" id="volunteer_type" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 outline-none focus:ring-2 focus:ring-brandOrange bg-white">
                        <option value="">-- Select Volunteer Type --</option>
                        <option value="Full-Time Volunteer">Full-Time Volunteer (Dedicated Seva & Relief)</option>
                        <option value="Part-Time Volunteer">Part-Time Volunteer (Weekend / Flexible Hours)</option>
                        <option value="Emergency Response">Emergency Response (Disaster & Calamity Support)</option>
                        <option value="Event-Based Volunteer">Event-Based Volunteer (Festivals & Programs)</option>
                    </select>
                </div>
            </div>

            <!-- SECTION B: SECURED BANK DETAILS VERIFICATION (INTERNAL REPOSITORY) -->
            <div class="border-b border-gray-200 pb-1 pt-2">
                <h3 class="text-sm font-black text-brandGray uppercase tracking-wide">Section B: Bank Account Verification</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Account Holder Name *</label>
                    <input type="text" name="bank_holder_name" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="As printed in Bank Passbook">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Account Number *</label>
                    <input type="text" name="bank_account_number" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Enter Account Number">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Bank IFSC Code *</label>
                    <input type="text" name="bank_ifsc_code" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none uppercase" placeholder="SBIN00XXXXX">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Bank Name & Branch *</label>
                    <input type="text" name="bank_name_branch" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="E.g. SBI, Porumamilla Branch">
                </div>
            </div>
            <!-- SECTION C: STRICT NOMINEE DATASET (INSURANCE DESTINATION TARGET) -->
            <div class="border-b border-gray-200 pb-1 pt-2">
                <h3 class="text-sm font-black text-brandGray uppercase tracking-wide">Section C: Insurance Nominee Details</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nominee Full Name *</label>
                    <input type="text" name="nominee_name" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Nominee Name">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Relationship to Member *</label>
                    <input type="text" name="nominee_relation" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="E.g. Mother, Wife, Father">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nominee Age *</label>
                    <input type="number" name="nominee_age" required min="1" max="120" class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Age">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nominee Contact Number *</label>
                    <input type="text" name="nominee_contact" required class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Mobile Number">
                </div>
            </div>

            <!-- SECTION D: DYNAMIC FAMILY REPEATER ROWS ENGINE (UP TO 6 MEMBERS) -->
            <div class="border-b border-gray-200 pb-1 pt-2 flex justify-between items-center">
                <h3 class="text-sm font-black text-brandGray uppercase tracking-wide">Section D: Family Unit Structural Tree</h3>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-black text-brandOrange uppercase">Total Members Count:</label>
                    <select id="family_members_count" onchange="renderDynamicFamilyRows(this.value)" class="border border-brandOrange bg-orange-50 font-bold rounded px-2 py-1 text-xs text-brandGray focus:ring-2 focus:ring-brandOrange outline-none">
                        <option value="0">None / 0</option>
                        <option value="1">1 Member</option>
                        <option value="2">2 Members</option>
                        <option value="3">3 Members</option>
                        <option value="4">4 Members</option>
                        <option value="5">5 Members</option>
                        <option value="6">6 Members</option>
                    </select>
                </div>
            </div>
            
            <!-- Dynamic Injection Terminal Node for Family Matrix Rows -->
            <div id="dynamic_family_rows_container" class="space-y-3"></div>

            <!-- SECTION E: COMPREHENSIVE 4 MANDATORY LEGAL DOCUMENT UPLOADS -->
            <div class="border-b border-gray-200 pb-1 pt-2">
                <h3 class="text-sm font-black text-brandGray uppercase tracking-wide">Section E: Verified Document Packets Upload</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-xs font-black text-brandGray uppercase mb-1">1. Health Declaration (Doctor Form) *</label>
                    <input type="file" name="document_health_declaration" required class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                    <span class="text-[10px] text-gray-500 font-semibold mt-0.5 block">Upload certified physical fitness sheet signed by a medical doctor.</span>
                </div>
                <div class="bg-gray-50 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-xs font-black text-brandGray uppercase mb-1">2. Family Declaration Sheet *</label>
                    <input type="file" name="document_family_declaration" required class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                    <span class="text-[10px] text-gray-500 font-semibold mt-0.5 block">Upload family consent copy with 2 witness signatures attached.</span>
                </div>
                <div class="bg-gray-50 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-xs font-black text-brandGray uppercase mb-1">3. Government ID Proof Copy *</label>
                    <input type="file" name="document_id_proof" required class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                    <span class="text-[10px] text-gray-500 font-semibold mt-0.5 block">Upload clear image copy of Aadhaar Card or Voter ID Card.</span>
                </div>
                <div class="bg-gray-50 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-xs font-black text-brandGray uppercase mb-1">4. Bank Account Passbook Copy *</label>
                    <input type="file" name="document_bank_proof" required class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                    <span class="text-[10px] text-gray-500 font-semibold mt-0.5 block">Upload Passbook front-page copy or Cancelled Check image.</span>
                </div>
            </div>

            <!-- --- THE MASTER CRITICAL LEGAL CONSENT DASHBOARD --- -->
            <div class="bg-gray-50 p-5 rounded-lg border-2 border-brandOrange/30 space-y-4">
                
                <!-- SECTION 1: OFFICIAL LEGAL DISCLAIMER (FIRST POSITION) -->
                <div class="space-y-1">
                    <h3 class="text-xs font-black uppercase text-red-600 tracking-wider flex items-center gap-1">
                        ⚠️ 1. Official Legal Disclaimer
                    </h3>
                    <p class="text-xs text-gray-700 leading-relaxed font-medium bg-white p-3 rounded border border-gray-200 shadow-inner">
                        The registered members of ABVHPS joining the Rudrasena Wing will be deployed solely for voluntary emergency support and relief operations during accidents or natural calamities. The organization does not enforce mandatory deployment; participation is completely voluntary and based on the absolute consent of the member. ABVHPS shall not be held legally responsible for any incidents or casualties during operations. However, on humanitarian grounds, the organization will facilitate the alignment of the designated ₹25 Lakh accident insurance for the family. No compensation shall be granted if a member expires due to personal reasons or health illnesses.
                    </p>
                </div>

                <!-- SECTION 2: OFFICIAL TERMS & CONDITIONS (SECOND POSITION - 2 POINTS) -->
                <div class="space-y-2">
                    <h3 class="text-xs font-black uppercase text-brandGray tracking-wider flex items-center gap-1">
                        📋 2. Terms & Conditions
                    </h3>
                    <div class="text-xs text-gray-700 space-y-2 font-medium">
                        <div class="bg-orange-50/40 p-2.5 rounded border border-orange-100 flex gap-2">
                            <span class="text-brandOrange font-bold">•</span>
                            <span>I am enrolling in the Rudrasena Dal with my absolute willingness and personal consent without any external force or pressure. I have obtained formal clearance and permission from my family members for this decision.</span>
                        </div>
                        <div class="bg-orange-50/40 p-2.5 rounded border border-orange-100 flex gap-2">
                            <span class="text-brandOrange font-bold">•</span>
                            <span>Under any circumstances or operational eventualities, neither I nor my family members shall hold ABVHPS or its management liable or responsible. I am affirming this statement with complete awareness and sound mind.</span>
                        </div>
                    </div>
                </div>

                <!-- Central Verification Checkbox Anchor -->
                <div class="pt-2 border-t border-gray-200">
                    <label class="inline-flex items-start cursor-pointer select-none">
                        <input type="checkbox" name="disclaimer_accepted" value="1" required class="form-checkbox text-brandOrange focus:ring-brandOrange h-4 w-4 rounded border-gray-300 mt-0.5">
                        <span class="ml-2.5 text-xs font-bold text-gray-900 leading-tight">
                            I have thoroughly read, understood, and hereby accept all the official disclaimer directives and terms and conditions specified above. *
                        </span>
                    </label>
                </div>
            </div>

            <!-- Core Submission Terminal Dispatch Anchor -->
            <div class="text-center pt-2">
                <button type="submit" id="btn_rudrasena_submit" class="bg-brandOrange hover:bg-opacity-90 text-white font-black text-sm py-3 px-10 rounded-lg shadow transition transform hover:scale-102 uppercase tracking-wider w-full sm:w-auto cursor-pointer">
                    Submit Rudrasena Application
                </button>
            </div>
        </form>
    </div>
</div>
<!-- CORE ADVANCED JAVASCRIPT PIPELINES MATRIX -->
<script>
    const ajaxHeaders = {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    /**
     * DYNAMIC FAMILY ROWS REPEATER GENERATOR ENGINE (UP TO 6 NODES)
     */
    function renderDynamicFamilyRows(count) {
        const container = document.getElementById('dynamic_family_rows_container');
        container.innerHTML = ''; // Flush old generated elements
        
        const rowCount = parseInt(count);
        if (rowCount === 0) return;

        // Generate clean multi-column structural rows using array bindings
        for (let i = 0; i < rowCount; i++) {
            const rowHtml = `
                <div class="bg-gray-50/70 p-4 rounded border border-gray-200 grid grid-cols-1 md:grid-cols-12 gap-3 items-center animate-fadeIn">
                    <div class="md:col-span-1 text-center"><span class="bg-brandOrange text-white text-xs font-black px-2 py-0.5 rounded-full shadow-sm">${i + 1}</span></div>
                    <div class="md:col-span-4">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Member Full Name *</label>
                        <input type="text" name="family[${i}][name]" required class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-semibold text-gray-800 focus:ring-1 focus:ring-brandOrange outline-none">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Relationship *</label>
                        <input type="text" name="family[${i}][relation]" required class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-semibold text-gray-800 focus:ring-1 focus:ring-brandOrange outline-none" placeholder="E.g. Son, Daughter">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Age *</label>
                        <input type="number" name="family[${i}][age]" required min="1" max="120" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-semibold text-gray-800 focus:ring-1 focus:ring-brandOrange outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Gender *</label>
                        <select name="family[${i}][gender]" required class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-semibold text-gray-800 focus:ring-1 focus:ring-brandOrange outline-none">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', rowHtml);
        }
    }

    /**
     * SECURE CENTRAL MEMBERSHIP LOOKUP PIPELINE
     */
    async function triggerMembershipLookup() {
        const memberId = document.getElementById('lookup_membership_id').value;
        const respMsg = document.getElementById('gate_response_msg');
        const verifyBtn = document.getElementById('btn_verify_member');
        const mainForm = document.getElementById('rudrasena_registration_form');

        if (!memberId || memberId.length !== 12) {
            alert('Please enter a valid 12-digit core membership ID.');
            return;
        }

        verifyBtn.disabled = true;
        verifyBtn.innerText = "Querying Central Nodes...";
        respMsg.classList.add('hidden');
        mainForm.classList.add('hidden');

        try {
            let response = await fetch("{{ route('rudrasena.verify_member') }}", {
                method: 'POST',
                headers: ajaxHeaders,
                body: JSON.stringify({ membership_id: memberId })
            });
            let result = await response.json();
            verifyBtn.disabled = false;
            verifyBtn.innerText = "Verify Membership";

            if (result.success) {
                respMsg.className = "text-xs font-bold mt-3 text-green-600 block";
                respMsg.innerText = result.message;

                // Bind immutable tracking variables securely
                document.getElementById('bound_membership_id').value = result.member.membership_id;
                document.getElementById('bound_dob').value = result.member.dob;
                document.getElementById('bound_age').value = result.member.age;

                document.getElementById('display_full_name').value = result.member.full_name;
                document.getElementById('display_mobile').value = result.member.mobile;
                
                // Smart Email Unlocking Fallback Logic Engine
                const emailInput = document.getElementById('display_email');
                if (!result.member.email || result.member.email === 'N/A') {
                    emailInput.value = '';
                    emailInput.readOnly = false;
                    emailInput.placeholder = "Provide working email to receive your ID Card";
                } else {
                    emailInput.value = result.member.email;
                    emailInput.readOnly = true;
                }
                
                document.getElementById('display_blood').value = result.member.blood_group;
                document.getElementById('display_gotram').value = result.member.gotram;

                // Unroll the advanced configuration profile panel smoothly
                mainForm.classList.remove('hidden');
            } else {
                respMsg.className = "text-xs font-bold mt-3 text-red-600 block";
                respMsg.innerText = result.message;
            }
        } catch (error) {
            verifyBtn.disabled = false;
            verifyBtn.innerText = "Verify Membership";
            alert('Database query transmission pipeline synchronization failure.');
        }
    }

    /**
     * MULTI-PART RELATIONAL RECORD DEPLOYMENT SYSTEM
     */
    async function executeRudrasenaSubmission(event) {
        event.preventDefault();
        
        const submitBtn = document.getElementById('btn_rudrasena_submit');
        const formElement = document.getElementById('rudrasena_registration_form');
        const packetData = new FormData(formElement); // Dynamically encapsulates all fields + files + family arrays

        submitBtn.disabled = true;
        submitBtn.innerText = "Securing Heavy Data Packet...";

        try {
            let response = await fetch("{{ route('rudrasena.submit') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: packetData
            });
            let result = await response.json();
            submitBtn.disabled = false;
            submitBtn.innerText = "Submit Rudrasena Application";

            if (result.success) {
                alert(result.message);
                formElement.reset();
                document.getElementById('membership_gate_section').classList.add('hidden');
                formElement.classList.add('hidden');
                window.location.href = "/";
            } else {
                alert('Submission Refused: ' + result.message);
            }
        } catch (error) {
            submitBtn.disabled = false;
            submitBtn.innerText = "Submit Rudrasena Application";
            alert('Critical infrastructure large asset transmission failure.');
        }
    }
</script>
@endsection
