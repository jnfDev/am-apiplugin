<script setup>
    import { ref } from 'vue'
    import { storeToRefs } from 'pinia'
    import { useSettingStore } from '../stores/settings'

    import TextRepeater from '../components/TextRepeater.vue'

    const settingStore = useSettingStore()
    const { numrows, emails, humandate } = storeToRefs(settingStore)

    const loading = ref(false)
    const error = ref(false)

    const onChange = async (settingName, settingValue) => {
        try {
            loading.value = true
            error.value = false

            await settingStore.update(settingName, settingValue)

        } catch (e) {
            console.log(e.message);
            error.value = e.message
            
        } finally {
            loading.value = false 
        }
    }

</script>


<template>
    <h1>Settings</h1>
    
    <div v-if="error">
        {{ error }}
    </div>

    <div v-if="loading">
        Loading...
    </div>
    
    <div>
        <label for="numrows">Rows Number</label>
        <input type="number" min="1" max="5" id="numrows" :value="numrows" @change="(e) => onChange('numrows', e.target.value)">
    </div>

    <div>
        <label for="humandate">Humandate</label>
        <input type="checkbox" id="humandate" :checked="humandate" @change="(e) => onChange('humandate', e.target.checked)" >
    </div>

    <div>
        <label for="emails">Emails</label>
        <TextRepeater :emails="emails" @change="(emails) => onChange('emails', emails)" />
    </div>

</template>