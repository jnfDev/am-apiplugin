<script setup>
defineProps({
    error: {
        type: String,
        required: true
    }
})
</script>

<template>
    <!-- Due to we are scaping the error variable 
        on the PHP side, we can make use of v-html more safety -->
    <div class="error" v-html="error"></div>
</template>

<style scoped>
    .error {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-left-width: 4px;
        margin: 0;
        box-shadow: 0 1px 1px rgb(0 0 0 / 4%);
        padding: 10px 12px;
        border-left-color: #dba617;
        margin-bottom: 20px;
    }
</style>