<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDC — Record Updated</title>
</head>
<body style="margin:0;padding:0;background-color:#eef1f7;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
    <div style="display:none;max-height:0;overflow:hidden;">Your record for sample #{{ $Maildata['Sampleno'] }} was updated at IDC Diagnostic Center.</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef1f7;padding:30px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 10px 40px rgba(15,23,42,.12);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#0284c7;background-image:linear-gradient(135deg,#0284c7,#38bdf8);padding:36px 40px;text-align:center;">
                            <div style="font-size:26px;font-weight:800;letter-spacing:8px;color:#ffffff;">I D C</div>
                            <div style="font-size:11px;font-weight:700;letter-spacing:2px;color:#e0f2fe;text-transform:uppercase;margin-top:4px;">Invasive Ductal Carcinoma Diagnostic Center</div>
                        </td>
                    </tr>

                    {{-- Status pill --}}
                    <tr>
                        <td style="padding:34px 40px 0;text-align:center;">
                            <span style="display:inline-block;background-color:#e0f2fe;color:#0284c7;font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:8px 18px;border-radius:999px;">↻ Record Updated</span>
                        </td>
                    </tr>

                    {{-- Greeting --}}
                    <tr>
                        <td style="padding:22px 40px 0;">
                            <h1 style="margin:0;font-size:22px;font-weight:800;color:#0f172a;text-align:center;">Dear {{ $Maildata['Name'] }},</h1>
                            <p style="margin:12px 0 0;font-size:14px;line-height:1.7;color:#475569;text-align:center;">
                                Your registration details at the IDC Diagnostic Center have been updated by our laboratory team.
                                Here is your current record — please review it and contact us if anything looks incorrect.
                            </p>
                        </td>
                    </tr>

                    {{-- Details card --}}
                    <tr>
                        <td style="padding:26px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e5e9f2;border-radius:14px;">
                                <tr>
                                    <td style="padding:8px 22px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #edf0f6;">Tracking ID</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:800;color:#0284c7;text-align:right;border-bottom:1px solid #edf0f6;">IDC-{{ str_pad($Maildata['ID'], 5, '0', STR_PAD_LEFT) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #edf0f6;">Sample Number</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:800;color:#0f172a;text-align:right;border-bottom:1px solid #edf0f6;">#{{ $Maildata['Sampleno'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #edf0f6;">Patient Name</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:700;color:#0f172a;text-align:right;border-bottom:1px solid #edf0f6;">{{ $Maildata['Name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #edf0f6;">Contact Number</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:700;color:#0f172a;text-align:right;border-bottom:1px solid #edf0f6;">{{ $Maildata['ContactNo'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #edf0f6;">Registered By</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:700;color:#0f172a;text-align:right;border-bottom:1px solid #edf0f6;">{{ $Maildata['Addedby'] }} (Laboratory Technician)</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Updated By</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:700;color:#0f172a;text-align:right;">{{ $Maildata['Updatedby'] }} (Laboratory Technician)</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Barcode --}}
                    <tr>
                        <td style="padding:26px 40px 0;text-align:center;">
                            <img src="https://barcodeapi.org/api/128/{{ urlencode($Maildata['Sampleno']) }}" alt="Sample barcode #{{ $Maildata['Sampleno'] }}" width="260" style="max-width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:8px;background:#ffffff;">
                            <div style="font-size:10px;font-weight:700;letter-spacing:2px;color:#94a3b8;text-transform:uppercase;margin-top:8px;">Your sample identification barcode</div>
                        </td>
                    </tr>

                    {{-- Note --}}
                    <tr>
                        <td style="padding:28px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb;border:1px solid #fde68a;border-radius:12px;">
                                <tr>
                                    <td style="padding:16px 20px;font-size:12px;line-height:1.7;color:#92400e;">
                                        <strong>Good to know</strong><br>
                                        • This update does not affect your sample or its processing.<br>
                                        • Your result will still be delivered to this email address.<br>
                                        • If you did not request this change, please contact the laboratory desk.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:32px 40px 28px;text-align:center;">
                            <div style="border-top:1px solid #e5e9f2;padding-top:22px;">
                                <div style="font-size:13px;font-weight:800;color:#0f172a;">IDC Diagnostic Center</div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:4px;line-height:1.7;">
                                    AI-assisted histopathology · Thank you for choosing IDC<br>
                                    This is an automated message — please do not reply directly to this email.
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>

                <div style="font-size:10px;color:#94a3b8;margin-top:16px;">© {{ date('Y') }} IDC Portal — Muhammad Uzair Ishfaq &amp; Khadija Ibrahim</div>
            </td>
        </tr>
    </table>
</body>
</html>
