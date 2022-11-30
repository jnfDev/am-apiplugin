<script setup>
    import { ref } from 'vue'
    import { storeToRefs } from 'pinia'
    import { useSettingStore } from '../stores/settings'

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

    <div class="error" v-if="error">
        {{ error }}
    </div>

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

    .loading {
        animation-name: loading;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-direction: alternate;
    }

    @keyframes loading {
        from { opacity: 0.6; }
        to { opacity: 0.4; }
    }

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