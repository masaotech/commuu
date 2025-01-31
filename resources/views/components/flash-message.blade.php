@props(['message', 'timeout', 'borderColor', 'backGroundColor', 'textColor'])

<p x-data="{ show: true }" x-show="show" x-transition.duration.200ms x-init="setTimeout(() => show = false, {{ $timeout }})"
    class="flash-messege my-1 content-center rounded border-2 {{ $borderColor }} {{ $backGroundColor }} px-4 py-1 text-sm {{ $textColor }}">
    <span class="flex justify-between">
        <span class="py-2">{{ $message }}</span>
        <button class="cursor-pointer p-2" onclick="this.closest('.flash-messege').classList.add('hidden');">
            <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                style="width: 10px; height: 10px; opacity: 1;" xml:space="preserve">
                <style type="text/css">
                    .st0 {
                        fill: #888;
                    }
                </style>
                <g>
                    <polygon class="st0"
                        points="512,52.535 459.467,0.002 256.002,203.462 52.538,0.002 0,52.535 203.47,256.005 0,459.465 
                            52.533,511.998 256.002,308.527 459.467,511.998 512,459.475 308.536,256.005">
                    </polygon>
                </g>
            </svg>
        </button>
    </span>
</p>
