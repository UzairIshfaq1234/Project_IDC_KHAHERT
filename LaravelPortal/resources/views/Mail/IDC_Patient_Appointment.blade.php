<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDC — Your Result Is Ready</title>
</head>
<body style="margin:0;padding:0;background-color:#eef1f7;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
    <div style="display:none;max-height:0;overflow:hidden;">Your diagnostic result for sample #{{ $Maildata['Sampleno'] }} is ready.</div>

    @php
        $isPositive = $Maildata['Result'] === 'Positive';
    @endphp

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef1f7;padding:30px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 10px 40px rgba(15,23,42,.12);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#4f46e5;background-image:linear-gradient(135deg,#4f46e5,#7c3aed);padding:36px 40px;text-align:center;">
                            <div style="font-size:26px;font-weight:800;letter-spacing:8px;color:#ffffff;">I D C</div>
                            <div style="font-size:11px;font-weight:700;letter-spacing:2px;color:#ddd6fe;text-transform:uppercase;margin-top:4px;">Invasive Ductal Carcinoma Diagnostic Center</div>
                        </td>
                    </tr>

                    {{-- Status pill --}}
                    <tr>
                        <td style="padding:34px 40px 0;text-align:center;">
                            <span style="display:inline-block;background-color:#eef2ff;color:#4f46e5;font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:8px 18px;border-radius:999px;">🔬 Diagnostic Result Ready</span>
                        </td>
                    </tr>

                    {{-- Greeting --}}
                    <tr>
                        <td style="padding:22px 40px 0;">
                            <h1 style="margin:0;font-size:22px;font-weight:800;color:#0f172a;text-align:center;">Dear {{ $Maildata['Name'] }},</h1>
                            <p style="margin:12px 0 0;font-size:14px;line-height:1.7;color:#475569;text-align:center;">
                                The histopathology analysis of your sample is complete and has been reviewed
                                by our consultant pathologist. Your diagnostic decision is below.
                            </p>
                        </td>
                    </tr>

                    {{-- Result banner --}}
                    <tr>
                        <td style="padding:26px 40px 0;">
                            @if ($isPositive)
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#e11d48;background-image:linear-gradient(135deg,#f43f5e,#ec4899);border-radius:16px;">
                                    <tr>
                                        <td style="padding:26px;text-align:center;">
                                            <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:#ffe4e6;text-transform:uppercase;">IDC Screening Decision</div>
                                            <div style="font-size:32px;font-weight:800;color:#ffffff;letter-spacing:2px;margin-top:6px;">⚠ POSITIVE</div>
                                            <div style="font-size:13px;font-weight:600;color:#ffe4e6;margin-top:8px;line-height:1.6;">
                                                Indicators of invasive ductal carcinoma were detected.<br>
                                                <strong style="color:#ffffff;">Please contact the hospital as soon as possible so we can begin your treatment.</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#059669;background-image:linear-gradient(135deg,#059669,#34d399);border-radius:16px;">
                                    <tr>
                                        <td style="padding:26px;text-align:center;">
                                            <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:#d1fae5;text-transform:uppercase;">IDC Screening Decision</div>
                                            <div style="font-size:32px;font-weight:800;color:#ffffff;letter-spacing:2px;margin-top:6px;">✓ NEGATIVE</div>
                                            <div style="font-size:13px;font-weight:600;color:#d1fae5;margin-top:8px;line-height:1.6;">
                                                Congratulations — no indicators of invasive ductal carcinoma were detected.<br>
                                                <strong style="color:#ffffff;">Your results are clear.</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            @endif
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
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #edf0f6;">Report No</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:800;color:#4f46e5;text-align:right;border-bottom:1px solid #edf0f6;">IDC-R-{{ str_pad($Maildata['ID'], 5, '0', STR_PAD_LEFT) }}</td>
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
                                                <td style="padding:11px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Result By</td>
                                                <td style="padding:11px 0;font-size:14px;font-weight:700;color:#0f172a;text-align:right;">Dr. {{ $Maildata['Resultedby'] }} (Consultant Pathologist)</td>
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
                            <div style="font-size:10px;font-weight:700;letter-spacing:2px;color:#94a3b8;text-transform:uppercase;margin-top:8px;">Sample identification barcode</div>
                        </td>
                    </tr>

                    {{-- Note --}}
                    <tr>
                        <td style="padding:28px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef2ff;border:1px solid #c7d2fe;border-radius:12px;">
                                <tr>
                                    <td style="padding:16px 20px;font-size:12px;line-height:1.7;color:#3730a3;">
                                        <strong>Important</strong><br>
                                        • This result was produced with AI assistance and verified by a qualified pathologist.<br>
                                        • Bring your sample number <strong>#{{ $Maildata['Sampleno'] }}</strong> when visiting the hospital.<br>
                                        • A printed diagnosis report is available at the laboratory reception desk.
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
