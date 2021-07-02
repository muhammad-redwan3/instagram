<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="grid grid-cols-12 mt-7 gap-4">
        <div class="col-start-5 col-span-4">
            <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                {{__('followers:')}}
            </h3>

            @if ($following!=null && sizeof($following) >0)
                @foreach ($following as $follow)
                    <div class="flex flex-col mb-3">
                        <div class="flex flex-row justify-rounded">
                            <div class="flex flex-row">
                                <a href="/{{$follow->username}}" class="rounded-full h-10 w-10 mr-3">
                                    <img src="{{$follow->profile_photo_url}}" alt="">
                                </a>
                                <div class="flex flex-col self-center">
                                    <a href="/{{$follow->username}}" class="text-base hover::underline whitespace-nowrap">{{$follow->username}}</a>
                                    <h3 class="text-sm text-gray-500 truncate whitespace-nowarp" style="max-width:25ch">{{$follow->bio}}</h3>
                                </div>
                            </div>
                            @livewire('follow-button', ['profile_id' => $profile->id], key($profile->id))
                        </div>
                    </div>
                @endforeach
            @else
                <div class="my-10 text-center">
                    <p class="font-semibold">{{__('Nothing to show followers')}}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>