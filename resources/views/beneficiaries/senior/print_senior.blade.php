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
            .print-target {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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
        
            .genTinio {
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
                @apply font-lucidaCalligraphy;
            }

            .office {
                position: absolute;
                top: 1rem;
                left: 50%;
                transform: translateX(-50%);
                width: max-content;
                text-align: center;
            }

            .province {
                position: absolute;
                top: 2rem;
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
                width: 1.0in;
                height: 1.0in;
                margin-left: auto;
                display: block;
                margin-right: 10px;
            }

            .thumbMark-holder{
                width: 1.0in;
                height: 0.4in;
                margin-left: auto;
                display: block;
                margin-right: 3px;
            }

            .municipality{
                font-size: 9pt;
                @apply font-calibri font-bold
            }

            .fullname{
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
                margin: 3px;
            }
        
        }
    </style>

    <div class="py-5 h-screen">

        <div class="no-print p-4 flex justify-between">

            <div class="flex gap-x-3 items-center">
                <a 
                    href="{{route('beneficiary.index', ['tab' => 'senior'])}}"
                    class="">
                    <span>
                        <img src="{{asset('/images/icons/back.svg')}}" alt="" class="object-contain w-10 h-10">
                    </span>
                </a>

                <h1 class="text-2xl font-bold border-b-[3px] border-red-500">Print Senior Citizen ID</h1>
            </div>
            
            <div class="flex gap-2">
                <button class="bg-green-600 text-white px-4 py-2 rounded" id="print-btn">
                    Print
                </button>

                <button class="bg-gray-600 text-white px-4 py-2 rounded" id="switch-btn">
                    Switch to Back
                </button>
            </div>
            
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            <div class="font-['Times_New_Roman']">

                {{-- ================= FRONT ================= --}}
                <div class="w-full p-3 h-full front-id">
                    <div class="w-full grid grid-cols-2 gap-5 p-2 print:grid-cols-1">

                        @foreach($senior as $item)
                            {{-- id border --}}
                            <div 
                                class="id-border font-defaultSans bg-white w-full border border-x-2 border-y-2 border-black h-[20rem] px-2 py-1 print:ms-[-1.2rem]"
                                style="background-image: url('{{ asset('images/gen.tinio-bg.jpg') }}'); 
                                    background-size: cover; 
                                    background-position: center; 
                                    background-repeat: no-repeat;"
                            >

                                <div class="w-full grid grid-cols-[70%_30%] gap-3 items-start">

                                    
                                    <div class="w-full text-center"> 

                                        {{-- HEADER --}}
                                        <div class="flex p-1 print:mt-[-8px] gap-x-5 items-center">
                                            
                                            {{-- FLAG --}}
                                            <img src="{{ asset('images/logo/gt-logo.png') }}" class="h-[4rem] w-[4rem] genTinio">

                                            <div class="w-full text-center font-bold header text-sm">
                                                <p class="republic print:text-[8pt]">Republic of the Philippines</p>
                                                <p class="office print:text-[8pt]">Office of Senior Citizens Affairs</p>
                                                <p class="province print:text-[8pt]">Municipality of General Tinio</p>
                                            </div>
                                        </div>

                                        <div class="border-b-2 border-black pt-2 print:pt-3">
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
                                                    print:text-[7.5pt] text-[10pt]
                                                @elseif($nameLength > 27)
                                                    print:text-[9.5pt] text-[18px]
                                                @elseif($nameLength > 22)
                                                    print:text-[10pt] text-[16px]
                                                @elseif($nameLength > 20)
                                                    print:text-[12pt] text-[18px]
                                                @else
                                                    print:text-[10pt] text-[18px]
                                                @endif
                                            ">
                                                {{ $fullName }}
                                            </h1>
                                        </div>

                                        <p class="text-xs font-bold label">Name</p>

                                        
                                        <div class="border-b-2 border-black">
                                            @php
                                                $address = strtoupper($item->beneficiary->address->street->barangay->name);
                                                $addressLength = strlen($address);
                                            @endphp

                                            <h1 class="address font-bold capitalize
                                                @if($addressLength >= 30)
                                                    print:text-[6pt] text-[10px]
                                                @elseif($addressLength >= 27)
                                                    print:text-[6.5pt] text-[14px]
                                                @elseif($addressLength > 22)
                                                    print:text-[8.5pt] text-[12px]
                                                @elseif($addressLength > 20)
                                                    print:text-[9pt] text-[14px]
                                                @else
                                                    print:text-[10pt] text-[16px]
                                                @endif
                                            ">
                                                {{ $address }}
                                            </h1>
                                        </div>
                                        
                                        <p class="label font-bold text-xs">Address</p>

                                        <div class="flex justify-between items-center mt-2 print:mt-1 px-3">
                                            <div>
                                                <h1 class="border-b-2 border-black capitalize font-bold text-sm print:text-xs">June 12, 1958</h1>
                                                <p class="label font-bold text-xs">Date of Birth</p>
                                            </div>

                                            <div>
                                                <h1 class="border-b-2 border-black capitalize font-bold text-sm print:text-xs">67 y.o</h1>
                                                <p class="label font-bold text-xs">Age</p>
                                            </div>

                                            <div>
                                                <h1 class="border-b-2 border-black capitalize font-bold text-sm print:text-xs">April 13, 2026</h1>
                                                <p class="label font-bold text-xs">Date of Issue</p>
                                            </div>
                                        </div>

                                        <div class="mt-5 print:my-2">
                                            @php
                                                $fullName = strtoupper(
                                                    $item->beneficiary->first_name . ' ' .
                                                    $item->beneficiary->middle_name . ' ' .
                                                    $item->beneficiary->last_name
                                                );

                                                $nameLength = strlen($fullName);
                                            @endphp
                                            <h1 class="fullname font-bold capitalize border-b-2 border-black
                                                @if($nameLength >= 30)
                                                    print:text-[7.5pt] text-[10pt]
                                                @elseif($nameLength > 27)
                                                    print:text-[9.5pt] text-[18px]
                                                @elseif($nameLength > 22)
                                                    print:text-[10pt] text-[16px]
                                                @elseif($nameLength > 20)
                                                    print:text-[12pt] text-[18px]
                                                @else
                                                    print:text-[10pt] text-[18px]
                                                @endif
                                            ">
                                                {{ $fullName }}
                                            </h1>
                                            <p class="label font-bold text-xs">Printed Name and Signature</p>
                                        </div>


                                        
                                    </div>

                                    <div class="">

                                        <div class="w-[95%] border-2 border-black py-2 px-5 print:px-0 print:py-1 print:text-xs text-center font-bold">
                                            ID No. 7207
                                        </div>

                                        {{-- picture-holder --}}
                                        <div 
                                            class="picture-holder w-[95%] border mt-1 border-slate-800 border-x-2 border-y-2 h-[10rem] print:h-[5rem] bg-white"
                                        >
                                        </div>

                                        {{-- thumb mark-holder --}}
                                        <div class="w-[95%] flex flex-col items-center">
                                            <div 
                                                class="thumbMark-holder w-full mt-2 border-slate-800 h-[3rem] print:h-[2rem] bg-white"
                                            >
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold">Thumb mark</p>
                                            </div>
                                        </div>
                                        



                                    </div>

                                </div>

                                <div class="w-full text-center font-bold mt-2 print:mt-0">
                                    <p class="print:text-[9px] text-xs">THIS CARD IS NON-TRANSFERABLE AND VALID ANYWHERE IN THE COUNTRY</p>
                                </div>
                                
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- ================= BACK ================= --}}
                <div class="hidden w-full p-3 h-full back-id">
                    <div class="w-full grid grid-cols-2 gap-5 p-2 print:grid-cols-1">

                        @foreach($senior as $item)
                            <div 
                                class="id-border font-defaultSans bg-white w-full border border-x-2 border-y-2 border-black h-[20rem] px-2 py-1 print:ms-[-1.2rem]"
                                style="background-image: url('{{ asset('images/osca-bg.jpg') }}'); 
                                    background-size: cover; 
                                    background-position: center; 
                                    background-repeat: no-repeat;"
                            >

                                <div class="mt-5 px-5 print:mt-3 print:px-3 font-bold text-sm print:text-[7pt]">
                                    <h1 class="text-md print:text-[8pt]">BENEFITS and PRIVILEGES Under Republic Act NO. 9994</h1>
                                    <p>- Free medical/dental diagnostic & laboratory fee in all government facilities</p>
                                    <p>- 20% discount in purchase of medicine</p>
                                    <p>- 20% discount in Hotels, house and concert halls, etc</p>
                                    <p>- 20% discount medical & dental services diagnostic & laboratory fee in private &nbsp; &nbsp; facilities</p>
                                    <p>- 20% discount in fare for domestic air, sea travel and public land transportation</p>
                                </div>

                                <div class="mt-3 text-center font-bold text-xs print:text-[6pt]">
                                    <p>Only for the exclusive use of Senior Citizens;</p>
                                    <p>abuse of privileges is punishable by law;</p>
                                    <p>Person's & Corporation violating RA 9994 shall be penalized.</p>
                                </div>

                                <div class="flex justify-between px-5 mt-8">
                                    <div class="text-center">
                                        <h1 class="font-bold print:text-[8.5pt] uppercase">{{$senior_chairman->full_name}}</h1>
                                        <p class="text-sm font-semibold print:text-[7pt]">OSCA Chairman</p>
                                    </div>

                                    <div class="text-center">
                                        <h1 class="font-bold print:text-[8.5pt] uppercase">{{$mayor->full_name}}</h1>
                                        <p class="text-sm font-semibold print:text-[7pt]">Municipal Mayor</p>
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