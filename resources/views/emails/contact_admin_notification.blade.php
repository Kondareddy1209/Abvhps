<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>New ABVHPS Inquiry</title></head>
<body style="font-family:sans-serif;background:#f4f4f4;margin:0;padding:0;">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center" style="padding:30px 15px;">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
  <tr><td style="background:#1a1a1a;padding:20px 30px;text-align:center;">
    <h2 style="color:#FF6600;margin:4px 0;font-size:14px;text-transform:uppercase;letter-spacing:2px;">ABVHPS CENTRAL BOARD</h2>
    <p style="color:#aaa;font-size:11px;margin:0;">New Contact Inquiry Received</p>
  </td></tr>
  <tr><td style="padding:25px 30px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px;">
      <tr><td style="padding:8px 0;border-bottom:1px solid #f0f0f0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Name</strong><br><span style="color:#111;">{{ $name }}</span></td></tr>
      <tr><td style="padding:8px 0;border-bottom:1px solid #f0f0f0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Email</strong><br><span style="color:#111;">{{ $email }}</span></td></tr>
      <tr><td style="padding:8px 0;border-bottom:1px solid #f0f0f0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Phone</strong><br><span style="color:#111;">{{ $phone ?: 'Not provided' }}</span></td></tr>
      <tr><td style="padding:8px 0;border-bottom:1px solid #f0f0f0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Subject</strong><br><span style="color:#111;">{{ $subject }}</span></td></tr>
      <tr><td style="padding:8px 0;border-bottom:1px solid #f0f0f0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Source</strong><br><span style="color:#FF6600;">{{ $source }}</span></td></tr>
      <tr><td style="padding:8px 0;border-bottom:1px solid #f0f0f0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Submitted</strong><br><span style="color:#111;">{{ $submittedAt }}</span></td></tr>
      <tr><td style="padding:12px 0;"><strong style="color:#4a4a4a;text-transform:uppercase;font-size:10px;">Message</strong><br><div style="margin-top:6px;padding:12px;background:#f8f8f8;border-radius:6px;border-left:3px solid #FF6600;color:#333;line-height:1.6;">{{ $messageText }}</div></td></tr>
    </table>
    <div style="margin-top:20px;text-align:center;">
      <a href="{{ config('app.url') }}/admin/contacts" style="background:#FF6600;color:#fff;padding:10px 24px;border-radius:6px;font-weight:bold;text-decoration:none;font-size:12px;text-transform:uppercase;">View in Admin Inbox</a>
    </div>
  </td></tr>
  <tr><td style="padding:12px 30px;background:#f9f9f9;border-top:1px solid #eee;font-size:10px;color:#aaa;text-align:center;">
    ABVHPS Central Board &mdash; Automated notification. Do not reply to this email directly.
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>