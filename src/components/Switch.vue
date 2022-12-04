<script setup>
const props = defineProps({
    value: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    }
})

const emit = defineEmits(['onChange'])

const onClick = () => {
    if (props.disabled) {
        return;
    }

    emit('onChange', ! props.value)
}

</script>

<template>
    <div class="switch" :class="{on: value}" @click="onClick"></div>
</template>


<style scoped>
    .switch {
        cursor: pointer;
        position: relative;
        border-radius: 11px;
        width: 38px;
        height: 22px;
        background-color: #CCCCCC;
        -webkit-transition: all .1s ease-in-out;
        -moz-transition: all .1s ease-in-out;
        -ms-transition: all .1s ease-in-out;
        transition: all .1s ease-in-out;
    }

    .switch:hover {
        outline: 2px solid #CCCCCC;
        outline-offset: 1px;
    }

    .switch.on:hover {
        outline: 2px solid #00A32A;
        outline-offset: 1px;
    }

    .switch.on {
        background-color: #00A32A;
    }

    .switch.on::before {
        left: 18px;
    }

    .switch::before {
        position: absolute;
        content: "";
        left: 2px;
        top: 2px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #fff;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
</style>