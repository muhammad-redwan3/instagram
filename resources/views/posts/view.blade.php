<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="grid grid-cols-5 mt-7 gap-4">
        <div class="col-start-2 col-span-3 border border-solid boder-gray-300">
            <div class="grid grid-cols-5">
                <div class="col-span-3">
                    <div class="flex justify-center">
                        <img src="/storage/{{$post->image_path}}" alt="" id="postImage" style="max-height: 85vh">
                    </div>
                </div>
                <div class="col-span-2 bg-white flex flex-col">
                    <div class="flex flex-row p-3 border-b border-solid border-gray-300 items-center justify-between" id="sec1">
                        <div class="flex flex-row items-center">
                            <img class="rounded-full h-10 w-10 mr-3" src="{{$post->user->profile_photo_url}}" alt="">

                            <a class="font-bold hover:underline"
                            href="/{{$post->user->username}}">{{$post->user->username}}</a>
                        </div>
                        
                        
                            {{-- @if (auth()->user()->id==$post->user_id) --}}

                            @can('update', $post)
                                
                          
                            <div class="text gray-500">
                                <a href="/posts/{{$post->id}}/edit">
                                <i class="far fa-edit"></i>
                                </a>
                                <span class="font-bold mx-2"></span>

                                <form class="inline-block" action="{{route('posts.destroy',$post->id)}}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('are your sure')">
                                    <i class="fa fa-trash"></i>
                                </button>
                                </form>
                            </div>
                            @endcan

                           
                            @cannot('update', $post)
                            <div>
                                @livewire('follow-button', ['profile_id' => $post->user->id], key($post->id))
                            </div> 
                            @endcannot
                  
                    </div>
                    <div class="border border-b border-solid border-gray-300 h-full">
                        <div class="grid grid-cols-5 overflow-y-auto" id="commentarea">
                            <div class="col-span-1 m-3">
                                <img src="{{$post->user->profile_photo_url}}" alt="" class="rounded-full h-10 w-10">
                            </div>
        
                            <div class="col-span-4 mt-5 mr-3">
                                <a  class="font-bold hover:underline" 
                                href="/{{$post->user->username}}">{{$post->user->username}}</a>
                                <span>{{$post->post_caption}}</span>
                            </div>

                            @foreach ($post->comments as $comment)
                       
                            <div class="col-span-1 m-3">
                                <img src="{{$comment->user->profile_photo_url}}" alt="" class="rounded-full h-9 w-9">
                            </div>
                            <div class="col-span-4 mt-5 mr-3">
                                <a class="font-bold hover:underline"  href="/{{$comment->user->username}}">{{$comment->user->username}}</a>
                                <span>{{$comment->comment}}</span>
                                <div class="text-gray-500 text-xs">{{$comment->created_at->format('M j o ')}}
                                {{-- @if (auth()->user()->id == $comment->user_id) --}}
                                @can('update', $comment)
                                    <a href="/comments/{{$comment->id}}/edit" class="text-xs ms-2">
                                    <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                   
                                    
                                    @can('delete',$comment)
                                        <form class="inline-block" action="{{route('comments.destroy',$comment->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
            
                                            <button type="submit" onclick="return confirm('delete comment')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        
                                        </form>
                                    @endcan
                                </div>
                            </div>
                         
                        @endforeach
                        </div>

                       
                    </div>

                    <div class="flex flex-col" id="sec3">
                        @livewire('like-button', ['post_id' => $post->id], key($post->id))
                        <div class="border-b border-solid border-gray-300 pl-4 pb-1 text-xs">
                            {{$post->created_at->format('M j o')}}
                        </div>
                    </div>
                    @if (Auth::check())
                    <div class="p-4" id="sec4">
                        <form action="/comments" method="POST" autocomplete="off">
                            @csrf
                            <div class="flex flex-row items-center justify-between">
                                <input class="w-full outline-none border-none p-1" type="text" id="comment" placeholder="{{__('Add comment')}}" name="comment" autofocus>
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <button class="text-blue-500 font-semibold hover:text-blue-700" type="submit">{{__('post')}}</button>
                            </div>
                        </form>                   
                    @else
                       <a href="/{{route('login')}}" class="text-blue-500 text-sm">{{__('log in')}}</a> 
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>