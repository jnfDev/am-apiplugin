<script setup>
import { ref } from 'vue'

const newEmail = ref('')
const emit = defineEmits(['change'])
const props = defineProps({ emails: Array })

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
    <form @submit.prevent="addEmail">
        <input v-model="newEmail">
        <button>Add</button>    
    </form>

    <ul>
        <li v-for="email in emails" :key="email">
            {{ email }} <button @click="removeEmail(email)">Remove</button>    
        </li>
    </ul>
</template>