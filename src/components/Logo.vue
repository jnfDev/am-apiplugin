<script setup>
import { computed } from 'vue'

const logoUrl = computed(() => {        
    const { assetsUrl } = AmAdminVars;
    return `${assetsUrl}/images/logo.svg` 
})
</script>

<template>
    <span class="am-logo">
        <img :src="logoUrl" alt="Plugin Logo">
    </span>
</template>

<style scoped>

.am-logo {
        display: inline-block;
        background-color: #0E1B3C;
        width: 52px;
        height: 52px;
        margin-right: 8px;
    }

.am-logo img { 
    width: 100%;
}
</style>