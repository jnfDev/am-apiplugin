import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useSettingStore = defineStore('settings', () => {
    const settings = ref({})

    /** Getters  */
    
    const numrows = computed(() => settings.value?.numrows)
    const emails = computed(()=> settings.value?.emails)
    const humandate = computed(() =>  settings.value?.humandate)

    /** Actions */

    /**
     * @throw Error
     * @return {void|Promise}
     */
    const init = async () => {
        const { ajaxUrl, nonce, actions: { getSettings: action } } = AmAdminVars
        const body = new FormData();
    
        body.append('action', action)
        body.append('wpnonce', nonce)

        const response = await ( await fetch( ajaxUrl, { body, method: 'POST' } )).json()
    
        if (true !== response?.success) {
            const { error_message } = response.data
            throw new Error(error_message)
        }
    
        settings.value = response.data
    }

    /**
     * @throw Error
     * @return {void|Promise} 
     */
    const update = async (name, value) => {
        const fallbackValue = settings.value[name]

        settings.value[name] = value

        const { ajaxUrl, nonce, actions: { updateSetting: action } } = AmAdminVars
        const body = new FormData();
    
        body.append('action', action)
        body.append('wpnonce', nonce)
        body.append('name', name)
        body.append('value', value);

        const response = await ( await fetch( ajaxUrl, { body, method: 'POST' } )).json()

        if (true !== response?.success) {
            const { error_message } = response.data

            // Set back the previos
            // valid value and throw error.
            settings.value[name] = fallbackValue
            throw new Error(error_message)
        }
    }

    return { numrows, emails, humandate, init, update }
});