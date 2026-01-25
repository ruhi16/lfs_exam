<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    
    <div class="flex font-sans shadow-lg m-8 border border-gray-200 rounded-lg">
        <div class="flex-none w-48 relative rounded-lg">
            <img src="{{ $prof_image_reference }}" alt="" class="absolute inset-0 w-full h-full object-cover"
                loading="lazy" />
        </div>
        <form class="flex-auto p-6">
            <div class="flex flex-wrap">
                <h1 class="flex-auto  font-semibold text-slate-900 text-4xl">
                    {{ $name }} ({{ $nickName }})
                </h1>
                <div class="text-lg font-semibold text-green-500">
                    Active
                </div>
                <div class="w-full flex-none text-sm font-bold text-slate-700 mt-2">
                    {{ $designaation }}, {{ $subject }}
                </div>
            </div>
            <div class="flex items-baseline mt-4 mb-6 pb-6 border-b border-slate-200">
                <div class="space-x-2 flex text-sm">
                    <label>
                        <input class="sr-only peer" name="size" type="radio" value="xs" checked />
                        <div
                            class="w-9 h-9 cursor-pointer rounded-lg flex items-center justify-center text-slate-700 peer-checked:font-semibold peer-checked:bg-slate-900 peer-checked:text-white hover:bg-slate-200">
                            CO
                        </div>
                    </label>
                    <label>
                        <input class="sr-only peer" name="size" type="radio" value="s" />
                        <div
                            class="w-9 h-9 cursor-pointer rounded-lg flex items-center justify-center text-slate-700 peer-checked:font-semibold peer-checked:bg-slate-900 peer-checked:text-white hover:bg-slate-200">
                            CO
                        </div>
                    </label>
                    <label>
                        <input class="sr-only peer" name="size" type="radio" value="m" />
                        <div
                            class="w-9 h-9 cursor-pointer rounded-lg flex items-center justify-center text-slate-700 peer-checked:font-semibold peer-checked:bg-slate-900 peer-checked:text-white hover:bg-slate-200">
                            AI
                        </div>
                    </label>
                    <label>
                        <input class="sr-only peer" name="size" type="radio" value="l" />
                        <div
                            class="w-9 h-9 cursor-pointer rounded-lg flex items-center justify-center text-slate-700 peer-checked:font-semibold peer-checked:bg-slate-900 peer-checked:text-white hover:bg-slate-200">
                            DS
                        </div>
                    </label>
                    <label>
                        <input class="sr-only peer" name="size" type="radio" value="xl" />
                        <div
                            class="w-9 h-9 cursor-pointer rounded-lg flex items-center justify-center text-slate-700 peer-checked:font-semibold peer-checked:bg-slate-900 peer-checked:text-white hover:bg-slate-200">
                            EH
                        </div>
                    </label>
                </div>
            </div>
            <div class="flex space-x-4 mb-6 text-sm font-medium">
                <div class="flex-auto flex space-x-4">
                    <button
                        class="h-10 px-6 font-semibold rounded-md bg-purple-500 text-white hover:border-purple-800 hover:bg-purple-900"
                        type="submit">
                        Like
                    </button>
                    <button
                        class="h-10 px-6 font-semibold rounded-md  border border-slate-200 text-slate-900 hover:border-slate-500 hover:bg-slate-200"
                        type="button">
                        Favorite
                    </button>
                </div>
                <button
                    class="flex-none flex items-center justify-center w-9 h-9 rounded-md text-slate-300 border border-slate-200"
                    type="button" aria-label="Like">
                    <svg width="20" height="20" fill="bg-red-500" aria-hidden="true">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                    </svg>
                </button>
            </div>
            <p class="text-sm text-slate-700">
                Feel Free to share your views.
            </p>
        </form>
    </div>
</div>