<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="max-w-4xlmy-0 mx-auto">
        <div class="grid grid-cols-12 mt-7 gap-4">

            @foreach ($posts as $post)
                <div class="post">
                    <a href="{{route('/posts/{{$post->id}}')}}" class="w-full h-full">
                        <img src="/storage/{{$post->image_path}}" alt="">
                    </a>
                </div>
            @endforeach
            <div class="col-start-5 col-span-4">
                <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                    {{__('Explore:')}}
                </h3>
    
               
            </div>
        </div>
    </div>
   
</x-app-layout>