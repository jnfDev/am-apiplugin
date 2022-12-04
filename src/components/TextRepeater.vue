<script setup>
import { ref } from 'vue'

const newEmail = ref('')
const emit = defineEmits(['change'])
const props = defineProps({ 
    emails: {
        type: Array,
        required: true,
    },
    isloading: {
        type: Boolean,
        default: false,
    }
})

const addEmail = () => {
    const { emails } = props
    emit('change', emails.concat(newEmail.value))
    newEmail.value = ''
}

const removeEmail = (email) => {
    const { emails } = props
    emit('change', emails.filter(e => e !== email))
}

</script>

<template>
    <div class="text-repeater" :class="{ loading: isloading }">
        <form @submit.prevent="addEmail">
            <input :disabled="(isloading || emails.length >= 5)" v-model="newEmail">
            <button :disabled="(isloading || emails.length >= 5)" >
                <span class="dashicons dashicons-insert"></span>
            </button>
        </form>
        <ul>
            <li v-for="email in emails" :key="email">
                {{ email }} 
                <button :disabled="isloading" @click="removeEmail(email)">
                    <span class="dashicons dashicons-remove"></span>
                </button>
            </li>
        </ul>
    </div>
</template>

<style scoped>

    button:disabled,
    button[disabled],
    input:disabled,
    input[disabled] {
        cursor: auto !important;
        opacity: 0.5;
    }

    li {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        background-color: rgb(230, 230, 230);
        padding-left: 10px;
        margin-bottom: 8px;
        border-radius: 4px;
    }

    li button {
        margin-left: auto !important;
    }

</style>