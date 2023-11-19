<template>
    <div class="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center" v-if="isOpen">
        <div class="bg-white w-9/12 h-[90%] md:h-auto overflow-y-auto m-auto p-7 rounded-md">
            <ion-icon @click="closeModal" class="cursor-pointer text-2xl mb-4" name="close-outline"></ion-icon>
            <slot name="content"></slot>
            <div class="flex flex-row items-center relative">
                <button v-if="btnSubmit" @click="btnSubmitFunc" type="button" class="mt-5 rounded-md px-3 py-3 bg-blue-500 text-white font-bold">
                    {{ btnText }}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        btnText: String,
        isOpen: Boolean,
        onClickClose: Boolean,
        btnSubmitFunc: Function,
        btnSubmit: Boolean,
    },
    data() {

    },
    methods: {
        closeModal() {
            // Emit an event to notify the parent component to close the modal
            this.$emit('close');
        },
    }
}
</script>
