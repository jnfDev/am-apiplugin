import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useSettingStore = defineStore('settings', () => {
    const settings = ref({})

    /** Getters  */
    
    const numrows = computed(() => settings.value?.numrows)
    const emails = computed(()=> settings.value?.emails)
    const humandate = computed(() => { settings.value?.humandate })

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

    
        const response = await fetch( ajaxUrl, { body, method: 'POST' } )
        const rawData = await response.json();
    
        if (true !== rawData?.success) {
            throw new Error('AJAX Request Failed')
        }
    
        settings.value = rawData.data
    }

    /**
     * @throw Error
     * @return {void|Promise} 
     */
    const update = async (name, value) => {
        // Work in progress..
    }

    return { numrows, emails, humandate, init, update }
});