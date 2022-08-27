@props(['disparador'])

<div
     class="flex fixed z-50 top-0 h-full w-full items-center"
     x-show="{{ $disparador }}"
     x-on:click.self="{{ $disparador }}=false"
     x-on:keydown.escape.window="{{ $disparador }}=false"
     x-cloak
 >

     <div {{ $attributes->merge(['class' => 'm-auto bg-gray-500 shadow-2xl rounded-xl p-2']) }}>

         {{ $slot }}

     </div>

</div>
