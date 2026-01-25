<div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Flower School ID Card</title>
    <link rel="stylesheet" href="style.css">
</head>

{{--
<link rel="stylesheet" href="styles.css"> --}}
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
        font-family: sans-serif;
    }

    .page {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .card {
        width: 400px;
        height: 650px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    .header {
        background-color: #024C69;
        /* Dark background */
        color: white;
        /* White text */
        text-align: center;
        padding: 10px;
        border-radius: 8px 8px 0 0;
    }

    .header h1 {
        margin: 0;
        font-size: 1.8em;
        font-weight: bold;
    }

    h2 {
        margin: 10;
        font-size: 1.2rem;
        align-items: center;

        font-weight: bold;
    }

    .header-details {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    .logo img {
        width: 80px;
        height: 80px;
        /* border-block: 5px solid #ccc; */
        border-radius: 50%;
        margin-right: 10px;
    }

    .school-info {
        text-align: left;
    }

    .english-medium {
        background-color: #ffeb3b;
        color: black;
        padding: 2px 5px;
        border-radius: 5px;
        font-size: 1.2em;
        display: inline-block;
        margin-top: 5px;
    }

    .estd {
        font-size: 1.2em;
        margin-top: 5px;
    }

    .address,
    .contact {
        text-align: center;
        font-size: 0.9em;
        margin-bottom: 2px;
    }

    .container{
        display: flex;
        flex-direction: column;
    }

    .photo-container {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        gap: 20px;
        /* justify-content: space-; */
        justify-content: center;
        align-items: right;
        margin-bottom: 15px;
    }

    .photo-placeholder-main img {
        width: 100px;
        height: 120px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
    }

    .photo-placeholder img {
        width: 100px;
        height: 100px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
    }

    .name {
        font-weight: bold;
        font-size: 1.1em;
    }

    .details {
        font-size: 0.9em;
    }

    .detail-row {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .detail-label {
        font-weight: bold;
        margin-right: 5px;
    }

    .detail-value {
        flex-grow: 1;
        border-bottom: 1px dotted #ccc;
        padding-bottom: 2px;
        text-align: left;
        font-size: 1.2rem;
        color: #b70808;
        font-weight: bold;
        text-transform: uppercase;
        white-space: pre;
    }

    .detail-value.other {
        flex-grow: 1;
        border-bottom: 1px dotted #ccc;
        padding-bottom: 2px;
        text-align: left;
        font-size: 1.0rem;
        color: #1108b7;
        font-weight: bold;
        text-transform: uppercase;
        white-space: pre;
    }

    .signature {
        text-align: right;
        margin-top: 15px;
    }

    .signature img {
        width: 100px;
        height: 40px;
    }

    .signature-label {
        font-size: 0.8em;
    }

    .card::before {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 20px;
        background: linear-gradient(to right, #ffeb3b, #ff9800);
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    }
</style>

<body>
    {{-- {{ $studentcr }} --}}

    <div class="container">
        <div class="card" id="idcard">
            <div class="header">
                <h1>LITTLE FLOWER SCHOOL</h1>
                <div class="header-details">
                    <div class="logo">
                        <img src="{{ asset('lfs_logo.png')}}" alt="Little Flower School Logo">
                    </div>
                    <div class="school-info">
                        <div class="english-medium">ENGLISH MEDIUM</div>
                        <div class="estd">Estd. 2019</div>

                    </div>
                </div>
                <div class="address">
                    Dayanagar Bahaliapara * Bhagwangola * MSD
                </div>
                <div class="contact">
                    Office Contact: 9064070076
                </div>
            </div>
            @php
            use SimpleSoftwareIO\QrCode\Facades\QrCode;
            $qrstring = url('studentcr-profile/'.$studentcr->id );
            @endphp

            <h2 align="center"></h2>
            
            <div class="photo-container">
                <div class="photo-placeholder-main">
                    <img src="{{ Storage::url($studentcr->studentdb->img_ref_profile) }}" alt="Image"
                        class="w-10 h-10 rounded-full">
                </div>
                <div class="photo-placeholder">
                    {!! QrCode::size(80)->generate($qrstring) !!}
                    {{-- <img src="{{ Storage::url($studentcr->studentdb->img_ref_profile) }}" alt="Image"
                        class="w-10 h-10 rounded-full"> --}}
                </div>
            </div>
            {{-- {{ $qrstring }} --}}
            <div class="details">
                <div class="detail-row">
                    <div class="name">NAME: </div>
                    <div class="detail-value"> {{ $studentcr->studentdb->name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Inst. Reg. No.:</div>
                    <div class="detail-value other">{{ $studentcr->studentdb->uuid_auto }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">C/O.: </div>
                    <div class="detail-value other"> {{ $studentcr->studentdb->fname }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">DOB:</div>
                    <div class="detail-value other"> {{date("d-m-Y", strtotime($studentcr->studentdb->dob)) }}</div>
                    <div class="detail-label">Gender:</div>
                    <div class="detail-value other"> {{ $studentcr->studentdb->ssex }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Class:</div>
                    <div class="detail-value other">{{ $studentcr->myclass->name }}</div>
                    <div class="detail-label">Sec:</div>
                    <div class="detail-value other">{{ $studentcr->section->name }}</div>
                    <div class="detail-label">Roll:</div>
                    <div class="detail-value other">{{ $studentcr->roll_no }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Address:</div>
                    <div class="detail-value other">{{ trim($studentcr->studentdb->vill1) }}, {{
                        trim($studentcr->studentdb->post) }} </div>
                    {{-- <div class="detail-value other">{{ trim($studentcr->studentdb->pstn) }},{{
                        trim($studentcr->studentdb->dist) }} </div> --}}

                </div>
                <div class="detail-row">
                    {{-- <div class="detail-label">Address:</div> --}}
                    {{-- <div class="detail-value other">{{ trim($studentcr->studentdb->vill1) }},{{
                        trim($studentcr->studentdb->post) }} </div> --}}
                    <div class="detail-value other">{{ trim($studentcr->studentdb->pstn) }}, {{
                        trim($studentcr->studentdb->dist) }}, {{ trim($studentcr->studentdb->pin) }} </div>

                </div>
                <div class="detail-row">
                    <div class="detail-label">Parents Mob:</div>
                    <div class="detail-value other">{{ trim($studentcr->studentdb->mobl1) }} </div>

                </div>
            </div>
            <div class="signature">
                
                <img src="{{ Storage::url('hm_sign.jpg')}}" alt="Signature" width="100" height="20">
                <div class="signature-label">Signature</div>
                <div class="signature-label">Head of Institution</div>
            </div>
        </div>
        

        {{-- <div class="card">
            <div class="header">
                <h1>LITTLE FLOWER SCHOOL</h1>
                <div class="header-details">
                    <div class="logo">
                        <img src="data:image/jpeg;base64,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"
                            alt="Little Flower School Logo">
                    </div>
                    <div class="school-info">
                        <div class="english-medium">ENGLISH MEDIUM</div>
                        <div class="estd">Estd. 2019</div>

                    </div>
                </div>
                <div class="address">
                    Dayanagar Bahaliapara * Bhagwangola * MSD
                </div>
                <div class="contact">
                    Office Contact: 9064070076
                </div>
            </div>
            <h2 align="center">Identity Card</h2>
            <div class="photo-container">
                <div class="photo-placeholder-main">xx</div>
                <div class="photo-placeholder"></div>
            </div>
            <div class="details">
                <div class="detail-row">
                    <div class="name">NAME:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Inst. Reg. No.:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">C/O.:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">DOB:</div>
                    <div class="detail-value"></div>
                    <div class="detail-label">Gender:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Class:</div>
                    <div class="detail-value"></div>
                    <div class="detail-label">Sec:</div>
                    <div class="detail-value"></div>
                    <div class="detail-label">Roll:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Address:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Parents Mob:</div>
                    <div class="detail-value"></div>
                </div>
            </div>
            <div class="signature">
                <img src="https://via.placeholder.com/100x40" alt="Signature">
                <div class="signature-label">Head of Institution</div>
            </div>
        </div> --}}



    </div>
    <div class="button-container">
        <button onclick="captureAndDownloadScreenshot()" class="bg-blue-500 text-white px-4 py-2 rounded">Download Id Card</button>
    </div>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        function captureAndDownloadScreenshot() {
            // Target the entire body or a specific element (e.g., document.getElementById("container"))
            // const element = document.body; // Uncomment this line to capture the entire body
            const element = document.getElementById("idcard"); // Replace with your element ID

            html2canvas(element).then(canvas => {
                // Create a download link
                const link = document.createElement('a');
                link.download = 'screenshot.png'; // File name
                link.href = canvas.toDataURL('image/png'); // Convert canvas to PNG
                link.click(); // Trigger download
            });
        }

            // Call the function (e.g., on button click or automatically)
        // captureAndDownloadScreenshot(); 
    </script>
</body>

</html>

</div>
