<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="grid grid-cols-12 mt-7 gap-4">
        <div class="col-start-3 col-span-6">
            @forelse ($posts as $post)
                <div class="flex flex-col border border-solid border-gray-300 mb-14 bg-white">
                    <div class="flex flex-row p-3 border border-solid border-gray-300 items-center">
                        <a href="/{{$post->user->username}}">
                        <img src="{{$post->user->profile_photo_url}}" alt="" class="rounded-full h-12 w-12 mr-3"></a>

                        <a href="/{{$post->user->username}}" class="hover:underline">{{$post->user->username}}</a>
                    </div>

                    <div>
                        <a href="/posts/{{$post->id}}"> <img src="/storage/{{$post->image_path}}" alt=""></a>
                    </div>
                    <div class="flex flex-row items-center mt-2">
                        @livewire('like-button', ['post_id' => $post->id], key($post->id))
                    </div>
                    <div class="border-b border-solid border-gray-200 pl-4 pb-1">
                        <div class="mr-7 mb-2">
                            <a href="/{{$post->user->username}}" class="font-bold text-base hover:underline">{{$post->user->username}}</a>
                            <span>{{$post->post_caption}}</span>
                        </div>
                        @foreach ($post->comments as $comment)
                            <div class="mr-5">
                                <a href="/{{$comment->user->username}}" class="font-bold hover:underline">
                                    {{$comment->user->username}}
                                </a>
                                <span>{{$comment->comment}}</span>
                            </div>
                        @endforeach
                        <div class="text-gray-500 text-xs">
                            {{$post->created_at->format('M j o')}}
                        </div>
                    </div>
                    <div class="p-4">
                        <form action="/comments" method="POST" autocomplete="off">
                            @csrf
                            <div class="flex flex-row items-center justify-betweent">
                                <input class="w-full outline-none p-4" type="text" id="{{$post->id}}" placeholder="{{__('add comment')}}" name="comment">
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <button class="text-blue-500 font-semibold hover:text-blue-700" type="submit">{{__('post')}}</button>

                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="m-10">
                    <p class="font-smibold">{{__('no posts')}}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>