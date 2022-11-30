import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useDataStore = defineStore('data',() => {
    const _table = ref({})
    const _graph = ref({})

    /** Getters */

    const table = computed(() => _table.value)
    const graph = computed(() => _graph.value)

    /** Actions */

    const loadData = async (refresh = false) => {
        const { ajaxUrl, nonce, actions: { getAPIData: action } } = AmAdminVars
        const body = new FormData();
    
        body.append('action', action)
        body.append('wpnonce', nonce)
        body.append('refresh', refresh)

        const response = await ( await fetch( ajaxUrl, { body, method: 'POST' } )).json()

        if (true !== response?.success) {
            const { error_message } = response.data
            throw new Error(error_message)
        }

        const { table, graph } = JSON.parse(response.data)
        const { title, data: { headers, rows } } = table
        
        _table.value = { title, headers, rows }
        _graph.value = graph
    }

    return { table, graph, loadData }
})