@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')
    
    <style>
        @media print {

            body * {
                visibility: hidden;
            }

            .print-target, .print-target * {
                visibility: visible;
            }

            .no-print {
                display: none !important;
            }

            .print-target {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
            }
        
            .flag {
                width: 0.693in;
                height: 0.429in;
            }
            .pwd-logo {
                width: 0.561in;
                height: 0.484in;
            }
            .header {
                width: 2.24in;
                height: 0.36in;
                position: relative;
                font-size: 9pt !important; 
            }
            .bondpaper-border{
                @apply border-none
            }
            .republic {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: max-content;
                text-align: center;
            }

            .province {
                position: absolute;
                top: 1rem;
                left: 50%;
                transform: translateX(-50%);
                width: max-content;
                text-align: center;
            }

            .id-border {
                width: 4.03in; 
                height: 2.42in;
            }

            .id{
                white-space: nowrap;
                margin-left: auto;
                @apply font-bold;
                display: block;
            }
        
            .id-no-component{
                margin-right: -15px;
                font-size: 8.5pt;
                margin-top:-10px;
            }
            .id-number{
                @apply font-calibriBody;
                margin-right: -.3rem;
                font-size: 7.5pt;
            }
            
            .id-label{
                @apply font-arial font-bold;
                margin-right: -.5rem;
            }

            .extra{
                font-weight: 900;
            }
            .picture-holder{
                width: 1.1in;
                height: 1.1in;
                margin-left: auto;
                display: block;
                margin-right: 3px;
            }

            .municipality{
                font-size: 9pt;
                @apply font-calibri font-bold
            }
            .fullname{
                font-size: 11pt;
                white-space: nowrap;
                @apply font-calibri;
            }
            .label{
                font-size: 8pt;
                @apply font-calibri font-bold;
            }
            .signature-component{
                margin-top: 1rem;
            }

            .signature-label{
                margin-top: -5px;
                font-family: 'Noto Nastaliq Urdu', 'Scheherazade New', serif; /* font sa uighur*/
            }
            .valid-label{
                margin-top: -5px;
                font-size: 5pt;
                font-family: 'Noto Nastaliq Urdu', 'Scheherazade New', serif; /* font sa uighur*/
            }
            
            .qr-container svg {
                width: 1.3in !important;
                height: 1.3in !important;
                margin-top: 2px;
            }

            @page {
                size: auto;
                margin: 23px;
            }
        
        }
    </style>

    <div class="py-5 h-screen">

        <div class="no-print p-4 flex justify-between items-center">

            <div class="flex gap-x-3 items-center">
                <a 
                    href="{{route('beneficiary.index', ['tab' => 'pwd'])}}"
                    class="">
                    <span>
                        <img src="{{asset('/images/icons/back.svg')}}" alt="" class="object-contain w-10 h-10">
                    </span>
                </a>

                <h1 class="text-2xl font-bold border-b-[3px] border-red-500">Print PWD ID</h1>
            </div>
            
            <div class="flex gap-2 items-center">
                <button class="bg-green-600 text-white px-4 py-2 rounded" id="print-btn">
                    Print
                </button>

                <button class="bg-gray-600 text-white px-4 py-2 rounded" id="switch-btn">
                    Switch to Back
                </button>
            </div>
            
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            <div class="">

                {{-- ================= FRONT ================= --}}
                <div class="w-full p-3 h-full front-id">
                    <div class="w-full grid grid-cols-2 gap-5 p-2 print:grid-cols-1">

                        @foreach ($pwd as $item)
                            {{-- id border --}}
                            <div class="id-border font-defaultSans bg-white w-full border border-x-2 border-y-2 border-black h-[20rem] p-3 print:ms-[-1.2rem]">

                                {{-- HEADER --}}
                                <div class="w-full flex p-1 print:mt-[-8px] justify-between items-center">
                                    
                                    {{-- FLAG --}}
                                    <img src="{{ asset('images/logo/phil.png') }}" class="h-[4rem] w-[7.3rem] flag">

                                    {{-- HEADER --}}
                                    <div class="text-center text-sm font-bold header">
                                        <p class="republic">REPUBLIC OF THE PHILIPPINES</p>
                                        <p class="province">Province of Nueva Ecija</p>
                                    </div>

                                    {{-- PWD LOGO --}}
                                    <img src="{{ asset('images/logo/pwdlogo.png') }}" class="h-[4rem] w-[5rem] pwd-logo">
                                </div>

                                <div class="w-full flex font-defaultSans">
                                    <div class="w-full pt-3 text-center bg-red print:pt-1">
                                        <div class="pb-4 px-2 ">
                                            <p class="font-bold font-defaultSans text-sm municipality">
                                                Municipality
                                                of 
                                                <span class="underline">
                                                    GENERAL
                                                    TINIO
                                                </span>
                                            </p>

                                            <div class="border-b-2 border-black pt-2">
                                                @php
                                                    $fullName = strtoupper(
                                                        $item->beneficiary->first_name . ' ' .
                                                        $item->beneficiary->middle_name . ' ' .
                                                        $item->beneficiary->last_name
                                                    );

                                                    $nameLength = strlen($fullName);
                                                @endphp
                                                <h1 class="fullname font-bold capitalize
                                                    @if($nameLength >= 30)
                                                        print:text-[9.5pt] text-[10pt]
                                                    @elseif($nameLength > 27)
                                                        print:text-[11.5pt] text-[18px]
                                                    @elseif($nameLength > 22)
                                                        print:text-[12pt] text-[16px]
                                                    @elseif($nameLength > 20)
                                                        print:text-[14pt] text-[18px]
                                                    @else
                                                        print:text-[14pt] text-[20px]
                                                    @endif
                                                ">
                                                    {{ $fullName }}
                                                </h1>
                                            </div>

                                            <p class="text-xs font-bold">Name</p>

                                            <div class="border-b-2 border-black">
                                                @php
                                                    $disability = strtoupper($item->disability_type);
                                                    $disabilityLength = strlen($disability);
                                                @endphp

                                                <h1 class="disability font-bold capitalize
                                                    @if($disabilityLength >= 30)
                                                        print:text-[8pt] text-[14px]
                                                    @elseif($disabilityLength >= 27)
                                                        print:text-[8.5pt] text-[18px]
                                                    @elseif($disabilityLength > 22)
                                                        print:text-[10.5pt] text-[16px]
                                                    @elseif($disabilityLength > 20)
                                                        print:text-[11pt] text-[18px]
                                                    @else
                                                        print:text-[12pt] text-[20px]
                                                    @endif
                                                ">
                                                    {{ $disability }}
                                                </h1>
                                            </div>
                                            
                                            <p class="label font-bold text-xs">Type of Disability</p>

                                            {{-- SIGNATURE COMPONENT --}}
                                            <div class="signature-component mt-10 print:pt-2 @if ($disabilityLength >= 27) print:pt-4 @endif">
                                                <div class="border-t-2 border-black">

                                                    <p class="signature-label font-bold print:text-[9pt] print:pt-[1pt]">
                                                        Signature/Thumb mark
                                                    </p>

                                                    <p class="valid-label text-xs bottom-0 print:pt-1.5">
                                                        VALID
                                                        ANYWHERE
                                                        IN
                                                        THE
                                                        PHILIPPINES
                                                    </p>


                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="id w-[13rem] h-[15rem] text-center">
                                        {{-- picture-holder --}}
                                        <div class="picture-holder w-full border mt-4 border-slate-800 border-x-2 border-y-2 h-[10rem] print:h-[7rem]"></div>

                                        <div class="id-no-component">   
                                            <p class="text-xs pt-3 underline decoration-2 font-bold font-calibriBody print:font-bold id-number">
                                                {{$item->pwd_id_number}}
                                            </p>
                                            <p class="text-xs font-arial font-bold id-label">ID NO.</p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            @endforeach


                        </div>

                    </div>

                    {{-- ================= BACK ================= --}}
                    <div class="hidden w-full p-3 h-full back-id">

                        <div class="print:ms-4 w-full grid grid-cols-2 gap-5 p-2 print:grid-cols-1">

                            @foreach ($pwd as $item)
                                {{-- id border --}}
                                <div class="id-border w-full font-defaultSans bg-white border border-x-2 border-y-2 border-black h-[20rem] p-2 print:ms-[-2.3rem]">
                                        
                                    <div class="w-full flex ms-1">
                                        <div class="w-full">
                                            <p class="print:text-[8pt] print:font-bold font-bold">
                                                Address: 
                                                <span class="underline decoration-1.5 underline-offset-4 w-full">
                                                    {{ $item->beneficiary->address->street->barangay->name }}
                                                </span>
                                            </p>

                                            <p class="print:text-[8pt] print:font-bold font-bold">
                                                Date of Birth:
                                                <span class="underline decoration-1.5 underline-offset-4 w-full">
                                                    {{ $item->beneficiary->birthdate 
                                                    ? \Carbon\Carbon::parse($item->beneficiary->birthdate)->format('F d, Y') 
                                                    : 'N/A' }}
                                                </span>
                                            </p>

                                            <p class="print:text-[8pt] print:font-bold font-bold">
                                                Date Issue:
                                                <span class="underline decoration-1.5 underline-offset-4 w-full">
                                                    {{  $item->date_id_issued
                                                    ? \Carbon\Carbon::parse($item->date_id_issued)->format('F d, Y') 
                                                    : 'N/A' }}
                                                </span>
                                            </p>

                                        </div>

                                        <div class="w-2/6 print:text-[9pt]">
                                            <p class="print:font-bold font-bold">
                                                Sex: 
                                                <span class="underline w-full underline-offset-2">
                                                    {{ $item->beneficiary->gender }}
                                                </span>
                                            </p>
                                            <p class="print:font-bold font-bold">
                                                Blood Type:
                                                <span class="underline w-full underline-offset-2">
                                                    {{ $item->blood_type }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="w-full text-center pt-1">
                                        <h1 class="print:text-[8pt] font-bold">
                                            IN CASE OF EMERGENCY
                                        </h1>
                                    </div>

                                    <div class="w-full flex justify-between print:text-[8pt] print:leading-tight">

                                        <p class="print:font-bold font-bold">
                                            Name: 
                                            <b class="w-full font-bold underline decoration-1.5 underline-offset-4">
                                                {{ $item->guardian_name }}
                                            </b>
                                        </p>

                                        <div class="flex justify-start ms-19">
                                            <p class="print:font-bold font-bold">
                                                Contact No:  
                                                <span class="contact_number w-full underline decoration-1.5 underline-offset-2">
                                                    ( {{ $item->beneficiary->contact_number }} )
                                                </span>
                                            </p>
                                        </div>

                                    </div>

                                    <div class="w-full flex">
                                        <div class="w-full text-[10px] text-center mt-2 print:mt-2">
                                            <p class="print:text-[5pt] print:leading-tight w-[85%] print:w-[90%]">
                                                THE HOLDER OF THIS
                                                CARD IS A PERSON
                                                DISABILITY AND IS
                                                ENTITLED TO DISCOUNT
                                                ON MEDICAL & DENTAL
                                                SERVICES, PURCHASE
                                                OF MEDICINES. BASIC
                                                COMMODITIES,
                                                TRANSPORTATION,
                                                ADMISSION FEES IN
                                                ALL ESTABLISHMENTS
                                                AND EDUCATIONAL
                                                ASSISTANCE
                                                AUTHORIZED BY R.A.
                                                9442 AND ITS
                                                IMPLEMENTING RULES &
                                                REGULATIONS. ANY VIOLATION
                                                
                                            </p>

                                            <p class="print:text-[6pt] print:font-bold font-bold w-[80%] print:w-[90%]">
                                                THIS CARD IS
                                                NON-TRANSFERRABLE
                                            </p>

                                            <div class="mt-10 text-center text-xs w-[80%] print:mt-10 print:w-[90%]">
                                                <b>Sherry Ann D. Bolisay</b>
                                                <p>Municipal Mayor</p>
                                            </div>

                                        </div>
                                        
                                        <div class="w-2/6 text-center">
                                            <div class="qr print:ml-[-15px]">
                                                {{-- Qr code  --}}
                                                @if($item->qr_link)
                                                    <div class="qr-container">
                                                        {!! QrCode::size(150)->generate($item->qr_link) !!}
                                                    </div>
                                                @endif
                                            </div>

                                            <p class="text-[10px] print:text-[6pt] print:mt-[-1px]">
                                                VALID FOR 5 YEARS
                                            </p>

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>


                    </div>

            </div>
            
            
        </div>



    </div>
    

    




@endsection