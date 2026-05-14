
    
@extends('layouts.app')


@section('title', 'Admin Dashboard')
@section('content')

    <div class="w-full grid gap-4 md:grid-cols-2 lg:grid-cols-3">

        <section 
            class="rounded-xl flex flex-col shadow-md p-5 bg-white"
        >   
            <div class="w-full flex items-center gap-x-20">
                <img src="{{asset('/images/icons/person.svg')}}" alt="Person Icon" class="object-contain w-20 h-auto">
                <span class="text-[50px] font-bold">{{$card_data['total_beneficiaries']}}</span>
            </div>
            <span class="w-full flex justify-center mt-1 text-[25px] font-bold">Total Beneficiaries</span>
        </section>
                
        <section 
            class="rounded-xl flex flex-col shadow-md p-5 bg-white"
        >   
            <div class="w-full flex items-center gap-x-20">
                <img src="{{asset('/images/icons/senior.png')}}" alt="Senior Icon" class="object-contain w-20 h-20">
                <span class="text-[50px] font-bold">{{$card_data['total_senior']}}</span>
            </div>
            <span class="w-full flex justify-center mt-1 text-[25px] font-bold">Total Senior</span>
        </section>

        <section 
            class="rounded-xl flex flex-col shadow-md p-5 bg-white"
        >   
            <div class="w-full flex items-center gap-x-20">
                <img src="{{asset('/images/icons/pwd.svg')}}" alt="PWD Icon" class="object-contain w-20 h-auto">
                <span class="text-[50px] font-bold">{{$card_data['total_pwd']}}</span>
            </div>
            <span class="w-full flex justify-center mt-1 text-[25px] font-bold">Total PWD</span>
        </section>

    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <!-- Barangay Chart -->
        <div class="bg-white p-4 rounded-xl shadow-md">
            <canvas id="superAdmin_barangayChart"></canvas>
        </div>

        <!-- Registration Line Chart -->
        <div class="bg-white p-4 rounded-xl shadow-md">
            <canvas id="registrationChart"></canvas>
        </div>

    </div>

    <div class="mt-6">
        <h1 class="text-xl font-bold">Recently Added</h1>

        <table class="w-full text-sm text-left border-collapse bg-[#F0F0F0] shadow-md mt-2">
            <thead class="text-gray-600 uppercase text-xs border-b">
                <tr class="bg-gray-50">
                    <th class="p-3">NAME</th>
                    <th class="p-3">TYPE</th>
                    <th class="p-3">CREATED BY</th>
                    <th class="p-3">DATE CREATED</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse($recent_activities as $activity)
                    <tr class="border-b hover:bg-gray-200">
                        <td class="p-3 uppercase">
                            {{$activity->last_name}} {{$activity->first_name}} {{$activity->middle_name}}
                        </td>
                        <td class="p-3 uppercase">
                            @if($activity->type === 'pwd')
                                PWD
                            @elseif($activity->type === 'senior')
                                Senior
                            @endif               
                        </td>
                        <td class="p-3 ">
                           <h1 class="uppercase">{{$activity->creator->name}}</h1> 
                           <p>{{ ucwords(str_replace('_', ' ', $activity->creator->role)) }}</p>
                        </td>
                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($activity->created_at)->format('m-d-Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
                            No result found.
                        </td>
                    </tr>
                    
                @endforelse


                
            </tbody>
        </table>

    </div>



    <script>
        const labels = @json($barangay_chart['labels']);
        const seniors = @json($barangay_chart['seniors']);
        const pwd = @json($barangay_chart['pwd']);

        const reg_labels = @json($registration_chart['labels']);
        const reg_values = @json($registration_chart['values']);
    </script>
@endsection


