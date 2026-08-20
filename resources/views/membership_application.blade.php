@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto my-4 sm:my-8 p-4 sm:p-6 bg-white rounded-xl shadow border border-gray-100">
    
    <!-- Laravel Form Opening with Security Tokens and File Upload Support -->
    <form action="{{ url('/submit-membership') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. Header Area -->
        <div class="border-b border-gray-100 pb-3 mb-6 text-center">
            <span class="text-xs font-bold text-brandOrange uppercase tracking-wider block">ABVHPS Membership Form</span>
            <h2 class="text-xl font-black text-brandGray mt-1">Registration Application</h2>
        </div>

        <!-- 2. 12-Digit Spaced Membership ID Row Component -->
        <div class="mb-6 p-4 bg-brandLightOrange rounded-lg border border-orange-100 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div>
                <span class="text-[11px] font-bold text-gray-500 uppercase block">Generated Membership ID</span>
                <span class="text-xl font-black text-brandOrange tracking-widest">{{ $formattedId }}</span>
            </div>
            <div class="text-right">
                <span class="text-[11px] font-bold text-gray-500 uppercase block">Verified Phone</span>
                <span class="text-sm font-bold text-brandGray">+91 {{ $phone }}</span>
            </div>
        </div>
        <!-- Section A: Aadhaar Verification Desk with Correct Trigger Mapping -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
            <h3 class="text-xs font-bold text-brandGray uppercase tracking-wider border-b border-gray-200 pb-2">Section A: Aadhaar Verification</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="md:col-span-2">
                    <label for="aadhaar_number" class="block text-xs font-bold text-brandGray uppercase mb-1">Aadhaar Number</label>
                    <input type="text" id="aadhaar_number" name="aadhaar_number" maxlength="12" required
                        value="{{ old('aadhaar_number', $member->aadhaar_number ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold tracking-widest text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Enter 12 Digit Aadhaar Number">
                </div>
                <div>
                    <!-- Verification Trigger mapped to real backend endpoint -->
                    <button type="button" id="btn_verify_aadhaar" onclick="executeAadhaarVerification()"
                        class="w-full py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 transition shadow-sm cursor-pointer">
                        Verify via OTP
                    </button>
                </div>
            </div>

            <!-- Aadhaar Auto-fill Row 1: Name and Father/Husband Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="full_name" class="block text-xs font-bold text-brandGray uppercase mb-1">Full Name (As per Aadhaar) *</label>
                    <input type="text" id="full_name" name="full_name" required
                        value="{{ old('full_name', $member->full_name ?? '') }}"
                        class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Enter Full Name (As per Aadhaar)">
                </div>
                <div>
                    <label for="father_or_husband_name" class="block text-xs font-bold text-brandGray uppercase mb-1">Father / Husband Name *</label>
                    <input type="text" id="father_or_husband_name" name="father_or_husband_name" required
                        value="{{ old('father_or_husband_name', $member->father_or_husband_name ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Enter Father or Husband Name">
                </div>
            </div>
            <!-- Aadhaar / Personal Info Row 2: DOB and Gender -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="dob" class="block text-xs font-bold text-brandGray uppercase mb-1">Date of Birth *</label>
                    <input type="date" id="dob" name="dob" required
                        value="{{ old('dob', $member->dob ?? '') }}"
                        class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange outline-none">
                </div>
                <div>
                    <label for="gender" class="block text-xs font-bold text-brandGray uppercase mb-1">Gender *</label>
                    <select id="gender" name="gender" required
                        class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange outline-none">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender', $member->gender ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $member->gender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $member->gender ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 4. Section B: Address Info Row Components -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
            <h3 class="text-xs font-bold text-brandGray uppercase tracking-wider border-b border-gray-200 pb-2">Section B: Address Details Mapping</h3>
            <div>
                <label for="permanent_address" class="block text-xs font-bold text-brandGray uppercase mb-1">Permanent Address (As per Aadhaar) *</label>
                <textarea id="permanent_address" name="permanent_address" rows="2" required
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                    placeholder="Enter Permanent Address (House No, Street, Village, Mandal, District details...)">{{ old('permanent_address', $member->permanent_address ?? '') }}</textarea>
            </div>

            <!-- Present Address Selector Radio Toggles -->
            <div class="space-y-2">
                <span class="block text-xs font-bold text-brandGray uppercase">Communication / Present Address</span>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center text-sm text-brandGray font-medium cursor-pointer">
                        <input type="radio" name="address_toggle" value="same" checked onclick="togglePresentAddress(false)"
                            class="h-4 w-4 text-brandOrange focus:ring-brandOrange border-gray-300">
                        <span class="ml-2">As Above (Same as Permanent)</span>
                    </label>
                    <label class="inline-flex items-center text-sm text-brandGray font-medium cursor-pointer">
                        <input type="radio" name="address_toggle" value="different" onclick="togglePresentAddress(true)"
                            class="h-4 w-4 text-brandOrange focus:ring-brandOrange border-gray-300">
                        <span class="ml-2">Add Address (Different Present Address)</span>
                    </label>
                </div>
            </div>
            <!-- Present Address Expandable Box Input Grid -->
            <div id="present_address_box" class="hidden">
                <label for="present_address" class="block text-xs font-bold text-brandGray uppercase mb-1">Present Address Details</label>
                <textarea id="present_address" name="present_address" rows="2"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-brandOrange focus:border-brandOrange text-brandGray"
                    placeholder="Enter Present House Number, Street, Village details">{{ old('present_address', $member->present_address ?? '') }}</textarea>
            </div>
        </div>

        <!-- 5. Section C: Gotram, Occupation, Blood Group & Optional Email Layout -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
            <h3 class="text-xs font-bold text-brandGray uppercase tracking-wider border-b border-gray-200 pb-2">Section C: Personal Profile</h3>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label for="gotram" class="block text-xs font-bold text-brandGray uppercase mb-1">Gotramu *</label>
                    <input type="text" id="gotram" name="gotram" required
                        value="{{ old('gotram', $member->gotram ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Enter Gotram">
                </div>
                <div>
                    <label for="occupation" class="block text-xs font-bold text-brandGray uppercase mb-1">Occupation *</label>
                    <input type="text" id="occupation" name="occupation" required
                        value="{{ old('occupation', $member->occupation ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Enter Profession">
                </div>
                <div>
                    <label for="blood_group" class="block text-xs font-bold text-brandGray uppercase mb-1">Blood Group *</label>
                    <select id="blood_group" name="blood_group" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-brandGray font-semibold focus:ring-brandOrange focus:border-brandOrange">
                        <option value="">Select Group</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group', $member->blood_group ?? '') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-brandGray uppercase mb-1">Email ID (Optional)</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', $member->email ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="name@email.com">
                </div>
            </div>
        </div>

        <!-- 6. Section D: Fixed Pin Code Input with Fetch Button Component -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
            <h3 class="text-xs font-bold text-brandGray uppercase tracking-wider border-b border-gray-200 pb-2">Section D: Location Demographics</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                <div class="sm:col-span-2">
                    <label for="pincode" class="block text-xs font-bold text-brandGray uppercase mb-1">PIN Code *</label>
                    <input type="text" id="pincode" name="pincode" maxlength="6" required
                        value="{{ old('pincode', $member->pincode ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-brandOrange font-black focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Enter 6 Digit PIN Code">
                </div>
                <div>
                    <button type="button" id="btn_fetch_pincode" onclick="fetchIndianPostalData()"
                        class="w-full py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 transition shadow-sm">
                        Fetch Details
                    </button>
                </div>
            </div>
            <!-- SECTION D: LOCATION DEMOGRAPHICS WITH CORRECT CONTROL NAMES -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-brandGray uppercase mb-1">Grama Panchayat / Taluka *</label>
                    <input type="text" id="grama_panchayat" name="grama_panchayat" required
                        value="{{ old('grama_panchayat', $member->grama_panchayat ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Grama Panchayat">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandGray uppercase mb-1">Mandal *</label>
                    <input type="text" id="mandal" name="mandal" required
                        value="{{ old('mandal', $member->mandal ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Mandal">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandGray uppercase mb-1">Assembly Segment (Optional)</label>
                    <input type="text" id="assembly_segment" name="assembly_segment"
                        value="{{ old('assembly_segment', $member->assembly_segment ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="Assembly Segment">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                <div>
                    <label class="block text-xs font-bold text-brandGray uppercase mb-1">District *</label>
                    <input type="text" id="district" name="district" required
                        value="{{ old('district', $member->district ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="District">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandGray uppercase mb-1">State *</label>
                    <input type="text" id="state" name="state" required
                        value="{{ old('state', $member->state ?? '') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm font-semibold text-brandGray focus:ring-brandOrange focus:border-brandOrange"
                        placeholder="State">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandGray uppercase mb-1">Country</label>
                    <input type="text" id="country" name="country" readonly
                        value="{{ old('country', $member->country ?? 'India') }}"
                        class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm font-semibold text-gray-500 outline-none"
                        placeholder="Country">
                </div>
            </div>
        </div>

        <!-- 7. Section E: Photo Input Document Component -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
            <h3 class="text-xs font-bold text-brandGray uppercase tracking-wider border-b border-gray-200 pb-2">Section E: Photo Management</h3>
            <div>
                <label for="photo" class="block text-xs font-bold text-brandGray uppercase mb-1">Upload Photo / Live Capture</label>
                <input type="file" id="photo" name="photo" accept="image/*" required
                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-orange-100 file:text-brandOrange hover:file:bg-orange-200">
            </div>
        </div>

        <!-- 8. Section F: Clean English Disclaimer & Required Checkbox Grid Components -->
        <div class="bg-brandLightOrange p-5 rounded-lg border border-orange-100 text-xs text-gray-700 space-y-4 leading-relaxed">
            <p class="font-bold text-brandOrange uppercase tracking-wider text-[11px]">Disclaimer & Data Security Policy</p>
            <p class="text-gray-600">
                The Aadhaar data collected through this application is strictly used for individual identity verification purpose only. This process is digitally executed with the applicant's explicit consent. In accordance with the Data Protection regulations of India, your personal information is stored securely in highly encrypted servers and will never be transferred to third parties or misused under any circumstances.
            </p>
            
            <div class="space-y-3 pt-3 border-t border-orange-200/60">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" required class="mt-0.5 h-4 w-4 rounded border-gray-300 text-brandOrange focus:ring-brandOrange cursor-pointer">
                    <span class="text-brandGray font-medium group-hover:text-brandOrange transition">
                        1. I am voluntarily submitting my personal and address details to Akhanda Bharatha Viswa Hindu Parirakshana Samiti (ABVHPS) with full consciousness and consent, without any force or pressure from anyone.
                    </span>
                </label>

                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" required class="mt-0.5 h-4 w-4 rounded border-gray-300 text-brandOrange focus:ring-brandOrange cursor-pointer">
                    <span class="text-brandGray font-medium group-hover:text-brandOrange transition">
                        2. I completely believe in and follow Sanatana Hindu Dharma. I agree to abide by all the rules and regulations of the organization.
                    </span>
                </label>

                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" required class="mt-0.5 h-4 w-4 rounded border-gray-300 text-brandOrange focus:ring-brandOrange cursor-pointer">
                    <span class="text-brandGray font-medium group-hover:text-brandOrange transition">
                        3. All the details submitted by me are completely true. If it is proven that I have provided false information or fake Aadhaar details to deceive the organization, my membership will be cancelled immediately, and the organization reserves full rights to take legal criminal or civil action against me.
                    </span>
                </label>
            </div>
        </div>

        <!-- Added Hidden Field to safely pass the Verified Phone Parameter into Controller -->
        <input type="hidden" name="phone" value="{{ $phone ?? session('verified_membership_phone') }}">

        <!-- 9. Final Application Form Submit Action Button Trigger -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brandOrange shadow-md transition cursor-pointer">
                Submit Registration & Generate ID Card
            </button>
        </div>
    </form>
</section>
<script>
    function togglePresentAddress(show) {
        const box = document.getElementById('present_address_box');
        const text = document.getElementById('present_address');
        if (show) {
            box.classList.remove('hidden');
            text.required = true;
        } else {
            box.classList.add('hidden');
            text.required = false;
            text.value = '';
        }
    }

    // Fixed Pin Code Engine with accurate array reading and local dummy data backup
    function fetchIndianPostalData() {
        const pincodeInput = document.getElementById('pincode').value;
        const btn = document.getElementById('btn_fetch_pincode') || document.querySelector('button[onclick="fetchIndianPostalData()"]');

        if (pincodeInput.length !== 6) {
            alert("Please enter a valid 6-digit PIN Code first.");
            return;
        }

        // LOCAL BACKUP LOGIC: If testing with Porumamilla pin code locally, auto-fill instantly without internet dependency
        if (pincodeInput === "516193") {
            document.getElementById('grama_panchayat').value = "Porumamilla";
            document.getElementById('mandal').value = "Porumamilla";
            document.getElementById('district').value = "YSR Kadapa";
            document.getElementById('state').value = "Andhra Pradesh";
            document.getElementById('country').value = "India";
            return;
        }

        if (btn) {
            btn.disabled = true;
            btn.innerText = "Fetching...";
        }

        const url = 'https://api.postalpincode.in/pincode/' + pincodeInput;
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                // Reading the exact array block structure data[0] from Indian Postal Service Response
                if (data && data[0] && data[0].Status === "Success" && data[0].PostOffice && data[0].PostOffice.length > 0) {
                    const postOfficeList = data[0].PostOffice;
                    const firstOffice = postOfficeList[0]; // Capturing the very first zone matching row
                    
                    document.getElementById('grama_panchayat').value = firstOffice.Name || '';
                    document.getElementById('mandal').value = firstOffice.Taluk || '';
                    document.getElementById('district').value = firstOffice.District || '';
                    document.getElementById('state').value = firstOffice.State || '';
                    document.getElementById('country').value = "India";
                } else {
                    alert("Invalid PIN Code or Service is down.");
                }
            })
            .catch(error => {
                console.error("Postal API error:", error);
                alert("Failed to fetch PIN Code details. Please check your network or enter details manually.");
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerText = "Fetch Details";
                }
            });
    }

    // Dynamic Aadhaar Verification Engine connected directly to Backend Pipeline
    async function executeAadhaarVerification() {
        const aadhaarInput = document.getElementById('aadhaar_number');
        const aadhaarValue = aadhaarInput ? aadhaarInput.value.trim() : '';

        if (!aadhaarValue || aadhaarValue.length !== 12 || !/^\d{12}$/.test(aadhaarValue)) {
            alert("Please enter a valid 12-digit Aadhaar Number first.");
            return;
        }

        if (aadhaarValue[0] === '0' || aadhaarValue[0] === '1') {
            alert("Invalid Aadhaar number format. Aadhaar numbers cannot start with 0 or 1.");
            return;
        }

        const btn = document.getElementById('btn_verify_aadhaar');
        if (btn) {
            btn.disabled = true;
            btn.innerText = "Verifying...";
        }

        try {
            const response = await fetch("{{ url('/membership/verify-aadhaar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    aadhaar_number: aadhaarValue
                })
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                // Populate verified applicant fields only if returned from verification record
                if (result.data) {
                    if (result.data.full_name) {
                        const nameField = document.getElementById('full_name');
                        nameField.value = result.data.full_name;
                    }
                    if (result.data.dob) {
                        document.getElementById('dob').value = result.data.dob;
                    }
                    if (result.data.gender) {
                        document.getElementById('gender').value = result.data.gender;
                    }
                    if (result.data.permanent_address) {
                        document.getElementById('permanent_address').value = result.data.permanent_address;
                    }
                    if (result.data.father_or_husband_name) {
                        document.getElementById('father_or_husband_name').value = result.data.father_or_husband_name;
                    }
                } else {
                    // No existing data, focus applicant name field for actual name entry
                    const nameField = document.getElementById('full_name');
                    if (!nameField.value) {
                        nameField.focus();
                    }
                }

                alert("✅ " + (result.message || "Aadhaar Identity Authenticated Successfully!"));
            } else {
                alert("❌ Verification Failed: " + (result.message || "Invalid Aadhaar details. Please check and try again."));
            }
        } catch (error) {
            console.error("Aadhaar verification error:", error);
            alert("Network error during Aadhaar verification. Please try again.");
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerText = "Verify via OTP";
            }
        }
    }
</script>
@endsection
