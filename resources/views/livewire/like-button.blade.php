<div class="flex flex-col items-start pl-4 pb-1">
    <div class="flex flex-row items-center">
        <button class="text-sm mr-2 focus:outline-none" wire:click="Togglelike({{$post_id}})">
            <i class="{{$isliked ? "fas text-red-500" : "far"}} fa-heart"></i>
        </button>
        <button class="text-sm mr-2 focus:outline-none"><i class="far fa-comment"></i></button>
        <button class="text-sm mr-2 focus:outline-none"><i class="far fa-share-square"></i></button>
    </div>
    <span class="text-sm">{{__('liked by ')}} {{$likeCount}}</span>
</div>
