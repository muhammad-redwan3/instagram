<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="grid grid-cols-12 mt-7 gap-4">
        <div class="col-start-5 col-span-4">
            <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                {{__('follow requests:')}}
            </h3>
            @if ($requsets!=null && sizeof($requsets) >0)
                @foreach ($requsets as $req)
                    <div class="flex flex-col mb-3">
                        <div class="flex flex-row justify-rounded">
                            <div class="flex flex-row">
                                <a href="/{{$req->username}}" class="rounded-full h-10 w-10 mr-3">
                                    <img src="{{$req->profile_photo_url}}" alt="">
                                </a>
                                <div class="flex flex-col self-center">
                                    <a href="/{{$req->username}}" class="text-base hover::underline whitespace-nowrap">{{$req->username}}</a>
                                    <h3 class="text-sm text-gray-500 truncate whitespace-nowarp" style="max-width:25ch">{{$req->bio}}</h3>
                                </div>
                            </div>
                            @livewire('follow-button', ['profile_id' => $req->id], key($req->id))
                        </div>
                    </div>
                @endforeach
            @else
                <div class="my-10 text-center">
                    <p class="font-semibold">{{__('Nothing to show follow requests')}}</p>
                </div>
            @endif
            <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                {{__(' peding sent follow :')}}
            </h3>
            @if ($pendings!=null && sizeof($pendings) >0)
                @foreach ($pendings as $peding)
                    <div class="flex flex-col mb-3">
                        <div class="flex flex-row justify-rounded">
                            <div class="flex flex-row">
                                <a href="/{{$peding->username}}" class="rounded-full h-10 w-10 mr-3">
                                    <img src="{{$peding->profile_photo_url}}" alt="">
                                </a>
                                <div class="flex flex-col self-center">
                                    <a href="/{{$peding->username}}" class="text-base hover::underline whitespace-nowrap">{{$peding->username}}</a>
                                    <h3 class="text-sm text-gray-500 truncate whitespace-nowarp" style="max-width:25ch">{{$peding->bio}}</h3>
                                </div>
                            </div>
                            @if ($profile->status == 'private')
                            @livewire('accept-follow', ['profile_id' => $peding->id], key($peding->username))
                            @endif
                            
                            @livewire('follow-button', ['profile_id' => $peding->id], key($peding->id))
                        </div>
                    </div>
                @endforeach
            @else
                <div class="my-10 text-center">
                    <p class="font-semibold">{{__('Nothing to show peding sent follow')}}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>