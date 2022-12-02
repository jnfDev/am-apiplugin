<script setup>
    import { ref } from 'vue'
    import { storeToRefs } from 'pinia'
    import { useSettingStore } from '../stores/settings'

    import Error from '../components/Error.vue'
    import TextRepeater from '../components/TextRepeater.vue'

    const settingStore = useSettingStore()
    const { numrows, emails, humandate } = storeToRefs(settingStore)

    const loading = ref({
        numrows: false,
        emails: false,
        humandate: false
    })
    const error = ref(false)

    const onChange = async (settingName, settingValue) => {
        try {
            loading.value[settingName] = true
            error.value = false

            await settingStore.update(settingName, settingValue)

        } catch (e) {
            console.log(e.message);
            error.value = e.message
            
        } finally {
            loading.value[settingName] = false
        }
    }
</script>

<template>
    <Error v-if="error" :error="error" /> 

    <h1>Table Settings</h1>

    <div class="setting-wrapper" :class="{ loading: loading['numrows'] }">
        <label for="numrows">Rows Number</label>
        <input type="number" min="1" max="5" :disabled="loading['numrows']" id="numrows" :value="numrows" @change="(e) => onChange('numrows', e.target.value)">
    </div>
    <div class="setting-wrapper" :class="{ loading: loading['humandate'] }">
        <label for="humandate">Humandate</label>
        <input type="checkbox" id="humandate" :disabled="loading['humandate']" :checked="humandate" @change="(e) => onChange('humandate', e.target.checked)" >
    </div>
    <div class="setting-wrapper" :class="{ loading: loading['emails'] }">
        <label for="emails">Emails</label>
        <TextRepeater :emails="emails" @change="(emails) => onChange('emails', emails)" :isloading="loading['emails']" />
    </div>
</template>

<style scoped>

    label {
        display: inline-block;
        font-size: 16px;
        font-weight: 600;
        color: rgb(60, 67, 74);
        width: 200px;
    }

    .setting-wrapper {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        padding-top: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e4e4e4;
    }
</style>