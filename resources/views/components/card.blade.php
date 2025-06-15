<div>
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
        {{-- dynamic icon public\assets\icon\ --}}
        <div class="p-4 {{$color}} rounded-full mb-4">
            {{-- icon from assets/icon --}}
            <img src="{{asset('assets/icon/'.$icon)}}" alt="icon" class="w-10">
        </div>
        <h4 class="text-xl font-semibold text-gray-800 mb-3">{{$title}}</h4>
        <p class="text-gray-600">{{$description}}</p>
    </div>    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</div>
