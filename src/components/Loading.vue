<script setup>
import Logo from './Logo.vue'
import { __ } from '../i18n'
</script>

<template>
    <div class="loading">
        <Logo /> <span>{{ __('Loading...') }}</span>
    </div>
</template>

<style scoped>

    .loading {
        width: 100%;
        padding-top: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40vh;
    }

    .loading span {
        animation-name: loading;
        animation-duration: 0.5s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .am-logo {
        animation-name: loading-logo;
        animation-duration: 0.5s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-direction: alternate;
    }

    @keyframes loading-logo {
        from { 
            background-color: rgb(174, 174, 174);
        }
        to {
            background-color: #0E1B3C;
        }
    }

    @keyframes loading {
        from {
            opacity: 0.5;
        }

        to {
            opacity: 1;
        }
    }

</style>