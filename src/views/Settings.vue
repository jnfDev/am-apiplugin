<script setup>
    import { ref } from 'vue'
    import { storeToRefs } from 'pinia'
    import { useSettingStore } from '../stores/settings'
    import { __ } from '../i18n'

    import Error from '../components/Error.vue'
    import TextRepeater from '../components/TextRepeater.vue'
    import Switch from '../components/Switch.vue'

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

    <h1>{{ __('Table Settings') }}</h1>

    <div class="setting-wrapper" :class="{ loading: loading['numrows'] }">
        <div class="label">
            <label for="numrows">{{ __('Rows Number') }}</label>
            <small>{{ __('Set the number of rows shown on the table (Table tab). The value must be a valid number between 1 and 5') }}</small>
        </div>
        <input type="number" min="1" max="5" :disabled="loading['numrows']" id="numrows" :value="numrows" @change="(e) => onChange('numrows', e.target.value)">
    </div>
    <div class="setting-wrapper" :class="{ loading: loading['humandate'] }">
        <div class="label">
            <label for="humandate">{{ __('Humandate') }}</label>
            <small>{{ __('Set the type of date shown on the table (Table tab)') }}</small>
        </div>
        
        <Switch :disabled="loading['humandate']" :value="humandate" @onChange="(value) => onChange('humandate', value)" />
    </div>
    <div class="setting-wrapper" :class="{ loading: loading['emails'] }">
        <div class="label">
            <label for="emails">{{ __('Emails') }}</label>
            <small>{{ __('Set emails listed on the Table tab. The list must be a valid list of emails, containing between 0 to 5 emails') }}</small>
        </div>
        <TextRepeater :emails="emails" @change="(emails) => onChange('emails', emails)" :isloading="loading['emails']" />
    </div>
</template>

<style scoped>

    .label {
        display: inline-block;
        font-size: 16px;
        font-weight: 600;
        color: rgb(60, 67, 74);
        width: 400px;
        margin-right: 30px;
    }

    .label label {
        display: block;
        color: rgb(60, 67, 74);
        font-size: 16px;
        font-weight: 600;
    }

    .label small {
        display: inline-block;
        color: rgb(160, 160, 160);
        margin-bottom: 30px;
    }

    .setting-wrapper {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        padding-top: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e4e4e4;
        flex-wrap: wrap;
    }

    .setting-wrapper label {
        margin-bottom: 15px;
    }
</style>