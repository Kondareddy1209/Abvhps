<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\SiteSetting;

class ContactController extends Controller
{
    /**
     * Public Contact Us Page
     */
    public function showContactPage()
    {
        $contactPhone = SiteSetting::get('contact_phone', '+91 8884933379');
        $contactEmail = SiteSetting::get('contact_email', 'info@abvhps.org');
        $contactAddress = SiteSetting::get('contact_address', 'Survey No:1826, Shanmukhapuram, Akkalareddy Palli, Porumamilla, Kadapa, A.P - 516193');

        return view('contact', compact('contactPhone', 'contactEmail', 'contactAddress'));
    }

    /**
     * Public Contact Form Submission with Anti-Spam & Link Blocking
     */
    public function submitContact(Request $request)
    {
        // 1. Honeypot Anti-Bot Trap (bots fill hidden inputs)
        if (!empty($request->input('website_trap_honeypot'))) {
            // Silently drop bot submission
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message. Our administration will review your submission shortly.'
            ]);
        }

        // 2. Validate Inputs
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:3000|min:5',
        ]);

        $messageContent = $request->message;
        $nameContent = $request->name;

        // 3. Link-Blocking Spam Filter: Detect URLs, links, BBCode, HTML hrefs
        $spamUrlPattern = '/(https?:\/\/|www\.|\.ru\/|\.xyz\/|\.top\/|<a\s+href|\[url=)/i';
        if (preg_match($spamUrlPattern, $messageContent) || preg_match($spamUrlPattern, $nameContent)) {
            return response()->json([
                'success' => false,
                'message' => 'External links and web addresses are not permitted in contact messages to prevent automated spam. Please remove any URLs and try again.'
            ], 422);
        }

        // 4. Save Valid Contact Message
        ContactMessage::create([
            'name' => strip_tags($request->name),
            'email' => strip_tags($request->email),
            'phone' => strip_tags($request->phone),
            'subject' => strip_tags($request->subject ?? 'General Devotee Inquiry'),
            'message' => strip_tags($request->message),
            'ip_address' => $request->ip(),
            'status' => 'unread',
        ]);

        return response()->json([
            'success' => true,
            'message' => '🙏 Thank you for reaching out to ABVHPS. Your message has been safely logged in our central audit desk.'
        ]);
    }

    /**
     * Admin Contact Forms Audit Inbox
     */
    public function adminIndex(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');

        $query = ContactMessage::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        $messages = $query->orderBy('id', 'desc')->paginate(20);

        $stats = [
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'read_messages' => ContactMessage::where('status', 'read')->count(),
            'replied_messages' => ContactMessage::where('status', 'replied')->count(),
        ];

        return view('admin.contacts_index', compact('messages', 'stats', 'status', 'search'));
    }

    /**
     * Admin View Single Contact Message
     */
    public function adminView($id)
    {
        $message = ContactMessage::findOrFail($id);
        if ($message->status === 'unread') {
            $message->status = 'read';
            $message->save();
        }

        return view('admin.contacts_view', compact('message'));
    }

    /**
     * Admin Delete Contact Message
     */
    public function adminDelete($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact inquiry removed from audit log.');
    }
}
