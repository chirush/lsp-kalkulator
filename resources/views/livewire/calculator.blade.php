<div class="flex">
    <div class="p-2 mt-4 ml-4 w-[366px] rounded bg-gray-700">
        <div id="resultRow" class="p-2">
            <div class="w-[333px] h-[60px] bg-white rounded text-3xl flex items-bottom justify-end p-2">{{ $display }}</div>
        </div>
        <div id="firstRow" class="p-2 mt-[-5px]">
            <button class="w-[80px] bg-red-500 h-12 text-white rounded font-semibold" wire:click="getNumber('clear')">C</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-semibold" wire:click="getNumber('pom')">+/-</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-semibold" wire:click="getNumber('%')">%</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-semibold" wire:click="getOperator('/')">/</button>
        </div>
        <div id="secondRow" class="p-2 mt-[-10px]">
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(7)">7</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(8)">8</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(9)">9</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-semibold text-md" wire:click="getOperator('*')">X</button>
        </div>
        <div id="thirdRow" class="p-2 mt-[-10px]">
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(4)">4</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(5)">5</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(6)">6</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-bold text-xl" wire:click="getOperator('-')">–</button>
        </div>
        <div id="forthRow" class="p-2 mt-[-10px]">
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(1)">1</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(2)">2</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(3)">3</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-semibold text-xl" wire:click="getOperator('+')">+</button>
        </div>
        <div id="fifthRow" class="p-2 mt-[-10px]">
            <button class="w-[164px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber(0)">0</button>
            <button class="w-[80px] bg-gray-500 h-12 text-white rounded" wire:click="getNumber('.')">.</button>
            <button class="w-[80px] bg-blue-500 h-12 text-white rounded font-semibold text-lg" wire:click="calculation">=</button>
        </div>
    </div>
    <div class="p-2 mt-4 ml-4 w-[366px] rounded bg-gray-700">
        <div id="resultRow" class="p-2">
            @foreach ($history as $history)
            <button class="w-[333px] h-[40px] bg-white rounded text-xl flex items-bottom justify-end p-2 mt-2" wire:click="useHistory({{ $history->result }})">{{ $history->formula }} = {{ $history->result }}</button>
            @endforeach
        </div>
    </div>
</div>