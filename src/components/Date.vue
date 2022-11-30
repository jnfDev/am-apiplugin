<script setup>
import { computed } from 'vue'

const props = defineProps({ 
    timestamp: {
        type: Number,
        required: true
    }, 
    humandate: {
        type: Boolean,
        default: true
    } 
})

const date = computed(() => {
    const { humandate, timestamp } = props

    if (!humandate) {
        return timestamp
    }

    return new Date(timestamp * 1000).toLocaleDateString()
} )

</script>

<template>
    {{ date }}
</template>