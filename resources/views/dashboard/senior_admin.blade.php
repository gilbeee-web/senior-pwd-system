@extends('layouts.app')


@section('title', 'Admin Dashboard')
@section('content')

    <div class="w-full grid gap-4 md:grid-cols-2 lg:grid-cols-3">

        <section 
            class="rounded-xl flex flex-col shadow-md p-5 bg-white"
        >   
            <div class="w-full flex items-center gap-x-20">
                <img src="{{asset('/images/icons/senior.png')}}" alt="Person Icon" class="object-contain w-20 h-auto">
                <span class="text-[50px] font-bold">{{ $data['card_data']['total'] }}</span>
            </div>
            <span class="w-full flex justify-center mt-1 text-[25px] font-bold">Total Senior</span>
        </section>
                
        <section 
            class="rounded-xl flex flex-col shadow-md p-5 bg-white"
        >   
            <div class="w-full flex items-center gap-x-20">
                <img src="{{asset('/images/icons/male.png')}}" alt="Male Icon" class="object-contain w-20 h-20">
                <span class="text-[50px] font-bold">{{ $data['card_data']['total_male'] }}</span>
            </div>
            <span class="w-full flex justify-center mt-1 text-[25px] font-bold">Total Male</span>
        </section>

        <section 
            class="rounded-xl flex flex-col shadow-md p-5 bg-white"
        >   
            <div class="w-full flex items-center gap-x-20">
                <img src="{{asset('/images/icons/female.png')}}" alt="PWD Icon" class="object-contain w-20 h-auto">
                <span class="text-[50px] font-bold">{{ $data['card_data']['total_female'] }}</span>
            </div>
            <span class="w-full flex justify-center mt-1 text-[25px] font-bold">Total Female</span>
        </section>

    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <!-- Barangay Chart -->
        <div class="bg-white p-4 rounded-xl shadow-md">
            @if($current_user->role === 'senior_admin')
                <h1 class="text-gray-500 font-bold text-xs">
                    Senior Citizen per Barangay
                </h1>

            @elseif($current_user->role === 'barangay_senior_admin')
                <h1 class="text-gray-500 font-bold text-xs">
                    Senior Citizen per Street
                </h1>
            @endif
            <canvas id="senior_barangayChart"></canvas>
        </div>

        <!-- Registration Line Chart -->
        <div class="bg-white p-4 rounded-xl shadow-md">
            <canvas id="registrationChart"></canvas>
        </div>

    </div>

    <div class="mt-6">
        <h1 class="text-xl font-bold">Recently Added</h1>

        <table class="w-full text-sm text-center border-collapse bg-[#F0F0F0] shadow-md mt-2">
            <thead class="text-gray-600 uppercase text-xs border-b">
                <tr class="bg-gray-50">
                    <th class="p-3">NAME</th>
                    <th class="p-3">CREATED BY</th>
                    <th class="p-3">DATE CREATED</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse($data['recent_activities'] as $activity)
                    <tr class="border-b hover:bg-gray-200">
                        <td class="p-3">{{$activity->last_name}}</td>
                        <td class="p-3">{{$activity->creator->name}}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($activity->created_at)->format('F d, Y \a\t g:ia') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
                            No result found.
                        </td>
                    </tr>
                    
                @endforelse


                
            </tbody>
        </table>

    </div>

    <script>
        const labels = @json($data['barangay_chart']['labels']);
        const values = @json($data['barangay_chart']['values']);

        console.log("Values: ", values);
        console.log("Labels: ", labels);

        const reg_labels = @json($data['registration_chart']['labels']);
        const reg_values = @json($data['registration_chart']['values']);
    </script>
@endsection