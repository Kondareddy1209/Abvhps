<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PublicVerificationController extends Controller
{
    /**
     * Verify Membership (12-Digit Numeric ID)
     */
    public function verifyMembership($id)
    {
        $cleanId = trim((string)$id);

        $member = DB::table('memberships')
            ->where('membership_id', $cleanId)
            ->first();

        if (!$member) {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Membership',
                'searchedId' => $cleanId,
                'errorMessage' => 'No active membership record was found with ID: ' . htmlspecialchars($cleanId),
            ]);
        }

        $locationParts = array_filter([
            $member->grama_panchayat,
            $member->mandal,
            $member->district,
            $member->state,
            $member->country ?? 'India'
        ]);

        $payload = [
            'isValid' => true,
            'entityType' => 'ABVHPS Life Member',
            'officialIdLabel' => 'Membership ID',
            'officialId' => $member->membership_id,
            'name' => $member->full_name,
            'photoPath' => $member->photo_path,
            'status' => ($member->payment_status === 'success' || $member->is_completed) ? 'ACTIVE & VERIFIED' : 'PENDING VERIFICATION',
            'isApproved' => ($member->payment_status === 'success' || $member->is_completed),
            'cadre' => 'Life Member',
            'location' => implode(', ', $locationParts) ?: 'Headquarters Matrix',
            'bloodGroup' => $member->blood_group ?? null,
            'verifiedSince' => $member->created_at ? Carbon::parse($member->created_at)->format('d M Y') : 'Official Record',
        ];

        return view('verify_entity', $payload);
    }

    /**
     * Verify Volunteer (6-Digit Numeric ID)
     */
    public function verifyVolunteer($id)
    {
        $cleanId = trim((string)$id);

        $volunteer = DB::table('volunteers')
            ->leftJoin('memberships', 'volunteers.membership_id', '=', 'memberships.membership_id')
            ->select(
                'volunteers.*',
                'memberships.full_name as member_full_name',
                'memberships.photo_path as member_photo_path',
                'memberships.blood_group as member_blood_group',
                'memberships.district as member_district',
                'memberships.mandal as member_mandal',
                'memberships.grama_panchayat as member_grama_panchayat',
                'memberships.state as member_state'
            )
            ->where('volunteers.volunteer_id', $cleanId)
            ->orWhere('volunteers.volunteer_login_id', $cleanId)
            ->first();

        if (!$volunteer || $volunteer->status !== 'approved') {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Volunteer',
                'searchedId' => $cleanId,
                'errorMessage' => 'No active, approved volunteer record was found with ID: ' . htmlspecialchars($cleanId),
            ]);
        }

        $locationParts = array_filter([
            $volunteer->grama_panchayat ?: $volunteer->member_grama_panchayat,
            $volunteer->mandal ?: $volunteer->member_mandal,
            $volunteer->district ?: $volunteer->member_district,
            $volunteer->state ?: $volunteer->member_state,
        ]);

        $payload = [
            'isValid' => true,
            'entityType' => 'Authorized Volunteer',
            'officialIdLabel' => 'Volunteer ID',
            'officialId' => $volunteer->volunteer_id ?? $volunteer->volunteer_login_id,
            'name' => $volunteer->member_full_name ?? 'Registered Volunteer',
            'photoPath' => $volunteer->member_photo_path ?? null,
            'status' => 'ACTIVE & APPROVED',
            'isApproved' => true,
            'cadre' => $volunteer->cadre ?: ($volunteer->designation ?: 'Field Volunteer'),
            'locality' => $volunteer->locality ?: 'Regional Jurisdiction',
            'location' => implode(', ', $locationParts) ?: ($volunteer->locality ?: 'Regional Jurisdiction'),
            'bloodGroup' => $volunteer->member_blood_group ?? null,
            'verifiedSince' => $volunteer->created_at ? Carbon::parse($volunteer->created_at)->format('d M Y') : 'Official Record',
        ];

        return view('verify_entity', $payload);
    }

    /**
     * Verify Rudra Sena Member (RS0001 format)
     */
    public function verifyRudrasena($id)
    {
        $cleanId = trim((string)$id);

        $member = DB::table('rudrasena_members')
            ->leftJoin('memberships', 'rudrasena_members.membership_id', '=', 'memberships.membership_id')
            ->select(
                'rudrasena_members.*',
                'memberships.photo_path as member_photo_path',
                'memberships.district as member_district',
                'memberships.mandal as member_mandal',
                'memberships.state as member_state'
            )
            ->where('rudrasena_members.rudrasena_id', $cleanId)
            ->first();

        if (!$member || !in_array($member->status, ['verified', 'approved'])) {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Rudra Sena Member',
                'searchedId' => $cleanId,
                'errorMessage' => 'No active, verified Rudra Sena member was found with ID: ' . htmlspecialchars($cleanId),
            ]);
        }

        $locationParts = array_filter([
            $member->assigned_locality,
            $member->member_district,
            $member->member_state,
        ]);

        $payload = [
            'isValid' => true,
            'entityType' => 'Rudra Sena Member',
            'officialIdLabel' => 'Rudra Sena ID',
            'officialId' => $member->rudrasena_id,
            'name' => $member->full_name,
            'photoPath' => $member->member_photo_path,
            'status' => 'VERIFIED & ACTIVE',
            'isApproved' => true,
            'cadre' => $member->assigned_cadder ?: 'Rudra Sena Commando',
            'location' => implode(', ', $locationParts) ?: ($member->assigned_locality ?: 'Dharma Defense Wing'),
            'bloodGroup' => $member->blood_group ?? null,
            'verifiedSince' => $member->created_at ? Carbon::parse($member->created_at)->format('d M Y') : 'Official Record',
        ];

        return view('verify_entity', $payload);
    }

    /**
     * Verify Exam Hall Ticket (11-Digit Numeric)
     */
    public function verifyExam($hallTicket)
    {
        $cleanId = trim((string)$hallTicket);

        $app = DB::table('exam_applications')
            ->leftJoin('exam_settings', 'exam_applications.exam_setting_id', '=', 'exam_settings.id')
            ->select(
                'exam_applications.*',
                'exam_settings.exam_title',
                'exam_settings.exam_date_time as exam_date',
                'exam_settings.exam_center_location as exam_center_address',
                'exam_settings.exam_type'
            )
            ->where('exam_applications.hall_ticket_number', $cleanId)
            ->first();

        if (!$app) {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Exam Hall Ticket',
                'searchedId' => $cleanId,
                'errorMessage' => 'No exam applicant hall ticket was found with number: ' . htmlspecialchars($cleanId),
            ]);
        }

        $isPaid = ($app->payment_status === 'success' || $app->payment_status === 'completed');

        $payload = [
            'isValid' => true,
            'entityType' => 'Exam Applicant Hall Ticket',
            'officialIdLabel' => 'Hall Ticket No.',
            'officialId' => $app->hall_ticket_number,
            'name' => $app->full_name,
            'photoPath' => $app->photo_path,
            'status' => $isPaid ? 'VALID HALL TICKET' : 'PENDING CLEARANCE',
            'isApproved' => $isPaid,
            'cadre' => $app->exam_title ?: 'Sanatana Dharma Examination',
            'location' => $app->exam_center_address ?: ($app->address ?: 'Authorized Examination Center'),
            'examDate' => $app->exam_date ? Carbon::parse($app->exam_date)->format('d M Y, h:i A') : 'Scheduled Exam',
            'schoolCollege' => $app->school_college_name ?? null,
            'verifiedSince' => $app->created_at ? Carbon::parse($app->created_at)->format('d M Y') : 'Official Entry',
        ];

        return view('verify_entity', $payload);
    }

    /**
     * Verify Organic Farmers Group (OF-XXXXXX)
     */
    public function verifyOrganicFarmers($groupId)
    {
        $cleanId = trim((string)$groupId);

        $group = DB::table('organic_farmers')
            ->where('farmer_registration_id', $cleanId)
            ->first();

        if (!$group) {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Organic Farmers Group',
                'searchedId' => $cleanId,
                'errorMessage' => 'No organic farmers village group was found with Group ID: ' . htmlspecialchars($cleanId),
            ]);
        }

        $crops = DB::table('farmer_crops')->where('organic_farmer_id', $group->id)->pluck('crop_name')->toArray();

        $payload = [
            'isValid' => true,
            'entityType' => 'Organic Farmers Group',
            'officialIdLabel' => 'Group ID',
            'officialId' => $group->farmer_registration_id,
            'name' => $group->farmer_name . ' (Village Lead Farmer)',
            'status' => $group->status === 'approved' ? 'VERIFIED ORGANIC GROUP' : 'PENDING VERIFICATION',
            'isApproved' => $group->status === 'approved',
            'cadre' => 'Desi Agriculture Wing',
            'location' => ($group->land_size_acres ? $group->land_size_acres . ' Acres (' . ($group->water_source ?? 'Rainfed') . ')' : 'Organic Farmland'),
            'extraDetail' => 'Desi Cows: ' . ($group->indigenous_cows_count ?? 0) . (!empty($crops) ? ' | Crops: ' . implode(', ', $crops) : ''),
            'verifiedSince' => $group->created_at ? Carbon::parse($group->created_at)->format('d M Y') : 'Official Entry',
        ];

        return view('verify_entity', $payload);
    }

    /**
     * Verify Kala Brundam Cultural Wing Group (KB-XXXXXX)
     */
    public function verifyKalaBrundham($groupId)
    {
        $cleanId = trim((string)$groupId);

        $group = DB::table('kala_brundams')
            ->where('team_registration_id', $cleanId)
            ->first();

        if (!$group) {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Kala Brundam Cultural Wing',
                'searchedId' => $cleanId,
                'errorMessage' => 'No Kala Brundam cultural group was found with Group ID: ' . htmlspecialchars($cleanId),
            ]);
        }

        $membersCount = DB::table('kala_brundam_members')->where('kala_brundam_id', $group->id)->count();

        $payload = [
            'isValid' => true,
            'entityType' => 'Kala Brundam Cultural Wing',
            'officialIdLabel' => 'Group ID',
            'officialId' => $group->team_registration_id,
            'name' => $group->team_name,
            'status' => $group->status === 'approved' ? 'VERIFIED CULTURAL TEAM' : 'PENDING VERIFICATION',
            'isApproved' => $group->status === 'approved',
            'cadre' => $group->team_type . ($group->custom_type_spec ? ' (' . $group->custom_type_spec . ')' : ''),
            'location' => $group->location,
            'extraDetail' => 'Certified Team Strength: ' . ($membersCount ?: 1) . ' Artists / Performers',
            'verifiedSince' => $group->created_at ? Carbon::parse($group->created_at)->format('d M Y') : 'Official Entry',
        ];

        return view('verify_entity', $payload);
    }

    /**
     * Verify Grama Seva Dal Village Wing Group (GSD-XXXXXX)
     */
    public function verifyGramaSevaDal($groupId)
    {
        $cleanId = trim((string)$groupId);

        $group = DB::table('grama_seva_dals')
            ->where('gong_registration_id', $cleanId)
            ->first();

        if (!$group) {
            return view('verify_entity', [
                'isValid' => false,
                'entityType' => 'Grama Seva Dal Village Wing',
                'searchedId' => $cleanId,
                'errorMessage' => 'No Grama Seva Dal village service group was found with Group ID: ' . htmlspecialchars($cleanId),
            ]);
        }

        $membersCount = DB::table('grama_seva_dal_members')->where('grama_seva_dal_id', $group->id)->count();
        $locationParts = array_filter([
            $group->village_or_gp,
            $group->mandal,
            $group->district,
            $group->state,
        ]);

        $payload = [
            'isValid' => true,
            'entityType' => 'Grama Seva Dal Village Wing',
            'officialIdLabel' => 'Group ID',
            'officialId' => $group->gong_registration_id,
            'name' => $group->leader_name . ' (Dal Lead)',
            'status' => $group->status === 'approved' ? 'VERIFIED SERVICE DAL' : 'PENDING VERIFICATION',
            'isApproved' => $group->status === 'approved',
            'cadre' => 'Village Youth Service Dal',
            'location' => implode(', ', $locationParts) ?: 'Grama Panchayat Jurisdiction',
            'extraDetail' => 'Seva Force Strength: ' . ($membersCount ?: 1) . ' Active Volunteers',
            'verifiedSince' => $group->created_at ? Carbon::parse($group->created_at)->format('d M Y') : 'Official Entry',
        ];

        return view('verify_entity', $payload);
    }
}
