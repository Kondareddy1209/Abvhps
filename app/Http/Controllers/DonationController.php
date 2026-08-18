<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use Carbon\Carbon;

class DonationController extends Controller
{
    /**
     * Display the Official Admin Donation Ledger with Real-Time Search Filter Channels
     */
    public function index(Request $request)
    {
        $searchToken = $request->input('search');

        // Dynamic Query Builder Matrix with Search Filter Vector Pipeline
        $query = Donation::query();

        if (!empty($searchToken)) {
            $query->where(function ($q) use ($searchToken) {
                $q->where('name', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('contact', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('pan_number', 'LIKE', '%' . $searchToken . '%');
            });
        }

        $donations = $query->orderBy('id', 'desc')->get();

        return view('admin.donation.index', compact('donations', 'searchToken'));
    }

    /**
     * Generate and Dynamic Compile Devotee Digital PDF Cash Receipt Response Block
     */
    public function downloadReceipt($id)
    {
        $donation = Donation::findOrFail($id);

        // Fetch global branding details from site settings configuration if available
        $siteName = 'ABVHPS CENTRAL BOARD';
        $address = 'Survey No:1035, Sasirekhapuram, Akkalareddy Palli, Porumamilla, Kadapa, A.P - 516193';

        // Compile and output a lightweight secure official receipt layout vector matrix
        $htmlOutput = "
        <div style='max-width: 600px; margin: 20px auto; font-family: sans-serif; padding: 30px; border: 6px double #EA580C; border-radius: 8px; background-color: #FFF;'>
            <div style='text-align: center; border-bottom: 2px solid #EA580C; padding-bottom: 15px; margin-bottom: 20px;'>
                <div style='font-size: 36px; margin-bottom: 5px;'>🔱</div>
                <h2 style='color: #EA580C; margin: 0; font-size: 18px; font-weight: 900; letter-spacing: 1px;'>AKHANDA BHARATA VISWA HINDU PARIRAKSHANA SAMITI</h2>
                <p style='color: #6B7280; font-size: 10px; font-weight: 700; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 0.5px;'>{$address}</p>
            </div>

            <div style='text-align: center; margin-bottom: 25px;'>
                <span style='background-color: #FEF3C7; color: #D97706; font-size: 11px; font-weight: 900; padding: 5px 20px; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #FDE68A;'>Official Donation Receipt</span>
            </div>

            <table style='width: 100%; border-collapse: collapse; font-size: 13px; font-semibold: 700; color: #374151; margin-bottom: 30px;'>
                <tr style='background-color: #F9FAFB;'>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>Receipt Number:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-family: monospace; color: #EA580C; font-weight: bold;'>ABVHPS-TXN-".str_pad($donation->id, 6, '0', STR_PAD_LEFT)."</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>Date of Contribution:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB;'>".$donation->created_at->format('d-M-Y H:i')." IST</td>
                </tr>
                <tr style='background-color: #F9FAFB;'>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>Devotee / Donor Name:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; text-transform: uppercase; font-weight: bold;'>{$donation->name}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>Guardian Name:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; text-transform: uppercase;'>".($donation->guardian ?? 'N/A')."</td>
                </tr>
                <tr style='background-color: #F9FAFB;'>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>Contact Reference:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-family: monospace;'>{$donation->contact}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>PAN Card Matrix:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-family: monospace; text-transform: uppercase;'>".($donation->pan_number ?? 'N/A')."</td>
                </tr>
                <tr style='background-color: #FEF3C7;'>
                    <td style='padding: 12px; border: 1px solid #FDE68A; font-weight: bold; color: #B45309;'>Total Contribution:</td>
                    <td style='padding: 12px; border: 1px solid #FDE68A; font-size: 16px; font-weight: 900; color: #B45309;'>₹".number_format($donation->amount, 2)."</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold;'>Seva/Purpose Matrix:</td>
                    <td style='padding: 10px; border: 1px solid #E5E7EB; font-weight: bold; color: #1F2937;'>".($donation->about ?? 'General Contribution Fund')."</td>
                </tr>
            </table>

            <div style='margin-top: 40px; border-top: 1px dashed #E5E7EB; pt: 20px; text-align: right;'>
                <div style='display: inline-block; text-align: center;'>
                    <div style='font-size: 14px; font-weight: bold; color: #111827; margin-bottom: 45px;'>Authorized Signatory</div>
                    <div style='font-size: 10px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px;'>Central Administration Node Desk</div>
                </div>
            </div>

            <div style='text-align: center; margin-top: 30px; border-top: 1px solid #E5E7EB; padding-top: 15px;'>
                <p style='color: #9CA3AF; font-size: 9px; font-weight: 700; text-transform: uppercase; margin: 0; letter-spacing: 1px;'>Thank you for your sacred contribution towards Sanatana Dharma Protection Matrix.</p>
            </div>
        </div>
        ";

        return response($htmlOutput)->header('Content-Type', 'text/html');
    }
}
