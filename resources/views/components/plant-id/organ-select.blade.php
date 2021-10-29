<div>
    <div class="grid grid-cols-1 mb-5 mx-7">
        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold text-center">Select an Organ</label>
        <select {{ $attributes }}
            class="text-base py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">

            <option value="">
                --Select--
            </option>

            <option value="bark">
                Bark
            </option>

            <option value="leaf">
                Leaf
            </option>

            <option value="fruit">
                Fruit
            </option>

            <option value="flower">
                Flower
            </option>

        </select>
    </div>
</div>
