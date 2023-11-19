<template>
    <div class="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center">
        <div class="bg-white w-9/12 py-10 h-[90%] flex flex-col justify-center md:h-auto overflow-y-auto m-auto p-7 rounded-2xl text-center">
            <p class="text-2xl">{{ text }}</p>
            <div class="flex flex-row justify-center items-center mt-10">
                <button @click="confirmFunc" class="bg-green-500 text-white px-5 py-2 mr-3 text-lg">Ya</button>
                <button @click="cancelFunc" class="bg-red-500 text-white px-3 py-2 text-lg">Batal</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['text', 'isConfirm'],
    methods: {
        confirmFunc() {
            this.$emit('confirmed');
        },
        cancelFunc() {
            this.$emit('canceled');
        }
    }
}
</script>
